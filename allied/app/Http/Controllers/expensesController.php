<?php

namespace App\Http\Controllers;

use App\expenses;
use Illuminate\Http\Request;

class expensesController extends Controller
{
    public function view()
    {
        $expenses = expenses::all();
        $data = array('expenses' =>  $expenses);
        return view('expenses.view', $data);
    }
    public function create(Request $request)
    {
        if($request->isMethod('post'))
        {
            $expenses=new expenses();
            $expenses->name=$request->input("name");
            $expenses->save();


            return redirect("/viewExpenses");
        }

        return view('expenses.create');
    }
    public function update($id,Request $request)
    {
        $expenses= expenses::find($id);
        if($request->isMethod('post'))
        {
            $expenses->name= $request->input("name");

            $expenses->save();

            return redirect("/viewExpenses");
        }
        $data=array('expenses'=>$expenses);
        return view('expenses.update',$data);
    }
    public function delete($id){
        $expenses=expenses::find($id);
        $expenses::where ('id',@$id)->delete();
        return redirect("/viewExpenses");
    }

}
