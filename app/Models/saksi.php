<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class saksi extends Model
{
    //
    protected $table = 'saksis';
    protected $fillable = [
        'nama_saksi',
        'nik_saksi',
        'tgl_lahir_saksi',
        'tempat_lahir_saksi',
        'alamat_saksi',
        'no_telepon_saksi',
        'nip',
        'foto'
    ];

    public function pengajuanAjb() {
        return $this->hasOne(pengajuan_ajb::class, 'id_saksi');
    }

}
