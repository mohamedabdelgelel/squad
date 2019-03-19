<?php

namespace App\Http\Controllers;

use App\laundry_booking;
use App\laundry;
use App\financial;
use App\booking;
use Carbon\Carbon;

use Illuminate\Http\Request;

class laundryBookingController extends Controller
{
    public function view()
    {
        $laundryBooking=laundry_booking::all();
        $data=array('laundryBooking'=>$laundryBooking);
        return view('laundryBooking.create',$data);
    }

    public function create(Request $request)
    {

        $booking=booking::all();
        $laundry =laundry::all();
       // $data =array();
        if($request->isMethod('post'))
        {
            $laundryBooking=new laundry_booking();
            $fin=new financial();
            $laundryBooking->start=$request->input('start');
            $laundryBooking->end=$request->input('end');
            $laundryBooking->status=$request->input('status');
            $laundryBooking->type=$request->input('type');
            $laundryBooking->quantity=$request->input('quantity');
            $f=laundry::find($request->input('name'));
            if($request->input('type')=='1')
            {
            $laundryBooking->cost=$f->cost*$request->input('quantity');
            }
            else
            {
            $laundryBooking->cost_dollar=$f->cost_dollar*$request->input('quantity');
            }
            $laundryBooking->laundry_id=$request->input('name');
            $laundryBooking->booking_id=$request->input('user');



            $laundryBooking->save();
            $fin->type='2';
            //$current_time = Carbon::now()->toDateTimeString();
            $fin->date=$request->input('start');
            if($laundryBooking->type=='1')
            $fin->cost=$laundryBooking->cost;
            else
            {
            $fin->cost_dollar=$laundryBooking->cost_dollar;
            }
            $fin->laundry_booking_id=$laundryBooking->id;
            $fin->save();
            return redirect("/viewLaundryBooking");
        }
        $data=array('laundries'=>$laundry,'booking'=>$booking);
        return view('laundryBooking.create',$data);
    }
    public function viewAll()
    {
        $laundryBooking=laundry_booking::all();
        //    $booking=booking::where('id',$laundryBooking->booking_id);
        //  $laundry =laundry::all()->where('id',$laundryBooking->laundry_id);
        $data =array('laundryBooking'=>$laundryBooking);
        return view('laundryBooking.view',$data);
        //still no user
    }
    public function update(Request $request,$id)
    {
        $laundryBooking=laundry_booking::find($id);
        $dt =  new \DateTime($laundryBooking->start);
        $dt2 =  new \DateTime($laundryBooking->end);

        $laundryBooking->start =$dt->format('Y-m-d\TH:i:s');
        $laundryBooking->end = $dt2->format('Y-m-d\TH:i:s');
        if($request->isMethod('post'))
        {
            $laundryBooking->start=$request->input('start');
            $laundryBooking->end=$request->input('end');
            $laundryBooking->status=$request->input('status');
            $laundryBooking->save();
            return redirect("/viewLaundryBooking");
        }
        $data=array('laundryBooking'=>$laundryBooking);
        return view('laundryBooking.update',$data);
    }
    public function delete($id){
        $laundryBooking=laundry_booking::find($id);
        $laundryBooking::where ('id',@$id)->delete();
        return redirect("/viewLaundryBooking");
    }

    public function delivered()
    {
        $laundryBooking=laundry_booking::all()->where('status','=',1);
        $data =array('laundryBooking'=>$laundryBooking);
        return view('laundryBooking.viewDelivered',$data);
    }
    public function undelivered()
    {
        $laundryBooking=laundry_booking::all()->where('status','=',0);
        $data =array('laundryBooking'=>$laundryBooking);
        return view('laundryBooking.viewUndelivered',$data);
    }
}
