<?php

namespace App\Http\Controllers;

//use App\house_keeping;
use App\financial;
use App\room;
use App\service_type;
use App\laundry_camp;
use Illuminate\Http\Request;

class laundryCampController extends Controller
{
    public function view()
    {
        $room=room::all();
        $service =service_type::all();
        $data =array('room'=>$room,'service'=>$service);
        return view('laundryCamp.create',$data);
    }

    public function create(Request $request)
    {
        $laundryCamp=new laundry_camp();

        if($request->isMethod('post'))
        {
            $fin=new financial();
            $laundryCamp->name=$request->input('name');
            $laundryCamp->cost=$request->input('cost');
            $laundryCamp->status=$request->input('status');
            $laundryCamp->start=$request->input('start');
            $laundryCamp->end=$request->input('end');
            $laundryCamp->type_id=$request->input('service_name');
            $laundryCamp->room_id=$request->input('room');

            $laundryCamp->save();
            $fin->type='1';
            //$current_time = Carbon::now()->toDateTimeString();
            $fin->date=$request->input('start');
            $fin->cost=$request->input("cost");
            $fin->laundry_camp_id=$laundryCamp->id;
            $fin->save();

            return redirect("/viewLaundryCamp");
        }
        $data=array('laundryBooking'=>$laundryCamp);
        return view('laundryCamp.create',$data);
    }
    public function viewAll()
    {
        $laundryCamp=laundry_camp::all();
        //    $booking=booking::where('id',$laundryBooking->booking_id);
        //  $laundry =laundry::all()->where('id',$laundryBooking->laundry_id);
        $data =array('laundryCamp'=>$laundryCamp);
        return view('laundryCamp.view',$data);
        //still no user or room
    }
    public function update(Request $request,$id)
    {
        $laundryCamp=laundry_camp::find($id);
        if($request->isMethod('post'))
        {
            $laundryCamp->name=$request->input('name');
            $laundryCamp->start=$request->input('start');
            $laundryCamp->end=$request->input('end');
            $laundryCamp->status=$request->input('status');
            $laundryCamp->cost=$request->input('cost');

            $laundryCamp->save();
            return redirect("/viewLaundryCamp");
        }
        $data=array('laundryCamp'=>$laundryCamp);
        return view('laundryCamp.update',$data);
    }
    public function delete($id){
        $laundryCamp=laundry_camp::find($id);
        $laundryCamp::where ('id',@$id)->delete();
        return redirect("/viewLaundryCamp");
    }
    public function delivered()
    {
        $laundryCamp=laundry_camp::all()->where('status','=',1);
        $data =array('laundryCamp'=>$laundryCamp);
        return view('laundryCamp.viewDelivered',$data);
    }
    public function undelivered()
    {
        $laundryCamp=laundry_camp::all()->where('status','=',0);
        $data =array('laundryCamp'=>$laundryCamp);
        return view('laundryCamp.viewUndelivered',$data);
    }
}
