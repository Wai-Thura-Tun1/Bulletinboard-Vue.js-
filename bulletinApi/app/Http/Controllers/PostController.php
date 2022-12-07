<?php

namespace App\Http\Controllers;

use App\Contracts\Services\PostServiceInterface;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PostUploadRequest;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private $postService;
    public function __construct(PostServiceInterface $postServiceInterface)
    {
        $this->postService = $postServiceInterface;
    }

    /**
     * Get Posts from Database (All for admin) (Related post for user)
     * @param Request $request
     * @return reponse
     */
    public function getPosts(Request $request) {
        return $this->postService->getPosts($request);
    }

    /**
     * Get Posts By Id
     * @param int $id
     * @return response
     */
    public function getPostDetail($id) {
        return $this->postService->getPostDetail($id);
    }

    /**
     * Cache all create-post data with user token
     * @param Request $request
     * @return response
     */
    public function createPost(PostRequest $request) {
        return $this->postService->createPost($request);
    }

    /**
     * Cache all update-post data with user token
     * @param Request $request
     * @param int $id
     * @return response
     */
    public function updatePost(PostRequest $request,$id) {
        return $this->postService->updatePost($request,$id);
    }

    /**
     * Get create-post data with user token
     * @param PostRequest $request
     * @return response
     */
    public function createPostData(Request $request) {
        return $this->postService->createPostData($request);
    }

    /**
     * Get update-post data with user token
     * @param PostRequest $request
     * @return response
     */
    public function updateUserData(Request $request) {
        return $this->postService->updatePostData($request);
    }

    /**
     * Create Post
     * @param Request $request
     * @return response
     */
    public function confirmCreate(Request $request) {
        return $this->postService->confirmCreate($request);
    }

    /**
     * Update Post
     * @param Request $request
     * @param int $id
     * @return response
     */
    public function confirmUpdate(Request $request,$id) {
        return $this->postService->confirmUpdate($request,$id);
    }

    /**
     * Read csv file and create data-set for creating posts
     * @param PostUploadRequest $request
     * @return response
     */
    public function uploadPost(PostUploadRequest $request) {
        return $this->postService->uploadPost($request);
    }

    /**
     * Delete Post
     * @param int $id
     * @return response
     */
    public function deletePost($id) {
        return $this->postService->deletePost($id);
    }

    /**
     * Export Post Data
     * @param Request $request
     * @return response
     */
    public function getPost(Request $request) {
        return $this->postService->exportPost($request);
    }
}
