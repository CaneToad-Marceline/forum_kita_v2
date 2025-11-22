<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class ModeratorController extends Controller
{
    public function index()
    {
        // Get all users who have at least one post
        $users = User::has('posts')
            ->withCount('posts')
            ->orderBy('name')
            ->get();

        return view('moderator.index', compact('users'));
    }

    public function exportUserPosts(User $user)
    {
        $posts = Post::where('user_id', $user->id)
            ->with('user')
            ->latest()
            ->get();

        $filename = 'posts_' . str_replace(' ', '_', $user->name) . '_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($posts) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, ['Post ID', 'Author Name', 'Author Email', 'Content', 'Created At', 'Updated At']);

            // Add data rows
            foreach ($posts as $post) {
                fputcsv($file, [
                    $post->id,
                    $post->user->name ?? 'Unknown',
                    $post->user->email ?? 'Unknown',
                    $post->content,
                    $post->created_at->format('Y-m-d H:i:s'),
                    $post->updated_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function viewUserPosts(User $user)
    {
        $posts = Post::where('user_id', $user->id)
            ->latest()
            ->get();

        return view('moderator.user-posts', compact('user', 'posts'));
    }
}