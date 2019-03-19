<?php

namespace App\Http\Controllers;
use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function viewCategory(){
        $category = Category::all();
        $arr = Array('category'=>$category);
        return view("Category.view",$arr);
    }

    public function addCategory(Request $request){

        if($request->isMethod('post')){
           	$newCategory = new Category();
            $newCategory->name = $request->input('name');
            $newCategory->save();
            return redirect("viewCategory");
        }
        return view('Category.add');
    }

    public function editCategory(Request $request, $id){

        if($request->isMethod('post')){
            $newCategory=Category::find($id);
            $newCategory->name = $request->input('name');
            $newCategory->save();
            return redirect("viewCategory");
        }
        else{
            $category=Category::find($id);
            $arr = Array('category'=>$category);
            return view("Category.edit",$arr);
        }

    }
    public function deleteCategory(Request $request,$id){
    	$category=Category::find($id);
	    $category->delete();
	    return redirect("viewCategory");
    }

}
