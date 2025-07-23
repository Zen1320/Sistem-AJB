<?php

namespace App\Http\Controllers;

use App\Models\pengajuan_ajb;
use Illuminate\Http\Request;

class Kelola_LaporanController extends Controller
{
    //
    public function index(Request $request){
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;

        $query = pengajuan_ajb::with([
            'user',
            'penjual',
            'pembeli',
            'saksi',
            'jenis',
            'objekTanah',
        ]);

        if ($tgl_awal && $tgl_akhir) {
            $query->whereBetween('created_at', [
                date('Y-m-d 00:00:00', strtotime($tgl_awal)),
                date('Y-m-d 23:59:59', strtotime($tgl_akhir))
            ]);
        }

        $data = $query->get();

        return view('admin.Laporan.index',compact('data'));
    }
}
