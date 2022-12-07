<?php
namespace App\Services;

use App\Contracts\Dao\PostDaoInterface;
use App\Contracts\Dao\UserDaoInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Traits\CommonService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserService implements UserServiceInterface {
    use CommonService;
    private $userDao;
    private $postDao;
    public function __construct(UserDaoInterface $userDaoInterface,PostDaoInterface $postDaoInterface) {
        $this->userDao = $userDaoInterface;
        $this->postDao = $postDaoInterface;
    }

    /**
     * Cache all create-user data with user token
     * @param UserCreateRequest $request
     * @return response
     */
    public function createUser($request)
    {
        $this->cacheData($request,"createdUserData");
        return $this->createReponse("null","User has been cached successfully",200,"user");
    }

    /**
     * Get create-user data with user token
     * @param Request $request
     * @return response
     */
    public function createUserData($request)
    {
        $createCache = Cache::get('createdUserData'.$request->bearerToken());
        return $this->createReponse($createCache,"Created cache user data",200,"user");
    }

    /**
     * Get update-user data with user token
     * @param Request $request
     * @return response
     */
    public function updateUserData($request) {
        $updateCache = Cache::get('updatedUserData'.$request->bearerToken());
        return $this->createReponse($updateCache,"Updated cache user data",200,"user");
    }

    /**
     * Delete user and related post
     * @param Request $request
     * @param int $id
     * @return response
     */
    public function deleteUser($request,$id) {
        $deletedUser = $this->userDao->deleteUser($id);
        if ($deletedUser) {
            $postByUserId = $this->postDao->getPostByUserId($id);
            foreach($postByUserId as $post) {
                $this->postDao->deletePost($post->id);
            }
            Storage::disk('public')->deleteDirectory($id);
            return $this->createReponse([],"User has been deleted successfully",200,"user");
        }
    }

    /**
     * Cache all update-post data with user token
     * @param Request $request
     * @return response
     */
    public function updateUser($request){
        $this->cacheData($request,"updatedUserData");
        return $this->createReponse("null","User has been cached successfully",200,"user");
    }

    /**
     * Create user
     * @param Request $request
     * @return response
     */
    public function confirmCreate($request) {
        $uniquePath = Str::random(40);
        $imagePart = explode(';base64,',$request->profile)[0];
        $fileID = $this->userDao->lastId();
        $type = explode("image/",$imagePart)[1];
        $path = ((int)$fileID->id + 1)."/image/".$uniquePath.".".$type;
        $storepath = config('constants.profile_url').$path;
        $data = $this->filterData($request,$storepath);
        $created = $this->userDao->createUser($data);
        if ($created) {
            Storage::disk('public')->put($path,file_get_contents($request->profile));
            return $this->createReponse([],"User has been created successfully",200,"user");
        }
    }

    /**
     * Update user
     * @param Request $request
     * @param int $id
     * @return response
     */
    public function confirmUpdate($request,$id) {
        $storepath = '';
        $exitProfile = str_contains($request->profile,"http");
        if (!$exitProfile) {
            $uniquePath = Str::random(40);
            $imagePart = explode(';base64,',$request->profile)[0];
            $type = explode("image/",$imagePart)[1];
            $path = $id."/image/".$uniquePath.".".$type;
            $storepath = config('constants.profile_url').$path;
        }
        else {
            $storepath = $request->profile;
        }
        $data = $this->filterData($request,$storepath,false);
        $currentProfile = $this->userDao->editUser($id);
        $fitlerCurrent = explode("/storage/",$currentProfile->profile)[1];
        $updated = $this->userDao->updateUser($data,$id);
        if ($updated && !$exitProfile) {
            Storage::disk('public')->delete($fitlerCurrent);
            Storage::disk('public')->put($path,file_get_contents($request->profile));
        }
        return $this->createReponse([],"User has been updated successfully",200,"user");
    }

    /**
     * Get user by id
     * @param int $id
     * @return response
     */
    public function editUser($id) {
        $profileUser = $this->userDao->editUser($id);
        return $this->createReponse($profileUser,"user profile data",200,"user");
    }

    /**
     * Get all user lists with search query
     * @param Request $request
     * @return response
     */
    public function getUsers($request)
    {
        $users = $this->userDao->getUsers($request);
        return $this->createReponse($users,"Users have been fetched successfully",200,"users");
    }

    /**
     * Get user type
     * @return response
     */
    public function getType()
    {
        $type = config('constants.type');
        return $this->createReponse($type,"User types",200,"types");
    }

    /**
     * Change password
     * @param ChangePasswordRequest $request
     * @return response
     */
    public function changePassword($request)
    {
        if (Hash::check($request->oldPass,$request->user()->password)) {

            $data = [
                'password' => Hash::make($request->newPass)
            ];
            $this->userDao->changePassword($request->user()->id,$data);
            return $this->createReponse([],"Password have been updated successfully.",200,"user");
        }
        else {
            return $this->createReponse(["oldPass" => "Wrong password"],"Password have been updated successfully.",401,"error");
        }
    }

    /**
     * Create data array for user table
     * @param Object $validated
     * @param string $path
     * @param bool $pass
     * @return mixed
     */
    public function filterData($validated,$path,$pass= true) {
        $data = [
            'name' => $validated->name,
            'email' => $validated->email,
            'profile' => $path,
            'type' => $validated->type,
            'phone' => $validated->phone ?? NULL,
            'address' => $validated->address ?? NULL,
            'dob' => $validated->dob ?? NULL,
        ];

        if ($pass) {
            $data['password'] = Hash::make($validated->pass);
        }
        return $data;
    }

    /**
     * Cache user data
     * @param Object $request
     * @param string $key
     * @return mixed
     */
    public function cacheData($request,$key) {
        $profile = '';
        $userType = config('constants.type')[$request->type];
        if ($request->profile) {
            $type = $request->profile->extension();
            $rawImage = file_get_contents($request->profile);
            $profile = "data:image/".$type.";base64,".base64_encode($rawImage);
        }
        else {
            $profileUser = $this->userDao->editUser($request->id);
            $profile = $profileUser->profile;
        }
        $data = [
            "id" => $request->id ?? '',
            'name' => $request->name,
            'email' => $request->email,
            'pass' => $request->pass,
            'typeid' => $request->type,
            'type' => $userType,
            'phone' => $request->phone ?? NULL,
            'dob' => $request->dob ?? NULL,
            'address' => $request->address ?? NULL,
            'profile' => $profile,
        ];
        Cache::put($key.$request->bearerToken(),$data,300);
        return;
    }
}
?>
