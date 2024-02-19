<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use Image;

class CategoryController extends Controller
{

    //* Display all categories
    public function index(Request $request)
    {
        $categories =Category::latest();

        if(!empty($request->get('keyword'))){
            $categories = $categories->where('name','like','%'.$request->get('keyword').'%');
        }

        $categories =$categories->paginate(10);
        return view('admin.category.list',compact('categories'));
    }

    //* Route to category create view
    public function create()
    {
        return view('admin.category.create');

    }

    //* Create new category
    public function store(Request $request)
    {
        $validator =Validator::make($request->all(),[
            'name' =>'required',
            'slug' =>'required|unique:categories',
        ]);

        if($validator->passes()){

            $category = new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->save();

            // Save Image Here

            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $ext = explode('.',$tempImage->name);
                $ext = last($extArray);

                $newImageName = $category->id.'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/category/'.$newImageName;
                File::copy($SPath,$dPath);

                //Generate Image Thumbnail
                $dPath = public_path().'/uploads/category/thumb/'.$newImageName;
                $img = Image::make($sPath);
                $img->resize(450, 600);
                $img->save($dPath);

                $category->image = $newImageName;
                $category->save();
            }

            $request->session()->flash('success','Category added successfully');

            return response()->json([
                'status' => true,
                'message' => 'Category added succesfully'
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    //* Route to edit view
    public function edit($categoryId, Request $request)
    {
        $category = Category::find($categoryId);
        if(empty($category)){
            return redirect()->route('categories.index');
        }

        return view('admin.category.edit', compact('category'));
    }

    //* Update category
    public function update($categoryId, Request $request)
    {
        $category = Category::find($categoryId);

        if(empty($category)){
            $request->session()->flash('error','Category not found');

            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Category not found'
            ]);
        }

        $validator =Validator::make($request->all(),[
            'name' =>'required',
            'slug' => 'required|unique:categories,slug,'.$category->id.',id'
        ]);

        if($validator->passes()){

            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->save();

            $oldImage = $category->image;

            // Save Image Here
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $ext = explode('.',$tempImage->name);
                $ext = last($extArray);

                $newImageName = $category->id.'-'.time().'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/category/'.$newImageName;
                File::copy($SPath,$dPath);

                //Generate Image Thumbnail
                $dPath = public_path().'/uploads/category/thumb/'.$newImageName;
                $img = Image::make($sPath);
                $img->resize(450, 600); //fix once intervention/image dependency fixed
                $img->save($dPath);

                $category->image = $newImageName;
                $category->save();

                //* Delete old images
                File::delete(public_path().'/uploads/category/thumb/'.$oldImage);
                File::delete(public_path().'/uploads/category/'.$oldImage);

            }

            $request->session()->flash('success','Category updated successfully');

            return response()->json([
                'status' => true,
                'message' => 'Category updated succesfully'
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    //* Delete category
    public function destroy($categoryId, Request $request)
    {
        $category = Category::find($categoryId);

        if(empty($category)){
            $request->session()->flash('error', 'Category not found.');
            return response()->json([
                'status' => true,
                'message' => 'Category not found'
            ]);
        }

        File::delete(public_path().'/uploads/category/thumb/'.$category->image);
        File::delete(public_path().'/uploads/category/'.$category->image);

        $category->delete();

        $request->session()->flash('success', 'Category deleted successfully');

        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully'
        ]);
    }
}
