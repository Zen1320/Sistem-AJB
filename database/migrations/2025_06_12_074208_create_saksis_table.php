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
        Schema::create('saksis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_saksi');
            $table->char('nik_saksi', 16);
            $table->date('tgl_lahir_saksi');
            $table->string('tempat_lahir_saksi');
            $table->string('alamat_saksi');
            $table->char('no_telepon_saksi',20);
            $table->string('foto')->nullable();
            $table->string('NIP');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saksis');
    }
};
