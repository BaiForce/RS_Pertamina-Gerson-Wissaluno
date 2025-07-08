<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Redirect pengguna setelah login berdasarkan role-nya.
     */
    protected function redirectTo()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return route('admin.dashboard');
        } elseif ($user->role === 'konsumen') {
            return route('konsumen.dashboard');
        }

        return '/home'; // fallback default
    }

    /**
     * Jika berhasil login, log informasinya.
     */
    protected function authenticated(Request $request, $user)
    {
        Log::info('Login berhasil', [
            'id' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
            'ip' => $request->ip(),
        ]);
    }

    /**
     * Jika login gagal, log informasinya.
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        Log::warning('Login gagal', [
            'email' => $request->input('email'),
            'ip' => $request->ip(),
        ]);

        throw \Illuminate\Validation\ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Gunakan email sebagai username.
     */
    public function username()
    {
        return 'email';
    }
}
