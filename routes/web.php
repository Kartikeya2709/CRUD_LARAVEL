<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserCommentController;
use App\Http\Controllers\CommentLogController;

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
    return redirect()->route('users.index');
});

Route::resource('users', UserCommentController::class)->except(['create', 'edit', 'show']);
Route::get('/logs', [CommentLogController::class, 'index'])->name('logs.index');
