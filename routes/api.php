<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', 'App\Http\Controllers\Api\AuthController@login');
Route::group(['middleware' => ['apiJwt']], function(){
    Route::apiResource('products', 'App\Http\Controllers\Api\ProductController');
    Route::apiResource('customers', 'App\Http\Controllers\Api\CustomerController');
    Route::apiResource('providers', 'App\Http\Controllers\Api\ProviderController');
    Route::apiResource('sales', 'App\Http\Controllers\Api\SaleController');
});

