<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class verify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $user = auth()->user();
        if ($user->role == 2 && $user->verify == false) {
            return redirect()->route('profile.verify')->with('info', 'Silakan lengkapi data masyarakat Anda terlebih dahulu sebelum mengajukan pengaduan.');
        }
        return $next($request);
    }
}
