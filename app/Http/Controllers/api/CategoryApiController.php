<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class CategoryApiController extends Controller
{
    //* Display all categories
    public function index(Request $request)
    {
        $categories =Category::all();

        return response()->json([
            'categories' => $categories
        ]);
    }

}
