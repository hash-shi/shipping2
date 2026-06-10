<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Libs\DBUtility;
use App\Libs\Masters;
use App\Http\Controllers\api\CommonController;
use App\Http\Controllers\api\MasterController;
use App\Models\configures;
use App\Models\deliveries;
use App\Models\status;
use App\Models\sih;
use App\Models\sid;
use App\Models\items;
use App\Models\itemsCustomer;
use App\Models\itemsSupplier;
use App\Models\itemsTransfer;
use milon\barcode;
use App\Libs\ProjectCommon;
use App\Models\hcodesH;
use mikehaertl\wkhtmlto\Pdf;
use DB;

class ShippingController extends Controller
{
  //-------------------------------------------------------------------------
  // 検索画面の初期検索条件等取得
  // 
  // 
  //-------------------------------------------------------------------------
  public function init(Request $request){

    //---------------------------------------------------------------------
    // 画面のリフレッシュ間隔の取得
    //---------------------------------------------------------------------
    $query = configures::query();
    $query->where('ID', 'SCREEN_REDRAW_INTERVAL');
    // 検索結果
    $screenRedrawInterval = $query->value('VALUE');

    //---------------------------------------------------------------------
    // 営業所コードの取得
    //---------------------------------------------------------------------
    $query = configures::query();
    $query->where('ID', 'OFFICE_CODE');
    // 検索結果
    $officeCode = $query->value('VALUE');
    
    //---------------------------------------------------------------------
    // 出荷日(From 一ヵ月前の一日、現在日付)
    //---------------------------------------------------------------------
    $searchShipDateFrom = date("Y-m-d", strtotime("first day of -36 month"));
    // $searchShipDateFrom = date("Y-m-d");
    $searchShipDateTo   = date("Y-m-d");

    //---------------------------------------------------------------------
    // 進捗一覧とそれぞれの存在件数と初期値
    //---------------------------------------------------------------------
    $searchStatus = array("1");
    $searchStatusList = $this->getStatusList($searchShipDateFrom, $searchShipDateTo);

    //---------------------------------------------------------------------
    // 受注No初期値(空)
    //---------------------------------------------------------------------
    $searchOrderNos = "";
    $orderNoList= $this->getOrderNoList($searchShipDateFrom, $searchShipDateTo);

    //---------------------------------------------------------------------
    // 運送便一覧
    //---------------------------------------------------------------------
    $searchFlights = "";
    $searchFlightsList = $this->getDriverList($searchShipDateFrom, $searchShipDateTo);

    //---------------------------------------------------------------------
    // 結果格納と返却
    //---------------------------------------------------------------------
    $result             = array(
      "searchShipDateFrom"    => $searchShipDateFrom,
      "searchShipDateTo"      => $searchShipDateTo,
      "searchStatus"          => $searchStatus,
      "searchStatusList"      => $searchStatusList,
      "searchOrderNos"        => $searchOrderNos,
      "searchFlights"         => $searchFlights,
      "searchFlightsList"     => $searchFlightsList,
      "orderNoList"           => $orderNoList,
      "screenRedrawInterval"  => $screenRedrawInterval,
      "officeCode"            => $officeCode,
    );
    return $result;
  }

  //-------------------------------------------------------------------------
  // 当日の検索条件を返却
  // 
  // 
  //-------------------------------------------------------------------------
  public function shipDate(Request $request){

    $shipDateFrom       = $request->input("shipDateFrom");
    $shipDateTo         = $request->input("shipDateTo");

    //---------------------------------------------------------------------
    // Status毎の件数を返却
    //---------------------------------------------------------------------
    $searchStatusList = $this->getStatusList($shipDateFrom, $shipDateTo);

    //---------------------------------------------------------------------
    // 対象日のドライバリストの作成
    //---------------------------------------------------------------------
    $flightsList = $this->getDriverList($shipDateFrom, $shipDateTo);

    //---------------------------------------------------------------------
    // 対象日の受注NOリストの作成
    //---------------------------------------------------------------------
    $orderNoList= $this ->getOrderNoList($shipDateFrom, $shipDateTo);

    //---------------------------------------------------------------------
    // 結果返却
    //---------------------------------------------------------------------
    return array(
      "flightsList"       => $flightsList,
      "searchStatusList"  => $searchStatusList,
      "orderNoList"       => $orderNoList,
      "test"              => $shipDateTo,
    );
  }

   //-------------------------------------------------------------------------
  // 日付に基づく進捗一覧の取得
  // 
  // 
  //-------------------------------------------------------------------------
  private function getStatusList($dateFrom, $dateTo){

    $query = status::query();

    $query->leftJoinSub(function($queryS) use($dateFrom, $dateTo){
      $queryS->from('SIH');
      $queryS->selectRaw('STATUS');
      $queryS->selectRaw('COUNT(*) as count');

      if ($dateFrom != null && $dateFrom != "") {
        $queryS->where('SHIP_DATE', '>=', $dateFrom);
      }
      if ($dateTo != null && $dateTo != "") {
        $queryS->where('SHIP_DATE', '<=', $dateTo);
      }
      $queryS->groupBy('STATUS');
    }, 'SIH', function($join) {
      $join->on('STATUS.id', '=', 'SIH.STATUS');
    });

    $query->selectRaw('STATUS.id as status');
    $query->selectRaw('STATUS.name as label');
    $query->selectRaw('ISNULL(SIH.count,0) as count');
    $query->orderBy('STATUS.order');

    // 検索結果
    $orderNos = $query->get();
    // $orderNos = $query->toSql();
    // 返却
    return $orderNos;
  }

   //-------------------------------------------------------------------------
  // 日付に基づく受付番号一覧の取得
  // 
  // 
  //-------------------------------------------------------------------------
  private function getOrderNoList($dateFrom, $dateTo){

    $query = sih::query();

    if ($dateFrom != null && $dateFrom != "") {
      $query->where('SHIP_DATE', '>=', $dateFrom);
    }
    if ($dateTo != null && $dateTo != "") {
      $query->where('SHIP_DATE', '<=', $dateTo);
    }

    // 並び順
    $query->orderBy('ORDER_NO', 'asc');
    // カラム指定
    $query->select('ORDER_NO');
    // 検索結果
    $orderNos = $query->get();
    // 返却
    return $orderNos;
  }

  //-------------------------------------------------------------------------
  // 日付に基づくドライバー一覧の取得
  // 
  // 
  //-------------------------------------------------------------------------
  private function getDriverList($dateFrom, $dateTo){

    $query = sih::query();

    $query->whereNotNull('DRIVER_CODE');
    $query->whereNotNull('FLIGHTS');

    if ($dateFrom != null && $dateFrom != "") {
      $query->where('SHIP_DATE', '>=', $dateFrom);
    }
    if ($dateTo != null && $dateTo != "") {
      $query->where('SHIP_DATE', '<=', $dateTo);
    }

    // 並び順
    $query->orderBy('DRIVER_CODE', 'asc');
    // 重複なし
    $query->distinct();
    // カラム指定
    $query->select('DRIVER_CODE', 'DRIVER_NAME', 'FLIGHTS');
    // 検索結果
    $drivers = $query->get();
    // 返却
    return $drivers;
  }

