<?php

namespace App\Http\Controllers;
use App\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function viewCurrency(){
        $currency = Currency::all();
        $arr = Array('currency'=>$currency);
        return view("Currency.view",$arr);
    }

    public function addCurrency(Request $request){

        if($request->isMethod('post')){
            $newcurrency = new Currency();
            $newcurrency->name = $request->input('name');
            $newcurrency->equivelant_egp = $request->input('equivelant_egp');
            $newcurrency->equivelant_dollar = $request->input('equivelant_dollar');
            $newcurrency->save();
            return redirect("viewCurrency");
        }
        return view('Currency.add');
    }

    public function editCurrency(Request $request, $id){

        if($request->isMethod('post')){
            $newcurrency=Currency::find($id);
            $newcurrency->name = $request->input('name');
            $newcurrency->equivelant_egp = $request->input('equivelant_egp');
            $newcurrency->equivelant_dollar = $request->input('equivelant_dollar');
            $newcurrency->save();
            return redirect("viewCurrency");
        }
        else{
            $currency=Currency::find($id);
            $arr = Array('currency'=>$currency);
            return view("Currency.edit",$arr);
        }

    }
    public function deleteCurrency(Request $request,$id){
        $currency=Currency::find($id);
        $currency->delete();
        return redirect("viewCurrency");
    }

}

