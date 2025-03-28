<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplicationCategory;
use App\Models\ApplicationProducts;
use App\Models\ProductPortfolio;
use App\Models\FeatureSection;
use App\Models\Grade;
use App\Models\KeyFeature;
use App\Models\Industry;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;


class ProductPortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Categories = ApplicationCategory::get();
      
        return view('admin.product-portfolio.index',compact('Categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {    
        try {

            $request->validate([
                'heading' => 'required|string|max:255',
                'subheading' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'slug' => 'required|string|unique:product_portfolios,slug|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'grade_title' => 'required|string|max:255',
                'feature_title' => 'required|string|max:255',
                'feature_description' => 'required|string',
                'industry_title' => 'required|string|max:255',
                'feature' => 'required|array',
                'feature.*.name' => 'required|string|max:255',
                'feature.*.description' => 'required|string',
                'category' => 'required|array',
                'category.*.parent_category' => 'required|string|max:255',
                'category.*.child_category' => 'required|string',
                'key_feature' => 'required|array',
                'key_feature.*.name' => 'required|string|max:255',
                'key_feature.*.description' => 'required|string',
                'key_feature.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'industry' => 'required|array',
                'industry.*.name' => 'required|string|max:255',
                'industry.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            DB::beginTransaction(); // Start transaction

            // Validate required fields
           
            $product = new ProductPortfolio();
            $product->heading = $request->heading;
            $product->sub_heading = $request->subheading;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->slug = $request->slug;

            // Handle Image Upload for Product Portfolio
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $file_name = time() . '-' . $image->getClientOriginalName();
                $file_path = 'productportfolio/' . $file_name;
                $destinationPath = storage_path('app/public/productportfolio');
                $image->move($destinationPath, $file_name);

                $product->image = $file_path;
            }

            $product->grade_title = $request->grade_title;
            $product->key_feature_title = $request->feature_title;
            $product->key_feature_description = $request->feature_description;
            $product->indutry_title = $request->industry_title;            
            $product->save();
        
            // Store Features
            if ($request->has('feature')) {
                foreach ($request->feature as $feature) {
                    FeatureSection::create([
                        'product_portfolio_id' => $product->id,
                        'title' => $feature['name'],
                        'description' => $feature['description'],
                    ]);
                }
            }

            // Store Categories (Grades)
            if ($request->has('category')) {
                foreach ($request->category as $category) {
                    Grade::create([
                        'product_portfolio_id' => $product->id,
                        'parent_category' => $category['parent_category'],
                        'child_category' => json_encode(explode(',', $category['child_category'])),
                    ]);
                }
            }

            // Store Key Features with Image Handling
            if ($request->has('key_feature')) {
                foreach ($request->key_feature as $key_feature) {
                    // dd($key_feature);
                    if (isset($key_feature['image']) && $key_feature['image'] instanceof \Illuminate\Http\UploadedFile) {
                        $image = $key_feature['image'];
                        $file_name = time() . '-' . $image->getClientOriginalName();
                        $file_path = 'keyfeature/' . $file_name;
                        $destinationPath = storage_path('app/public/keyfeature');
                        $image->move($destinationPath, $file_name);
                    } else {
                        $file_path = null;
                    }

                    KeyFeature::create([
                        'product_portfolio_id' => $product->id,
                        'name' => $key_feature['name'],
                        'description' => $key_feature['description'],
                        'image' => $file_path,
                    ]);
                }
            }

            // Store Industries with Image Handling
            if ($request->has('industry')) {
                foreach ($request->industry as $industry) {
                    if (isset($industry['image']) && $industry['image'] instanceof \Illuminate\Http\UploadedFile) {
                        $image = $industry['image'];
                        $file_name = time() . '-' . $image->getClientOriginalName();
                        $file_path = 'industry/' . $file_name;
                        $destinationPath = storage_path('app/public/industry');
                        $image->move($destinationPath, $file_name);
                    } else {
                        $file_path = null;
                    }

                    Industry::create([
                        'product_portfolio_id' => $product->id,
                        'name' => $industry['name'],
                        'image' => $file_path,
                    ]);
                }
            }
          
            DB::commit(); // Commit transaction

            return back()->with('success', 'Product added successfully');
        } catch (\Throwable $e) {
            DB::rollBack(); // Rollback transaction
            return back()->with('error', $e->getMessage());
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
        $sql = ProductPortfolio::with('grade','keyFeature','industry','featureSection')->where('id', '!=', 0);

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
            $operate = '<a href='.route('product-portfolio.edit',$row->id).' class="btn btn-xs btn-gradient-primary btn-rounded btn-icon edit-data" data-id=' . $row->id . ' title="Edit"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';
            $operate .= '<form action="'.route('product-portfolio.destroy', $row->id).'" method="POST" style="display:inline;">
            '.csrf_field().'
            '.method_field('DELETE').'
            <button type="submit" class="btn btn-xs btn-gradient-danger btn-rounded btn-icon" onclick="return confirm(\'Are you sure you want to delete this item?\')">
                <i class="fa fa-trash"></i>
            </button>
            </form>';
            
            $tempRow = $row->toArray();
            $tempRow['id'] = $row->id;
            $tempRow['no'] = $no++;
            $tempRow['heading'] = $row->heading;
            $tempRow['sub_heading'] = $row->sub_heading;
            $tempRow['description'] = $row->description;
            $tempRow['name'] = $row->name;
            $tempRow['slug'] = $row->slug;
            $tempRow['image'] = url(Storage::url($row->image)); 
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = ProductPortfolio::with('grade','keyFeature','industry','featureSection')->where('id',$id)->first();
        // dd($product->toArray());
        return view('admin.product-portfolio.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
        // dd($request->all());
        try {
            $request->validate([
                'heading' => 'required|string|max:255',
                'subheading' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'slug' => 'required|string|max:255|unique:product_portfolios,slug,' . $id,
                'grade_title' => 'required|string|max:255',
                'feature_title' => 'required|string|max:255',
                'feature_description' => 'required|string',
                'industry_title' => 'required|string|max:255',
                'feature' => 'required|array',
                'feature.*.name' => 'required|string|max:255',
                'feature.*.description' => 'required|string',
                'category' => 'required|array',
                'category.*.parent_category' => 'required|string|max:255',
                'category.*.child_category' => 'required|string',
                'key_feature' => 'required|array',
                'key_feature.*.name' => 'required|string|max:255',
                'key_feature.*.description' => 'required|string',
                'industry' => 'required|array',
                'industry.*.name' => 'required|string|max:255',
            ]);


            DB::beginTransaction(); // Start transaction

            $product = ProductPortfolio::findOrFail($id);
            $product->heading = $request->heading;
            $product->sub_heading = $request->subheading;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->slug = $request->slug;

            // Handle Image Upload for Product Portfolio
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $file_name = time() . '-' . $image->getClientOriginalName();
                $file_path = 'productportfolio/' . $file_name;
                $destinationPath = storage_path('app/public/productportfolio');
                $image->move($destinationPath, $file_name);

                $product->image = $file_path;
            }

            $product->grade_title = $request->grade_title;
            $product->key_feature_title = $request->feature_title;
            $product->key_feature_description = $request->feature_description;
            $product->indutry_title = $request->industry_title;            
            $product->save();
          
            // Store Features
            if ($request->has('feature')) {
                foreach ($request->feature as $feature) {
                    FeatureSection::updateOrCreate(['id' => $feature['id'] ?? null],[
                        'product_portfolio_id' => $product->id,
                        'title' => $feature['name'],
                        'description' => $feature['description'],
                    ]);
                    
                }
            }
            //  dd($request->all());
            if ($request->has('category')) {
                foreach ($request->category as $category) {
                    Grade::updateOrCreate(['id' => $category['id'] ?? null],[
                        'product_portfolio_id' => $product->id,
                        'parent_category' => $category['parent_category'],
                        'child_category' => json_encode(explode(',', $category['child_category'])),
                    ]);
                }
            }

            // Store Key Features with Image Handling
            if ($request->has('key_feature')) {
                foreach ($request->key_feature as $key_feature) {
                  
                    if (isset($key_feature['image']) && $key_feature['image'] instanceof \Illuminate\Http\UploadedFile) {
                        $image = $key_feature['image'];
                        $file_name = time() . '-' . $image->getClientOriginalName();
                        $file_path = 'keyfeature/' . $file_name;
                        $destinationPath = storage_path('app/public/keyfeature');
                        $image->move($destinationPath, $file_name);
                    } else {
                        $file_path = KeyFeature::find($key_feature['id'])->image ?? null;
                    }

                    KeyFeature::updateOrCreate([ 'id' => $key_feature['id'] ?? null],[
                        'product_portfolio_id' => $product->id,
                        'name' => $key_feature['name'],
                        'description' => $key_feature['description'],
                        'image' => $file_path,
                    ]);
                }
            }

            // Store Industries with Image Handling
            if ($request->has('industry')) {
                foreach ($request->industry as $industry) {
                    if (isset($industry['image']) && $industry['image'] instanceof \Illuminate\Http\UploadedFile) {
                        $image = $industry['image'];
                        $file_name = time() . '-' . $image->getClientOriginalName();
                        $file_path = 'industry/' . $file_name;
                        $destinationPath = storage_path('app/public/industry');
                        $image->move($destinationPath, $file_name);
                    } else {
                        $file_path = Industry::find($industry['id'])->image ?? null;
                    }

                    Industry::updateOrCreate(['id' => $industry['id'] ?? null],[
                        'product_portfolio_id' => $product->id,
                        'name' => $industry['name'],
                        'image' => $file_path,
                    ]);
                }
            }
          
            DB::commit(); // Commit transaction

            return back()->with('success', 'Product Updated successfully');
        } catch (\Throwable $e) {
            DB::rollBack(); // Rollback transaction
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $product = ProductPortfolio::findOrFail($id);
            $product->grade()->delete();
            $product->keyFeature()->delete();
            $product->industry()->delete();
            $product->featureSection()->delete();
            $product->delete();
            return back()->with("success","Product Deleted Successfully");
        }catch(QueryException $e){
            return back()->with("error","Product not found");
        }
    }

    public function deleteFeature($id)
    {
        try{
            $feature = FeatureSection::findOrFail($id);
            $feature->delete();
            return response()->json(['message' => 'Feature Deleted successfully'], 200);
        }catch(QueryException $e){
            return response()->json(['message' => 'Error deleting Feature', 'error' => $e->getMessage()], 500);
        }
    }

    public function deleteGrade($id)
    {
        try {
            $grade = Grade::findOrFail($id);
            $grade->delete();
            return response()->json(['message' => 'Grade deleted successfully'], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Grade not found'], 404);
        }
    }

    public function deleteKeyFeature($id)
    {
        try {
            $keyFeature = KeyFeature::findOrFail($id);
            $keyFeature->delete();
            return response()->json(['message' => 'Key Feature deleted successfully'], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Key Feature not found'], 404);
        }
    }

    public function deleteIndustry($id)
    {
        try {
            $industry = Industry::findOrFail($id);
            $industry->delete();
            return response()->json(['message' => 'Industry deleted successfully'], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Industry not found'], 404);
        }
    }

    /**
     * Update the order of products
     */
    public function updateOrder(Request $request)
    {
        try {
            // Log the incoming request for debugging
            \Log::info('Received updateOrder request', [
                'content_type' => $request->header('Content-Type'),
                'data' => $request->all(),
                'json' => $request->json()->all()
            ]);
            
            // Check if the request is JSON
            if ($request->isJson()) {
                $orderedIds = $request->json('order');
            } else {
                $orderedIds = $request->input('order');
            }
            
            // Validate the data
            if (!is_array($orderedIds) || empty($orderedIds)) {
                \Log::error('Invalid order data format', ['order' => $orderedIds]);
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid data: order array is required'
                ], 400);
            }
            
            \Log::info('Processing product sequence update', ['ids' => $orderedIds]);
            
            DB::beginTransaction();
            
            // Update positions based on array order
            foreach ($orderedIds as $index => $productId) {
                $result = ProductPortfolio::where('id', $productId)
                    ->update(['position' => $index + 1]);
                    
                \Log::info('Updated product position', [
                    'id' => $productId, 
                    'position' => $index + 1,
                    'success' => $result ? 'yes' : 'no'
                ]);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Product sequence updated successfully',
                'updated_ids' => $orderedIds
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to update product sequence', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product sequence: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle drag over event
     */
    public function dragOver(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'position' => 'required|integer',
        ]);

        try {
            // Log the drag over event
            \Log::info('Drag over', [
                'id' => $request->id,
                'position' => $request->position
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Drag over registered',
                'item_id' => $request->id,
                'current_position' => $request->position
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to register drag over: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Handle drag end event with full sequence data
     */
    public function dragEnd(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'start_position' => 'required|integer',
            'end_position' => 'required|integer',
            'sequence' => 'required|array',
            'sequence.*.id' => 'required|integer',
            'sequence.*.position' => 'required|integer',
        ]);

        try {
            // Log drag end event with complete sequence
            \Log::info('Drag end', [
                'moved_item_id' => $request->id,
                'from_position' => $request->start_position,
                'to_position' => $request->end_position,
                'sequence' => $request->sequence
            ]);
            
            // You can process the sequence data here
            // For example, update all positions in the database
            
            return response()->json([
                'success' => true,
                'message' => 'Drag end processed successfully',
                'item_moved' => [
                    'id' => $request->id,
                    'from' => $request->start_position,
                    'to' => $request->end_position
                ],
                'sequence_received' => $request->sequence
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process drag end: ' . $e->getMessage()
            ], 500);
        }
    }
}