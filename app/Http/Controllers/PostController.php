<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Services\PostService;
use App\Http\Resources\PostResource;

class PostController extends Controller
{

private PostService $postService;

public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
       $user = auth()->user();

        $posts = $this->postService->getPostForUser($user);

        return response()->json([
            'message' => 'Posts retrieved successfully',
            'posts' => PostResource::collection($posts),
        ], 200);
 }

    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
{
     Gate::authorize('create', Post::class); 

    $validated = $request->validated();

     Post::create([
        'title' => $validated['title'],
        'user_id' => auth()->id(),
    ]);

    return response()->json([
        'message' => 'Post created successfully',
        'post' => PostResource::make($post),
    ], 201);
}

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }


public function update(UpdatePostRequest $request, Post $post)
{
    Gate::authorize('update', $post);

    $updatedPost = $this->postService->update(
        $post,
        $request->validated()
    );

    if (!$updatedPost) {
        return response()->json([
            'message' => 'Failed to update post'
        ], 400);
    }

    return response()->json([
        'message' => 'Post updated successfully',
        'post' => PostResource::make($updatedPost),
    ], 200);
}


    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);
        
        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully'
        ], 200);
    }
}
