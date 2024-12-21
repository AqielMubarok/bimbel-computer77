<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kumpul_tugas', function (Blueprint $table) {
            // Menghapus kolom 'jenis_paket'
            $table->dropColumn('jenis_paket');
        });
    }

    public function down()
    {
        Schema::table('kumpul_tugas', function (Blueprint $table) {
            // Menambahkan kembali kolom 'jenis_paket' jika rollback
            $table->string('jenis_paket')->nullable();
        });
    }
};
