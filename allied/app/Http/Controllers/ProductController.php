<?php

namespace App\Http\Controllers;
use App\Brand;
use App\Color;
use App\Product;
use App\Size;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function viewProduct(){
        $product = Product::all();
        $arr = Array('product'=>$product);
        return view("Product.view",$arr);
    }


    public function addProduct(){
        $colors = Color::all();
        $brands = Brand::all();
        $sizes = Size::all();

        return view('Product.add',compact('colors','brands','sizes'));
    }


    public function addProductpost(Request $request){

        if($request->isMethod('post')){

            $newProduct = new Product();
            $newProduct->name = $request->name;
            $newProduct->save();
            return redirect("ViewProduct");
        }
        return view('Product.add');
    }

    public function editProduct(Request $request, $id){

        if($request->isMethod('post')){
            $newProduct=Size::find($id);
            $newProduct->name = $request->name;
            $newProduct->save();
            return redirect("ViewProduct");
        }
        else{
            $product=Product::find($id);
            $arr = Array('product'=>$product);
            return view("Product.edit",$arr);
            return view('Product.edit');
        }

    }

}
