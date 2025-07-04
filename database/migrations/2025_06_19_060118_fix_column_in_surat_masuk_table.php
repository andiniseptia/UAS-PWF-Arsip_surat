<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->dropColumn('no_surat_keluar');
            $table->string('no_surat_masuk')->after('id_surat_masuk');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->dropColumn('no_surat_masuk');
            $table->string('no_surat_keluar');
        });
    }
};
