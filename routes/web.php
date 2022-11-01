<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\AuthController;

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

Route::get('/', function (Request $request) {
    if($request->user()){
        return redirect()->route('exercises.index');
    }
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login-auth');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('user')->name('users.')->group(function(){
    Route::get('/', [UserController::class, 'index'])->name('index');

    Route::get('/profile/{id?}', [UserController::class, 'profile'])->name('profile');

    Route::get('/add', [UserController::class, 'getAdd'])->name('get-add');

    Route::post('/add', [UserController::class, 'postAdd'])->name('post-add');

    Route::get('/update/{id?}', [UserController::class, 'getUpdate'])->name('get-update');

    Route::post('/update/{id?}', [UserController::class, 'postUpdate'])->name('post-update');

    Route::get('/change-password/{id}', [UserController::class, 'getPassword'])->name('get-password');

    Route::post('/change-password', [UserController::class, 'postPassword'])->name('post-password');

    Route::get('/delete/{id}', [UserController::class, 'delete'])->name('delete');

    Route::get('/messages', [UserController::class, 'messages'])->name('messages');
});

Route::prefix('exercise')->name('exercises.')->group(function(){
    Route::get('/', [ExerciseController::class, 'index'])->name('index');

    Route::get('/detail/{id}', [ExerciseController::class, 'detail'])->name('detail');

    Route::get('/add', [ExerciseController::class, 'getAdd'])->name('get-add');

    Route::post('/add', [ExerciseController::class, 'postAdd'])->name('post-add');

    Route::get('/update/{id?}', [ExerciseController::class, 'getUpdate'])->name('get-update');

    Route::post('/update/{id?}', [ExerciseController::class, 'postUpdate'])->name('post-update');

    Route::get('/delete/{id}', [ExerciseController::class, 'delete'])->name('delete');

    Route::get('/download/{id}', [ExerciseController::class, 'download'])->name('download');
});

Route::prefix('quiz')->name('quizzes.')->group(function(){
    Route::get('/', [QuizController::class, 'index'])->name('index');

    Route::get('/detail/{id}', [QuizController::class, 'detail'])->name('detail');

    Route::get('/add', [QuizController::class, 'getAdd'])->name('get-add');

    Route::post('/add', [QuizController::class, 'postAdd'])->name('post-add');

    Route::get('/update/{id?}', [QuizController::class, 'getUpdate'])->name('get-update');

    Route::post('/update/{id?}', [QuizController::class, 'postUpdate'])->name('post-update');

    Route::get('/delete/{id}', [QuizController::class, 'delete'])->name('delete');

    Route::get('/download/{id}', [QuizController::class, 'download'])->name('download');
});