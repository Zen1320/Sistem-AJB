<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class objek_tanah extends Model
{
    //
    protected $table = 'objek_tanah';
    protected $fillable = [
        'nomor_hak_bangun',
        'nomor_surat_ukur',
        'nomor_nib',
        'pengesahan_nib_oleh',
        'nomor_spp',
        'provinsi',
        'kota',
        'kecamatan',
        'kelurahan',
        'jalan',
        'alamat_lengkap',
    ];

    public function pengajuanAjb() {
        return $this->hasOne(pengajuan_ajb::class, 'id_objek_tanah');
    }
}
