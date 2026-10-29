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

        return response()->json([
            'status' => 200,
            'tags' => $tags
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:tags,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }

        $tag = Tag::create([
            'name' => $request->name
        ]);

        if ($tag) {
            return response()->json([
                'status' => 200,
                'message' => 'Tag Created Successfully',
                'tag' => $tag
            ], 200);
        }

        return response()->json([
            'status' => 500,
            'message' => 'Something Went Wrong'
        ], 500);
    }
    
    public function show($id)
    {
        $tag = Tag::find($id);
        if ($tag) {
            return response()->json([
                'status' => 200,
                'tag' => $tag
            ], 200);
        }

        return response()->json([
            'status' => 404,
            'message' => 'No Tag Found'
        ], 404);
    }

    public function edit($id)
    {
        $tag = Tag::find($id);
        if ($tag) {
            return response()->json([
                'status' => 200,
                'tag' => $tag
            ], 200);
        }

        return response()->json([
            'status' => 404,
            'message' => 'No Tag Found'
        ], 404);
    }

    public function update(Request $request, int $id)
    {
        $tag = Tag::find($id);
        if (!$tag) {
            return response()->json([
                'status' => 404,
                'message' => 'No Tag Found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:tags,name,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }

        $tag->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Tag Updated Successfully'
        ], 200);
    }

    public function destroy($id)
    {
        $tag = Tag::find($id);
        if ($tag) {
            $tag->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Tag Deleted Successfully'
            ], 200);
        }

        return response()->json([
            'status' => 404,
            'message' => 'No Tag Found'
        ], 404);
    }
}
