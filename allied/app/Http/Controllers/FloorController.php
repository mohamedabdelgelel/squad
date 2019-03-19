<?php

namespace App\Http\Controllers;

use App\floor;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    //

    public function view()
    {
        $departments = floor::all();
        $data = array('departments' => $departments);
        return view('floor.view', $data);
    }
    public function create(Request $request)
    {
        if($request->isMethod('post'))
        {
            $department=new floor();
            $department->name=$request->input("name");
            $department->save();


            return redirect("/viewFloors");
        }
        return view('floor.create');
    }
    public function update($id,Request $request)
    {
        $department=floor::find($id);

        if($request->isMethod('post'))
        {
            $department->name=$request->input("name");
            $department->save();


            return redirect("/viewFloors");
        }

        $data = array('department' => $department);

        return view('floor.update',$data);
    }
    public function delete($id){
        $department=floor::find($id);
        $department->delete();
        return redirect("/viewFloors");
    }
}
