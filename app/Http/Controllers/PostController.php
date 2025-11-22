<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function dashboard()
    {
        $posts = Post::with('user')->latest()->get();
        return view('dashboard', compact('posts'));
    }

    public function index()
    {
        $posts = Post::where('user_id', auth()->id())->latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|max:280', 
        ]);

        auth()->user()->posts()->create([
            'content' => $request->content,
        ]);

        return back()->with('success', 'Posted!');
    }

    public function edit(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post->update($request->only('title', 'content'));
        return redirect()->route('posts.index')->with('success', 'Post updated!');
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted!');
    }
}
