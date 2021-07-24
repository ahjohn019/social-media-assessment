<?php

use Illuminate\Support\Facades\Route;
use App\Posts;
use App\Comments;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RegLoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $posts_All = Posts::orderBy('created_at','desc')->paginate(5);
    $comments_All = Comments::orderBy('created_at','desc')->get();
    $users_All = User::all();
    return View::make('index')->with(compact('posts_All', 'comments_All','users_All'));
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/login', function () {
    return view('login');
});