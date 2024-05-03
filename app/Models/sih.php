<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sih extends Model
{
    // use HasFactory;

    protected $table            = 'SIH';
    protected $primaryKey       = 'SIH_ID';
    public $incrementing        = false;
    public $keyType             = "string";
    public $timestamps          = false;
    protected $guarded          = [];

    protected $casts = [
        'SIH_ID' => 'int',
        'ORDER_NO' => 'string',
        'HCODE' => 'int',
        'OFFICE_CODE' => 'string',
        'OFFICE_NAME' => 'string',
        'OFFICE_OTHER_CODE' => 'string',
        'OFFICE_OTHER_NAME' => 'string',
        'COMPANY_CODE' => 'string',
        'COMPANY_NAME' => 'string',
        // 'ORDER_DATE' => 'datetime',
        // 'ORDER_TIME' => 'datetime',
        // 'SHIP_DATE' => 'datetime',
        // 'DELIVERY_DATE' => 'datetime',
        'DELIVERY_AMPM' => 'int',
        // 'DELIVERY_TIME' => 'datetime',
        'KARI' => 'int',
        'ORDER_USER' => 'string',
        'ORDER2_USER' => 'string',
        'CUSTOMER_CODE' => 'string',
        'CUSTOMER_NAME' => 'string',
        'DELIVERY_CODE' => 'string',
        'DELIVERY_NAME' => 'string',
        'SUPPLIER_CODE' => 'string',
        'SUPPLIER_NAME' => 'string',
        'WAREHOUSE_CODE' => 'string',
        'WAREHOUSE_NAME' => 'string',
        'DRIVER_CODE' => 'string',
        'DRIVER_NAME' => 'string',
        'TRUCKER_CODE' => 'string',
        'TRUCKER_NAME' => 'string',
        'FLIGHTS' => 'string',
        'FEE' => 'int',
        'ADD_FEE' => 'int',
        'HIGHWAY_FEE' => 'int',
        'FEE_CLASS' => 'int',
        'CONTINUED_SHEET' => 'int',
        'ALL_SHEET' => 'int',
        'CURRENT_SHEET' => 'int',
        'LOADING_RATE' => 'int',
        'INVOICE_NOTE' => 'string',
        'DELIVERY_NOTE' => 'string',
        'TAG_NOTE' => 'string',
        // 'CONFIRM_DATE' => 'datetime',
        'STATUS' => 'int',
        // 'PRINT_DATE' => 'datetime',
        'PRINT_COUNT' => 'int',
        // 'COMPLETION_DATE' => 'datetime',
        // 'PRINT2_DATE' => 'datetime',
        'PRINT2_COUNT' => 'int',
        'CONFIRM_COUNT' => 'int',
    ];

    //-------------------------------------------------------------------------
    // リレーション定義
    //-------------------------------------------------------------------------
    Public function hCode_rel() {
        return  $this->hasOne(hcodesH::class, 'CODE', 'HCODE');
    }
    Public function sCode_rel() {
        return  $this->hasOne(status::class, 'id', 'STATUS');
    }
    Public function ooCode_rel() {
        return  $this->hasOne(offices::class, 'CODE', 'OFFICE_OTHER_CODE');
    }

    //-------------------------------------------------------------------------
    // 連想配列追加定義
    // リレーション定義で取得したデータを、本データと同列に扱いたい場合は
    // ここの連想配列に定義してください
    //-------------------------------------------------------------------------
    Public static function syncRelationInfo(){
        return array(
            'HNAME'=>'hCode_rel:NAME',
            'SNAME'=>'sCode_rel:name',
        );
    }
}
