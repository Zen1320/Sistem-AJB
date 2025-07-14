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
        Schema::create('pengajuan_ajb', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_penjual')->constrained('penjuals')->onDelete('cascade');
            $table->foreignId('id_pembeli')->constrained('pembelis')->onDelete('cascade');
            $table->foreignId('id_saksi')->nullable()->constrained('saksis')->onDelete('cascade');
            $table->foreignId('id_objek_tanah')->constrained('objek_tanah')->onDelete('cascade');
            $table->foreignId('id_berkas')->constrained('berkas_ajb')->onDelete('cascade');
            $table->foreignId('id_jenis')->constrained('jenis_transaksis')->onDelete('cascade');
            $table->string('kode_pengajuan')->unique();
            $table->decimal('harga_transaksi_tanah', 15, 2);
            $table->date('tanggal_pengajuan');
            $table->integer('status')->default(0);
            $table->string('keterangan')->nullable();
            $table->string('file_Akta')->nullable();
            $table->timestamp('tanggal_akad')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_ajb');
    }
};
