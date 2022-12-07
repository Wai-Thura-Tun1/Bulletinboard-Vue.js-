<?php
namespace App\Contracts\Services;

interface UserServiceInterface {

    /**
     * Cache all create-user data with user token
     * @param UserCreateRequest $request
     * @return response
     */
    public function createUser($request);

    /**
     * Get user by id
     * @param int $id
     * @return response
     */
    public function editUser($id);

    /**
     * Get all user lists with search query
     * @param Request $request
     * @return response
     */
    public function getUsers($request);

    /**
     * Get user type
     * @return response
     */
    public function getType();

    /**
     * Create user
     * @param Request $request
     * @return response
     */
    public function confirmCreate($request);

    /**
     * Update user
     * @param Request $request
     * @param int $id
     * @return response
     */
    public function confirmUpdate($request,$id);

    /**
     * Get create-user data with user token
     * @param Request $request
     * @return response
     */
    public function createUserData($request);

    /**
     * Get update-user data with user token
     * @param Request $request
     * @return response
     */
    public function updateUserData($request);

    /**
     * Cache all update-post data with user token
     * @param Request $request
     * @return response
     */
    public function updateUser($request);

    /**
     * Delete user and related post
     * @param Request $request
     * @param int $id
     * @return response
     */
    public function deleteUser($request,$id);

    /**
     * Change password
     * @param ChangePasswordRequest $request
     * @return response
     */
    public function changePassword($request);
}
?>
