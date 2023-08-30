<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\ActiveDriver;
use App\Models\Booking;
use App\Models\BookingTimestamp;
use App\Models\Noshow;
use App\Models\Passenager;
use App\Models\User;
use App\Models\UserLog;
use App\Models\VehicleType;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Twilio\Rest\Client;

class HomeController extends Controller
{
    public function home()
    {
        $user = Auth::user();
        if($user->role == 'Admin'){
            $drivers = User::where('role','Driver')->count();
            $partners = User::where('role','Partner')->count();
            $active_drivers = ActiveDriver::count();
            $rejected_rides = Booking::where('status', '=', 'rejected')->count();
            $accepted_rides = Booking::where('status', '=', 'accepted')->count();
            $pending_rides = Booking::where('status', '=', 'pending')->count();
            $today_rides = Booking::where('created_at', Carbon::now())->count();
            $active_rides = Booking::where('status', '!=', 'completed')->where('status', '!=', 'rejected')->where('status', '!=', 'not_shown')->count();

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
                        "card_value" => $active_rides,
                        "card_icon" => '<i class="fa fa-chart-area fa-3x text-primary"></i>'
                    ],
                    [
                        "card_title" => "Today Rides",
                        "card_value" => $today_rides,
                        "card_icon" => '<i class="fa fa-chart-pie fa-3x text-primary"></i>'
                    ],
                    [
                        "card_title" => "Accepted Rides",
                        "card_value" => $accepted_rides,
                        "card_icon" => '<i class="fa fa-chart-pie fa-3x text-primary"></i>'
                    ],
                    [
                        "card_title" => "Decline Rides",
                        "card_value" => $rejected_rides,
                        "card_icon" => '<i class="fa fa-chart-pie fa-3x text-primary"></i>'
                    ],
                    [
                        "card_title" => "Confirmed Rides",
                        "card_value" => $pending_rides,
                        "card_icon" => '<i class="fa fa-chart-pie fa-3x text-primary"></i>'
                    ],
                    [
                        "card_title" => "Active Drivers",
                        "card_value" => $active_drivers,
                        "card_icon" => '<i class="fa fa-chart-pie fa-3x text-primary"></i>'
                    ]
                ]
            ];
        }
        else if($user->role == 'Partner'){
            $your_rides = Booking::where('partner_id',$user->id)->count();
            $your_today_rides = Booking::where('partner_id',$user->id)->whereDate('pick_date_time',Carbon::today())->count();
            $data = [
                "cards" => [
                    [
                        "card_title" => "Your Rides",
                        "card_value" => $your_rides,
                        "card_icon" => '<i class="fa fa-chart-area fa-3x text-primary"></i>'
                    ],
                    [
                        "card_title" => "Your Today Rides",
                        "card_value" => $your_today_rides,
                        "card_icon" => '<i class="fa fa-chart-pie fa-3x text-primary"></i>'
                    ],
                ]
            ];
        }
        else if($user->role == 'Driver'){
            $your_rides = Booking::where('driver_id',$user->id)->count();
            $your_today_rides = Booking::where('driver_id',$user->id)->whereDate('pick_date_time',Carbon::today())->count();
            $logs = UserLog::where('user_id',$user->id)->orderBy('id', 'ASC')->get();

            $total_seconds = 0;
            $start_act = null;

            foreach ($logs as $log) {
                if ($log->activity == "login") {
                    $start_act = $log->created_at;
                }
                if ($log->activity == "logout" && $start_act !== null) {
                    $end_act = $log->created_at;
                    $time_diff = $start_act->diff($end_act);

                    // Convert the time difference to seconds and add to the total
                    $total_seconds += $time_diff->h * 3600 + $time_diff->i * 60 + $time_diff->s;
                }
            }

            // Convert the total seconds to H:i:s format
            $total_hours = floor($total_seconds / 3600);
            $total_minutes = floor(($total_seconds % 3600) / 60);
            $total_seconds %= 60;

            $total_time_formatted = sprintf('%02d:%02d:%02d', $total_hours, $total_minutes, $total_seconds);

            $data = [
                "cards" => [
                    [
                        "card_title" => "Your Rides",
                        "card_value" => $your_rides,
                        "card_icon" => '<i class="fa fa-chart-area fa-3x text-primary"></i>'
                    ],
                    [
                        "card_title" => "Your Today Rides",
                        "card_value" => $your_today_rides,
                        "card_icon" => '<i class="fa fa-chart-pie fa-3x text-primary"></i>'
                    ],
                    [
                        "card_title" => "Working Hours",
                        "card_value" => $total_time_formatted,
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
    public function onTheWayBooking($id){
        if($this->statusChangeBooking($id,'ontheway')){
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
        $user = Auth::user();
        return view('reject')->with([
            'role' => $user->role,
            'name' => $user->name,
            'id' => $id
        ]);
    }
    public function noshowBooking($id){
        $user = Auth::user();
        return view('noshow')->with([
            'role' => $user->role,
            'name' => $user->name,
            'id' => $id
        ]);
    }
    public function addStopBooking($id){
        $user = Auth::user();
        $booking = Booking::where('id',$id)->first();
        return view('addStop')->with([
            'role' => $user->role,
            'name' => $user->name,
            'id' => $id,
            'booking' => $booking
        ]);
    }
    public function rejectBookingPost(Request $request, $id){
        if($this->statusChangeBooking($id,'rejected', $request->reason)){
            return redirect()->back()->with('msg','Booking Status Updated!');
        }
        else{
            return redirect()->back()->with('error','Something went wrong, try again');
        }
    }
    public function noshowBookingPost(Request $request, $id){

        // upload no show pics
        if ($request->hasFile('not_shown_img')) {
            $not_shown_img = $request->file('not_shown_img');
            $path = 'not_shown_imgs/';
            $not_shown_img_name = uniqid() . '.' . $not_shown_img->getClientOriginalExtension();
            $not_shown_img->move($path, $not_shown_img_name);
            $data['not_shown_img'] = $not_shown_img_name;

            $data['lat'] = $request->lat;
            $data['lon'] = $request->lon;
            $data['booking_id'] = $id;
            $nowshow = Noshow::create($data);
        }


        if($this->statusChangeBooking($id,'not_shown', $request->reason)){
            return redirect()->back()->with('msg','Booking Status Updated!');
        }
        else{
            return redirect()->back()->with('error','Something went wrong, try again');
        }
    }
    public function addStopBookingPost(Request $request, $id){
        $booking = Booking::where('id',$id)->first();
        if($booking->update($request->except("_token"))){
            return redirect()->back()->with('msg','Booking Stop Updated!');
        }
        else{
            return redirect()->back()->with('error','Something went wrong, try again');
        }
    }
    public function statusChangeBooking($id,$status, $reason = null){
        $booking = Booking::where('id',$id)->with('passengers')->first();
        $booking->status = $status;
        if($reason){
            $booking->reason = $reason;
        }

        $timestamp = new BookingTimestamp();
        $timestamp->booking_id = $id;
        $timestamp->status = $status;

        Helper::userLogEntry('booking:'.$id.", status changed:".$status);

        if($booking->save() && $timestamp->save() ){
            $to = $booking->passengers[0]->phone_number;
            $message = $this->sendsms(
                $to,
                "Ride: ".$id." status change: ".$status
            );
            // dd($message);
            return response()->json(["status" => true, "message" => $message]);
        }
        else{
            return response()->json(["status" => false, "message" => "message not available"]);
        }
    }

    public function sendsms($to,$message_body){
        $sid = env("TWILIO_SID"); // Your Account SID from www.twilio.com/console
        $token = env("TWILIO_TOKEN"); // Your Auth Token from www.twilio.com/console

        $client = new Client($sid, $token);
        $message = "Message Sent";

        try{
            $message = $client->messages->create(
                $to, // Text this number
                [
                    'from' => '+16183615815', // From a valid Twilio number
                    'body' => $message_body
                ]
            );
        }
        catch(Exception $e)
        {
            $message = $e->getMessage();
        }

        return $message;
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
    public function assignDriver($booking_id, $time = 0)
    {
        $user = Auth::user();
        $drivers = User::where('role','Driver')->get();
        foreach($drivers as $driver){
            $lastavailable = Booking::where("driver_id",$driver->id)->pluck('pick_date_time')->max();
            if($lastavailable == null){
                $lastavailable = Carbon::now()->subHours($time);
                // dd($booking_id,$lastavailable);
            }
            $lastavailableDateTime = Carbon::parse($lastavailable)->addHours($time);
            $isAvailableCount = Booking::where("id",$booking_id)->where("pick_date_time",">=",$lastavailableDateTime)->count();

            if($isAvailableCount > 0){
                $driver->available = true;
            }
            else{
                $driver->available = false;
            }
        }


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
            'booking_id' => $booking->id,
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
        $user->phone_no = $request->phone_no;
        $user->taxi_driver_no = $request->taxi_driver_no;
        $user->license_no = $request->license_no;
        $user->license_expiry = $request->license_expiry;

        // upload license pics
        if ($request->hasFile('license_img')) {
            $license_img = $request->file('license_img');
            $path = 'license_imgs/';
            $license_img_name = uniqid() . '.' . $license_img->getClientOriginalExtension();
            $license_img->move($path, $license_img_name);

            $user->license_img = $license_img_name;
        }


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
        $user->phone_no = $request->phone_no;
        $user->taxi_driver_no = $request->taxi_driver_no;
        $user->license_no = $request->license_no;
        $user->license_expiry = $request->license_expiry;

        // upload license pics
        if ($request->hasFile('license_img')) {
            $license_img = $request->file('license_img');
            $path = 'license_imgs/';
            $license_img_name = uniqid() . '.' . $license_img->getClientOriginalExtension();
            $license_img->move($path, $license_img_name);

            $user->license_img = $license_img_name;
        }

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
        $booking->passenger_nos = $request->passenger_nos;
        $booking->currency = $request->currency;
        $booking->booking_id = $request->booking_id;
        $booking->extras = $request->extras;

        if($booking->status == "rejected"){
            $booking->status = $booking->status == "rejected" ? "pending":$booking->status;
            $this->statusChangeBooking($booking->id,'pending');
        }
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
        if(isset($request->extras)){
            $keys = array_keys($request->extras);
            $implodedKeys = implode(', ', $keys);
        }

        $booking = new Booking();
        $booking->destination = $request->destination;
        $booking->location = $request->location;
        $booking->pick_date_time = $request->pick_date_time;
        $booking->vehicle_type = $request->vehicle_type;
        $booking->price = $request->price;
        $booking->passenger_nos = $request->passenger_nos;
        $booking->currency = $request->currency;
        $booking->booking_id = $request->booking_id;
        $booking->extras = $implodedKeys ?? "";
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

    public function storeBookingApi(Request $request)
    {
        if(isset($request->extras)){
            $keys = array_keys($request->extras);
            $implodedKeys = implode(', ', $keys);
        }

        $booking = new Booking();
        $booking->destination = $request->destination;
        $booking->location = $request->location;
        $booking->pick_date_time = $request->pick_date_time;
        $booking->vehicle_type = $request->vehicle_type;
        $booking->price = $request->price;
        $booking->passenger_nos = $request->passenger_nos;
        $booking->currency = $request->currency;
        $booking->booking_id = $request->booking_id;
        $booking->extras = $implodedKeys ?? "";
        $booking->partner_id = Auth::user()->id;
        $booking->status = "pending";


        if($booking->save()){
            $timestamp =  new BookingTimestamp();
            $timestamp->booking_id = $booking->id;
            $timestamp->status = "pending";

            if($timestamp->save()){
                return response()->json([
                    "status" => true,
                    "data" => $booking,
                    "message" => "Booking Created"
                ],200);
            }
            else{
                return response()->json([
                    "status" => false,
                    "data" => [],
                    "message" => "Something went wrong in Timestamp creation, try again"
                ],200);
            }

        }
        else{
            return response()->json([
                "status" => false,
                "data" => [],
                "message" => "Something went wrong, try again"
            ],200);
        }
    }

    public function assignDriverStore(Request $request, $booking_id)
    {
        $booking = Booking::where('id',$booking_id)->first();
        $booking->driver_id = $request->driver_id;
        $booking->price_driver = $request->price_driver;

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
    public function viewLogs($booking_id)
    {
        $user = Auth::user();
        $booking_timestamps = BookingTimestamp::where('booking_id',$booking_id)->get();
        return view('booking_timestamps')->with([
            'role' => $user->role,
            'name' => $user->name,
            'id' => $user->id,
            'view' => true,
            'booking_timestamps' => $booking_timestamps,
            'booking_id' => $booking_id
        ]);
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
    public function viewUserLogs($user_id)
    {
        $user = Auth::user();
        $userlogs = UserLog::where('user_id',$user_id)->orderBy('id', 'desc')->get();
        $logged_user = User::find($user_id);
        return view('logs')->with([
            'role' => $user->role,
            'name' => $user->name,
            'id' => $user->id,
            'view' => true,
            'userlogs' => $userlogs,
            'logged_user' => $logged_user
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
        $bookings = Booking::where('partner_id',$user->id)->with('passengers')->with('driver')->get();
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
        $bookings = Booking::where('status',"completed")->where('driver_id',$driver_id)->with('passengers')->with('driver')->get();
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
        $bookings = Booking::where('status',"onboard")->where('driver_id',$driver_id)->with('passengers')->with('driver')->get();
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
        $bookings = Booking::where('driver_id',$driver_id)->with('passengers')->with('driver')->get();
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
        $bookings = Booking::where('status',"arrived")->where('driver_id',$driver_id)->with('passengers')->with('driver')->get();
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
        $bookings = Booking::where('status',"assigned")->with('passengers')->with('driver')->get();
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
        $bookings = Booking::where('status',"rejected")->with('passengers')->with('driver')->get();
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
        $bookings = Booking::where('status',"accepted")->with('passengers')->with('driver')->get();
        return view('bookings')->with([
            'role' => $user->role,
            'name' => $user->name,
            'id' => $user->id,
            'accepted' => true,
            'bookings' => $bookings
        ]);
    }
    public function unattendedBookings()
    {
        $user = Auth::user();
        $bookings = Booking::wherein('status',["pending"])->whereDate('created_at',"<=",Carbon::now()->addMinutes(15))->with('passengers')->with('driver')->get();
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
        // $bookings = Booking::where('status',"pending")->with('passengers')->with('driver')->get();
        $bookings = Booking::with('passengers')->with('driver')->get();
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
            Helper::userLogEntry('login');
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
        Helper::userLogEntry('logout');
        Auth::logout();
        return redirect()->route('login');
    }
}
