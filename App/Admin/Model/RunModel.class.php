<?php
namespace Admin\Model;
use Think\Model;

class RunModel extends Model{

	public static $admin_info;
	public function _initialize()
	{
		self::$admin_info = session('admin_info');	#管理员资料
	}


}