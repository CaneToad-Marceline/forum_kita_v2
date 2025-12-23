<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class ModeratorApiController extends Controller
{
    /**
     * GET /api/moderator/users
     * Get all users with their post count
     */
    public function getUsers()
    {
        $users = User::withCount('posts')
            ->orderBy('name')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'posts_count' => $user->posts_count,
                    'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                ];
            });

        return response()->json([
            'status' => true,
            'message' => 'Data users berhasil diambil',
            'data' => $users
        ], 200);
    }

    /**
     * GET /api/moderator/users/{id}/posts
     * Get all posts from a specific user
     */
    public function getUserPosts($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan',
                'data' => null
            ], 404);
        }

        $posts = Post::where('user_id', $userId)
            ->with('user:id,name,email')
            ->latest()
            ->get()
            ->map(function ($post) {
                return [
                    'id' => $post->id,
                    'content' => $post->content,
                    'user' => [
                        'id' => $post->user->id,
                        'name' => $post->user->name,
                        'email' => $post->user->email,
                    ],
                    'created_at' => $post->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $post->updated_at->format('Y-m-d H:i:s'),
                ];
            });

        return response()->json([
            'status' => true,
            'message' => "Data posts dari {$user->name} berhasil diambil",
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'posts' => $posts
            ]
        ], 200);
    }

    /**
     * DELETE /api/moderator/posts/{id}
     * Moderator can delete any post
     */
    public function deletePost($postId)
    {
        $post = Post::find($postId);

        if (!$post) {
            return response()->json([
                'status' => false,
                'message' => 'Post tidak ditemukan',
                'data' => null
            ], 404);
        }

        $postData = [
            'id' => $post->id,
            'content' => $post->content,
            'user_name' => $post->user->name,
        ];

        $post->delete();

        return response()->json([
            'status' => true,
            'message' => 'Post berhasil dihapus oleh moderator',
            'data' => $postData
        ], 200);
    }

    /**
     * GET /api/moderator/stats
     * Get forum statistics
     */
    public function getStats()
    {
        $totalUsers = User::count();
        $totalPosts = Post::count();
        $totalModerators = User::where('role', 'moderator')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        
        $recentPosts = Post::latest()
            ->take(5)
            ->with('user:id,name')
            ->get()
            ->map(function ($post) {
                return [
                    'id' => $post->id,
                    'content' => substr($post->content, 0, 50) . '...',
                    'user_name' => $post->user->name,
                    'created_at' => $post->created_at->diffForHumans(),
                ];
            });

        $topPosters = User::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->take(5)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'posts_count' => $user->posts_count,
                ];
            });

        return response()->json([
            'status' => true,
            'message' => 'Statistik forum berhasil diambil',
            'data' => [
                'summary' => [
                    'total_users' => $totalUsers,
                    'total_posts' => $totalPosts,
                    'total_moderators' => $totalModerators,
                    'total_admins' => $totalAdmins,
                ],
                'recent_posts' => $recentPosts,
                'top_posters' => $topPosters,
            ]
        ], 200);
    }

    /**
     * GET /api/moderator/users/{id}/export
     * Export user posts as JSON (for API consumption)
     */
    public function exportUserPosts($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan',
                'data' => null
            ], 404);
        }

        $posts = Post::where('user_id', $userId)
            ->latest()
            ->get()
            ->map(function ($post) {
                return [
                    'post_id' => $post->id,
                    'content' => $post->content,
                    'created_at' => $post->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $post->updated_at->format('Y-m-d H:i:s'),
                ];
            });

        return response()->json([
            'status' => true,
            'message' => 'Data export berhasil diambil',
            'data' => [
                'user_info' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'total_posts' => $posts->count(),
                'posts' => $posts,
                'exported_at' => now()->format('Y-m-d H:i:s'),
            ]
        ], 200);
    }
}