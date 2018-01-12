<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\BaseModel;

class ZOrder extends BaseModel
{
    protected $guarded = [];

    protected $table = 'z_orders';

    public $timestamps = true;
}
