<?php

namespace App\Http\Controllers;

//use App\meal;
use App\ingredient;
use App\meal;
use App\meal_ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class mealsIngredientsController extends Controller
{

    public function view($id)
    {
        $meal=meal::find($id);
        $ingredient =ingredient::all();
        $data =array('ingredient'=>$ingredient,'meal'=>$meal);
        return view('mealsIngredient.create',$data);
    }

    public function create($id,Request $request)
    {
        $meal=meal::find($id);
        $data=array('meal'=>$meal);
        if ($request->isMethod('post'))
        {
            $ingredient_meal = new meal_ingredient();
            $ingredient_meal->quantity = $request->input("quantity");
            $ingredient_meal->meal_id = $id;
            $ingredient_meal->ingredient_id = $request->input("name");;

            $ingredient_meal->save();
            return redirect("/viewMeals");
        }
       return view('mealsIngredient.create',$data);
    }
}
