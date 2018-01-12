<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\BaseModel;

class ZProductLog extends BaseModel
{
    protected $guarded = [];

    protected $table = 'z_product_logs';

    public $timestamps = true;
}
