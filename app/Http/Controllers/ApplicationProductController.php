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
       
        $request->validate([
            'name'=>'required',
            'slug'=>'required | unique:application_products,slug',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories'=>'required',    
        ],[
            'slug.unique' => 'Slug must be unique',
            'categories.required' => 'At least one category must be selected',
        ]);
            try{
                // Directly decode the JSON string from the form
                $categoryIds = json_decode($request->categories, true);
                
                // Ensure we have categories
                if (empty($categoryIds)) {
                    return back()->with('error', 'At least one category must be selected');
                }
                
                $image = $request->file('image'); 
                $imageNameWithoutExtension = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $imageName = time() . '_' . $imageNameWithoutExtension . '.' . $image->getClientOriginalExtension();

                $productDescImage = $request->file('product_desc_image');
                $productDescImageNameWithoutExtension = pathinfo($productDescImage->getClientOriginalName(), PATHINFO_FILENAME);
                $productDescImageName = time() . '_' . $productDescImageNameWithoutExtension . '.' . $productDescImage->getClientOriginalExtension();

                $features = json_decode($request->features);
                $request->image->move(public_path("product"),$imageName);        
                $request->product_desc_image->move(public_path("product"),$productDescImageName);
                $product = new ApplicationProducts;
                $product->name = $request->name;
                $product->image = 'product/'.$imageName;
                $product->slug = $request->slug;
                $product->description = $request->description;
                $product->category_id = $categoryIds[0] ?? null; 
                $product->product_description = $request->product_description;
                $product->product_desc_image = 'product/'.$productDescImageName;

                $product->features = $features;
                $product->save();
                
                // Attach all selected categories to the product
                $product->categories()->attach($categoryIds);
                
                return back()->with('success', 'Product added successfully');    
            }catch(\Exception $e){
                // More detailed error handling
                return back()->with('error', 'Error: ' . $e->getMessage());
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

        $sql = ApplicationProducts::with(['category', 'categories'])->where('id', '!=', 0);

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
        // Get the product with its categories
        $product = ApplicationProducts::with('categories')->findOrFail($id);
        
        // Get all available categories
        $categories = ApplicationCategory::select('id', 'name', 'slug')->get();
        
        // Get the IDs of already selected categories
        $selectedCategories = $product->categories->pluck('id')->toArray();
        
        // Also add the primary category if it exists and isn't already in the array
        if ($product->category_id && !in_array($product->category_id, $selectedCategories)) {
            $selectedCategories[] = $product->category_id;
        }
        
        // Get the full category data for display
        $selectedCategoriesWithNames = [];
        
        foreach ($selectedCategories as $categoryId) {
            $category = $categories->firstWhere('id', $categoryId);
            if ($category) {
                $selectedCategoriesWithNames[] = [
                    'id' => $categoryId,
                    'name' => $category->name
                ];
            }
        }
        
        return view('admin.application-product.edit', compact(
            'categories', 
            'product', 
            'selectedCategories',
            'selectedCategoriesWithNames'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = ApplicationProducts::findOrFail($id);
        
        $request->validate([
            'name'=>'required',
            'slug'=>'required',
            'categories'=>'required',
        ],[
            'categories.required' => 'At least one category must be selected',
        ]);
        
        try {
            // Decode categories JSON
            $categoryIds = json_decode($request->categories, true);
            
            // Ensure we have categories
            if (empty($categoryIds)) {
                return back()->with('error', 'At least one category must be selected');
            }
            
            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->category_id = $categoryIds[0] ?? $product->category_id; // Set primary category
            $product->description = $request->description ?? $product->description;
            $product->features = json_decode($request->features) ?? $product->features; 
            $product->product_description = $request->product_description ?? $product->product_description;
            if($request->image != null){
                $image = $request->file('image'); 
                $imageNameWithoutExtension = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $imageName = time() . '_' . $imageNameWithoutExtension . '.' . $image->getClientOriginalExtension();
                $request->image->move(public_path("product"),$imageName);
                $product->image = 'product/' . $imageName;
            }

          
                


            if($request->product_desc_image != null){
                $productDescImage = $request->file('product_desc_image');
                $productDescImageNameWithoutExtension = pathinfo($productDescImage->getClientOriginalName(), PATHINFO_FILENAME);
                $productDescImageName = time() . '_' . $productDescImageNameWithoutExtension . '.' . $productDescImage->getClientOriginalExtension();
                $request->product_desc_image->move(public_path("product"),$productDescImageName);
                $product->product_desc_image = 'product/' . $productDescImageName;
            }
            
            $product->save();
            
            // Sync categories
            $product->categories()->sync($categoryIds);
            
            return back()->with("success","Product updated successfully");
            
        } catch(\Exception $e){
            // More detailed error handling
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
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