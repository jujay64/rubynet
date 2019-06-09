<?php

use Illuminate\Http\Request;

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
Route::group(['prefix' => 'api'], function(){

/**
* Auth
*/
Route::post('auth/logout', 'Auth\LoginController@logout');

/**
* Users
*/
Route::resource('users','User\UserController',['except' => ['create','edit']]);
Route::resource('users.postlikes','User\UserPostLikeController',['only' => ['index']]);
Route::resource('users.posts','User\UserPostController',['only' => ['index']]);
Route::name('verify')->get('users/verify/{token}','User\UserController@verify');
Route::name('resend')->get('users/{user}/resend','User\UserController@resend');
Route::get('user', 'User\UserController@getAuthenticatedUser');

Route::post('users/{user}/photo', 'User\UserController@uploadPicture');
/**
* Departments
*/
Route::resource('departments','Department\DepartmentController',['except' => ['create','edit']]);
Route::resource('departments.users','Department\DepartmentUserController',['only' => ['index']]);

/**
* Comments
*/
Route::resource('comments','Comment\CommentController',['only' => ['index','show']]);

/**
* Posts
*/
Route::resource('posts','Post\PostController',['except' => ['create','edit']]);
Route::resource('posts.comments','Post\PostCommentController',['only' => ['index']]);

/**
* PostLikes
*/
Route::resource('postlikes','PostLike\PostLikeController',['only' => ['index','show']]);

/**
* UserTrees
*/
Route::resource('usertrees','UserTree\UserTreeController',['only' => ['index','show']]);

/**
* Jobs
*/
Route::resource('jobs','Job\JobController',['except' => ['create','edit']]);

/**
* Roles
*/
Route::resource('roles','Role\RoleController',['except' => ['create','edit']]);

/**
* DepartmentManager
*/
Route::resource('departmentmanagers','DepartmentManager\DepartmentManagerController',['except' => ['create','edit']]);

Route::post('oauth/token','\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');

});