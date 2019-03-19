<?php
namespace App\Http\Controllers;
use App\exercise;
use App\employee;
use App\exercise_booking;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Storage;
use App\booking;

class ExerciseController extends Controller
{
    //
    public function view()
    {
        $exercises = exercise::all();
        $data = array('exercises' => $exercises);
        return view('Exercise.viewExercise', $data);
    }
    public function create(Request $request)
    {
        $employees = employee::where('type',"=",'Freelancer')->get();
        // return $request;
        if($request->isMethod('post'))
        {
            // return $request;
            $exercise=new exercise();
            $exercise->name=$request->input("name");
            $exercise->duration=$request->input("duration");
            $exercise->calories=$request->input("calories");
            $exercise->calories_female=$request->input("female");

            $exercise->employee_id=$request->input("employee_id");
            $exercise->description=$request->input("description");
            $date=Carbon::now()->micro;
            if(!empty($request->file('image')))
            {
                $request->file('image')->storeAs(
                    'public/ExerciseImages', $date.'.jpg'
                );
                $exercise->photo=$date.'.jpg';
            }
            if(!empty($request->file('video')))
            {
                $request->file('video')->storeAs(
                    'public/ExerciseVideos', $date.'.mp4'
                );
                $exercise->video=$date.'.mp4';
            }
            $exercise->save();
            return redirect("/viewExercise");
        }
        $data = array('employees' => $employees);
        return view('Exercise.createExercise',$data);
    }
    public function index()
    {
        return Exercise::orderBy('name','DESC')->get();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exercise=DB::table('exercises')->where('id',$id)->get();
        $employees = employee::where('type',"=",'freelancer')->get();
       // $exercise[0]->photo=Storage::url('ExerciseImages/'.$exercise[0]->photo);
      //  $exercise[0]->video = Storage::url('exerciseVideos/'.$exercise[0]->video);
        $data = array('exercise' => $exercise[0],'employees'=>$employees);
        return view('Exercise.detailsExercise',$data);
    }
    public function get()
    {
        $exercises=DB::table('exercises')->orderBy('id','desc')->get();
        return $exercises;
    }
    public function viewAssigned(Request $request)
    {    $exercises = null;
        $data = array('exercises' => $exercises);
        if($request->isMethod('post')) {
            $exercise_books=array();
            $exercises = exercise::all();
foreach ($exercises as $exercise) {

    $exercise_booking = exercise_booking::where('date', '=', $request->input("day"))->where('exercise_id',$exercise->id)->first();
    if ($exercise_booking!=null)
    {
        array_push($exercise_books,$exercise_booking);

    }
}
            $data = array('exercises' => $exercise_books);
        }
        return view('Exercise.track', $data);

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exercise=DB::table('exercises')->where('id',$id)->get();
        $employees = employee::where('type',"=",'Freelancer')->get();
        $exercise[0]->photo=Storage::url('ExerciseImages/'.$exercise[0]->photo);
        $exercise[0]->video = Storage::url('exerciseVideos/'.$exercise[0]->video);
        $data = array('exercise' => $exercise[0],'employees'=>$employees);
        //  return $data;
        return view('Exercise.updateExercise',$data);
    }
    /**
     * Update the specified resource in storage.
    ظ
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(empty($id))
            return ;
        if(!empty($request->name))
            DB::table('exercises')->where('id',$id)->update(['name'=>$request->name]);
        if(!empty($request->duration))
            DB::table('exercises')->where('id',$id)->update(['duration'=>$request->duration]);
        if(!empty($request->employee_id))
            DB::table('exercises')->where('id',$id)->update(['employee_id'=>$request->employee_id]);
        if(!empty($request->calories))
            DB::table('exercises')->where('id',$id)->update(['calories'=>$request->calories]);
        if(!empty($request->description))
            DB::table('exercises')->where('id',$id)->update(['description'=>$request->description]);
        $data=DB::table('exercises')->where('id',$id)->get();
        $date=Carbon::now()->micro;
        if(!empty($request->file('image')))
        {
            $request->file('image')->storeAs(
                'public/ExerciseImages', $date.'.jpg'
            );
            Storage::delete('public/ExerciseImages/'.$data[0]->photo);
            DB::table('exercises')->where('id',$id)->update(['photo'=>$date.'.jpg']);
        }
        if(!empty($request->file('image')))
        {
            $request->file('video')->storeAs(
                'public/ExerciseVideos', $date.'.mp4'
            );
            Storage::delete('public/ExerciseVideos/'.$data[0]->video);
            DB::table('exercises')->where('id',$id)->update(['video'=>$date.'.mp4']);
        }
        return redirect()->route('editExercise', [$id]);
    }
    public function assign(Request $request)
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




                # code...
            
                    $exercises=DB::table('exercises')->get();
        $data = array('exercises' => $exercises,'users'=>$users);
        return view('Exercise.assignExercise',$data);

        /*
              foreach ($request->id as $id)
                  DB::table('exercise_bookings')->insert(['duration'=>0,'start'=>$request->start,'end'=>$request->end,'booking_id'=>$id,
                      'exercise_id'=>$request->exercise_id]);
          */
    }

    public function assignExercise(Request $request)
    {
        if(isset($request->id)&&isset($request->id2))
        {
            foreach ($_SESSION['days'] as $day) {
                foreach ($request->id as $id) {
                 //   echo($_SESSION['month'] . '-' . $day);
                   // exit();
                    $book=booking::find($id);
                
        if (new \DateTime($book->from)<= new \DateTime($_SESSION['month'] . '-' . $day) && new \DateTime($book->to)>= new \DateTime($_SESSION['month'] . '-' . $day))  {
                        # code...
                    

                    foreach ($request->id2 as $id2) {


                        DB::table('exercise_bookings')->insert(['duration' => $request->input('duration'.$id2),'time' => $request->input('time'.$id2) ,'date' => $_SESSION['month'] . '-' . $day, 'booking_id' => $id,
                            'exercise_id' => $id2]);

                    }
                }
            }
            }
            return redirect("/track");

        }
        else
        {
            $message="please select guests and Activities";
            $users=array();

$users=array();

            for ($i=0; $i <count($_SESSION['days']) ; $i++) { 
        $bookings=booking::where("paid",1)->where("from",">=",$_SESSION['month'] . '-' . $_SESSION['days'][$i])->where("to","<=",$_SESSION['month'] . '-' . $_SESSION['days'][$i])->get();
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
                        if ($check==0) {
                                            array_push($users, $booking);

                            # code...
                        }

                        # code...
                    }
                }
                # code...
            }
            # code...
        }


            
            $exercises=DB::table('exercises')->get();
            $data = array('exercises' => $exercises,'users'=>$users,'message'=>$message);
            return view('Exercise.assignExercise',$data);

        }
        /*
              foreach ($request->id as $id)
                  DB::table('exercise_bookings')->insert(['duration'=>0,'start'=>$request->start,'end'=>$request->end,'booking_id'=>$id,
                      'exercise_id'=>$request->exercise_id]);
          */
    }

    public function get_users(Request $request)
    {
        if(isset($request->month)) {
            $_SESSION['month'] = $request->input("month");
            $data = array('month' =>  $_SESSION['month']);
            // return $data;
            return view('meals.schedule',$data);
        }


        // return $data;
        return view('meals.schedule');
    }
    public function track($id)
    {
       /* $users=DB::table('bookings')->join('users','users.id','=','bookings.id')
            ->rightJoin('exercise_bookings','exercise_bookings.booking_id','=','bookings.id')->orderBy('exercise_bookings.date')
            ->where('exercise_bookings.exercise_id','=',$id)
            ->select('exercise_bookings.id','exercise_bookings.exercise_id','exercise_bookings.date','users.name','users.email')->get();
        $exercises=DB::table('exercises')->where('id',$id)->get();
        $data = array('exercise' => $exercises[0],'users'=>$users);*/

        return view('exercise.track');
    }
    public function delete_assign($id)
    {
        DB::table('exercise_bookings')->where('id', $id)->delete();
        return redirect()->route('/track');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$date)
    {
        DB::table('exercise_bookings')->where('exercise_id', $id)->where('date', $date)->delete();
        return redirect("/viewExercise");
    }


    public function delete($id)
    {
 $exercise = exercise::find($id);
 $exercise->delete();
         return redirect("/viewExercise");
    }
}