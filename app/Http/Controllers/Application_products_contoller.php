<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplicationCategory;
use App\Models\ApplicationProducts;


class Application_products_contoller
{
    public function add_products(){
        $all_categories = ApplicationCategory::select('name','slug','id')->get()->toArray();
        $all_products = ApplicationProducts::select('name','image','id','description','features')->get()->toArray();
        return view('admin.add-application-products',compact('all_categories','all_products'));
    }
    public function handle_add_product(Request $request){
        $request->validate([
            'name'=>'required',
            'slug'=>'required',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id'=>'required',    
        ]);
        
        // try{
            $features = json_decode($request->features);
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path("product"),$imageName);
            $product = new ApplicationProducts;
            $product->name = $request->name;
            $product->image = 'product/'.$imageName;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->category_id = $request->category_id;
            $product->features = $features;
            $product->save();
            return back()->with('success', 'Product added successfully');
        // }catch(queryException $e){
            
        // };
    }

    public function edit_products($id){
        $product = ApplicationProducts::findOrFail($id);
        $all_categories = ApplicationCategory::select('name','slug','id')->get()->toArray();
        return view('admin.edit-application-product',compact('all_categories','product'));
    }

    public function handle_edit_product(Request $request,$id){
        $product = ApplicationProducts::findOrFail($id);
        $request->validate([
            'name'=>'required',
            'slug'=>'required',
            'category_id'=>'required',     
        ]);
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->category_id = $request->category_id;
        $product->description = $request->description ?? $product->description;
        $product->features = json_decode($request->features) ?? $product->features; 
        if($request->image != null){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path("product"),$imageName);
            $product->image = 'product/' . $imageName;
        }
        $product->save();
        return back()->with("success","Product edit successfully");
    }

    public function handle_delete_product(Request $request,$id){
        $res = ApplicationProducts::where('id',$id)->delete();
        return back()->with('success', 'Product deleted successfully');
    }
}