<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;


trait ActionId {
    public static function bootActionId():void {
        static::creating(function($model){
            $model->created_user_id = request()->user()->id ?? 1;
            $model->updated_user_id = request()->user()->id ?? 1;
            Cache::pull('createdUserData'.request()->bearerToken());
            Cache::pull('createdPost'.request()->bearerToken());
        });

        static::updating(function($model){
            $model->updated_user_id = request()->user()->id;
            Cache::pull('updatedUserData'.request()->bearerToken());
            Cache::pull('updatedPost'.request()->bearerToken());
        });

        static::deleting(function($model){
            $model->deleted_user_id = request()->user()->id;
        });
    }
}
