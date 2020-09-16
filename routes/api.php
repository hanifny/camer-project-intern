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
        //GET TEKNISI
        Route::get('engineer', [
            'uses' => 'CamerController@get_engineer',
            'roles' => ['Admin']
        ]);

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
        Route::post('unit', [
            'uses' => 'UnitController@store',
            'roles' => ['Admin']
        ]);

        // {{ CAMER }} \\
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
});