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
    Schema::table('kumpul_tugas', function (Blueprint $table) {
        $table->string('judul_tugas')->after('name')->nullable();
    });
}

public function down()
{
    Schema::table('kumpul_tugas', function (Blueprint $table) {
        $table->dropColumn('judul_tugas');
    });
}

};
