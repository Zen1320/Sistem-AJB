<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class jenis_pengajuan extends Model
{
    //
    protected $table = 'jenis_transaksis';
    protected $fillable = [
        'nama_jenis',
    ];

    public function pengajuanAjb() {
        return $this->hasOne(pengajuan_ajb::class, 'id_jenis');
    }
}
