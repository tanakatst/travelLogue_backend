<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
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


Route::post('login','LoginController@login');
Route::post('logout', 'LoginController@logout');
Route::post('register', [LoginController::class, "register"]);

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('editUser','LoginController@edit');
    // Route::get('getPosts', 'PostController@getPost');
    // Route::post('post', 'PostController@post');
    // Route::post('update', 'PostController@updatePost');
    // Route::delete('delete', 'PostController@destroy');
    Route::apiResource('posts', 'PostController');
    Route::apiResource('plan', 'PlanController');
    // Route::get('post', 'PostController@post');
});


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });





