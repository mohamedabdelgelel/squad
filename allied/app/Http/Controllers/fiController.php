<?php

namespace App\Http\Controllers;

use App\laundry_camp;
use App\laundry_booking;
use App\house_keeping;
use App\booking_extra;
use App\ingredient;
use App\fi;
use Illuminate\Http\Request;

class fiController extends Controller
{
    public function view()
    {
        $laundryCamp =laundry_camp::all();
        $hk =house_keeping::all();
        $ing =ingredient::all();
        $data =array('laundryCamp'=>$laundryCamp,'hk'=>$hk,'ing'=>$ing);
        return view('fi.view',$data);
    }
    public function viewAll()
    {
        $fi =fi::all();
        $laundryBooking =laundry_booking::all();
        $BookingExtra =booking_extra::all();
        //$hk =house_keeping::all();
        $data =array('laundryBooking'=>$laundryBooking,'BookingExtra'=>$BookingExtra,'fi'=>$fi);
        return view('fi.viewAll',$data);
    }
}
