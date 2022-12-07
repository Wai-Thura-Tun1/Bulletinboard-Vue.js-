<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PostsExport implements FromCollection,WithMapping,WithHeadings,ShouldAutoSize
{
    private $userId;

    public function __construct($id)
    {
        $this->userId = $id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Post::with('createdUser')->when($this->userId != 0,function($query){
            $query->where('created_user_id',$this->userId);
        })->get();
    }

    public function headings(): array
    {
        return config('constants.exportHeader');
    }

    public function map($post): array
    {
        return [
            $post->title,
            $post->description,
            $post->statustext,
            $post->createdUser->name,
            $post->posttime
        ];
    }
}
