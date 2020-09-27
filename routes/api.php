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
        // Get all unit where camer is invalid
        Route::get('invalid', 'UnitController@invalid'); 
        // Get lantai
        Route::get('floor', 'UnitController@floor');
        // Get nama unit per lantai
        Route::get('floor/{id}', 'UnitController@unit_per_floor');
        // Get semua unit
        Route::get('unit', 'UnitController@all_unit');
        // Get unit per tower
        Route::get('unit/tower/{tower}', 'UnitController@tower');
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
        // Resend camer invalid
        Route::post('invalid', 'CamerController@update');

        // Chat
        Route::get('messages', 'ChatsController@fetchMessages');
        Route::post('messages', 'ChatsController@sendMessage');

        Route::post('payment/store', 'PaymentController@store'); 
});