<?php

namespace App\Http\Controllers;

use App\admin;
use App\user_role;
use Illuminate\Http\Request;
use App\employee;
class RoleController extends Controller
{
    //
    public function logout()
    {
        session_destroy();
        return redirect('login-admin');
    }
    public function login(Request $request)
    {
        if($request->isMethod('post'))
        {
            $admin =admin::where('user_name','=',$request->input("name"))->first();
            if ($admin!=null)
            {
                if ($admin->password==$request->input("password"))
                {
                    if ($admin->type==0)
                    {
                        $_SESSION['role']=0;

                        return redirect('/viewFloors');
                    }
                    else
                    {
                        $_SESSION['role']=1;
foreach ($admin->roles as $role)
                        {
                            if ($role->role=='Booking')
                            {
                                $_SESSION['Booking']=true;

                            }
                            if ($role->role=='House')
                            {
                                $_SESSION['House']=true;

                            }
                            if ($role->role=='Food')
                            {
                                $_SESSION['Food']=true;

                            }
                            if ($role->role=='Financial')
                            {
                                $_SESSION['Financial']=true;

                            }
                            if ($role->role=='Laundry')
                            {
                                $_SESSION['Laundry']=true;

                            }
                            if ($role->role=='Spa')
                            {
                                $_SESSION['Spa']=true;

                            }
                            if ($role->role=='Service')
                            {
                                $_SESSION['Service']=true;

                            }
                            if ($role->role=='Inventory')
                            {
                                $_SESSION['Inventory']=true;

                            }
                            if ($role->role=='Shop')
                            {
                                $_SESSION['Shop']=true;

                            }
                            if ($role->role=='Maintenance')
                            {
                                $_SESSION['Maintenance']=true;

                            }
                            if ($role->role=='HR')
                            {
                                $_SESSION['HR']=true;

                            }
                            if ($role->role=='Activities')
                            {
                                $_SESSION['Activities']=true;

                            }

                        }
                        if ($admin->roles[0]->role=='Booking')
                        {
                            return redirect('/viewBooking');

                        }
                        if ($admin->roles[0]->role=='Activities')
                        {
                            return redirect('/viewExercise');

                        }
                        if ($admin->roles[0]->role=='HR')
                        {
                            return redirect('/viewEmployee');

                        }
                        if ($admin->roles[0]->role=='Maintenance')
                        {
                            return redirect('/viewMaintenance');

                        }
                        if ($admin->roles[0]->role=='Shop')
                        {
                            return redirect('/ViewShopBooking');

                        }
                        if ($admin->roles[0]->role=='Inventory')
                        {
                            return redirect('/ViewInventory');

                        }
                        if ($admin->roles[0]->role=='Service')
                        {
                            return redirect('/viewBookingExtra');

                        }
                        if ($admin->roles[0]->role=='Spa')
                        {
                            return redirect('/viewExtra');

                        }
                        if ($admin->roles[0]->role=='Laundry')
                        {
                            return redirect('/viewService');

                        }
                        if ($admin->roles[0]->role=='Financial')
                        {
                            return redirect('/viewBooking');

                        }
                        if ($admin->roles[0]->role=='Food')
                        {
                            return redirect('/viewMeals');

                        }
                        if ($admin->roles[0]->role=='House')
                        {
                            return redirect('/viewHouseKeeping');

                        }


                    }
                }
            }

        }
        return view('Roles.login');

    }
    public function create(Request $request)
    {
        if($request->isMethod('post'))
        {
            $admin=new admin();
            $admin->user_name=$request->input("username");
            $admin->employee_id=$request->input("employee");
            $admin->password=$request->input("password");
            $admin->type=1;


            $admin->save();
            if ($request->input("Booking")!=null)
            {
                $role = new user_role();
                $role->admin_id=$admin->id;
                $role->role="Booking";
                $role->save();


            }
            if ($request->input("Food")!=null)
            {
                $role = new user_role();
                $role->admin_id=$admin->id;
                $role->role="Food";
                $role->save();
            }
            if ($request->input("Activities")!=null)
            {
                $role = new user_role();
                $role->admin_id=$admin->id;
                $role->role="Activities";
                $role->save();
            }
            if ($request->input("HR")!=null)
            {
                $role = new user_role();
                $role->admin_id=$admin->id;
                $role->role="HR";
                $role->save();
            }
            if ($request->input("Maintenance")!=null)
            {
                $role = new user_role();
                $role->admin_id=$admin->id;
                $role->role="Maintenance";
                $role->save();
            }
            if ($request->input("Shop")!=null)
            {
                $role = new user_role();
                $role->admin_id=$admin->id;
                $role->role="Shop";
                $role->save();
            }
            if ($request->input("Inventory")!=null)
            {
                $role = new user_role();
                $role->admin_id=$admin->id;
                $role->role="Inventory";
                $role->save();
            }
            if ($request->input("Spa")!=null)
            {
                $role = new user_role();
                $role->admin_id=$admin->id;
                $role->role="Spa";
                $role->save();
            }
            if ($request->input("Service")!=null)
            {
                $role = new user_role();
                $role->admin_id=$admin->id;
                $role->role="Service";
                $role->save();
            }
            if ($request->input("Laundry")!=null)
            {
                $role = new user_role();
                $role->admin_id=$admin->id;
                $role->role="Laundry";
                $role->save();
            }
            if ($request->input("House")!=null)
            {
                $role = new user_role();
                $role->admin_id=$admin->id;
                $role->role="House";
                $role->save();
            }
            if ($request->input("Financial")!=null)
            {
                $role = new user_role();
                $role->admin_id=$admin->id;
                $role->role="Financial";
                $role->save();
            }



            return redirect("/viewRoles");
        }
        $employees = employee::all();
        $data = array('employees' => $employees);
        return view('Roles.addroles',$data);

    }

public function viewRoles(Request $request)
    {
        $admins=admin::all();
        
        $data = array('admins' => $admins);
        return view('Roles.viewroles',$data);

    }
    public function delete($id)
    {
        $admin=admin::find($id);
        $admin->delete();
                                   return redirect('/viewRoles');


    }


}
