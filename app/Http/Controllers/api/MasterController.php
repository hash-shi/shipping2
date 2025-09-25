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
class MasterController extends Controller {
	//-------------------------------------------------------------------------
	// Customers
	// 得意先
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
		// $customers = $query->get();
		$customers = $query->select('CODE', 'NAME', 'NAME1')->get();

		// 返却
		return $customers;
	}
	public function getCustomerName(Request $request){

		$sql = "";
		$param = [];
		$result = "";

		//---------------------------------------------------------------------
		// パラメータ取得
		//---------------------------------------------------------------------
		$code     = $request->input("code") ?? "0";

		$sql = "
			select
				NAME
			from
				CUSTOMERS
			where
				1 = 1
			and CODE = ?
			order by
				CODE
		";

		// コード
		$param[] = $code;

		$record = DB::select($sql, $param);
		$record = json_decode(json_encode($record), true);

		// 返却
		if (0 < count($record)) { $result = $record[0]["NAME"]; }
		return $result;
	}

	//-------------------------------------------------------------------------
	// Deliveries
	// 納入先
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
		$deliveries = $query->select('CUSTOMER_CODE','CODE','NAME','NAME2')->get();

		// 返却
		return $deliveries;
	}
	public function getDeliverieName(Request $request){

		$sql = "";
		$param = [];
		$result = "";

		//---------------------------------------------------------------------
		// パラメータ取得
		//---------------------------------------------------------------------
		$code         = $request->input("code") ?? "0";
		$customerCode = $request->input("customerCode");

		$sql = "
			select
				NAME
			from
				DELIVERIES
			where
				1 = 1
			and CODE = ?
		";
		// コード
		$param[] = $code;

		if ($customerCode != null && $customerCode != "") {
			$sql = $sql . " and CUSTOMER_CODE = ? ";
			$param[] = $customerCode;
		}

		$sql = $sql . "
			order by
				CODE
		";

		$record = DB::select($sql, $param);
		$record = json_decode(json_encode($record), true);

		// 返却
		if (0 < count($record)) { $result = $record[0]["NAME"]; }
		return $result;
	}

	//-------------------------------------------------------------------------
	// Drivers
	// 運転手
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
		$drivers = $query->select('CODE', 'NAME', 'TRUCKER_CODE', 'TRUCKER_NAME', 'COMPANY_CODE')->get();

		// 返却
		return $drivers;
	}
	public function getDriverName(Request $request){

		$sql = "";
		$param = [];
		$result = "";

		//---------------------------------------------------------------------
		// パラメータ取得
		//---------------------------------------------------------------------
		$code         = $request->input("code") ?? "0";
		$truckerCode	= $request->input("truckerCode");
		$companyCode	= $request->input("companyCode");

		$sql = "
			select
				NAME
			from
				DRIVERS
			where
				1 = 1
			and CODE = ?
		";
		// コード
		$param[] = $code;

		if ($truckerCode != null && $truckerCode != "") {
			$sql = $sql . " and TRUCKER_CODE = ? ";
			$param[] = $truckerCode;
		}

		if ($companyCode != null && $companyCode != "") {
			$sql = $sql . " and COMPANY_CODE = ? ";
			$param[] = $companyCode;
		}

		$sql = $sql . "
			order by
				CODE,
				TRUCKER_CODE
		";

		$record = DB::select($sql, $param);
		$record = json_decode(json_encode($record), true);

		// 返却
		if (0 < count($record)) { $result = $record[0]["NAME"]; }
		return $result;
	}
	//---------------------------------------------------------------------
	// 特殊処理、運転手コードから運送会社コードを取得
	//---------------------------------------------------------------------
	public function getDriverTrucker(Request $request){

		$sql = "";
		$param = [];
		$result = "";

		//---------------------------------------------------------------------
		// パラメータ取得
		//---------------------------------------------------------------------
		$code         = $request->input("code") ?? "0";
		$truckerCode	= $request->input("truckerCode");
		$companyCode	= $request->input("companyCode");

		$sql = "
			select
				TRUCKER_CODE
			from
				DRIVERS
			where
				1 = 1
			and CODE = ?
		";
		// コード
		$param[] = $code;

		if ($truckerCode != null && $truckerCode != "") {
			$sql = $sql . " and TRUCKER_CODE = ? ";
			$param[] = $truckerCode;
		}
		if ($companyCode != null && $companyCode != "") {
			$sql = $sql . " and COMPANY_CODE = ? ";
			$param[] = $companyCode;
		}

		$sql = $sql . "
			order by
				CODE,
				TRUCKER_CODE
		";

		$record = DB::select($sql, $param);
		$record = json_decode(json_encode($record), true);

		// 返却
		if (0 < count($record)) { $result = $record[0]["TRUCKER_CODE"]; }
		return $result;
	}

	//-------------------------------------------------------------------------
	// HCodesH
	// 取引区分(鑑)
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
	// 取引区分(明細)
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
	// 商品
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
	public function getItemName(Request $request){

		$sql = "";
		$param = [];
		$result = "";

		//---------------------------------------------------------------------
		// パラメータ取得
		//---------------------------------------------------------------------
		$code         		= $request->input("code") ?? "0";
		$hCode            = $request->input("hCode") ?? "0";
		$customerCode     = $request->input("customerCode");
		$deliveryCode     = $request->input("deliveryCode");
		$supplierCode     = $request->input("supplierCode");

		$sql = "
			select
				NAME
			from
				ITEMS
			where
				1 = 1
			and CODE = ?
		";
		$param[] = $code;

		// 売上or仕入で分岐する。
		if ($hCode == 1 || $hCode == 4) {
			// 得意先別納入先別マスタ
			$sql += "
				and CODE in (
					select distinct
						ITEM_CODE
					from
						ITEMS_CUSTOMER
					where
						1 = 1
			";
			if ($customerCode != null && $customerCode != "") {
				$sql += " and CUSTOMER_CODE = ? ";
				$param[] = $customerCode;
			}
			if ($deliveryCode != null && $deliveryCode != "") {
				$sql += " and (DELIVERY_CODE = ? or DELIVERY_CODE is null) ";
				$param[] = $deliveryCode;
			}
			$sql += "
				)
			";
		} else if ($hCode != 1 && $hCode != 4) {
			// 仕入先別マスタ
			$sql += "
				and CODE in (
					select distinct
						ITEM_CODE
					from
						ITEMS_SUPPLIER
					where
						1 = 1
			";
			if ($supplierCode != null && $supplierCode != "") {
				$sql += " and SUPPLIER_CODE = ? ";
				$param[] = $customerCode;
			}
			$sql += "
				)
			";
		}
		$sql += "
			order by
				SORT_ORDER
		";

		$record = DB::select($sql, $param);
		$record = json_decode(json_encode($record), true);

		// 返却
		if (0 < count($record)) { $result = $record[0]["NAME"]; }
		return $result;
	}
	//---------------------------------------------------------------------
	// 商品名以外のデータが必要な場合はこっち
	//---------------------------------------------------------------------
	public function getItemData(Request $request){

		$sql = "";
		$param = [];
		$result = "";

		//---------------------------------------------------------------------
		// パラメータ取得
		//---------------------------------------------------------------------
		$code         		= $request->input("code") ?? "0";
		$hCode            = $request->input("hCode") ?? "0";
		$customerCode     = $request->input("customerCode");
		$deliveryCode     = $request->input("deliveryCode");
		$supplierCode     = $request->input("supplierCode");

		$sql = "
			select
				CODE,
				NAME,
				HNAME,
				SORT_ORDER,
				WEIGHT,
				QTY_PER_CTN,
				UNIT,
				RATE1,
				RATE2,
				RATE3,
				GCODE1,
				GCODE2,
				GCODE3,
				GNAME1,
				GNAME2,
				GNAME3,
				STEPS_CODE1,
				STEPS_CODE2,
				STEPS_CODE3,
				STEPS1,
				STEPS2,
				STEPS3,
				HEIGHT,
				MARGIN,
				IMAGE,
				ON_NOT_STOCK,
				ON_PRINT,
				ON_NOT_USE,
				ON_IMAGE,
				ON_KEEP,
				COMPANY_CODE,
				COMPANY_NAME,
				WAREHOUSE_CODE,
				WAREHOUSE_NAME
				SUPPLIER,
				PROPER,
				ORDER_FLG,
				MEMO
			from
				ITEMS
			where
				1 = 1
			and CODE = ?
		";
		$param[] = $code;

		// 売上or仕入で分岐する。
		if ($hCode == 1 || $hCode == 4) {
			// 得意先別納入先別マスタ
			$sql = $sql . "
				and CODE in (
					select distinct
						ITEM_CODE
					from
						ITEMS_CUSTOMER
					where
						1 = 1
			";
			if ($customerCode != null && $customerCode != "") {
				$sql = $sql . " and CUSTOMER_CODE = ? ";
				$param[] = $customerCode;
			}
			if ($deliveryCode != null && $deliveryCode != "") {
				$sql = $sql . " and (DELIVERY_CODE = ? or DELIVERY_CODE is null) ";
				$param[] = $deliveryCode;
			}
			$sql = $sql . "
				)
			";
		} else if ($hCode != 1 && $hCode != 4) {
			// 仕入先別マスタ
			$sql = $sql . "
				and CODE in (
					select distinct
						ITEM_CODE
					from
						ITEMS_SUPPLIER
					where
						1 = 1
			";
			if ($supplierCode != null && $supplierCode != "") {
				$sql = $sql . " and SUPPLIER_CODE = ? ";
				$param[] = $supplierCode;
			}
			$sql = $sql . "
				)
			";
		}
		$sql = $sql . "
			order by
				SORT_ORDER
		";

		$record = DB::select($sql, $param);
		$record = json_decode(json_encode($record), true);

		// 返却
		if (0 < count($record)) { $result = $record[0]; }
		return $result;
	}

	//-------------------------------------------------------------------------
	// getOffices
	// 営業所
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
	public function getOfficeName(Request $request){

		$sql = "";
		$param = [];
		$result = "";

		//---------------------------------------------------------------------
		// パラメータ取得
		//---------------------------------------------------------------------
		$code     = $request->input("code") ?? "0";

		$sql = "
			select
				NAME
			from
				OFFICES
			where
				1 = 1
			and CODE
			order by
				CODE
		";

		// コード
		$param[] = $code;

		$record = DB::select($sql, $param);
		$record = json_decode(json_encode($record), true);

		// 返却
		if (0 < count($record)) { $result = $record[0]["NAME"]; }
		return $result;
	}

	//-------------------------------------------------------------------------
	// Places
	// 置場
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
	public function getPlaceName(Request $request){

		$sql = "";
		$param = [];
		$result = "";

		//---------------------------------------------------------------------
		// パラメータ取得
		//---------------------------------------------------------------------
		$code         		= $request->input("code") ?? "0";

		$sql = "
			select
				NAME
			from
				PLACES
			where
				1 = 1
			and CODE = ?
			order by
				CODE
		";

		// コード
		$param[] = $code;

		$record = DB::select($sql, $param);
		$record = json_decode(json_encode($record), true);

		// 返却
		if (0 < count($record)) { $result = $record[0]["NAME"]; }
		return $result;
	}

	//-------------------------------------------------------------------------
	// Remarks
	// 備考
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
	// Suppliers
	// 仕入先
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
		$suppliers = $query->select('CODE','NAME','NAME1')->get();

		// 返却
		return $suppliers;
	}
	public function getSupplierName(Request $request){

		$sql = "";
		$param = [];
		$result = "";

		//---------------------------------------------------------------------
		// パラメータ取得
		//---------------------------------------------------------------------
		$code         = $request->input("code") ?? "0";

		$sql = "
			select
				NAME
			from
				SUPPLIERS
			where
				1 = 1
			and CODE = ?
			order by
				CODE
		";

		// コード
		$param[] = $code;

		$record = DB::select($sql, $param);
		$record = json_decode(json_encode($record), true);

		// 返却
		if (0 < count($record)) { $result = $record[0]["NAME"]; }
		return $result;
	}

	//-------------------------------------------------------------------------
	// Truckers
	// 運送会社
	// 
	//-------------------------------------------------------------------------
	public function getTruckerName(Request $request){

		$sql = "";
		$param = [];
		$result = "";

		//---------------------------------------------------------------------
		// パラメータ取得
		//---------------------------------------------------------------------
		$code         = $request->input("code") ?? "0";
		$companyCode	= $request->input("companyCode");

		$sql = "
			select
				NAME
			from
				TRUCKERS
			where
				1 = 1
			and CODE = ?
		";
		// コード
		$param[] = $code;
	
		if ($companyCode != null && $companyCode != "") {
			$sql = $sql . " and COMPANY_CODE = ? ";
			$param[] = $companyCode;
		}

		$sql = $sql . "
			order by
				CODE
		";
		
		$record = DB::select($sql, $param);
		$record = json_decode(json_encode($record), true);

		// 返却
		if (0 < count($record)) { $result = $record[0]["NAME"]; }
		return $result;
	}

	//-------------------------------------------------------------------------
	// Users
	// 運転手+受注者
	// 
	//-------------------------------------------------------------------------
	public function getUsers(Request $request){
		// return users::whereNotNull('CODE')->orderBy('CODE')->get();
		return users::whereNotNull('CODE')->orderBy('CODE')->select('CODE', 'NAME')->get();
	}

	//-------------------------------------------------------------------------
	// Warehouses
	// 倉庫
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
		$warehouses = $query->select('CODE','NAME','NAME1')->get();

		// 返却
		return $warehouses;
	}
	public function getWarehouseName(Request $request){

		$sql = "";
		$param = [];
		$result = "";

		//---------------------------------------------------------------------
		// パラメータ取得
		//---------------------------------------------------------------------
		$code         = $request->input("code") ?? "0";

		$sql = "
			select
				NAME
			from
				WAREHOUSES
			where
				1 = 1
			and CODE = ?
			order by
				CODE
		";

		// コード
		$param[] = $code;

		$record = DB::select($sql, $param);
		$record = json_decode(json_encode($record), true);

		// 返却
		if (0 < count($record)) { $result = $record[0]["NAME"]; }
		return $result;
	}
}
