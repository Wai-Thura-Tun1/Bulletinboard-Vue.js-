<?php
namespace App\Contracts\Dao;

interface PostDaoInterface {

    /**
     * Get Posts from Database (All for admin) (Related post for user)
     * @param Request $request
     * @return Object
     */
    public function getPosts($request);

    /**
     * Get Posts By Id
     * @param int $id
     * @return Object
     */
    public function getPostDetail($id);

    /**
     * Create Post
     * @param array $data
     * @return mixed
     */
    public function confirmCreate($data);

    /**
     * Update Post
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function confirmUpdate($data,$id);

    /**
     * Delete Post
     * @param int $id
     * @return mixed
     */
    public function deletePost($id);

    /**
     * Get all title of post from database
     * @return array
     */
    public function fetchAllTitle();

    /**
     * Create posts from csv file with just one query
     * @param array $data
     * @return mixed
     */
    public function uploadPost($data);

    /**
     * Get Post By user id
     * @param int $id
     * @return Object
     */
    public function getPostByUserId($id);
}
?>
