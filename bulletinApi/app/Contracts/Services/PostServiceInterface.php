<?php
namespace App\Contracts\Services;

interface PostServiceInterface {

    /**
     * Get Posts from Database (All for admin) (Related post for user)
     * @param Request $request
     * @return response
     */
    public function getPosts($request);

    /**
     * Get Posts By Id
     * @param int $id
     * @return response
     */
    public function getPostDetail($id);

    /**
     * Cache all create-post data with user token
     * @param Request $request
     * @return response
     */
    public function createPost($request);

    /**
     * Get create-post data with user token
     * @param PostRequest $request
     * @return response
     */
    public function createPostData($request);

    /**
     * Get update-post data with user token
     * @param PostRequest $request
     * @return response
     */
    public function updatePostData($request);

    /**
     * Create Post
     * @param Request $request
     * @return response
     */
    public function confirmCreate($request);

    /**
     * Update Post
     * @param Request $request
     * @param int $id
     * @return response
     */
    public function confirmUpdate($request,$id);

    /**
     * Cache all update-post data with user token
     * @param Request $request
     * @param int $id
     * @return response
     */
    public function updatePost($request,$id);

    /**
     * Delete Post
     * @param int $id
     * @return response
     */
    public function deletePost($id);

    /**
     * Read csv file and create data-set for creating posts
     * @param PostUploadRequest $request
     * @return response
     */
    public function uploadPost($request);

    /**
     * Export Post Data
     * @param Request $request
     * @return response
     */
    public function exportPost($request);
}
?>
