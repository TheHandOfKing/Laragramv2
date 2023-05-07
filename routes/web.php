<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [UserProfileController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/profiles/{user:slug}', [UserProfileController::class, 'show'])->middleware(['auth', 'verified', 'ensureProfileIsVisible'])->name('profile');
// Posts
Route::resource('posts', PostController::class)->except('index', 'create', 'show');
Route::get('/p/{post:slug}', [PostController::class, 'show'])->name('posts.show')->middleware(['auth', 'verified']);
// Comments
Route::resource('comments', CommentController::class, ['except' => ['create, show']]);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Follower logic
Route::middleware(['auth'])->group(function () {
    Route::post('/follow/{user}', [FollowController::class, 'follow'])->name('follow');
    Route::get('/{user}/followers', [FollowController::class, 'followers'])->name('followers');
    Route::get('/{user}/following', [FollowController::class, 'following'])->name('following');
});

// Media routes
Route::middleware('auth')->group(function () {
    Route::post('/media/update-media/{modelType}/{modelId}/{collection}', [MediaController::class, 'store'])->name('model.updateMedia');
    Route::delete('/media/delete-media/{media}', [MediaController::class, 'destroy'])->name('model.deleteMedia');
});

require __DIR__ . '/auth.php';
