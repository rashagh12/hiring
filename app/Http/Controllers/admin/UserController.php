<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\counter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index() {
        $users = User::orderBy('created_at','DESC')->paginate(8);
        $projects = counter::latest()->paginate(5);
        counter::increment('views');

        return view('admin.users.list',[
            'users' => $users,
            'projects' =>$projects
        ]);
    }

    public function edite($id){
        $user = User::findOrFail($id);
        return view('admin.users.edite',[
            "user" => $user,
        ]);

    }
    
    public function update(Request $request){
        
        $id = Auth::user()->id;

        $validator = Validator::make($request->all(),[
            'name' => 'required|min:5|max:20',
            'email' => 'required|email|unique:users,email,'.$id.',id'
        ]);


        if ($validator->passes()) {

            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->designation = $request->designation;
            $user->save();

            session()->flash('success','User information updated successfully.');

            // return response()->json([
            //     'status' => true,
            //     'errors' => []
            // ]);
            return redirect()->route('admin.users');

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function deleteuser(Request $request){
        $id = $request->id;
        
        $user = User::find($id);
        if($user == null){
            session()->flash('errors','User not found');
            return response()->json([
                'status' => false,
            ]);
        }
        $user->delete();
        session()->flash('success','User deleted successfully');
        return redirect()->route('admin.users');
    }
    public function viewcv($id){
        $user =User::find($id);
        return view('admin.users.cv',[
            'user' =>$user,
        ]);

    }
}
