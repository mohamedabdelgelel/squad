<?php

namespace App\Http\Controllers;

use App\out_source;
use Illuminate\Http\Request;

class outSourceController extends Controller
{
    public function view()
    {
        $out = out_source::all();
        $data = array('out' => $out);
        return view('outSource.view', $data);
    }
    public function create(Request $request)
    {
        if($request->isMethod('post'))
        {
            $out=new out_source();
            $out->name=$request->input("name");
            $out->address=$request->input("address");
            $out->mobile=$request->input("mobile");
            $out->commercial_register=$request->input("commercial_register");
            $out->tax_register=$request->input("tax_register");
            $out->responsible=$request->input("responsible");
            $out->responsible_number=$request->input("responsible_number");
            $out->mail=$request->input("mail");
            $out->save();


            return redirect("/viewOutSource");
        }

        return view('outSource.create');
    }
    public function update($id,Request $request)
    {
        $out= out_source::find($id);
        if($request->isMethod('post'))
        {
            $out->name=$request->input("name");
            $out->address=$request->input("address");
            $out->mobile=$request->input("mobile");
            $out->commercial_register=$request->input("commercial_register");
            $out->tax_register=$request->input("tax_register");
            $out->responsible=$request->input("responsible");
            $out->responsible_number=$request->input("responsible_number");
            $out->mail=$request->input("mail");
            $out->save();

            return redirect("/viewOutSource");
        }
        $data=array('out'=>$out);
        return view('outSource.update',$data);
    }
    public function delete($id){
        $out=out_source::find($id);
        $out::where ('id',@$id)->delete();
        return redirect("/viewOutSource");
    }

}
