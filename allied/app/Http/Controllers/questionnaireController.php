<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\questionaire;
use Illuminate\Support\Facades\Auth;

class questionnaireController extends Controller
{
    //


    public function create(Request $request,$id)
    {
        if (Auth::id() == null) {
            return redirect("/booknow");

        }
        $questionaire=questionaire::where('book_id',Auth::id())->first();

        if($request->isMethod('post'))
        {
            if ($questionaire==null)  {
                            $questionaire=new questionaire();

                # code...
            }
            $questionaire->question_one=$request->input("question_one");
            $questionaire->question_two=$request->input("question_two");
            $questionaire->question_three=$request->input("question_three");
            $questionaire->question_four=$request->input("question_four");
            $questionaire->question_five=$request->input("question_five");
            $questionaire->question_six=$request->input("question_six");
            $questionaire->question_seven=$request->input("question_seven");
            $questionaire->question_eight=$request->input("question_eight");
            $questionaire->question_nine=$request->input("question_nine");
            $questionaire->question_ten=$request->input("question_ten");
            $questionaire->question_eleven=$request->input("question_eleven");
            $questionaire->question_twelve=$request->input("question_twelve");
            $questionaire->question_thirteen=$request->input("question_thirteen");
            $questionaire->question_fourteen=$request->input("question_fourteen");
            $questionaire->question_fifteen=$request->input("question_fifteen");
            $questionaire->question_sixteen=$request->input("question_sixteen");
            $questionaire->question_seventeen=$request->input("question_seventeen");

            $questionaire->question_eighteen=$request->input("question_eighteen");
            $questionaire->question_ninteen=$request->input("question_nineteen");
            $questionaire->question_twenty=$request->input("twenty");
            $questionaire->question_twenty1=$request->input("twenty_one");
            $questionaire->question_twenty2=$request->input("twenty_two");
            $questionaire->question_twenty3=$request->input("twenty_three");
            $questionaire->question_twenty4=$request->input("twenty_four");
            $questionaire->question_twenty5=$request->input("twenty_five");
            $questionaire->question_twenty6=$request->input("twenty_six");
            $questionaire->question_twenty7=$request->input("twenty_seven");

            $questionaire->question_twenty8=$request->input("twenty_eight");

            $questionaire->book_id=Auth::id();
            $questionaire->save();



            return view("questionnaire.acongrate");
        }
        if ($questionaire!=null) {
            $data = array('id' => $id,'questionaire'=>$questionaire);

        return view('questionnaire.acreate',$data);
            # code...
        }
        else
        {
        $data = array('id' => $id);

        return view('questionnaire.acreate',$data);
    }
    }
    public function create_ar(Request $request,$id)
    {
        if (Auth::id() == null) {
            return redirect("/booknow");

        }
        $questionaire=questionaire::where('book_id',Auth::id())->first();

        if($request->isMethod('post'))
        {
            if ($questionaire==null)  {
                            $questionaire=new questionaire();

                # code...
            }
            $questionaire->question_one=$request->input("question_one");
            $questionaire->question_two=$request->input("question_two");
            $questionaire->question_three=$request->input("question_three");
            $questionaire->question_four=$request->input("question_four");
            $questionaire->question_five=$request->input("question_five");
            $questionaire->question_six=$request->input("question_six");
            $questionaire->question_seven=$request->input("question_seven");
            $questionaire->question_eight=$request->input("question_eight");
            $questionaire->question_nine=$request->input("question_nine");
            $questionaire->question_ten=$request->input("question_ten");
            $questionaire->question_eleven=$request->input("question_eleven");
            $questionaire->question_twelve=$request->input("question_twelve");
            $questionaire->question_thirteen=$request->input("question_thirteen");
            $questionaire->question_fourteen=$request->input("question_fourteen");
            $questionaire->question_fifteen=$request->input("question_fifteen");
            $questionaire->question_sixteen=$request->input("question_sixteen");
            $questionaire->question_seventeen=$request->input("question_seventeen");

            $questionaire->question_eighteen=$request->input("question_eighteen");
            $questionaire->question_ninteen=$request->input("question_nineteen");
            $questionaire->question_twenty=$request->input("twenty");
            $questionaire->question_twenty1=$request->input("twenty_one");
            $questionaire->question_twenty2=$request->input("twenty_two");
            $questionaire->question_twenty3=$request->input("twenty_three");
            $questionaire->question_twenty4=$request->input("twenty_four");
            $questionaire->question_twenty5=$request->input("twenty_five");
            $questionaire->question_twenty6=$request->input("twenty_six");
            $questionaire->question_twenty7=$request->input("twenty_seven");

            $questionaire->question_twenty8=$request->input("twenty_eight");

            $questionaire->book_id=Auth::id();
            $questionaire->save();



            return view("questionnaire.congrate");
        }
        if ($questionaire!=null) {
            $data = array('id' => $id,'questionaire'=>$questionaire);

        return view('questionnaire.create',$data);
            # code...
        }
        else
        {
        $data = array('id' => $id);

        return view('questionnaire.create',$data);
    }
    }
}
