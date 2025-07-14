<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class penjual extends Model
{
    //
    protected $table = 'penjuals';
    protected $fillable = [
        'nama_penjual',
        'nik_penjual',
        'tgl_lahir_penjual',
        'tempat_lahir_penjual',
        'pekerjaan_penjual',
        

        'nama_istri_penjual',
        'nik_istri_penjual',
        'tgl_lahir_istri_penjual',
        'tempat_lahir_istri_penjual',
        'pekerjaan_penjual_istri',

        'alamat_penjual',
        'no_telepon_penjual', // 'no_telp_penjual'
        'no_telepon_istri_penjual' // 'no_telp_istri_penjual'
        // 'no_telp'
    ];

    public function pengajuanAjb() {
        return $this->hasOne(pengajuan_ajb::class, 'id_penjual');
    }
}
