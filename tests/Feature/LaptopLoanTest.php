<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\LaporanMasalah;
use App\Models\Peminjaman;
use App\Models\User;
use Database\Seeders\AdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LaptopLoanTest extends TestCase
{
    use RefreshDatabase;

    public function test_borrower_can_request_a_catalog_laptop_and_admin_approval_updates_stock(): void
    {
        $borrower = User::factory()->create(['role' => 'user']);
        $admin = User::factory()->create(['role' => 'admin']);
        $this->assertTrue($borrower->fresh()->is_active);
        $this->actingAs($borrower)->get(route('dashboard'))->assertOk();
        $laptop = Barang::create([
            'nama_barang' => 'ASUS VivoBook 14',
            'kode_barang' => 'LP-001',
            'merk' => 'ASUS',
            'model' => 'VivoBook 14',
            'stok' => 2,
            'jumlah' => 2,
            'kondisi' => 'Baik',
        ]);

        $this->actingAs($borrower)->post(route('katalog.pinjam', $laptop), [
            'jumlah' => 1,
            'peminjaman_pada' => now()->addDay()->setTime(9, 0)->format('Y-m-d\TH:i'),
            'waktu_kembali_rencana' => '16:00',
            'guru_produktif' => 'Pa Wanda',
            'mata_pelajaran' => 'Produktif AI',
            'keperluan' => 'Praktik kelas',
            'includes_charger' => '1',
        ])->assertRedirect(route('peminjaman.saya'));

        $loan = Peminjaman::firstOrFail();
        $this->assertSame('menunggu', $loan->status);
        $this->assertSame(2, $laptop->fresh()->jumlah);
        $this->assertTrue($loan->includes_charger);
        $this->assertSame('Pa Wanda', $loan->guru_produktif);
        $this->assertSame('Produktif AI', $loan->mata_pelajaran);
        $this->assertSame('16:00', $loan->waktu_kembali_rencana);
        $this->assertSame($loan->peminjaman_pada->toDateString(), $loan->tanggal_kembali_rencana->toDateString());
        $notification = $admin->notifications()->firstOrFail();
        $this->assertStringContainsString($borrower->name, $notification->data['message']);
        $this->assertSame(route('peminjaman.index', [], false), $notification->data['url']);
        $this->actingAs($admin)->get(route('dashboard'))
            ->assertOk()
            ->assertSee($notification->data['message'])
            ->assertSee(route('peminjaman.index', [], false), false);

        $this->actingAs($admin)->get(route('notifications.show', $notification->id))
            ->assertRedirect(route('peminjaman.index'));
        $this->assertNotNull($notification->fresh()->read_at);
        $this->actingAs($admin)->get(route('dashboard'))
            ->assertOk()
            ->assertDontSee($notification->data['message']);

        $this->actingAs($admin)->patch(route('peminjaman.approve', $loan))->assertSessionHas('success');
        $this->assertSame(1, $laptop->fresh()->jumlah);
        $this->assertSame('dipinjam', $loan->fresh()->status);

        $this->patch(route('peminjaman.kembalikan', $loan), [
            'kondisi_kembali' => 'Baik',
            'catatan_kerusakan' => '',
        ])->assertSessionHas('success');
        $this->assertSame(2, $laptop->fresh()->jumlah);
        $this->assertSame('dikembalikan', $loan->fresh()->status);
    }

    public function test_borrowing_request_is_not_saved_without_an_active_admin(): void
    {
        $borrower = User::factory()->create(['role' => 'user']);
        $laptop = Barang::create([
            'nama_barang' => 'Laptop Tanpa Admin',
            'kode_barang' => 'LP-005',
            'stok' => 1,
            'jumlah' => 1,
            'kondisi' => 'Baik',
        ]);

        $this->actingAs($borrower)->post(route('katalog.pinjam', $laptop), [
            'jumlah' => 1,
            'peminjaman_pada' => now()->addDay()->setTime(9, 0)->format('Y-m-d\TH:i'),
            'waktu_kembali_rencana' => '16:00',
            'guru_produktif' => 'Pa Wanda',
            'mata_pelajaran' => 'Produktif AI',
            'keperluan' => 'Praktik kelas',
        ])->assertSessionHasErrors('admin');

        $this->assertDatabaseCount('peminjaman', 0);
    }

    public function test_catalog_loan_requires_a_valid_same_day_schedule_and_configured_selections(): void
    {
        $borrower = User::factory()->create(['role' => 'user']);
        User::factory()->create(['role' => 'admin']);
        $laptop = Barang::create([
            'nama_barang' => 'Laptop Praktik',
            'kode_barang' => 'LP-006',
            'stok' => 1,
            'jumlah' => 1,
            'kondisi' => 'Baik',
        ]);
        $schedule = [
            'jumlah' => 1,
            'peminjaman_pada' => now()->addDay()->setTime(10, 0)->format('Y-m-d\TH:i'),
            'guru_produktif' => 'Pa Wanda',
            'mata_pelajaran' => 'Produktif AI',
            'keperluan' => 'Praktik kelas',
        ];

        $this->actingAs($borrower)->post(route('katalog.pinjam', $laptop), $schedule + [
            'waktu_kembali_rencana' => '09:00',
        ])->assertSessionHasErrors('waktu_kembali_rencana');

        $this->post(route('katalog.pinjam', $laptop), array_merge($schedule, [
            'waktu_kembali_rencana' => '16:00',
            'guru_produktif' => 'Guru tidak terdaftar',
        ]))->assertSessionHasErrors('guru_produktif');

        $this->assertDatabaseCount('peminjaman', 0);
    }

    public function test_user_cannot_read_another_users_notification(): void
    {
        $owner = User::factory()->create(['role' => 'admin']);
        $otherUser = User::factory()->create(['role' => 'admin']);
        $owner->notify(new \App\Notifications\LoanStatusChanged(
            'Pengajuan menunggu persetujuan.',
            route('peminjaman.index', [], false)
        ));
        $notificationId = $owner->notifications()->firstOrFail()->id;

        $this->actingAs($otherUser)
            ->get(route('notifications.show', $notificationId))
            ->assertNotFound();

        $this->assertNull($owner->notifications()->firstOrFail()->read_at);
    }

    public function test_borrower_cannot_open_admin_inventory_and_insufficient_stock_is_not_approved(): void
    {
        $borrower = User::factory()->create(['role' => 'user']);
        $admin = User::factory()->create(['role' => 'admin']);
        $laptop = Barang::create([
            'nama_barang' => 'Laptop Sekolah',
            'kode_barang' => 'LP-002',
            'stok' => 1,
            'jumlah' => 1,
            'kondisi' => 'Baik',
        ]);
        $loan = Peminjaman::create([
            'user_id' => $borrower->id,
            'barang_id' => $laptop->id,
            'jumlah' => 2,
            'tanggal_pinjam' => now()->toDateString(),
            'tanggal_kembali_rencana' => now()->addDays(2)->toDateString(),
            'status' => 'menunggu',
        ]);

        $this->actingAs($borrower)->get(route('barang.index'))->assertForbidden();
        $this->actingAs($admin)->patch(route('peminjaman.approve', $loan))->assertSessionHas('error');
        $this->assertSame(1, $laptop->fresh()->jumlah);
        $this->assertSame('menunggu', $loan->fresh()->status);
    }

    public function test_registration_creates_a_non_admin_account(): void
    {
        $this->post(route('register.submit'), [
            'name' => 'Peminjam Baru',
            'email' => 'peminjam@example.test',
            'password' => 'sekolah12345',
            'password_confirmation' => 'sekolah12345',
        ])->assertRedirect(route('login'));

        $this->assertDatabaseHas('users', ['email' => 'peminjam@example.test', 'role' => 'user']);
    }

    public function test_login_and_registration_pages_remain_open_and_registration_can_log_in_to_dashboard(): void
    {
        $existingUser = User::factory()->create(['name' => 'Pengguna Lama']);

        $this->actingAs($existingUser)
            ->get(route('login'))
            ->assertOk()
            ->assertSee('Selamat datang');

        $this->get(route('register'))
            ->assertOk()
            ->assertSee('Daftar Akun');

        $this->post(route('register.submit'), [
            'name' => 'Pengguna Baru',
            'email' => 'pengguna.baru@example.test',
            'password' => 'password-baru',
            'password_confirmation' => 'password-baru',
        ])->assertRedirect(route('login'));

        $newUser = User::where('email', 'pengguna.baru@example.test')->firstOrFail();
        $this->assertSame('user', $newUser->role);

        $this->post(route('login.submit'), [
            'email' => 'pengguna.baru@example.test',
            'password' => 'password-baru',
        ])->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($newUser);
    }

    public function test_admin_seeder_preserves_existing_password_when_rerun(): void
    {
        config()->set('app.admin.email', 'configured-admin@example.test');
        $seeder = new AdminSeeder();
        $seeder->run();

        $admin = User::where('email', 'configured-admin@example.test')->firstOrFail();
        $admin->update(['password' => 'a-user-chosen-password']);

        $seeder->run();

        $admin = $admin->fresh();
        $this->assertSame('admin', $admin->role);
        $this->assertTrue($admin->is_active);
        $this->assertTrue(Hash::check('a-user-chosen-password', $admin->password));
        $this->assertSame(1, User::where('email', $admin->email)->count());
    }

    public function test_borrower_can_open_empty_reports_page(): void
    {
        $borrower = User::factory()->create(['role' => 'user']);

        $this->actingAs($borrower)
            ->get(route('laporan.index'))
            ->assertOk()
            ->assertSee('Belum ada laporan');
    }

    public function test_guest_can_browse_catalog_and_laptop_details(): void
    {
        $laptop = Barang::create([
            'nama_barang' => 'Laptop Katalog',
            'kode_barang' => 'LP-004',
            'stok' => 1,
            'jumlah' => 1,
            'kondisi' => 'Baik',
        ]);

        $this->get(route('katalog'))
            ->assertOk()
            ->assertSee('Katalog Laptop')
            ->assertSee(route('katalog'), false)
            ->assertSee('Login');

        $this->get(route('katalog.show', $laptop))
            ->assertOk()
            ->assertSee($laptop->nama_barang);
    }

    public function test_admin_can_open_reports_page_with_private_attachment_link(): void
    {
        $reporter = User::factory()->create(['role' => 'user']);
        $admin = User::factory()->create(['role' => 'admin']);
        $report = LaporanMasalah::create([
            'user_id' => $reporter->id,
            'judul' => 'Laptop tidak menyala',
            'kategori' => 'Laptop Bermasalah',
            'deskripsi' => 'Laptop tidak menyala saat tombol ditekan.',
            'foto' => 'laporan/lampiran.jpg',
            'prioritas' => 'Normal',
        ]);

        $this->actingAs($admin)
            ->get(route('laporan.index'))
            ->assertOk()
            ->assertSee($report->judul)
            ->assertSee(route('laporan.file', $report), false)
            ->assertSee($reporter->name);
    }

    public function test_disabled_user_is_logged_out_and_cannot_read_another_users_history(): void
    {
        $owner = User::factory()->create(['role' => 'user']);
        $other = User::factory()->create(['role' => 'user']);
        $laptop = Barang::create([
            'nama_barang' => 'ASUS VivoBook',
            'kode_barang' => 'LP-003',
            'stok' => 1,
            'jumlah' => 1,
            'kondisi' => 'Baik',
        ]);
        Peminjaman::create([
            'user_id' => $other->id,
            'barang_id' => $laptop->id,
            'jumlah' => 1,
            'tanggal_pinjam' => now()->subDays(3)->toDateString(),
            'tanggal_kembali_rencana' => now()->subDays(1)->toDateString(),
            'status' => 'dikembalikan',
        ]);

        $this->actingAs($owner)->get(route('riwayat', ['cari' => 'ASUS']))
            ->assertOk()->assertDontSee('ASUS VivoBook');

        $owner->update(['is_active' => false]);
        $this->actingAs($owner)->get(route('dashboard'))->assertRedirect(route('login'));
    }

    public function test_loan_history_displays_fallback_for_missing_student(): void
    {
        $borrower = User::factory()->create(['role' => 'user']);
        $laptop = Barang::create([
            'nama_barang' => 'Laptop Riwayat',
            'kode_barang' => 'LP-004',
            'stok' => 1,
            'jumlah' => 1,
            'kondisi' => 'Baik',
        ]);
        Peminjaman::create([
            'user_id' => $borrower->id,
            'barang_id' => $laptop->id,
            'jumlah' => 1,
            'tanggal_pinjam' => now()->subDays(3)->toDateString(),
            'tanggal_kembali_rencana' => now()->subDays(1)->toDateString(),
            'status' => 'dikembalikan',
        ]);

        $this->actingAs($borrower)->get(route('riwayat'))
            ->assertOk()
            ->assertSee('Data Siswa Hilang')
            ->assertSee('Laptop Riwayat');
    }
}
