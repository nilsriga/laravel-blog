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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
        ]);

        // Strip all HTML tags except <p>, <br>, <strong>, <em>
        $validated['body'] = strip_tags($validated['body'], '<p><br><strong><em>');

        $post = Post::create($validated);
        $post->categories()->attach($validated['categories']);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
        ]);

        $post->update($validated);
        $post->categories()->sync($validated['categories']);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        if (Gate::denies('delete', $post)) {
            abort(403);
        }
        $post->delete();
        return redirect()->route('home');
    }

    public function search(Request $request)
    {
        // Validate the search input to ensure it's safe
        $request->validate([
            'query' => 'required|string|min:2|max:255',
        ]);

        // Use the query to search for posts
        $query = $request->input('query');
        $posts = Post::where('title', 'LIKE', "%{$query}%")
            ->orWhere('body', 'LIKE', "%{$query}%")
            ->paginate(10);

        return view('posts.search', compact('posts', 'query'));
    }

    public function category(Category $category)
    {
        $posts = $category->posts()->with('user', 'categories')->get();
        return view('home', compact('posts'));
    }
}
