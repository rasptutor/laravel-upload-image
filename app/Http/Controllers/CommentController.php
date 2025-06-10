<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required',
            'post_id' => 'required|exists:posts,id',
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $request->post_id,
            'body' => $request->body,
        ]);

        return back()->with('success', 'Comment posted!');
    }

    public function destroy(Comment $comment)
    {
        // Optional: authorize that the current user owns the comment
        if ($comment->user_id !== Auth::id()) {
            abort(403); // Forbidden
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }
}
