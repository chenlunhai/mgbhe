<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

use App\BaseModel;
use App\ZStore;

class ZUser extends BaseModel
{
    protected $guarded = [];

    protected $table = 'z_users';

    public $timestamps = true;

    protected $dates = ['login_time'];

    public function save(array $options = [])
    {
        // 设置默认值
        if (!$this->login_time) {
            $this->login_time = Carbon::now()->getTimestamp();
        }
        if (!$this->login_ip) {
            $this->login_ip = request()->ip();
        }

        parent::save();
    }

    public function storeId()
    {
        return $this->belongsTo(ZStore::class, 'store_id', 'id');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = md5($value);
    }
}
