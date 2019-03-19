<?php

namespace App\Http\Controllers;

use App\booking;
use App\room;
use App\Cobon;
use App\User;
use App\points;
use App\evaluation_trainer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\employee;
use App\banks;
use App\financial;

use App\booking_bank;

use App\evaluation_camp;
use App\settings;
use App\bullets_weight;
use App\price;

class bookingController extends Controller
{
    //
    public function book(Request $request)
    {
        if (Auth::id() == null) {
            return view('ahome');

            //return redirect("/booknow");

        }
        if ($request->isMethod('post')) {


            $_SESSION['program'] = $request->input("people");
            $_SESSION['type'] = $request->input("typestay");

            $_SESSION['room'] = $request->input("room");


            $_SESSION['number'] = $request->input("number");
            if ($_SESSION['type'] == "weekly" && $request->input("number") == null) {
                $message = 'Please Select No.Of Weeks';
                return redirect("/book")->with("message", $message);
            }


            $_SESSION['month'] = $request->input("month");
            // $_SESSION['year']=$request->input("year");
            $month = date("m", strtotime($_SESSION['month']));
            $current = date("m", strtotime(date('Y-m-d H:i:s')));
            $year = date("y", strtotime($_SESSION['month']));
            $currentYear = date("y", strtotime(date('Y-m-d H:i:s')));
            if ($year < $currentYear || ($month < $current && $year == $currentYear)) {
                $message = 'Your Selected "Check-In Month\Year" is Illogical';
                return redirect("/book")->with("message", $message);

            }
            if ($request->input("cobone") != null) {
                $cobone = Cobon::where("number", "=", $request->input("cobone"))->first();
                if ($cobone == null) {
                    $message = "You Entered an Invalid Coupon Code";
                    return redirect("/book")->with("message", $message);


                    //   return redirect("/complete/" . $origin)->with("message", $message);
                } else {
                    if ($cobone->expired != null) {
                        if ($cobone->expired < date("Y-m-d", strtotime(date('Y-m-d')))) {
                            $message = "You Entered an Expired Coupon";
                            return redirect("/book")->with("message", $message);
                        }
                        # code...
                    }

                    if ($cobone->type == "limited") {
                        if ($cobone->time_of_use < 1) {

                            $message = "You Entered a Terminated Coupon";
                            return redirect("/book")->with("message", $message);
                        }


                    }
                    $_SESSION['cobone'] = $cobone->id;
                }


            }


            return redirect("/calendar");
        }
        $month = date("Y-m", strtotime(date('Y-m')));

        $settings = settings::first();
        $data = array('settings' => $settings, 'month' => $month);

        return view('booking.abooking', $data);
    }

    public function book_ar(Request $request)
    {
        if (Auth::id() == null) {
            return view('home');

            //return redirect("/booknow");

        }
        if ($request->isMethod('post')) {


            $_SESSION['program'] = $request->input("people");
            $_SESSION['type'] = $request->input("typestay");

            $_SESSION['room'] = $request->input("room");


            $_SESSION['number'] = $request->input("number");
            if ($_SESSION['type'] == "weekly" && $request->input("number") == null) {
                $message = 'من فضلك اختر عدد الاسابيع ';
                return redirect("/book_ar")->with("message", $message);
            }


            $_SESSION['month'] = $request->input("month");
            // $_SESSION['year']=$request->input("year");
            $month = date("m", strtotime($_SESSION['month']));
            $current = date("m", strtotime(date('Y-m-d H:i:s')));
            $year = date("y", strtotime($_SESSION['month']));
            $currentYear = date("y", strtotime(date('Y-m-d H:i:s')));
            if ($year < $currentYear || ($month < $current && $year == $currentYear)) {
                $message = 'الحجز الذي قمت  به في خلال  هذا الشهر \ السنة غير منطقي';
                return redirect("/book_ar")->with("message", $message);

            }
            if ($request->input("cobone") != null) {
                $cobone = Cobon::where("number", "=", $request->input("cobone"))->first();
                if ($cobone == null) {
                    $message = "لقد قمت بادخال رقم كوبون غير صحيح ";
                    return redirect("/book_ar")->with("message", $message);


                    //   return redirect("/complete/" . $origin)->with("message", $message);
                }
                else {
                    if ($cobone->expired != null) {
                        if ($cobone->expired < date("Y-m-d", strtotime(date('Y-m-d')))) {
                            $message = "لقد ادخلت كوبون منتهي الصلاحية";
                            return redirect("/book_ar")->with("message", $message);
                        }
                        # code...
                    }

                    if ($cobone->type == "limited") {
                        if ($cobone->time_of_use < 1) {

                            $message = "لقد ادخلت كوبون  منتهي الاستخدام";
                            return redirect("/book_ar")->with("message", $message);
                        }


                    }
                    $_SESSION['cobone'] = $cobone->id;
                }


            }


            return redirect("/calendar_ar");
        }
        $month = date("Y-m", strtotime(date('Y-m')));

        $settings = settings::first();
        $data = array('settings' => $settings, 'month' => $month);
        return view('booking.booking',$data);
    }


    public function update($id, Request $request)
    {
        $booking = booking::find($id);
        $bookings = booking::where("from", ">=", $booking->from)->where("from", "<", $booking->to)->where("paid", 1)->where("room_id", $booking->room_id)->orWhere(function ($query) use ($booking) {
            $query->where("from", "<=", $booking->from)->where("to", ">=", $booking->from)->where("paid", 1)->where("room_id", $booking->room_id);
        })->get();
        $spots = array();
        $check1 = 1;
        $check2 = 1;
        $check3 = 1;
        $check4 = 1;

        if ($booking->room->number_of_beds == 4) {

            foreach ($bookings as $book) {
                if ($book->spot == 1) {
                    $check1 = 0;
                }
                if ($book->spot == 2) {
                    $check2 = 0;
                }
                if ($book->spot == 3) {
                    $check3 = 0;
                }
                if ($book->spot == 4) {
                    $check4 = 0;
                }


            }
            if ($check1 == 1) {


                array_push($spots, 1);

            }
            if ($check2 == 1) {
                array_push($spots, 2);
            }
            if ($check3 == 1) {
                array_push($spots, 3);
            }
            if ($check4 == 1) {
                array_push($spots, 4);
            }


            # code...
        }


        if ($booking->room->number_of_beds == 2) {

            foreach ($bookings as $book) {


                if ($book->spot == 1) {
                    $check1 = 0;
                }
                if ($book->spot == 2) {
                    $check2 = 0;
                }


            }
            if ($check1 == 1) {


                array_push($spots, 1);

            }
            if ($check2 == 1) {
                array_push($spots, 2);
            }
        }

        $data = array('booking' => $booking, 'bookings' => $bookings, 'spots' => $spots);
        if ($request->isMethod('post')) {
            $booking->weight = $request->input("weight");
            $booking->daily_burning = $request->input("daily_burning");
            $booking->status = $request->input("status");
            $booking->spot = $request->input("spot");
            $booking->save();
            return redirect('/viewBooking');


        }
        return view('booking.update', $data);

    }

