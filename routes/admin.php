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

Route::group(['prefix' => 'document', 'as' => 'document.'], function() {
    Route::get('download/{id}', 'DocumentController@download')->name('download');
});

Route::group(['middleware' => ['token:access']], function() {

    Route::group(['prefix' => 'region', 'as' => 'region.'], function() {
        Route::get('list', 'RegionController@list')->name('list');
        Route::post('add', 'RegionController@add')->name('add');
        Route::get('item/{id}', 'RegionController@item')->name('item');
        Route::put('item/{id}', 'RegionController@edit')->name('edit');
        Route::delete('item/{id}', 'RegionController@delete')->name('delete');
    });

    Route::group(['prefix' => 'district', 'as' => 'district.'], function() {
        Route::get('list', 'DistrictController@list')->name('list');
        /*Route::post('add', 'RegionController@add')->name('add');
        Route::get('item/{id}', 'RegionController@item')->name('item');
        Route::put('item/{id}', 'RegionController@edit')->name('edit');
        Route::delete('item/{id}', 'RegionController@delete')->name('delete');*/
    });

    Route::group(['prefix' => 'goodsCategory', 'as' => 'goodsCategory.'], function() {
        Route::get('list', 'CategoryController@list')->name('list');
        /*Route::post('add', 'CategoryController@add')->name('add');
        Route::get('item/{id}', 'CategoryController@item')->name('item');
        Route::put('item/{id}', 'CategoryController@edit')->name('edit');
        Route::delete('item/{id}', 'CategoryController@delete')->name('delete');*/
    });

    Route::group(['prefix' => 'goods', 'as' => 'goods.'], function() {
        Route::get('list', 'GoodsController@list')->name('list');
        /*Route::post('add', 'GoodsController@add')->name('add');
        Route::get('item/{id}', 'GoodsController@item')->name('item');
        Route::put('item/{id}', 'GoodsController@edit')->name('edit');
        Route::delete('item/{id}', 'GoodsController@delete')->name('delete');*/
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

    Route::group(['prefix' => 'defect', 'as' => 'defect.'], function() {
        Route::get('list', 'DefectController@list')->name('list');
        Route::put('change-field', 'DefectController@changeField')->name('change-field');
        Route::put('add-record', 'DefectController@addRecord')->name('add-record');
        /*Route::post('add', 'UserController@add')->name('add');
        Route::get('item/{id}', 'UserController@item')->name('item');
        Route::put('item/{id}', 'UserController@edit')->name('edit');
        Route::delete('item/{id}', 'UserController@delete')->name('delete');

        Route::get('params', 'UserController@params')->name('params');*/
    });

    Route::group(['prefix' => 'progressrate', 'as' => 'progressrate.'], function() {
        Route::get('list', 'ProgressRateController@list')->name('list');
        Route::get('detail', 'ProgressRateController@detail')->name('detail');
        Route::put('change-field', 'ProgressRateController@changeField')->name('change-field');

        Route::get('check-list', 'ProgressRateController@checkList')->name('check-list');
        Route::put('change-field-check-list', 'ProgressRateController@changeFieldCheckList')->name('change-field-check-list');

        Route::put('add-record', 'ProgressRateController@addRecord')->name('add-record');
        Route::put('add-record-check-list', 'ProgressRateController@addRecordCheckList')->name('add-record-check-list');
        /*Route::post('add', 'UserController@add')->name('add');
        Route::get('item/{id}', 'UserController@item')->name('item');
        Route::put('item/{id}', 'UserController@edit')->name('edit');
        Route::delete('item/{id}', 'UserController@delete')->name('delete');

        Route::get('params', 'UserController@params')->name('params');*/
    });

    Route::group(['prefix' => 'stock', 'as' => 'stock.'], function() {
        Route::get('list', 'StockController@list')->name('list');
        Route::get('detail/{id}', 'StockController@details')->name('detail');
        Route::put('change-field', 'StockController@changeField')->name('change-field');
        Route::put('change-column', 'StockController@changeColumn')->name('change-column');
        Route::put('add-record', 'StockController@addRecord')->name('add-record');

        /*Route::get('check-list', 'ProgressRateController@checkList')->name('check-list');
        Route::put('change-field-check-list', 'ProgressRateController@changeFieldCheckList')->name('change-field-check-list');*/
    });

    Route::group(['prefix' => 'shipment-progress', 'as' => 'shipment-progress.'], function() {
        Route::get('list/{id?}', 'ShipmentProgressController@list')->name('list');
        Route::put('change-field', 'ShipmentProgressController@changeField')->name('change-field');
        Route::put('change-column', 'ShipmentProgressController@changeColumn')->name('change-column');
        Route::put('add-record', 'ShipmentProgressController@addRecord')->name('add-record');

        //Route::get('detail/{id}', 'StockController@details')->name('detail');
        /*Route::get('check-list', 'ProgressRateController@checkList')->name('check-list');
        Route::put('change-field-check-list', 'ProgressRateController@changeFieldCheckList')->name('change-field-check-list');*/
    });

    Route::group(['prefix' => 'import', 'as' => 'import.'], function() {
        Route::post('defect', 'ImportController@defect')->name('defect');
        Route::post('progressrate', 'ImportController@progressRate')->name('progressrate');
        Route::post('stock', 'ImportController@stock')->name('stock');
        Route::post('shipment-progress', 'ImportController@shipmentProgress')->name('shipment-progress');
    });

    Route::group(['prefix' => 'document', 'as' => 'document.'], function() {
        Route::get('list/{id}', 'DocumentController@list')->name('list');
        Route::post('add/{id}', 'DocumentController@uploadFile')->name('upload');
        Route::delete('item/{id}', 'DocumentController@deleteFile')->name('delete');
        //Route::get('download/{id}', 'DocumentController@download')->name('download');

        Route::get('params', 'DocumentController@params')->name('params');

        Route::post('add-region/{id}', 'DocumentController@addRegion')->name('add-region');
        Route::post('add-district/{id}', 'DocumentController@addDistrict')->name('add-district');
        Route::delete('delete-region/{id}', 'DocumentController@removeRegion')->name('delete-region');
        Route::delete('delete-district/{id}', 'DocumentController@removeDistrict')->name('delete-district');

        Route::put('rename-region/{id}', 'DocumentController@renameRegion')->name('rename-region');
        Route::put('rename-district/{id}', 'DocumentController@renameDistrict')->name('rename-district');
    });
});
