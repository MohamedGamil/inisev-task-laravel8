<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use App\Events\PostPublished;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostsController extends ApiBaseController
{
    /**
     * @return \Illuminate\Http\Response
     *
     * @SWG\Post(
     *      path="/create-post",
     *      summary="Creates a new post.",
     *      tags={"post"},
     *      description="Creates a new post using given inputs.",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="title",
     *          description="Title of new post",
     *          in="formData",
     *          required=true,
     *          type="string",
     *          format="varchar"
     *      ),
     *      @SWG\Parameter(
     *          name="slug",
     *          description="Slug of new post",
     *          in="formData",
     *          required=false,
     *          type="string",
     *          format="varchar"
     *      ),
     *      @SWG\Parameter(
     *          name="description",
     *          description="Description of new post",
     *          in="formData",
     *          required=false,
     *          type="string",
     *          format="text"
     *      ),
     *      @SWG\Parameter(
     *          name="author_id",
     *          description="Author ID of new post",
     *          in="formData",
     *          required=true,
     *          type="number",
     *          format="integer"
     *      ),
     *      @SWG\Parameter(
     *          name="website_id",
     *          description="Website ID of new post",
     *          in="formData",
     *          required=true,
     *          type="number",
     *          format="integer"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @SWG\Response(
     *          response=400,
     *          description="Bad Request"
     *       ),
     *      @SWG\Response(
     *          response=404,
     *          description="Resources Not Found"
     *       ),
     *     )
     */
    public function createPost(Request $request)
    {
        $rules = [
            'title' => 'required|string',
            'slug' => 'nullable|string',
            'description' => 'nullable|string',
            'author_id' => 'required|exists:App\Models\User,id',
            'website_id' => 'required|exists:App\Models\Website,id',
        ];

        $this->validate($request, $rules);

        $keys = array_keys($rules);
        $inputs = collect($request->input())
            ->only($keys)
            ->toArray();

        $inputs['published_at'] = now();

        $post = new Post($inputs);

        if (false === $post->save()) {
            return $this->sendError('Unable to create post');
        }

        \Log::debug("Post published.");

        event(new PostPublished($post->website, $post));

        return $this->sendResponse([
            'post' => $post,
        ]);
    }
}
