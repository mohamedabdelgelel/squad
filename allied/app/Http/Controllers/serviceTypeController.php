<?php

namespace App\Http\Controllers;

use App\service_type;
use Illuminate\Http\Request;

class serviceTypeController extends Controller
{
    public function view()
    {
        $service=service_type::all();
        $data=array('service'=>$service);
        return view('service.view',$data);
    }
    public function create(Request $request)
    {
        if($request->isMethod('post'))
        {
            $service = new service_type();
            $service->name = $request->input("name");
            $service->save();
            return redirect("/viewService");
        }

        return view('service.create');
    }
    public function update(Request $request,$id)
    {
        $service=service_type::find($id);

        if($request->isMethod('post'))
        {
            $service->name = $request->input("name");

            $service->save();
            return redirect("/viewService");
        }
        $data=array('service'=>$service);
        return view('service.update',$data);
    }
    public function delete($id)
    {
        $service=service_type::find($id);
        $service::where ('id',@$id)->delete();
        return redirect("/viewService");
    }
}
