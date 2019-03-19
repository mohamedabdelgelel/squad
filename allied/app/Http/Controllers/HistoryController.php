<?php

namespace App\Http\Controllers;
use App\Brand;
use App\Color;
use App\History;
use App\Product;
use App\Size;
use App\Supplier;
use App\Inventory;
use App\financial;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function viewHistory(){
        $history = History::all();
        $arr = Array('history'=>$history);
        return view("History.view",$arr);
    }
    public function addHistory(){
        $products = Product::all();
        $brands = Brand::all();
        $colors = Color::all();
        $sizes = Size::all();
        $suppliers = Supplier::all();


        return view('History.add',compact('products', 'brands','colors','sizes','suppliers'));
    }

    public function addHistorypost(Request $request){

        $newHistory = new History();
        $product = Product::find($request->name);
        $newHistory->name = $product->name;
        $newHistory->type = $request->type;
        $newHistory->barcode = $request->barcode;
        $newHistory->quantity = $request->quantity;
        $newHistory->price = $request->price;
        $newHistory->sales_price = $request->sales_price;
        $newHistory->bullets = $request->bullets;
        $newHistory->kilo_or_numbers = $request->kilo_or_numbers;
        $newHistory->color_id = $request->color_id;
        $newHistory->brand_id = $request->brand_id;
        $newHistory->size_id = $request->size_id;
        $newHistory->supplier_id = $request->supplier_id;
        $newHistory->check = 0;
        $newHistory->date = date('Y-m-d');;
        $newHistory->save();

        $inventorys = Inventory::all();
        $check = 0;
        foreach ($inventorys as $in){
            if($in->name == $request->name && $in->color_id == $request->color_id && $in->size_id == $request->size_id&& $in->brand_id == $request->brand_id){
                $newInventory=Inventory::find($in->id);
                $product = Product::find($request->name);
                $newInventory->name = $product->name;
                $newInventory->type = $in->type;
                $newInventory->barcode = $in->barcode;
                $newInventory->quantity = (($request->quantity) + $in->quantity);
                if($request->kilo_or_numbers == 'kilo')
                    $newInventory->equivalent = (($request->quantity)*1000) + $in->equivalent;
                $newInventory->price = $request->price;
                $newInventory->sales_price = $request->sales_price;
                $newInventory->bullets = $request->bullets;
                $newInventory->kilo_or_numbers = $request->kilo_or_numbers;
                $newInventory->print_of_return = $request->print_of_return;
                $newInventory->color_id = $request->color_id;
                $newInventory->brand_id = $request->brand_id;
                $newInventory->size_id = $request->size_id;
                $newInventory->date = date('Y-m-d');
                $newInventory->save();
                $check++;
            }
        }
        if($check == 0){
            $newInventory = new Inventory();
$product = Product::find($request->name);
                $newInventory->name = $product->name;
                            $newInventory->type = $request->type;
            $newInventory->barcode = $request->barcode;
            $newInventory->quantity = $request->quantity;
            if($request->kilo_or_numbers == 'kilo')
                $newInventory->equivalent = ($request->quantity)*1000;
            $newInventory->price = $request->price;
            $newInventory->sales_price = $request->sales_price;
            $newInventory->bullets = $request->bullets;
            $newInventory->kilo_or_numbers = $request->kilo_or_numbers;
            $newInventory->print_of_return = $request->print_of_return;

            $newInventory->color_id = $request->color_id;
            $newInventory->brand_id = $request->brand_id;
            $newInventory->size_id = $request->size_id;
            $newInventory->date = date('Y-m-d');
            $newInventory->save();
        }

       /* $f = new financial();
        $f->shop_booking_id = $newHistory->id;
        $f->cost = $newHistory->price;
        $f->type = '2';
        $f->date = $newHistory->date;
        $f->save();
*/
        session()->flash('success', '¡Registro exitoso!');
        session()->flash('success', 'Ooops! Algo salio mal :(');

        return redirect("/ViewHistory");

    }

    public function editHistory(Request $request, $id){

        if($request->isMethod('post')){
            $newHistory=History::find($id);
            $newHistory->name = $request->name;
            $newHistory->type = $request->type;
            $newHistory->barcode = $request->barcode;
            $newHistory->quantity = $request->quantity;
            $newHistory->price = $request->price;
            $newHistory->sales_price = $request->sales_price;
            $newHistory->bullets = $request->bullets;
            $newHistory->kilo_or_numbers = $request->kilo_or_numbers;
            $newHistory->save();
            return redirect("ViewHistory");

        }
        else{
            $history=History::find($id);
            $arr = Array('history'=>$history);
            return view("History.edit",$arr);

            return view('History.edit');
        }

    }
   public function create()
    {
        $colorList = \DB::table('Colors')->pluck('name','id');
        $colorList = ['0' => 'Select Your Color']+ collect($colorList)->toArray();
        return view('History.add')->with('colorList',$colorList);
    }
}