    public function delete($id)
    {
        $booking = booking::find($id);
        $booking->delete();

        return redirect('/viewBooking');

    }

    public function bookInside(Request $request, $id)
    {

    if ($request->isMethod('post')) {


            $_SESSION['program'] = $request->input("people");
            $_SESSION['type'] = $request->input("typestay");

            $_SESSION['room'] = $request->input("room");


            $_SESSION['number'] = $request->input("number");
            if ($_SESSION['type'] == "weekly" && $request->input("number") == null) {
                $message = 'Please Select No.Of Weeks';
                return redirect("/bookInside/".$id)->with("message", $message);
            }


            $_SESSION['month'] = $request->input("month");
            // $_SESSION['year']=$request->input("year");
            $month = date("m", strtotime($_SESSION['month']));
            $current = date("m", strtotime(date('Y-m-d H:i:s')));
            $year = date("y", strtotime($_SESSION['month']));
            $currentYear = date("y", strtotime(date('Y-m-d H:i:s')));
            if ($year < $currentYear || ($month < $current && $year == $currentYear)) {
                $message = 'Your Selected "Check-In Month\Year" is Illogical';
                return redirect("/bookInside/".$id)->with("message", $message);

            }
            if ($request->input("cobone") != null) {
                $cobone = Cobon::where("number", "=", $request->input("cobone"))->first();
                if ($cobone == null) {
                    $message = "You Entered an Invalid Coupon Code";
                    return redirect("/bookInside/".$id)->with("message", $message);


                    //   return redirect("/complete/" . $origin)->with("message", $message);
                } else {
                    if ($cobone->expired != null) {
                        if ($cobone->expired < date("Y-m-d", strtotime(date('Y-m-d')))) {
                            $message = "You Entered an Expired Coupon";
                            return redirect("/bookInside/".$id)->with("message", $message);
                        }
                        # code...
                    }

                    if ($cobone->type == "limited") {
                        if ($cobone->time_of_use < 1) {

                            $message = "You Entered a Terminated Coupon";
                            return redirect("/bookInside/".$id)->with("message", $message);
                        }


                    }
                    $_SESSION['cobone'] = $cobone->id;
                }


            }


            return redirect("/calendarInside");
        }
        $_SESSION['user_id']=$id;
        $month = date("Y-m", strtotime(date('Y-m')));

        $settings = settings::first();
        $data = array('id' => $id,'settings' => $settings, 'month' => $month);

        return view('booking.bookinginside', $data);
    }


