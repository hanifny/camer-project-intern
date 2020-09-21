<?php

use Illuminate\Support\Facades\Route;

Route::post('login', 'AuthController@login');
Route::post('refresh', 'AuthController@refresh');
Route::group(['middleware' => ['auth:api', 'roles']], function() {
        // {{ AUTH }} \\
        // Get user info
        Route::post('me', 'AuthController@me');
        // Logout user from application
        Route::post('logout', 'AuthController@logout');
        // GET TEKNISI
        Route::get('engineer', 'UserController@all');
        // POST TEKNISI
        Route::post('engineer', 'UserController@store');
        // Edit Password
        Route::put('user', 'UserController@changePassword');

        //  {{ UNIT }}  \\
        // Get all unit where camer is invalid
        Route::get('invalid', 'UnitController@invalid'); 
        // Get lantai
        Route::get('floor', 'UnitController@floor');
        // Get nama unit per lantai
        Route::get('floor/{id}', 'UnitController@unit_per_floor');
        // Get semua unit
        Route::get('unit', 'UnitController@all_unit');
        // Get tipe
        Route::get('type', 'UnitController@all_type');
        // Store unit baru
        Route::post('unit', [
            'uses' => 'UnitController@store',
            'roles' => ['Admin']
        ]);
        // Update unit baru
        Route::put('unit', [
            'uses' => 'UnitController@update',
            'roles' => ['Admin']
        ]);
        Route::delete('unit/{id}', [
            'uses' => 'UnitController@destroy',
            'roles' => ['Admin']
        ]);

        // {{ CAMER }} \\
        // export 
        Route::get('camer/export/', [
            'uses' => 'CamerController@export',
            'roles' => ['Admin']
        ]);
        // store camer
        Route::post('floor/{id}/{unit_id}', [
            'uses' => 'CamerController@store',
            'roles' => ['Engineer']
        ]);
        // get camer
        Route::get('camer', 'CamerController@all');
        // get camer per month
        Route::get('camer/{month_year}', 'CamerController@camer_per_month');    
        // validasi
        Route::patch('camer', [
            'uses' => 'CamerController@validation',
            'roles' => ['Admin']
        ]);
        // validasi semua perbulan
        Route::patch('camer_per_month', [
            'uses' => 'CamerController@validation_per_month',
            'roles' => ['Admin']
        ]);
        // Get count data
        Route::get('count', 'CamerController@count');
        // Resend camer invalid
        Route::post('invalid', 'CamerController@update');
});