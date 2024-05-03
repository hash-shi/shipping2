<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use App\Libs\DBUtility;

class ValidateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //=====================================================================
        //
        // OrderNoの重複チェック
        //
        //=====================================================================
        //---------------------------------------------------------------------
        // OrderNoの重複チェック
        //---------------------------------------------------------------------
        Validator::extend('duplicateOrderNo', function ($attribute, $value, $parameters, $validator) {
            
            //---------------------------------------------------------------------
            // コネクション取得
            //---------------------------------------------------------------------
            $con = DBUtility::getCon();

            //---------------------------------------------------------------------
            // 存在チェック
            //---------------------------------------------------------------------
            $count = 0;
            $sql = "SELECT COUNT(*) as CNT FROM SIH WHERE ORDER_NO = ?";
            $stmt = sqlsrv_prepare($con, $sql, array(mb_convert_encoding ($value, "Windows-31J", "UTF-8")));
            sqlsrv_execute($stmt);
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {
                $count = $row["CNT"];
            }

            //---------------------------------------------------------------------
            // 結果返却
            //---------------------------------------------------------------------
            if ($count == 0 ){ return true; }
            return false;
        });
        Validator::replacer('duplicateOrderNo', function ($message, $attribute, $rule, $parameters, $validator) {
            return "指定された受注No.は既に存在します。";
        });
    }
}
