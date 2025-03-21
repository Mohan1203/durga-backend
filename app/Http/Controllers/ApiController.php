<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\ProductPortfolio;

class ApiController extends Controller
{
    public function getProductPortfolio()
    {
        try {
            $products = ProductPortfolio::all(); 
            return response()->json([
                'success' => true,
                'data' => $products
            ], 200);

        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => "Error fetching products",
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getProductPortfolioDetail($slug)
    {
        try {
            $productDetails = ProductPortfolio::with('featureSection','grade','keyFeature','industry')->where('slug', $slug)->first();

            if (!$productDetails) {
                return response()->json([
                    'success' => false,
                    'message' => "Product not found"
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $productDetails
            ], 200);

        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => "Error fetching product",
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
