<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KumpulTugas extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('kumpul_tugas')) {
            Schema::create('kumpul_tugas', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('judul_tugas'); 
                $table->string('jenis_paket');
                $table->string('kelas');
                $table->string('file')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('kumpul_tugas');
    }
}
