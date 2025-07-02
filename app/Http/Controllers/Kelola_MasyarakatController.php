<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class Kelola_MasyarakatController extends Controller
{
    //
    public function index()
    {
        $pengguna = User::whereIn('role', [2])->get();
        return view('admin.kelola_masyarakat.index', compact('pengguna'));
    }
    public function detail($id){
        $pengguna = User::where('id', $id)->where('role', 2)->first();

        if (!$pengguna) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($pengguna);
    }

    public function change_status($id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status == 1 ? 0 : 1;
        $user->save();

        return back()->with('success', 'Status berhasil diubah.');
    }

}
