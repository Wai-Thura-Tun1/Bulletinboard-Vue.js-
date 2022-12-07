<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserServiceInterface;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;
    public function __construct(UserServiceInterface $userServiceInterface)
    {
        $this->userService = $userServiceInterface;
    }

    /**
     * Cache all create-user data with user token
     * @param UserCreateRequest $request
     * @return response
     */
    public function createUser(UserCreateRequest $request) {
        return $this->userService->createUser($request);
    }

    /**
     * Get user by id
     * @param int $id
     * @return response
     */
    public function editUser($id) {
        return $this->userService->editUser($id);
    }

    /**
     * Get all user lists with search query
     * @param Request $request
     * @return response
     */
    public function getUsers(Request $request) {
        return $this->userService->getUsers($request);
    }

    /**
     * Get user type
     * @return response
     */
    public function getType() {
        return $this->userService->getType();
    }

    /**
     * Get create-user data with user token
     * @param Request $request
     * @return response
     */
    public function createUserData(Request $request) {
        return $this->userService->createUserData($request);
    }

    /**
     * Cache all update-post data with user token
     * @param UserUpdateRequest $request
     * @return response
     */
    public function updateUser(UserUpdateRequest $request) {
        return $this->userService->updateUser($request);
    }

    /**
     * Get update-user data with user token
     * @param Request $request
     * @return response
     */
    public function updateUserData(Request $request) {
        return $this->userService->updateUserData($request);
    }

    /**
     * Create user
     * @param Request $request
     * @return response
     */
    public function confirmCreate(Request $request) {
        return $this->userService->confirmCreate($request);
    }

    /**
     * Update user
     * @param Request $request
     * @param int $id
     * @return response
     */
    public function confirmUpdate(Request $request,$id) {
        return $this->userService->confirmUpdate($request,$id);
    }

    /**
     * Delete user and related post
     * @param Request $request
     * @param int $id
     * @return response
     */
    public function deleteUser(Request $request,$id) {
        return $this->userService->deleteUser($request,$id);
    }

    /**
     * Change password
     * @param ChangePasswordRequest $request
     * @return response
     */
    public function resetPass(ChangePasswordRequest $request) {
        return $this->userService->changePassword($request);
    }
}
