<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $barangColumns = Schema::getColumnListing('barangs');
        $shouldCopyStockToQuantity = ! in_array('jumlah', $barangColumns, true);

        Schema::table('barangs', function (Blueprint $table) use ($barangColumns) {
            if (! in_array('jumlah', $barangColumns, true)) {
                $table->integer('jumlah')->default(0);
            }
            if (! in_array('merk', $barangColumns, true)) {
                $table->string('merk')->nullable();
            }
            if (! in_array('model', $barangColumns, true)) {
                $table->string('model')->nullable();
            }
            if (! in_array('nomor_seri', $barangColumns, true)) {
                $table->string('nomor_seri')->nullable();
            }
            if (! in_array('foto', $barangColumns, true)) {
                $table->string('foto')->nullable();
            }
            if (! in_array('kondisi', $barangColumns, true)) {
                $table->string('kondisi')->default('Baik');
            }
            if (! in_array('keterangan', $barangColumns, true)) {
                $table->text('keterangan')->nullable();
            }
        });

        if ($shouldCopyStockToQuantity) {
            DB::table('barangs')->orderBy('id')->chunkById(100, function ($barangs) {
                foreach ($barangs as $barang) {
                    DB::table('barangs')->where('id', $barang->id)->update([
                        'jumlah' => $barang->stok,
                    ]);
                }
            });
        }

        $userColumns = Schema::getColumnListing('users');
        Schema::table('users', function (Blueprint $table) use ($userColumns) {
            if (! in_array('role', $userColumns, true)) {
                $table->string('role')->default('user');
            }
            if (! in_array('is_active', $userColumns, true)) {
                $table->boolean('is_active')->default(true);
            }
        });

        $loanColumns = Schema::getColumnListing('peminjaman');
        Schema::table('peminjaman', function (Blueprint $table) use ($loanColumns) {
            if (! in_array('user_id', $loanColumns, true)) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            }
            if (! in_array('includes_charger', $loanColumns, true)) {
                $table->boolean('includes_charger')->default(false);
            }
            if (! in_array('catatan', $loanColumns, true)) {
                $table->text('catatan')->nullable();
            }
            if (! in_array('kondisi_kembali', $loanColumns, true)) {
                $table->string('kondisi_kembali')->nullable();
            }
            if (! in_array('catatan_kerusakan', $loanColumns, true)) {
                $table->text('catatan_kerusakan')->nullable();
            }
        });

        if (in_array('siswa_id', $loanColumns, true)) {
            Schema::table('peminjaman', function (Blueprint $table) {
                $table->foreignId('siswa_id')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn(['includes_charger', 'catatan', 'kondisi_kembali', 'catatan_kerusakan']);
            $table->foreignId('siswa_id')->nullable(false)->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'is_active']);
        });

        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn(['jumlah', 'merk', 'model', 'nomor_seri', 'foto', 'kondisi', 'keterangan']);
        });
    }
};