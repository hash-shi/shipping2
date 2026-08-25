<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//印刷系統
Route::get('/shipping/detail/instructions/{sihId}'                  , "App\Http\Controllers\api\ShippingController@instructionPrint");
// Route::get('/shipping/detail/slip/{sihId}'                          , "App\Http\Controllers\api\ShippingController@slipPrint");
Route::get('/shipping/detail/slip/{sihId}'                          , "App\Http\Controllers\api\ShippingController@slipPrint2");

Route::get('/qrPrint/{printResultID}'                               , "App\Http\Controllers\api\QrprintController@qrPrint");

Route::get('/401', 'App\Http\Controllers\PagesController@error401');
Route::get('/{any}', 'App\Http\Controllers\PagesController@index')->where('any', '.*');
