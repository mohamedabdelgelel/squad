<?php

namespace App\Http\Controllers;

use App\evaHouse;
use App\evaHouseKeeping;
use Illuminate\Http\Request;

class EvaHouseController extends Controller
{
    public function view(Request $request)
    {
        $evaluation=null;
          $date = $request->input("date");
            if($request->isMethod('post'))
            {
               $evaluation = evaHouseKeeping::where('date','=',$date)->get();
    
            }

    $data = array('evaluations' => $evaluation);
        return view('EvaluateHouseKeeping.view', $data); 

        }
    public function create(Request $request)
    {
        $evaluation = evaHouse::all();

        if($request->isMethod('post'))
        {
                for($i=0;$i<count($evaluation);$i++) {
                    $eva = new evaHouseKeeping();
                    $eva->eva_id = $evaluation[$i]->id;
                    $eva->type = $request->input('qu' . $evaluation[$i]->id);
                    $eva->date = $request->input('date');
                    $eva->note = $request->input('note' . $evaluation[$i]->id);
                    $eva->save();
                }
            return redirect("/viewEvaluateHouseKeeping");
        }

        $data = array('evas' => $evaluation);
        return view('EvaluateHouseKeeping.create',$data);
    }
}
