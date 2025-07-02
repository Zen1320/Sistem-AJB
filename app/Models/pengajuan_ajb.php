<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pengajuan_ajb extends Model
{
    //
    protected $table = 'pengajuan_ajb';

    protected $fillable =[
    'id_user', 'id_penjual', 'id_pembeli', 'id_saksi',
    'id_jenis', 'id_objek_tanah', 'id_berkas','kode_pengajuan',
    'harga_transaksi_tanah', 'tanggal_pengajuan', 'status', 'keterangan','file_Akta'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function penjual() {
        return $this->belongsTo(penjual::class, 'id_penjual');
    }

    public function pembeli() {
        return $this->belongsTo(pembeli::class, 'id_pembeli');
    }

    public function saksi() {
        return $this->belongsTo(saksi::class, 'id_saksi');
    }

    public function jenis() {
        return $this->belongsTo(jenis_pengajuan::class, 'id_jenis');
    }

    public function objekTanah() {
        return $this->belongsTo(objek_tanah::class, 'id_objek_tanah');
    }

    public function berkas() {
        return $this->belongsTo(berkas_ajb::class, 'id_berkas');
    }
}
