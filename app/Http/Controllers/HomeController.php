<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function home()
    {
        $user = Auth::user();
        return view('home')->with([
            'role' => $user->role,
            'name' => $user->name
        ]);
    }
    public function users()
    {
        return view('users');
    }
    public function partners()
    {
        return view('partners');
    }
    public function addPartners()
    {
        return view('addPartners');
    }
    public function drivers()
    {
        return view('drivers');
    }
    public function vehicles()
    {
        return view('vehicles');
    }
    public function bookings()
    {
        return view('bookings');
    }
    public function extras()
    {
        return view('extras');
    }


    public function signin()
    {
        return view('auth.signin');
    }

    public function signin_check(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect()->route('home');
        }
        else{
            return redirect()->back()->with('error','Invalid Credantials');
        }
    }

    public function signup()
    {
        return view('auth.signup');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
