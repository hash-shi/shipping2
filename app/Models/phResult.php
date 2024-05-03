<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class phResult extends Model
{
    protected $table            = 'PH_RESULT';
    protected $primaryKey       = 'ID';
    public $incrementing        = false;
    public $keyType             = "string";
    public $timestamps          = false;
    protected $guarded          = [];
    // use HasFactory;
}
