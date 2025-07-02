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
        Schema::create('objek_tanah', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_hak_bangun');
            $table->string('nomor_surat_ukur');
            $table->string('nomor_nib');
            $table->string('pengesahan_nib_oleh');
            $table->string('nomor_spp');
            $table->string('provinsi');
            $table->string('kota');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('jalan');
            $table->string('alamat_lengkap');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_objek_tanah');
    }
};
