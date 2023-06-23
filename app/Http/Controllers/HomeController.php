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
        if($user->role == 'Admin'){
            $drivers = User::where('role','Driver')->count();
            $partners = User::where('role','Partner')->count();
            $data = [
                "cards" => [
                    [
                        "card_title" => "Total Drivers",
                        "card_value" => $drivers,
                        "card_icon" => '<i class="fa fa-chart-line fa-3x text-primary"></i>'
                    ],
                    [
                        "card_title" => "Total Partners",
                        "card_value" => $partners,
                        "card_icon" => '<i class="fa fa-chart-bar fa-3x text-primary"></i>'
                    ],
                    [
                        "card_title" => "Active Rides",
                        "card_value" => "6 (dummy)",
                        "card_icon" => '<i class="fa fa-chart-area fa-3x text-primary"></i>'
                    ],
                    [
                        "card_title" => "Today Rides",
                        "card_value" => "1 (dummy)",
                        "card_icon" => '<i class="fa fa-chart-pie fa-3x text-primary"></i>'
                    ],
                ]
            ];
        }
        else if($user->role == 'Partner'){
            $drivers = User::where('role','Driver')->count();
            $data = [
                "cards" => [
                    [
                        "card_title" => "Your Rides",
                        "card_value" => "6 (dummy)",
                        "card_icon" => '<i class="fa fa-chart-area fa-3x text-primary"></i>'
                    ],
                    [
                        "card_title" => "Your Today Rides",
                        "card_value" => "1 (dummy)",
                        "card_icon" => '<i class="fa fa-chart-pie fa-3x text-primary"></i>'
                    ],
                ]
            ];
        }
        else if($user->role == 'Driver'){
            $data = [
                "cards" => [
                    [
                        "card_title" => "Your Rides",
                        "card_value" => "6 (dummy)",
                        "card_icon" => '<i class="fa fa-chart-area fa-3x text-primary"></i>'
                    ],
                    [
                        "card_title" => "Your Today Rides",
                        "card_value" => "1 (dummy)",
                        "card_icon" => '<i class="fa fa-chart-pie fa-3x text-primary"></i>'
                    ],
                ]
            ];
        }
        return view('home')->with([
            'role' => $user->role,
            'name' => $user->name,
            'data' => $data
        ]);
    }
    public function usersDelete($id){
        $user = User::where('id',$id)->first();
        if($user->delete()){
            return redirect()->back()->with('msg','Driver Deleted!');
        }
        else{
            return redirect()->back()->with('error','Something went wrong, try again');
        }
    }
    public function users()
    {
        return view('users');
    }
    public function partners()
    {
        $user = Auth::user();
        $data = User::where('role','Partner')->get();
        return view('partners')->with([
            'role' => $user->role,
            'name' => $user->name,
            'data' => $data
        ]);
    }
    public function addDrivers()
    {
        $user = Auth::user();
        return view('addDrivers')->with([
            'role' => $user->role,
            'name' => $user->name
        ]);
    }
    public function addPartners()
    {
        $user = Auth::user();
        return view('addPartners')->with([
            'role' => $user->role,
            'name' => $user->name
        ]);
    }
    public function editDrivers($id)
    {
        $user = Auth::user();
        $driver = User::where('id',$id)->first();
        return view('addDrivers')->with([
            'role' => $user->role,
            'name' => $user->name,
            'edit' => true,
            'driver' => $driver
        ]);
    }
    public function editPartners($id)
    {
        $user = Auth::user();
        $partner = User::where('id',$id)->first();
        return view('addPartners')->with([
            'role' => $user->role,
            'name' => $user->name,
            'edit' => true,
            'partner' => $partner
        ]);
    }
    public function storeDrivers(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = "Driver";

        if($user->save()){
            return redirect()->back()->with('msg','Driver Added!');
        }
        else{
            return redirect()->back()->with('error','Something went wrong, try again');
        }
    }
    public function updateDrivers(Request $request, $id)
    {
        $user = User::where('id',$id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = "Driver";

        if($user->save()){
            return redirect()->back()->with('msg','Driver Updated!');
        }
        else{
            return redirect()->back()->with('error','Something went wrong, try again');
        }
    }
    public function updatePartners(Request $request, $id)
    {
        $user = User::where('id',$id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = "Partner";

        if($user->save()){
            return redirect()->back()->with('msg','Partner Updated!');
        }
        else{
            return redirect()->back()->with('error','Something went wrong, try again');
        }
    }
    public function storePartners(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = "Partner";

        if($user->save()){
            return redirect()->back()->with('msg','Partner Added!');
        }
        else{
            return redirect()->back()->with('error','Something went wrong, try again');
        }
    }
    public function drivers()
    {
        $user = Auth::user();
        $data = User::where('role','Driver')->get();
        return view('drivers')->with([
            'role' => $user->role,
            'name' => $user->name,
            'data' => $data
        ]);
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
