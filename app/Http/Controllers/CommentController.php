<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    // Store a new comment
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        // Associate the new comment with the current user and post
        $post->comments()->create([
            'body' => $request->body,
            'user_id' => auth()->user()->id(),
        ]);

        return redirect()->route('posts.show', $post)->with('success', 'Comment added successfully.');
    }

    // Show the edit form for a comment
    public function edit(Comment $comment)
    {
        if (Gate::denies('update', $comment)) {
            abort(403, 'Unauthorized action.');
        }

    }

    // Update an existing comment
    public function update(Request $request, Comment $comment)
    {
        if (Gate::denies('update', $comment)) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $comment->update(['body' => $request->body]);
        return redirect()->route('posts.show', $comment->post)->with('success', 'Comment updated successfully.');
    }

    // Delete a comment
    public function destroy(Comment $comment)
    {
        if (Gate::denies('delete', $comment)) {
            abort(403, 'Unauthorized action.');
        }

        $comment->delete();
        return redirect()->route('posts.show', $comment->post)->with('success', 'Comment deleted successfully.');
    }
}
