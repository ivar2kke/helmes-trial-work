<?php

use App\Http\Controllers\UserController;
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

Route::get('/', 'App\Http\Controllers\UserController@create');
Route::post('/store', 'App\Http\Controllers\UserController@store');
Route::post('/terminate', 'App\Http\Controllers\UserController@terminate');
Route::put('/update/{user_id}', 'App\Http\Controllers\UserController@update')->whereNumber('user_id');
