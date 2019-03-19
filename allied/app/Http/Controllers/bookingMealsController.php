<?php

namespace App\Http\Controllers;

use App\meal;
use App\booking;
use App\employee;
use App\ingredient;
use App\meal_ings;
use DB;
use App\meal_book;
use Illuminate\Http\Request;

class bookingMealsController extends Controller
{
    /*
    public function view($id)
    {
        $meal=meal::find($id);
        $mealBooking=meal_booking::all();
        $data=array('mealBooking'=>$mealBooking,'meal'=>$meal);
        return view('meals.viewTracker',$data);
    }*/
    public function create(Request $request)
    {
        $meal=meal::all();
        $booking=booking::all();
        $data=array('meals'=>$meal,'bookings'=>$booking);

        if($request->isMethod('post'))
        {
            foreach ($booking as $booking) {

                if($request->input($booking->id)==true)
                {
                $mealBooking = new meal_book();


                $mealBooking->meal_id =$request->input('meals');
                $mealBooking->booking_id = $booking->id;
                $mealBooking->save();
                }
            }
            return redirect("/viewAssignedDys");
        }
        return view('meals.viewAssignedDys',$data);
    }
    public function get_users(Request $request)
    {
        if(isset($request->month)) {
            $_SESSION['month'] = $request->input("month");
            $data = array('month' =>  $_SESSION['month']);
            // return $data;
            return view('meals.scheduler',$data);
        }


        // return $data;
        return view('meals.scheduler');
    }

    public function assign(Request $request) //this is the fumction that u have to modify it
    {

     $days=array();
        for ($i=1;$i<32;$i++)
        {
            if ($request->input($i) != null)
            {
                array_push($days,$i);
            }
        }
        $_SESSION['days']=$days;
      //  exit();
         $users=array();
            for ($i=0; $i <count($days) ; $i++) { 
        $bookings=booking::where("paid",1)->where("from","<=",$_SESSION['month'] . '-' . $days[$i])->where("to",">=",$_SESSION['month'] . '-' . $days[$i])->get();
        foreach ($bookings as $booking) {
            if (count($users)==0) {
                array_push($users, $booking);
            }
                else
                {
                    $check=0;
                    for ($x=0; $x <count($users) ; $x++) { 
                        if ($users[$x]->id==$booking->id) {
                            # code...
                       
                    $check=1;

                        }
                        
                        # code...
                    }
                    if ($check==0) {
                                            array_push($users, $booking);

                            # code...
                        }

                }
                # code...
            }
            # code...

        }

         $employee=employee::all();


/*
        $days=array();
        for ($i=1;$i<32;$i++)
        {
            if ($request->input($i) != null)
            {
                array_push($days,$i);
            }
        }
        $_SESSION['days']=$days;
        //  exit();
        $users=booking::where('paid','=','1');*/
        $meal=DB::table('meals')->get();
        $data = array('meals' => $meal,'users'=>$users,'employees'=>$employee);

        return view('meals.viewDays',$data);

        /*
              foreach ($request->id as $id)
                  DB::table('exercise_bookings')->insert(['duration'=>0,'start'=>$request->start,'end'=>$request->end,'booking_id'=>$id,
                      'exercise_id'=>$request->exercise_id]);
          */
    }

