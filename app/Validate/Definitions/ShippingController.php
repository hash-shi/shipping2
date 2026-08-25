<?php
namespace App\Validate\Definitions;
use App\Models\deliveries;
use App\Models\warehouses;
use App\Validate\Base\ValidateDefinitionsBase;

class ShippingController extends ValidateDefinitionsBase {

	private $ORDER_NO;
	private $sihRecord;
	private $sidRecords;

	//-----------------------------------------------------
	// 入力値チェックのルール定義
	//-----------------------------------------------------
	private $rules = array(
		"basic"     => [
		],
		// "create"  => [
		//     'ORDER_NO'                 => ['required', 'size:6', 'regex:/^[0-9]+$/'],
		//     'HCODE'                    => ['required'],
		//     'SHIP_DATE'                => ['required'],
		// ],
		// "copy"  => [
		//     'ORDER_NO'                 => ['required', 'size:6', 'regex:/^[0-9]+$/'],
		//     'SHIP_DATE'                => ['required'],
		// ],
		"susp"  => [
			'sihRecord.ORDER_NO'           => ['required'],
			'sihRecord.SHIP_DATE'          => ['required'],
			// 一時保存時は入力値チェックをスルーする。
			// 'sihRecord.OFFICE_OTHER_CODE'  => ['nullable', 'exists:offices,CODE'],
			// 'sihRecord.CUSTOMER_CODE'      => ['required_without_all:sihRecord.DELIVERY_CODE',  'nullable', 'exists:customers,CODE'],
			// 'sihRecord.DELIVERY_CODE'      => ['required_without_all:sihRecord.CUSTOMER_CODE',  'nullable'],
			// 'sihRecord.SUPPLIER_CODE'      => ['required_without_all:sihRecord.WAREHOUSE_CODE', 'nullable', 'exists:suppliers,CODE'],
			// 'sihRecord.WAREHOUSE_CODE'     => ['required_without_all:sihRecord.SUPPLIER_CODE',  'nullable', 'exists:warehouses,CODE'],
			// 'sihRecord.DRIVER_CODE'        => ['nullable', 'exists:drivers,CODE'],
			// 'sihRecord.TRUCKER_CODE'       => ['required_with:sihRecord.DRIVER_CODE', 'nullable', 'exists:truckers,CODE'],
			// 'sihRecord.FLIGHTS'            => ['required_with:sihRecord.DRIVER_CODE'],
			// 'sihRecord.OFFICE_FEE_CODE'    => ['required_if:sihRecord.HCODE,4,5,6'],

			// 'sidRecords.*.HCODE'           => ['required_with:sidRecords.*.ITEM_CODE', 'nullable', 'exists:hcodesD,CODE'],
			// 'sidRecords.*.ITEM_CODE'       => ['required_with:sidRecords.*.HCODE','required_with:sidRecords.*.QTY_PER_CTN','required_with:sidRecords.*.QTY_CTN',],
			// 'sidRecords.*.QTY_PER_CTN'     => ['required_with:sidRecords.*.ITEM_CODE'],
			// 'sidRecords.*.QTY_CTN'         => ['required_with:sidRecords.*.ITEM_CODE'],
		],
		"conf"  => [
			'sihRecord.ORDER_NO'           => ['required'],
			'sihRecord.SHIP_DATE'          => ['required'],

			'sihRecord.OFFICE_OTHER_CODE'  => ['nullable', 'exists:offices,CODE'],
			'sihRecord.CUSTOMER_CODE'      => ['required_without_all:sihRecord.DELIVERY_CODE',  'nullable', 'exists:customers,CODE'],
			'sihRecord.DELIVERY_CODE'      => ['required_without_all:sihRecord.CUSTOMER_CODE',  'nullable', 'different:sihRecord.WAREHOUSE_CODE'],
			'sihRecord.SUPPLIER_CODE'      => ['required_without_all:sihRecord.WAREHOUSE_CODE', 'nullable', 'exists:suppliers,CODE'],
			'sihRecord.WAREHOUSE_CODE'     => ['required_without_all:sihRecord.SUPPLIER_CODE',  'nullable', 'exists:warehouses,CODE', 'different:sihRecord.DELIVERY_CODE'],
			'sihRecord.DRIVER_CODE'        => ['nullable', 'exists:drivers,CODE'],
			'sihRecord.TRUCKER_CODE'       => ['required_with:sihRecord.DRIVER_CODE', 'nullable', 'exists:truckers,CODE'],
			'sihRecord.FLIGHTS'            => ['required_with:sihRecord.DRIVER_CODE'],
			'sihRecord.OFFICE_FEE_CODE'    => ['required_if:sihRecord.HCODE,4,5,6'],

			'sidRecords.*.HCODE'           => ['required_with:sidRecords.*.ITEM_CODE', 'nullable', 'exists:hcodesD,CODE'],
			'sidRecords.*.ITEM_CODE'       => ['required_with:sidRecords.*.HCODE','required_with:sidRecords.*.QTY_PER_CTN','required_with:sidRecords.*.QTY_CTN',],
			'sidRecords.*.QTY_PER_CTN'     => ['required_with:sidRecords.*.ITEM_CODE'],
			'sidRecords.*.QTY_CTN'         => ['required_with:sidRecords.*.ITEM_CODE'],
		],
		// 在庫調整用
		"susp_"  => [
			'sihRecord.ORDER_NO'           => ['required'],
			'sihRecord.SHIP_DATE'          => ['required'],
			// 一時保存時は入力値チェックをスルーする。
			// 'sihRecord.DELIVERY_CODE'      => ['nullable', 'exists:warehouses,CODE'],
			// 'sidRecords.*.HCODE'           => ['required_with:sidRecords.*.ITEM_CODE', 'nullable', 'exists:hcodesD,CODE'],
			// 'sidRecords.*.ITEM_CODE'       => ['required_with:sidRecords.*.HCODE','required_with:sidRecords.*.QTY_PER_CTN','required_with:sidRecords.*.QTY_CTN',],
			// 'sidRecords.*.QTY_PER_CTN'     => ['required_with:sidRecords.*.ITEM_CODE'],
			// 'sidRecords.*.QTY_CTN'         => ['required_with:sidRecords.*.ITEM_CODE'],
		],
		// 在庫調整用
		"conf_"  => [
			'sihRecord.ORDER_NO'           => ['required'],
			'sihRecord.SHIP_DATE'          => ['required'],
			'sihRecord.DELIVERY_CODE'      => ['nullable', 'exists:warehouses,CODE'],
			'sidRecords.*.HCODE'           => ['required_with:sidRecords.*.ITEM_CODE', 'nullable', 'exists:hcodesD,CODE'],
			'sidRecords.*.ITEM_CODE'       => ['required_with:sidRecords.*.HCODE','required_with:sidRecords.*.QTY_PER_CTN','required_with:sidRecords.*.QTY_CTN',],
			'sidRecords.*.QTY_PER_CTN'     => ['required_with:sidRecords.*.ITEM_CODE'],
			'sidRecords.*.QTY_CTN'         => ['required_with:sidRecords.*.ITEM_CODE'],
		],
		"exis" => [
			'ORDER_NO'                     => ['required', 'numeric', 'min:1', 'max:999998'],
		],
	);

