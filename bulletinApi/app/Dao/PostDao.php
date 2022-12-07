<?php
namespace App\Dao;
use App\Contracts\Dao\PostDaoInterface;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostDao implements PostDaoInterface {

    /**
     * Get Posts from Database (All for admin) (Related post for user)
     * @param Request $request
     * @return Object
     */
    public function getPosts($request)
    {
        return Post::with('createdUser')->when($request->user()->type != 0,function($query) use ($request){
            $query->whereHas('createdUser',function($query) use ($request){
                $query->where('id',$request->user()->id);
            });
        })->when($request->search,function($query) use ($request){
            $query->where('title','LIKE','%'.$request->search.'%')
            ->orWhere('description','LIKE','%'.$request->search.'%')
            ->orWhereHas('createdUser', function($query) use ($request){
                $query->where('name','LIKE','%'.$request->search.'%');
            });
        })
        ->orderBy("created_at",'DESC')
        ->paginate(config('constants.paginate'));
    }

    /**
     * Get Posts By Id
     * @param int $id
     * @return Object
     */
    public function getPostDetail($id) {
        return Post::with('createdUser','updatedUser')->where('id',$id)->first();
    }

    /**
     * Create Post
     * @param array $data
     * @return mixed
     */
    public function confirmCreate($data)
    {
        return DB::transaction(function() use ($data){
            Post::create($data);
        });
    }

    /**
     * Update Post
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function confirmUpdate($data, $id)
    {
        return DB::transaction(function() use ($data,$id){
            Post::find($id)->update($data);
        });
    }

    /**
     * Get all title of post from database
     * @return array
     */
    public function fetchAllTitle()
    {
        return Post::pluck('title')->toArray();
    }

    /**
     * Create posts from csv file with just one query
     * @param array $data
     * @return mixed
     */
    public function uploadPost($data)
    {
        return DB::transaction(function() use ($data){
            return Post::insert($data);
        });
    }

    /**
     * Delete Post
     * @param int $id
     * @return mixed
     */
    public function deletePost($id)
    {
        return DB::transaction(function() use ($id){
            Post::find($id)->delete();
        });
    }

    /**
     * Get Post By user id
     * @param int $id
     * @return Object
     */
    public function getPostByUserId($id) {
        return Post::where('created_user_id',$id)->get();
    }
}
?>
