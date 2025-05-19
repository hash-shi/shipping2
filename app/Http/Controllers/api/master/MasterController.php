<?php
namespace App\Http\Controllers\api\master;

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
	// Users
	// 
	// 
	//-------------------------------------------------------------------------
	public function getUsers(Request $request){

		$sql = "
			select
				CODE
				NAME,
			from
				users
			where
				1 = 1
				and CODE is not null
			order by
				CODE
		";

		$record = DB::select($sql);
		return json_decode(json_encode($record), true);
	}

	//-------------------------------------------------------------------------
	// Offices
	// 営業所
	// 
	//-------------------------------------------------------------------------
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
	// Customers
	// 得意先
	// 
	//-------------------------------------------------------------------------
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
	// Suppliers
	// 仕入先
	// 
	//-------------------------------------------------------------------------
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
	// Warehouses
	// 倉庫
	// 
	//-------------------------------------------------------------------------
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
	// Drivers
	// 運転手
	// 
	//-------------------------------------------------------------------------
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
	// Items
	// 商品
	// 
	//-------------------------------------------------------------------------
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
				$param[] = $customerCode;
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
	// Places
	// 置場
	// 
	//-------------------------------------------------------------------------
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
}
