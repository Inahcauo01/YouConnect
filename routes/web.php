<?php

use App\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ProfileController;

use App\Http\Livewire\Chat\CreateChat;
use App\Http\Livewire\Chat\Main;


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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/feed', function () {
        return view('feed');
    })->name('feed');
});


Route::get('/feed', [PostController::class, 'index'])->name('feed');
Route::resource('posts', PostController::class);
Route::put('posts', [PostController::class, 'update'])->name('posts.update');

// like and unlike
Route::post('/posts/{post}/like', [LikeController::class, 'like'])->name('posts.like');
Route::delete('/posts/{post}/unlike', [LikeController::class, 'unlike'])->name('posts.unlike');

// comments
// Route::post('/posts/{post_id}/comments', [CommentController::class, 'store'])->name('comments.store');
// Route::put('/posts/{post_id}/comments/{comment_id}', [CommentController::class, 'update'])->name('comments.update');
// Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');


Route::resource('tags', TagController::class)->only(['index', 'show']);

// Route::resource('profiles', ProfileController::class);
Route::resource('profiles', ProfileController::class)->only(['show','update']);
Route::get('/mark-as-read', [PostController::class, 'markCommeLu'])->name('posts.markCommeLu');

// livewire chat
Route::get('/users_chat',CreateChat::class)->name('users_chat');
Route::get('/chat{key?}',Main::class)->name('chat');
Route::get('/main',Main::class)->name('main');

Route::resource('/admin-dashboard', AdminDashboardController::class)->middleware('auth', 'role:admin');
// Route::resource('/admin-dashboard', AdminDashboardController::class);
// Route::get('/list-user-chat', function () {
//     return view('messages.list-user-chat');
// });

Route::get('/conversation-show/{messages}', function ($messages) {
    return view('messages.conversation-show',compact($messages));
})->name('conversation-show');