  //-------------------------------------------------------------------------
  // 検索処理
  // 
  // 
  //-------------------------------------------------------------------------
  public function search(Request $request){

    //---------------------------------------------------------------------
    // 検索条件取得
    //---------------------------------------------------------------------
    $searchWarehouses   = $request->input("searchWarehouses");
    $searchShipDateFrom = $request->input("searchShipDateFrom");
    $searchShipDateTo   = $request->input("searchShipDateTo");
    $searchStatus       = $request->input("searchStatus");
    $searchOrderNos     = $request->input("searchOrderNos");
    $searchFlights      = $request->input("searchFlights");
    $searchCustomerCode = $request->input("searchCustomerCode");
    
    // 検索条件の組み立て
    $querySih = sih::query();
    $querySih->from('SIH as S');
    $querySih->leftJoin('SIH_RESULT as R', function($join) {
      $join->on('S.SIH_ID', '=', 'R.SIH_ID');
      // $join->on('S.ORDER_NO', '=', 'R.ORDER_NO');
    });
    $querySih->leftJoin('USERS as U', function($join) {
      $join->on('S.ORDER_USER', '=', 'U.CODE')->orWhere('S.ORDER2_USER', '=', 'U.CODE');
    });

    // 倉庫及び納入先
    if ($searchWarehouses != null && $searchWarehouses != ""){
      $querySih->where(function($warehouse) use($searchWarehouses){
        $warehouse->where('S.WAREHOUSE_CODE', $searchWarehouses)->orWhere('S.DELIVERY_CODE', $searchWarehouses);
      });
    }

    // 出荷日(from)
    if ($searchShipDateFrom != null && $searchShipDateFrom != ""){
      $querySih->where('S.SHIP_DATE', '>=', $searchShipDateFrom);
    }

    // 出荷日(to)
    if ($searchShipDateTo != null && $searchShipDateTo != ""){
      $querySih->where('S.SHIP_DATE', '<=', $searchShipDateTo);
    }

    // 進捗
    if ($searchStatus != null){
      // $searchStatus
      $querySih->whereIn('STATUS', $searchStatus);
    }

    // 受注No
    if ($searchOrderNos != null && $searchOrderNos != ""){
      $querySih->where('S.ORDER_NO', $searchOrderNos);
    }

    // 運送便
    if ($searchFlights != null && $searchFlights != ""){
      $driverCode = explode(":", $searchFlights)[0];
      $flights    = explode(":", $searchFlights)[1];
      $querySih->where('S.DRIVER_CODE', $driverCode);
      $querySih->where('S.FLIGHTS', $flights);
    }

    // 得意先
    if ($searchCustomerCode != null && $searchCustomerCode != ""){
      $querySih->where('S.CUSTOMER_CODE', $searchCustomerCode);
    }

    // 並び順
    $querySih->selectRaw('S.*');
    $querySih->orderBy('SIH_ID', 'desc');
    // $querySih->orderBy('ORDER_NO', 'desc');

    // var_dump($querySih->toSql());

    // 検索結果
    // $sihRecords = $querySih->get();
    $sihRecords = ProjectCommon::syncRelation('\App\Models\sih', ProjectCommon::getRelation('App\Models\sih', $querySih)->get());
    
    //---------------------------------------------------------------------
    // 結果格納と返却
    //---------------------------------------------------------------------
    $result = array(
      "sihRecords" => $sihRecords
    );
    return $result;
  }

  //-------------------------------------------------------------------------
  // レコードの存在確認
  // 
  // 
  //-------------------------------------------------------------------------
  public function exis(Request $request){
    // 受注Noを取得する
    $ORDER_NO = $request->input("ORDER_NO");
    // チェックそのものはvalidat側で行うので、ここでは何もしない。
    return sprintf('%06d', $ORDER_NO);
  }

