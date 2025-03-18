<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplicationCategory;
use App\Models\ApplicationProducts;
use Illuminate\Support\Facades\App;

class TestController
{
    public function index(){
        $Categories = ApplicationCategory::get();
      
        return view('admin.product.index',compact('Categories'));
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

    public function show(Request $request)  
    {
        $offset = request('offset', 0);
        $limit = request('limit', 10);
        $sort = request('sort', 'id');
        $order = request('order', 'DESC');

        $sql = ApplicationProducts::with('category')->where('id', '!=', 0);

        if (!empty($_GET['search'])) {
            $search = $_GET['search'];
            $sql->where(function ($query) use ($search) {
                $query->where('id', 'LIKE', "%$search%")->orwhere('name', 'LIKE', "%$search%");
            });
        }

        if ($request->show_deleted) {
            $sql->onlyTrashed();
        }
        $total = $sql->count();

        $sql->orderBy($sort, $order)->skip($offset)->take($limit);
        $res = $sql->get();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $no = 1;
        $operate = "";
        foreach ($res as $row) {
            // $operate = '<a href='.route('edit-application-products',$row->id).' class="btn btn-xs btn-gradient-primary btn-rounded btn-icon edit-data" data-id=' . $row->id . ' title="Edit" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';
            // $operate .= '<a href='.route('',$row->id).' class="btn btn-xs btn-gradient-danger btn-rounded btn-icon delete-form" data-id=' . $row->id . '><i class="fa fa-trash"></i></a>';
            
            $tempRow = $row->toArray();
            $tempRow['no'] = $no++;
            $tempRow['slug'] = $row->slug;
            $tempRow['image'] = $row->image;
            $tempRow['category_id'] = $row->category_id;
            $tempRow['category_name'] = $row->category->name;
            $tempRow['description'] = $row->description;
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }
}