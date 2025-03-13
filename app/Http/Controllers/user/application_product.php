<?php

namespace App\Http\Controllers\user;

use App\Models\ApplicationProducts;
use Illuminate\Http\Request;

class application_product
{
    public function get_all_application_product(Request $request){
        try{
            $appUrl = env("APP_URL",$request->getSchemeAndHttpHost());
            $all_products = ApplicationProducts::all()->map(function ($product) use ($appUrl){
               $productArray = $product->toArray();
               if(!empty($productArray['image'])){
                $productArray['image'] = $appUrl . '/' . $productArray['image']; 
               }   
               return $productArray;
            });

            return response()->json([
                'success' => true,
                'products' => $all_products
            ],200);
        }catch(QueryException $e){
            return response()->json([
                'success'=> false,
                'message'=> "Error fetching product",
                'error'=>$e->getMessage(),
            ],500);
            
        }  
    }
   
}