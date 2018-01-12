<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\BaseModel;

class ZProduct extends BaseModel
{
    protected $guarded = [];

    protected $table = 'z_products';

    public $timestamps = true;

    protected $dates = ['produce_time'];
}
