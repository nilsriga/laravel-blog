<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user', 'categories')
            ->withCount('comments') // Add this to load the count of comments for each post
            ->get();
        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        // Load related data if needed (e.g., user, categories, and comments)
        $post->load('user', 'categories', 'comments.user'); // Load the post with related data

        return view('posts.show', compact('post'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // Validation for image
        ]);
    
        // Strip all HTML tags except <p>, <br>, <strong>, <em>
        $validated['body'] = strip_tags($validated['body'], '<p><br><strong><em>');
    
        // Handle image upload if present
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('post_images', 'public'); // Store image in the 'public/images' directory
    
            // Resize and optimize the image
            $resizedImage = Image::make(Storage::path('public/' . $imagePath))->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode();
    
            // Save the resized image
            Storage::put('public/' . $imagePath, $resizedImage);
    
            $validated['image_url'] = $imagePath;  // Save the image path to the database
        }
    
        // Create the post
        $post = auth()->user()->posts()->create($validated);
        $post->categories()->attach($validated['categories']);
    
        return redirect()->route('home')->with('success', 'Post created successfully.');
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // Validation for image
        ]);
    
        // Strip all HTML tags except <p>, <br>, <strong>, <em>
        $validated['body'] = strip_tags($validated['body'], '<p><br><strong><em>');
    
        // Handle image upload if present
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($post->image_url && Storage::exists('public/' . $post->image_url)) {
                Storage::delete('public/' . $post->image_url);
            }
    
            $image = $request->file('image');
            $imagePath = $image->store('post_images', 'public'); // Store image in the 'public/images' directory
    
            // Resize and optimize the image
            $resizedImage = Image::make(Storage::path('public/' . $imagePath))->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode();
    
            // Save the resized image
            Storage::put('public/' . $imagePath, $resizedImage);
    
            $validated['image_url'] = $imagePath;  // Update the image path in the database
        }
    
        // Update the post
        $post->update($validated);
        $post->categories()->sync($validated['categories']);
    
        return redirect()->route('home')->with('success', 'Post updated successfully.');
    }
    
    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    public function edit(Post $post)
    {
        if (Gate::denies('update', $post)) {
            abort(403);
        }
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
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
        return view('posts.index', compact('posts'));
    }
}
