<?php

namespace App\Http\Controllers;
use App\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function viewTypeOfInventory(){
        $typeOfInventory = Type::all();
        $arr = Array('typeOfInventory'=>$typeOfInventory);
        return view("Type.view",$arr);
    }

    public function addTypeOfInventory(Request $request){

        if($request->isMethod('post')){
            $newTypeOfInventory = new Type();
            $newTypeOfInventory->name = $request->input('name');
            $newTypeOfInventory->save();
            return redirect("viewTypeOfInventory");
        }
        return view('Type.add');
    }

    public function editTypeOfInventory(Request $request, $id){

        if($request->isMethod('post')){
            $newTypeOfInventory=Type::find($id);
            $newTypeOfInventory->name = $request->input('name');
            $newTypeOfInventory->save();
            return redirect("viewTypeOfInventory");
        }
        else{
            $TypeOfInventory=Type::find($id);
            $arr = Array('TypeOfInventory'=>$TypeOfInventory);
            return view("Type.edit",$arr);
            return view('Type.edit');
        }

    }

    public function deleteType(Request $request,$id){
        $Type=Type::find($id);
        $Type->delete();
        return redirect("viewTypeOfInventory");
    }
}
