<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'nama' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'digits:16', 'unique:users,nik'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'no_telp' => ['required', 'string', 'max:20'],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        try {
            $user = User::create([
                'name' => $request->nama,
                'nik' => $request->nik,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
                'password' => Hash::make($request->password),
                'role' => 2
            ]);

            Log::info('User berhasil didaftarkan', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            event(new Registered($user));
            Auth::login($user);
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            Log::error('Terjadi kesalahan saat registrasi', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Terjadi kesalahan saat mendaftarkan akun. Silakan coba lagi.')->withInput();
        }
    }
}
