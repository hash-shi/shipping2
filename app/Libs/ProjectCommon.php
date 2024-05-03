<?php
namespace App\Libs;
use Illuminate\Support\Facades\Schema;
use DB;

class ProjectCommon {

    //-------------------------------------------------------------------------
    // Eloquentで定義されているリレーションを実行する
    // リレーションメソッドには、必ず末尾に_relを付与すること
    // 
    // 
    // 
    //-------------------------------------------------------------------------
    public static function getRelation($TABLE_CLASS, $eloquentObject){
        // メソッド一覧からリレーションが存在しているかチェック
        $relationMethods = [];

        // 当該クラスのリレーションメソッド一覧の取得
        $methods         = get_class_methods($TABLE_CLASS);
        foreach($methods as $method){
            if (strrpos($method, "_rel") === strlen($method) - strlen("_rel")){
                $relationMethods[] = $method;
            }
        }

        // リレーションメソッドをwithでコールして、全てのデータを連結させる
        if (count($relationMethods) != 0){
            foreach($relationMethods as $relationMethod){
                $eloquentObject = $eloquentObject->with($relationMethod);
            }
        }
        return $eloquentObject;
    }

    //-------------------------------------------------------------------------
    // 
    // 
    // 
    // 
    // 
    //-------------------------------------------------------------------------
    public static function syncRelation($TABLE_CLASS, $results){

        if ($results === null){ return $results; } 

        $hasSyncMethod   = false;
        $methods         = get_class_methods($TABLE_CLASS);
        foreach($methods as $method){
            if ($method === "syncRelationInfo"){ $hasSyncMethod = true; break; }
        }

        // リレーションシンクメソッドを持っているか判断
        if ($hasSyncMethod){
            // 持っている場合は、まずはそれをコールしてリレーション内のデータのSync情報を取得する
            $syncRelationInfo       = $TABLE_CLASS::syncRelationInfo();

            // 結果が複数存在している場合は、全てに適用する
            // ただし、このメソッド自体、複数結果のものをコールすることは想定していない
            if (!ProjectCommon::is_hash($results)) {
                // 配列
                for ($count = 0 ; $count < count($results); $count++){
                    $results[$count] = ProjectCommon::syncRelationInner($syncRelationInfo, $results[$count]);
                }
            } else {
                // 連想配列
                $results = ProjectCommon::syncRelationInner($syncRelationInfo, $results);
            }
        }
        // 結果返却
        return $results;
    }

    //-------------------------------------------------------------------------
    // 
    // 
    // 
    // 
    // 
    //-------------------------------------------------------------------------
    public static function syncRelationInner($syncRelationInfo, $result){
        foreach ( $syncRelationInfo as $key => $value ) {
            $relName        = explode(":", $value)[0];
            $itemName       = explode(":", $value)[1];
            
            if ($result[$relName] == null) { 
                $result[$key] = null;
            } else {
                $result[$key]   = $result[$relName][$itemName];
            }

            // var_dump('$result[$relName]:' . $result[$relName]);
            // var_dump('$result[$relName][$itemName]:' . $result[$relName][$itemName]);
        }
        return $result;
    }

    //-------------------------------------------------------------------------
    // 配列か連想配列かを判断する
    // 
    // 
    // 
    // 
    //-------------------------------------------------------------------------
    public static function is_hash(&$array) {
        $i = 0;
        if ($array === null){ return false; }
        foreach($array as $k => $dummy) {
            if ( $k !== $i++ ) return true;
        }
        return false;
    }

    //-------------------------------------------------------------------------
    // DBに登録する際に必要となる項目を埋める関数
    // 
    // 
    // 
    // 
    //-------------------------------------------------------------------------
    public static function DBData($request, $tableName, $hashmap){

        // あくまでもテーブルにないカラムを削除するだけ

        // 空白項目は全てNULLにする
        foreach($hashmap as $key => $val){
            if ($val === ""){ $hashmap[$key] = null; }
        }

        //---------------------------------------------------------------------
        // 不要なカラムの削除
        //---------------------------------------------------------------------
        // カラム対象テーブルのカラム一覧を取得
        // $columns = DB::select("DESC ".$tableName);
        $columns = Schema::getColumnListing($tableName);

        // foreach($columns as $column){ $columnArray[] = $column->Field; }
        $columnArray = array();
        foreach($columns as $column){ $columnArray[] = $column; }

        // 削除対象カラム名を抽出
        $removeColumnNames = array();
        foreach($hashmap as $key => $val){
            if (!in_array($key, $columnArray)){
                $removeColumnNames[] = $key;
            }
        }

        // 削除対象カラムを削除
        for ($count = 0 ; $count < count($removeColumnNames) ; $count++){
            $removeColumnName = $removeColumnNames[$count];
            unset($hashmap[$removeColumnName]);
        }
        
        // データ登録用連想配列として返却
        return $hashmap;
    }

    //-------------------------------------------------------------------------
    // tableのカラム名を取得する。
    // テーブルの場合はSchema::getColumnListing()から取得できるが
    // ビューはできないため、こちらを使用する。
    // 
    // 
    //-------------------------------------------------------------------------
    public static function DBTableColumn($tableName) {
        $sqlTableColumn = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = ";
        return json_decode(json_encode(DB::select($sqlTableColumn . "'" . $tableName. "'")), true);
    }
}
