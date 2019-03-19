<?php

namespace App\Http\Controllers;

use App\meal;
use App\meal_ingredient;
//use App\ingredient;
use Illuminate\Http\Request;

class selectedController extends Controller
{
    public function view($id)
    {
       $meal=meal::find($id);
       $mealIngredient=meal_ingredient::all()->where('meal_id',$id);
       //$new=array($mealIngredient->ingredient_id);
       $data =array('meal'=>$meal,'mealIngredient'=>$mealIngredient);
       return view('mealsIngredient.selected',$data);
    }

}
