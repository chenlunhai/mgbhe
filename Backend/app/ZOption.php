<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\BaseModel;

class ZOption extends BaseModel
{
    protected $guarded = [];

    protected $table = 'z_options';

    public $timestamps = true;
}
