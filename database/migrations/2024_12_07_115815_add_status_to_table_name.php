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
            // Gunakan method ->columnExists() untuk mengecek terlebih dahulu
            if (!Schema::hasColumn('nilais', 'status')) {
                $table->string('status')->nullable(); // Atau sesuaikan dengan kebutuhan
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nilais', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
