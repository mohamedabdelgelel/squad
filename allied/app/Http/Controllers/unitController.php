<?php

namespace App\Http\Controllers;

use App\unit;
use Illuminate\Http\Request;

class unitController extends Controller
{
    public function view()
    {
        $unit = unit::all();
        $data = array('unit' => $unit);
        return view('unit.view', $data);
    }
    public function create(Request $request)
    {
        if($request->isMethod('post'))
        {
            $unit=new unit();
            $unit->name=$request->input("name");
            $unit->equivalent=$request->input("equivalent");
            $unit->unit_id=$request->input("unit_id");
            
            $unit->save();


            return redirect("/viewUnit");
        }
        else{
            $unit = unit::all();
            return view('unit.create',compact('unit'));
        }
        return view('unit.create');
    }
    public function editUnit(Request $request, $id){
        if($request->isMethod('post')){
            $newUnit=Color::find($id);
            $newUnit->name = $request->input('name');
            $newUnit->equivalent = $request->input("equivalent");
            $newUnit->unit_id=$request->input("unit_id");
            $newUnit->save();
            return redirect("viewUnit");
        }

        else{
            $unit=Color::find($id);
            $arr = Array('unit'=>$unit);
            return view("Unit.update",$arr);
        }

    }
    public function delete($id){
        $unit=unit::find($id);
        $unit::where ('id',$id)->delete();
        return redirect("/viewUnit");
    }
}
