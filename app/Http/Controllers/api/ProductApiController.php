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
    //* Product Index
    public function index(Request $request)
    {

        $products = Product::with('product_images')->get();

        $data['products'] = $products;
        return response()->json($data);
    }

}
