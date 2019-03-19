<?php

namespace App\Http\Controllers;

use App\revenues;
use Illuminate\Http\Request;

class revenuesController extends Controller
{
    public function view()
    {
        $revenues = revenues::all();
        $data = array('revenues' =>  $revenues);
        return view('revenues.view', $data);
    }
    public function create(Request $request)
    {
        if($request->isMethod('post'))
        {
            $revenues=new revenues();
            $revenues->name=$request->input("name");
            $revenues->save();


            return redirect("/viewRevenues");
        }

        return view('revenues.create');
    }
    public function update($id,Request $request)
    {
        $revenues= revenues::find($id);
        if($request->isMethod('post'))
        {
            $revenues->name= $request->input("name");

            $revenues->save();

            return redirect("/viewRevenues");
        }
        $data=array('revenues'=>$revenues);
        return view('revenues.update',$data);
    }
    public function delete($id){
        $revenues=revenues::find($id);
        $revenues::where ('id',@$id)->delete();
        return redirect("/viewRevenues");
    }

}
