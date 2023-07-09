<?php

namespace App\Http\Controllers\Api;

use App\Models\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();
        if ($tags->count() > 0){

            return response()->json([
                'status' => 200,
                'tags' => $tags
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

            $tag = Tag::create([
                'name' => $request->name
            ]);

            if($tag){

                return response()->json([
                    'status' => 200,
                    'message' => 'Tag Created Successfully'
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
        $tag = Tag::find($id);
        if($tag){

            return response()->json([
                'status' => 200,
                'tag' => $tag
            ], 200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => 'No Tag Found'
            ], 404);
        }
    }

    public function edit($id)
    {
        $tag = Tag::find($id);
        if($tag){

            return response()->json([
                'status' => 200,
                'tag' => $tag
            ], 200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => 'No Tag Found'
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

            $tag = Tag::find($id);
            if($tag){

                $tag->update([
                    'name' => $request->name,
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Tag Updated Successfully'
                ], 200);
            }else{
                
                return response()->json([
                    'status' => 404,
                    'message' => 'No Tag Found'
                ], 404);
            }
        }
    }

    public function destroy($id)
    {
        $tag = Tag::find($id);
        if($tag){

            $tag->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Tag Deleted Successfully'
            ], 200);
            
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No Tag Found'
            ], 404);
        }
    }
}