    public function assignExercise(Request $request)
    {

        if((isset($request->id))&&isset($request->id2) &&isset($request->id3)&&isset($request->id4)&&isset($request->id5)&&isset($request->id6 ))
        {
            foreach ($_SESSION['days'] as $day) {
                foreach ($request->id as $id) {

                    $book=booking::find($id);

                        
                
          if (new \DateTime($book->from)<= new \DateTime($_SESSION['month'] . '-' . $day) && new \DateTime($book->to)>= new \DateTime($_SESSION['month'] . '-' . $day))  {


                       
                    
                    foreach ($request->id2 as $id2) {
                        DB::table('meal_books')->insert(['type' => 1, 'date' => $_SESSION['month'] . '-' . $day, 'booking_id' => $id,
                            'meal_id' => $id2 ]);

                     
                    }
               
                }
           }
       }

            foreach ($_SESSION['days'] as $day) {
                foreach ($request->id as $id) {
                    $book=booking::find($id);
                
        if (new \DateTime($book->from)<= new \DateTime($_SESSION['month'] . '-' . $day) && new \DateTime($book->to)>= new \DateTime($_SESSION['month'] . '-' . $day))  {



                    foreach ($request->id3 as $id3) {
                        DB::table('meal_books')->insert(['type' => 2, 'date' => $_SESSION['month'] . '-' . $day, 'booking_id' => $id,
                            'meal_id' => $id3]);

                    }
                }
                }
            }

            foreach ($_SESSION['days'] as $day) {
                foreach ($request->id as $id) {
                    $book=booking::find($id);
                
        if (new \DateTime($book->from)<= new \DateTime($_SESSION['month'] . '-' . $day) && new \DateTime($book->to)>= new \DateTime($_SESSION['month'] . '-' . $day))  {

                    foreach ($request->id4 as $id4) {
                        DB::table('meal_books')->insert(['type' => 3, 'date' => $_SESSION['month'] . '-' . $day, 'booking_id' => $id,
                            'meal_id' => $id4]);

                    }
                }
            }
        }

            foreach ($_SESSION['days'] as $day) {
                foreach ($request->id as $id) {
                    $book=booking::find($id);
                
        if (new \DateTime($book->from)<= new \DateTime($_SESSION['month'] . '-' . $day) && new \DateTime($book->to)>= new \DateTime($_SESSION['month'] . '-' . $day))  {

                    foreach ($request->id5 as $id5) {
                        DB::table('meal_books')->insert(['type' => 4, 'date' => $_SESSION['month'] . '-' . $day, 'booking_id' => $id,
                            'meal_id' => $id5]);

                    }
                }
            }
        }

            foreach ($_SESSION['days'] as $day) {
                foreach ($request->id as $id) {
$book=booking::find($id);
                
        if (new \DateTime($book->from)<= new \DateTime($_SESSION['month'] . '-' . $day) && new \DateTime($book->to)>= new \DateTime($_SESSION['month'] . '-' . $day))  {
                    foreach ($request->id6 as $id6) {
                        DB::table('meal_books')->insert(['type' => 5, 'date' => $_SESSION['month'] . '-' . $day, 'booking_id' => $id,
                            'meal_id' => $id6]);

                    }
                }
            }
        }


        }


  if((isset($request->id7))&&isset($request->id2) &&isset($request->id3)&&isset($request->id4)&&isset($request->id5)&&isset($request->id6 ))
        {
            foreach ($_SESSION['days'] as $day) {
                foreach ($request->id7 as $id) {


                        
       


                       
                    
                    foreach ($request->id2 as $id2) {
                        DB::table('meal_books')->insert(['type' => 1, 'date' => $_SESSION['month'] . '-' . $day, 'employee_id' => $id,
                            'meal_id' => $id2 ]);

                     
                    }
               
                
           }
       }

          foreach ($_SESSION['days'] as $day) {
                foreach ($request->id7 as $id) {


                        
       


                       
                    
                    foreach ($request->id3 as $id3) {
                        DB::table('meal_books')->insert(['type' => 2, 'date' => $_SESSION['month'] . '-' . $day, 'employee_id' => $id,
                            'meal_id' => $id3 ]);

                     
                    }
               
                
           }
       }

          foreach ($_SESSION['days'] as $day) {
                foreach ($request->id7 as $id) {


                        
       


                       
                    
                    foreach ($request->id4 as $id4) {
                        DB::table('meal_books')->insert(['type' => 3, 'date' => $_SESSION['month'] . '-' . $day, 'employee_id' => $id,
                            'meal_id' => $id4 ]);

                     
                    }
               
                
           }
       }

            foreach ($_SESSION['days'] as $day) {
                foreach ($request->id7 as $id) {


                        
       


                       
                    
                    foreach ($request->id5 as $id5) {
                        DB::table('meal_books')->insert(['type' => 4, 'date' => $_SESSION['month'] . '-' . $day, 'employee_id' => $id,
                            'meal_id' => $id5 ]);

                     
                    }
               
                
           }
       }

           foreach ($_SESSION['days'] as $day) {
                foreach ($request->id7 as $id) {


                        
       


                       
                    
                    foreach ($request->id6 as $id6) {
                        DB::table('meal_books')->insert(['type' => 5, 'date' => $_SESSION['month'] . '-' . $day, 'employee_id' => $id,
                            'meal_id' => $id6 ]);

                     
                    }
               
                
           }
       }


        }




if (!isset($request->id7) && !isset($request->id)) 
    # code...

        {

            $message="please select guests or employees and Recipes For All Meals";
            $users=array();
            $days=$_SESSION['days'];
            for ($i=0; $i <count($days) ; $i++) { 
        $bookings=booking::where("paid",1)->where("from","<=",$_SESSION['month'] . '-' . $days[$i])->where("to",">=",$_SESSION['month'] . '-' . $days[$i])->get();
        foreach ($bookings as $booking) {
            if (count($users)==0) {
                array_push($users, $booking);
            }
                else
                {
                    $check=0;
                    for ($x=0; $x <count($users) ; $x++) { 
                        if ($users[$x]->id==$booking->id) {
                            # code...
                       
                    $check=1;

                        }
                        
                        # code...
                    }
                    if ($check==0) {
                                            array_push($users, $booking);

                            # code...
                        }

                }
                # code...
            }
            # code...

        }

         $employee=employee::all();


/*
        $days=array();
        for ($i=1;$i<32;$i++)
        {
            if ($request->input($i) != null)
            {
                array_push($days,$i);
            }
        }
        $_SESSION['days']=$days;
        //  exit();
        $users=booking::where('paid','=','1');*/
        $meal=DB::table('meals')->get();
        $data = array('meals' => $meal,'users'=>$users,'employees'=>$employee);


            return view('meals.viewDays',$data)->with("message",$message);

        }


            return redirect("/assingAllMeals");


        /*else
        {
            $message="please select guests and Recipes For All Meals";
            $users=booking::all();
            $meal=DB::table('meals')->get();
            $data = array('meals' => $meal,'users'=>$users,'message'=>$message);
            return view('meals.viewDays',$data);

        }*/
        /*
              foreach ($request->id as $id)
                  DB::table('exercise_bookings')->insert(['duration'=>0,'start'=>$request->start,'end'=>$request->end,'booking_id'=>$id,
                      'exercise_id'=>$request->exercise_id]);
          */
    }
    public function view(Request $request)
    {
       // $meal = meal_book::all()->unique('meal_id');
        $data=null;
        if($request->isMethod('post')) {
            $mealb=array();
            $mealam=array();
            $meall=array();
            $mealpm=array();
            $meald=array();

            $maals =meal::all();
            foreach ($maals as $maal) {
                $m = meal_book::where('type', '=', '1')->where('date','=',$request->input('day'))->where('meal_id',$maal->id)->first();
                if ($m !=null)

                    array_push($mealb,$m);
            }
            foreach ($maals as $maal) {
                $m = meal_book::where('type', '=', '2')->where('date','=',$request->input('day'))->where('meal_id',$maal->id)->first();
              if ($m !=null)

                array_push($mealam,$m);
            }
            foreach ($maals as $maal) {
                $m = meal_book::where('type', '=', '3')->where('date','=',$request->input('day'))->where('meal_id',$maal->id)->first();
                if ($m !=null)

                    array_push($meall,$m);
            }
            foreach ($maals as $maal) {
                $m = meal_book::where('type', '=', '4')->where('date','=',$request->input('day'))->where('meal_id',$maal->id)->first();
                if ($m !=null)

                    array_push($mealpm,$m);
            }
            foreach ($maals as $maal) {
                $m = meal_book::where('type', '=', '5')->where('date','=',$request->input('day'))->where('meal_id',$maal->id)->first();
                if ($m !=null)

                    array_push($meald,$m);
            }


            $data = array('mealbs' => $mealb, 'mealams' => $mealam, 'smealls' => $meall, 'smealpms' => $mealpm, 'mealds' => $meald);
            return view('meals.assingAllMeals', $data);
        }

        return view('meals.assingAllMeals');

    }
    //$request request
     public function report(Request $request)
    {
     
        if($request->isMethod('post'))
         {
           
          $start = $request->input("start");
          $end = $request->input("end");
                       $meal_book=meal_book::where('date','>=',$start)->where('date','<=',$end)->get();

         $ingredients = ingredient::all();
         $quantities=array();
                  $prices=array();

         foreach ($ingredients as $ing) {
                     $quantity=0;
                     $price=0;


             foreach ($meal_book as $meal) {
                 $meal_ings=$meal->meal->ingredients;
                 foreach ($meal_ings as $meal_ing) {
                     if ($meal_ing->ingredient_id==$ing->id) {
                        $quantity+=$meal_ing->quantity;
                        $price+=$meal_ing->quantity*$ing->cost;

                     }
                     

                 }
             }
             array_push($quantities, $quantity);
                     array_push($prices, $price);
         }
          $data=array('ingredients'=> $ingredients,'quantities'=> $quantities,'prices'=> $prices);

        return view('meals.viewReport',$data);
     }

        return view('meals.viewReport');
        
    }

 
}
