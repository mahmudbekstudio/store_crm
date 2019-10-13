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

Route::post('auth/login', 'AuthController@login')->name('admin.login');
Route::post('auth/reset-password', 'AuthController@resetPassword')->name('admin.reset-password');
Route::post('auth/register', 'AuthController@register')->name('admin.register');

Route::group(['middleware' => 'token:refresh'], function() {
    Route::get('auth/refresh', 'AuthController@refresh')->name('admin.refresh');
});

Route::group(['middleware' => ['token:access']], function() {
    Route::post('logout', 'AuthController@logout')->name('admin.logout');
    Route::any('website', 'MainController@settings')->name('admin.website');
});

Route::group(['middleware' => ['token:access.' . \App\Models\User::ROLE_ADMIN]], function() {
    Route::post('check-access', 'MainController@success')->name('admin.check-access');
});
