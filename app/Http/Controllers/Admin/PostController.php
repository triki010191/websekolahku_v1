<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Post::class, 'post');
    }

    public function index(Request $request)
    {
        $posts = Post::with(['category', 'author'])
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->when($request->category, fn ($q, $c) => $q->where('category_id', $c))
            ->when($request->search, fn ($q, $s) => $q->where('title', 'like', "%$s%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $categories = Category::where('type', 'post')->get();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('type', 'post')->get();

        return view('admin.posts.form', ['post' => new Post, 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['user_id'] = $request->user()->id;
        $data['slug'] = Str::slug($data['title']).'-'.now()->format('YmdHis');
        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('posts', 'public');
        }

        Post::create($data);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil dibuat.');
    }

    public function edit(Post $post)
    {
        $categories = Category::where('type', 'post')->get();

        return view('admin.posts.form', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $this->validated($request, $post);
        $data['is_featured'] = $request->boolean('is_featured');
        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('posts', 'public');
        }
        $post->update($data);

        return redirect()->route('admin.posts.index')->with('success', 'Berita diperbarui.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return back()->with('success', 'Berita dihapus.');
    }

    private function validated(Request $r, ?Post $post = null): array
    {
        return $r->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'tags' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:draft,published,scheduled'],
            'published_at' => ['nullable', 'date'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:15360'],
        ]);
    }
}
