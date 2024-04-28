<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function logout() {
        Auth::logout();
    
        setcookie('user', null);
        setcookie('access-token', null);

        return redirect()->route('login');
    }
}
