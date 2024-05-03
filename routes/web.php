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
Route::get('/shipping/instructionPrint/{sihId}'                   , "App\Http\Controllers\api\ShippingController@instructionPrint");
Route::get('/shipping/slipPrint/{sihId}'                          , "App\Http\Controllers\api\ShippingController@slipPrint");

Route::get('/qrPrint/{printResultID}'								, "App\Http\Controllers\api\QrprintController@qrPrint");
Route::get('/pdfPrint/{pdfName}'                                    , "App\Http\Controllers\api\QrprintController@pdfPrint");

Route::get('/401', 'App\Http\Controllers\PagesController@error401');
Route::get('/{any}', 'App\Http\Controllers\PagesController@index')->where('any', '.*');
