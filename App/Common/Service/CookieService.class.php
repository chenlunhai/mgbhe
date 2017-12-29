<?php
namespace Common\Service;
use Common\Service\CodeService;
class CookieService {
	static $setCookieTime = 3600*24*30;
 	public function unSetCookie(){
        session('shop_info',null);
        cookie('wl_uid',null);
    }
    public function setCookie($arr){
        $Code = new CodeService();
        $val  = $Code->authcode($arr[1],'ENCODE');
        cookie($arr[0],$val,self::$setCookieTime);
    }
    public function getCookie($str){
        $Code = new CodeService();
        $val  = cookie($str);
        return $Code->authcode($val,'DECODE');
    }
}