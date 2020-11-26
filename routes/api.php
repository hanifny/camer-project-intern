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
            'uses' => 'MeterRecordController@export',
            'roles' => ['Admin', 'SuperAdmin']
        ]);
        // store camer
        Route::post('camer', [
            'uses' => 'MeterRecordController@store',
            'roles' => ['Engineer']
        ]);
        // get camer
        Route::get('camer/{type}/{month_year}/{tower}', 'MeterRecordController@getCamer');
        // get camer per month by type and month
        Route::get('camer/{type}/{month_year}', 'MeterRecordController@camer_per_month');   
        // get camer last month
        Route::get('camer-last-month/{type}/{unit_id}', 'MeterRecordController@camer_last_month'); 
        // validasi
        Route::patch('camer', [
            'uses' => 'MeterRecordController@validation',
            'roles' => ['Admin', 'SuperAdmin']
        ]);
        // Get count data
        Route::get('count', 'MeterRecordController@count');
        // Get all unit where camer is invalid
        Route::get('invalid', 'MeterRecordController@invalid'); 
        // Resend camer that invalid
        Route::post('invalid', 'MeterRecordController@update');
});