<?php

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

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login'); //Login page
    Route::post('/login', [LoginController::class, 'login']);                       //Login interface
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])    //Registration page
    ->name('register');
    Route::post('/register', [RegisterController::class, 'register']);     //Account registration interface
    Route::get('/logout', function () {                                     //Log out and log in
//        auth()->logout();
        session()->forget('user');
        return redirect('/');
    })->name('logout');

    Route::get('/', [ProjectController::class, 'index']);                      //Go directly to the project list on the homepage
    Route::get('/details/{id}', [ProjectController::class, 'details']);    //Project details page

// All routes except homepage, registration, and login require authentication
Route::middleware('auth')->group(function () {
    Route::get('/add', [ProjectController::class, 'add']);                 //Enter the project addition page
    Route::get('/cancel', [UserController::class, 'cancel']);              //User cancels account
    Route::get('/add/{id}', [ProjectController::class, 'add']);            //Enter the project editing page
    Route::post('/add', [ProjectController::class, 'add']);                //Project Add Interface
    Route::post('/add/{id}', [ProjectController::class, 'add']);           //Project editing interface
    Route::get('/delete/{id}', [ProjectController::class, 'delete']);      //Project deletion interface
});