  //-------------------------------------------------------------------------
  // 詳細レコードの取得
  // 新規・修正・複写、共通
  // 
  //-------------------------------------------------------------------------
  public function new(Request $request, $sihId, $orderNo, $hCode, $shipDate, $userCode){
    return $this->create($request, $sihId, $orderNo, $hCode, $shipDate, $userCode, "");
  }
  public function fix(Request $request, $sihId){
    return $this->create($request, $sihId, "", "", "", "", "");
  }
  public function copy(Request $request, $sihId, $orderNo, $hCode, $shipDate, $userCode, $sihIdBase){
    return $this->create($request, $sihId, $orderNo, $hCode, $shipDate, $userCode, $sihIdBase);
  }
  public function create(Request $request, $sihId, $orderNo, $hCode, $shipDate, $userCode, $sihIdBase){

    // 新規・更新フラグ
    $isNew      = true;

    // 営業所コード
    $officeCode = null;
    // 出荷指示ヘッダー
    $sihRecord = null;
    // 出荷指示明細
    $sidRecords = array();
    // 定数マスタ
    $common = new CommonController;

    $configures = $common->getConfig($request);
    // dump($configures);

    // 営業所コード
    $officeCode = $configures[array_search('OFFICE_CODE', array_column($configures, 'ID'))]['VALUE'];

    // 最新の受注No(在庫調整用)を取得
    $adjustNo = $configures[array_search('ADJUST_NO_NEXT', array_column($configures, 'ID'))]['VALUE'];
    // $adjustNo = $common->getAdjustNoMax($request);

    // SIHの用意
    $sihColumns = Schema::getColumnListing('sih');
    // SIDの用意
    $sidColumns = Schema::getColumnListing('sid');
    // ITEMSの用意
    $itemsColumns = ProjectCommon::DBTableColumn('ITEMS');
    $items_rel = null;
    foreach ($itemsColumns as $column) { $items_rel[$column['COLUMN_NAME']] = null; }
    // QCODESの用意
    $qcodesColumns = ProjectCommon::DBTableColumn('QCODES');
    $qcodes_rel = null;
    foreach ($qcodesColumns as $column) { $qcodes_rel[$column['COLUMN_NAME']] = null; }
    // HCODESDの用意
    $hcodesdColumns = ProjectCommon::DBTableColumn('HCODESD');
    $hcodesd_rel = null;
    foreach ($hcodesdColumns as $column) { $hcodesd_rel[$column['COLUMN_NAME']] = null; }

    // 存在確認
    if (sih::where('SIH_ID', $sihId)->exists()) {

      // 更新
      $isNew = false;
      // ヘッダー
      $sihRecord = ProjectCommon::syncRelation('\App\Models\sih', ProjectCommon::getRelation('App\Models\sih', sih::where('SIH_ID', $sihId))->first());
      // $sihRecord = ProjectCommon::syncRelation('\App\Models\sih', ProjectCommon::getRelation('App\Models\sih', sih::where('ORDER_NO', $orderNo))->first());

      // logger($sihRecord);

      if ($sihRecord['ORDER_TIME'] != null && $sihRecord['ORDER_TIME'] != "") {
        $sihRecord['ORDER_TIME'] = mb_substr($sihRecord['ORDER_TIME'], 0, 5);
      }
      if ($sihRecord['DELIVERY_TIME'] != null && $sihRecord['DELIVERY_TIME'] != "") {
        $sihRecord['DELIVERY_TIME'] = mb_substr($sihRecord['DELIVERY_TIME'], 0, 5);
      }

      // 明細
      // $sidRecords = ProjectCommon::getRelation('App\Models\sid', sid::where('SIH_ID', $sihId))->get();
      // $sidRecords = ProjectCommon::getRelation('App\Models\sid', sid::where('ORDER_NO', $orderNo))->get();
      $sidRecords = ProjectCommon::syncRelation('App\Models\sid', ProjectCommon::getRelation('App\Models\sid', sid::where('SIH_ID', $sihId))->get());
      // $sidRecords = ProjectCommon::syncRelation('App\Models\sid', ProjectCommon::getRelation('App\Models\sid', sid::where('ORDER_NO', $orderNo))->get());

      // 明細が8件ない場合、不足分を埋める。※本当はありえない処理にしたい
      if (count($sidRecords) < 8) {
        for ($i = count($sidRecords); $i < 8; $i++) {
          // 配列の作成
          $sidRecord = null;
          foreach ($sidColumns as $column) { $sidRecord[$column] = null;}
          $sidRecord['SIH_ID']        = $sihId;
          // $sidRecord['ORDER_NO']  = $orderNo;
          $sidRecord['RNO']           = ($i + 1);
          $sidRecord['items_rel']     = $items_rel;
          $sidRecord['qcodes_rel']    = $qcodes_rel;
          $sidRecord['QNAME']         = $qcodes_rel['NAME'];
          $sidRecord['hcodesd_rel']   = $hcodesd_rel;
          $sidRecord['SAMPLE']        = $hcodesd_rel['SAMPLE'];
          // 格納
          $sidRecords[] = $sidRecord;
        }
      }
      // ↓2026/03/31_hash-shi_融通変換対応------------------------------
      $hcode = $sihRecord['HCODE'];
      $officeCodeF = $sihRecord['OFFICE_OTHER_CODE'];
      $officeCodeT = $sihRecord['OFFICE_CODE'];
      if ($hcode == 4 || $hcode == 5 || $hcode == 6) {
        if ($officeCode != $sihRecord['OFFICE_CODE']) {
          for ($i = 0; $i < count($sidRecords); $i++) {
            $record = $sidRecords[$i];
            if ($record['ITEM_CODE'] != null && $record['ITEM_CODE'] != "") {
              $items = itemsTransfer::where('OFFICE_CODE_F', $officeCodeF)->where('OFFICE_CODE_T', $officeCodeT)->where('ITEM_CODE_T', $record['ITEM_CODE'])->get();
              foreach($items as $item) {
                $sidRecords[$i]['ITEM_CODE'] = $item['ITEM_CODE_F'];
              }
            }
          }
        }
      }
      // ↑2026/03/31_hash-shi_融通変換対応------------------------------
    } else {

      // 新規
      $isNew = true;

      // ヘッダー
      if ($sihIdBase !== "") {
        // 複写
        // 基となるレコードに上書き
        $sihRecord = ProjectCommon::syncRelation('\App\Models\sih', ProjectCommon::getRelation('App\Models\sih', sih::where('SIH_ID', $sihIdBase))->first());				// 基となるレコードに上書き
        // $sihRecord = ProjectCommon::syncRelation('\App\Models\sih', ProjectCommon::getRelation('App\Models\sih', sih::where('ORDER_NO', $orderNoBase))->first());

        // 個別の設定値
        // $sihRecord['DELIVERY_DATE'] = null;
        $sihRecord['LOADING_RATE']  = '1';
      } else {
        // 新規
        foreach ($sihColumns as $column) { $sihRecord[$column] = null;}
        // 個別の設定値
        // $sihRecord['DELIVERY_DATE'] = date('Y-m-d');
        $sihRecord['LOADING_RATE']  = '1';
      }

      // 共通する設定値
      $sihRecord['SIH_ID']            = $sihId;
      $sihRecord['ORDER_NO']          = $orderNo;
      $sihRecord['HCODE']             = $hCode;
      $sihRecord['HNAME']             = hcodesH::where('CODE', $hCode)->first()['NAME'];
      $sihRecord['OFFICE_CODE']       = $configures[array_search('OFFICE_CODE', array_column($configures, 'ID'))]['VALUE']; // 初期値として設定している営業所を格納
      $sihRecord['OFFICE_NAME']       = $configures[array_search('OFFICE_NAME', array_column($configures, 'ID'))]['VALUE'];
      $sihRecord['OFFICE_OTHER_CODE'] = null;
      $sihRecord['OFFICE_OTHER_NAME'] = null;
      $sihRecord['COMPANY_CODE']      = $configures[array_search('COMPANY_CODE', array_column($configures, 'ID'))]['VALUE'];
      $sihRecord['COMPANY_NAME']      = $configures[array_search('COMPANY_NAME', array_column($configures, 'ID'))]['VALUE'];
      $sihRecord['ORDER_DATE']        = null;
      $sihRecord['ORDER_TIME']        = null;
      $sihRecord['SHIP_DATE']         = $shipDate;
      $sihRecord['DELIVERY_DATE'] 		= $shipDate;
      $sihRecord['DELIVERY_AMPM']     = '3';
      $sihRecord['DELIVERY_TIME']     = null;
      $sihRecord['ORDER_USER']        = $userCode;
      $sihRecord['ORDER2_USER']       = $userCode;
      $sihRecord['CUSTOMER_CODE']     = null;
      $sihRecord['CUSTOMER_NAME']     = null;
      $sihRecord['DELIVERY_CODE']     = null;
      $sihRecord['DELIVERY_NAME']     = null;
      $sihRecord['SUPPLIER_CODE']     = null;
      $sihRecord['SUPPLIER_NAME']     = null;
      $sihRecord['WAREHOUSE_CODE']    = null;
      $sihRecord['WAREHOUSE_NAME']    = null;
      $sihRecord['DRIVER_CODE']       = null;
      $sihRecord['DRIVER_NAME']       = null;
      $sihRecord['TRUCKER_CODE']      = null;
      $sihRecord['TRUCKER_NAME']      = null;
      $sihRecord['FLIGHTS']           = null;
      $sihRecord['FEE']               = null;
      $sihRecord['ADD_FEE']           = null;
      $sihRecord['HIGHWAY_FEE']       = null;
      $sihRecord['FEE_CLASS']       	= null;
      $sihRecord['OFFICE_FEE_CODE']   = null;
      $sihRecord['OFFICE_FEE_NAME']   = null;
      $sihRecord['CONTINUED_SHEET']   = null;
      $sihRecord['ALL_SHEET']       	= null;
      $sihRecord['CURRENT_SHEET']     = null;
      // $sihRecord['LOADING_RATE']      = null;
      $sihRecord['INVOICE_NOTE']      = null;
      $sihRecord['DELIVERY_NOTE']     = null;
      $sihRecord['TAG_NOTE']       		= null;
      $sihRecord['CONFIRM_DATE']      = null;
      $sihRecord['STATUS']            = '0';
      $sihRecord['SNAME']             = status::where('id', '0')->first()['name'];
      $sihRecord['PRINT_DATE']       	= null;
      $sihRecord['PRINT_COUNT']       = null;
      $sihRecord['COMPLETION_DATE']   = null;
      $sihRecord['PRINT2_DATE']       = null;
      $sihRecord['PRINT2_COUNT']      = null;
      $sihRecord['CONFIRM_COUNT']     = null;
      // 明細
      if ($sihIdBase !== "") {
        // 複写
        // 基となるレコードに上書き
        // $sidRecords = ProjectCommon::getRelation('App\Models\sid', sid::where('SIH_ID', $sihIdBase))->get();
        // $sidRecords = ProjectCommon::getRelation('App\Models\sid', sid::where('ORDER_NO', $orderNoBase))->get();
        $sidRecords = ProjectCommon::syncRelation('App\Models\sid', ProjectCommon::getRelation('App\Models\sid', sid::where('SIH_ID', $sihIdBase))->get());
        // $sidRecords = ProjectCommon::syncRelation('App\Models\sid', ProjectCommon::getRelation('App\Models\sid', sid::where('ORDER_NO', $orderNoBase))->get());
      } else {
        // 新規
      }

      // 明細が8件ない場合、不足分を埋める。※本当はありえない処理にしたい
      if (count($sidRecords) < 8) {
        for ($i = count($sidRecords); $i < 8; $i++) {
          // 配列の作成
          $sidRecord = null;
          foreach ($sidColumns as $column) { $sidRecord[$column] = null;}
          // 格納
          $sidRecords[] = $sidRecord;
        }
      }
      for ($i = 0; $i < 8; $i++) {
        // 初期値設定
        $sidRecords[$i]['SIH_ID']       = $sihId;
        // $sidRecords[$i]['ORDER_NO']  = $orderNo;
        $sidRecords[$i]['RNO']          = ($i + 1);
        $sidRecords[$i]['items_rel']    = $items_rel;
        $sidRecords[$i]['qcodes_rel']   = $qcodes_rel;
        $sidRecords[$i]['QNAME']        = $qcodes_rel['NAME'];
        $sidRecords[$i]['hcodesd_rel']  = $hcodesd_rel;
        $sidRecords[$i]['SAMPLE']       = $hcodesd_rel['SAMPLE'];
      }
    }

    //---------------------------------------------------------------------
    // 結果格納と返却
    //---------------------------------------------------------------------
    $result             = array(
      "isNew"                   => $isNew,
      "sihRecord"               => $sihRecord,
      "sidRecords"              => $sidRecords,
      "officeCode"              => $officeCode,
      "adjustNo"                => $adjustNo
    );
    return $result;
  }