    public function complete(Request $request, $day)
    {
        if (Auth::id() == null) {
            return view('ahome');

            //return redirect("/booknow");

        }
        if ($request->isMethod('post')) {
            //  $user = User::find(Auth::id());

            $booking = new booking();
            $booking->from = $request->input("from");
            $booking->to = $request->input("to");
            $booking->room_id = $request->input("room");

            $booking->status = "Check-Out";

            $booking->cost = $request->input("cost");
            $booking->user_id = Auth::id();
            $booking->type = $_SESSION['program'];
            $booking->save();
            if (isset($_SESSION['cobone'])) {
                $cobone = Cobon::find($_SESSION['cobone']);

                        if ($cobone->time_of_use !=null) {


                           $cobone->time_of_use-=1;
                           $cobone->save();
                           


                    


                # code...
            }
        }
            return redirect("/createQuestionnaire/" . $booking->id);

        }

        $discount = 0;

        $cost = 0;
        $to = 0;
        $romm = 0;
        $origin = $day;
        $day = strtotime($_SESSION['month'] . '-' . $day);
        $newformat = date('Y-m-d', $day);
        $from = $_SESSION['month'] . '-' . $origin;
        $price = price::first();
        if ($_SESSION['type'] == "dayuse") {
            $booking = new booking();
            $booking->from = $_SESSION['month'] . '-' . $origin;
            $to = $_SESSION['month'] . '-' . $origin;
            //  $booking->status = "complete";
            $user = User::find(Auth::id());
            if ($user->country == 'Egypt') {
                $cost = $price->dayuse;
            } else {
                $cost = $price->dayuse_usd;

            }
            $booking->user_id = Auth::id();


            //   $booking->save();
            //     return redirect("/createQuestionnaire/" . $booking->id);


        } else {
            $rooms = room::where("type", "=", $_SESSION['room'])->get();
            $month = date("m", strtotime($_SESSION['month']));
            $year = date("y", strtotime($_SESSION['month']));


            $bookings = booking::where("from", ">=", $from)->where("from", "<", $to)->where("paid", 1)->orWhere(function ($query) use ($from, $to) {
                $query->where("from", "<=", $from)->where("to", ">=", $from)->where("paid", 1);
            })->get();
            $room = null;
            for ($y = 0; $y < count($rooms); $y++) {
                $counter = 0;

                for ($x = 0; $x < count($bookings); $x++) {
                    if (($from <= $bookings[$x]->from && $to >= $bookings[$x]->from) || ($from >= $bookings[$x]->from && $to <= $bookings[$x]->to)) {
                        if ($rooms[$y]->id == $bookings[$x]->room_id) {
                            $counter++;
                        }
                    }

                }
                if ($counter < count($rooms[$y]->Spots)) {
                    $room = $rooms[$y];
                    break;
                }


            }


            // if ($request->isMethod('post')) {
            $cost = 0;
            $user = User::find(Auth::id());
            if ($user->country == 'Egypt') {
                $from = $_SESSION['month'] . '-' . $origin;
                if ($_SESSION['type'] == "weekend") {
                    $to = date('Y-m-d', strtotime($from . ' + ' . 2 . ' days'));
                    if ($room->type == 'private')
                        $cost = $price->weekend_private;
                    if ($room->type == 'public')
                        $cost = $price->weekend_shared;
                    if ($room->type == 'single')
                        $cost = $price->weekend_single;
                    if ($room->type == 'four')
                        $cost = $price->weekend_quad;

                } else {
                    $number = $_SESSION['number'];

                    $to = date('Y-m-d', strtotime($from . ' + ' . (($number * 7) - 1) . ' days'));
                    if ($number == 1) {
                        if ($room->type == 'private')
                            $cost = $price->price_private_egp * $price->percentage_one_week / 100;
                        if ($room->type == 'public')
                            $cost = $price->price_shared_egp * $price->percentage_one_week / 100;
                        if ($room->type == 'single')
                            $cost = $price->price_single_egp * $price->percentage_one_week / 100;
                        if ($room->type == 'four')
                            $cost = $price->price_quad_egp * $price->percentage_one_week / 100;
                    } elseif ($number == 2) {
                        if ($room->type == 'private')

                            $cost = $price->price_private_egp * $price->percentage_two_weeks / 100;
                        if ($room->type == 'public')
                            $cost = $price->price_shared_egp * $price->percentage_two_weeks / 100;
                        if ($room->type == 'single')
                            $cost = $price->price_single_egp * $price->percentage_two_weeks / 100;
                        if ($room->type == 'four')
                            $cost = $price->price_quad_egp * $price->percentage_two_weeks / 100;
                    } elseif ($number == 3) {
                        if ($room->type == 'private')

                            $cost = $price->price_private_egp * $price->percentage_three_weeks / 100;
                        if ($room->type == 'public')
                            $cost = $price->price_shared_egp * $price->percentage_three_weeks / 100;
                        if ($room->type == 'single')
                            $cost = $price->price_single_egp * $price->percentage_three_weeks / 100;
                        if ($room->type == 'four')
                            $cost = $price->price_quad_egp * $price->percentage_three_weeks / 100;
                    } elseif ($number >= 4) {
                        if ($room->type == 'private')

                            $cost = $price->price_private_egp * $price->percentage_four_weeks / 100;
                        if ($room->type == 'public')
                            $cost = $price->price_shared_egp * $price->percentage_four_weeks / 100;
                        if ($room->type == 'single')
                            $cost = $price->price_single_egp * $price->percentage_four_weeks / 100;
                        if ($room->type == 'four')
                            $cost = $price->price_quad_egp * $price->percentage_four_weeks / 100;
                    }

                }
            } else {
                $from = $_SESSION['month'] . '-' . $origin;
                if ($_SESSION['type'] == "weekend") {
                    $to = date('Y-m-d', strtotime($from . ' + ' . 2 . ' days'));
                    if ($room->type == 'private')
                        $cost = $price->weekend_private_usd;
                    if ($room->type == 'public')
                        $cost = $price->weekend_shared_usd;
                    if ($room->type == 'single')
                        $cost = $price->weekend_single_usd;
                    if ($room->type == 'four')
                        $cost = $price->weekend_quad_usd;
                } else {
                    $number = $_SESSION['number'];

                    $to = date('Y-m-d', strtotime($from . ' + ' . (($number * 7) - 1) . ' days'));
                    if ($number == 1) {
                        if ($room->type == 'private')
                            $cost = $price->price_private_usd * $price->percentage_one_week / 100;
                        if ($room->type == 'public')
                            $cost = $price->price_shared_usd * $price->percentage_one_week / 100;
                        if ($room->type == 'single')
                            $cost = $price->price_single_usd * $price->percentage_one_week / 100;
                        if ($room->type == 'four')
                            $cost = $price->price_quad_usd * $price->percentage_one_week / 100;
                    } elseif ($number == 2) {
                        if ($room->type == 'private')
                            $cost = $price->price_private_usd * $price->percentage_two_weeks / 100;
                        if ($room->type == 'public')
                            $cost = $price->price_shared_usd * $price->percentage_two_weeks / 100;
                        if ($room->type == 'single')
                            $cost = $price->price_single_usd * $price->percentage_two_weeks / 100;
                        if ($room->type == 'four')
                            $cost = $price->price_quad_usd * $price->percentage_two_weeks / 100;
                    } elseif ($number == 3) {
                        if ($room->type == 'private')
                            $cost = $price->price_private_usd * $price->percentage_three_weeks / 100;
                        if ($room->type == 'public')
                            $cost = $price->price_shared_usd * $price->percentage_three_weeks / 100;
                        if ($room->type == 'single')
                            $cost = $price->price_single_usd * $price->percentage_three_weeks / 100;
                        if ($room->type == 'four')
                            $cost = $price->price_quad_usd * $price->percentage_three_weeks / 100;
                    } elseif ($number >= 4) {
                        if ($room->type == 'private')
                            $cost = $price->price_private_usd * $price->percentage_four_weeks / 100;
                        if ($room->type == 'public')
                            $cost = $price->price_shared_usd * $price->percentage_four_weeks / 100;
                        if ($room->type == 'single')
                            $cost = $price->price_single_usd * $price->percentage_four_weeks / 100;
                        if ($room->type == 'four')
                            $cost = $price->price_quad_usd * $price->percentage_four_weeks / 100;
                    }

                }

            }
            if (isset($_SESSION['cobone'])) {
                $cobone = Cobon::find($_SESSION['cobone']);
                $discount =$cobone->discount*$cost/100;


                # code...
            }
           
        }
        if ($_SESSION['type'] != "dayuse")
            $data = array('room' => $_SESSION['room'], 'type' => $_SESSION['type'], 'program' => $_SESSION['program'], 'from' => $from, 'to' => $to, 'cost' => $cost, 'id' => $day, $cost, 'room_id' => $room->id,'discount'=>$discount);
        else
            $data = array('type' => $_SESSION['type'], 'program' => $_SESSION['program'], 'from' => $from, 'to' => $to, 'cost' => $cost, 'id' => $day,'discount'=>$discount);

        return view('booking.acompelete', $data);
    }

