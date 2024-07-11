<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('login', 'App\Http\Controllers\HomeAPIController@loginApi');

Route::post('userregistration', 'App\Http\Controllers\HomeAPIController@store_users_APIs');
  
  Route::post('createinvoice', 'App\Http\Controllers\HomeAPIController@store_invoiceproducts_APIs');
  
    Route::post('invoice_grandtotal', 'App\Http\Controllers\HomeAPIController@store_invoicegrandtotal_APIs');
  
  
  Route::get('productsINVOICE', 'App\Http\Controllers\HomeAPIController@productsoninvoice_sales');
  
   Route::get('PAYINVOICE', 'App\Http\Controllers\HomeAPIController@getinvoice_topay');
  //get messages 

Route::get('fetchalltransactions', 'App\Http\Controllers\HomeAPIController@alltransactionapi');
  


///MPESA C2B INTERGRATION 
Route::get('mpesa_password', 'App\Http\Controllers\HomeAPIController@lipaNaMpesaPassword');
Route::post('mpesa_accesstoken', 'App\Http\Controllers\HomeAPIController@newAccessToken');
Route::post('store_invoicepayments', 'App\Http\Controllers\HomeAPIController@stkPush');
Route::post('mpesa_callback_url', 'App\Http\Controllers\HomeAPIController@MpesaRes');