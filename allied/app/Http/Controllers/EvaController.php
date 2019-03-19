<?php

namespace App\Http\Controllers;

use App\evaHouse;
use Illuminate\Http\Request;

class EvaController extends Controller
{
    public function view()
    {
        $eva = evaHouse::all();
        $data = array('evas' => $eva);
        return view('EvaluateHouse.view', $data);
    }
    public function create(Request $request)
    {
        if($request->isMethod('post'))
        {
            if ($request->input('question1'))
            {
            $eva=new evaHouse();
            $eva->question=$request->input("question1");


            $eva->save();
            }

            return redirect("/viewEvaluateHouse");
        }

        return view('EvaluateHouse.create');
    }
    public function update($id,Request $request)
    {
        $eva= evaHouse::find($id);
        if($request->isMethod('post'))
        {
            $eva->question=$request->input("question");
            $eva->save();

            return redirect("/viewEvaluateHouse");
        }
        $data=array('eva'=>$eva);
        return view('EvaluateHouse.update',$data);
    }
}
