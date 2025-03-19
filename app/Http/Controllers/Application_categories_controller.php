<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\ApplicationCategory;

class Application_categories_controller 
{
    public function show_application_categories(){
        $all_categories = ApplicationCategory::select('id','name', 'image', 'slug')->get()->toArray();
        return view('admin.application-category.application-categories', compact('all_categories'));
    }

    public function add_application_categories(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        try{
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $category = new ApplicationCategory();
            $category->name = $request->name;
            $category->image = 'images/'.$imageName;
            $category->slug = $request->slug;
            $category->save();
            return back()->with('success', 'Category added successfully');
        }catch(queryException $e){
            if ($e->getcode() == 23000){
                return back()->with('error','Category with slug already exists');
            }
            return back()->with('error','Something went wrong');
        }
    
      
    }

    public function show_edit_application_categories($id){
        $category = ApplicationCategory::findOrFail($id);
        return view('admin.application-category.edit-category', compact('category'));
    }

    public function edit_application_category(Request $request,$id){
        $category = ApplicationCategory::findOrFail($id);
        $request->validate([
           'name'=>'required',
           'slug'=>'required',
        ]);

        $category->name = $request->name;
        $category->slug = $request->slug;
        if($request->image != null){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path("images"),$imageName);
            $category->image = 'images/' . $imageName;
        }
        $category->save();
        return redirect()->to('/');
    }

    public function delete_application_category(Request $request,  $id){
        $res = ApplicationCategory::where('id',$id)->delete();
        return back()->with('success', 'Category deleted successfully');
    }

}