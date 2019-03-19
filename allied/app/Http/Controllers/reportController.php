<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;

class reportController extends Controller
{
    public function allExercise()
    {
        $users=DB::table('bookings')->join('users','bookings.user_id','=','users.id')->leftJoin('exercise_bookings','bookings.user_id','=','exercise_bookings.booking_id')
            ->leftJoin('exercises','exercises.id','=','exercise_bookings.exercise_id')->groupBy('bookings.id')
            ->selectRaw('bookings.id as id,users.name as name,users.email as email,sum(exercises.calories) as sum,bookings.daily_burning as daily,bookings.from as date')
            ->get();
        for($i=0;$i<sizeof($users);++$i)
        {
            $datetime2 = new DateTime($users[$i]->date);
            $interval = $datetime2->diff(Carbon::now());
            $days = $interval->format('%a');
            $db=$users[$i]->daily*$days;
            $users[$i]->sum+=$db;
        }
        $data=array('users'=>$users);
        return view('Report.report',$data);
    }
    public function dailyExercise($id)
    {
        $user=DB::table('bookings')->join('users','bookings.user_id','=','users.id')->leftJoin('exercise_bookings','bookings.user_id','=','exercise_bookings.booking_id')
            ->leftJoin('exercises','exercises.id','=','exercise_bookings.exercise_id')->groupBy('bookings.id')
            ->selectRaw('bookings.id as id,users.name as name,users.email as email,sum(exercises.calories) as sum,bookings.daily_burning as daily,bookings.from as date')->where('bookings.id','=',$id)
            ->get();
        $datetime2 = new DateTime($user[0]->date);
        $interval = $datetime2->diff(Carbon::now());
        $days = $interval->format('%a');
        $db=$user[0]->daily*$days;
        $user[0]->sum+=$db;
        $report=DB::table('exercise_bookings')->join('exercises','exercises.id','=','exercise_bookings.exercise_id')->
        orderBy('exercise_bookings.date')->having('exercise_bookings.booking_id','=',$id)->get();
        $reportSum=DB::table('exercise_bookings')->selectRaw('*,sum(exercises.calories) as sum')->join('exercises','exercises.id','=','exercise_bookings.exercise_id')->groupBy('exercise_bookings.date')
        ->having('exercise_bookings.booking_id','=',$id)->get();
        $j=0;$i=0;
        for($i;$i<sizeof($report);++$i)
        {
            $report[$i]->sum=0;
            if($report[$i]->date>$reportSum[$j]->date)
            {
                $report[$i-1]->sum=$reportSum[$j]->sum;
                ++$j;
            }
        }
        $report[$i-1]->sum=$reportSum[$j]->sum;
        $data=array('user'=>$user,'reports'=>$report);
        return view('Report.dailyReport',$data);
    }

}
