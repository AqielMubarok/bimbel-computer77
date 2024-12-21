<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */ 
    public function up()
    {
        Schema::table('nilais', function (Blueprint $table) {
            $table->renameColumn('kehadiran', 'nilai_tugas'); // Ganti nama kolom
            $table->renameColumn('kompetensi', 'nilai_ujian'); // Ganti nama kolom
            $table->renameColumn('skill', 'predikat'); // Ganti nama kolom
            $table->renameColumn('status', 'kompetensi_unggulan'); // Ganti nama kolom
        });
    }

    public function down()
    {
        Schema::table('nilais', function (Blueprint $table) {
            $table->renameColumn('nilai_tugas', 'kehadiran');
            $table->renameColumn('nilai_ujian', 'kompetensi');
            $table->renameColumn('predikat', 'skill');
            $table->renameColumn('kompetensi_unggulan', 'status');
        });
    }

};
