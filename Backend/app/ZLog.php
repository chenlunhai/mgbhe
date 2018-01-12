<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\BaseModel;

class ZLog extends BaseModel
{
    protected $guarded = [];

    protected $table = 'z_logs';

    public $timestamps = true;

    public function getPictureAttribute($value)
    {
        if ($value) {
            return config('voyager.log.picture_prefix') . $value;
        }

        return $value;
    }
}
