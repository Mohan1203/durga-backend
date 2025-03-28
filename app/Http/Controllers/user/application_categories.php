<?php

namespace App\Http\Controllers\user;
use App\Models\ApplicationCategory;

use Illuminate\Http\Request;

class application_categories
{
    public function get_all_categories(Request $request){
        try {
            $appUrl = env('APP_URL', $request->getSchemeAndHttpHost());
            $allCategories = ApplicationCategory::all()->sortBy('sequence')->map(function($category) use ($appUrl){
                $categoryArray  = $category->toArray();
                
                if(!empty($categoryArray['image'])){
                    $categoryArray['image'] = $appUrl . '/' . $category['image'];
                }
            return $categoryArray;
            }); 
            return response()->json([
                'success' => true,
                'data' => $allCategories
            ], 200);
        } catch (QueryException $e) {
            // Handle any database-related errors
            return response()->json([
                'success' => false,
                'message' => 'Error fetching categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}