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
                $product = ApplicationProducts::where('slug',$slug)->with('category')->first();
                if(!$product){
                    return response()->json([
                        'success' => true,
                        'data' => null,
                    ],200);
                }
                if(!empty($product['image'])){
                    $product['image'] = $appUrl . '/' . $product['image']; 
                    }  
                $product['category_name'] = $product->category ?  $product->category->name : null;
                unset($product['category']);
                return response()->json([
                    'success' => true,
                    'data' => $product
                ],200);   
            }else{
                $category_id = $request->category_id;
                $limit = $request->limit ? $request->limit : 9;
                $offset = $request->offset?$request->offset :0;
                $total;
                $all_products;
                if($category_id){
                    $total = ApplicationProducts::where('category_id','=',$category_id)->count();
                    $all_products = ApplicationProducts::where('category_id','=',$category_id)->with('category')->skip($offset)->take($limit)->get();
                }else{
                    $total = ApplicationProducts::where('id','>',0)->count();
                    $all_products = ApplicationProducts::skip($offset)->with('category')->take($limit)->get();
                }
                // $total = ApplicationProducts::where('id','>',0)->count();
                // $all_products = ApplicationProducts::skip($offset)->take($limit)->get();
                $filter_product = $all_products->map(function ($product) use ($appUrl){
                     $productArray = $product->toArray();
                    if(!empty($productArray['image'])){
                    $productArray['image'] = $appUrl . '/' . $productArray['image']; 
                    }   
                   
                   $productArray['category_name'] = $product->category ? $product->category->name :null;
                   unset($productArray['category']);
                   return $productArray;
                });
                return response()->json([
                    'success' => true,
                    'data' => $filter_product,
                    'total'=>$total,
                ],200); 
            }
            
        }catch(QueryException $e){
            return response()->json([
                'success'=> false,
                'message'=> "Error fetching product",
                'error'=>$e->getMessage(),
            ],500);
            
        }  
    }
   
}