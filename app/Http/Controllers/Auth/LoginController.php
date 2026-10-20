<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // Guard default users
    protected $guard = 'web';

    // Redirect setelah login berhasil
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Override guard agar login menggunakan guard 'web'
     */
    protected function guard()
    {
        return Auth::guard('web');
    }

    /**
     * Setelah login berhasil
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended($this->redirectTo);
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda berhasil logout.');
    }
}