  //-------------------------------------------------------------------------
  // 出荷指示登録・更新
  // 一時登録と完了があるが、入力値チェックの違いのみの為、共通処理をコールしている
  // 
  //-------------------------------------------------------------------------
  public function susp(Request $request){
    return $this->regist($request, 0, 'susp');
  }
  public function susp_(Request $request){
    return $this->regist($request, 0, 'susp');
  }
  public function conf(Request $request){
    return $this->regist($request, 1, 'conf');
  }
  public function conf_(Request $request){
    return $this->regist($request, 1, 'conf');
  }
  // public function inst(Request $request){
  // 	return $this->regist($request, 1, 'inst');
  // }
  // public function slip(Request $request){
  // 	return $this->regist($request, 1, 'slip');
  // }
  public function update(Request $request){
    return $this->regist($request, 1, 'conf');
  }
  public function comp(Request $request){
    return $this->regist($request, 2, 'comp');
  }
  public function regist(Request $request, $isStatus, $isMethod){

    //---------------------------------------------------------------------
    // リクエスト取得
    //---------------------------------------------------------------------
    $isNew          = $request->input("isNew");
    $sihRecord      = $request->input("sihRecord");
    $sidRecords     = $request->input("sidRecords");

    $sihId          = $sihRecord['SIH_ID'];
    $orderNo        = $sihRecord['ORDER_NO'];

    //---------------------------------------------------------------------
    // 特殊処理
    // 例えば、このデータの時、このデータは強制的に何になるなど
    //---------------------------------------------------------------------
    if ($sihRecord['DELIVERY_AMPM'] == '3'){ $sihRecord['DELIVERY_TIME'] = null; }
    $sihRecord['STATUS'] = '0'; 
    
    //カンマ削除
    $sihRecord['FEE'] =$sihRecord['FEE'] != null ? (int)str_replace( ',', '', $sihRecord['FEE'] ):null;
    $sihRecord['ADD_FEE']=$sihRecord['ADD_FEE']!= null ? (int)str_replace( ',', '', $sihRecord['ADD_FEE'] ):null;     
    $sihRecord['HIGHWAY_FEE']=$sihRecord['HIGHWAY_FEE'] != null ? (int)str_replace( ',', '', $sihRecord['HIGHWAY_FEE'] ):null;

    if ($isStatus == 0) {
      // 0:未確定/一時保存
      $sihRecord['STATUS'] = $isStatus;
    } else if ($isStatus == 1) {
      // 1:入力確定
      $sihRecord['STATUS'] = $isStatus;
      // 入力確定日時
      $sihRecord['CONFIRM_DATE'] = date('Y-m-d H:i');

      // 確定回数の更新
      $confirmCount = 0;
      if ($sihRecord['CONFIRM_COUNT'] != null) { $confirmCount = $sihRecord['CONFIRM_COUNT']; }
      // 初回or確定時のみ
      if ($confirmCount == 0 || $isMethod == 'conf') {
        $sihRecord['CONFIRM_COUNT'] = (intval($confirmCount) + 1);
      }

      // 指示書印刷回数の更新
      if ($isMethod == 'inst') {
        $printCount = 0;
        if ($sihRecord['PRINT_COUNT'] != null) { $printCount = $sihRecord['PRINT_COUNT']; }
        $sihRecord['PRINT_COUNT'] = (intval($printCount) + 1);
        $sihRecord['PRINT_DATE'] = date('Y-m-d H:i:s');
      }

      // 伝票印刷回数の更新
      if ($isMethod == 'slip') {
        $printCount2 = 0;
        if ($sihRecord['PRINT2_COUNT'] != null) { $printCount2 = $sihRecord['PRINT2_COUNT']; }
        $sihRecord['PRINT2_COUNT'] = (intval($printCount2) + 1);
        $sihRecord['PRINT2_DATE'] = date('Y-m-d H:i:s');
      }

    } else if ($isStatus == 3) {
      // 3.端数完了
      $sihRecord['STATUS'] = $isStatus;
    } else if ($isStatus == 2) {
      // 2:出荷完了
      $sihRecord['STATUS'] = $isStatus;
      // 出荷完了日
      $sihRecord['COMPLETION_DATE'] = date('Y-m-d H:i');
    }

    // ↓2026/03/31_hash-shi_融通変換対応------------------------------
    // 定数マスタ
    $common = new CommonController;
    $configures = $common->getConfig($request);
    $officeCode = $configures[array_search('OFFICE_CODE', array_column($configures, 'ID'))]['VALUE'];
    $officeCodeF = $sihRecord['OFFICE_OTHER_CODE'];
    $officeCodeT = $sihRecord['OFFICE_CODE'];
    $hcode = $sihRecord['HCODE'];
    if ($hcode == 4 || $hcode == 5 || $hcode == 6) {
      if ($officeCode != $sihRecord['OFFICE_CODE']) {
        for ($i = 0; $i < count($sidRecords); $i++) {
          $record = $sidRecords[$i];
          if ($record['ITEM_CODE'] != null && $record['ITEM_CODE'] != "") {
            $items = itemsTransfer::where('OFFICE_CODE_F', $officeCodeF)->where('OFFICE_CODE_T', $officeCodeT)->where('ITEM_CODE_F', $record['ITEM_CODE'])->get();
            foreach($items as $item) {
              $sidRecords[$i]['ITEM_CODE'] = $item['ITEM_CODE_T'];
            }
          }
        }
      }
    }
    // ↑2026/03/31_hash-shi_融通変換対応------------------------------

    //---------------------------------------------------------------------
    // トランザクション開始
    //---------------------------------------------------------------------
    DB::beginTransaction();

    try {

      if ($isNew) {

        // IDと受注番号の取り直しを行う。
        $common = new CommonController;
        $sihId = $common->getId($request);

        // 受注番号の取り直しと更新(+1する)
        // $orderNo = $common->updOrderNo($request);
        $orderNo = 0;
        if ($sihRecord['HCODE']!=7) {
          // 通常
          $orderNo = $common->updOrderNo($request);
        } else {
          // 在庫調整
          $orderNo = $common->updAdjustNo($request);
        }

        // 登録
        $sihRecord['SIH_ID'] = $sihId;
        $sihRecord['ORDER_NO'] = $orderNo;
        DB::table('SIH')->insert(ProjectCommon::DBData($request, 'SIH', $sihRecord));
        // 一件ずつ
        foreach($sidRecords as $sidRecord) {
          $sidRecord['SIH_ID'] = $sihId;
          DB::table('SID')->insert(ProjectCommon::DBData($request, 'SID', $sidRecord));
        }

      } else {
        // 更新
        DB::table('SIH')->where('SIH_ID', $sihId)->update(ProjectCommon::DBData($request, 'SIH', $sihRecord));
        // 一件ずつ
        foreach($sidRecords as $sidRecord) {
          $sihId = $sidRecord['SIH_ID'];
          $rNo = $sidRecord['RNO'];
          DB::table('SID')->where('SIH_ID', $sihId)->where('RNO', $rNo)->update(ProjectCommon::DBData($request, 'SID', $sidRecord));
        }
      }

      //---------------------------------------------------------------------
      // コミット
      //---------------------------------------------------------------------
      DB::commit();

    } catch(Exception $e) {
      //---------------------------------------------------------------------
      // トランザクションロールバック
      //---------------------------------------------------------------------
      DB::rollback();
    }

    return array(
      "SIH_ID"   => $sihId,
      "ORDER_NO" => $orderNo,
    );
  }

