<?php
namespace App\Contracts\Dao;

interface UserDaoInterface {

    /**
     * Create user
     * @param array $data
     * @return mixed
     */
    public function createUser($data);

    /**
     * Get a lastest-user
     * @return mixed
     */
    public function lastId();

    /**
     * Get user by id
     * @param int $id
     * @return Object
     */
    public function editUser($id);

    /**
     * Get all user lists with search query
     * @param Request $request
     * @return Object
     */
    public function getUsers($request);

    /**
     * Update user
     * @param array $data
     * @param int $id
     * @return Object
     */
    public function updateUser($data,$id);

    /**
     * Delete user
     * @param int $id
     * @return mixed
     */
    public function deleteUser($id);

    /**
     * Change password
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function changePassword($id,$data);
}
?>
