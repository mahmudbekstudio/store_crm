<?php
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Ajax routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "admin" middleware group. Enjoy building your Ajax!
|
*/

Route::post('auth/login', 'AuthController@login')->name('login');
Route::post('auth/reset-password', 'AuthController@resetPassword')->name('reset-password');
Route::post('auth/register', 'AuthController@register')->name('register');

Route::group(['middleware' => 'token:refresh'], function() {
    Route::get('auth/refresh', 'AuthController@refresh')->name('refresh');
});

Route::group(['middleware' => ['token:access']], function() {
    Route::post('check-access', 'MainController@success')->name('check-access');
    Route::post('logout', 'AuthController@logout')->name('logout');
    Route::any('website', 'MainController@settings')->name('website');
});

Route::group(['middleware' => ['token:access.' . \App\Models\User::ROLE_ADMIN]], function() {

    Route::group(['prefix' => 'region', 'as' => 'region.'], function() {
        Route::get('list', 'RegionController@list')->name('list');
        Route::post('add', 'RegionController@add')->name('add');
        Route::get('item/{id}', 'RegionController@item')->name('item');
        Route::put('item/{id}', 'RegionController@edit')->name('edit');
        Route::delete('item/{id}', 'RegionController@delete')->name('delete');
    });

    Route::group(['prefix' => 'goods', 'as' => 'goods.'], function() {
        Route::get('list', 'GoodsController@list')->name('list');
        Route::post('add', 'GoodsController@add')->name('add');
        Route::get('item/{id}', 'GoodsController@item')->name('item');
        Route::put('item/{id}', 'GoodsController@edit')->name('edit');
        Route::delete('item/{id}', 'GoodsController@delete')->name('delete');
    });

    Route::group(['prefix' => 'school', 'as' => 'school.'], function() {
        Route::get('list', 'SchoolController@list')->name('list');
        Route::post('add', 'SchoolController@add')->name('add');
        Route::get('item/{id}', 'SchoolController@item')->name('item');
        Route::put('item/{id}', 'SchoolController@edit')->name('edit');
        Route::delete('item/{id}', 'SchoolController@delete')->name('delete');
    });

    Route::group(['prefix' => 'user', 'as' => 'user.'], function() {
        Route::get('list', 'UserController@list')->name('list');
        Route::post('add', 'UserController@add')->name('add');
        Route::get('item/{id}', 'UserController@item')->name('item');
        Route::put('item/{id}', 'UserController@edit')->name('edit');
        Route::delete('item/{id}', 'UserController@delete')->name('delete');

        Route::get('params', 'UserController@params')->name('params');
    });
});
