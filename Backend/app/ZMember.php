<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

use App\BaseModel;

class ZMember extends BaseModel
{
    protected $guarded = [];

    protected $table = 'z_members';

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

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = md5($value);
    }
}
