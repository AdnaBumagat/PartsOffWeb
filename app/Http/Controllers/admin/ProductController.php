<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\Product;
use App\Models\TempImage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{

    //* Product Index
    public function index(Request $request){

        $products = Product::latest('id')->with('product_images');

        if($request->get('keyword')!=""){
            $products = $products->where('title','like','%'.$request->keyword.'%');

        }
        $products = $products->paginate();
        $data['products'] = $products;
        return view ('admin.products.list',$data);

    }

    //* Create product
    public function create(){
        $data =[];
        $categories = Category::orderBy('name','ASC')->get();
        $data['categories'] = $categories;
        return view ('admin.products.create',$data);
    }

    public function store(Request $request){

        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products',
            'track_qty' => 'required|in:Yes,No',
            'category' => 'required|numeric',
            'is_featured'=> 'required|in:Yes,No',
        ];
    
        if (!empty($request->track_qty) && $request->track_qty == 'Yes'){
            $rules['qty'] = 'required|numeric';
        }
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->passes()){
            $product = new Product;
            $product->title = $request->title;
            $product->slug = $request->title;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->sku = $request->sku;
            $product->track_qty = $request->track_qty;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->category_id = $request->category;
            $product->is_featured = $request->is_featured;
            $product->save();

            //Save Gallery Pics
            if(!empty($request->image_array)){
                foreach ($request->image_array as $temp_image_id) {

                    $tempImageInfo = TempImage::find($temp_image_id);
                    $extArray = explode('.',$tempImageInfo->name);
                    $ext = last($extArray);

                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                    $productImage->image = 'NULL';
                    $productImage->save();

                    $imageName = $product->id.'-'.$productImage->id.'-'.time().'.'.$ext;
                    $productImage->image = $imageName;
                    $productImage->save();

                    //Generate Product Thumbnails

                    //Large Image
                    $sourcePath = public_path().'/temp/'.$tempImageInfo->name;
                    $destPath = public_path().'/uploads/product/large/'.$imageName;
                    $image = Image::make($sourcePath);
                    $image->resize(1400, null, function ($constraint){
                        $constraint->aspectRatio();
                    });
                    $image->save($destPath);
                    

                    //Small Image
                    $destPath = public_path().'/uploads/product/small/'.$imageName;
                    $image = Image::make($sourcePath);
                    $image->fit(300,300);
                    $image->save($destPath);
                }
            }
            
    
            session()->flash('success','Product added succesfully');
    
            return response()->json([
                'status' => true,
                'message' => 'Product saved successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    
    //* Product Edit
    public function edit($id, Request $request){
        
        $product = Product::find($id);

        if(empty($product)){
            return redirect()->route('products.index')->with('error','Product not found');
        }

        //Fetch product Images
        $productImages = ProductImage::where('product_id',$product->id)->get();
        
        $data =[];
        $data['product'] = $product;
        $categories = Category::orderBy('name','ASC')->get();
        $data['categories'] = $categories;
        $data['productImages'] = $productImages;
        
        return view('admin.products.edit',$data);
    }


    //* Product Update
    public function update($id, Request $request){

        $product = Product::find($id);

        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products,slug,'.$product->id.',id',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products,sku,'.$product->id.',id',
            'track_qty' => 'required|in:Yes,No',
            'category' => 'required|numeric',
            'is_featured'=> 'required|in:Yes,No',
        ];
    
        if (!empty($request->track_qty) && $request->track_qty == 'Yes'){
            $rules['qty'] = 'required|numeric';
        }
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->passes()){
            $product->title = $request->title;
            $product->slug = $request->title;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->sku = $request->sku;
            $product->track_qty = $request->track_qty;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->category_id = $request->category;
            $product->is_featured = $request->is_featured;
            $product->save();

            //Save Gallery Pics
            session()->flash('success','Product updated succesfully');
    
            return response()->json([
                'status' => true,
                'message' => 'Product updated successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

    }
}
