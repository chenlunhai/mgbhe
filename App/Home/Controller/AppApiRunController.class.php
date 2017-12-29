<?php
/**
 * APP主类
 */
namespace Home\Controller;
use Think\Controller;

class AppApiRunController extends Controller {
	static $user_info;
	public function _initialize()
	{
		self::check_access_token();
	}
	/**
	 * 验证access_token
	 * @param 2017-12-12 14:30:14
	 */
	private static function check_access_token()
	{
		$access_token = I('post.access_token');
		$res = D('access_token')->check_access_token($access_token);
		if($res['status'] != 1)	exit(json_encode($res));
		
		self::$user_info = ['uid'=>$res['msg']];
	}

}