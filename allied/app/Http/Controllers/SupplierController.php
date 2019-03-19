<?php

namespace App\Http\Controllers;
use App\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function viewSupplier(){
        $supplier = Supplier::all();
        $arr = Array('supplier'=>$supplier);
        return view("Supplier.view",$arr);
    }

    public function addSupplier(Request $request){

        if($request->isMethod('post')){
            $this->validate($request,[
                'name' => 'required|max:25|unique:suppliers'
            ]);
            $newSupplier = new Supplier();
            $newSupplier->name = $request->input('name');
            $newSupplier->address = $request->input('address');
            $newSupplier->phone = $request->input('phone');
            $newSupplier->content_person_name = $request->input('content_person_name');
            $newSupplier->content_person_phone = $request->input('content_person_phone');
            $newSupplier->id_text = $request->input('id_text');
            $newSupplier->vat = $request->input('vat');
            $newSupplier->save();
            return redirect("ViewSupplier");
        }
        return view('Supplier.add');
    }

    public function editSupplier(Request $request, $id){

        if($request->isMethod('post')){
            $newSupplier=Supplier::find($id);
            $newSupplier->name = $request->input('name');
            $newSupplier->address = $request->input('address');
            $newSupplier->phone = $request->input('phone');
            $newSupplier->content_person_name = $request->input('content_person_name');
            $newSupplier->content_person_phone = $request->input('content_person_phone');
            $newSupplier->id_text = $request->input('id_text');
            $newSupplier->vat = $request->input('vat');
            $newSupplier->save();
            return redirect("ViewSupplier");
        }
        else{
            $supplier=Supplier::find($id);
            $arr = Array('supplier'=>$supplier);
            return view("Supplier.edit",$arr);
            return view('Supplier.edit');
        }

    }
}
