<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\api\MasterController;
use App\Http\Controllers\Controller;
use App\Libs\DBUtility;
use App\Libs\Masters;
use App\Libs\ProjectCommon;
use App\Models\configures;
use App\Models\customers;
use App\Models\deliveries;
use App\Models\drivers;
use App\Models\hcodesD;
use App\Models\hcodesH;
use App\Models\items;
use App\Models\itemsCustomer;
use App\Models\itemsSupplier;
use App\Models\itemsTransfer;
use App\Models\offices;
use App\Models\places;
use App\Models\remarks;
use App\Models\sid;
use App\Models\sih;
use App\Models\status;
use App\Models\suppliers;
use App\Models\users;
use App\Models\warehouses;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use mikehaertl\wkhtmlto\Pdf;
use milon\barcode;

class CommonController extends Controller
{
	//-------------------------------------------------------------------------
	// SSO用ユーザー情報の取得
	// 
	// 
	//-------------------------------------------------------------------------
	public function getSSO(Request $request, $userCode){
		return users::where('CODE', $userCode)->orderBy('CODE')->get();
	}

	//-------------------------------------------------------------------------
	// 設定ファイルの取得
	// 
	// 
	//-------------------------------------------------------------------------
	public function getConfig(Request $request){
		return json_decode(json_encode(configures::whereNotNull('ID')->get()), true);
	}

	//-------------------------------------------------------------------------
	// サーバーシステム日付の取得
	// 
	// 
	//-------------------------------------------------------------------------
	public function getToday(Request $request){
		return date("Y-m-d");
	}

	//-------------------------------------------------------------------------
	// ID
	// 出荷指示のIDを採番
	// 
	//-------------------------------------------------------------------------
	public function getId(Request $request){
		// 最大値を取得
		$sihId = sih::max("SIH_ID");
		// 返却
		return $sihId + 1;
	}

	//-------------------------------------------------------------------------
	// ORDER_NO
	// 出荷指示の受注番号を採番
	// 
	//-------------------------------------------------------------------------
	public function getOrderNo(Request $request){

		$orderNo = "1";

		// 採番最大値取得
		$config = $this->getConfig($request);
		$orderNoMax = $config[array_search('ORDER_NO_MAX', array_column($config, 'ID'))]['VALUE'];

		// 最新の受注番号を取得
		$orderNoNext = $config[array_search('ORDER_NO_NEXT', array_column($config, 'ID'))]['VALUE'];

		// 受注番号を比較して格納
		// if ($record != null && intval($record['ORDER_NO']) < intval($orderNoMax)) { $orderNo = $record['ORDER_NO']; }
		if (intval($orderNoNext) < intval($orderNoMax)) { $orderNo = $orderNoNext; }

		// + 1して返却
		// return sprintf('%06d', (intval($orderNo) + 1));
		return sprintf('%06d', (intval($orderNo)));
	}

	//-------------------------------------------------------------------------
	// ORDER_NO
	// 出荷指示の登録時に最新番号を取り直す&+1値に更新する。
	// 取り直した場合を考慮して最新番号を返却する。
	//-------------------------------------------------------------------------
	public function updOrderNo(Request $request){
		$orderNo = $this->getOrderNo($request);
		configures::where('ID', 'ORDER_NO_NEXT')->update(['VALUE' => (intval($orderNo) + 1)]);
		return $orderNo;
	}

	//-------------------------------------------------------------------------
	// ORDER_NO
	// 出荷指示の受注番号を採番
	// (在庫調整用)
	//-------------------------------------------------------------------------
	public function getAdjustNo(Request $request){
		
		$orderNo = "900001";

		// 採番最大値取得
		$config = $this->getConfig($request);
		$orderNoMax = $config[array_search('ADJUST_NO_MAX', array_column($config, 'ID'))]['VALUE'];

		// 最新の受注番号を取得
		$orderNoNext = $config[array_search('ADJUST_NO_NEXT', array_column($config, 'ID'))]['VALUE'];

		// 受注番号を比較して格納
		if (intval($orderNoNext) < intval($orderNoMax)) { $orderNo = $orderNoNext; }

		// + 1して返却
		// return sprintf('%06d', (intval($orderNo) + 1));
		return sprintf('%06d', (intval($orderNo)));
	}

	//-------------------------------------------------------------------------
	// ORDER_NO
	// 出荷指示の登録時に最新番号を取り直す&+1値に更新する。
	// 取り直した場合を考慮して最新番号を返却する。
	// (在庫調整用)
	//-------------------------------------------------------------------------
	public function updAdjustNo(Request $request){
		$orderNo = $this->getAdjustNo($request);
		configures::where('ID', 'ADJUST_NO_NEXT')->update(['VALUE' => (intval($orderNo) + 1)]);
		return $orderNo;
	}

	//-------------------------------------------------------------------------
	// ORDER_NO
	// 出荷指示の受注番号を採番
	// (在庫調整用)
	// HANE1用特殊処理、SIHから900000番台の中の最大値+1を返却する。
	//-------------------------------------------------------------------------
	public function getAdjustNoMax(Request $request){
		
		$orderNo = "900000";

		$sql = "";

		$sql = "
		SELECT
			(MAX(ORDER_NO) + 1) ORDER_NO
		FROM
			SIH
		WHERE
			1 = 1
		AND ORDER_NO BETWEEN 900000 AND 999999
		";

		// コード
		$param[] = null;

		$record = DB::select($sql, $param);
		$record = json_decode(json_encode($record), true);

		if (0 < count($record)) { $orderNo = $record[0]["ORDER_NO"]; }

		// + 1して返却
		// return sprintf('%06d', (intval($orderNo) + 1));
		return sprintf('%06d', (intval($orderNo)));
	}

}