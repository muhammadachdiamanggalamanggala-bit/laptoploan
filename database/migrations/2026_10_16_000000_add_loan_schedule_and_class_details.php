<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dateTime('peminjaman_pada')->nullable();
            $table->time('waktu_kembali_rencana')->nullable();
            $table->string('guru_produktif')->nullable();
            $table->string('mata_pelajaran')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn([
                'peminjaman_pada',
                'waktu_kembali_rencana',
                'guru_produktif',
                'mata_pelajaran',
            ]);
        });
    }
};