    public function complete_ar(Request $request, $day)
    {
       if (Auth::id() == null) {
            return view('home');

            //return redirect("/booknow");

        }
        if ($request->isMethod('post')) {
            //  $user = User::find(Auth::id());

            $booking = new booking();
            $booking->from = $request->input("from");
            $booking->to = $request->input("to");
            $booking->room_id = $request->input("room");

            $booking->status = "Check-Out";

            $booking->cost = $request->input("cost");
            $booking->user_id = Auth::id();
            $booking->type = $_SESSION['program'];
            $booking->save();
            if (isset($_SESSION['cobone'])) {
                $cobone = Cobon::find($_SESSION['cobone']);

                        if ($cobone->time_of_use !=null) {


                           $cobone->time_of_use-=1;
                           $cobone->save();
                           


                    


                # code...
            }
        }
            return redirect("/createQuestionnaire_ar/" . $booking->id);

        }

        $discount = 0;

        $cost = 0;
        $to = 0;
        $romm = 0;
        $origin = $day;
        $day = strtotime($_SESSION['month'] . '-' . $day);
        $newformat = date('Y-m-d', $day);
        $from = $_SESSION['month'] . '-' . $origin;
        $price = price::first();
        if ($_SESSION['type'] == "dayuse") {
            $booking = new booking();
            $booking->from = $_SESSION['month'] . '-' . $origin;
            $to = $_SESSION['month'] . '-' . $origin;
            //  $booking->status = "complete";
            $user = User::find(Auth::id());
            if ($user->country == 'Egypt') {
                $cost = $price->dayuse;
            } else {
                $cost = $price->dayuse_usd;

            }
            $booking->user_id = Auth::id();


            //   $booking->save();
            //     return redirect("/createQuestionnaire/" . $booking->id);


        } else {
            $rooms = room::where("type", "=", $_SESSION['room'])->get();
            $month = date("m", strtotime($_SESSION['month']));
            $year = date("y", strtotime($_SESSION['month']));


            $bookings = booking::where("from", ">=", $from)->where("from", "<", $to)->where("paid", 1)->orWhere(function ($query) use ($from, $to) {
                $query->where("from", "<=", $from)->where("to", ">=", $from)->where("paid", 1);
            })->get();
            $room = null;
            for ($y = 0; $y < count($rooms); $y++) {
                $counter = 0;

                for ($x = 0; $x < count($bookings); $x++) {
                    if (($from <= $bookings[$x]->from && $to >= $bookings[$x]->from) || ($from >= $bookings[$x]->from && $to <= $bookings[$x]->to)) {
                        if ($rooms[$y]->id == $bookings[$x]->room_id) {
                            $counter++;
                        }
                    }

                }
                if ($counter < count($rooms[$y]->Spots)) {
                    $room = $rooms[$y];
                    break;
                }


            }


            // if ($request->isMethod('post')) {
            $cost = 0;
            $user = User::find(Auth::id());
            if ($user->country == 'Egypt') {
                $from = $_SESSION['month'] . '-' . $origin;
                if ($_SESSION['type'] == "weekend") {
                    $to = date('Y-m-d', strtotime($from . ' + ' . 2 . ' days'));
                    if ($room->type == 'private')
                        $cost = $price->weekend_private;
                    if ($room->type == 'public')
                        $cost = $price->weekend_shared;
                    if ($room->type == 'single')
                        $cost = $price->weekend_single;
                    if ($room->type == 'four')
                        $cost = $price->weekend_quad;

                } else {
                    $number = $_SESSION['number'];

                    $to = date('Y-m-d', strtotime($from . ' + ' . (($number * 7) - 1) . ' days'));
                    if ($number == 1) {
                        if ($room->type == 'private')
                            $cost = $price->price_private_egp * $price->percentage_one_week / 100;
                        if ($room->type == 'public')
                            $cost = $price->price_shared_egp * $price->percentage_one_week / 100;
                        if ($room->type == 'single')
                            $cost = $price->price_single_egp * $price->percentage_one_week / 100;
                        if ($room->type == 'four')
                            $cost = $price->price_quad_egp * $price->percentage_one_week / 100;
                    } elseif ($number == 2) {
                        if ($room->type == 'private')

                            $cost = $price->price_private_egp * $price->percentage_two_weeks / 100;
                        if ($room->type == 'public')
                            $cost = $price->price_shared_egp * $price->percentage_two_weeks / 100;
                        if ($room->type == 'single')
                            $cost = $price->price_single_egp * $price->percentage_two_weeks / 100;
                        if ($room->type == 'four')
                            $cost = $price->price_quad_egp * $price->percentage_two_weeks / 100;
                    } elseif ($number == 3) {
                        if ($room->type == 'private')

                            $cost = $price->price_private_egp * $price->percentage_three_weeks / 100;
                        if ($room->type == 'public')
                            $cost = $price->price_shared_egp * $price->percentage_three_weeks / 100;
                        if ($room->type == 'single')
                            $cost = $price->price_single_egp * $price->percentage_three_weeks / 100;
                        if ($room->type == 'four')
                            $cost = $price->price_quad_egp * $price->percentage_three_weeks / 100;
                    } elseif ($number >= 4) {
                        if ($room->type == 'private')

                            $cost = $price->price_private_egp * $price->percentage_four_weeks / 100;
                        if ($room->type == 'public')
                            $cost = $price->price_shared_egp * $price->percentage_four_weeks / 100;
                        if ($room->type == 'single')
                            $cost = $price->price_single_egp * $price->percentage_four_weeks / 100;
                        if ($room->type == 'four')
                            $cost = $price->price_quad_egp * $price->percentage_four_weeks / 100;
                    }

                }
            } else {
                $from = $_SESSION['month'] . '-' . $origin;
                if ($_SESSION['type'] == "weekend") {
                    $to = date('Y-m-d', strtotime($from . ' + ' . 2 . ' days'));
                    if ($room->type == 'private')
                        $cost = $price->weekend_private_usd;
                    if ($room->type == 'public')
                        $cost = $price->weekend_shared_usd;
                    if ($room->type == 'single')
                        $cost = $price->weekend_single_usd;
                    if ($room->type == 'four')
                        $cost = $price->weekend_quad_usd;
                } else {
                    $number = $_SESSION['number'];

                    $to = date('Y-m-d', strtotime($from . ' + ' . (($number * 7) - 1) . ' days'));
                    if ($number == 1) {
                        if ($room->type == 'private')
                            $cost = $price->price_private_usd * $price->percentage_one_week / 100;
                        if ($room->type == 'public')
                            $cost = $price->price_shared_usd * $price->percentage_one_week / 100;
                        if ($room->type == 'single')
                            $cost = $price->price_single_usd * $price->percentage_one_week / 100;
                        if ($room->type == 'four')
                            $cost = $price->price_quad_usd * $price->percentage_one_week / 100;
                    } elseif ($number == 2) {
                        if ($room->type == 'private')
                            $cost = $price->price_private_usd * $price->percentage_two_weeks / 100;
                        if ($room->type == 'public')
                            $cost = $price->price_shared_usd * $price->percentage_two_weeks / 100;
                        if ($room->type == 'single')
                            $cost = $price->price_single_usd * $price->percentage_two_weeks / 100;
                        if ($room->type == 'four')
                            $cost = $price->price_quad_usd * $price->percentage_two_weeks / 100;
                    } elseif ($number == 3) {
                        if ($room->type == 'private')
                            $cost = $price->price_private_usd * $price->percentage_three_weeks / 100;
                        if ($room->type == 'public')
                            $cost = $price->price_shared_usd * $price->percentage_three_weeks / 100;
                        if ($room->type == 'single')
                            $cost = $price->price_single_usd * $price->percentage_three_weeks / 100;
                        if ($room->type == 'four')
                            $cost = $price->price_quad_usd * $price->percentage_three_weeks / 100;
                    } elseif ($number >= 4) {
                        if ($room->type == 'private')
                            $cost = $price->price_private_usd * $price->percentage_four_weeks / 100;
                        if ($room->type == 'public')
                            $cost = $price->price_shared_usd * $price->percentage_four_weeks / 100;
                        if ($room->type == 'single')
                            $cost = $price->price_single_usd * $price->percentage_four_weeks / 100;
                        if ($room->type == 'four')
                            $cost = $price->price_quad_usd * $price->percentage_four_weeks / 100;
                    }

                }

            }
            if (isset($_SESSION['cobone'])) {
                $cobone = Cobon::find($_SESSION['cobone']);
                $discount =$cobone->discount*$cost/100;


                # code...
            }
           
        }
        if ($_SESSION['type'] != "dayuse")
            $data = array('room' => $_SESSION['room'], 'type' => $_SESSION['type'], 'program' => $_SESSION['program'], 'from' => $from, 'to' => $to, 'cost' => $cost, 'id' => $day, $cost, 'room_id' => $room->id,'discount'=>$discount);
        else
            $data = array('type' => $_SESSION['type'], 'program' => $_SESSION['program'], 'from' => $from, 'to' => $to, 'cost' => $cost, 'id' => $day,'discount'=>$discount);

        return view('booking.complete', $data);
    }

