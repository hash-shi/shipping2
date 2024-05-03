<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sidResult extends Model
{
    protected $table            = 'SID_RESULT';
    public $incrementing        = false;
    public $keyType             = "string";
    public $timestamps          = false;
    protected $guarded          = [];
    // use HasFactory;
}
