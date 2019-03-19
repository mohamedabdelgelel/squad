<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\department;
use App\job;

class JobController extends Controller
{
    //

    public function view()
    {
        $jobs = job::all();
        $data = array('jobs' => $jobs);
        return view('job.view', $data);
    }
    public function create(Request $request)
    {
        if($request->isMethod('post'))
        {
            $job=new job();
            $job->name=$request->input("name");
            $job->department_id=$request->input("department_id");
            $job->save();


            return redirect("/viewJobs");
        }
        $departments = department::all();
        $data = array('departments' => $departments);
        return view('job.create',$data);
    }
    public function update($id,Request $request)
    {
        $job=job::find($id);

        if($request->isMethod('post'))
        {
            $job->name=$request->input("name");
            $job->department_id=$request->input("department_id");

            $job->save();


            return redirect("/viewJobs");
        }

        $departments = department::all();
        $data = array('departments' => $departments,'job'=>$job);

        return view('job.update',$data);
    }
    public function delete($id){
        $job=job::find($id);
        $job->delete();
        return redirect("/viewJobs");
    }
}
