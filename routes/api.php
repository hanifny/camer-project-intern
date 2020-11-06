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
        // GET User
        Route::get('user', 'UserController@all');
        // POST User
        Route::post('user', 'UserController@store');
        // Edit Password
        Route::patch('user', 'UserController@changePassword');
        Route::put('user', 'UserController@update');
        Route::delete('user/{id}', 'UserController@destroy');

        //  {{ UNIT }}  \\
        // Get lantai
        // Route::get('floor', 'UnitController@floor');
        // Get unit per lantai
        Route::get('unit/{floor}', 'UnitController@unit_per_floor');
        // Get semua unit
        Route::get('unit', 'UnitController@all_unit');
        // Get unit per tower
        Route::get('unit/tower/{tower}', 'UnitController@tower');


        // Get lantai by tower
        Route::get('apt/{tower}', 'UnitController@floorByTower');
        // Get unit by tower and lantai
        Route::get('apt/{tower}/{floor}', 'UnitController@unitByFloorTower');

        // Get tipe
        Route::get('type', 'UnitController@all_type');
        // Store unit baru
        Route::post('unit', [
            'uses' => 'UnitController@store',
            'roles' => ['Admin', 'SuperAdmin']
        ]);
        // Update unit baru
        Route::put('unit', [
            'uses' => 'UnitController@update',
            'roles' => ['Admin', 'SuperAdmin']
        ]);
        Route::delete('unit/{id}', [
            'uses' => 'UnitController@destroy',
            'roles' => ['Admin', 'SuperAdmin']
        ]);

        // {{ CAMER }} \\
        // export 
        Route::get('camer/export/', [
            'uses' => 'CamerController@export',
            'roles' => ['Admin', 'SuperAdmin']
        ]);
        // store camer
        Route::post('floor/{id}/{unit_id}', [
            'uses' => 'CamerController@store',
            'roles' => ['Engineer']
        ]);
        // get camer
        Route::get('camer', 'CamerController@all');
        // get camer
        Route::get('camer/{month_year}/{tower}', 'CamerController@camer_per_tower');
        // get camer per month
        Route::get('camer/{month_year}', 'CamerController@camer_per_month');   
        // get camer last month
        Route::get('camer-last-month/{unit_id}', 'CamerController@camer_last_month'); 
        // validasi
        Route::patch('camer', [
            'uses' => 'CamerController@validation',
            'roles' => ['Admin', 'SuperAdmin']
        ]);
        // validasi semua perbulan
        Route::patch('camer_per_month', [
            'uses' => 'CamerController@validation_per_month',
            'roles' => ['Admin', 'SuperAdmin']
        ]);
        // Get count data
        Route::get('count', 'CamerController@count');
        // Get all unit where camer is invalid
        Route::get('invalid', 'CamerController@invalid'); 
        // Resend camer invalid
        Route::post('invalid', 'CamerController@update');
});