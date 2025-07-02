<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pembeli extends Model
{
    //
    protected $table = 'pembelis';
    protected $fillable = [
        'nama_pembeli',
        'nik_pembeli',
        'tgl_lahir_pembeli',
        'tempat_lahir_pembeli',
        'alamat_pembeli',
        'no_telepon_pembeli', // 'no_telp_pembeli'
        // 'no_telp'
    ];

    public function pengajuanAjb() {
        return $this->hasOne(pengajuan_ajb::class, 'id_pembeli');
    }
}
