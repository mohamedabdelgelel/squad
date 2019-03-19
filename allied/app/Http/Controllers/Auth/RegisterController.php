<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/book';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',

            'phone' => 'required|numeric',
            'address' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'national_id' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);
                 $this->registered($request, $user);

         if ($request->lang=="arab") {

         return redirect('/book_ar');

            }
            else
            {
                         return redirect('/book');

            }

                        
    }

    protected function create(array $data)
    {
        $time = strtotime($data['month'].'/'.$data['Days'].'/'.$data['year']);

        $newformat = date('Y-m-d',$time);
        if ($data['country']=="مصر") {
            $data['country']="Egypt";
            # code...
        }
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],

            'email' => $data['email'],
            'gender' => $data['gender'],
            'country' => $data['country'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'age' => $newformat,

            'national_id' => $data['national_id'],


            'password' => Hash::make($data['password']),
        ]);
    }
}
