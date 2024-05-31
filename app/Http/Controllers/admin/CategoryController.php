<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::orderBy('created_at','DESC')->paginate(7);
        return view('admin.category.index',[
            'categories' => $categories
        ]);
        
    }
    public function createCategory(){
        return view('admin.category.create');
    }


    public function saveCategory(Request $request){
        $rules =[
            'name' =>'required',
        ];
        $validator =Validator::make($request->all(),$rules);

        if($validator->passes()){

            $categories =new Category();
            $categories->name = $request->name;
            $categories->save();
            session()->flash('success','Category added successfully.');

            return redirect()->route('admin.category',$categories->id) ;
            }
            else {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
            }

    }

    public function editCategory($id){
        $category =Category::findOrFail($id);
        $data=[
            'category' => $category,
        ];
        return view('admin.category.edit',$data);
    }

    public function updateCategory(Request $request ,$id){
        $request->validate([
            'name' => 'required',
        ]);

        $category = Category::find($id);
        $category->name = $request->name;
        $category->save();
        return redirect()->route('admin.category')->with("success","Updated  Successfully");


    }

    public function deleteCategory($id){
        $category=Category::find($id);

        $category->delete();
        return redirect()->route('admin.category')->with("success","Deleted Successfully");

    }
}
