<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'post_id' => $request->post_id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return back();
    }

    public function destroy(Comment $comment)
    {
        // only author or admin can delete
        if (auth()->id() !== $comment->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $comment->delete();
        return back();
    }
}
