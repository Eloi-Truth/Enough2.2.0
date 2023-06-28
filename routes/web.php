<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('/community', CommunityController::class);
//Route::get('community/{community}', 'CommunityController@show')->name('community.show');
//Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
//Route::post('/communities/{community}/subscribe', [CommunityController::class 'subscribe'])->name('communities.subscribe');
//Route::post('/communities/{community}/subscribe', [CommunityController::class, 'subscribe'])->name('communities.subscribe');

Route::group(['middleware' => 'auth'], function () {
    // Rota para inscrever-se em uma comunidade
    Route::post('/communities/{community}/subscribe', [CommunityController::class, 'subscribe'])->name('communities.subscribe');

    // Rota para acessar a comunidade e suas funcionalidades apenas para usuários inscritos
    Route::get('/communities/{community}', [CommunityController::class, 'show'])->name('community.show');
    Route::post('/communities/{community}/posts', [CommunityController::class, 'storePost'])->name('community.posts.store');
    Route::post('/communities/{community}/posts/{post}/comments', [CommunityController::class, 'storeComment'])->name('community.comments.store');
});



Route::get('community/{community}/users', [CommunityController::class, 'showUsers'])->name('community.users');



Route::resource('/posts', PostController::class);


Route::resource('/comment',CommentController::class);


//Route::resource('/likes/{id}', LikeController::class);
//Route::post('/likes/{id}', [LikeController::class, 'store'])->name('likes.store');
Route::delete('/likes/{id}', [LikeController::class, 'destroy'])->name('likes.destroy');
Route::post('/likes', [LikeController::class, 'store'])->name('likes.store');

Route::post('/communities/{community_id}/posts/{post_id}/likes', 'LikeController@store')->name('community.posts.likes.store');




require __DIR__.'/auth.php';
