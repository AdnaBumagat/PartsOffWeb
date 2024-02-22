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

class ProductController extends Controller
{
    //* Product Index
    public function index(Request $request)
    {

        $products = Product::with('product_images')->get();

        $data['products'] = $products;
        return response()->json($data);
    }

    //* Create product
    public function store(Request $request)
    {

        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products',
            'track_qty' => 'required|in:Yes,No',
            'category' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No',
        ];

        if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
            $rules['qty'] = 'required|numeric';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
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
            if (!empty($request->image_array)) {
                foreach ($request->image_array as $temp_image_id) {

                    $tempImageInfo = TempImage::find($temp_image_id);
                    $extArray = explode('.', $tempImageInfo->name);
                    $ext = last($extArray);

                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                    $productImage->image = 'NULL';
                    $productImage->save();

                    $imageName = $product->id . '-' . $productImage->id . '-' . time() . '.' . $ext;
                    $productImage->image = $imageName;
                    $productImage->save();

                    //Generate Product Thumbnails

                    //Large Image
                    $sourcePath = public_path() . '/temp/' . $tempImageInfo->name;
                    $destPath = public_path() . '/uploads/product/large/' . $imageName;
                    $image = Image::make($sourcePath);
                    $image->resize(1400, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $image->save($destPath);

                    //Small Image
                    $destPath = public_path() . '/uploads/product/small/' . $imageName;
                    $image = Image::make($sourcePath);
                    $image->fit(300, 300);
                    $image->save($destPath);
                }
            }

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

    //* Product Update
    public function update($id, Request $request)
    {

        $product = Product::find($id);

        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products,slug,' . $product->id . ',id',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products,sku,' . $product->id . ',id',
            'track_qty' => 'required|in:Yes,No',
            'category' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No',
        ];

        if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
            $rules['qty'] = 'required|numeric';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
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
            session()->flash('success', 'Product updated succesfully');

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

    public function destroy($id, Request $request)
    {
        $product = Product::find($id);

        if (empty($product)) {
            session()->flash('error', 'Product not found');
            return response()->json([
                'status' => false,
                'notFound' => true
            ]);
        }

        $productImages = ProductImage::where('product_id', $id)->get();

        if (!empty($productImages)) {
            foreach ($productImages as $productImage) {
                File::delete(public_path('uploads/product/large/' . $productImage->image));
                File::delete(public_path('uploads/product/small/' . $productImage->image));
            }

            ProductImage::where('product_id', $id)->delete();
        }

        $product->delete();

        if (empty($product)) {
            return response()->json([
                'status' => true,
                'message' => 'Product deleted succesfully'
            ]);
        }
    }
}
