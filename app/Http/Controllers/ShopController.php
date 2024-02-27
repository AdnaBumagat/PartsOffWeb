<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    //* GET categories and products
    public function index(Request $request, $categorySlug = null)
    {
        $categorySelected = "";

        //* GET categories, order by name, ascending, and status = 1
        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $products = Product::where('status',1);

        //Apply Filters here
        if(!empty($categorySlug)){
            $category = Category::where('slug',$categorySlug)->first();
            $products = $products->where('category_id',$category->id);
            $categorySelected = $category->id;
        }

        if(!empty($request->get('search'))){
            $products = $products->where('title','like','%'.$request->get('search').'%');
        }

        if($request->get('price_max') != '' && $request->get('price_min') != ''){
            if($request->get('price_max') == '50000'){
                $products = $products->whereBetween('price',[intval($request->get('price_min')),intval($request->get('price_max')),100000]);
            }else{
            $products = $products->whereBetween('price',[intval($request->get('price_min')),intval($request->get('price_max'))]);
            }
        }


        if ($request->get('sort') !=''){
            if($request->get('sort') == 'latest'){
                $products = $products->orderBy('id', 'DESC');
            }else if($request->get('sort')=='price_asc'){
                $products = $products->orderBy('price', 'ASC');
            }else {
                $products = $products->orderBy('price', 'DESC');
            }
        }else{
            $products = $products->orderBy('id', 'DESC');
        }


        $products = $products->paginate(6);

        $data['categories'] = $categories;
        $data['products'] = $products;
        $data['categorySelected'] = $categorySelected;
        $data['priceMax'] = (intval($request->get('price_max'))== 0)?1000: $request->get('price_max');
        $data['priceMin'] = intval($request->get('price_min'));
        $data['sort'] = $request->get('sort');

        return view('front.shop', $data);
    }

    //*Product Page
    public function product($slug)
    {
        $product = Product::where('slug', $slug)->with('product_images')->first();
        if ($product == null) {
            abort(404);
        }

        $data['product'] = $product;

        return view('front.product',$data);
    }
}
