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
            $products = ProductPortfolio::all()->map(function ($product) {
                $product->image = url('storage/' . $product->image); // Adjust the path as needed
                return $product;
            });
           
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

    public function getProductPortfolioDetail(Request $request)
    {
        try {
            $slug = $request->slug;
    
            $productDetails = ProductPortfolio::with(['featureSection', 'grade', 'keyFeature', 'industry'])
                ->where('slug', $request->slug)
                ->first();

            if ($productDetails) {
                $productDetails->image = url('storage/' . $productDetails->image);

                foreach (['featureSection', 'grade', 'keyFeature', 'industry'] as $relation) {
                    if ($productDetails->$relation) {
                        foreach ($productDetails->$relation as $item) {
                            if (isset($item->image)) {
                                $item->image = url('storage/' . $item->image);
                            }
                            if ($relation === 'grade' && isset($item->child_category)) {
                                $decoded = json_decode($item->child_category, true);
                                if (is_string($decoded)) {
                                    $item->child_category = json_decode($decoded, true);
                                } else {
                                    $item->child_category = $decoded;
                                }
                            }
                        }
                    }
                }
            }


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