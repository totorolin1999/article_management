<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $articlesPerPage = (int) $request->input('per_page', 7);
        // 使用 Laravel 內建的 LengthAwarePaginator，直接透過 SQL count，不將全部記錄載入記憶體
        $articles = Article::with(['category', 'tags'])->paginate($articlesPerPage);

        return response()->json([
            'status' => 200,
            'paginate' => $articles,
            'pageCount' => $articles->lastPage()
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'link' => 'required|string|max:500',
            'category_id' => 'required|integer|exists:categories,id',
            'tag_id' => 'nullable|array',
            'tag_id.*' => 'integer|exists:tags,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }

        try {
            $article = DB::transaction(function () use ($request) {
                $created = Article::create([
                    'category_id' => $request->category_id,
                    'title' => $request->title,
                    'link' => $request->link,
                ]);

                if (!empty($request->tag_id)) {
                    $created->tags()->attach($request->tag_id);
                }

                return $created;
            });

            return response()->json([
                'status' => 200,
                'message' => 'Article Created Successfully',
                'article' => $article->load(['category', 'tags'])
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function show($id)
    {
        $article = Article::with(['category', 'tags'])->find($id);
        if ($article) {
            return response()->json([
                'status' => 200,
                'article' => $article
            ], 200);
        }

        return response()->json([
            'status' => 404,
            'message' => 'No Article Found'
        ], 404);
    }

    public function edit($id)
    {
        $article = Article::with(['category', 'tags'])->find($id);
        if ($article) {
            return response()->json([
                'status' => 200,
                'article' => $article
            ], 200);
        }

        return response()->json([
            'status' => 404,
            'message' => 'No Article Found'
        ], 404);
    }

    public function update(Request $request, int $id)
    {
        $article = Article::find($id);
        if (!$article) {
            return response()->json([
                'status' => 404,
                'message' => 'No Article Found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'link' => 'required|string|max:500',
            'category_id' => 'required|integer|exists:categories,id',
            'tag_id' => 'nullable|array',
            'tag_id.*' => 'integer|exists:tags,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }

        try {
            DB::transaction(function () use ($article, $request) {
                $article->update([
                    'category_id' => $request->category_id,
                    'title' => $request->title,
                    'link' => $request->link,
                ]);

                $article->tags()->sync($request->tag_id ?? []);
            });

            return response()->json([
                'status' => 200,
                'message' => 'Article Updated Successfully'
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $article = Article::find($id);
        if ($article) {
            $article->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Article Deleted Successfully'
            ], 200);
        }

        return response()->json([
            'status' => 404,
            'message' => 'No Article Found'
        ], 404);
    }
}
