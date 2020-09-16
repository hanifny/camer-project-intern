<?php

use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

Route::post('login', 'AuthController@login');
Route::post('refresh', 'AuthController@refresh');

Route::middleware('auth:api')->group(function () {
    // {{ AUTH }} \\
    // Get user info
    Route::post('me', 'AuthController@me');
    // Logout user from application
    Route::post('logout', 'AuthController@logout');

    //  {{ UNIT }}  \\
    // Get lantai
    Route::get('floor', 'UnitController@floor');
    // Get nama unit per lantai
    Route::get('floor/{id}', 'UnitController@unit_per_floor');
    // Get semua unit
    Route::get('unit', 'UnitController@all_unit');
    // Get tipe
    Route::get('type', 'UnitController@all_type');
    // Store unit baru
    Route::post('unit', 'UnitController@store');

    // {{ CAMER }} \\
    // store camer
    Route::post('floor/{id}/{unit}', 'CamerController@store');
    // get camer
    Route::get('camer', 'CamerController@all');
    // get camer per month
    Route::get('camer/{month_year}', 'CamerController@camer_per_month');    
    // validasi
    Route::patch('camer', 'CamerController@validation');
    // validasi semua perbulan
    Route::patch('camer_per_month', 'CamerController@validation_per_month');
});
