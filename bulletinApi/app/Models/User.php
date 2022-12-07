<?php

namespace App\Models;

use App\Traits\ActionId;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory,HasApiTokens,ActionId,SoftDeletes;
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'phone',
        'dob',
        'address',
        'profile',
    ];
    protected $appends = ['typename','createtime','updatetime'];
    public const CREATED_AT = 'created_at';
    protected $hidden = ['password'];

    public function getTypeNameAttribute() {
        foreach(config('constants.type') as $key => $value) {
            if ($this->type == $key) {
                return $value;
            }
        }
    }

    public function getCreateTimeAttribute() {
        return $this->created_at->format('Y/m/d');
    }

    public function getUpdateTimeAttribute() {
        return $this->updated_at->format('Y/m/d');
    }

    public function createdUser() {
        return $this->belongsTo(User::class,'created_user_id','id');
    }
}
