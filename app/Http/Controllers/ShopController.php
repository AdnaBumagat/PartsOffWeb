<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    //* GET categories and products
    public function index(){

        //* GET categories, order by name, ascending, and status = 1
        $categories = Category::orderBy('name', 'ASC')
                ->where('status', 1)
                ->get();
        //* GET products, order by name, descending, status = 1
        $products = Product::orderBy('id', 'DESC')
                ->where('status', 1)
                ->get();

        $data['categories'] = $categories;
        $data['products'] = $products;

        return view('front.shop', $data);
    }
}
