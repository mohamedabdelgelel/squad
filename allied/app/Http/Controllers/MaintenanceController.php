<?php

namespace App\Http\Controllers;

use App\location;
use App\maintenance;
use Illuminate\Http\Request;use PhpParser\Builder\Use_;
use App\room;
class MaintenanceController extends Controller
{

    public function view()
    {
        $maintenance = maintenance::all();
        $data = array('maintenances' => $maintenance);
        return view('Maintenance.view', $data);
    }

    public function  details($id)
    {
        $employee = maintenance::find($id);
        $data = array( 'employee' => $employee);
        return view('Maintenance.details', $data);

    }
    public function  delete($id)
    {
        $employee = maintenance::find($id);
        $employee->delete();
        return redirect("/viewMaintenance");

    }
    public function create(Request $request)
    {
        if($request->isMethod('post'))
        {
            $maintenance=new maintenance();
            $maintenance->cause=$request->input("cause");
            $maintenance->cost=$request->input("cost");

            $maintenance->type=$request->input("type");
            $maintenance->start=$request->input("date");
            if ($maintenance->type=="scheduled")
            {
                $maintenance->duration=$request->input("duration");
                $maintenance->end=date('Y-m-d', strtotime($maintenance->start. ' + '. $request->input("duration").' days'));

            }
            if ($request->input("location")!=0)
            {
                $maintenance->location_id=$request->input("location");

            }
            if ($request->input("room")!=0)
            {
                $maintenance->room_id=$request->input("room");

            }
            $maintenance->save();


            return redirect("/viewMaintenance");
        }

        $rooms=room::all();
        $locations =location::all();
        $data = array('rooms' => $rooms,'locations'=>$locations);

        return view('Maintenance.create',$data);
    }
}
