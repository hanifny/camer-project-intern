<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::post('/login', 'Auth\LoginController');

Route::post('login', 'AuthController@login');
Route::post('refresh', 'AuthController@refresh');


Route::middleware('auth:api')->group(function () {
    // Get user info
    Route::post('me', 'AuthController@me');
    // Logout user from application
    Route::post('logout', 'AuthController@logout');
});