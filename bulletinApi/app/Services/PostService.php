<?php
namespace App\Services;

use App\Contracts\Dao\PostDaoInterface;
use App\Contracts\Services\PostServiceInterface;
use App\Exports\PostsExport;
use App\Traits\CommonService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class PostService implements PostServiceInterface {
    use CommonService;
    private $postDao;
    public function __construct(PostDaoInterface $postDaoInterface) {
        $this->postDao = $postDaoInterface;
    }

    /**
     * Get Posts from Database (All for admin) (Related post for user)
     * @param Request $request
     * @return response
     */
    public function getPosts($request)
    {
        $posts = $this->postDao->getPosts($request);
        return $this->createReponse($posts,"Posts have been fetch successfully.",200,"posts");
    }

    /**
     * Get Posts By Id
     * @param int $id
     * @return response
     */
    public function getPostDetail($id)
    {
        $postDetail = $this->postDao->getPostDetail($id);
        return $this->createReponse($postDetail,"Post has been fetch successfully.",200,"post");
    }

    /**
     * Get create-post data with user token
     * @param PostRequest $request
     * @return response
     */
    public function createPostData($request) {
        $createdPost = Cache::get('createdPost'.$request->bearerToken());
        return $this->createReponse($createdPost,"Created post-cache data has been fetched",200,"post");
    }

    /**
     * Get update-post data with user token
     * @param PostRequest $request
     * @return response
     */
    public function updatePostData($request) {
        $updatedPost = Cache::get('updatedPost'.$request->bearerToken());
        return $this->createReponse($updatedPost,"Updated post-cache data has been fetched",200,"post");
    }

    /**
     * Cache all create-post data with user token
     * @param Request $request
     * @return response
     */
    public function createPost($request)
    {
        $this->cachePost("createdPost",$request);
        return $this->createReponse([],"Create Post has been cached successfully",200,"post");
    }

    /**
     * Cache all update-post data with user token
     * @param Request $request
     * @param int $id
     * @return response
     */
    public function updatePost($request, $id)
    {
        $this->cachePost("updatedPost",$request,$id);
        return $this->createReponse([],"Update Post has been cached successfully",200,"post");
    }

    /**
     * Create Post
     * @param Request $request
     * @return response
     */
    public function confirmCreate($request) {
        $data = $this->filterData($request);
        $this->postDao->confirmCreate($data);
        return $this->createReponse([],"Post has been created successfully",200,"post");
    }

    /**
     * Update Post
     * @param Request $request
     * @param int $id
     * @return response
     */
    public function confirmUpdate($request, $id)
    {
        $data = $this->filterData($request);
        $this->postDao->confirmUpdate($data,$id);
        return $this->createReponse([],"Post has been updated successfully",200,"post");
    }

    /**
     * Delete Post
     * @param int $id
     * @return response
     */
    public function deletePost($id)
    {
        $this->postDao->deletePost($id);
        return $this->createReponse([],"Post has been deleted successfully",200,"post");
    }

    /**
     * Export Post Data
     * @param Request $request
     * @return response
     */
    public function exportPost($request)
    {
        return Excel::download(new PostsExport($request->user()->id), 'posts.xlsx');
    }

    /**
     * Cache post data
     * @param string $key
     * @param Request $request
     * @param $id
     * @return void
     */
    public function cachePost($key,$request,$id = null) {
        $data = $this->filterData($request);
        $data['id'] = $id ?? '';
        Cache::put($key.$request->bearerToken(),$data,300);
        return;
    }

    /**
     * Read csv file and create data-set for creating posts
     * @param PostUploadRequest $request
     * @return response
     */
    public function uploadPost($request) {
        $csv = file($request->data);
        $fileName = Str::random(10).$request->file('data')->getClientOriginalName();
        $filePath = $request->user()->id."/csv/".$fileName;
        $titles = $this->postDao->fetchAllTitle();
        $data = array_map('str_getcsv',$csv);
        $uploadData = [];
        foreach($data as $value) {
            if (!in_array($value[0],$titles)) {
                $uploadData[] = [
                    'title' => $value[0],
                    'description' => $value[1],
                    'status' => $value[2],
                    'created_user_id' => $request->user()->id,
                    'created_at' => now(),
                    'updated_user_id' => $request->user()->id,
                    'updated_at' => now(),
                ];
            }
        }
        $uploaded = $this->postDao->uploadPost($uploadData);
        if ($uploaded) {
            Storage::disk('public')->put($filePath,file_get_contents($request->data));
        }
        return $this->createReponse(["data" => $uploadData],"Post has been uploaded successfully",200,"post");
    }

    /**
     * Create data-array for Post Database
     * @param mixed $request
     * @return array
     */
    public function filterData($request) {
        return [
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status ?? '',
        ];

    }

}
?>
