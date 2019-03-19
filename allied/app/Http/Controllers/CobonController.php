<?php

namespace App\Http\Controllers;

use App\Cobon;
use Illuminate\Http\Request;

class CobonController extends Controller
{
    public function view()
    {
        $cobon = Cobon::all();
        $data = array('cobon' => $cobon);
        return view('Cobon.view', $data);
    }
    public function create(Request $request)
    {
        if($request->isMethod('post'))
        {
            $cobon=new Cobon();
            $cobon->number=$request->input("number");
            $cobon->name=$request->input("name");
            $cobon->discount=$request->input("discount");

            $cobon->type=$request->input("type");
            $cobon->expired=$request->input("expired");
            $cobon->time_of_use=$request->input("time_of_use");
            $cobon->save();


            return redirect("/viewCobon");
        }

        return view('Cobon.create');
    }
    public function update($id,Request $request)
    {
        $cobon= Cobon::find($id);
        if($request->isMethod('post'))
        {
            $cobon->number=$request->input("number");
            $cobon->name= $request->input("name");
            $cobon->type = $request->input("type");
            $cobon->expired = $request->input("expired");
            $cobon->time_of_use = $request->input("time_of_use");
            $cobon->save();

            return redirect("/viewCobon");
        }
        $data=array('cobon'=>$cobon);
        return view('Cobon.update',$data);
    }
    public function delete($id){
        $cobon=Cobon::find($id);
        $cobon::where ('id',@$id)->delete();
        return redirect("/viewCobon");
    }

    public function details($id)
    {
        $cobon= Cobon::find($id);
        $data = array('cobon' => $cobon);
        return view('Cobon.details', $data);
    }
}
