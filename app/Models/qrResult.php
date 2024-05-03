<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class qrResult extends Model
{
    protected $table            = 'QR_RESULT';
    protected $primaryKey       = 'ID';
    public $incrementing        = false;
    public $keyType             = "string";
    public $timestamps          = false;
    protected $guarded          = [];
    // use HasFactory;

    //-------------------------------------------------------------------------
    // リレーション定義
    //-------------------------------------------------------------------------
    Public function supplier_rel() {
        return  $this->hasOne(suppliers::class, 'CODE', 'SUPPLIER_CODE');
    }
    Public function warehouse_rel() {
        return  $this->hasOne(warehouses::class, 'CODE', 'WAREHOUSE_CODE');
    }
    Public function items_rel() {
        return  $this->hasOne(items::class, 'CODE', 'ITEM_CODE');
    }
    
    //-------------------------------------------------------------------------
    // 連想配列追加定義
    // リレーション定義で取得したデータを、本データと同列に扱いたい場合は
    // ここの連想配列に定義してください
    //-------------------------------------------------------------------------
    Public static function syncRelationInfo(){
        return array(
              'SUPPLIER_NAME'=>'supplier_rel:NAME',
              'WAREHOUSE_NAME'=>'warehouse_rel:NAME',
              'ITEM_NAME'=>'items_rel:NAME',
            );
    }
}
