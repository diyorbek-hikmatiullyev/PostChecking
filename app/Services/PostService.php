<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class PostService
{
    public function update(Post $post, array $data): ?Post
    {
        return DB::transaction(function () use ($post, $data) {

            $post = Post::whereKey($post->id)
                ->lockForUpdate()
                ->firstOrFail();

            $post->update($data);

            if ($post->status === 'reject') {
                $post->delete();

                return null;
            }

            return $post->fresh();
        });
    }

    public function getPostForUser(User $user)
    {
        return match ($user->role) {
            'admin' => Post::all(),
            'jurnalist' => Post::where('status', 'pending')->orWhere('user_id', $user->id)->get(),
            'user' => Post::where('status', 'accept')->get(),
            default => Post::where('status', 'accept')->get(),
        };
    }
}
