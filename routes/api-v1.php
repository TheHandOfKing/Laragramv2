<?php

use App\Http\Controllers\UserController;

Route::middleware('auth')->prefix('/api')->group(function () {
  Route::get('users', [UserController::class, 'index'])->name('api.users');
});
