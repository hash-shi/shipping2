<?php
namespace App\Validate\Base;

abstract class ValidateDefinitionsBase {

    // 入力値チェック定義
    abstract public function getTargets(Request $request, $action);
    abstract public function getRules(Request $request, $action);
    abstract public function getMessages(Request $request, $action);
    abstract public function getAttributes(Request $request, $action);

    //=========================================================================
    //
    // Laravelが望む形で返却する為のヘルパー関数
    //
    //=========================================================================
    protected function make($array, $targets){
        $result = null;
        for ($count = 0 ; $count < count($targets); $count++) {
            if ($targets[$count]){
                $key            = $targets[$count];
            }
            if ($result == null){
                if (array_key_exists($key, $array)){
                    $result     = $array[$key];
                }
            } else {
                if (array_key_exists($key, $array)){
                    $result     = array_merge_recursive($result, $array[$key]);
                }
            }
        }
        if ($result == null){ $result = []; }
        return $result;
    }

    //=========================================================================
    //
    // Laravelが望む形の配列に定義を追加する
    //
    //=========================================================================
    protected function add($array, $addArray){
        if ($array == null){
            $array = $addArray;
        } else {
            $array = array_merge_recursive($array, $addArray);
        }
        return $array;
    }

    //=========================================================================
    //
    // Laravelが望む形で空配列を返却する
    //
    //=========================================================================
    protected function empty(){
        return [];
    }
}
