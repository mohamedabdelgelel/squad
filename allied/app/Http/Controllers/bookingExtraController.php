<?php

namespace App\Http\Controllers;

use App\booking_extra;
use Carbon\Carbon;

use App\extra_services;
use App\financial;
use App\booking;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\Cloner\Data;

class bookingExtraController extends Controller
{

    public function create(Request $request)
    {
        $bookingExtra=new booking_extra();
        $extra =extra_services::all();
        $booking=booking::all();


        if($request->isMethod('post'))
        {
            $fin=new financial();
            $extra =extra_services::find($request->input('extra'));
            $bookingExtra->type=$request->input('type');

            $bookingExtra->period=$request->input('period')*$extra->duration;
            $bookingExtra->date=date('Y-m-d H:i:s');
            if($request->input('type')=='1') {
                $bookingExtra->cost = $request->input('period') * $extra->cost_per_duration;
            }
            else {
                $bookingExtra->cost_dollar = $request->input('period') * $extra->cost_dollar;
            }
            $bookingExtra->extra_id=$request->input('extra');
            $bookingExtra->booking_id=$request->input('user');

            $bookingExtra->save();
            $fin->type='2';
            $current_time = Carbon::now()->toDateTimeString();
            $fin->date=$current_time;
            if($bookingExtra->type=='1')
                $fin->cost=$bookingExtra->cost;
            else
            {
                $fin->cost_dollar=$bookingExtra->cost_dollar;
            }
            $fin->spa_id=$bookingExtra->id;
            $fin->save();
            return redirect("/viewBookingExtra");
        }
        $data=array('bookingExtra'=>$bookingExtra,'extra'=>$extra,'booking'=>$booking);
        return view('BookingExtra.create',$data);
    }
    public function viewAll()
    {
        $bookingExtra=booking_extra::all();
        //    $booking=booking::where('id',$laundryBooking->booking_id);
        //  $laundry =laundry::all()->where('id',$laundryBooking->laundry_id);
        $data =array('bookingExtra'=>$bookingExtra);
        return view('bookingExtra.view',$data);
        //still no user
    }

    public function delete($id){
        $bookingExtra=booking_extra::find($id);
        $bookingExtra::where ('id',@$id)->delete();
        return redirect("/viewBookingExtra");
    }
}