  //-------------------------------------------------------------------------
  // 出荷指示更新
  // 指示書と伝票番号は印刷回数のみ更新する。
  // 
  //-------------------------------------------------------------------------
  public function inst(Request $request){
    return $this->registPrint($request, 1, 'inst');
  }
  public function slip(Request $request){
    return $this->registPrint($request, 1, 'slip');
  }
  public function registPrint(Request $request, $isStatus, $isMethod){

    //---------------------------------------------------------------------
    // リクエスト取得
    //---------------------------------------------------------------------
    $isNew          = $request->input("isNew");
    $sihRecord      = $request->input("sihRecord");
    $sidRecords     = $request->input("sidRecords");

    $sihId          = $sihRecord['SIH_ID'];
    $orderNo        = $sihRecord['ORDER_NO'];

    //---------------------------------------------------------------------
    // トランザクション開始
    //---------------------------------------------------------------------
    DB::beginTransaction();

    try {

      // 指示書印刷回数の更新
      if ($isMethod == 'inst') {
        $printCount = 0;
        if ($sihRecord['PRINT_COUNT'] != null) { $printCount = $sihRecord['PRINT_COUNT']; }
        $sihRecord['PRINT_COUNT'] = (intval($printCount) + 1);
        $sihRecord['PRINT_DATE'] = date('Y-m-d H:i:s');
      }

      // 伝票印刷回数の更新
      if ($isMethod == 'slip') {
        $printCount2 = 0;
        if ($sihRecord['PRINT2_COUNT'] != null) { $printCount2 = $sihRecord['PRINT2_COUNT']; }
        $sihRecord['PRINT2_COUNT'] = (intval($printCount2) + 1);
        $sihRecord['PRINT2_DATE'] = date('Y-m-d H:i:s');
      }

      // 更新
      DB::table('SIH')->where('SIH_ID', $sihId)->update([
        'PRINT_COUNT'    => $sihRecord['PRINT_COUNT'],
        'PRINT_DATE'     => $sihRecord['PRINT_DATE'],
        'PRINT2_COUNT'   => $sihRecord['PRINT2_COUNT'],
        'PRINT2_DATE'    => $sihRecord['PRINT2_DATE'],
      ]);

      //---------------------------------------------------------------------
      // トランザクションロールバック
      //---------------------------------------------------------------------
      DB::commit();

    } catch(Exception $e) {
      //---------------------------------------------------------------------
      // トランザクションロールバック
      //---------------------------------------------------------------------
      DB::rollback();
    }

    return array(
      "SIH_ID"   => $sihId,
      "ORDER_NO" => $orderNo,
    );
  }

  //-------------------------------------------------------------------------
  // 出荷指示削除
  // 
  // 
  //-------------------------------------------------------------------------
  public function del(Request $request){
    $sihId = $request->input("sihId");
    SIH::where('SIH_ID', $sihId)->delete();
    SID::where('SIH_ID', $sihId)->delete();
  }
  
