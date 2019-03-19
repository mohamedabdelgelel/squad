<?php

namespace App\Http\Controllers;
use App\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function viewBrand(){
        $brand = Brand::all();
        $arr = Array('brand'=>$brand);
        return view("Brand.view",$arr);
    }

    public function addBrand(Request $request){

        if($request->isMethod('post')){
            $this->validate($request,[
                'name' => 'required|max:25|unique:brands'
            ]);
            $newBrand = new Brand();
            $newBrand->name = $request->input('name');
            $newBrand->save();
            return redirect("ViewBrand");
        }
        return view('Brand.add');
    }

    public function editBrand(Request $request, $id){

        if($request->isMethod('post')){
            $newBrand=Brand::find($id);
            $newBrand->name = $request->input('name');
            $newBrand->save();
            return redirect("ViewBrand");
        }
        else{
            $brand=Brand::find($id);
            $arr = Array('brand'=>$brand);
            return view("Brand.edit",$arr);
            return view('Brand.edit');
        }

    }
}
