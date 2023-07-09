<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        if ($categories->count() > 0){

            return response()->json([
                'status' => 200,
                'categories' => $categories
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No Records Found'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
        ]);

        if($validator->fails()) {

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{

            $category = Category::create([
                'name' => $request->name
            ]);

            if($category){

                return response()->json([
                    'status' => 200,
                    'message' => 'Category Created Successfully'
                ], 200);
            }else{
                
                return response()->json([
                    'status' => 500,
                    'message' => 'Something Went Wrong'
                ], 500);
            }
        }
    }
    
    public function show($id)
    {
        $category = Category::find($id);
        if($category){

            return response()->json([
                'status' => 200,
                'category' => $category
            ], 200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => 'No Category Found'
            ], 404);
        }
    }

    public function edit($id)
    {
        $category = Category::find($id);
        if($category){

            return response()->json([
                'status' => 200,
                'category' => $category
            ], 200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => 'No Category Found'
            ], 404);
        }
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
        ]);

        if($validator->fails()) {

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{

            $category = Category::find($id);
            if($category){

                $category->update([
                    'name' => $request->name,
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Category Updated Successfully'
                ], 200);
            }else{
                
                return response()->json([
                    'status' => 404,
                    'message' => 'No Category Found'
                ], 404);
            }
        }
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if($category){

            $category->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Category Deleted Successfully'
            ], 200);
            
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No Category Found'
            ], 404);
        }
    }
}
