<?php

namespace App\Http\Controllers;
use App\booking;
use App\Inventory;
use App\History;
use App\ShopBooking;
use Illuminate\Http\Request;
use App\meal_book;
use Carbon\Carbon;
 use App\ingredient;
use App\meal_ing;

class InventoryController extends Controller
{
    public function viewInventory(){
        $inventory = Inventory::all();
        $arr = Array('inventory'=>$inventory);
        return view("inventory.view",$arr);
    }
     public function discount($id,$quantity){
        $ingredient=ingredient::find($id);
        $inventory = Inventory::find($ingredient->inventory_id);
        if ($inventory->kilo_or_numbers=='kilo') {
            $inventory->equivalent-=$quantity;
                        $inventory->quantity-=$quantity/1000;
                        $inventory->save();
                        $ingredient->last_subtract=Carbon::now()->format('Y-m-d');
                        $ingredient->save();
                        return redirect('/viewDailyFood');

            # code...
        }
        else
        {
                                    $inventory->quantity-=$quantity;
                                                            $inventory->save();
                               $ingredient->last_subtract=Carbon::now()->format('Y-m-d');
                                            $ingredient->save();
                                                                    return redirect('/viewDailyFood');





        }

        
    } 

     public function viewDailyFood(){
         $meals_booking=meal_book::where("date","=",Carbon::now()->format('Y-m-d'))->get();
      
        $ingredients=ingredient::where("last_subtract","!=",Carbon::now()->format('Y-m-d'))->orwhere('last_subtract',null)->get();
            $quantities=array();

        foreach ($ingredients as $ingredient) {
            $quantity=0;
            # code...
        foreach ($meals_booking as $meal) {

            $meal_ingrediants=$meal->meal->ingredients;
                  foreach ($meal_ingrediants as $meal_ingrediant) {


                    if ($meal_ingrediant->ingredient_id==$ingredient->id) {
                        $quantity+=$meal_ingrediant->quantity;

                        # code...
                    }
}




            # code...
        }
                                array_push($quantities, $quantity);

}

        $data=array('ingredients'=>$ingredients,'quantities'=>$quantities);
        return view("inventory.viewfoods",$data);
    }

    public function editInventory(Request $request, $id){

        if($request->isMethod('post')){
            $newInventory=Inventory::find($id);
            $newInventory->name = $request->name;
            $newInventory->name = $request->barcode;
            $newInventory->name = $request->quantity;
            $newInventory->name = $request->price;
            $newInventory->name = $request->sales_price;
            $newInventory->name = $request->bullets;
            $newInventory->name = $request->print_of_return;
            $newInventory->name = $request->kilo_or_numbers;
            $newInventory->name = $request->kilo_or_numbers;
            $newInventory->color_id = $request->color_id;
            $newInventory->brand_id = $request->brand_id;
            $newInventory->size_id = $request->size_id;
            $newInventory->supplier_id = $request->supplier_id;
            $newInventory->save();
            return redirect("ViewSupplier");
        }
        else{
            $inventory=Inventory::find($id);
            $arr = Array('inventory'=>$inventory);
            return view("inventory.edit",$arr);
            return view('inventory.edit');
        }

    }
    public function takeFromInventory(Request $request, $id){
        $inventory=Inventory::find($id);
        $booking = booking::all();
        return view('inventory.take',compact('inventory', 'booking'));
    }
    public function takeFromInventoryPost(Request $request, $id){

        if($request->isMethod('post')){

            $newInventory=Inventory::find($id);

            $newHistory = new History();
            $newHistory->name = $newInventory->name;
            $newHistory->type = $newInventory->type;
            $newHistory->barcode = $newInventory->barcode;
            $newHistory->quantity = $request->quantity;
            $newHistory->price = $newInventory->price * $request->quantity;
            $newHistory->sales_price = $newInventory->sales_price;
            $newHistory->bullets = $newInventory->bullets * $request->quantity;
            $newHistory->kilo_or_numbers = $newInventory->kilo_or_numbers;
            $newHistory->color_id = $newInventory->color_id;
            $newHistory->brand_id = $newInventory->brand_id;
            $newHistory->size_id = $newInventory->size_id;
            $newHistory->supplier_id = 1000;
            $newHistory->check = 1;
            $newHistory->save();

            $newInventory->quantity = (($newInventory->quantity) - $request->quantity);
            if($request->kilo_or_numbers == 'kilo')
                $newInventory->equivalent = $newInventory->quantity*1000;
            $newInventory->print_of_return = ($newInventory->print_of_return) - $request->quantity;
            $newInventory->save();


            $newShopBooking = new ShopBooking();
            $newShopBooking->price = $newInventory->price;
            $newShopBooking->cost = ($newInventory->price) * ($request->quantity);
            $newShopBooking->quantity = $request->quantity;
            $newShopBooking->booking_id = $request->BookingName;
            $newShopBooking->inventory_id = $newInventory->id;
            $newShopBooking->date = date('Y-m-d');;
            $newShopBooking->save();


            return redirect("ViewInventory");

        }
    }
    public function search(Request $request){

        if($request->isMethod('post'))
        {
            $q = $request->q;
            $q1 = $request->q1;
            $user = History::whereDate('created_at', '=', $q)->where('supplier_id','=',$q1)->get();

            if(count($user) > 0)
                return view('inventory.search')->withDetails($user)->withQuery ( $q , $q1);
            else return view ('inventory.search')->withMessage('No Details found. Try to search again !');
        }
        return view("inventory.search");
    }




}


