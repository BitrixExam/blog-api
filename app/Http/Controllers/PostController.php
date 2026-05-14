<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Filters\PostFilter;

class PostController extends Controller
{
    public function __construct(
        private PostFilter $postFilter,
    ) {
    }

    public function storePost(StorePostRequest $request): PostResource
    {
        $post = $request->user()->posts()->create($request->validated());

        return new PostResource($post);
    }

    public function showPosts(Request $request): AnonymousResourceCollection
    {
        $posts = $this->postFilter->apply(Post::query(), $request)->get();

        return PostResource::collection($posts);
    }

    public function showMyPosts(Request $request): AnonymousResourceCollection
    {
        $posts = $this->postFilter->apply($request->user()->posts()->getQuery(), $request)->get();

        return PostResource::collection($posts);
    }
}
