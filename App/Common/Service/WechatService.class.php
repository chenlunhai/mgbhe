<?php
/**
 * 微信操作类
 */
namespace Common\Service;
use Think\Model;
use Think\Exception;
class WechatService{
	private static $appid = 'wxdecaf62718ea0c2d';
	private static $appsec= '71ce4d0382cfc1625668f825a87cea4b';


	/**
	 * 微信网页授权获取code，scope：snsapi_base类型静默获取，只能获取到openid，snsapi_userinfo 需用户点确定可以获取到用户信息
	 * @param 2017-12-5 17:54:37
	 */
	public function get_code($type = 0)
	{
		$arr = ['snsapi_base','snsapi_userinfo'];
        $reurl = urlencode(getFullUrl());	#当前域名地址
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.self::$appid.'&redirect_uri='.$reurl.'&response_type=code&scope='.$arr[$type].'&state=STATE#wechat_redirect';
        header('location:'.$url);
        die;
	}
	/**
	 * 通过code获取openid
	 * @param 2017-12-6 10:12:12
	 */
    public function code_cash_openid($code){
    	try {
    		$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.self::$appid.'&secret='.self::$appsec.'&code='.$code.'&grant_type=authorization_code';
        	$res = json_decode(file_get_contents($url),true);
        	if(empty($res)) throw new Exception("非json数据", 0);
        	if(isset($res['errcode'])) throw new Exception($res['errmsg'], $res['errcode']);
        	
        	return $res['openid'];
    	} catch (Exception $e) {
    		return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
    	}
       

        return $res->access_token ? $res : 'codeCashToken fail';
    }
	/* 获取token值*/
    public function getToken(){
    	$file = $_SERVER['DOCUMENT_ROOT'].'/Data/json/wechat_accsee_token.txt';
    	try {
    		$json = file_get_contents($file);
	        if(!empty($json)){
	            $data = json_decode($json);
	            if(($data->endtime-600)> $_SERVER['REQUEST_TIME']) return $data->token;
	        }
        	$res = $this->sendToken();
	        $arr = array(
	            'addtime' => NOW_TIME,
	            'token'   => $res['msg'],
	            'endtime' => NOW_TIME+7200,
	        );

	        $inRes = file_put_contents($file, json_encode($arr));
        	if(!$inRes) throw new Exception($file.':无法写入，权限不足', 0);
        	
        	return $res['msg'];
    	} catch (Exception $e) {
    		return ['status'=>0,'msg'=>$e->getMessage()];
    	}
    }
 


 
    /* 发起获得token值请求 */
    public function sendToken(){
    	try {
    		$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.self::$appid.'&secret='.self::$appsec.'';
    		$data = json_decode(file_get_contents($url),true);
    		if(empty($data)) throw new Exception("非json数据", 0);
    		
    		if(isset($data['errcode'])) throw new Exception($data['errmsg'], $data['errcode']);
    		return ['status'=>1,'msg'=>$data['access_token']];
    	} catch (Exception $e) {
    		return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
    	}
    }
}