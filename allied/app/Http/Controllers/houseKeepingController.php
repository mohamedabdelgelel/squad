<?php

namespace App\Http\Controllers;

use App\house_keeping;
use App\location;
use App\room;

use Illuminate\Http\Request;

class houseKeepingController extends Controller
{
    public function view()
    {
        $booking=house_keeping::all();
        $data =array('booking'=>$booking);
        return view('houseKeeping.create',$data);
    }

    public function create(Request $request)
    {
        $houseKeeping=new house_keeping();

        if($request->isMethod('post'))
        {
            $houseKeeping->name=$request->input('name');
            $houseKeeping->start=$request->input('start');
            $houseKeeping->end=$request->input('end');
            $houseKeeping->status=$request->input('status');
            if ($request->input("location")!=0)
            {
                $houseKeeping->location_id=$request->input("location");

            }
            if ($request->input("room")!=0)
            {
                $houseKeeping->room_id=$request->input("room");

            }
            $houseKeeping->save();
            return redirect("/viewHouseKeeping");
        }
        $rooms=room::all();
        $locations =location::all();
        $data = array('rooms' => $rooms,'locations'=>$locations);
        return view('houseKeeping.create',$data);
    }
    public function delivered()
    {
        $houseKeeping=house_keeping::all()->where('status','=',1);
        $data =array('houseKeeping'=>$houseKeeping);
        return view('houseKeeping.viewDelivered',$data);
    }
    public function undelivered()
    {
        $houseKeeping=house_keeping::all()->where('status','=',0);
        $data =array('houseKeeping'=>$houseKeeping);
        return view('houseKeeping.viewUndelivered',$data);
    }
    public function update(Request $request,$id)
    {
        $houseKeeping=house_keeping::find($id);
        $dt =  new \DateTime($houseKeeping->start);
        $dt2 =  new \DateTime($houseKeeping->end);

        $houseKeeping->start =$dt->format('Y-m-d\TH:i:s');
        $houseKeeping->end = $dt2->format('Y-m-d\TH:i:s');
        if($request->isMethod('post'))
        {
            $houseKeeping->name=$request->input('name');
            $houseKeeping->start=$request->input('start');
            $houseKeeping->end=$request->input('end');
            $houseKeeping->status=$request->input('status');

            $houseKeeping->save();
            return redirect("/viewHouseKeeping");
        }
        $data=array('houseKeeping'=>$houseKeeping);
        return view('houseKeeping.update',$data);
    }
    public function viewAll()
    {
        $houseKeeping=house_keeping::all();
        $data =array('houseKeeping'=>$houseKeeping);
        return view('houseKeeping.view',$data);
    }
    public function delete($id){
        $houseKeeping=house_keeping::find($id);
        $houseKeeping::where ('id',@$id)->delete();
        return redirect("/viewHouseKeeping");
    }

}
