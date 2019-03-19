<?php

namespace App\Http\Controllers;

use App\classes;
use Illuminate\Http\Request;

class classController extends Controller
{
    public function view()
    {
        $unit = classes::all();
        $data = array('unit' => $unit);
        return view('classes.view', $data);
    }
    public function create(Request $request)
    {
        if($request->isMethod('post'))
        {
            $unit=new classes();
            $unit->name=$request->input("name");
            $unit->save();
            return redirect("/viewClasses");
        }
        return view('classes.create');
    }
     public function delete($id){

       $unit=classes::find($id);
        $unit::where ('id',@$id)->delete();

        return redirect("/viewClasses");

    }
    
}
