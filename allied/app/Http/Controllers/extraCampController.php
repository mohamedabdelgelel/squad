<?php

namespace App\Http\Controllers;

use App\extra_camp;
use Illuminate\Http\Request;

class extraCampController extends Controller
{
    public function view()
    {
        $extraCamp=extra_camp::all();
        $data =array('extraCamp'=>$extraCamp);
        return view('extraCamp.view',$data);
    }
    public function create(Request $request)
    {
        $extraCamp=new extra_camp();

        if($request->isMethod('post'))
        {
            $extraCamp->name=$request->input('name');
            $extraCamp->duration=$request->input('duration');

            $extraCamp->save();
            return redirect("/viewExtraCamp");
        }
        return view('extraCamp.create');
    }
    public function update($id,Request $request)
    {
        $extraCamp= extra_camp::find($id);
        if($request->isMethod('post'))
        {
            $extraCamp->name= $request->input("name");
            $extraCamp->duration = $request->input("duration");

            $extraCamp->save();

            return redirect("/viewExtraCamp");
        }
        $data=array('extraCamp'=>$extraCamp);
        return view('extraCamp.update',$data);
    }
    public function delete($id){
        $extraCamp=extra_camp::find($id);
        $extraCamp::where ('id',@$id)->delete();
        return redirect("/viewExtraCamp");
    }

}
