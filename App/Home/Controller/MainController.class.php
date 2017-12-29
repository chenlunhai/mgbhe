<?php
/**
 * 主入口
 */
namespace Home\Controller;
use Think\Controller;
use Common\Service\CookieService;
use Common\Service\CodeService;
class MainController extends Controller {
	public static $user_info;	#用户资料
	public static $uid;	#用户id
	public static $shop_info;	#店主信息
	public function _initialize(){
		 
		self::setUid(); #设置用户id
        self::setPid(); #设置链接带上推荐人
		self::setShopSn();	#设置无人超市店铺归属人信息
		self::setMyhzSn();	#设置无人售货机店铺归属人信息
	}
    
    private static function setUid()
    {
    	$CookieService = new CookieService();
		$uid 	= $CookieService->getCookie('wl_uid');
		 
		if($uid > 0){
			self::$uid = $uid;
		}
    }
    private static function setPid()
    {
       if(strpos($_SERVER['PATH_INFO'],'pid') === false && self::$uid > 0){
        header('location:'.U(CONTROLLER_NAME.'/'.ACTION_NAME,array_merge($_GET,['pid'=>self::$uid])));die;
       }
    }
    /**
     * 设置无人超市店铺归属人信息
     * @param 2017/11/9
     */
    private static function setShopSn()
    {
    	$shop = session('shop_info');

    	if(!empty($shop) && $shop['type'] == 5){
    		self::$shop_info = $shop;
    		return;
    	}
    	$shop_sn = I('get.shop_sn','');
    	if(empty($shop_sn)) return;

		$str = base64_decode($shop_sn);
 
		$CodeService = new CodeService();
		$code = $CodeService->authcode($str,'DECODE');
		if(empty($code)) return;

		$shop_info = M('shop_record')->where(['shop_sn'=>$code])->field('id,uid')->find();
		if(empty($shop_info)) return;
		$shop_info['type'] = 5;
		session('shop_info',$shop_info);
    	self::$shop_info = $shop_info;
    }
    /**
     * 设置无人售货机店铺归属人信息
     * @param 2017-12-9 14:47:09
     */
    private static function setMyhzSn()
    {
    	$shop = session('shop_info');

    	if(!empty($shop) && $shop['type'] == 4){
    		self::$shop_info = $shop;
    		return;
    	}
    	$bid = I('get.bid','');
    	if(empty($bid)) return;
 
		$shop_info = M('myhz')->where(['bid'=>$bid])->field('id,uid')->find();
		if(empty($shop_info)) return;
		$shop_info['type'] = 4;
		session('shop_info',$shop_info);
    	self::$shop_info = $shop_info;

    }
}