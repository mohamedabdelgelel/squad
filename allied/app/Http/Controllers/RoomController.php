<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\room;
use App\floor;
use App\price;

class RoomController extends Controller
{
    //

    public function view()
    {
        $rooms = room::all();
        $data = array('rooms' => $rooms);
        return view('Room.view', $data);
    }
    public function viewPrices()
    {
        $price = price::first();
        $data = array('price' => $price);
        return view('Room.viewPrices', $data);
    }
    public function create(Request $request)
    {
        if($request->isMethod('post'))
        {
            $rooms=new room();
            $rooms->number=$request->input("number");
            $rooms->type=$request->input("type");
            
            $rooms->floor_id=$request->input("floor_id");

            $rooms->save();


            return redirect("/viewRooms");
        }
        $floors=floor::all();
        $data = array('floors' => $floors);

        return view('Room.create',$data);
    }
    public function update($id,Request $request)
    {

  $rooms= room::find($id);
        if($request->isMethod('post'))
        {

            $rooms->number=$request->input("number");
            $rooms->type=$request->input("type");
          
            $rooms->floor_id=$request->input("floor_id");

            $rooms->save();


            return redirect("/viewRooms");
        }
        $floors=floor::all();

        $data=array('room'=>$rooms,'floors'=>$floors);
        return view('Room.update',$data);



       
    }
     public function updatePrices($id,Request $request)
    {
        if($request->isMethod('post'))
        {
       $price= price::find($id);

            $price->price_single_egp=$request->input("price_single_egp");
            $price->price_single_usd=$request->input("price_single_usd");
          
            $price->price_private_egp=$request->input("price_private_egp");
                        $price->price_private_usd=$request->input("price_private_usd");
            $price->price_shared_egp=$request->input("price_shared_egp");
            $price->price_shared_usd=$request->input("price_shared_usd");
            $price->price_quad_egp=$request->input("price_quad_egp");
            $price->price_quad_usd=$request->input("price_quad_usd");
            $price->weekend_single=$request->input("weekend_single");
            $price->weekend_private=$request->input("weekend_private");
            $price->weekend_shared=$request->input("weekend_shared");
            $price->weekend_quad=$request->input("weekend_quad");
            $price->weekend_single_usd=$request->input("weekend_single_usd");
            $price->weekend_private_usd=$request->input("weekend_private_usd");
            $price->weekend_shared_usd=$request->input("weekend_shared_usd");
            $price->weekend_quad_usd=$request->input("weekend_quad_usd");
                        $price->dayuse=$request->input("dayuse");
            $price->dayuse_usd=$request->input("dayuse_usd");
            $price->percentage_one_week=$request->input("percentage_one_week");
            $price->percentage_two_weeks=$request->input("percentage_two_weeks");
            $price->percentage_three_weeks=$request->input("percentage_three_weeks");
            $price->percentage_four_weeks=$request->input("percentage_four_weeks");



            $price->save();


            return redirect("/viewPrices");
        }
      //  $floors=floor::all();
    }
    public function details($id)
    {
        $rooms= room::find($id);

        $data=array('room'=>$rooms);
        return view('Room.details',$data);
    }
    public function delete($id){
        $rooms=room::find($id);
        $rooms::where ('id',$id)->delete();
        return redirect("/viewRooms");
    }
}
