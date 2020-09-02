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

    // Get Lantai
    Route::get('lantai', 'CamerController@lantai');

    // Get unit per Lantai
    Route::get('lantai/{nama}', 'CamerController@unit_per_lantai');

    // Get unit per Lantai
    Route::get('lantai/{nama}/{unit}', 'CamerController@detail_unit');

});