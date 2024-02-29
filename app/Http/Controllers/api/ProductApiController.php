<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\Product;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ProductApiController extends Controller
{
    //* Get all products
    public function index()
    {

        $products = Product::with('product_images')->get();

        $data['products'] = $products;
        return response()->json($data);
    }

    public function displayProduct(){

        $products = Product::select('title', 'description', 'price', 'qty')->get();

        return response()->json($products);

    }

    //* Filter products by latest
    public function getLatestProduct()
    {
        $products = Product::where('is_featured', 'Yes')
            ->orderBy('id', 'DESC')
            ->take(8)
            ->where('status', 1)
            ->get();

        $data['featuredProducts'] = $products;

        $latestProducts = Product::orderBy('id', 'DESC')
            ->where('status', 1)
            ->take(8)
            ->get();

        $data['latestProducts'] = $latestProducts;

        return response()->json([
            'data' => $data
        ]);
    }
}
