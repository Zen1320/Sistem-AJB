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
        Schema::create('berkas_ajb', function (Blueprint $table) {
            $table->id();
            $table->string('file_ktp_penjual')->nullable();
            $table->string('file_ktp_istri_penjual')->nullable();
            $table->string('file_kk_penjual')->nullable();
            $table->string('file_ktp_pembeli')->nullable();
            $table->string('file_kk_pembeli')->nullable();
            $table->string('file_akta_nikah')->nullable();

            $table->string('file_sertifikat')->nullable();
            $table->string('file_bukti_pbb')->nullable();
            $table->string('file_imb')->nullable();
            $table->string('file_persetujuan')->nullable();
            $table->string('file_dokumen_lainnya')->nullable();
            $table->string('file_akta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_berkas__ajb');
    }
};
