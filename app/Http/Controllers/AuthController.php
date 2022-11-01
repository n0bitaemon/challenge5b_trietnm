<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(Request $request){
        if($request->user()){
            return redirect()->route('exercises.index');
        }
        return view('login');
    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        if(Auth::attempt($credentials)){
            $userSession = Auth::user();

            return redirect()->route('users.index');
        }

        return back()->withErrors([
            'wrong_credentials' => 'Wrong username or password'
        ]);
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
