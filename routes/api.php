<?php

use Illuminate\Support\Facades\Route;

Route::post('login', 'AuthController@login');
Route::post('refresh', 'AuthController@refresh');
Route::group(['middleware' => ['auth:api', 'roles']], function() {
        Route::post('import_excel', 'UnitController@import_excel');

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
        Route::get('unit/{floor}', 'UnitController@unitPerFloor');
        // Get semua unit
        Route::get('unit', 'UnitController@allUnit');
        // Get unit per tower
        Route::get('unit/tower/{tower}', 'UnitController@tower');
        // Get lantai by tower
        Route::get('apt/{tower}', 'UnitController@floorByTower');
        // Get unit by tower and lantai
        Route::get('apt/{tower}/{floor}', 'UnitController@unitByFloorTower');
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
        Route::post('camer', 'MeterRecordController@store');
        // get camer
        Route::get('camer/{type}/{month_year}/{tower}', 'MeterRecordController@getCamer');
        // get camer per month by type and month
        Route::get('camer/{type}/{month_year}', 'MeterRecordController@camerPerMonth');   
        // get camer last month
        Route::get('camer-last-month/{type}/{unit_id}', 'MeterRecordController@camerLastMonth'); 
        // validasi
        Route::patch('camer', [
            'uses' => 'MeterRecordController@validation',
            'roles' => ['Admin', 'SuperAdmin']
        ]);
        // Get all unit where camer is invalid
        Route::get('invalid', 'MeterRecordController@invalid'); 
        // Resend camer that invalid
        Route::post('invalid', 'MeterRecordController@update');

        // Get count data
        Route::get('count', 'MeterRecordController@count');

        // Konteks ANDROID
        Route::get('context', 'ContextController');
});