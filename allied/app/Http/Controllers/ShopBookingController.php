<?php

namespace App\Http\Controllers;
use App\History;
use App\Inventory;
use App\ShopBooking;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

class ShopBookingController extends Controller
{
    public function viewShopBooking(){
        $inventory = Inventory::all();
        $arr = Array('inventory'=>$inventory);
        return view("Shop.view",$arr);
    }
    public function viewShopBookingSale(){
        $shopBooking = ShopBooking::all();
        $arr = Array('shopBooking'=>$shopBooking);
        return view("Shop.viewBooking",$arr);
    }

    public function searchShop(Request $request){

        if($request->isMethod('post'))
        {
            $q = Input::get ( 'q' );
             $q1 = Input::get ( 'q1' );
             $user = ShopBooking::whereBetween('date', [$q, $q1])->get();
             if(count($user) > 0)
                 return view('Shop.search')->withDetails($user)->withQuery ( $q , $q1);
             else return view ('Shop.search')->withMessage('No Details found. Try to search again !');
        }
            return view("/Shop.search");
    }
    public function searchIncoming(Request $request){

        if($request->isMethod('post'))
        {
            $q = Input::get ( 'q' );
            $q1 = Input::get ( 'q1' );
            $user = History::whereBetween('date', [$q, $q1])->where('type','Shop')->get();
            if(count($user) > 0)
                return view('Shop.searchIncoming')->withDetails($user)->withQuery ( $q , $q1);
            else return view ('Shop.searchIncoming')->withMessage('No Details found. Try to search again !');
        }
        return view("/Shop.searchIncoming");
    }

}
