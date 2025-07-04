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
       Schema::create('surat_masuk', function (Blueprint $table) {
        $table->id('id_surat_masuk');
        $table->string('no_surat_keluar')->unique();
        $table->date('tanggal_masuk');
        $table->string('pengirim');
        $table->string('file');
        $table->foreignId('jenis_surat_id')->constrained('jenis_surat')->onDelete('cascade');
        // Tidak pakai timestamps karena kamu bilang tidak ada created_at dan updated_at
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};