	//-----------------------------------------------------
	// 入力値チェックのメッセージ定義
	//-----------------------------------------------------
	private $messages = array(
		"basic"     => [
			"sihRecord.OFFICE_FEE_CODE.required_if" => '取区が「融通」の場合、:attributeは必ず指定してください。',
		],
	);

	//-----------------------------------------------------
	// 入力値チェックの項目名定義
	//-----------------------------------------------------
	private $attributes = array(
		"basic"    => [
			'ORDER_NO'                      => '受注No.',
			'HCODE'                         => '取区',
			'SHIP_DATE'                     => '出荷日',
			'sihRecord.ORDER_NO'            => '受注No.',
			'sihRecord.SHIP_DATE'           => '出荷日',

			'sihRecord.CUSTOMER_CODE'       => '得意先', 
			// 'sihRecord.DELIVERY_CODE'       => '納入先', 
			'sihRecord.DELIVERY_CODE'       => '納/倉', 
			'sihRecord.SUPPLIER_CODE'       => '仕入先',
			'sihRecord.WAREHOUSE_CODE'      => '倉庫',
			'sihRecord.DRIVER_CODE'         => '運転手',
			'sihRecord.TRUCKER_CODE'        => '運送会社',
			'sihRecord.FLIGHTS'             => '便区分',
			'sihRecord.OFFICE_FEE_CODE'     => '運賃負担営業所',

			'sidRecords.*.HCODE'            => '区',
			'sidRecords.*.ITEM_CODE'        => '商品コード',
			'sidRecords.*.QTY_PER_CTN'      => '入数',
			'sidRecords.*.QTY_CTN'          => '予袋数',

		]
	);

