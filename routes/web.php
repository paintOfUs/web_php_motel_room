<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthenticateMiddleware;
use App\Models\post;
use App\Http\Controllers\SearchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $posts = post::simplePaginate(3);
    $latestPosts = post::latest()->take(6)->get();
    return view('home',['posts'=> $posts,'latestPosts'=> $latestPosts]);
})->name('home');

//login and register
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/doLogin', [AuthController::class, 'login'])->name('dologin');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/regist', [RegisterController::class, 'index'])->name('regist');
Route::get('/doregist', [RegisterController::class, 'register'])->name('doregist');
//Admin
Route::get('/Admin', [AdminController::class, 'index'])->name('admin')->middleware(AuthenticateMiddleware::class);
Route::post('/Admin', [AdminController::class, 'page'])->name('logic');
Route::get('/Admin/edit/{id}', [AdminController::class, 'edit'])->name('edit');
Route::get('/Admin/remove/{id}', [AdminController::class, 'remove'])->name('remove');
Route::get('/Admin/create', [AdminController::class, 'create'])->name('create');

//User
Route::match(['post', 'put'], '/create', [UserController::class, 'create'])->name('add');
Route::get('/detail', [DetailController::class, 'detail'])->name('detail');

//Search
Route::post('/search', [SearchController::class,'search'])->name('search');