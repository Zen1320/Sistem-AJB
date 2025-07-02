<?php

namespace App\Http\Controllers;

use App\Models\saksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class Kelola_AnggotaController extends Controller
{
    //
    public function index(){
        $title = 'Hapus Pengguna';
        $text = "Apakah Anda yakin ingin menghapus ini? *semua data yang berhubungan dengan Pengaduan dan Aktifitas Didalamnnya ini akan dihapus juga*";
        confirmDelete($title, $text);
        $anggotaSaksi = saksi::all();
        return view('admin.Kelola_anggota.index',compact('anggotaSaksi'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_saksi' => 'required|string|max:255',
            'nik_saksi' => 'required|digits:16',
            'tgl_lahir_saksi' => 'required|date',
            'tempat_lahir_saksi' => 'required|string|max:100',
            'alamat_saksi' => 'required|string',
            'no_telepon_saksi' => 'required|string|max:20',
            'NIP' => 'required|string|max:50',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = 'saksi_' . time() . '_' . Str::random(6) . '.' . $foto->getClientOriginalExtension();
            $validated['foto'] = $foto->storeAs('foto_saksi', $filename, 'public');
        }

        saksi::create($validated);

        return redirect()->back()->with('success', 'Anggota saksi berhasil ditambahkan.');
    }

    public function edit($id){
        $saksi = saksi::find($id)->first();
        return response()->json($saksi);
    }

    public function update(Request $request, $id)
    {
        $anggota = saksi::findOrFail($id);

        $validated = $request->validate([
            'nama_saksi' => 'required|string|max:255',
            'nik_saksi' => 'required|digits:16',
            'tgl_lahir_saksi' => 'required|date',
            'tempat_lahir_saksi' => 'required|string|max:100',
            'alamat_saksi' => 'required|string',
            'no_telepon_saksi' => 'required|string|max:20',
            'NIP' => 'required|string|max:50',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Cek apakah ada file foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($anggota->foto) {
                Storage::disk('public')->delete($anggota->foto);
            }

            $foto = $request->file('foto');
            $filename = 'saksi_' . time() . '_' . Str::random(6) . '.' . $foto->getClientOriginalExtension();
            $validated['foto'] = $foto->storeAs('foto_saksi', $filename, 'public');
        }

        $anggota->update($validated);

        return redirect()->back()->with('success', 'Data anggota saksi berhasil diperbarui.');
    }

    // Destroy (menghapus data anggota)
    public function destroy($id)
    {
        $anggota = saksi::findOrFail($id);

        // Hapus foto jika ada
        if ($anggota->foto) {
            Storage::disk('public')->delete($anggota->foto);
        }

        $anggota->delete();

        return redirect()->back()->with('success', 'Data anggota saksi berhasil dihapus.');
    }
}
