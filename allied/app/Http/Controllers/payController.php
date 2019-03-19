<?php

namespace App\Http\Controllers;

use App\financial;
use App\fi;
use Illuminate\Http\Request;

class payController extends Controller
{
    public function view(Request $request)
    {
       // $bookings=null;
        $pay=null;
        if ($request->isMethod('post')) {
            //  $user = User::find(Auth::id());

            $start = $request->input("start");
            $end = $request->input("end");

            $pay = financial::where("date",">=",$start)->where("date","<=",$end)->get()->where("type","=","1");

          /*  foreach ($pay as $pay) {
                $booking->from = date("d-m-Y", strtotime($booking->from));
                $booking->to = date("d-m-Y", strtotime($booking->to));
                $booking->user->age = date("d-m-Y", strtotime($booking->user->age));*/
            }
        $data = array('pay' => $pay);
        return view('money.view',$data);
        }

        // $data = array('bookings' => $bookings);
    public function viewRev(Request $request)
    {
        $fi =fi::all();
        // $bookings=null;
        $pay=null;
        if ($request->isMethod('post')) {
            //  $user = User::find(Auth::id());

            $start = $request->input("start");
            $end = $request->input("end");

            $pay = financial::where("date",">=",$start)->where("date","<=",$end)->get()->where("type","=","2");

            /*  foreach ($pay as $pay) {
                  $booking->from = date("d-m-Y", strtotime($booking->from));
                  $booking->to = date("d-m-Y", strtotime($booking->to));
                  $booking->user->age = date("d-m-Y", strtotime($booking->user->age));*/
        }
        $data = array('pay' => $pay,'fi'=>$fi);
        return view('money.viewRevMoney',$data);
    }
    public function viewIng(Request $request)
    {
        // $bookings=null;
        $pay=null;
        if ($request->isMethod('post')) {
            //  $user = User::find(Auth::id());

            $start = $request->input("start");
            $end = $request->input("end");

            $pay = financial::where("date",">=",$start)->where("date","<=",$end)->get()->where("type","=","1");

            /*  foreach ($pay as $pay) {
                  $booking->from = date("d-m-Y", strtotime($booking->from));
                  $booking->to = date("d-m-Y", strtotime($booking->to));
                  $booking->user->age = date("d-m-Y", strtotime($booking->user->age));*/
        }
        $data = array('pay' => $pay);
        return view('money.viewIngMoney',$data);
    }
    public function viewCamp(Request $request)
    {
        // $bookings=null;
        $pay=null;
        if ($request->isMethod('post')) {
            //  $user = User::find(Auth::id());

            $start = $request->input("start");
            $end = $request->input("end");

            $pay = financial::where("date",">=",$start)->where("date","<=",$end)->get()->where("type","=","1");

            /*  foreach ($pay as $pay) {
                  $booking->from = date("d-m-Y", strtotime($booking->from));
                  $booking->to = date("d-m-Y", strtotime($booking->to));
                  $booking->user->age = date("d-m-Y", strtotime($booking->user->age));*/
        }
        $data = array('pay' => $pay);
        return view('money.viewCampMoney',$data);
    }
    public function viewSpa(Request $request)
    {
        $fi =fi::all();
        // $bookings=null;
        $pay=null;
        if ($request->isMethod('post')) {
            //  $user = User::find(Auth::id());

            $start = $request->input("start");
            $end = $request->input("end");

            $pay = financial::where("date",">=",$start)->where("date","<=",$end)->get()->where("type","=","2");

            /*  foreach ($pay as $pay) {
                  $booking->from = date("d-m-Y", strtotime($booking->from));
                  $booking->to = date("d-m-Y", strtotime($booking->to));
                  $booking->user->age = date("d-m-Y", strtotime($booking->user->age));*/
        }
        $data = array('pay' => $pay,'fi'=>$fi);
        return view('money.viewSpaMoney',$data);
    }
    public function viewLan(Request $request)
    {
        // $bookings=null;
        $fi =fi::all();
        $pay=null;
        if ($request->isMethod('post')) {
            //  $user = User::find(Auth::id());

            $start = $request->input("start");
            $end = $request->input("end");

            $pay = financial::where("date",">=",$start)->where("date","<=",$end)->get()->where("type","=","2");

            /*  foreach ($pay as $pay) {
                  $booking->from = date("d-m-Y", strtotime($booking->from));
                  $booking->to = date("d-m-Y", strtotime($booking->to));
                  $booking->user->age = date("d-m-Y", strtotime($booking->user->age));*/
        }
        $data = array('pay' => $pay,'fi'=>$fi);
        return view('money.viewLanMoney',$data);
    }
       public function viewBook(Request $request)
    {
        // $bookings=null;
        $fi =fi::all();
        $pay=null;
        if ($request->isMethod('post')) {
            //  $user = User::find(Auth::id());
            $start = $request->input("start");
            $end = $request->input("end");

            $pay = financial::where("date",">=",$start)->where("date","<=",$end)->get()->where("type","=","2");
            /*  foreach ($pay as $pay) {
                  $booking->from = date("d-m-Y", strtotime($booking->from));
                  $booking->to = date("d-m-Y", strtotime($booking->to));
                  $booking->user->age = date("d-m-Y", strtotime($booking->user->age));*/
        }
        $data = array('pay' => $pay,'fi'=>$fi);
        return view('money.viewBookMoney',$data);
    }
       public function viewMain(Request $request)
    {
        // $bookings=null;
        $pay=null;
        if ($request->isMethod('post')) {
            //  $user = User::find(Auth::id());

            $start = $request->input("start");
            $end = $request->input("end");

            $pay = financial::where("date",">=",$start)->where("date","<=",$end)->get()->where("type","=","1");

            /*  foreach ($pay as $pay) {
                  $booking->from = date("d-m-Y", strtotime($booking->from));
                  $booking->to = date("d-m-Y", strtotime($booking->to));
                  $booking->user->age = date("d-m-Y", strtotime($booking->user->age));*/
        }
        $data = array('pay' => $pay);
        return view('money.viewMainMoney',$data);
    }
}

