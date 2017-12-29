<?php
/**
 * 验证登陆
 */
namespace Home\Controller;
use Think\Controller;
use Common\Service\CookieService;
class RunController extends MainController {
	public function _initialize()
	{
		parent::_initialize();
		self::check_user_login();
	}
	
	/**
	 * 用户是否登陆
	 * @param 2017/11/2
	 */
	private static function check_user_login()
	{	
		#无登录状态下，首页
	  	if(CONTROLLER_NAME == 'Index' && ACTION_NAME == 'index'){
	  		$gourl = U('NoLogin/index');
			header('location:'.$gourl);
			die;
	  	}

		if(parent::$uid < 1){
			$gourl = U('Login/index',['reurl'=>urlencode(getFullUrl())]);
			header('location:'.$gourl);
			die;
		}
	}
     
}