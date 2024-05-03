<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class calendar extends Model
{
    protected $table            = 'CALENDAR';
    protected $primaryKey       = 'CDATE';
    public $incrementing        = false;
    public $keyType             = "date";
    public $timestamps          = false;
    protected $guarded          = [];
    // use HasFactory;
}
