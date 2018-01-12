<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\BaseModel;

class ZStore extends BaseModel
{
	protected $guarded = [];

    protected $table = 'z_stores';

    public $timestamps = true;

    public function save(array $options = [])
    {
        // 设置默认值
        if (!$this->shop_sn) {
            $this->shop_sn = '';
        }

        parent::save();
    }
}
