<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\points;
use App\user_bullets;

class userController extends Controller
{
    //

    public function view(Request $request)
    {
        if (Auth::id() == null) {
            return redirect("/booknow");

        }
if ($request->isMethod('post')) {
            $user = User::find(Auth::id());
            $user->first_name = $request->input("first_name");
            $user->last_name = $request->input("last_name");
            $user->phone = $request->input("phone");
            $user->email = $request->input("email");
            $user->address = $request->input("address");
            $user->save();
            return redirect("/profile");

        }
        $user = User::find(Auth::id());

        $rank=points::where('start','<=',$user->days)->where('finish','>=',$user->days)->first();


        $data = array('user' => $user,'rank'=>$rank);
        return view('auth.aprofile', $data);
    }

public function view_ar(Request $request)
    {
        if (Auth::id() == null) {
            return redirect("/booknow_ar");

        }
if ($request->isMethod('post')) {
            $user = User::find(Auth::id());
            $user->first_name = $request->input("first_name");
            $user->last_name = $request->input("last_name");
            $user->phone = $request->input("phone");
            $user->email = $request->input("email");
            $user->address = $request->input("address");
            $user->save();
            return redirect("/profile_ar");

        }
        $user = User::find(Auth::id());

        $rank=points::where('start','<=',$user->days)->where('finish','>=',$user->days)->first();


        $data = array('user' => $user,'rank'=>$rank);
        return view('auth.profile', $data);
    }


    public function details($id)
    {

        $user = User::find($id);
        $data = array('user' => $user);
        return view('User.details', $data);
    }


    public function addUser(Request $request)
    {

        if ($request->isMethod('post')) {
            $user=User::where('email','=', $request->input("email"))->first();
            if ($user==null) {


                $user = new User();
                $user->first_name = $request->input("first_name");
                $user->last_name = $request->input("last_name");
                $user->phone = $request->input("phone");

                $user->email = $request->input("email");
                $user->address = $request->input("address");
                $user->gender = $request->input("gender");
                $user->country = $request->input("country");
                $user->gender = $request->input("gender");
                $user->national_id = $request->input("national_id");
                $time = strtotime($request->input("month").'/'.$request->input("day").'/'.$request->input("year"));

                $newformat = date('Y-m-d',$time);
                $user->age = $newformat;
                $password = $request->input("password");
                $confirm = $request->input("confirm");
                if ($password == $confirm) {
                    $user->password = Hash::make($password);
                } else {
                    $message = "password is not matched";
                    return redirect("/addUser")->with("message", $message);


                }

                $user->save();
                return redirect("/bookInside/" . $user->id);
            }
            else
            {

                $message = "Email you have entered is already in use";
                return redirect("/addUser")->with("message", $message);
            }

        //    return redirect("/profile");

        }

        return view('User.addUser');
    }
public function viewUsers(Request $request)
{

    $users=User::all();
    $data = array('users' => $users);
    if ($request->isMethod('post')) {
        $id= $request->input("user");


        return redirect("/bookInside/".$id);

    }
    return view('User.viewUsers', $data);

}
public function addbullets(Request $request)
{

    $users=User::all();
    $data = array('users' => $users);
    if ($request->isMethod('post')) {
        $id= $request->input("user");
        $user=User::find($id);
        $user->bullets+=$request->input("quantity");
        $user_bullets=new user_bullets();
        $user_bullets->user_id=$id;
        $user_bullets->quantity=$request->input("quantity");
        $user_bullets->reason=$request->input("reason");
        $user_bullets->save();
        $user->save();




    }
    return view('User.increasebullets', $data);

}
public function decreasebullets(Request $request)
{

    
    $users=User::all();
    $data = array('users' => $users);
    if ($request->isMethod('post')) {
         
         $id= $request->input("user");
        $user=User::find($id);
        $user->bullets-=$request->input("quantity");
        $user_bullets=new user_bullets();
        $user_bullets->user_id=$id;
        $user_bullets->quantity=-$request->input("quantity");
        $user_bullets->reason=$request->input("reason");
        $user_bullets->save();
        $user->save();



    }
    return view('User.decreasebullets', $data);

}
public function viewIncreasedBullets()
{

$user_bullets=user_bullets::where('quantity','>',0)->get();
        $data = array('users' => $user_bullets);


    return view('User.viewincreased', $data);

}
public function viewDecreasedBullets()
{

$user_bullets=user_bullets::where('quantity','<',0)->get();
    $data = array('users' => $user_bullets);


    return view('User.viewdecreased', $data);

}

}
