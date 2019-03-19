<?php

namespace App\Http\Controllers;

use App\fi;
use Illuminate\Http\Request;

class dollarController extends Controller
{
    public function view()
    {
        $dollar = fi::all();
        $data = array('dollar' => $dollar);
        return view('dollar.view', $data);
    }
    public function create(Request $request)
    {
        if($request->isMethod('post'))
        {
            $dollar=new fi();
            $dollar->dollar=$request->input("dollar");
            $dollar->save();


            return redirect("/viewDollar");
        }

        return view('dollar.create');
    }
    public function update($id,Request $request)
    {
        $dollar= fi::find($id);
        if($request->isMethod('post'))
        {
            $dollar->dollar=$request->input("dollar");
            $dollar->save();

            return redirect("/viewDollar");
        }
        $data=array('dollar'=>$dollar);
        return view('dollar.update',$data);
    }
}
