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
        'RNO' => 'int',
        'ORDER_NO' => 'string',
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
    ];

    //-------------------------------------------------------------------------
    // リレーション定義
    //-------------------------------------------------------------------------
    Public function items_rel() {
        return  $this->hasOne(items::class, 'CODE', 'ITEM_CODE');
    }

    // use HasFactory;
}
