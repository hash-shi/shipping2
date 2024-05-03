<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class remarks extends Model
{
    protected $table            = 'REMARKS';
    public $incrementing        = false;
    public $keyType             = "string";
    public $timestamps          = false;
    protected $guarded          = [];

    // use HasFactory;
}