    public function completeInside(Request $request, $day)
    {

       if ($request->isMethod('post')) {
            //  $user = User::find(Auth::id());

            $booking = new booking();
            $booking->from = $request->input("from");
            $booking->to = $request->input("to");
            $booking->room_id = $request->input("room");

            $booking->status = "Check-Out";

            $booking->cost = $request->input("cost");
            $booking->user_id = Auth::id();
            $booking->type = $_SESSION['program'];
            $booking->save();
            if (isset($_SESSION['cobone'])) {
                $cobone = Cobon::find($_SESSION['cobone']);

                        if ($cobone->time_of_use !=null) {


                           $cobone->time_of_use-=1;
                           $cobone->save();
                           


                    


                # code...
            }
        }
            return redirect("/options");

        }

        $discount = 0;

        $cost = 0;
        $to = 0;
        $romm = 0;
        $origin = $day;
        $day = strtotime($_SESSION['month'] . '-' . $day);
        $newformat = date('Y-m-d', $day);
        $from = $_SESSION['month'] . '-' . $origin;
        $price = price::first();
        if ($_SESSION['type'] == "dayuse") {
            $booking = new booking();
            $booking->from = $_SESSION['month'] . '-' . $origin;
            $to = $_SESSION['month'] . '-' . $origin;
            //  $booking->status = "complete";
            $user = User::find(Auth::id());
            if ($user->country == 'Egypt') {
                $cost = $price->dayuse;
            } else {
                $cost = $price->dayuse_usd;

            }
            $booking->user_id = Auth::id();


            //   $booking->save();
            //     return redirect("/createQuestionnaire/" . $booking->id);


        } else {
            $rooms = room::where("type", "=", $_SESSION['room'])->get();
            $month = date("m", strtotime($_SESSION['month']));
            $year = date("y", strtotime($_SESSION['month']));


            $bookings = booking::where("from", ">=", $from)->where("from", "<", $to)->where("paid", 1)->orWhere(function ($query) use ($from, $to) {
                $query->where("from", "<=", $from)->where("to", ">=", $from)->where("paid", 1);
            })->get();
            $room = null;
            for ($y = 0; $y < count($rooms); $y++) {
                $counter = 0;

                for ($x = 0; $x < count($bookings); $x++) {
                    if (($from <= $bookings[$x]->from && $to >= $bookings[$x]->from) || ($from >= $bookings[$x]->from && $to <= $bookings[$x]->to)) {
                        if ($rooms[$y]->id == $bookings[$x]->room_id) {
                            $counter++;
                        }
                    }

                }
                if ($counter < count($rooms[$y]->Spots)) {
                    $room = $rooms[$y];
                    break;
                }


            }


            // if ($request->isMethod('post')) {
            $cost = 0;
            $user = User::find($_SESSION['user_id']);
            if ($user->country == 'Egypt') {
                $from = $_SESSION['month'] . '-' . $origin;
                if ($_SESSION['type'] == "weekend") {
                    $to = date('Y-m-d', strtotime($from . ' + ' . 2 . ' days'));
                    if ($room->type == 'private')
                        $cost = $price->weekend_private;
                    if ($room->type == 'public')
                        $cost = $price->weekend_shared;
                    if ($room->type == 'single')
                        $cost = $price->weekend_single;
                    if ($room->type == 'four')
                        $cost = $price->weekend_quad;

                } else {
                    $number = $_SESSION['number'];

                    $to = date('Y-m-d', strtotime($from . ' + ' . (($number * 7) - 1) . ' days'));
                    if ($number == 1) {
                        if ($room->type == 'private')
                            $cost = $price->price_private_egp * $price->percentage_one_week / 100;
                        if ($room->type == 'public')
                            $cost = $price->price_shared_egp * $price->percentage_one_week / 100;
                        if ($room->type == 'single')
                            $cost = $price->price_single_egp * $price->percentage_one_week / 100;
                        if ($room->type == 'four')
                            $cost = $price->price_quad_egp * $price->percentage_one_week / 100;
                    } elseif ($number == 2) {
                        if ($room->type == 'private')

                            $cost = $price->price_private_egp * $price->percentage_two_weeks / 100;
                        if ($room->type == 'public')
                            $cost = $price->price_shared_egp * $price->percentage_two_weeks / 100;
                        if ($room->type == 'single')
                            $cost = $price->price_single_egp * $price->percentage_two_weeks / 100;
                        if ($room->type == 'four')
                            $cost = $price->price_quad_egp * $price->percentage_two_weeks / 100;
                    } elseif ($number == 3) {
                        if ($room->type == 'private')

                            $cost = $price->price_private_egp * $price->percentage_three_weeks / 100;
                        if ($room->type == 'public')
                            $cost = $price->price_shared_egp * $price->percentage_three_weeks / 100;
                        if ($room->type == 'single')
                            $cost = $price->price_single_egp * $price->percentage_three_weeks / 100;
                        if ($room->type == 'four')
                            $cost = $price->price_quad_egp * $price->percentage_three_weeks / 100;
                    } elseif ($number >= 4) {
                        if ($room->type == 'private')

                            $cost = $price->price_private_egp * $price->percentage_four_weeks / 100;
                        if ($room->type == 'public')
                            $cost = $price->price_shared_egp * $price->percentage_four_weeks / 100;
                        if ($room->type == 'single')
                            $cost = $price->price_single_egp * $price->percentage_four_weeks / 100;
                        if ($room->type == 'four')
                            $cost = $price->price_quad_egp * $price->percentage_four_weeks / 100;
                    }

                }
            } else {
                $from = $_SESSION['month'] . '-' . $origin;
                if ($_SESSION['type'] == "weekend") {
                    $to = date('Y-m-d', strtotime($from . ' + ' . 2 . ' days'));
                    if ($room->type == 'private')
                        $cost = $price->weekend_private_usd;
                    if ($room->type == 'public')
                        $cost = $price->weekend_shared_usd;
                    if ($room->type == 'single')
                        $cost = $price->weekend_single_usd;
                    if ($room->type == 'four')
                        $cost = $price->weekend_quad_usd;
                } else {
                    $number = $_SESSION['number'];

                    $to = date('Y-m-d', strtotime($from . ' + ' . (($number * 7) - 1) . ' days'));
                    if ($number == 1) {
                        if ($room->type == 'private')
                            $cost = $price->price_private_usd * $price->percentage_one_week / 100;
                        if ($room->type == 'public')
                            $cost = $price->price_shared_usd * $price->percentage_one_week / 100;
                        if ($room->type == 'single')
                            $cost = $price->price_single_usd * $price->percentage_one_week / 100;
                        if ($room->type == 'four')
                            $cost = $price->price_quad_usd * $price->percentage_one_week / 100;
                    } elseif ($number == 2) {
                        if ($room->type == 'private')
                            $cost = $price->price_private_usd * $price->percentage_two_weeks / 100;
                        if ($room->type == 'public')
                            $cost = $price->price_shared_usd * $price->percentage_two_weeks / 100;
                        if ($room->type == 'single')
                            $cost = $price->price_single_usd * $price->percentage_two_weeks / 100;
                        if ($room->type == 'four')
                            $cost = $price->price_quad_usd * $price->percentage_two_weeks / 100;
                    } elseif ($number == 3) {
                        if ($room->type == 'private')
                            $cost = $price->price_private_usd * $price->percentage_three_weeks / 100;
                        if ($room->type == 'public')
                            $cost = $price->price_shared_usd * $price->percentage_three_weeks / 100;
                        if ($room->type == 'single')
                            $cost = $price->price_single_usd * $price->percentage_three_weeks / 100;
                        if ($room->type == 'four')
                            $cost = $price->price_quad_usd * $price->percentage_three_weeks / 100;
                    } elseif ($number >= 4) {
                        if ($room->type == 'private')
                            $cost = $price->price_private_usd * $price->percentage_four_weeks / 100;
                        if ($room->type == 'public')
                            $cost = $price->price_shared_usd * $price->percentage_four_weeks / 100;
                        if ($room->type == 'single')
                            $cost = $price->price_single_usd * $price->percentage_four_weeks / 100;
                        if ($room->type == 'four')
                            $cost = $price->price_quad_usd * $price->percentage_four_weeks / 100;
                    }

                }

            }
            if (isset($_SESSION['cobone'])) {
                $cobone = Cobon::find($_SESSION['cobone']);
                $discount =$cobone->discount*$cost/100;


                # code...
            }
           
        }
        if ($_SESSION['type'] != "dayuse")
      $data = array('room' => $_SESSION['room'], 'type' => $_SESSION['type'], 'program' => $_SESSION['program'], 'from' => $from, 'to' => $to, 'cost' => $cost, 'id' => $day, $cost, 'room_id' => $room->id,'discount'=>$discount,'country'=>$user->country);
        else
            $data = array('type' => $_SESSION['type'], 'program' => $_SESSION['program'], 'from' => $from, 'to' => $to, 'cost' => $cost, 'id' => $day,'discount'=>$discount,'country'=>$user->country);
        return view('booking.completeInside', $data);
    }

