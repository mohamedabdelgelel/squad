<?php



namespace App\Http\Controllers;



use App\ingredient;

use App\financial;

use App\classes;

use Carbon\Carbon;

use App\unit;
use App\Inventory;


use Illuminate\Http\Request;

//use App\supplier;



class ingredientController extends Controller

{

    public function view()

    {

        $ingredient = ingredient::all();

        $data = array('ingredient' => $ingredient);

        return view('ingredient.view', $data);

    }

    public function create(Request $request)

    {

      // $supplier=supplier::all();

        $unit=unit::all();
        $inventories=Inventory::where('type','=','Food and Beverage')->get();
              $category=classes::all();
        if($request->isMethod('post'))

        {

            $ingredient=new ingredient();

            $fin=new financial();

            $ingredient->inventory_id=$request->input("name");

              $ingredient->classes_id=$request->input("category");

            $ingredient->calories=$request->input("calories");

            $ingredient->carbo=$request->input("carbo");

            $ingredient->proten=$request->input("proten");

            $ingredient->quantity=$request->input("quantity");

            $ingredient->cost=$request->input("cost");

            $ingredient->sugar=$request->input("sugar");

            $ingredient->fats=$request->input("fats");

            $ingredient->spicy=$request->input("spicy");

            $ingredient->gluten=$request->input("gluten");

            $ingredient->dariy=$request->input("dariy");

            $ingredient->type=$request->input("type");

            $ingredient->unit_id=$request->input("unit");

            $ingredient->save();

            $fin->type='1';

            $current_time = Carbon::now()->toDateTimeString();

            $fin->date=$current_time;

            $fin->cost=$request->input("quantity")*$request->input("cost");

            $fin->ingredient_id=$ingredient->id;

            $fin->save();



            return redirect("/viewIngredient");

        }

        $data=array('unit'=>$unit,'inventories'=>$inventories,'categorys'=>$category);

        return view('ingredient.create',$data);

    }

    public function update($id,Request $request)

    {

        $ingredient= ingredient::find($id);

        $unit=unit::all();
                $inventories=Inventory::where('type','=','Food and Beverage')->get();

              

        if($request->isMethod('post'))

        {

            $ingredient->inventory_id=$request->input("name");

      

            $ingredient->calories=$request->input("calories");

            $ingredient->carbo=$request->input("carbo");

            $ingredient->proten=$request->input("proten");

            $ingredient->quantity=$request->input("quantity");

            $ingredient->cost=$request->input("cost");

            $ingredient->sugar=$request->input("sugar");

            $ingredient->fats=$request->input("fats");

            $ingredient->spicy=$request->input("spicy");

            $ingredient->gluten=$request->input("gluten");

            $ingredient->dariy=$request->input("dariy");

            $ingredient->type=$request->input("type");

            //$ingredient->unit_id=$request->input("unit");

            $ingredient->save();



            return redirect("/viewIngredient");

        }

        $data=array('ingredient'=>$ingredient,'units'=>$unit,'inventories'=>$inventories);

        return view('ingredient.update',$data);

    }

    public function delete($id){

       $ingredient=ingredient::find($id);

        $ingredient::where ('id',@$id)->delete();

        return redirect("/viewIngredient");

    }

    public function details($id)

    {

        $ingredient= ingredient::find($id);

        $data = array('ingredient' => $ingredient);

        return view('ingredient.details', $data);

    }

}

