<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/super-admin/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Override redirect after login based on role
    protected function authenticated(Request $request, $user)
    {
        if ($user->role == 'super_admin') {
            return redirect('/super-admin/dashboard');
        } elseif ($user->role == 'doctor') {
            return redirect('/doctor/dashboard');
        } elseif ($user->role == 'user') {
            return redirect('/patient/dashboard');
        }
        
        return redirect('/super-admin/dashboard');
    }

    protected function credentials(Request $request)
    {
        return [
            'email' => $request->email,
            'password' => $request->password,
        ];
    }

    protected function loggedOut(Request $request)
    {
        return redirect('/login');
    }
}