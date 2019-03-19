<?php

namespace App\Http\Controllers;

use App\banks;
use Illuminate\Http\Request;

class bankController extends Controller
{
    public function view()
    {
        $bank = banks::all();
        $data = array('bank' => $bank);
        return view('bank.view', $data);
    }
    public function create(Request $request)
    {
        if($request->isMethod('post'))
        {
            $bank=new banks();
            $bank->name=$request->input("name");
            $bank->account_number=$request->input("account_number");
            $bank->kind_of_money=$request->input("kind_of_money");
            $bank->kind_of_account=$request->input("kind_of_account");
            $bank->bank_address=$request->input("bank_address");

            $bank->save();


            return redirect("/viewBank");
        }

        return view('bank.create');
    }
    public function update($id,Request $request)
    {
        $bank= banks::find($id);
        if($request->isMethod('post'))
        {
            $bank->name=$request->input("name");
            $bank->account_number=$request->input("account_number");
            $bank->kind_of_money=$request->input("kind_of_money");
            $bank->kind_of_account=$request->input("kind_of_account");
            $bank->bank_address=$request->input("bank_address");

            $bank->save();

            return redirect("/viewBank");
        }
        $data=array('bank'=>$bank);
        return view('bank.update',$data);
    }
    public function delete($id){
        $bank=banks::find($id);
        $bank::where ('id',@$id)->delete();
        return redirect("/viewBank");
    }

}
