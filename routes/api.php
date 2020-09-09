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

    // Get lantai
    Route::get('floor', 'CamerController@floor');

    // Get nama unit per lantai
    Route::get('floor/{id}', 'CamerController@unit_per_floor');

    // Get detail camer unit per lantai
    Route::get('floor/{id}/{unit}', 'CamerController@camer_unit');

    Route::post('floor/{id}/{unit}', 'CamerController@store');

    // Get semua unit
    Route::get('unit', 'CamerController@all_unit');

    Route::get('camer', 'CamerController@camer');
});