  //-------------------------------------------------------------------------
  // 指示書印刷
  // 
  // 
  //-------------------------------------------------------------------------
  public function instructionPrint(Request $request, $sihId){

    // ヘッダーの取得
    $sihRecord = ProjectCommon::syncRelation('\App\Models\sih', ProjectCommon::getRelation('App\Models\sih', sih::where('SIH_ID', $sihId))->first());
    // $sihRecord = ProjectCommon::syncRelation('\App\Models\sih', ProjectCommon::getRelation('App\Models\sih', sih::where('ORDER_NO', $orderNo))->first());

    // 明細の取得
    $sidRecords = ProjectCommon::syncRelation('\App\Models\sid', ProjectCommon::getRelation('App\Models\sid', sid::where('SIH_ID', $sihId))->get());
    // $sidRecords = ProjectCommon::syncRelation('\App\Models\sid', ProjectCommon::getRelation('App\Models\sid', sid::where('ORDER_NO', $orderNo))->get());

    //日付系のフォーマット修正
    $orderDate      = $sihRecord['ORDER_DATE'] != null ? date('Y-m-d', strtotime($sihRecord['ORDER_DATE'])) : '';          // 受注日
    $orderTime      = $sihRecord['ORDER_TIME'] != null ? date('g', strtotime($sihRecord['ORDER_TIME'])) : '';              // 受注時刻
    $orderAmPm      = $sihRecord['ORDER_TIME'] != null ? date('A', strtotime($sihRecord['ORDER_TIME'])) : '';              // 受注時刻

    $shipDate       = $sihRecord['SHIP_DATE'] != null ?  date('Y-m-d', strtotime($sihRecord['SHIP_DATE'])) : '';           // 出荷日
    $deliveryDate   = $sihRecord['DELIVERY_DATE'] != null ? date('Y-m-d', strtotime($sihRecord['DELIVERY_DATE'])) : '';    // 納品日
    $deliveryTime   = $sihRecord['DELIVERY_TIME'] != null ? date('g:i A', strtotime($sihRecord['DELIVERY_TIME'])) :'';     // 納品時刻
    $deliveryTime   = mb_substr($deliveryTime, 0, strpos($deliveryTime, ':'));

    $QtySum = 0;

    // 1ページ目の設定・データ格納============================================================================================================

    // テンプレートファイルを読み込み
    $html_data = file_get_contents('.\Template\instruction.html');

    // 置換実行
    // $html_data = preg_replace('/_confirmCount_/',   $sihRecord['CONFIRM_COUNT'],    $html_data);
    $printCount = $sihRecord['CONFIRM_COUNT'] != null ? $sihRecord['CONFIRM_COUNT'] : 0;
    $html_data = preg_replace('/_printCount_/',   	$printCount,                    $html_data);

    $html_data = preg_replace('/_orderNo_/',        $sihRecord['ORDER_NO'],         $html_data);
    $html_data = preg_replace('/_orderYear_/',      mb_substr($orderDate, 0, 4),    $html_data);
    $html_data = preg_replace('/_orderMonth_/',     mb_substr($orderDate, 5, 2),    $html_data);
    $html_data = preg_replace('/_orderDay_/',       mb_substr($orderDate, 8, 2),    $html_data);

    if ($orderTime != null && $orderTime != "") {
      if ($orderAmPm == "AM") {
        $html_data = preg_replace('/_orderMgn_/',       '-27px',         $html_data);
        $html_data = preg_replace('/_orderCircleDis_/', 'inline-block', $html_data);
      } else if ($orderAmPm == "PM") {
        $html_data = preg_replace('/_orderMgn_/',       '-14px',         $html_data);
        $html_data = preg_replace('/_orderCircleDis_/', 'inline-block', $html_data);
      }
    } else {
      $html_data = preg_replace('/_orderCircleDis_/',     'none',     $html_data);
    }

    $html_data = preg_replace('/_shipMonth_/',      mb_substr($shipDate, 5, 2),     $html_data);
    $html_data = preg_replace('/_shipDay_/',        mb_substr($shipDate, 8, 2),     $html_data);
    $html_data = preg_replace('/_deliveryMonth_/',  mb_substr($deliveryDate, 5, 2), $html_data);
    $html_data = preg_replace('/_deliveryDay_/',    mb_substr($deliveryDate, 8, 2), $html_data);
    $html_data = preg_replace('/_deliveryTime_/',   $deliveryTime,                  $html_data);

    switch ($sihRecord['DELIVERY_AMPM']) {
      case 1:
        $html_data = preg_replace('/_deliveryMgn_/',       '-27px',        $html_data);
        $html_data = preg_replace('/_deliveryCircleDis_/', 'inline-block', $html_data);
        break;
      case 2:
        $html_data = preg_replace('/_deliveryMgn_/',       '-14px',        $html_data);
        $html_data = preg_replace('/_deliveryCircleDis_/', 'inline-block', $html_data);
        break;
      default:
        $html_data = preg_replace('/_deliveryTime_/',       '',         $html_data); 
        $html_data = preg_replace('/_deliveryCircleDis_/',  'none',     $html_data);
    }

    if ($sihRecord['HCODE']!='7') {
      // 通常
      $html_data = preg_replace('/_customerTitle_/',  '得意先',   $html_data);
      $html_data = preg_replace('/_customerCode_/',   mb_substr($sihRecord['CUSTOMER_CODE'], 3, 4),                               $html_data);
      $html_data = preg_replace('/_customerName_/',   $sihRecord['CUSTOMER_NAME'],   $html_data);
      $html_data = preg_replace('/_deliveryTitle_/',  '納入先',   $html_data);
      $html_data = preg_replace('/_deliveryCode_/',   mb_substr($sihRecord['DELIVERY_CODE'], 3, 4),                               $html_data);
      $html_data = preg_replace('/_deliveryName_/',   $sihRecord['DELIVERY_NAME'],   $html_data);
      $html_data = preg_replace('/_supplierTitle_/',  '仕入先',   $html_data);
      $html_data = preg_replace('/_supplierCode_/',   mb_substr($sihRecord['SUPPLIER_CODE'], 3, 4),                               $html_data);
      $html_data = preg_replace('/_supplierName_/',   $sihRecord['SUPPLIER_NAME'],   $html_data);
      $html_data = preg_replace('/_warehouseTitle_/', '倉庫',   $html_data);
      $html_data = preg_replace('/_warehouseCode_/',  mb_substr($sihRecord['WAREHOUSE_CODE'], 3, 4),                              $html_data);
      $html_data = preg_replace('/_warehouseName_/',  $sihRecord['WAREHOUSE_NAME'],   $html_data);
      $html_data = preg_replace('/_driverTitle_/',    '運転手',   $html_data);
      $html_data = preg_replace('/_driverCode_/',     mb_substr($sihRecord['DRIVER_CODE'], 2, 4),                                 $html_data);
      $html_data = preg_replace('/_driverName_/',     $sihRecord['DRIVER_NAME'],     $html_data);
      $html_data = preg_replace('/_driverBarcode_/',  'data:image/png;base64,'.\DNS1D::getBarcodePNG($sihRecord['DRIVER_CODE'], 'C39', 1, 25, array(1, 1, 1), true), $html_data);
      $html_data = preg_replace('/_truckerTitle_/',   '運送会社',   $html_data);
      $html_data = preg_replace('/_truckerCode_/',    $sihRecord['TRUCKER_CODE'],                                                 $html_data);
      $html_data = preg_replace('/_truckerName_/',    $sihRecord['TRUCKER_NAME'],    $html_data);
      $html_data = preg_replace('/_flightsTitle_/',   '便区分',   $html_data);
      $html_data = preg_replace('/_flights_/',        $sihRecord['FLIGHTS'],                                                      $html_data);

      $html_data = preg_replace('/_feeTitle_/',       '運賃',   $html_data);
      $html_data = preg_replace('/_fee_/',            number_format($sihRecord['FEE'],0,'',','),                                  $html_data);
      $html_data = preg_replace('/_addFeeTitle_/',    '付加',   $html_data);
      $html_data = preg_replace('/_addFee_/',         number_format($sihRecord['ADD_FEE'],0,'',','),                              $html_data);
      $html_data = preg_replace('/_highwayFeeTitle_/','有料<br>道路代',   $html_data);
      $html_data = preg_replace('/_highwayFee_/',     number_format($sihRecord['HIGHWAY_FEE'],0,'',','),                          $html_data);

      // $html_data = preg_replace('/_feeClassMgnTitle1_/',  '運賃付替区分',   $html_data);
      // $html_data = preg_replace('/_feeClassMgnTitle2_/',  '他 ・ 自',   $html_data);
      // switch ($sihRecord['FEE_CLASS']) {
      // 	case 1:
      // 		$html_data = preg_replace('/_feeClassMgn_/', '16px',         $html_data);
      // 		$html_data = preg_replace('/_feeClassDis_/', 'inline-block', $html_data);
      // 		break;
      // 	case 2:
      // 		$html_data = preg_replace('/_feeClassMgn_/', '48px',         $html_data);
      // 		$html_data = preg_replace('/_feeClassDis_/', 'inline-block', $html_data);
      // 		break;
      // 	default:
      // 		$html_data = preg_replace('/_feeClassMgn_/', '0px',          $html_data);
      // 		$html_data = preg_replace('/_feeClassDis_/', 'none',         $html_data);
      // 		break;
      // }

      $html_data = preg_replace('/_officeFeeTitle_/',  '運賃負担<br>営業所',   $html_data);
      $html_data = preg_replace('/_officeFeeCode_/',   $sihRecord['OFFICE_FEE_CODE'],   $html_data);
      $html_data = preg_replace('/_officeFeeName_/',   $sihRecord['OFFICE_FEE_NAME'],   $html_data);

    } else {
      // 在庫調整
      $html_data = preg_replace('/_customerTitle_/',  '倉庫',   $html_data);
      $html_data = preg_replace('/_customerCode_/',   mb_substr($sihRecord['DELIVERY_CODE'], 3, 4),                               $html_data);
      $html_data = preg_replace('/_customerName_/',   $sihRecord['DELIVERY_NAME'],   $html_data);
      $html_data = preg_replace('/_deliveryTitle_/',  '',   $html_data);
      $html_data = preg_replace('/_deliveryCode_/',   '',   $html_data);
      $html_data = preg_replace('/_deliveryName_/',   '',   $html_data);
      $html_data = preg_replace('/_supplierTitle_/',  '',   $html_data);
      $html_data = preg_replace('/_supplierCode_/',   '',   $html_data);
      $html_data = preg_replace('/_supplierName_/',   '',   $html_data);
      $html_data = preg_replace('/_warehouseTitle_/', '',   $html_data);
      $html_data = preg_replace('/_warehouseCode_/',  '',   $html_data);
      $html_data = preg_replace('/_warehouseName_/',  '',   $html_data);
      $html_data = preg_replace('/_driverTitle_/',    '',   $html_data);
      $html_data = preg_replace('/_driverCode_/',     '',   $html_data);
      $html_data = preg_replace('/_driverName_/',     '',   $html_data);
      $html_data = preg_replace('/_driverBarcode_/',  '""', $html_data);
      $html_data = preg_replace('/_truckerTitle_/',   '',   $html_data);
      $html_data = preg_replace('/_truckerCode_/',    '',   $html_data);
      $html_data = preg_replace('/_truckerName_/',    '',   $html_data);
      $html_data = preg_replace('/_flightsTitle_/',   '',   $html_data);
      $html_data = preg_replace('/_flights_/',        '',   $html_data);
      $html_data = preg_replace('/_feeTitle_/',       '',   $html_data);
      $html_data = preg_replace('/_fee_/',            '',   $html_data);
      $html_data = preg_replace('/_addFeeTitle_/',    '',   $html_data);
      $html_data = preg_replace('/_addFee_/',         '',   $html_data);
      $html_data = preg_replace('/_highwayFeeTitle_/','',   $html_data);
      $html_data = preg_replace('/_highwayFee_/',     '',   $html_data);

      // $html_data = preg_replace('/_feeClassMgnTitle1_/',  '',   $html_data);
      // $html_data = preg_replace('/_feeClassMgnTitle2_/',  '',   $html_data);
      // switch ($sihRecord['FEE_CLASS']) {
      // 	case 1:
      // 		$html_data = preg_replace('/_feeClassMgn_/', '16px',         $html_data);
      // 		$html_data = preg_replace('/_feeClassDis_/', 'inline-block', $html_data);
      // 		break;
      // 	case 2:
      // 		$html_data = preg_replace('/_feeClassMgn_/', '48px',         $html_data);
      // 		$html_data = preg_replace('/_feeClassDis_/', 'inline-block', $html_data);
      // 		break;
      // 	default:
      // 		$html_data = preg_replace('/_feeClassMgn_/', '0px',          $html_data);
      // 		$html_data = preg_replace('/_feeClassDis_/', 'none',         $html_data);
      // 		break;
      // }

      $html_data = preg_replace('/_officeFeeTitle_/',  '',   $html_data);
      $html_data = preg_replace('/_officeFeeCode_/',   '',   $html_data);
      $html_data = preg_replace('/_officeFeeName_/',   '',   $html_data);

    }

    for ($i = 0; $i < count($sidRecords); $i++) {
      $sidRecord = $sidRecords[$i];
      if ($sidRecord['ITEM_CODE'] != null) {

        $html_data = preg_replace('/_Hcode' . $i . '_/',        $sidRecord['HCODE'],        $html_data);
        $html_data = preg_replace('/_itemCode' . $i . '_/',     $sidRecord['ITEM_CODE'],    $html_data);
        $html_data = preg_replace('/_QtyPerCtn' . $i . '_/',    $sidRecord['QTY_PER_CTN'],  $html_data);
        $html_data = preg_replace('/_QtyCtn1' . $i . '_/',      number_format($sidRecord['QTY_CTN'],0,'',','), $html_data);
        $html_data = preg_replace('/_Qty1' . $i . '_/',         number_format($sidRecord['QTY'],0,'',','),     $html_data);
        
        // $html_data = preg_replace('/_QtyCtn2' . $i . '_/',      ($sidRecord['QTY_CTN2'] < 1 && $sidRecord['QTY_CTN2'] > 0 ? '0' . $sidRecord['QTY_CTN2'] : $sidRecord['QTY_CTN2']), $html_data); 
        // $html_data = preg_replace('/_Qty2' . $i . '_/',         ($sidRecord['QTY2'] < 1 &&   $sidRecord['QTY_CTN2'] > 0 ? '0' . $sidRecord['QTY2'] : $sidRecord['QTY2']),           $html_data); 
        // $html_data = preg_replace('/_QtyCtn2' . $i . '_/',      $sidRecord['QTY_CTN'],      $html_data);
        // $html_data = preg_replace('/_Qty2' . $i . '_/',         $sidRecord['QTY'],          $html_data);
        $html_data = preg_replace('/_QtyCtn2' . $i . '_/',      '', $html_data);
        $html_data = preg_replace('/_Qty2' . $i . '_/',         '', $html_data);

        $html_data = preg_replace('/_LoadingPlaceCode' . $i . '_/', $sidRecord['LOADING_PLACE_CODE'],   $html_data);
        $html_data = preg_replace('/_LoadingPlaceName' . $i . '_/', $sidRecord['LOADING_PLACE_NAME'],   $html_data);
        $html_data = preg_replace('/_Remark1' . $i . '_/',          $sidRecord['REMARK1'],              $html_data);
        $html_data = preg_replace('/_itemName' . $i . '_/',         $sidRecord['ITEM_NAME'],            $html_data);
        $html_data = preg_replace('/_QName' . $i . '_/',            $sidRecord['QNAME'],                $html_data);
        $html_data = preg_replace('/_Remark2' . $i . '_/',          $sidRecord['REMARK2'],              $html_data);
        $QtySum = $QtySum + (double)$sidRecord['QTY2'];
  
        //入数の違いがある場合の円の表示判定
        $items = items::where('CODE', $sidRecord['ITEM_CODE'])->first();
        $orgQtyPerCtn = null;
        if ($items != null) {
          $orgQtyPerCtn = $items['QTY_PER_CTN'];
        }
  
        if ($sidRecord['QTY_PER_CTN'] != null && $orgQtyPerCtn != $sidRecord['QTY_PER_CTN']) {
          $html_data = preg_replace('/_circle2' . $i . '_/', 'inline-block',  $html_data);
          logger('/_circle2' . $i . '_/' . ':inline-block');
        } else {
          $html_data = preg_replace('/_circle2' . $i . '_/', 'none',          $html_data);
          logger('/_circle2' . $i . '_/' . ':none');
        }

      } else {

        $html_data = preg_replace('/_Hcode' . $i . '_/',            '　', $html_data);
        $html_data = preg_replace('/_itemCode' . $i . '_/',         '　', $html_data);
        $html_data = preg_replace('/_QtyPerCtn' . $i . '_/',        '　', $html_data);
        $html_data = preg_replace('/_QtyCtn1' . $i . '_/',          '　', $html_data);
        $html_data = preg_replace('/_Qty1' . $i . '_/',             '　', $html_data);
        $html_data = preg_replace('/_QtyCtn2' . $i . '_/',          '　', $html_data); 
        $html_data = preg_replace('/_Qty2' . $i . '_/',             '　', $html_data); 
        $html_data = preg_replace('/_LoadingPlaceCode' . $i . '_/', '　', $html_data);
        $html_data = preg_replace('/_LoadingPlaceName' . $i . '_/', '　', $html_data);
        $html_data = preg_replace('/_Remark1' . $i . '_/',          '　', $html_data);
        $html_data = preg_replace('/_itemName' . $i . '_/',         '　', $html_data);
        $html_data = preg_replace('/_Remark2' . $i . '_/',          '　', $html_data);
        $html_data = preg_replace('/_QName' . $i . '_/',            '　', $html_data);
        $html_data = preg_replace('/_circle2' . $i . '_/',          'none', $html_data);
      }
    }

    // バーコード
    $html_data = preg_replace('/_barcode_/', 'data:image/png;base64,'.\DNS1D::getBarcodePNG($sihRecord['OFFICE_CODE'] . '-' . $sihRecord['ORDER_NO'], 'C39', 1, 25, array(1, 1, 1), true), $html_data);
    // バーコード下部
    $html_data = preg_replace('/_QtySum_/', round($QtySum,2), $html_data);
    // $html_data = preg_replace('/_invoiceNote_/',  mb_convert_encoding($sihRecord['INVOICE_NOTE'],  'UTF-8', 'Windows-31J'), $html_data);
    // $html_data = preg_replace('/_deliveryNote_/', mb_convert_encoding($sihRecord['DELIVERY_NOTE'], 'UTF-8', 'Windows-31J'), $html_data);
    $html_data = preg_replace('/_invoiceNote_/',  $sihRecord['INVOICE_NOTE'], $html_data);
    $html_data = preg_replace('/_deliveryNote_/', $sihRecord['DELIVERY_NOTE'], $html_data);

    // 1ページ目の設定・データ格納============================================================================================================

    // 2ページ目の設定・データ格納============================================================================================================

    // テンプレートファイルを読み込み
    $html_data2 = file_get_contents('.\Template\instruction2.html');

    // 置換実行
    $barcodeCusDel = "";
    if ($sihRecord['CUSTOMER_CODE'] != null && $sihRecord['CUSTOMER_CODE'] != "") {
      $barcodeCusDel = $sihRecord['CUSTOMER_CODE'];
    } else {
      $barcodeCusDel = $sihRecord['DELIVERY_CODE'];
    }

    if ($barcodeCusDel != null && $barcodeCusDel != "") {
      // バーコード系は空データだと落ちてしまう。
      $html_data2 = preg_replace('/_barcodeCusDel_/', '<img src=' . 'data:image/png;base64,'.\DNS1D::getBarcodePNG($barcodeCusDel, 'C39', 1, 50, array(1, 1, 1), true) . ' />',    $html_data2);
    } else {
      $html_data2 = preg_replace('/_barcodeCusDel_/', '', $html_data2);
    }

    $COUNT = count($sidRecords);
    for ($i = 0; $i < $COUNT; $i++) {
      $sidRecord = $sidRecords[$i];
      if ($sidRecord['ITEM_CODE'] != null && $sidRecord['ITEM_CODE'] != "") {
        $html_data2 = preg_replace('/_barcodeItem' . $i . '_/'  , '<img src=' . 'data:image/png;base64,'.\DNS1D::getBarcodePNG($sidRecord['ITEM_CODE'], 'C39', 1, 50, array(1, 1, 1), true) . ' />',    $html_data2);
        $html_data2 = preg_replace('/_ItemName' . $i . '_/'     , $sidRecord['ITEM_NAME']   , $html_data2);
        $html_data2 = preg_replace('/_Qty' . $i . '_/'          , $sidRecord['QTY']         , $html_data2);
        $html_data2 = preg_replace('/_barcodeQty' . $i . '_/'   , '<img src=' . 'data:image/png;base64,'.\DNS1D::getBarcodePNG($sidRecord['QTY'],       'C39', 1, 50, array(1, 1, 1), true) . ' />',    $html_data2);
      } else {
        $html_data2 = preg_replace('/_barcodeItem' . $i . '_/'  , '', $html_data2);
        $html_data2 = preg_replace('/_ItemName' . $i . '_/'     , '', $html_data2);
        $html_data2 = preg_replace('/_Qty' . $i . '_/'          , '', $html_data2);
        $html_data2 = preg_replace('/_barcodeQty' . $i . '_/'   , '', $html_data2);
      }
    }

    // 2ページ目の設定・データ格納============================================================================================================
    
    $pdf = new Pdf([
      // エンコード形式
      'encoding'          => 'utf-8',
      'page-size'         => 'B5',
      'orientation'       => 'landscape',
      'margin-top'        => '0',
      'margin-left'       => '0',
      'margin-right'      => '0',
      'margin-bottom'     => '0',
      'disable-smart-shrinking',
    ]);

    //ページを追加
    $pdf->addPage($html_data);
    $pdf->addPage($html_data2);
    
    //画面へ返却する
    $pdf-> send();

  }

