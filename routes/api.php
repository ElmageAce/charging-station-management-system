<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['as' => 'api.', 'namespace' => 'Api'], function () {
    Route::group(['prefix' => 'company', 'as' => 'company.', 'namespace' => 'Company'], function () {
        Route::apiResource('', 'CompanyController', ['parameters' => ['' => 'company']]);
        Route::group(['prefix' => '{company}'], function () {
            Route::apiResource('station', 'StationController', ['only' => 'index']);
            Route::apiResource('sub-companies', 'SubCompanyController', ['only' => 'index', 'parameters' => ['sub-companies' => 'subCompanies']]);
        });
    });

    Route::group(['prefix' => 'station', 'as' => 'station.', 'namespace' => 'Station'], function () {
        Route::apiResource('', 'StationController', ['parameters' => ['' => 'station']]);
        Route::get('index-within-radius/{latitude}/{longitude}/{radius?}', 'StationController@indexWithinRadius')->name('index-within-radius');
    });
});
