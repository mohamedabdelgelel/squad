<?php

namespace App\Http\Controllers;
use App\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function viewTest(){
        $test = Test::all();
        $arr = Array('test'=>$test);
        return view("Test.view",$arr);
    }

    public function addTest(Request $request){

        if($request->isMethod('post')){
            $newTest = new Test();
            $newTest->name = $request->input('name');
            $newTest->excellant = $request->input('excellant');
            $newTest->good = $request->input('good');
            $newTest->average = $request->input('average');
            $newTest->poor = $request->input('poor');
            $newTest->save();
            return redirect("viewTest");
        }
        return view('Test.add');
    }

    public function editTest(Request $request, $id){

        if($request->isMethod('post')){
            $newTest=Test::find($id);
            $newTest->name = $request->input('name');
            $newTest->excellant = $request->input('excellant');
            $newTest->good = $request->input('good');
            $newTest->average = $request->input('average');
            $newTest->poor = $request->input('poor');
            $newTest->save();
            return redirect("viewTest");
        }
        else{
            $test=Test::find($id);
            $arr = Array('test'=>$test);
            return view("Test.edit",$arr);
        }

    }

    public function deleteTest(Request $request,$id){
        $Test=Test::find($id);
        $Test->delete();
        return redirect("viewTest");
    }
}
