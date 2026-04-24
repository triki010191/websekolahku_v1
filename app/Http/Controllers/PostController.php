<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::published()
            ->with(['category', 'author'])
            ->when($request->category, fn ($q, $slug) => $q->whereHas('category', fn ($q) => $q->where('slug', $slug)))
            ->when($request->search, fn ($q, $s) => $q->where('title', 'like', "%$s%"))
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $categories = Category::where('type', 'post')->get();
        $popular    = Post::published()->orderByDesc('views')->take(4)->get();

        return view('berita.index', compact('posts', 'categories', 'popular'));
    }

    public function show(string $slug)
    {
        $post = Post::published()->where('slug', $slug)->with(['category', 'author'])->firstOrFail();
        $post->increment('views');

        $related = Post::published()
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('berita.show', compact('post', 'related'));
    }
}
