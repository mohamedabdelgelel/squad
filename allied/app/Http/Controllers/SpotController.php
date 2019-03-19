<?php

namespace App\Http\Controllers;

use App\room;
use App\Spot;
use Illuminate\Http\Request;

class SpotController extends Controller
{
    public function viewSpot()
    {
        $spot = Spot::all();
        $data = array('spot' => $spot);
        return view('Spot.view', $data);
    }
    public function addSpot(Request $request)
    {
        if($request->isMethod('post'))
        {
            $room = room::find($request->input("room_id"));
            if($room->type =='private' || $room->type =='public'){
                if (count($room->Spots) < 2) {
                    $newSpot=new Spot();
                    $newSpot->name=$request->input("name");
                    $newSpot->room_id=$request->input("room_id");
                    $newSpot->save();
                    return redirect("/viewSpot");
                }
            }
            if($room->type =='single'){
                if (count($room->Spots) < 1) {
                    $newSpot=new Spot();
                    $newSpot->name=$request->input("name");
                    $newSpot->room_id=$request->input("room_id");
                    $newSpot->save();
                    return redirect("/viewSpot");
                }
            }
            if($room->type =='four'){
                if (count($room->Spots) < 4){
                    $newSpot=new Spot();
                    $newSpot->name=$request->input("name");
                    $newSpot->room_id=$request->input("room_id");
                    $newSpot->save();
                    return redirect("/viewSpot");
                }
            }
            else{
                $message = "The room exceeded the limit";
            return redirect("/addSpot")->with('message',$message);
            }


        }
        else{
            $room = room::all();
            return view('Spot.add',compact('room'));
        }
        return view('Spot.create');
    }
    public function editSpot(Request $request, $id){
        if($request->isMethod('post')){

            $room = room::find($request->input("room_id"));
            $spot=Spot::find($id);
            if($room->id == $spot->room_id){
                $newSpot=Spot::find($id);
                    $newSpot->name=$request->input("name");
                    $newSpot->room_id=$request->input("room_id");
                    $newSpot->save();
                    return redirect("/viewSpot");
            }
            if($room->type =='private' || $room->type =='public'){
                if (count($room->Spots) < 2) {
                    $newSpot=Spot::find($id);
                    $newSpot->name=$request->input("name");
                    $newSpot->room_id=$request->input("room_id");
                    $newSpot->save();
                    return redirect("/viewSpot");
                }
                else{
                    $room = room::all();
         return view('Spot.add',compact('room'));
                }
            }
            if($room->type =='single'){
                if (count($room->Spots) < 1) {
                    $newSpot=Spot::find($id);
                    $newSpot->name=$request->input("name");
                    $newSpot->room_id=$request->input("room_id");
                    $newSpot->save();
                    return redirect("/viewSpot");
                }
            }
            if($room->type =='four'){
                if (count($room->Spots) < 4){
                    $newSpot=Spot::find($id);
                    $newSpot->name=$request->input("name");
                    $newSpot->room_id=$request->input("room_id");
                    $newSpot->save();
                    return redirect("/viewSpot");
                }
            }
            else{
                $message = "The room exceeded the limit";
                $spot=Spot::find($id);
                $room = room::all();
                return view('Spot.edit',compact('room','spot'))->with('message',$message);
            }
        }

        else{
            $spot=Spot::find($id);
            $room = room::all();
            return view('Spot.edit',compact('room','spot'));
        }

    }
    public function delete($id){
        $Spot=Spot::find($id);
        $Spot::where ('id',$id)->delete();
        return redirect("/viewSpot");
    }
}