    public function calendar()
    {
        if (Auth::id() == null) {
            return view('ahome');

            //return redirect("/booknow");

        }
        // $information =Session::get("information");
        $month = date("m", strtotime($_SESSION['month']));
        $year = date("y", strtotime($_SESSION['month']));

        $bookings = booking::whereMonth("from", "=", $month)->whereYear("from", "=", '20' . $year)->where("paid", 1)->orWhere(function ($query) use ($month, $year) {
            $query->whereMonth('to', '=', $month)
                ->whereYear('to', '=', '20' . $year)->where("paid", 1);
        })->get();
        $rooms = room::where("type", "=", $_SESSION['room'])->get();
        $total = 0;
        foreach ($rooms as $room) {
            $total += count($room->Spots);

            # code...
        }
        $real = array();
        for ($x = 0; $x < count($bookings); $x++) {
            if ($bookings[$x]->room_id != null) {
                array_push($real, $bookings[$x]);
            }
        }
        $dt = new \DateTime($_SESSION['month']);
//exit();
        $data = array('rooms' => $rooms, 'bookings' => $real, 'totals' => $total, 'month' => $_SESSION['month'], 'cal' => $dt->format('M-Y'), 'type' => $_SESSION['type']);
        return view('booking.acalander', $data);


    }

    public function calendar_ar()
    {
        if (Auth::id() == null) {
            return view('home');

            //return redirect("/booknow");

        }
        // $information =Session::get("information");
        $month = date("m", strtotime($_SESSION['month']));
        $year = date("y", strtotime($_SESSION['month']));

        $bookings = booking::whereMonth("from", "=", $month)->whereYear("from", "=", '20' . $year)->where("paid", 1)->orWhere(function ($query) use ($month, $year) {
            $query->whereMonth('to', '=', $month)
                ->whereYear('to', '=', '20' . $year)->where("paid", 1);
        })->get();
        $rooms = room::where("type", "=", $_SESSION['room'])->get();
         $total = 0;
        foreach ($rooms as $room) {
            $total += count($room->Spots);

            # code...
        }
        $real = array();
        for ($x = 0; $x < count($bookings); $x++) {
            if ($bookings[$x]->room_id != null) {
                array_push($real, $bookings[$x]);
            }
        }
        $dt = new \DateTime($_SESSION['month']);
        $real = array();
        for ($x = 0; $x < count($bookings); $x++) {
            if ($bookings[$x]->room_id != null) {
                array_push($real, $bookings[$x]);
            }
        }
        $dt = new \DateTime($_SESSION['month']);

        $data = array('rooms' => $rooms, 'bookings' => $real, 'totals' => $total, 'month' => $_SESSION['month'], 'cal' => $dt->format('M-Y'), 'type' => $_SESSION['type']);
        return view('booking.calendar', $data);


    }

