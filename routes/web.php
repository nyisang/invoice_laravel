<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
Route::get('/', function () {
    return view('welcome');
});

Route::get('signuppage', 'App\Http\Controllers\HomeController@signuppage')->name('signuppage');

Route::post('store_users', 'App\Http\Controllers\HomeController@store_users');

Route::post('logininvoice', 'App\Http\Controllers\HomeController@logininvoice');
Route::get('dashboard', 'App\Http\Controllers\HomeController@dashboard')->name('dashboard');


///MPESA C2B INTERGRATION 
Route::get('mpesa_password', 'App\Http\Controllers\HomeController@lipaNaMpesaPassword');
Route::post('mpesa_accesstoken', 'App\Http\Controllers\HomeController@newAccessToken');
Route::post('store_invoicepayments', 'App\Http\Controllers\HomeController@stkPush');
Route::post('mpesa_callback_url', 'App\Http\Controllers\HomeController@MpesaRes');