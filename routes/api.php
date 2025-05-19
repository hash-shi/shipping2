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
Route::get('sso/{userCode}'                                     , "App\Http\Controllers\api\MasterController@getSSO");

// コンフィグ
Route::get('config'                                             , "App\Http\Controllers\api\MasterController@getConfig");

// 当日
Route::get('today'                                              , "App\Http\Controllers\api\MasterController@getToday");

// マスタ取得
Route::get('orderNo'                                            , "App\Http\Controllers\api\MasterController@getOrderNo");

Route::get('master/users'                                        , "App\Http\Controllers\api\MasterController@getUsers");
Route::post('master/customers'                                   , "App\Http\Controllers\api\MasterController@getCustomers");
Route::post('master/deliveries'                                  , "App\Http\Controllers\api\MasterController@getDeliveries");
Route::post('master/suppliers'                                   , "App\Http\Controllers\api\MasterController@getSuppliers");
Route::post('master/warehouses'                                  , "App\Http\Controllers\api\MasterController@getWarehouses");
Route::post('master/drivers'                                     , "App\Http\Controllers\api\MasterController@getDrivers");
Route::post('master/hcodesH'                                     , "App\Http\Controllers\api\MasterController@getHCodesH");
Route::post('master/hcodesD'                                     , "App\Http\Controllers\api\MasterController@getHCodesD");
Route::post('master/places'                                      , "App\Http\Controllers\api\MasterController@getPlaces");
Route::post('master/remarks'                                     , "App\Http\Controllers\api\MasterController@getRemarks");
Route::post('master/items'                                       , "App\Http\Controllers\api\MasterController@getItems");
Route::post('master/detail'                                      , "App\Http\Controllers\api\MasterController@getDetail");
Route::post('master/offices'                                     , "App\Http\Controllers\api\MasterController@getOffices");

Route::post('master/getOfficeName'                               , "App\Http\Controllers\api\master\MasterController@getOfficeName");
Route::post('master/getCustomerName'                             , "App\Http\Controllers\api\master\MasterController@getCustomerName");
Route::post('master/getDeliverieName'                            , "App\Http\Controllers\api\master\MasterController@getDeliverieName");
Route::post('master/getSupplierName'                             , "App\Http\Controllers\api\master\MasterController@getSupplierName");
Route::post('master/getWarehouseName'                            , "App\Http\Controllers\api\master\MasterController@getWarehouseName");
Route::post('master/getTruckerName'                              , "App\Http\Controllers\api\master\MasterController@getTruckerName");
Route::post('master/getDriverName'                               , "App\Http\Controllers\api\master\MasterController@getDriverName");
Route::post('master/getPlaceName'                                , "App\Http\Controllers\api\master\MasterController@getPlaceName");

Route::post('master/getDriverTrucker'                            , "App\Http\Controllers\api\master\MasterController@getDriverTrucker");
Route::post('master/getItemData'                                 , "App\Http\Controllers\api\master\MasterController@getItemData");

// 出荷指示検索
Route::get('shippingSearchInit'                                 , "App\Http\Controllers\api\ShippingController@searchInit");
Route::post('shippingSearchDateInfo'                            , "App\Http\Controllers\api\ShippingController@searchDateInfo");
Route::post('shippingSearch'                                    , "App\Http\Controllers\api\ShippingController@search");
Route::post('shipping/update'                                   , "App\Http\Controllers\api\ShippingController@update");

// 出荷指示登録更新削除
Route::get('shippingDetail/{sihId}'                                                      , "App\Http\Controllers\api\ShippingController@fix");
Route::get('shippingDetail/{sihId}/{orderNo}/{hCode}/{shipDate}/{userCode}'              , "App\Http\Controllers\api\ShippingController@new");
Route::get('shippingDetail/{sihId}/{orderNo}/{hCode}/{shipDate}/{userCode}/{orderNoBase}', "App\Http\Controllers\api\ShippingController@copy");

// Route::post('shipping/exis'                                     , "App\Http\Controllers\api\ShippingController@exis");
// Route::post('shipping/regist'                                   , "App\Http\Controllers\api\ShippingController@regist");
// Route::post('shipping/copy'                                     , "App\Http\Controllers\api\ShippingController@copy");
Route::post('shipping/susp'                                     , "App\Http\Controllers\api\ShippingController@susp");
Route::post('shipping/conf'                                     , "App\Http\Controllers\api\ShippingController@conf");
Route::post('shipping/comp'                                     , "App\Http\Controllers\api\ShippingController@comp");
Route::post('shipping/inst'                                     , "App\Http\Controllers\api\ShippingController@inst");
Route::post('shipping/vouc'                                     , "App\Http\Controllers\api\ShippingController@vouc");
Route::delete('shipping'                                        , "App\Http\Controllers\api\ShippingController@del");

// Route::post("deliveries"                                        , "App\Http\Controllers\api\ShippingController@getDeliveries");
// Route::post("itemsCustomer"                                     , "App\Http\Controllers\api\ShippingController@getItemsCustomer");
// Route::post("itemsSupplier"                                     , "App\Http\Controllers\api\ShippingController@getItemsSupplier");
// Route::get("shipping/updateConfirmCount/{orderNo}"              , "App\Http\Controllers\api\ShippingController@updateConfirmCount");

//QRコード印刷
Route::get('qrPrintInit'                                   , "App\Http\Controllers\api\QrprintController@qrPrintInit");
Route::post('getQrHistoryData'                             , "App\Http\Controllers\api\QrprintController@getQrHistoryData");
Route::post('serialNumberChange'                           , "App\Http\Controllers\api\QrprintController@serialNumberChange");

Route::post('qrPrint/regist'                               , "App\Http\Controllers\api\QrprintController@regist");
Route::post('qrPrint/rePrint'                              , "App\Http\Controllers\api\QrprintController@rePrint");

Route::post('qrPrint/search'                               , "App\Http\Controllers\api\QrprintController@search");

Route::get('resetSession'                                  , "App\Http\Controllers\api\QrprintController@resetSession");