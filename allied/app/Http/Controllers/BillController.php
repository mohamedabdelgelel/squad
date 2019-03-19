<?php

namespace App\Http\Controllers;
use App\Bill;
use App\financial;
use Illuminate\Http\Request;


class BillController extends Controller
{
    public function createBill(Request $request){
        $bills = Bill::all();
        foreach ($bills as $bill){
            if($bill->supplier_id != $request->supplierName && $request->date !=$request->date && $bill->totalCost != $request->totalCost){
                $newBill = new Bill();
                $newBill->supplier_id = $request->supplierName;
                $newBill->date = $request->date;
                $newBill->totalCost = $request->totalCost;
                $newBill->save();
                $message = "The Bill Is Created Successful";

                $f = new financial();
                $f->bill_id = $newBill->id;
                $f->cost = $newBill->totalCost;
                $f->type = '1';
                $f->date = $newBill->date;
                $f->save();

                return view('Inventory.search',['message' => $message] );
            }
        }

        $message = "The Bill Isn't Created !! Because That Bill is been Created Previously";

        return view('Inventory.search',['message' => $message] );
    }
}