    public function calendarInside()
    {

        // $information =Session::get("information");
        $month = date("m", strtotime($_SESSION['month']));
        $year = date("y", strtotime($_SESSION['month']));

        $bookings = booking::whereMonth("from", "=", $month)->whereYear("from", "=", '20' . $year)->where("paid", 1)->orWhere(function ($query) use ($month, $year) {
            $query->whereMonth('to', '=', $month)
                ->whereYear('to', '=', '20' . $year)->where("paid", 1);
        })->get();
        $rooms = room::where("type", "=", $_SESSION['room'])->get();
        $total = 0;
        foreach ($rooms as $room) {
            $total += count($room->Spots);

            # code...
        }
        $real = array();
        for ($x = 0; $x < count($bookings); $x++) {
            if ($bookings[$x]->room_id != null) {
                array_push($real, $bookings[$x]);
            }
        }
        $dt = new \DateTime($_SESSION['month']);
//exit();
        $data = array('rooms' => $rooms, 'bookings' => $real, 'totals' => $total, 'month' => $_SESSION['month'], 'cal' => $dt->format('M-Y'), 'type' => $_SESSION['type']);
        return view('booking.calendarInside', $data);


    }


    public function price($id)
    {
        // $information =Session::get("information");
        if (Session::get("cost") == null) {
            return redirect("/");

            //  exit();


        }
        $data = array('cost' => Session::get("cost"), 'discount' => Session::get("discount"), 'actual' => Session::get("actual"), 'id' => $id);
        return view('booking.price', $data);


    }

    public function history()
    {
        if (Auth::id() == null) {
            return view('ahome');

            //return redirect("/booknow");

        }
        $bookings = booking::where('user_id', Auth::id())->paginate(3);
        foreach ($bookings as $booking) {
            $booking->from = date("d-m-Y", strtotime($booking->from));
            $booking->to = date("d-m-Y", strtotime($booking->to));

        }
        $data = array('booking' => $bookings);
        return view('booking.ahistory', $data);
    }

    public function history_ar()
    {
        if (Auth::id() == null) {
            return view('home');

            //return redirect("/booknow");

        }
        $bookings = booking::where('user_id', Auth::id())->paginate(3);
        foreach ($bookings as $booking) {
            $booking->from = date("d-m-Y", strtotime($booking->from));
            $booking->to = date("d-m-Y", strtotime($booking->to));

        }
        $data = array('booking' => $bookings);
        return view('booking.history', $data);
    }

    public function viewBooking()
    {

        $bookings = booking::all();
        foreach ($bookings as $booking) {
            $booking->from = date("d-m-Y", strtotime($booking->from));
            $booking->to = date("d-m-Y", strtotime($booking->to));
            $booking->user->age = date("d-m-Y", strtotime($booking->user->age));
        }
        $data = array('bookings' => $bookings);
        return view('booking.viewBooking', $data);
    }

    public function viewArrivalList(Request $request)
    {
        $bookings = null;
        if ($request->isMethod('post')) {
            //  $user = User::find(Auth::id());

            $start = $request->input("start");
            $end = $request->input("end");


            $bookings = booking::where("from", ">=", $start)->where("from", "<=", $end)->get();
            //echo count($bookings);
            // exit();
            foreach ($bookings as $booking) {
                $booking->from = date("d-m-Y", strtotime($booking->from));
                $booking->to = date("d-m-Y", strtotime($booking->to));
                $booking->user->age = date("d-m-Y", strtotime($booking->user->age));
            }
        }
        $data = array('bookings' => $bookings);

        // $data = array('bookings' => $bookings);
        return view('booking.viewarrival', $data);
    }

    public function viewDispatcher(Request $request)
    {
        $bookings = null;

        if ($request->isMethod('post')) {
            //  $user = User::find(Auth::id());

            $start = $request->input("start");
            $end = $request->input("end");


            $bookings = booking::where("to", ">=", $start)->where("to", "<=", $end)->get();

            foreach ($bookings as $booking) {
                $booking->from = date("d-m-Y", strtotime($booking->from));
                $booking->to = date("d-m-Y", strtotime($booking->to));
                $booking->user->age = date("d-m-Y", strtotime($booking->user->age));
            }
        }
        $data = array('bookings' => $bookings);

        // $data = array('bookings' => $bookings);
        return view('booking.viewDispatcher', $data);
    }

