<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingTimestamp;
use App\Models\Passenager;
use App\Models\User;
use App\Models\VehicleType;
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
            'id' => $user->id,
            'data' => $data
        ]);
    }
    public function deletePassenger($id){
        $passenger = Passenager::where('id',$id)->first();
        if($passenger->delete()){
            return redirect()->back()->with('msg','Passenger Deleted!');
        }
        else{
            return redirect()->back()->with('error','Something went wrong, try again');
        }
    }
    public function completeBooking($id){
        if($this->statusChangeBooking($id,'completed')){
            return redirect()->back()->with('msg','Booking Status Updated!');
        }
        else{
            return redirect()->back()->with('error','Something went wrong, try again');
        }
    }
    public function onboardBooking($id){
        if($this->statusChangeBooking($id,'onboard')){
            return redirect()->back()->with('msg','Booking Status Updated!');
        }
        else{
            return redirect()->back()->with('error','Something went wrong, try again');
        }
    }
    public function arriveBooking($id){
        if($this->statusChangeBooking($id,'arrived')){
            return redirect()->back()->with('msg','Booking Status Updated!');
        }
        else{
            return redirect()->back()->with('error','Something went wrong, try again');
        }
    }
    public function acceptBooking($id){
        if($this->statusChangeBooking($id,'accepted')){
            return redirect()->back()->with('msg','Booking Status Updated!');
        }
        else{
            return redirect()->back()->with('error','Something went wrong, try again');
        }
    }
    public function rejectBooking($id){
        if($this->statusChangeBooking($id,'rejected')){
            return redirect()->back()->with('msg','Booking Status Updated!');
        }
        else{
            return redirect()->back()->with('error','Something went wrong, try again');
        }
    }
    public function statusChangeBooking($id,$status){
        $booking = Booking::where('id',$id)->first();
        $booking->status = $status;

        $timestamp = new BookingTimestamp();
        $timestamp->booking_id = $id;
        $timestamp->status = $status;

        if($booking->save() && $timestamp->save() ){
            return true;
        }
        else{
            return false;
        }
    }
    public function deleteBooking($id){
        $user = Booking::where('id',$id)->first();
        if($user->delete()){
            return redirect()->back()->with('msg','Booking Deleted!');
        }
        else{
            return redirect()->back()->with('error','Something went wrong, try again');
        }
    }
    public function deleteVehicle($id){
        $user = VehicleType::where('id',$id)->first();
        if($user->delete()){
            return redirect()->back()->with('msg','Vehicle Deleted!');
        }
        else{
            return redirect()->back()->with('error','Something went wrong, try again');
        }
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
            'id' => $user->id,
            'data' => $data
        ]);
    }
    public function vehicleTypes()
    {
        $user = Auth::user();
        $data = VehicleType::get();
        return view('vehicle_types')->with([
            'role' => $user->role,
            'name' => $user->name,
            'id' => $user->id,
            'data' => $data
        ]);
    }
    public function addPassenger($booking_id)
    {
        $user = Auth::user();
        return view('addPassenger')->with([
            'role' => $user->role,
            'name' => $user->name,
            'id' => $user->id,
            'booking_id' => $booking_id
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
    public function addVehicle()
    {
        $user = Auth::user();
        return view('addVehicle')->with([
            'role' => $user->role,
            'name' => $user->name
        ]);
    }
    public function assignDriver($booking_id)
    {
        $user = Auth::user();
        $drivers = User::where('role','Driver')->get();
        $booking = Booking::where('id',$booking_id)->first();
        return view('assignDriver')->with([
            'role' => $user->role,
            'name' => $user->name,
            'id' => $user->id,
            'drivers' => $drivers,
            'booking' => $booking
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
            'id' => $user->id,
            'edit' => true,
            'driver' => $driver
        ]);
    }
    public function editBooking($id)
    {
        $user = Auth::user();
        $booking = Booking::where('id',$id)->first();
        $vehicleTypes = VehicleType::get();
        return view('add_booking')->with([
            'role' => $user->role,
            'name' => $user->name,
            'id' => $user->id,
            'edit' => true,
            'booking' => $booking,
            'vehicleTypes' => $vehicleTypes
        ]);
    }
    public function editPassenger($booking_id)
    {
        $user = Auth::user();
        $passenger = Passenager::where('booking_id',$booking_id)->first();
        return view('addPassenger')->with([
            'role' => $user->role,
            'name' => $user->name,
            'id' => $user->id,
            'edit' => true,
            'passenger' => $passenger,
            'booking_id' => $booking_id
        ]);
    }
    public function editVehicle($id)
    {
        $user = Auth::user();
        $vehicle = VehicleType::where('id',$id)->first();
        return view('addVehicle')->with([
            'role' => $user->role,
            'name' => $user->name,
            'id' => $user->id,
            'edit' => true,
            'vehicle' => $vehicle
        ]);
    }
    public function editPartners($id)
    {
        $user = Auth::user();
        $partner = User::where('id',$id)->first();
        return view('addPartners')->with([
            'role' => $user->role,
            'name' => $user->name,
            'id' => $user->id,
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
    public function updatePassenger(Request $request, $id)
    {
        $passenger = Passenager::where('id',$id)->first();
        $passenger->name = $request->name;
        $passenger->phone_number = $request->phone_number;
        $passenger->suitcase_number = $request->suitcase_number;
        $passenger->flight_date_time = $request->flight_date_time;
        $passenger->flight_number = $request->flight_number;
        $passenger->flight_airline = $request->flight_airline;
        $passenger->flight_arriving_from = $request->flight_arriving_from;

        if($passenger->save()){
            return redirect()->back()->with('msg','Passenger Updated!');
        }
        else{
            return redirect()->back()->with('error','Something went wrong, try again');
        }
    }
    public function updateBooking(Request $request, $id)
    {
        $booking = Booking::where('id',$id)->first();
        $booking->destination = $request->destination;
        $booking->location = $request->location;
        $booking->pick_date_time = $request->pick_date_time;
        $booking->vehicle_type = $request->vehicle_type;
        $booking->extras = $request->extras;
        $booking->partner_id = Auth::user()->id;

        if($booking->save()){
            return redirect()->back()->with('msg','Booking Updated!');
        }
        else{
            return redirect()->back()->with('error','Something went wrong, try again');
        }
    }
    public function updateVehicle(Request $request, $id)
    {
        $vehicle = VehicleType::where('id',$id)->first();
        $vehicle->type = $request->type;

        if($vehicle->save()){
            return redirect()->back()->with('msg','Vehicle Updated!');
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
    public function storePassenger(Request $request, $booking_id)
    {
        $passenger = new Passenager();
        $passenger->booking_id = $booking_id;
        $passenger->name = $request->name;
        $passenger->phone_number = $request->phone_number;
        $passenger->suitcase_number = $request->suitcase_number;
        $passenger->flight_date_time = $request->flight_date_time;
        $passenger->flight_number = $request->flight_number;
        $passenger->flight_airline = $request->flight_airline;
        $passenger->flight_arriving_from = $request->flight_arriving_from;

        if($passenger->save()){
            return redirect()->route('passengers',['booking_id'=> $booking_id])->with('msg','Passenger Added!');
        }
        else{
            return redirect()->back()->with('error','Something went wrong, try again');
        }
    }
    public function storeBooking(Request $request)
    {
        $booking = new Booking();
        $booking->destination = $request->destination;
        $booking->location = $request->location;
        $booking->pick_date_time = $request->pick_date_time;
        $booking->vehicle_type = $request->vehicle_type;
        $booking->extras = $request->extras;
        $booking->partner_id = Auth::user()->id;
        $booking->status = "pending";


        if($booking->save()){
            $timestamp =  new BookingTimestamp();
            $timestamp->booking_id = $booking->id;
            $timestamp->status = "pending";

            if($timestamp->save()){
                return redirect()->route('passengers',['booking_id' => $booking->id])->with('msg','Booking Added!');
            }
            else{
                return redirect()->back()->with('error','Something went wrong in Timestamp creation, try again');
            }

        }
        else{
            return redirect()->back()->with('error','Something went wrong, try again');
        }
    }
    public function assignDriverStore(Request $request, $booking_id)
    {
        $booking = Booking::where('id',$booking_id)->first();
        $booking->driver_id = $request->driver_id;

        if($booking->save()){
            $this->statusChangeBooking($booking_id,'assigned');
            return redirect()->back()->with('msg','Driver Assigned!');
        }
        else{
            return redirect()->back()->with('error','Something went wrong, try again');
        }
    }
    public function storeVehicle(Request $request)
    {
        $vehicle = new VehicleType();
        $vehicle->type = $request->type;

        if($vehicle->save()){
            return redirect()->back()->with('msg','Vehicle Added!');
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
    public function viewPassengers($booking_id)
    {
        $user = Auth::user();
        $passengers = Passenager::where('booking_id',$booking_id)->get();
        return view('passengers')->with([
            'role' => $user->role,
            'name' => $user->name,
            'id' => $user->id,
            'view' => true,
            'passengers' => $passengers,
            'booking_id' => $booking_id
        ]);
    }
    public function passengers($booking_id)
    {
        $user = Auth::user();
        $passengers = Passenager::where('booking_id',$booking_id)->get();
        return view('passengers')->with([
            'role' => $user->role,
            'name' => $user->name,
            'id' => $user->id,
            'passengers' => $passengers,
            'booking_id' => $booking_id
        ]);
    }
    public function drivers()
    {
        $user = Auth::user();
        $data = User::where('role','Driver')->get();
        return view('drivers')->with([
            'role' => $user->role,
            'name' => $user->name,
            'id' => $user->id,
            'data' => $data
        ]);
    }
    public function vehicles()
    {
        return view('vehicles');
    }
    public function bookingDetail($booking_id)
    {
        $user = Auth::user();
        $booking = Booking::where('id',$booking_id)->with('passengers')->first();
        return view('booking_detail')->with([
            'role' => $user->role,
            'name' => $user->name,
            'id' => $user->id,
            'booking_id' => $booking_id,
            'booking' => $booking
        ]);
    }
    public function bookings()
    {
        $user = Auth::user();
        $bookings = Booking::where('partner_id',$user->id)->with('passengers')->get();
        return view('bookings')->with([
            'role' => $user->role,
            'name' => $user->name,
            'id' => $user->id,
            'for_partner' => true,
            'bookings' => $bookings
        ]);
    }
    public function completedBookings($driver_id)
    {
        $user = Auth::user();
        $bookings = Booking::where('status',"completed")->where('driver_id',$driver_id)->with('passengers')->get();
        return view('bookings')->with([
            'role' => $user->role,
            'name' => $user->name,
            'id' => $user->id,
            'bookings' => $bookings
        ]);
    }
    public function onboardBookings($driver_id)
    {
        $user = Auth::user();
        $bookings = Booking::where('status',"onboard")->where('driver_id',$driver_id)->with('passengers')->get();
        return view('bookings')->with([
            'role' => $user->role,
            'name' => $user->name,
            'id' => $user->id,
            'bookings' => $bookings
        ]);
    }
    public function assignedDriverBookings($driver_id)
    {
        $user = Auth::user();
        $bookings = Booking::where('status',"assigned")->where('driver_id',$driver_id)->with('passengers')->get();
        return view('bookings')->with([
            'role' => $user->role,
            'name' => $user->name,
            'id' => $user->id,
            'driver' => true,
            'bookings' => $bookings
        ]);
    }
    public function arrivedBookings($driver_id)
    {
        $user = Auth::user();
        $bookings = Booking::where('status',"arrived")->where('driver_id',$driver_id)->with('passengers')->get();
        return view('bookings')->with([
            'role' => $user->role,
            'name' => $user->name,
            'id' => $user->id,
            'bookings' => $bookings
        ]);
    }
    public function assignedBookings()
    {
        $user = Auth::user();
        $bookings = Booking::where('status',"assigned")->with('passengers')->get();
        return view('bookings')->with([
            'role' => $user->role,
            'name' => $user->name,
            'id' => $user->id,
            'bookings' => $bookings
        ]);
    }
    public function rejectedBookings()
    {
        $user = Auth::user();
        $bookings = Booking::where('status',"rejected")->with('passengers')->get();
        return view('bookings')->with([
            'role' => $user->role,
            'name' => $user->name,
            'id' => $user->id,
            'bookings' => $bookings
        ]);
    }
    public function acceptedBookings()
    {
        $user = Auth::user();
        $bookings = Booking::where('status',"accepted")->with('passengers')->get();
        return view('bookings')->with([
            'role' => $user->role,
            'name' => $user->name,
            'id' => $user->id,
            'accepted' => true,
            'bookings' => $bookings
        ]);
    }
    public function pendingBookings()
    {
        $user = Auth::user();
        $bookings = Booking::where('status',"pending")->with('passengers')->get();
        return view('bookings')->with([
            'role' => $user->role,
            'name' => $user->name,
            'id' => $user->id,
            'bookings' => $bookings
        ]);
    }
    public function addBooking()
    {
        $user = Auth::user();
        $vehicleTypes = VehicleType::get();
        return view('add_booking')->with([
            'role' => $user->role,
            'name' => $user->name,
            'id' => $user->id,
            'vehicleTypes' => $vehicleTypes
        ]);
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
