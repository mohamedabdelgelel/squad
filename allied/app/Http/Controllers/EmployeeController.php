<?php

namespace App\Http\Controllers;

use App\employee;
use App\job;
use App\vacation;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Storage;


class EmployeeController extends Controller
{
    public function view()
    {
        $employees = employee::all();
        $data = array('employees' => $employees);
        return view('Employee.view', $data);
    }

    public function addVacation(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $vacation = new vacation();
            $vacation->employee_id = $id;
            $vacation->start = $request->input("start");
            $vacation->type = $request->input("type");
            $vacation->end = $request->input("end");
            $vacation->save();
            return redirect("/viewEmployee");


        }
        $data = array('id' => $id);
        return view('Employee.addVacation', $data);

    }

    public function viewVacation($id)
    {
        $vacations = vacation::where('employee_id', $id)->get();
        $data = array('vacations' => $vacations);
        return view('Employee.viewVacation', $data);


    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $employee = new employee();
            $employee->first_name = $request->input("first_name");
            $employee->last_name = $request->input("last_name");

            $employee->qualification = $request->input("qualification");
            $employee->marital = $request->input("marital");

            $employee->army = $request->input("army");
            $employee->salary_constant = $request->input("salary_constant");
            $employee->salary_change = $request->input("salary_change");
            $employee->salary_allowances = $request->input("salary_allowances");
            $employee->rewards = $request->input("rewards");
            $employee->address = $request->input("address");

            $employee->date_of_birth = $request->input("date_of_birth");
            $employee->phone = $request->input("phone");
            $date = Carbon::now()->micro;

            $request->file('image')->storeAs(
                'public/ExerciseImages', $date . '.jpg'
            );
            $employee->photo = $date . '.jpg';

            $employee->national_id = $request->input("national_id");
            $employee->job_id = $request->input("job_id");
            $employee->type = $request->input("type");
            if ($request->input("insurance") == "yes") {
                $employee->insurance = true;
            } else {
                $employee->insurance = false;

            }
            if ($request->input("taxes") == "yes") {
                $employee->taxes = true;
            } else
                $employee->taxes = false;


            $employee->save();


            return redirect("/viewEmployee");
        }
        $jobs = job::all();
        $data = array('jobs' => $jobs);
        return view('Employee.create', $data);
    }

    public function update(Request $request, $id)
    {
        $employee = employee::find($id);
        if ($request->isMethod('post')) {
            $employee->first_name = $request->input("first_name");
            $employee->last_name = $request->input("last_name");

            $employee->qualification = $request->input("qualification");
            $employee->army = $request->input("army");
            $employee->salary_constant = $request->input("salary_constant");
            $employee->salary_change = $request->input("salary_change");
            $employee->salary_allowances = $request->input("salary_allowances");
            $employee->rewards = $request->input("rewards");
            $employee->address = $request->input("address");

            $employee->date_of_birth = $request->input("date_of_birth");
            $employee->phone = $request->input("phone");


            $employee->national_id = $request->input("national_id");
            $employee->job_id = $request->input("job_id");
            $employee->type = $request->input("type");
            if ($request->input("insurance") != null) {
                $employee->insurance = true;
            } else {
                $employee->insurance = false;

            }
            if ($request->input("taxes") != null) {
                $employee->taxes = true;
            } else
                $employee->taxes = false;


            $employee->save();


            return redirect("/viewEmployee");
        }
        $jobs = job::all();
        $data = array('jobs' => $jobs, 'employee' => $employee);
        return view('Employee.update', $data);
    }
    public function  details($id)
    {
        $employee = employee::find($id);
        $data = array( 'employee' => $employee);
        return view('Employee.details', $data);

    }

    public function delete($id)
    {
        $employee = employee::find($id);
        $employee->delete();
        return redirect("/viewEmployee");


    }
    public function deleteVacation($id)
    {
        $employee = vacation::find($id);
        $employee->delete();
        return redirect("/viewVacations/".$id);


    }
}
