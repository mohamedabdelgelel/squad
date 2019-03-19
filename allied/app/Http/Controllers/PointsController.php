<?php

namespace App\Http\Controllers;

use App\points;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PointsController extends Controller
{
    public function view()
    {
        $points = points::all();
        $data = array('points' => $points);
        return view('Points.view', $data);
    }
    public function create(Request $request)
    {
        if($request->isMethod('post'))
        {
            $points=new points();
            $points->name=$request->input("name");
          $points->name_arabic=$request->input("arabic");

            $points->start=$request->input("start");
            $points->finish=$request->input("finish");
                        
          //  $points->incentive_percentage=$request->input("incentive_percentage");
            $date=Carbon::now()->micro;

            if(!empty($request->file('image')))
            {
                $request->file('image')->storeAs(
                    'public/TierImages', $date.'.jpg'
                );
                $points->photo=$date.'.jpg';
            }
            $points->save();


            return redirect("/viewPoints");
        }

        return view('Points.create');
    }
    public function update($id,Request $request)
    {
        $points= points::find($id);
        if($request->isMethod('post'))
        {  
            $points->name=$request->input("name");
          $points->name_arabic=$request->input("arabic");

            $points->start=$request->input("start");
            $points->finish=$request->input("finish");
            $points->weight=$request->input("kg");

            $points->money=$request->input("money");

           // $points->incentive_percentage=$request->input("incentive_percentage");
            $date=Carbon::now()->micro;

            if(!empty($request->file('image')))
            {
                $request->file('image')->storeAs(
                    'public/TierImages', $date.'.jpg'
                );
                $points->photo=$date.'.jpg';
            }
            $points->save();

            return redirect("/viewPoints");
        }
        $data=array('points'=>$points);
        return view('Points.update',$data);
    }
    public function delete($id){
        $points=points::find($id);
        $points::where ('id',$id)->delete();
        return redirect("/viewPoints");
    }
    public function details($id)
    {
        $points= points::find($id);
        $data = array('points' => $points);
        return view('Points.details', $data);
    }
}
