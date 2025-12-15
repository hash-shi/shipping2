<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sid extends Model
{
    protected $table            = 'SID';
    public $incrementing        = false;
    public $keyType             = "string";
    public $timestamps          = false;
    protected $guarded          = [];

    protected $casts = [
        'SIH_ID' => 'int',
        // 'ORDER_NO' => 'string',
        'RNO' => 'int',
        'HCODE' => 'string',
        'LA' => 'int',
        'ITEM_CODE' => 'string',
        'ITEM_NAME' => 'string',
        'QTY_PER_CTN' => 'int',
        'QTY_CTN' => 'int',
        'QTY' => 'int',
        'QTY_CTN2' => 'double',
        'QTY2' => 'double',
        'LOADING_PLACE_CODE' => 'string',
        'LOADING_PLACE_NAME' => 'string',
        'REMARK1' => 'string',
        'REMARK2' => 'string',
        'QCODE' => 'int',
    ];

    //-------------------------------------------------------------------------
    // リレーション定義
    //-------------------------------------------------------------------------
    Public function items_rel() {
        return  $this->hasOne(items::class, 'CODE', 'ITEM_CODE');
    }
    Public function qcodes_rel() {
        return  $this->hasOne(qcodes::class, 'CODE', 'QCODE');
    }

    //-------------------------------------------------------------------------
    // 連想配列追加定義
    // リレーション定義で取得したデータを、本データと同列に扱いたい場合は
    // ここの連想配列に定義してください
    //-------------------------------------------------------------------------
    Public static function syncRelationInfo(){
        return array(
              'QNAME'=>'qcodes_rel:NAME'
        );
    }

    // use HasFactory;
}
