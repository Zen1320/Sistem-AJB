<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class berkas_ajb extends Model
{
    protected $table = 'berkas_ajb';
    protected $fillable = [
        'file_ktp_penjual',
        'file_ktp_istri_penjual',
        'file_kk_penjual',
        'file_ktp_pembeli',
        'file_kk_pembeli',
        'file_akta_nikah',
        
        'file_sertifikat',
        'file_bukti_pbb',
        'file_imb',
        'file_persetujuan',
        'file_dokumen_lainnya',
        'file_akta'
    ];

    public function pengajuanAjb() {
        return $this->hasOne(pengajuan_ajb::class, 'id_berkas');
    }
}
