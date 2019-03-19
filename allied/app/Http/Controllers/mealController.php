<?php

namespace App\Http\Controllers;

 use App\meal;
 use Carbon\Carbon;
use App\meal_book;
 use Storage;
 use App\ingredient;
use App\meal_ing;

 use Illuminate\Http\Request;

class mealController extends Controller
{
    public function view()
    {
        $meals = meal::all();
        //  $meal_ing=meal_ing::all();
        $data = array('meals' => $meals);
        return view('meals.view', $data);
    }

    public function create(Request $request)
    {
        $ing = ingredient::where('type', '=', '1')->get();
        $drs = ingredient::where('type', '=', '2')->get();
        $ger = ingredient::where('type', '=', '3')->get();
        if ($request->isMethod('post')) {
            $meal = new meal();
         
            $meal->name = $request->input("name");
            $meal->serving_size = $request->input("serving_size");
            $meal->method = $request->input("method");
            $meal->note = $request->input("note");
           $count=$request->input("number-ingrediants");
            $countDres=$request->input("number-dressing");
             $countGernsh=$request->input("number-gernish");
               $date=Carbon::now()->micro;
           if(!empty($request->file('image')))
             {
                 $request->file('image')->storeAs(
                     'public/foodImages', $date.'.jpg'
                 );
                 $meal->photo=$date.'.jpg';
             }

            $meal->save();
            for ($i=1; $i <=$count ; $i++) { 
                 if ($request->input('ing'.$i) != "") {
                $meal_ing = new meal_ing();
                $meal_ing->meal_id = $meal->id;

                $meal_ing->ingredient_id = $request->input('ing'.$i);
                $meal_ing->quantity = $request->input('quantity'.$i);
                $meal_ing->save();

               }
            }

        for ($i=1; $i <=$countDres ; $i++) { 
                 if ($request->input('dres'.$i) != "") {
                $meal_ing = new meal_ing();
                $meal_ing->meal_id = $meal->id;
                $meal_ing->ingredient_id = $request->input('dres'.$i);
                $meal_ing->quantity = $request->input('q'.$i);
                $meal_ing->save();

               }
            }

             for ($i=1; $i <=$countGernsh ; $i++) { 
                if ($request->input('ger'.$i) != "") {
                $meal_ing = new meal_ing();
                $meal_ing->meal_id = $meal->id;
                $meal_ing->ingredient_id = $request->input('ger'.$i);
                $meal_ing->save();

               }
            }
            return redirect("/viewMeals");
        }

        $date = array('ings' => $ing, 'drss' => $drs, 'gers' => $ger);
        return view('meals.create', $date);
    }

    public function update($id, Request $request)
    {
        $meal = meal::find($id);
        if ($request->isMethod('post')) {
            $meal->name = $request->input("name");
            $meal->type = $request->input("type");
            $meal->date = $request->input("date");
            $meal->save();

            return redirect("/viewMeals");
        }
        $data = array('meal' => $meal);
        return view('meals.update', $data);
    }

    public function delete($id)
    {
        $meal = meal::find($id);
        $meal::where('id', $id)->delete();
        return redirect("/viewMeals");
    }

    public function viewType($id, Request $request)
    {

        $data = array('type' => $id);

        if ($request->isMethod('post')) {
            $mealb = array();


            $maals = meal::all();
            foreach ($maals as $maal) {
                $m = meal_book::where('type', '=', $id)->where('date', '=', $request->input('day'))->where('meal_id', $maal->id)->first();
                if ($m != null)

                    array_push($mealb, $m);
                $data = array('meals' => $mealb, 'type' => $id);

            }
        }

        return view('meals.breakfast', $data);
    }
     public function viewDetails($id, Request $request)
    {
       // $meals = meal::all();
        $mealing= meal_ing::where('meal_id','=',$id)->get();
        //  $meal_ing=meal_ing::all();
        $data = array('mealing'=>$mealing);
        return view('meals.detailsMeal', $data);
    }
}




