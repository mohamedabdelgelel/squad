<?php

namespace App\Http\Controllers;

use App\booking;
use App\extra_camp;
use App\extra_camp_booking;
use Illuminate\Http\Request;

class extraCampBookingController extends Controller
{
    public function create(Request $request)
    {
        $extraCampBooking=new extra_camp_booking();
        $extra =extra_camp::all();
        $booking=booking::all();

        if($request->isMethod('post'))
        {
            // $extra =extra_services::find($request->input('extra'));
            $extraCampBooking->date=$request->input('date');
            $extraCampBooking->booking_id=$request->input('user');
            $extraCampBooking->camp_id=$request->input('camp');


            $extraCampBooking->save();
            return redirect("/viewExtraCampBooking");
        }
        $data=array('extra'=>$extra,'booking'=>$booking);
        return view('extraCampBooking.create',$data);
    }
    public function view()
    {
        $extraCampBooking=extra_camp_booking::all();
        $data =array('extraCampBooking'=>$extraCampBooking);
        return view('extraCampBooking.view',$data);
        //still no user
    }
    public function update(Request $request,$id)
    {
        $extraCampBooking=extra_camp_booking::find($id);
        if($request->isMethod('post'))
        {
            $extraCampBooking->date=$request->input('date');

            $extraCampBooking->save();
            return redirect("/viewExtraCampBooking");
        }
        $data=array('extraCampBooking'=>$extraCampBooking);
        return view('extraCampBooking.update',$data);
    }
    public function delete($id){
        $extraCampBooking=extra_camp_booking::find($id);
        $extraCampBooking::where ('id',@$id)->delete();
        return redirect("/viewExtraCampBooking");
    }
}