  //-------------------------------------------------------------------------
  // 伝票印刷
  // 
  // 
  //-------------------------------------------------------------------------
  public  function slipPrint(Request $request, $sihId){

    // ヘッダーの取得
    $sihRecord = sih::where('SIH_ID', $sihId)->first();
    // $sihRecord = sih::where('ORDER_NO', $orderNo)->first();
    // 明細の取得
    $sidRecords = sid::where('SIH_ID', $sihId)->get();
    // $sidRecords = sid::where('ORDER_NO', $orderNo)->get();

    //日付系のフォーマット定義
    $shipDate       = $sihRecord['SHIP_DATE'] != null ? date('Y-m-d', strtotime($sihRecord['SHIP_DATE'])) : "";            //出荷日
    $deliveryDate   = $sihRecord['DELIVERY_DATE'] != null ? date('Y-m-d', strtotime($sihRecord['DELIVERY_DATE'])) : "";    //納品日

    // テンプレートファイルを読み込み
    // ↓2026/03/31_hash-shi_伝票分岐------------------------------
    // $html_data = file_get_contents(".\Template\ship.html");
    $html_data = null;
    if ($sihRecord['CUSTOMER_CODE'] != '1487700') {
      // 日本飾材以外
      $html_data = file_get_contents(".\Template\ship.html");
    } else {
      // 日本飾材
      $html_data = file_get_contents(".\Template\ship_1487700.html");
    }
    // ↑2026/03/31_hash-shi_伝票分岐------------------------------

    // 置換実行
    $html_data = preg_replace('/_orderNo_/',        $sihRecord['ORDER_NO'],         $html_data); 
    // $html_data = preg_replace('/_companyName_/',    $sihRecord['COMPANY_NAME'],     $html_data);
    $html_data = preg_replace('/_companyName_/',    $sihRecord['CUSTOMER_NAME'],    $html_data);
    $html_data = preg_replace('/_deliverryName_/',  $sihRecord['DELIVERY_NAME'],    $html_data);
    $html_data = preg_replace('/_shipYear_/',       mb_substr($shipDate,0,4),       $html_data);
    $html_data = preg_replace('/_shipMonth_/',      mb_substr($shipDate,5,2),       $html_data);
    $html_data = preg_replace('/_shipDay_/',        mb_substr($shipDate,8,2),       $html_data);
    // $html_data = preg_replace('/_confirmCount_/',   $sihRecord['PRINT2_COUNT'],     $html_data);
    $printCount2 = $sihRecord['CONFIRM_COUNT'] != null ? $sihRecord['CONFIRM_COUNT'] : 0;
    $html_data = preg_replace('/_print2Count_/',    $printCount2,                   $html_data);
    $html_data = preg_replace('/_deliveryYear_/',   mb_substr($deliveryDate,0,4),   $html_data);
    $html_data = preg_replace('/_deliveryMonth_/',  mb_substr($deliveryDate,5,2),   $html_data);
    $html_data = preg_replace('/_deliveryDay_/',    mb_substr($deliveryDate,8,2),   $html_data);

    for ($i = 0; $i < 8; $i++) {
      $sidRecord = $sidRecords[$i];
      $html_data = preg_replace('/_itemName' . $i . '_/'  , $sidRecord['ITEM_NAME'],      $html_data);
      $html_data = preg_replace('/_QtyPerCtn' . $i . '_/' , $sidRecord['QTY_PER_CTN'],    $html_data);
      $html_data = preg_replace('/_QtyCtn' . $i . '_/'    , $sidRecord['QTY_CTN'],        $html_data);
      $html_data = preg_replace('/_Qty' . $i . '_/'       , $sidRecord['QTY'],            $html_data);
    }

    // ↓2026/03/31_hash-shi_伝票分岐------------------------------
    // $html_data = preg_replace('/_hane_/','data:image/png;base64,'.base64_encode(file_get_contents('./images/hane.bmp')),$html_data);
    if ($sihRecord['CUSTOMER_CODE'] != '1487700') {
      $html_data = preg_replace('/_hane_/','data:image/png;base64,'.base64_encode(file_get_contents('./images/hane.bmp')),$html_data);
    } else {
      $html_data = preg_replace('/_hane_/','data:image/png;base64,'.base64_encode(file_get_contents('./images/nisshoku.bmp')),$html_data);
    }
    // ↑2026/03/31_hash-shi_伝票分岐------------------------------

    $html_data = preg_replace('/_warehouseName_/',  $sihRecord['WAREHOUSE_NAME'],   $html_data);
    $html_data = preg_replace('/_truckerName_/',    $sihRecord['TRUCKER_NAME'],     $html_data);
    $html_data = preg_replace('/_driverName_/',     $sihRecord['DRIVER_NAME'],      $html_data);

    $pdf = new Pdf([
      // エンコード形式
      'encoding'      => 'utf-8',
      'page-size'     => 'B4',
      'orientation'   => 'landscape',
      'margin-top'    => 0,
      'margin-left'   => 0,
      'margin-right'  => 0,
      'margin-bottom' => 0,
    ]);

    //ページを追加
    $pdf->addPage($html_data);
    $pdf-> send();
  }

  //-------------------------------------------------------------------------
  // 一覧の取得
  // 
  // 
  //-------------------------------------------------------------------------
  public function getDetail(Request $request){
    $master = new MasterController;
    $user = $master->getUsers($request);
    $hcodesD = $master->getHCodesD($request);
    $places = $master->getPlaces($request);
    $remarks = $master->getRemarks($request);
    $qcodes = $master->getQCodes($request);
    $result = array(
      "users"         => $user,
      "hcodesD"       => $hcodesD,
      "places"        => $places,
      "remarks"       => $remarks,
      "qcodes"        => $qcodes,
    );
    return $result;
  }

}
