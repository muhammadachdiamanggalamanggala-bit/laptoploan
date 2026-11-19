<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $loanColumns = Schema::getColumnListing('peminjaman');
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->enum('status', ['menunggu', 'dipinjam', 'dikembalikan', 'ditolak'])->default('menunggu')->change();
            if (! Schema::hasColumn('peminjaman', 'alasan_penolakan')) {
                $table->text('alasan_penolakan')->nullable();
            }
        });

        if (! Schema::hasTable('laporan_masalah')) {
            Schema::create('laporan_masalah', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->string('judul');
                $table->string('kategori');
                $table->text('deskripsi');
                $table->string('foto')->nullable();
                $table->string('prioritas')->default('Normal');
                $table->string('status')->default('Baru');
                $table->text('respon_admin')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('type');
                $table->morphs('notifiable');
                $table->text('data');
                $table->timestamp('read_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('laporan_masalah');

        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn('alasan_penolakan');
            $table->enum('status', ['menunggu', 'dipinjam', 'dikembalikan'])->default('menunggu')->change();
        });
    }
};