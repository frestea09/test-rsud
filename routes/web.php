<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;



Route::get('/', function () {
    return view('login', [LoginController::class, 'showLoginForm']);
});


Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/', function () {
    return view('login', [LoginController::class, 'showLoginForm']);
})->name('home');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.submit');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/generate-pdf', function(){
    return"ganteng";
})->name('generate.pdf');

Route::get('/dashboard',  [LoginController::class, 'login'])->name('dashboard');
Route::post('/users', action: [UserController::class, 'store'])->name('users.store');
Route::get(uri : '/users/{id}/edit', action :[ UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [ UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
