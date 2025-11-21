<?php

use Illuminate\Http\Request;
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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

// SSO
Route::get('sso/{userCode}'                                     , "App\Http\Controllers\api\CommonController@getSSO");
// コンフィグ
Route::get('config'                                             , "App\Http\Controllers\api\CommonController@getConfig");
// 当日
Route::get('today'                                              , "App\Http\Controllers\api\CommonController@getToday");
// 受注番号
Route::get('orderNo'                                            , "App\Http\Controllers\api\CommonController@getOrderNo");
Route::get('adjustNo'                                           , "App\Http\Controllers\api\CommonController@getAdjustNo");

// 

// 出荷指示関連
// index
Route::get('shipping'                                           , "App\Http\Controllers\api\ShippingController@init");
Route::post('shipping/shipDate'                                 , "App\Http\Controllers\api\ShippingController@shipDate");
Route::post('shipping/search'                                   , "App\Http\Controllers\api\ShippingController@search");
Route::post('shipping/update'                                   , "App\Http\Controllers\api\ShippingController@update");
Route::post('shipping/exis'                                     , "App\Http\Controllers\api\ShippingController@exis");

// 詳細画面関係
// Detail
Route::get('shipping/detail/{sihId}'                                                      , "App\Http\Controllers\api\ShippingController@fix");
Route::get('shipping/detail/{sihId}/{orderNo}/{hCode}/{shipDate}/{userCode}'              , "App\Http\Controllers\api\ShippingController@new");
Route::get('shipping/detail/{sihId}/{orderNo}/{hCode}/{shipDate}/{userCode}/{orderNoBase}', "App\Http\Controllers\api\ShippingController@copy");

Route::post('shipping/detail/masters'                           , "App\Http\Controllers\api\ShippingController@getDetail");

Route::post('shipping/detail/susp'                              , "App\Http\Controllers\api\ShippingController@susp");
Route::post('shipping/detail/conf'                              , "App\Http\Controllers\api\ShippingController@conf");
Route::post('shipping/detail/comp'                              , "App\Http\Controllers\api\ShippingController@comp");
Route::post('shipping/detail/inst'                              , "App\Http\Controllers\api\ShippingController@inst");
Route::post('shipping/detail/slip'                              , "App\Http\Controllers\api\ShippingController@slip");
Route::delete('shipping'                                        , "App\Http\Controllers\api\ShippingController@del");

Route::post('shipping/detail/susp_'                             , "App\Http\Controllers\api\ShippingController@susp_");
Route::post('shipping/detail/conf_'                             , "App\Http\Controllers\api\ShippingController@conf_");

// マスタ取得
Route::post('master/customers'                                   , "App\Http\Controllers\api\MasterController@getCustomers");
Route::post('master/deliveries'                                  , "App\Http\Controllers\api\MasterController@getDeliveries");
Route::post('master/drivers'                                     , "App\Http\Controllers\api\MasterController@getDrivers");
Route::post('master/hcodesH'                                     , "App\Http\Controllers\api\MasterController@getHCodesH");
Route::post('master/hcodesD'                                     , "App\Http\Controllers\api\MasterController@getHCodesD");
Route::post('master/items'                                       , "App\Http\Controllers\api\MasterController@getItems");
Route::post('master/offices'                                     , "App\Http\Controllers\api\MasterController@getOffices");
Route::post('master/places'                                      , "App\Http\Controllers\api\MasterController@getPlaces");
Route::post('master/remarks'                                     , "App\Http\Controllers\api\MasterController@getRemarks");
Route::post('master/suppliers'                                   , "App\Http\Controllers\api\MasterController@getSuppliers");
// Route::post('master/truckers'                                  , "App\Http\Controllers\api\MasterController@getTruckers");
Route::post('master/users'                                       , "App\Http\Controllers\api\MasterController@getUsers");
Route::post('master/warehouses'                                  , "App\Http\Controllers\api\MasterController@getWarehouses");
// 名称返却検索
Route::post('master/getCustomerName'                             , "App\Http\Controllers\api\MasterController@getCustomerName");
Route::post('master/getDeliverieName'                            , "App\Http\Controllers\api\MasterController@getDeliverieName");
Route::post('master/getDriverName'                               , "App\Http\Controllers\api\MasterController@getDriverName");
// Route::post('master/getHcodesHName'                              , "App\Http\Controllers\api\MasterController@getHcodesHName");
// Route::post('master/getHcodesDName'                              , "App\Http\Controllers\api\MasterController@getHcodesDName");
// Route::post('master/getItemName'                                 , "App\Http\Controllers\api\MasterController@getItemName");
Route::post('master/getOfficeName'                               , "App\Http\Controllers\api\MasterController@getOfficeName");
Route::post('master/getPlaceName'                                , "App\Http\Controllers\api\MasterController@getPlaceName");
// Route::post('master/getRemarkName'                               , "App\Http\Controllers\api\MasterController@getRemarkName");
Route::post('master/getSupplierName'                             , "App\Http\Controllers\api\MasterController@getSupplierName");
Route::post('master/getTruckerName'                              , "App\Http\Controllers\api\MasterController@getTruckerName");
// Route::post('master/getUserName'                                 , "App\Http\Controllers\api\MasterController@getUserName");
Route::post('master/getWarehouseName'                            , "App\Http\Controllers\api\MasterController@getWarehouseName");
// 特殊処理用検索
Route::post('master/getItemData'                                 , "App\Http\Controllers\api\MasterController@getItemData");
Route::post('master/getDriverTrucker'                            , "App\Http\Controllers\api\MasterController@getDriverTrucker");


//QRコード印刷
Route::get('qrPrint'                                       , "App\Http\Controllers\api\QrprintController@init");
Route::post('qrPrint/getSerialNumber'                      , "App\Http\Controllers\api\QrprintController@getSerialNumber");
Route::post('qrPrint/regist'                               , "App\Http\Controllers\api\QrprintController@regist");
Route::post('qrPrint/rePrint'                              , "App\Http\Controllers\api\QrprintController@rePrint");
Route::post('qrPrint/search'                               , "App\Http\Controllers\api\QrprintController@search");

Route::get('resetSession'                                  , "App\Http\Controllers\api\QrprintController@resetSession");