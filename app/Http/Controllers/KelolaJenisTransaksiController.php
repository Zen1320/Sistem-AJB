<?php

namespace App\Http\Controllers;

use App\Models\jenis_pengajuan;
use Illuminate\Http\Request;

class KelolaJenisTransaksiController extends Controller
{
    //
    public function index()
    {
        $title = 'Hapus Jenis Transaksi';
        $text = "Apakah Anda yakin ingin menghapus ini? *semua data yang berhubungan dengan Jenis Transaksi ini akan dihapus juga*";
        confirmDelete($title, $text);
        $jenis = jenis_pengajuan::all();
        return view('admin.Kelola_JenisTransaksi.index', compact('jenis'));
    }

    public function edit($id)
    {
        $jenis = jenis_pengajuan::findOrFail($id);
        return response()->json($jenis);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required',

        ]);
        jenis_pengajuan::create([
            'nama_jenis' => $request->nama,

        ]);
        return redirect()->back()->with('success', 'Data Jenis Transaksi berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'nama' => 'required',

        ]);

        $jenis = jenis_pengajuan::findOrFail($id);
        $jenis->update([
            'nama_jenis' => $request->nama,
        ]);
        return redirect()->back()->with('success', 'Jenis Transaksi berhasil diubah');
    }
    public function destroy($id)
    {
        $Jenis = jenis_pengajuan::findOrFail($id);
        $Jenis->delete();
        return redirect()->back()->with('success', 'Jenis Transaksi berhasil dihapus');
    }
}
