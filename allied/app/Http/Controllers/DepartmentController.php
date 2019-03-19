<?php

namespace App\Http\Controllers;

use App\department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    //

    public function view()
    {
        $departments = department::all();
        $data = array('departments' => $departments);
        return view('department.view', $data);
    }
    public function create(Request $request)
    {
        if($request->isMethod('post'))
        {
            $department=new department();
            $department->name=$request->input("name");
            $department->save();


            return redirect("/viewDepartments");
        }
        return view('department.create');
    }
    public function update($id,Request $request)
    {
        $department=department::find($id);

        if($request->isMethod('post'))
        {
            $department->name=$request->input("name");
            $department->save();


            return redirect("/viewDepartments");
        }

        $data = array('department' => $department);

        return view('department.update',$data);
    }
    public function delete($id){
        $department=department::find($id);
        $department->delete();
        return redirect("/viewDepartments");
    }
}
