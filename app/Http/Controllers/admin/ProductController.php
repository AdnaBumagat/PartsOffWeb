<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\Products;
use App\Models\TempImage;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{


    public function index(){

    }
    public function create(){
        $data =[];
        $categories = Category::orderBy('name','ASC')->get();
        $data['categories'] = $categories;
        return view ('admin.products.create',$data);
    }

    public function store(Request $request){

        exit();
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
            $product = new Products;
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
                foreach ($request->image_array as $temp_image_id){

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
                }

                //Generate Product Thumbnails

                //Large Image
                $manager = new ImageManager(new Driver());
                $sourcePath = public_path().'/temp/'.$tempImageInfo->name;
                $destPath = public_path().'/uploads/product/large/'.$tempImageInfo->name;
                $image = $manager->read($sourcePath);
                $image->resize(1400,null,function($constraint){
                    $constraint->aspectRatio();
                });
                $image->save($destPath);

                //Small Image
                $sourcePath = public_path().'/temp/'.$tempImageInfo->name;
                $destPath = public_path().'/uploads/product/small/'.$tempImageInfo->name;
                $image = $manager->read($sourcePath);
                $image->scale(300,300);
                $image->save($destPath);

            }
            $request->session()->flash('success','Product added succesfully');
    
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
}
