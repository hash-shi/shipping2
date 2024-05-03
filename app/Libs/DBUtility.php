<?php
namespace App\Libs;

class DBUtility {

    //-------------------------------------------------------------------------
    // 
    // DBコネクションの取得
    // 
    //-------------------------------------------------------------------------
    public static function getCon(){
        $serverName = config("app.SQLSERVER_HOST");
        $connectionOptions = array(
            "Database"  => config("app.SQLSERVER_DATABASE"),
            "Uid"       => config("app.SQLSERVER_USERNAME"),
            "PWD"       => config("app.SQLSERVER_PASSWORD")
        );

        $conn = \sqlsrv_connect($serverName, $connectionOptions);
        if(!$conn){
            // abort(500, "データベース接続に失敗しました。");
            DBUtility::errorSQLServer();
            return null;
        }
        return $conn;
    }

    //-------------------------------------------------------------------------
    // 
    // SQLエラー発生時に適切にエラーを500エラーとして返す
    // 
    //-------------------------------------------------------------------------
    public static function errorSQLServer(){
        $errorMessage = "";
        if( ($errors = sqlsrv_errors() ) != null) {
            foreach( $errors as $error ) {
                $sqlstate   = "SQLSTATE: ".mb_convert_encoding ($error[ 'SQLSTATE'], "UTF-8", "Windows-31J");
                $code       = "code: ".mb_convert_encoding ($error[ 'code'], "UTF-8", "Windows-31J");
                $message    = "message: ".mb_convert_encoding ($error[ 'message'], "UTF-8", "Windows-31J");
                $errorMessage .= $sqlstate."|".$code."|".$message."\n";
            }            
        }
        abort(500, "SQLServer\n".$errorMessage);
    }

    //-------------------------------------------------------------------------
    // 
    // 商品マスタのカラム一覧
    // (共通的に使用する必要があったので、外だしとして定義)
    // 
    //-------------------------------------------------------------------------
    public static function getItemSelectColumnStr(){
        return "CODE, NAME, HNAME, WEIGHT, SORT_ORDER, QTY_PER_CTN, UNIT, GCODE1, GNAME1, GCODE2, GNAME2, GCODE3, GNAME3, IMAGE, ON_NOT_STOCK, ON_PRINT, ON_NOT_USE, ON_IMAGE, ON_KEEP, COMPANY_CODE, COMPANY_NAME, WAREHOUSE_CODE, WAREHOUSE_NAME, SUPPLIER, PROPER, ORDER_FLG, MEMO, RATE1, RATE2, RATE3";
    }

    //-------------------------------------------------------------------------
    // 
    // 商品マスタのrowを適切に連想配列に変換する処理
    // (共通的に使用する必要があったので、外だしとして定義)
    // 
    //-------------------------------------------------------------------------
    public static function getItemRow2Array($row){
        $item = array(
            "CODE"				=> mb_convert_encoding ($row["CODE"], "UTF-8", "Windows-31J")
           ,"NAME"				=> mb_convert_encoding ($row["NAME"], "UTF-8", "Windows-31J")
           ,"HNAME"			    => mb_convert_encoding ($row["HNAME"], "UTF-8", "Windows-31J")
           ,"WEIGHT"			=> mb_convert_encoding ($row["WEIGHT"], "UTF-8", "Windows-31J")
           ,"SORT_ORDER"		=> $row["SORT_ORDER"]
           ,"QTY_PER_CTN"		=> $row["QTY_PER_CTN"]
           ,"UNIT"				=> mb_convert_encoding ($row["UNIT"], "UTF-8", "Windows-31J")
           ,"GCODE1"			=> mb_convert_encoding ($row["GCODE1"], "UTF-8", "Windows-31J")
           ,"GNAME1"			=> mb_convert_encoding ($row["GNAME1"], "UTF-8", "Windows-31J")
           ,"GCODE2"			=> mb_convert_encoding ($row["GCODE2"], "UTF-8", "Windows-31J")
           ,"GNAME2"			=> mb_convert_encoding ($row["GNAME2"], "UTF-8", "Windows-31J")
           ,"GCODE3"			=> mb_convert_encoding ($row["GCODE3"], "UTF-8", "Windows-31J")
           ,"GNAME3"			=> mb_convert_encoding ($row["GNAME3"], "UTF-8", "Windows-31J")
           ,"IMAGE"			    => mb_convert_encoding ($row["IMAGE"], "UTF-8", "Windows-31J")
           ,"ON_NOT_STOCK"		=> $row["ON_NOT_STOCK"]
           ,"ON_PRINT"			=> $row["ON_PRINT"]
           ,"ON_NOT_USE"		=> $row["ON_NOT_USE"]
           ,"ON_IMAGE"			=> $row["ON_IMAGE"]
           ,"ON_KEEP"			=> $row["ON_KEEP"]
           ,"COMPANY_CODE"		=> mb_convert_encoding ($row["COMPANY_CODE"], "UTF-8", "Windows-31J")
           ,"COMPANY_NAME"		=> mb_convert_encoding ($row["COMPANY_NAME"], "UTF-8", "Windows-31J")
           ,"WAREHOUSE_CODE"	=> mb_convert_encoding ($row["WAREHOUSE_CODE"], "UTF-8", "Windows-31J")
           ,"WAREHOUSE_NAME"	=> mb_convert_encoding ($row["WAREHOUSE_NAME"], "UTF-8", "Windows-31J")
           ,"SUPPLIER"			=> mb_convert_encoding ($row["SUPPLIER"], "UTF-8", "Windows-31J")
           ,"PROPER"			=> $row["PROPER"]
           ,"ORDER_FLG"		    => $row["ORDER_FLG"]
           ,"MEMO"				=> mb_convert_encoding ($row["MEMO"], "UTF-8", "Windows-31J")
           ,"RATE1"             => $row["RATE1"]
           ,"RATE2"             => $row["RATE2"]
           ,"RATE3"             => $row["RATE3"]
        );
        return $item;
    }
}
