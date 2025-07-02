<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit()
    {
       return view('profile.edit');
    }

    /**
     * Update the user's profile information.
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('photo')) {

            $path =  $request->file('photo')->store('uploads/foto', 'public');
            $user->foto = $path;
            $user->save();
        }

        return back()->with('success', 'Foto profile berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function verify(){
        $user = Auth::user();
        if($user->verify == 1){
            return  Redirect::route('dashboard')->with('info','Data Anda Sudah Lengkap! ');
        }
        $progress = $this->calculateProfileProgress($user);
            return view('profile.verify', compact('user', 'progress'));
    }

    private function calculateProfileProgress($user)
    {
        $fields = [
            'name',
            'nik',
            'email',
            'no_telp',
            'alamat',
            'foto',
            'file_ktp'
        ];

        $filled = collect($fields)->filter(fn($field) => !empty($user->$field))->count();
        return round(($filled / count($fields)) * 100);
    }

      public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nik'       => ['required', 'digits:16', Rule::unique('users', 'nik')->ignore($user->id)],
            'email'     => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'no_telp'     => 'required|numeric',
            'alamat'   => 'required|string|max:1000',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'file_ktp'  => $user->file_ktp ? 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120' : 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'terms'     => 'accepted',
        ]);

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::delete($user->foto); // hapus file lama
            }
           $validated['foto'] = $request->file('foto')->store('uploads/foto', 'public');
        }

        if ($request->hasFile('file_ktp')) {
            if ($user->file_ktp) {
                Storage::delete($user->file_ktp);
            }
            $validated['file_ktp'] = $request->file('file_ktp')->store('uploads/ktp', 'public');

        }

        $user->update([
            'nama'        => $validated['name'],
            'nik'         => $validated['nik'],
            'email'       => $validated['email'],
            'no_telp'   => $validated['no_telp'],
            'alamat'      => $validated['alamat'],
            'foto'        => $validated['foto'] ?? $user->foto,
            'file_ktp'    => $validated['file_ktp'] ?? $user->file_ktp,
            'verify' => 1,
        ]);

        return redirect()->route('dashboard')->with('success', 'Data berhasil disimpan!.');
    }
}
