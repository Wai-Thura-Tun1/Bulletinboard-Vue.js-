<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::controller(AuthController::class)->prefix('user')->group(function(){
    Route::post('login','loginUser');
});

Route::middleware('auth:api')->group(function(){
    Route::post('/user/logout',[AuthController::class,'logoutUser']);
    Route::controller(UserController::class)->group(function(){
        Route::prefix('user')->group(function(){
            Route::get('type','getType');
            Route::put('password','resetPass');
            Route::get('{id}','editUser');
            Route::post('','createUser');
            Route::get('create/data','createUserData');
            Route::get('update/data','updateUserData');
            Route::post('create/data','confirmCreate');
            Route::post('{id}/update','confirmUpdate');
            Route::put('{id}','updateUser');
            Route::delete('{id}','deleteUser');

        });
        Route::get('users','getUsers');
    });

    Route::controller(PostController::class)->group(function(){
        Route::prefix('post')->group(function(){
            Route::get('{id}', 'getPostDetail');
            Route::post('', 'createPost');
            Route::get('create/data','createPostData');
            Route::get('update/data','updateUserData');
            Route::post('create/data','confirmCreate');
            Route::post('{id}/update','confirmUpdate');
            Route::put('{id}', 'updatePost');
            Route::delete('{id}', 'deletePost');

        });

        Route::prefix('posts')->group(function(){
            Route::get('',[PostController::class, 'getPosts']);
            Route::post('',[PostController::class, 'uploadPost']);
            Route::get('excel',[PostController::class, 'getPost']);
        });
    });
});





