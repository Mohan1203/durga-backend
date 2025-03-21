<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplicationCategory;
use App\Models\ApplicationProducts;

class ApplicationProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Categories = ApplicationCategory::get();
        return view('admin.application-product.index',compact('Categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name'=>'required',
            'slug'=>'required | unique:application_products,slug',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id'=>'required',    
        ],[
            'slug.unique' => 'Slug must be unique'
        ]);
            try{
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
            }catch(QueryException $e){
                if($e->getcode() == 23000){
                    return back()->with('error','Slug must be unique');
                    return back()->with('error',"Something went wrong");
                }
            }
           
    }

    /**
     * Display the specified resource.
     */
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
            $operate = '<a href='.route('application-products.edit',$row->id).' class="btn btn-xs btn-gradient-primary btn-rounded btn-icon edit-data" data-id=' . $row->id . ' title="Edit"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';
            
            $operate .= '<form action="'.route('application-products.destroy', $row->id).'" method="POST" style="display:inline;">
                '.csrf_field().'
                '.method_field('DELETE').'
                <button type="submit" class="btn btn-xs btn-gradient-danger btn-rounded btn-icon" onclick="return confirm(\'Are you sure you want to delete this item?\')">
                    <i class="fa fa-trash"></i>
                </button>
            </form>';
            
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = ApplicationProducts::findOrFail($id);
        $categories = ApplicationCategory::select('name','slug','id')->get();
        return view('admin.application-product.edit',compact('categories','product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = ApplicationProducts::findOrFail($id);
        // dd($request->name);
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $productId = $id ?? $request->id;
            $product = ApplicationProducts::findOrFail($productId);
            
            // Delete product image if exists
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            
            $product->delete();
            
            return back()->with('success', 'Event deleted successfully');
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting product: ' . $e->getMessage()
            ], 500);
        }
    }
}