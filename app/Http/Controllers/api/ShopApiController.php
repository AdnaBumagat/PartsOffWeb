<?php

namespace App\Http\Controllers\api;

use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShopApiController extends Controller
{
    //* GET categories and products
    public function index(Request $request, $categorySlug = null)
    {
        $categorySelected = "";

        //* GET categories, order by name, ascending, and status = 1
        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $products = Product::where('status', 1);

        //Apply Filters here
        if (!empty($categorySlug)) {
            $category = Category::where('slug', $categorySlug)->first();
            $products = $products->where('category_id', $category->id);
            $categorySelected = $category->id;
        }

        if (!empty($request->get('search'))) {
            $products = $products->where('title', 'like', '%' . $request->get('search') . '%');
        }

        $products = $products->orderBy('id', 'DESC');

        $products = $products->paginate(9);

        $data['categories'] = $categories;
        $data['products'] = $products;
        $data['categorySelected'] = $categorySelected;

        return response()->json([
            'data' => $data
        ]);
    }

    //*Product Page
    public function product($slug)
    {
        $product = Product::where('slug', $slug)->with('product_images')->first();
        if ($product == null) {
            abort(404);
        }

        $data['product'] = $product;

        return response()->json([
            'data' => $data
        ]);
    }

    public function productDisplay($title)
    {
        $product = Product::select('title', 'description', 'price', 'qty')
            ->where('title', $title)
            ->with('product_images')
            ->first();

        if ($product == null){
            abort(404);
        }

        $data['product'] = $product;

        return response()->json([
            'data' => $data
        ]);

    }
}
