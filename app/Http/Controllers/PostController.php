<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user', 'categories')->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'categories' => 'required|array',
        ]);

        $post = auth()->user()->posts()->create($request->only('title', 'body'));
        $post->categories()->attach($request->categories);

        return redirect()->route('posts.index');
    }

    public function edit(Post $post)
    {
        if (Gate::denies('update', $post)) {
            abort(403);
        }
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        if (Gate::denies('update', $post)) {
            abort(403);
        }
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'categories' => 'required|array',
        ]);

        $post->update($request->only('title', 'body'));
        $post->categories()->sync($request->categories);

        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        if (Gate::denies('delete', $post)) {
            abort(403);
        }
        $post->delete();
        return redirect()->route('posts.index');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $posts = Post::where('title', 'like', "%$query%")
                     ->orWhere('body', 'like', "%$query%")
                     ->get();

        return view('posts.index', compact('posts'));
    }

    public function category(Category $category)
    {
        $posts = $category->posts()->with('user', 'categories')->get();
        return view('posts.index', compact('posts'));
    }
}
