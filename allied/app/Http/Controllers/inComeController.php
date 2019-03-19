<?php

namespace App\Http\Controllers;

use App\income;
use App\revenues;
use App\out_source;
use Illuminate\Http\Request;

class inComeController extends Controller
{
    public function view()
    {
        $in=income::all();
        $data =array('in'=>$in);
        return view('income.view',$data);
    }
    public function create(Request $request)
    {
        $revenues =revenues::all();
        $out =out_source::all();
        // $data =array();
        if($request->isMethod('post'))
        {
            $in=new income();
            $in->date=$request->input('date');
            $in->cost=$request->input('cost');
            $in->type=$request->input('type');
            $in->revenues_id=$request->input('revenues');
            $in->out_source_id=$request->input('out');

            $in->save();
            return redirect("/viewIncome");
        }
        $data=array('out'=>$out,'revenues'=>$revenues);
        return view('income.create',$data);
    }
    public function update($id,Request $request)
    {

        $in= income::find($id);
        if($request->isMethod('post'))
        {
            $in->date=$request->input('date');
            $in->cost=$request->input('cost');
            $in->type=$request->input('type');

            $in->save();

            return redirect("/viewIncome");
        }
        $data=array('in'=>$in);
        return view('income.update',$data);
    }
    public function delete($id){
        $in=income::find($id);
        $in::where ('id',@$id)->delete();
        return redirect("/viewIncome");
    }
}
