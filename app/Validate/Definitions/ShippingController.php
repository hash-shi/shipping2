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

			'sihRecord.OFFICE_OTHER_CODE'  => ['nullable', 'exists:offices,CODE'],
			'sihRecord.CUSTOMER_CODE'      => ['required_without_all:sihRecord.DELIVERY_CODE', 'nullable', 'exists:customers,CODE'],
			'sihRecord.DELIVERY_CODE'      => ['required_without_all:sihRecord.CUSTOMER_CODE', 'nullable'],
			'sihRecord.SUPPLIER_CODE'      => ['required_without_all:sihRecord.WAREHOUSE_CODE', 'nullable', 'exists:suppliers,CODE'],
			'sihRecord.WAREHOUSE_CODE'     => ['required_without_all:sihRecord.SUPPLIER_CODE', 'nullable', 'exists:warehouses,CODE'],
			'sihRecord.DRIVER_CODE'        => ['nullable', 'exists:drivers,CODE'],
			'sihRecord.TRUCKER_CODE'       => ['required_with:sihRecord.DRIVER_CODE', 'nullable', 'exists:truckers,CODE'],
			'sihRecord.FLIGHTS'            => ['required_with:sihRecord.DRIVER_CODE'],

			'sidRecords.*.HCODE'           => ['required_with:sidRecords.*.ITEM_CODE', 'nullable', 'exists:hcodesD,CODE'],
			'sidRecords.*.ITEM_CODE'       => ['required_with:sidRecords.*.HCODE','required_with:sidRecords.*.QTY_PER_CTN','required_with:sidRecords.*.QTY_CTN',],
			'sidRecords.*.QTY_PER_CTN'     => ['required_with:sidRecords.*.ITEM_CODE'],
			'sidRecords.*.QTY_CTN'         => ['required_with:sidRecords.*.ITEM_CODE'],
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
			
			'sidRecords.*.HCODE'           => ['required_with:sidRecords.*.ITEM_CODE', 'nullable', 'exists:hcodesD,CODE'],
			'sidRecords.*.ITEM_CODE'       => ['required_with:sidRecords.*.HCODE','required_with:sidRecords.*.QTY_PER_CTN','required_with:sidRecords.*.QTY_CTN',],
			'sidRecords.*.QTY_PER_CTN'     => ['required_with:sidRecords.*.ITEM_CODE'],
			'sidRecords.*.QTY_CTN'         => ['required_with:sidRecords.*.ITEM_CODE'],
		],
	);


	//-----------------------------------------------------
	// 入力値チェックのメッセージ定義
	//-----------------------------------------------------
	private $messages = array(
		"basic"     => [],
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
		if ($action == "susp" || $action == "conf") {
			// 納/倉は条件によって参照テーブルが変わる為、独自チェック
			$this->sihRecord = $request->input('sihRecord');
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
			$this->sidRecords = $request->input('sidRecords');
			$rules  = $this->add($rules, ['sihRecord.ORDER_NO' => function($attribute, $value, $fail) {
				foreach($this->sidRecords as $record) {
					// とりあえず区と商品コードが入力済みのデータが1行でもあればいい。
					if (($record["HCODE"] != null && $record["HCODE"] != "") && ($record["ITEM_CODE"] != null && $record["ITEM_CODE"] != "")) {
						return false;
					}
				}
				$fail('明細が入力されていません。');
			}]);
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
