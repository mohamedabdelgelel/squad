<?php

namespace App\Http\Controllers;

use App\payment;
use App\expenses;
use App\out_source;
use Illuminate\Http\Request;

class paymentController extends Controller
{
    public function view()
    {
        $pay=payment::all();

        $data =array('pay'=>$pay);
        return view('payments.view',$data);

    }
    public function create(Request $request)
    {
        $expenses =expenses::all();
        $out =out_source::all();
        // $data =array();
        if($request->isMethod('post'))
        {
            $pay=new payment();
            $pay->date=$request->input('date');
            $pay->cost=$request->input('cost');
            $pay->type=$request->input('type');
            $pay->expenses_id=$request->input('expenses');
            $pay->out_source_id=$request->input('out');

            $pay->save();
            return redirect("/viewPayments");
        }
        $data=array('out'=>$out,'expenses'=>$expenses);
        return view('payments.create',$data);
    }
    public function update($id,Request $request)
    {

        $pay= payment::find($id);
        if($request->isMethod('post'))
        {
            $pay->date=$request->input('date');
            $pay->cost=$request->input('cost');
            $pay->type=$request->input('type');

            $pay->save();

            return redirect("/viewPayments");
        }
        $data=array('pay'=>$pay);
        return view('payments.update',$data);
    }
    public function delete($id){
        $pay=payment::find($id);
        $pay::where ('id',@$id)->delete();
        return redirect("/viewPayments");
    }
}
