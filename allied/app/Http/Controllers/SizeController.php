<?php



namespace App\Http\Controllers;
use App\Size;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Array_;


class SizeController extends Controller
{
    public function viewSize(){
        $size = Size::all();
        $arr = Array('size'=>$size);
        return view("Size.view",$arr);
    }

    public function addSize(Request $request){

        if($request->isMethod('post')){
            $this->validate($request,[
                'name' => 'required|max:25|unique:sizes'
            ]);
            $newSize = new Size();
            $newSize->name = $request->input('name');
            $newSize->save();
            return redirect("ViewSize");
        }
        return view('Size.add');
    }

    public function editSize(Request $request, $id){

        if($request->isMethod('post')){
            $newSize=Size::find($id);
            $newSize->name = $request->input('name');
            $newSize->save();
            return redirect("ViewSize");
        }
        else{
            $size=Size::find($id);
            $arr = Array('size'=>$size);
            return view("Size.edit",$arr);
            return view('Size.edit');
        }

    }

}
