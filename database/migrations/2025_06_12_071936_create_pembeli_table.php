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
        Schema::create('pembelis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pembeli');
            $table->char('nik_pembeli', 16);
            $table->date('tgl_lahir_pembeli');
            $table->string('tempat_lahir_pembeli');
            $table->string('alamat_pembeli');
            $table->string('no_telepon_pembeli')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_pembeli');
    }
};
