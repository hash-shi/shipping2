<?php

namespace App\Http\Controllers\api;

use App\Libs\DBUtility;
use App\Http\Controllers\Controller;
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
use App\Models\suppliers;
use App\Models\users;
use App\Models\warehouses;
use App\Libs\ProjectCommon;
use Illuminate\Http\Request;
use DB;
class MasterController extends Controller
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
		// return configures::whereNotNull('ID')->get();
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
	// Users
	// 
	// 
	//-------------------------------------------------------------------------
	public function getUsers(Request $request){
		return users::whereNotNull('CODE')->orderBy('CODE')->get();
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

		// $query = sih::query();
		// $query->where('SIH_ID', sih::max("SIH_ID"));
		// $record = $query->first();

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
	// Customers
	// 
	// 
	//-------------------------------------------------------------------------
	public function getCustomers(Request $request){

		//---------------------------------------------------------------------
		// パラメータ取得
		//---------------------------------------------------------------------
		$searchOfficeCode       = $request->input("searchOfficeCode");
		$searchCustomerKana     = $request->input("searchCustomerKana");
		$searchCustomerName     = $request->input("searchCustomerName");
		$notLike                = $request->input("notLike");

		// 検索条件の組み立て
		$query = customers::query();

		$query->where('ON_NOT_USE', 0);

		// 営業所コード
		if ($searchOfficeCode != null && $searchOfficeCode != ""){
			if ($notLike == 0) {
				$query->where('CODE', 'LIKE', $searchOfficeCode . '%');
			} else {
				$query->where('CODE', 'NOT LIKE', $searchOfficeCode . '%');
			}
		}

		// 得意先カナ
		if ($searchCustomerKana !== null && $searchCustomerKana !== ""){
			$query->where('NAME1', 'LIKE', '%' . mb_convert_kana($searchCustomerKana, "kvhas") . '%');
		}

		// 得意先名
		if ($searchCustomerName != null && $searchCustomerName != ""){
			$query->where('NAME', 'LIKE', '%' . $searchCustomerName . '%');
		}

		// 並び順
		$query->orderBy('CODE', 'asc');

		// 検索結果
		// $customers = ProjectCommon::getRelation('\App\Models\customers', $query)->get();
		$customers = $query->get();

		// 返却
		return $customers;
	}

	//-------------------------------------------------------------------------
	// Deliveries
	// 
	// 
	//-------------------------------------------------------------------------
	public function getDeliveries(Request $request){

		//---------------------------------------------------------------------
		// パラメータ取得
		//---------------------------------------------------------------------
		$searchOfficeCode       = $request->input("searchOfficeCode");
		$searchCustomerCode     = $request->input("searchCustomerCode");
		$searchDeliveryKana     = $request->input("searchDeliveryKana");
		$searchDeliveryName     = $request->input("searchDeliveryName");
		$notLike                = $request->input("notLike");

		// 検索条件の組み立て
		$query = deliveries::query();

		$query->where('ON_NOT_USE', 0);
		
		// 営業所コード
		if ($searchOfficeCode != null && $searchOfficeCode != ""){
			if ($notLike == 0) {
				$query->where('CODE', 'LIKE', $searchOfficeCode . '%');
			} else {
				$query->where('CODE', 'NOT LIKE', $searchOfficeCode . '%');
			}
		}

		// 得意先コード
		if ($searchCustomerCode != null && $searchCustomerCode != ""){
			$query->where('CUSTOMER_CODE', $searchCustomerCode);
		}

		// カナ
		if ($searchDeliveryKana != null && $searchDeliveryKana != ""){
			$query->where('NAME2', 'LIKE', '%' . mb_convert_kana($searchDeliveryKana, "kvhas") . '%');
		}

		// 名
		if ($searchDeliveryName != null && $searchDeliveryName != ""){
			$query->where('NAME', 'LIKE', '%' . $searchDeliveryName . '%');
		}

		// 並び順
		$query->orderBy('CODE', 'asc');

		// 検索結果
		// $deliveries = ProjectCommon::getRelation('\App\Models\deliveries', $query)->get();
		$deliveries = $query->get();

		// 返却
		return $deliveries;
	}

	//-------------------------------------------------------------------------
	// Suppliers
	// 
	// 
	//-------------------------------------------------------------------------
	public function getSuppliers(Request $request){

		//---------------------------------------------------------------------
		// パラメータ取得
		//---------------------------------------------------------------------
		$searchOfficeCode       = $request->input("searchOfficeCode");
		$searchSupplierKana     = $request->input("searchSupplierKana");
		$searchSupplierName     = $request->input("searchSupplierName");
		$notLike                = $request->input("notLike");

		
		// 検索条件の組み立て
		$query = suppliers::query();

		$query->where('ON_NOT_USE', 0);

		// 営業所コード
		if ($searchOfficeCode != null && $searchOfficeCode != ""){
			if ($notLike == 0) {
				$query->where('CODE', 'LIKE', $searchOfficeCode . '%');
			} else {
				$query->where('CODE', 'NOT LIKE', $searchOfficeCode . '%');
			}
		}

		// カナ
		if ($searchSupplierKana != null && $searchSupplierKana != ""){
			$query->where('NAME1', 'LIKE', '%' . mb_convert_kana($searchSupplierKana, "kvhas") . '%');
		}

		// 名
		if ($searchSupplierName != null && $searchSupplierName != ""){
			$query->where('NAME', 'LIKE', '%' . $searchSupplierName . '%');
		}

		// 並び順
		$query->orderBy('CODE', 'asc');

		// 検索結果
		// $customers = ProjectCommon::getRelation('\App\Models\suppliers', $query)->get();
		$suppliers = $query->get();

		// 返却
		return $suppliers;
	}

	//-------------------------------------------------------------------------
	// Warehouses
	// 
	// 
	//-------------------------------------------------------------------------
	public function getWarehouses(Request $request){

		//---------------------------------------------------------------------
		// パラメータ取得
		//---------------------------------------------------------------------
		$searchOfficeCode       = $request->input("searchOfficeCode");
		$searchWarehouseKana    = $request->input("searchWarehouseKana");
		$searchWarehouseName    = $request->input("searchWarehouseName");
		$notLike                = $request->input("notLike");

		// 検索条件の組み立て
		$query = warehouses::query();

		// 営業所コード
		if ($searchOfficeCode != null && $searchOfficeCode != ""){
			if ($notLike == 0) {
				$query->where('CODE', 'LIKE', $searchOfficeCode . '%');
			} else {
				$query->where('CODE', 'NOT LIKE', $searchOfficeCode . '%');
			}
		}

		// カナ
		if ($searchWarehouseKana != null && $searchWarehouseKana != ""){
			$query->where('NAME1', 'LIKE', '%' . mb_convert_kana($searchWarehouseKana, "kvhas") . '%');
		}

		// 名
		if ($searchWarehouseName != null && $searchWarehouseName != ""){
			$query->where('NAME', 'LIKE', '%' . $searchWarehouseName . '%');
		}

		// 並び順
		$query->orderBy('CODE', 'asc');

		// 検索結果
		// $customers = ProjectCommon::getRelation('\App\Models\warehouses', $query)->get();
		$warehouses = $query->get();

		// 返却
		return $warehouses;
	}

	//-------------------------------------------------------------------------
	// Drivers
	// 
	// 
	//-------------------------------------------------------------------------
	public function getDrivers(Request $request){

		//---------------------------------------------------------------------
		// パラメータ取得
		//---------------------------------------------------------------------
		$searchOfficeCode       = $request->input("searchOfficeCode");
		$searchOfficeOtherCode  = $request->input("searchOfficeOtherCode");
		$searchDriverKana       = $request->input("searchDriverKana");
		$searchDriverName       = $request->input("searchDriverName");
		$searchTruckerKana      = $request->input("searchTruckerKana");
		$searchTruckerName      = $request->input("searchTruckerName");

		// 検索条件の組み立て
		$query = drivers::query();

		$query->where('ON_NOT_USE', 0);

		// 営業所と相手営業所が両方ある場合は、or検索する。
		if (($searchOfficeCode != null && $searchOfficeCode != "") &&
			($searchOfficeOtherCode != null && $searchOfficeOtherCode != "")) {
				$query->where(function($companyCode) use($searchOfficeCode, $searchOfficeOtherCode){
					$companyCode->where('COMPANY_CODE', $searchOfficeCode)->orWhere('COMPANY_CODE', $searchOfficeOtherCode);
				});
		} else {

			// 営業所コード
			if ($searchOfficeCode != null && $searchOfficeCode != ""){
				$query->where('COMPANY_CODE', $searchOfficeCode);
			}

			// 相手営業所コード
			if ($searchOfficeOtherCode != null && $searchOfficeOtherCode != ""){
				$query->where('COMPANY_CODE', $searchOfficeOtherCode);
			}
		}

		// ドライバーカナ
		if ($searchDriverKana != null && $searchDriverKana != ""){
			$query->where('NAME2', 'LIKE', '%' . mb_convert_kana($searchDriverKana, "kvhas") . '%');
		}

		// ドライバー名
		if ($searchDriverName != null && $searchDriverName != ""){
			$query->where('NAME', 'LIKE', '%' . $searchDriverName . '%');
		}

		// 配送会社カナ
		if ($searchTruckerKana != null && $searchTruckerKana != ""){
			$query->where('TRUCKER_NAME2', 'LIKE', '%' . mb_convert_kana($searchTruckerKana, "kvhas") . '%');
		}

		// 配送会社名
		if ($searchTruckerName != null && $searchTruckerName != ""){
			$query->where('TRUCKER_NAME', 'LIKE', '%' . $searchTruckerName . '%');
		}

		// 並び順
		$query->orderBy('CODE', 'asc');

		// 検索結果
		// $customers = ProjectCommon::getRelation('\App\Models\drivers', $query)->get();
		$drivers = $query->get();

		// 返却
		return $drivers;
	}

	//-------------------------------------------------------------------------
	// HCodesH
	// 
	// 
	//-------------------------------------------------------------------------
	public function getHCodesH(Request $request){

		//---------------------------------------------------------------------
		// パラメータ取得
		//---------------------------------------------------------------------
		$HCODE = $request->input("HCODE");

		// 検索条件の組み立て
		$query = hcodesH::query();

		// コード
		if ($HCODE != null && $HCODE != ""){
			$query->where('CODE', $HCODE);
		}

		// 並び順
		$query->orderBy('CODE', 'asc');

		// 検索結果
		// $customers = ProjectCommon::getRelation('\App\Models\hCodes', $query)->get();
		$hCodesH = $query->get();

		// 返却
		return $hCodesH;
	}

	//-------------------------------------------------------------------------
	// HCodesD
	// 
	// 
	//-------------------------------------------------------------------------
	public function getHCodesD(Request $request){

		//---------------------------------------------------------------------
		// パラメータ取得
		//---------------------------------------------------------------------
		$HCODE = $request->input("HCODE");

		$KBN = null;

		// コードがある場合は区分を取得する。
		if ($HCODE != null && $HCODE != "") {
			$hCodesH = $this->getHCodesH($request);
			if (0 < count($hCodesH)) {
				$KBN = $hCodesH[0]['KBN'];
			}
		}

		// 検索条件の組み立て
		$query = hcodesD::query();

		// 区分
		if ($KBN != null && $KBN != ""){
			$query->where('KBN', $KBN);
		}

		// 並び順
		$query->orderBy('CODE', 'asc');

		// 検索結果
		// $customers = ProjectCommon::getRelation('\App\Models\hCodes', $query)->get();
		$hCodesD = $query->get();

		// 返却
		return $hCodesD;
	}

	//-------------------------------------------------------------------------
	// Items
	// 
	// 
	//-------------------------------------------------------------------------
	public function getItems(Request $request){

		//---------------------------------------------------------------------
		// パラメータ取得
		//---------------------------------------------------------------------
		// 20220720_hash-shi_得意先・納入先の絞り込み追加_str------------
		$searchHcode            = $request->input("searchHcode");
		$searchCustomerCode     = $request->input("searchCustomerCode");
		$searchDeliveryCode     = $request->input("searchDeliveryCode");
		$searchSupplierCode     = $request->input("searchSupplierCode");
		// 20220720_hash-shi_得意先・納入先の絞り込み追加_end------------
		$searchItemCode         = $request->input("searchItemCode");
		$searchItemName         = $request->input("searchItemName");
		$searchType             = $request->input("searchType");

		// 検索条件の組み立て
		$query = items::query();

		// 売上or仕入で分岐する。
		if ($searchHcode == 1 || $searchHcode == 4) {
			// 得意先別納入先別マスタ
			$query->whereIn('CODE', function($queryItemsC) use($searchCustomerCode, $searchDeliveryCode) {
				$queryItemsC->from('ITEMS_CUSTOMER');
				$queryItemsC->select('ITEM_CODE');

				// 得意先コード
				if ($searchCustomerCode != null && $searchCustomerCode != "") {
					$queryItemsC->where('CUSTOMER_CODE', $searchCustomerCode);
				}

				// 納入先コード
				$queryItemsC->where(function ($queryDel) use($searchDeliveryCode) {
					if ($searchDeliveryCode != null && $searchDeliveryCode != "") {
						$queryDel->where('DELIVERY_CODE', $searchDeliveryCode)->orWhereNull('DELIVERY_CODE');
					}
				});

				$queryItemsC->distinct();
			});
		} else if ($searchHcode != 1 && $searchHcode != 4) {
			// 仕入先別マスタ
			$query->whereIn('CODE', function($queryItemsC) use($searchSupplierCode) {
				$queryItemsC->from('ITEMS_SUPPLIER');
				$queryItemsC->select('ITEM_CODE');
				// 仕入先コード
				if ($searchSupplierCode != null && $searchSupplierCode != "") {
					$queryItemsC->where('SUPPLIER_CODE', $searchSupplierCode);
				}
				$queryItemsC->distinct();
			});
		}

		// 商品コード
		if($searchType =="1") {
			if ($searchItemCode != null && $searchItemCode != "") {
				$query->where('CODE', $searchItemCode);
			}
		} else {
			if ($searchItemCode != null && $searchItemCode != "") {
				$query->where('CODE', 'LIKE', '%' . $searchItemCode . '%');
			}
		}

		// 商品名
		if ($searchItemName != null && $searchItemName != "") {
			$query->where('NAME', 'LIKE', '%' . $searchItemName . '%');
		}

		// 並び順
		$query->orderBy('SORT_ORDER');

		// 検索結果
		$items = $query->get();

		// 返却
		return $items;
	}

	//-------------------------------------------------------------------------
	// Places
	// 
	// 
	//-------------------------------------------------------------------------
	public function getPlaces(Request $request){

		// 検索条件の組み立て
		$query = places::query();

		$query->where('ON1', 1);

		// 並び順
		$query->orderBy('CODE', 'asc');

		// 検索結果
		// $customers = ProjectCommon::getRelation('\App\Models\places', $query)->get();
		$places = $query->get();

		// 返却
		return $places;
	}

	//-------------------------------------------------------------------------
	// ItemCustomer
	// 
	// 
	//-------------------------------------------------------------------------
	public function getItemCustomer(Request $request){

		$searchCustomerCode     = $request->input("searchCustomerCode");
		$searchDeliveryCode     = $request->input("searchDeliveryCode");

		// 検索条件の組み立て
		$query = itemsCustomer::query();

		// 得意先コード
		if ($searchCustomerCode != null && $searchCustomerCode != "") {
			$query->where('CUSTOMER_CODE', $searchCustomerCode);
		}

		// 納入先コード
		$query->where(function ($queryDel) use($searchDeliveryCode) {
			if ($searchDeliveryCode != null && $searchDeliveryCode != "") {
				$queryDel->where('DELIVERY_CODE', $searchDeliveryCode)->orWhereNull('DELIVERY_CODE');
			}
		});

		$query->select('CUSTOMER_CODE', 'CUSTOMER_NAME', 'DELIVERY_CODE', 'DELIVERY_NAME', 'ITEM_CODE', 'ITEM_NAME');
		$query->distinct();
		$query->orderBy('CUSTOMER_CODE');

		// 検索結果
		$itemsCustomer = $query->get();
		// 返却
		return $itemsCustomer;
	}

	//-------------------------------------------------------------------------
	// ItemSupplier
	// 
	// 
	//-------------------------------------------------------------------------
	public function getItemSupplier(Request $request){

		$searchSupplierCode     = $request->input("searchSupplierCode");

		// 検索条件の組み立て
		$query = itemsSupplier::query();

		// 仕入先コード
		if ($searchSupplierCode != null && $searchSupplierCode != "") {
			$query->where('SUPPLIER_CODE', $searchSupplierCode);
		}

		$query->select('SUPPLIER_CODE', 'ITEM_CODE');
		$query->distinct();
		$query->orderBy('SUPPLIER_CODE');

		// 検索結果
		$itemsSupplier = $query->get();
		// 返却
		return $itemsSupplier;
	}

	//-------------------------------------------------------------------------
	// ItemTransfer
	// 
	// 
	//-------------------------------------------------------------------------
	public function getItemTransfer(Request $request){

		// 検索条件の組み立て
		$query = itemsTransfer::query();
		$query->select('IN_OFFICE_CODE', 'IN_ITEM_CODE', 'OT_OFFICE_CODE', 'OT_ITEM_CODE');
		$query->distinct();
		$query->orderBy('IN_OFFICE_CODE');

		// 検索結果
		$itemsTransfer = $query->get();
		// 返却
		return $itemsTransfer;
	}

	//-------------------------------------------------------------------------
	// Remarks
	// 
	// 
	//-------------------------------------------------------------------------
	public function getRemarks(Request $request){

		// 検索条件の組み立て
		$query = remarks::query();

		// 並び順
		$query->orderBy('class', 'asc');
		$query->orderBy('code', 'asc');

		// 検索結果
		// $remarks = ProjectCommon::getRelation('\App\Models\remarks', $query)->get();
		$remarks = $query->get();

		// 返却
		return $remarks;
	}

	//-------------------------------------------------------------------------
	// getOffices
	// 
	// 
	//-------------------------------------------------------------------------
	public function getOffices(Request $request){

		//---------------------------------------------------------------------
		// パラメータ取得
		//---------------------------------------------------------------------
		$searchOfficeCode     = $request->input("searchOfficeCode");
		$searchOfficeKana     = $request->input("searchOfficeKana");
		$searchOfficeName     = $request->input("searchOfficeName");

		// 検索条件の組み立て
		$query = offices::query();

		// コード
		if ($searchOfficeCode != null && $searchOfficeCode != ""){
			$query->where('CODE', $searchOfficeCode);
		}

		// カナ
		if ($searchOfficeKana != null && $searchOfficeKana != ""){
			$query->where('NAME1', 'LIKE', '%' . mb_convert_kana($searchOfficeKana, "kvhas") . '%');
		}

		// 名
		if ($searchOfficeName != null && $searchOfficeName != ""){
			$query->where('NAME', 'LIKE', '%' . $searchOfficeName . '%');
		}

		// 並び順
		$query->orderBy('CODE', 'asc');

		// 検索結果
		$offices = $query->get();

		// 返却
		return $offices;
	}

	public function getDetail(Request $request){

		$user = $this->getUsers($request);
		$customers = $this->getCustomers($request);
		$deliveries = $this->getDeliveries($request);
		$suppliers = $this->getSuppliers($request);
		$warehouses = $this->getWarehouses($request);
		$drivers = $this->getDrivers($request);
		$hcodesD = $this->getHCodesD($request);
		$places = $this->getPlaces($request);
		$remarks = $this->getRemarks($request);
		$offices = $this->getOffices($request);

		$result = array(
			"users"         => $user,
			"customers"     => $customers,
			"deliveries"    => $deliveries,
			"suppliers"     => $suppliers,
			"warehouses"    => $warehouses,
			"drivers"       => $drivers,
			"hcodesD"       => $hcodesD,
			"places"        => $places,
			"remarks"       => $remarks,
			"offices"       => $offices,
		);

		return $result;
	}
}
