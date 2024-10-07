<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('editoriales', App\Http\Controllers\EditorialController::class)->middleware('auth');

Route::get('/delete-editorial/{editorial_id}', [
    'as' => 'deleteEditorial',
    'middleware' => 'auth',
    'uses' => '\App\Http\Controllers\EditorialController@deleteEditorial'
]);
