<?php

namespace App\Http\Controllers\user;

use App\Models\ApplicationProducts;
use Illuminate\Http\Request;

class application_product
{
    public function get_all_application_product(Request $request){
        try{
            $slug = $request->slug;
            $appUrl = env("APP_URL",$request->getSchemeAndHttpHost());
            if($slug){
                // When looking up by slug, also check if the product exists in the category list
                // for products that belong to multiple categories
                $product = ApplicationProducts::where('slug', $slug)
                    ->with(['category', 'categories'])
                    ->first();
                    
                if(!$product){
                    return response()->json([
                        'success' => true,
                        'data' => null,
                    ],200);
                }
                
                // Convert to array to make it easier to work with
                $productArray = $product->toArray();
                
                if(!empty($productArray['image'])){
                    $productArray['image'] = $appUrl . '/' . $productArray['image']; 
                }

                if(!empty($productArray['product_desc_image'])){
                    $productArray['product_desc_image'] = $appUrl . '/' . $productArray['product_desc_image']; 
                }
                
                // Add all categories from many-to-many relationship
                $categoriesArray = [];
                
                if (isset($productArray['categories']) && is_array($productArray['categories']) && count($productArray['categories']) > 0) {
                    foreach ($productArray['categories'] as $category) {
                        $categoriesArray[] = [
                            'id' => $category['id'],
                            'name' => $category['name']
                        ];
                    }
                }
                
                // If no categories from many-to-many, but has a primary category,
                // include the primary category in the categories array
                if (empty($categoriesArray) && isset($productArray['category_id']) && $productArray['category_id'] && isset($productArray['category']) && $productArray['category']) {
                    $categoriesArray = [
                        [
                            'id' => $productArray['category_id'],
                            'name' => $productArray['category']['name']
                        ]
                    ];
                }
                
                // Set the categories array
                $productArray['categories'] = $categoriesArray;
                
                // Keep category_id in the response (don't unset it)
                unset($productArray['category']);
                
                return response()->json([
                    'success' => true,
                    'data' => $productArray
                ],200);   
            }else{
                $category_id = $request->category_id;
                $limit = $request->limit ? $request->limit : 9;
                $offset = $request->offset ? $request->offset : 0;
                $total;
                $all_products;
                
                if ($category_id) {
                    // Query products that belong to the specified category using the many-to-many relationship
                    // This will find products where the category is in their categories list,
                    // regardless of whether it's their primary category or not
                    $productsQuery = ApplicationProducts::where(function($query) use ($category_id) {
                        // Check for the category in the many-to-many relationship
                        $query->whereHas('categories', function($q) use ($category_id) {
                            $q->where('application-categories.id', $category_id);
                        })
                        // OR check if it's the primary category
                        ->orWhere('category_id', $category_id);
                    })->with(['category', 'categories']);
                    
                    $total = $productsQuery->count();
                    
                    $all_products = $productsQuery->skip($offset)
                        ->take($limit)
                        ->get();
                } else {
                    $total = ApplicationProducts::where('id', '>', 0)->count();
                    $all_products = ApplicationProducts::skip($offset)
                        ->with(['category', 'categories'])
                        ->take($limit)
                        ->get();
                }
                
                $filter_product = $all_products->map(function ($product) use ($appUrl){
                    $productArray = $product->toArray();
                    
                    if(!empty($productArray['image'])){
                        $productArray['image'] = $appUrl . '/' . $productArray['image']; 
                    }   
                    if(!empty($productArray['product_desc_image'])){
                        $productArray['product_desc_image'] = $appUrl . '/' . $productArray['product_desc_image']; 
                    }
                    
                   
               
                    // Add all categories from many-to-many relationship
                    $categoriesArray = [];
                    
                    if (isset($productArray['categories']) && is_array($productArray['categories']) && count($productArray['categories']) > 0) {
                        foreach ($productArray['categories'] as $category) {
                            $categoriesArray[] = [
                                'id' => $category['id'],
                                'name' => $category['name']
                            ];
                        }
                    }
                    
                    // If no categories from many-to-many, but has a primary category,
                    // include the primary category in the categories array
                    if (empty($categoriesArray) && isset($productArray['category_id']) && $productArray['category_id'] && isset($productArray['category']) && $productArray['category']) {
                        $categoriesArray = [
                            [
                                'id' => $productArray['category_id'],
                                'name' => $productArray['category']['name']
                            ]
                        ];
                    }
                    
                    // Set the categories array
                    $productArray['categories'] = $categoriesArray;
                    
                    // Keep category_id in the response but remove the category object
                    unset($productArray['category']);
                    return $productArray;
                });
                
                return response()->json([
                    'success' => true,
                    'data' => $filter_product,
                    'total'=>$total,
                ],200); 
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'success'=> false,
                'message'=> "Error fetching product",
                'error'=> $e->getMessage(),
                'trace'=> $e->getTraceAsString(),
            ], 500);
        }  
    }
   
   
   
}