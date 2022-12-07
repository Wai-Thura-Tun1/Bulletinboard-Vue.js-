<?php

namespace App\Dao;

use App\Contracts\Dao\UserDaoInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserDao implements UserDaoInterface
{
    /**
     * Create user
     * @param array $data
     * @return mixed
     */
    public function createUser($data)
    {
        return DB::transaction(function () use ($data) {
            return User::create($data);
        });
    }

    /**
     * Get a lastest-user
     * @return mixed
     */
    public function lastId()
    {
        return User::orderBy('id','DESC')->first();
    }

    /**
     * Update user
     * @param array $data
     * @param int $id
     * @return Object
     */
    public function updateUser($data,$id)
    {
        return DB::transaction(function () use ($data,$id) {
            $updateUser = User::find($id);
            $updateUser->update($data);
            return $updateUser;
        });
    }

    /**
     * Change password
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function changePassword($id,$data)
    {
        return DB::transaction(function () use ($id,$data){
            return User::find($id)->update($data);
        });
    }

    /**
     * Get user by id
     * @param int $id
     * @return Object
     */
    public function editUser($id)
    {
        return User::find($id);
    }

    /**
     * Delete user
     * @param int $id
     * @return mixed
     */
    public function deleteUser($id) {
        return DB::transaction(function() use ($id){
            return User::find($id)->delete();
        });
    }

    /**
     * Get all user lists with search query
     * @param Request $request
     * @return Object
     */
    public function getUsers($request)
    {
        return User::with('createdUser')->where('name', 'LIKE', '%' . $request->name . '%')
            ->when($request->email, function ($query) use ($request) {
                $query->where('email', 'LIKE', '%' . $request->email . '%');
            })
            ->when($request->from, function ($query) use ($request) {
                $query->when($request->to, function ($query1) use ($request) {
                    $query1->whereBetween('created_at', [date($request->from), date($request->to)]);
                });
            })
            ->orderBy('created_at','DESC')
            ->paginate(config('constants.paginate'));
    }
}
