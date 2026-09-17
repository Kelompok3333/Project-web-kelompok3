<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('is_published', true)
            ->latest('published_at')
            ->paginate(10);

        return response()->json($articles);
    }
}
