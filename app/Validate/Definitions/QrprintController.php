<?php
namespace App\Validate\Definitions;

use App\Validate\Base\ValidateDefinitionsBase;

class QrprintController extends ValidateDefinitionsBase {

    //-----------------------------------------------------
    // 入力値チェックのルール定義
    //-----------------------------------------------------
    private $rules = array(
        "basic"     => [
        ],
        "regist"  => [
            'printDate'     => ['required', 'date'],
            'supplierCode'  => ['required_without_all:warehouseCode'],
            'warehouseCode' => ['required_without_all:supplierCode'],
            'itemCode'      => ['required'],
            'qtyPer'        => ['required', 'numeric', 'between:1,999999'],
            'pattern'       => ['required'],
            'numSheet'      => ['required', 'numeric', 'between:1,999'],
            'startNum'      => ['required', 'numeric', 'between:1,12'],
        ],
        "rePrint"   => [
            'startNum'      => ['required', 'numeric', 'between:1,12'],
            'rePrintIds'    => ['array', 'min:1'],
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
            'printDate'     => '年月日',
            'supplierCode'  => '仕入先コード',
            'warehouseCode' => '倉庫コード',
            'itemCode'      => '商品コード',
            'qtyPer'        => '入数',
            'pattern'       => '形態',
            'numSheet'      => '枚数',
            'startNum'      => '開始位置',
            'rePrintIds'    => '再発行対象',
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
        return $this->make($this->rules, ["basic", $action]);
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
