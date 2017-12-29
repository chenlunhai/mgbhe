<?php
/**
 * 蚂蚁盒子通信类-小盒子
 * @param 2017-11-23 10:19:09
 */
namespace Common\Service;
use Think\Controller;
use Think\Model;
use Think\Exception;
class MyhzService{
	private static $name 		= 'mgbhmyhz';
	private static $password 	= 'mgbh1109';
	private static $appId 		= 'qhLk3ImUFPi4Uha6bG';
	private static $appSecret 	= 'E7998A6A3561914E8A1EF545EE31DFBE';
	private static $url 		= 'http://openapi.uat.mayihezi.com/v1/';
	private static $access_token_file = '';
	private static $boxId = '73183069290';
	public function __construct()
	{
		self::$access_token_file = $_SERVER['DOCUMENT_ROOT'].'/Data/Json_Myhz/access_token_file.json';
	}
 	/**
 	 * 售货机开门
 	 * @param 2017-11-30 10:14:50
 	 * @param array $data:mobile,uid,bid
 	 */
 	public static function get_box_open($data)
 	{
 		$url = self::$url.'box/open_door';
 		try {
 			if(empty($data['mobile']) || empty($data['uid']) || empty($data['bid'])) throw new Exception('error #paramter');
 			
 			$access_token = self::get_name_accsee_token();
			
			$arr = [
				'sign'=>self::get_sign(),'timestamp'=>NOW_TIME,'boxId'=>$data['bid'],'openDoorSource'=>'PARTNER','distribution'=>false,'customerMobile'=>$data['mobile'],'partnerCustomerId'=>$data['uid']
			];
			 
			$res = json_decode(self::http_curl($url,$arr,'POST',$access_token['msg']),true);
			if(empty($res)) throw new Exception("售货机开门返回错误非json数据");
			 
			if($res['data']['openDoorCode'] != '1200'){
				$res_code = [
					'1201'=>'系统内部错误','1204'=>'售货机正在繁忙','1205'=>'售货机正与其他用户交易中','1206'=>'售货机没有注册','1315'=>'暂无开门权限','1316'=>'售货机掉线','1314'=>'有未完成订单'
				];
				throw new Exception($res_code[$res['data']['openDoorCode']]);
			}

			return ['status'=>1,'msg'=>'开门成功'];
 		} catch (Exception $e) {
 			self::in_log($e->getMessage(),$url);	#写入日志
			return ['status'=>0,'msg'=>$e->getMessage()];
 		}
 	}
 	/**
 	 * 请求售货机更改订单状态
 	 * @param 2017-11-30 17:56:13
 	 * @param array $data:orderNum,osn,boxId
 	 */
 	public static function pay_order($data)
 	{
 		$url = self::$url.'order/pay';
 		try {
 			$access_token = self::get_name_accsee_token();

 			$arr = [
 				'timestamp'=>NOW_TIME,'payMethod'=>'PARTNER','sign'=>self::get_sign(),
 				'order'=>['orderNum'=>$data['orderNum'],'partnerOrderNum'=>$data['osn'],'boxId'=>$data['boxId']]
 			];
 			$res = json_decode(self::http_curl($url,$arr,'POST',$access_token['msg']),true);
			if(empty($res)) throw new Exception("售货机开门返回错误非json数据");
			if($res['code'] != 1) throw new Exception($res['desc']);

			return ['status'=>1,'msg'=>'成功'];
 		} catch (Exception $e) {
 			self::in_log($e->getMessage(),$url);	#写入日志
			return ['status'=>0,'msg'=>$e->getMessage()];
 		}
 	}
	/**
	 * 获得售货机列表
	 * @param 2017-11-28 14:50:47
	 */
	public static function get_box_list_info()
	{
		$access_token = self::get_name_accsee_token();
		$url = self::$url.'box/page';

		$res = self::http_curl($url,'','GET',$access_token['msg']);
		var_dump($res);
	}
	/**
	 * 添加商品
	 * @param 2017-11-30 15:45:42
	 */
	public static function add_goods()
	{
		$url = self::$url.'product/batch_save';
		try {
			$access_token = self::get_name_accsee_token();
			$arr = [
				[
					'name'=>'测试商品','costPrice'=>'0.01','salePrice'=>'0.01','categoryId'=>'17004363','partnerProductId'=>1
				]
			];
			$res = json_decode(self::http_curl($url,$arr,'POST',$access_token['msg']),true);
			if(empty($res)) throw new Exception('新增商品返回错误非json数据');
			dump($res);
		} catch (Exception $e) {
			self::in_log($e->getMessage(),$url);	#写入日志
			return ['status'=>0,'msg'=>$e->getMessage()];
		}
	}
	/**
	 * 获取商品类目
	 * @param 2017-11-30 15:47:07
	 */
	public static function add_goods_cate()
	{
		$url = self::$url.'category/list';
		try {
			$access_token = self::get_name_accsee_token();
			$res = json_decode(self::http_curl($url,'','GET',$access_token['msg']),true);
			if(empty($res)) throw new Exception('获取商品类目返回错误非json数据');
			if($res['code'] != 1) throw new Exception($res['desc']);
			
			return ['status'=>1,'msg'=>$res['data']];
		} catch (Exception $e) {
			self::in_log($e->getMessage(),$url);	#写入日志
			return ['status'=>0,'msg'=>$e->getMessage()];
		}
		
		
	}
	/**
	 * 通过账号密码获取accseeToken
	 * @param 2017-11-23 10:23:26
	 */
	private static function get_name_accsee_token()
	{
		$access_token = json_decode(file_get_contents(self::$access_token_file),true);
		if(!empty($access_token) && $access_token['endtime'] > (NOW_TIME+600)){	#可直接返回access_token
			return ['status'=>1,'msg'=>$access_token['access_token']];
		}
		$url = self::$url.'open_user/login';
		$account = [
			'name'=>self::$name,'password'=>self::$password,'timestamp'=>NOW_TIME,'sign'=>self::get_sign(),
		];
		try {

			$res = json_decode(self::http_curl($url,$account),true);
			
			if(empty($res)) throw new Exception("蚂蚁盒子获取accsee_token接口返回错误非json数据");
			
			if($res['code'] != 1) throw new Exception($res['desc']);
			
			$in_data = [
				'endtime' => NOW_TIME+7200,'access_token'=>$res['data']['accessToken']
			];
			file_put_contents(self::$access_token_file,json_encode($in_data));

			return ['status'=>1,'msg'=>$res['data']['accessToken']];
		} catch (Exception $e) {
			self::in_log($e->getMessage(),$url);	#写入日志
			return ['status'=>0,'msg'=>$e->getMessage()];
		}
	}
	/**
	 * 接口返回错误，写入日志
	 * @param 2017-11-23 17:27:42
	 * @param string $msg:错误信息, string $action:动作名称 
	 */
	private static function in_log($msg,$action)
	{
		$logfile 	= $_SERVER['DOCUMENT_ROOT'].'/Data/Log_Myhz/'.date('Y-m-d').'.txt';
		$content = 'starttime:'.date('Y-m-d H:i:s').',url:'.$action.',ip:'.get_client_ip().',error:'.$msg.PHP_EOL;
		
		file_put_contents($logfile,$content,FILE_APPEND);
	}
	/**
	 * 加密数据返回，sign签名
	 * @param 2017-11-23 10:25:09
	 * @return string 
	 */
	public static function get_sign($timestamp)
	{
		if(empty($timestamp)) $timestamp = NOW_TIME;
		$data = [
			'appId' => self::$appId,'appSecret'=> self::$appSecret,'timestamp'=>$timestamp
		];
		ksort($data);
		$str = '';
		foreach ($data as $key => $value) {
			$str .= $value;
		}
		return md5($str);
	}
	/**
	 * 发起curl请求，json类型
	 * @param 2017-11-23 10:20:35
	 */
	private static function http_curl($url,$data,$request = 'POST',$token='')
    {
	 
		$ch = curl_init($url);
		if(is_array($data)){
			$data = json_encode($data);
			$header = [
				'Content-Type: application/json','Content-Length: ' . strlen($data)
			];
			if(!empty($token)) $header[strlen($header)] = 'access_token:'.$token;
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		}
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request);
		if($request == 'POST')	curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
		if($request == 'GET') curl_setopt($ch, CURLOPT_HTTPHEADER,['access_token:'.$token]);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		
		
		
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
    }
}