    public function evaluate(Request $request)
    {
        $bookings = booking::where("status", "=", 'Check-In')->get();

        $employees = employee::where('type', "=", 'Freelancer')->get();

        $data = array('bookings' => $bookings, 'employees' => $employees);
        if ($request->isMethod('post')) {

            foreach ($employees as $employee) {
                $evaluation_trainer = new evaluation_trainer();
                $evaluation_trainer->booking_id = $request->input("user");
                $evaluation_trainer->trainer_id = $employee->id;
                $evaluation_trainer->notes = $request->input('note' . $employee->id);
                $evaluation_trainer->evaluation = $request->input('employee' . $employee->id);
                $evaluation_trainer->save();


            }
            $evaluation_camp = new evaluation_camp();
            $evaluation_camp->question_one = $request->input("breakfast");
            $evaluation_camp->question_one_note = $request->input("breakfast_note");
            $evaluation_camp->question_two = $request->input("snack1");
            $evaluation_camp->question_two_note = $request->input("snack1_note");
            $evaluation_camp->question_three = $request->input("lunch");
            $evaluation_camp->question_three_note = $request->input("lunch_note");
            $evaluation_camp->question_four = $request->input("snack2");
            $evaluation_camp->question_four_note = $request->input("snack2_note");
            $evaluation_camp->question_five = $request->input("Dinner");
            $evaluation_camp->question_five_note = $request->input("dinner_note");
            $evaluation_camp->question_six = $request->input("beverages");
            $evaluation_camp->question_six_note = $request->input("beverages_note");
            $evaluation_camp->question_seven = $request->input("livingroom");
            $evaluation_camp->question_seven_note = $request->input("livingroom_note");
            $evaluation_camp->question_eight = $request->input("reception");
            $evaluation_camp->question_eight_note = $request->input("reception_note");
            $evaluation_camp->question_nine = $request->input("diningroom");
            $evaluation_camp->question_nine_note = $request->input("diningroom_note");
            $evaluation_camp->question_ten = $request->input("kitchen");
            $evaluation_camp->question_ten_note = $request->input("kitchen_note");
            $evaluation_camp->question_eleven = $request->input("bedroom");
            $evaluation_camp->question_eleven_note = $request->input("bedroom_note");
            $evaluation_camp->question_twelve = $request->input("bathrooms");
            $evaluation_camp->question_twelve_note = $request->input("bathrooms_note");
            $evaluation_camp->question_thirteen = $request->input("welcome");
            $evaluation_camp->question_thirteen_note = $request->input("welcome_note");
            $evaluation_camp->question_fourteen = $request->input("discipline");
            $evaluation_camp->question_fourteen_note = $request->input("discipline_note");
            $evaluation_camp->question_fifteen = $request->input("response");
            $evaluation_camp->question_fifteen_note = $request->input("response_note");
            $evaluation_camp->question_sixteen = $request->input("how");
            $evaluation_camp->question_seventeen = $request->input("suggestions");
            $evaluation_camp->booking_id = $request->input("user");
            $evaluation_camp->save();


        }
        return view('booking.evaluation', $data);


    }


    public function pay(Request $request)
    {
        $banks = banks::all();
        $bookings = booking::where("paid", "=", 0)->get();

        if ($request->isMethod('post')) {
            //  $user = User::find(Auth::id());

            $user = $request->input("user");
            $bank = $request->input("bank");
            $booking = booking::find($user);
            $date1 = new \DateTime($booking->from);
            $date2 = new \DateTime($booking->to);

            $diff = $date1->diff($date2);

//echo($diff->days)+1;

            $booking->user->days += ($diff->days) + 1;
            $rank = points::where('start', '<=', $booking->user->days)->where('finish', '>', $booking->user->days)->first();

            $booking->user->bullets += $booking->cost * $rank->incentive_percentage / 100;
            echo($booking->user->bullets);
            $booking->user->save();

            $booking_bank = new booking_bank();
            $booking_bank->booking_id = $user;
            $booking_bank->bank_id = $bank;
            $booking_bank->save();
            $financial = new financial();

            $financial->type = 2;
            $financial->date = $booking->from;
            $financial->booking_id = $booking->id;

            if ($booking->user->country == 'Egypt')
                $financial->cost = $booking->cost;
            else
                $financial->cost_dollar = $booking->cost;

            $financial->save();
            $booking->paid = 1;
            $booking->save();


            return redirect('/getpaid');


        }
        $data = array('bookings' => $bookings, 'banks' => $banks);

        // $data = array('bookings' => $bookings);
        return view('booking.pay', $data);
    }

    public function getpaid()
    {
        $booking_banks = booking_bank::all();
        $data = array('bookings' => $booking_banks);

        // $data = array('bookings' => $bookings);
        return view('booking.viewpaid', $data);
    }


    public function viewSettings()
    {
        $settings = settings::first();
        $data = array('settings' => $settings);
        return view('Room.settings', $data);
    }

    public function updateSettings($id, Request $request)
    {
        if ($request->isMethod('post')) {
            $price = settings::find($id);


            $price->health_retreat = $request->input("health_retreat");
            $price->bootcamp = $request->input("bootcamp");
            $price->weekend = $request->input("weekend");
            $price->weekly = $request->input("weekly");
            $price->dayuse = $request->input("dayuse");


            $price->save();


            return redirect("/viewSettings");
        }
        //  $floors=floor::all();
    }


    public function weight_bullets(Request $request)
    {
        if ($request->isMethod('post')) {
            $bullets_weight = new bullets_weight();

            $user = User::find($request->input("user_id"));
            $bullets_weight->date = $request->input("date");
            $bullets_weight->weight = $request->input("weight");
            $bullets_weight->user_id = $request->input("user_id");
            $rank = points::where('start', '<=', $user->days)->where('finish', '>', $user->days)->first();

            $bullets_weight->bullets = $rank->weight * $bullets_weight->weight;


            $bullets_weight->save();
            $user->weight -= $bullets_weight->weight;
            $user->save();


            return redirect("/view_weight_bullets");
        }
        $users = User::all();
        $data = array('users' => $users);
        return view('Points.bullets_weight', $data);

    }


    public function view_weight_bullets()
    {
        $bullets_weight = bullets_weight::all();
        $data = array('bullets_weight' => $bullets_weight);

        // $data = array('bookings' => $bookings);
        return view('Points.view_bullets_weight', $data);
    }


}
