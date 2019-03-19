<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\floor;
use App\location;

class LocationController extends Controller
{
    //

    public function view()
    {
        $jobs = location::all();
        $data = array('jobs' => $jobs);
        return view('location.view', $data);
    }
    public function create(Request $request)
    {
        if($request->isMethod('post'))
        {
            $job=new location();
            $job->name=$request->input("name");
            $job->floor_id=$request->input("department_id");
            $job->save();


            return redirect("/viewLocations");
        }
        $departments = floor::all();
        $data = array('departments' => $departments);
        return view('location.create',$data);
    }
    public function update($id,Request $request)
    {
        $job=location::find($id);

        if($request->isMethod('post'))
        {
            $job->name=$request->input("name");
            $job->floor_id=$request->input("department_id");

            $job->save();


            return redirect("/viewLocations");
        }

        $departments = floor::all();
        $data = array('departments' => $departments,'job'=>$job);

        return view('location.update',$data);
    }
    public function delete($id){
        $job=location::find($id);
        $job->delete();
        return redirect("/viewLocations");
    }
}
