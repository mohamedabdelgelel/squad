<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\room;
use App\floor;
use App\price;
use App\rewards;

use App\referral_bullets;

class RewardController extends Controller
{
    //

  
    public function viewReferral()
    {
        $referral = referral_bullets::first();
        $data = array('referral' => $referral);
        return view('rewards.viewReferral', $data);
   }
    
     public function updateReferral($id,Request $request)
    {
        if($request->isMethod('post'))
        {
       $price= referral_bullets::find($id);

          
            $price->perecentage=$request->input("perecentage");



            $price->save();


            return redirect("/viewReferral");
        }
      //  $floors=floor::all();
    }
   public function viewDiscount()
    {
        $discount = rewards::first();
        $data = array('discount' => $discount);
        return view('rewards.viewDiscount', $data);
   }
    
     public function updateDiscount($id,Request $request)
    {
        if($request->isMethod('post'))
        {
       $price= rewards::find($id);

          
            $price->discount_egp=$request->input("discount_egp");
            $price->discount_bullets=$request->input("discount_bullets");



            $price->save();


            return redirect("/viewDiscount");
        }
      //  $floors=floor::all();
    }
    public function viewCashback()
    {
        $cash = rewards::first();
        $data = array('cash' => $cash);
        return view('rewards.viewCashback', $data);
   }
    
     public function updateCashback($id,Request $request)
    {
        if($request->isMethod('post'))
        {
       $price= rewards::find($id);

           $price->cashback_egp=$request->input("cashback_egp");
            $price->cashback_bullets=$request->input("cashback_bullets");



            $price->save();


            return redirect("/viewCashback");
        }
      //  $floors=floor::all();
    }
    public function viewExtra()
    {
        $extra = rewards::first();
        $data = array('extra' => $extra);
        return view('rewards.viewExtra', $data);
   }
    
     public function updateExtra($id,Request $request)
    {
        if($request->isMethod('post'))
        {
       $price= rewards::find($id);

          
            $price->extra_bullets=$request->input("extra_bullets");



            $price->save();


            return redirect("/viewExtrabullets");
        }
      //  $floors=floor::all();
    }
    public function viewExercise()
    {
        $exercise = rewards::first();
        $data = array('exercise' => $exercise);
        return view('rewards.viewExercise', $data);
   }
    
     public function updateExercise($id,Request $request)
    {
        if($request->isMethod('post'))
        {
       $price= rewards::find($id);

          
            $price->exercise_bullets=$request->input("exercise_bullets");



            $price->save();


            return redirect("/viewExercisebullets");
        }
      //  $floors=floor::all();
    }
}