	//=========================================================================
	// getTargets
	//
	//
	//
	//=========================================================================
	public function getTargets($request, $action){
		$params                     = array();
		$params                     = $request->all();
		return $params;
	}

	//=========================================================================
	// getRules
	//
	//
	//
	//=========================================================================
	public function getRules($request, $action){
		$rules  = $this->make($this->rules, ["basic", $action]);

		// 独自チェック
		// if ($action == "exis") {
		// 	$this->ORDER_NO = $request->input('ORDER_NO');
		// 	$rules  = $this->add($rules, ['ORDER_NO' => function($attribute, $value, $fail) {
		// 		// exists = 存在して入ればtrue はあるが not existsがないので手組する。
		// 		$ORDER_NO = sprintf('%06d', $this->ORDER_NO);
		// 		if (0 < sih::where('ORDER_NO', $ORDER_NO)->count()) {
		// 			$fail(':attribute' . ':' . $ORDER_NO . 'が存在しています。');
		// 		}
		// 	}]);
		// }

		// if ($action == "susp" || $action == "conf" || $action == "comp") {
		// 	$isNew = $request->input('isNew');
		// 	if ($isNew) {
		// 		$this->sihRecord = $request->input('sihRecord');
		// 		$rules  = $this->add($rules, ['sihRecord.ORDER_NO' => function($attribute, $value, $fail) {
		// 			// exists = 存在して入ればtrue はあるが not existsがないので手組する。
		// 			$ORDER_NO = sprintf('%06d', $this->sihRecord["ORDER_NO"]);
		// 			if (0 < sih::where('ORDER_NO', $ORDER_NO)->count()) {
		// 				$fail(':attribute' . ':' . $ORDER_NO . 'が存在しています。');
		// 			}
		// 		}]);
		// 	}
		// }

		// if ($action == "susp" || $action == "conf") {
		if ($action == "conf") {
			$this->sihRecord = $request->input('sihRecord');
			$this->sidRecords = $request->input('sidRecords');

			// 納/倉は条件によって参照テーブルが変わる為、独自チェック
			$rules  = $this->add($rules, ['sihRecord.DELIVERY_CODE' => function($attribute, $value, $fail) {
				$DELIVERY_CODE = $this->sihRecord["DELIVERY_CODE"];
				$HCODE = $this->sihRecord["HCODE"];
				if ($HCODE==1 || $HCODE==4) {
					$deliveries = deliveries::where('CODE', $DELIVERY_CODE)->get();
					if (count($deliveries) == 0) {
						$fail('選択された:attributeは正しくありません。');
					}
				} else if ($HCODE!=1 && $HCODE!=4) {
					$warehouses = warehouses::where('CODE', $DELIVERY_CODE)->get();
					if (count($warehouses) == 0) {
						$fail('選択された:attributeは正しくありません。');
					}
				}
			}]);

			// 登録時に入力済み明細が0行の場合エラー
			$rules  = $this->add($rules, ['sihRecord.ORDER_NO' => function($attribute, $value, $fail) {
				foreach($this->sidRecords as $record) {
					// とりあえず区と商品コードが入力済みのデータが1行でもあればいい。
					if (($record["HCODE"] != null && $record["HCODE"] != "") && ($record["ITEM_CODE"] != null && $record["ITEM_CODE"] != "")) {
						return false;
					}
				}
				$fail('明細が入力されていません。');
			}]);

			// 取引区分別必須入力チェック
			// 明細の取引区分を参照して鑑の必須項目を確認する。
			$rules  = $this->add($rules, ['sihRecord.ORDER_NO' => function($attribute, $value, $fail) {
				foreach($this->sidRecords as $record) {

					if (in_array($record["HCODE"], array("11","12","31","34","36","37","41","44"))) {
						// 11,12,31,34,36,37,41,44 → 得意先,仕入先 必須
						$CUSTOMER_CODE = $this->sihRecord["CUSTOMER_CODE"];
						$SUPPLIER_CODE = $this->sihRecord["SUPPLIER_CODE"];
						if (($CUSTOMER_CODE == null || $CUSTOMER_CODE == "") || ($SUPPLIER_CODE == null || $SUPPLIER_CODE == "")) {
							$fail('取引区分が' . $record["HCODE"] . 'の場合は、得意先と仕入先を指定してください。');
						}
					}
					else if (in_array($record["HCODE"], array("15","16","35","38","45"))) {
						// 15,16,35,38,45 → 得意先,出荷倉庫
						$CUSTOMER_CODE = $this->sihRecord["CUSTOMER_CODE"];
						$WAREHOUSE_CODE = $this->sihRecord["WAREHOUSE_CODE"];
						if (($CUSTOMER_CODE == null || $CUSTOMER_CODE == "") || ($WAREHOUSE_CODE == null || $WAREHOUSE_CODE == "")) {
							$fail('取引区分が' . $record["HCODE"] . 'の場合は、得意先と出庫倉庫を指定してください。');
						}
					}
					else if (in_array($record["HCODE"], array("10","13","14"))) {
						// 10,13,14 → 仕入先,納入倉庫
						$SUPPLIER_CODE = $this->sihRecord["SUPPLIER_CODE"];
						$DELIVERY_CODE = $this->sihRecord["DELIVERY_CODE"];
						if (($SUPPLIER_CODE == null || $SUPPLIER_CODE == "") || ($DELIVERY_CODE == null || $DELIVERY_CODE == "")) {
							$fail('取引区分が' . $record["HCODE"] . 'の場合は、仕入先と納入倉庫を指定してください。');
						}
					}
					else if (in_array($record["HCODE"], array("51"))) {
						// 51 → 倉庫
						$DELIVERY_CODE = $this->sihRecord["DELIVERY_CODE"];
						$WAREHOUSE_CODE = $this->sihRecord["WAREHOUSE_CODE"];
						if (($DELIVERY_CODE == null || $DELIVERY_CODE == "") || ($WAREHOUSE_CODE == null || $WAREHOUSE_CODE == "")) {
							$fail('取引区分が' . $record["HCODE"] . 'の場合は、倉庫を指定してください。');
						}
					}
				}
			}]);

			// 混在チェック
			// 20260722_取引区分が混合してはいけない(例:取引区分15選択時、15以外は選択できない※サンプル品は除外)
			// // 在庫調整以外で数量+-のデータが混在してはいけない
			// // ただし、サンプル品の場合は混在してもよい
			// $rules  = $this->add($rules, ['sihRecord.ORDER_NO' => function($attribute, $value, $fail) {
			// 	$plus = 0;
			// 	$minus = 0;
			// 	foreach($this->sidRecords as $record) {
			// 		// サンプル品は除外する
			// 		if ($record["SAMPLE"] != "1") {
			// 			if (0 < $record["QTY"]) { $plus++; }
			// 			if (0 > $record["QTY"]) { $minus++; }
			// 		}
			// 	}
			// 	if (0 < $plus && 0 < $minus) {
			// 		$fail('赤伝/黒伝が混在しています。');
			// 	}
			// }]);
			$rules  = $this->add($rules, ['sihRecord.ORDER_NO' => function($attribute, $value, $fail) {
				$HCODE = null;
				foreach($this->sidRecords as $record) {
					if ($record["HCODE"] != null && $record["HCODE"] != "") {
						if ($HCODE == null) {
							$HCODE = $record["HCODE"];
						} else {
							// サンプル品以外で取引区分が異なる商品がある場合、エラーにする。
							if ($HCODE != $record["HCODE"] && $record["SAMPLE"] != "1" ) {
								$fail('赤伝/黒伝が混在しています。');
							}
						}
					}
				}
			}]);
			// 20260722-------------------------------------------------------------------------------------------

		}

		return $rules; 
	}

	//=========================================================================
	// getMessages
	//
	//
	//
	//=========================================================================
	public function getMessages($request, $action){
		return  $this->make($this->messages, ["basic", $action]);
	}

	//=========================================================================
	// getAttributes
	//
	//
	//
	//=========================================================================
	public function getAttributes($request, $action){
		return $this->make($this->attributes, ["basic", $action]);
	}
}
