<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index()
    {
        // $articles = Article::all();
        // $articles = Article::with('category', 'tags')->get();
        $articlesPerPage = 7;
        $articles = Article::with('category', 'tags')->simplePaginate($articlesPerPage);
        $pageCount = count(Article::all()) / $articlesPerPage;
        if ($articles->count() > 0){

            return response()->json([
                'status' => 200,
                'paginate' => $articles,
                'pageCount' => ceil($pageCount)
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
            'title' => 'required|string|max:100',
            'link' => 'required|string|max:100',
            'category_id' => 'required|integer',
            // 'tag_id' => 'required|array',
            // 'tag_id.*' => 'integer',
        ]);

        if($validator->fails()) {

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{

            $article = Article::create([
                'category_id' => $request->category_id,
                'title' => $request->title,
                'link' => $request->link
            ]);
            $article->tags()->attach($request->tag_id);

            if($article){

                return response()->json([
                    'status' => 200,
                    'message' => 'Article Created Successfully'
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
        $article = Article::find($id);
        if($article){

            return response()->json([
                'status' => 200,
                'article' => $article
            ], 200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => 'No Article Found'
            ], 404);
        }
    }

    public function edit($id)
    {
        $article = Article::with('tags')->find($id);
        if($article){

            return response()->json([
                'status' => 200,
                'article' => $article
            ], 200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => 'No Article Found'
            ], 404);
        }
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'link' => 'required|string|max:100',
            'category_id' => 'required|integer',
            // 'tag_id' => 'required|array',
            // 'tag_id.*' => 'integer',
        ]);

        if($validator->fails()) {

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{

            $article = Article::find($id);
            if($article){

                $article->update([
                    'category_id' => $request->category_id,
                    'title' => $request->title,
                    'link' => $request->link
                ]);
                $article->tags()->sync($request->tag_id);

                return response()->json([
                    'status' => 200,
                    'message' => 'Article Updated Successfully'
                ], 200);
            }else{
                
                return response()->json([
                    'status' => 404,
                    'message' => 'No Article Found'
                ], 404);
            }
        }
    }

    public function destroy($id)
    {
        $article = Article::find($id);
        if($article){

            $article->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Article Deleted Successfully'
            ], 200);
            
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No Article Found'
            ], 404);
        }
    }
}
