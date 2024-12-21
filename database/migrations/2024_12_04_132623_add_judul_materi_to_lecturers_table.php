<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJudulMateriToLecturersTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('lecturers', 'judul_materi')) {
            Schema::table('lecturers', function (Blueprint $table) {
                $table->string('judul_materi');
            });
        }
    }

    public function down()
    {
        Schema::table('lecturers', function (Blueprint $table) {
            $table->dropColumn('judul_materi');
        });
    }
}
