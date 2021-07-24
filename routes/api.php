<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\RegLoginController;


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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//users
Route::get('/users', [UsersController::class, 'index']);
Route::get('/users/{id}', [UsersController::class, 'show']);
Route::put('/users/{id}', [UsersController::class, 'update']);
Route::delete('/users/{id}', [UsersController::class, 'destroy']);



//register/login
Route::post('/register', [RegLoginController::class, 'register']);
Route::post('/login', [RegLoginController::class, 'authenticate']);

//posts
Route::get('/posts', [PostsController::class, 'index']);
Route::get('/posts/{id}', [PostsController::class, 'show']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('logout', [RegLoginController::class, 'logout']);
    Route::get('get_user', [RegLoginController::class, 'get_user']);
    Route::post('/posts', [PostsController::class, 'store']);
    Route::put('/posts/{id}', [PostsController::class, 'update']);
    Route::delete('/posts/{id}', [PostsController::class, 'destroy']);
});


//comments
Route::get('/comments', [CommentsController::class, 'index']);
Route::post('/comments', [CommentsController::class, 'store']);
Route::get('/comments/{id}', [CommentsController::class, 'show']);
Route::put('/comments/{id}', [CommentsController::class, 'update']);
Route::delete('/comments/{id}', [CommentsController::class, 'destroy']);



