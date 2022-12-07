<?php

namespace App\Models;

use App\Traits\ActionId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory,ActionId,SoftDeletes;

    protected $fillable = ['title','description','status'];

    protected $appends = ['posttime','statustext','updatetime'];

    public function createdUser() {
        return $this->belongsTo(User::class,'created_user_id','id');
    }

    public function getPostTimeAttribute() {
        return $this->created_at->format('Y/m/d');
    }

    public function getUpdateTimeAttribute() {
        return $this->updated_at->format('Y/m/d');
    }

    public function getStatusTextAttribute() {
        return config('constants.status')[$this->status];
    }

    public function updatedUser() {
        return $this->belongsTo(User::class,'updated_user_id','id');
    }
}
