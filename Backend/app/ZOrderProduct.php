<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\BaseModel;

class ZOrderProduct extends BaseModel
{
    protected $guarded = [];

    protected $table = 'z_order_products';

    public $timestamps = true;
}
