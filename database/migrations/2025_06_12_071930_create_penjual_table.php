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
        Schema::create('penjuals', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penjual');
            $table->char('nik_penjual', 16);
            $table->date('tgl_lahir_penjual');
            $table->string('tempat_lahir_penjual');
            $table->string('no_telepon_penjual')->nullable();
            $table->string('nama_istri_penjual')->nullable();
            $table->char('nik_istri_penjual', 16)->nullable();
            $table->date('tgl_lahir_istri_penjual')->nullable();
            $table->string('tempat_lahir_istri_penjual')->nullable();
            $table->string('no_telepon_istri_penjual')->nullable();
            $table->string('alamat_penjual');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_penjual');
    }
};
