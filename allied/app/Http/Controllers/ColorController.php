<?php

namespace App\Http\Controllers;
use App\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function viewColor(){
        $color = Color::all();
        $arr = Array('color'=>$color);
        return view("Color.view",$arr);
    }

    public function addColor(Request $request){

        if($request->isMethod('post')){
            $this->validate($request,[
                'name' => 'required|max:25|unique:colors'
            ]);
            $newColor = new Color();
            $newColor->name = $request->input('name');
            $newColor->save();
            return redirect("ViewColor");
        }
        return view('Color.add');
    }

    public function editColor(Request $request, $id){

        if($request->isMethod('post')){
            $newColor=Color::find($id);
            $newColor->name = $request->input('name');
            $newColor->save();
            return redirect("ViewColor");
        }
        else{
            $color=Color::find($id);
            $arr = Array('color'=>$color);
            return view("Color.edit",$arr);
            return view('Color.edit');
        }

    }
}
