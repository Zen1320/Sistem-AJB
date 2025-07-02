<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Kelola_PenggunaController extends Controller
{
    //

    public function index()
    {
        $title = 'Hapus Pengguna';
        $text = "Apakah Anda yakin ingin menghapus ini? *semua data yang berhubungan dengan Pengaduan dan Aktifitas Didalamnnya ini akan dihapus juga*";
        confirmDelete($title, $text);
        $pengguna = User::whereIn('role', [0, 1])->get();
        return view('admin.Kelola_Pengguna.index', compact('pengguna'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'nomor_tlp' => 'required|numeric',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
            'role' => 'required'
        ]);
        $pengguna = User::create([
            'name' => $request->nama,
            'alamat' => $request->alamat,
            'no_telp' => $request->nomor_tlp,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        try {
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('foto_profile', $filename, 'public');
                User::where('id', $pengguna->id)->update(['foto' => $path]);
            }

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengupload foto');
        }

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'nomor_tlp' => 'required|numeric',
            'email' => 'required|email',
            'password' => 'nullable',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
            'role' => 'required'
        ]);

        $pengguna = User::find($id);
        $pengguna->name = $request->nama;
        $pengguna->alamat = $request->alamat;
        $pengguna->no_telp = $request->nomor_tlp;
        $pengguna->email = $request->email;
        $pengguna->role = $request->role;

        if ($request->password) {
            $pengguna->password = bcrypt($request->password);
        }

        if ($request->hasFile('foto')) {

            if ($pengguna->foto && Storage::disk('public')->exists($pengguna->foto)) {
                Storage::disk('public')->delete($pengguna->foto);
            }
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('foto_profile', $filename, 'public');
            $pengguna->foto = $path;
        }

        try {
            if ($pengguna->save()) {
                return redirect()->back()->with('success', 'Data berhasil diupdate');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupdate data');
        }
    }


    public function destroy(Request $request)
    {
        $pengguna = User::find($request->id);
        if (!$pengguna) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
        if ($pengguna->foto && Storage::disk('public')->exists($pengguna->foto)) {
            Storage::disk('public')->delete($pengguna->foto);
        }
        try {
            if ($pengguna->delete()) {
                return redirect()->back()->with('success', 'Data berhasil dihapus');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data');
        }
    }
}
