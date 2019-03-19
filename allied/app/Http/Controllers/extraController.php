<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\extra_services;

class extraController extends Controller
{
    //
    public function view()
    {
        $extras = extra_services::all();
        $data = array('extras' => $extras);
        return view('extra.view', $data);
    }
    public function create(Request $request)
    {
        if($request->isMethod('post'))
        {
            $extra=new extra_services();
            $extra->name=$request->input("name");
            $extra->cost_per_duration=$request->input("cost_per_duration");
            $extra->cost_dollar=$request->input("cost_dollar");
            $extra->duration=$request->input("duration");
            $extra->bullets=$request->input("bullets");


            $extra->save();


            return redirect("/viewExtra");
        }
        return view('extra.create');
    }
    public function update(Request $request,$id)
    {
        $extra=extra_services::find($id);
        if($request->isMethod('post'))
        {
            $extra->name=$request->input('name');
            $extra->cost_per_duration=$request->input('cost_per_duration');
            $extra->cost_dollar=$request->input("cost_dollar");
            $extra->duration=$request->input('duration');
            $extra->bullets=$request->input('bullets');

            $extra->save();
            return redirect("/viewExtra");
        }
        $data=array('extra'=>$extra);
        return view('extra.update',$data);
    }
    public function delete($id){
        $extra=extra_services::find($id);
        $extra::where ('id',@$id)->delete();
        return redirect("/viewExtra");
    }

}
