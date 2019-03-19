<?php

namespace App\Http\Controllers;

use App\service_type;
use App\laundry;
use Illuminate\Http\Request;

class laundryController extends Controller
{
    public function view()
    {
        $laundry=laundry::all();
        $data=array('laundry'=>$laundry);
        return view('laundry.view',$data);

    }

    public function create(Request $request)
    {
       // $service=service_type::find($id);
        $service =service_type::all();
        $laundry=new laundry();
        if($request->isMethod('post'))
        {
            $laundry->name=$request->input("name");
            $laundry->cost=$request->input("cost");
            $laundry->cost_dollar=$request->input("cost_dollar");
            $laundry->bullets=$request->input("bullets");
            $laundry->type_id=$request->input('service_name');
            $laundry->save();
            return redirect("/viewLaundry");
        }
        $data=array('service'=>$service);
        return view('laundry.create',$data);

    }
    public function update(Request $request,$id)
    {
        $laundry=laundry::find($id);
        if($request->isMethod('post'))
        {
            $laundry->name=$request->input("name");
            $laundry->cost=$request->input("cost");
            $laundry->cost_dollar=$request->input("cost_dollar");
            $laundry->bullets=$request->input("bullets");
           // $laundry->type_id=$request->input('service_name');
            $laundry->save();
            return redirect("/viewLaundry");
        }
        $data=array('laundry'=>$laundry);
        return view('laundry.update',$data);

    }
    public function delete($id){
        $laundry=laundry::find($id);
        $laundry::where ('id',@$id)->delete();
        return redirect("/viewLaundry");
    }
}
