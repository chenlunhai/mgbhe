<?php
/**
 * 与数钜宝通信类
 * @param 2017/11/9
 */
namespace Common\Service;
use Think\Exception;
class SjbService{
	const APIURL = 'http://sjb.wlylai.com/Mgbh/';	#数钜宝接口请求地址
	const GOURL  = 'http://sjb.wlylai.com/';	#数钜宝地址
	const STATUS = 0;	#0（禁止使用）1（正常使用）

	/**
	 * 大盒子消费订单写入数钜宝
	 * @param 2017/11/11
	 * @param array $data:uid,order_sn,money,paytime
	 * @return array
	 */
	public function report_sjb($data)
	{
		try {
			if(self::STATUS == 0) throw new Exception("error #api stop");
			
			$check_res = check_data($data,['uid','order_sn','money','paytime']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

			$user = M('user_account')->where(['id'=>$data['uid']])->field('code,province,city')->find();
			if(empty($user['code'])) throw new Exception("error #code", 11013);	
			
			$data['code'] = $user['code'];
			$data['province'] = $user['province'];
			$data['city'] = $user['city'];
			unset($data['uid'],$user);
			$url = self::APIURL.'report_sjb';

			$res = json_decode(https_request($url,json_encode($data)),true);

			if(empty($res)) throw new Exception("接口数据异常", 10000);
			if($res['status'] != 1) throw new Exception($res['msg'], 10001);
			M('order')->where(['osn'=>$data['order_sn'],'status'=>0])->setField('status',1);
			return ['status'=>1,'msg'=>$res['msg']];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 根据用户id,返回数钜宝新增米米
	 * @param 2017-11-11 22:11:35
	 * @param string $id
	 * @return array
	 */
	public function get_today_add_money($id)
	{
		try {
			if(self::STATUS == 0) throw new Exception("error #api stop");

			if($id < 1) throw new Exception("error #id", 11000);
			
			$code = M('user_account')->where(['id'=>$id])->getField('code');
			if(empty($code)) throw new Exception("账号异常", 11013);
			
			$url = self::APIURL.'get_today_add_money';
			$res = json_decode(https_request($url,json_encode(['code'=>$code])),true);

			if(empty($res)) throw new Exception("接口数据异常", 10000);
			if($res['status'] != 1) throw new Exception($res['msg'], 10001);

			return ['status'=>1,'msg'=>$res['msg']];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 根据用户id，返回进入数钜宝链接
	 * @param 2017/11/11
	 * @param string $id
	 * @return array
	 */
	public function get_go_cds_url($id)
	{
		try {
			if(self::STATUS == 0) throw new Exception("error #api stop");

			if($id < 1) throw new Exception("error #id", 11000);
			
			$code = M('user_account')->where(['id'=>$id])->getField('code');
			if(empty($code)) throw new Exception("账号异常", 11013);
			
			$reurl = self::GOURL.'User/integral_total/code/'.$code;
			return ['status'=>1,'msg'=>$reurl];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}

	/**
	 * 手机号是否在数钜宝存在
	 * @param 2017/11/9
	 * @param $mobile
	 */
	public function check_mobile_exists($mobile)
	{
		try {
			if(self::STATUS == 0) throw new Exception("error #api stop");

			
			if(empty($mobile)) throw new Exception('error #mobile',11001);
			
			$url = self::APIURL.'get_mobile_exists';
			$res = json_decode(https_request($url,json_encode(['mobile'=>$mobile])),true);

			if(empty($res)) throw new Exception("接口数据异常", 10000);
			if($res['status'] != 1) throw new Exception($res['msg'], 10001);

			return ['status'=>1,'msg'=>$res['msg']];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 通过code获取用户详细资料
	 * @param 2017/11/9
	 * @param string $code
	 * @return array
	 */
	public function get_user_info($code)
	{
		try {
			if(self::STATUS == 0) throw new Exception("error #api stop");

			if(empty($code)) throw new Exception('error #code',11000);

			$url = self::APIURL.'get_user_info';
			$res = json_decode(https_request($url,json_encode(['code'=>$code])),true);

			if(empty($res)) throw new Exception("接口数据异常", 10000);
			if($res['status'] != 1) throw new Exception($res['msg'], 10001);

			return ['status'=>1,'msg'=>$res['msg']['info']];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 注册用户到数钜宝
	 * @param 2017/11/10
	 * @param array $data:mobile,realname,province,city,region
	 * @return array
	 */
	public function create_user($data)
	{
		try {
			if(self::STATUS == 0) throw new Exception("error #api stop");
			
			$check_res = check_data($data,['mobile','realname','city','region','pcode']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

			$url = self::APIURL.'create_user';
			 
			$res = json_decode(https_request($url,json_encode($data)),true);

			if(empty($res)) throw new Exception("接口数据异常", 10000);
			if($res['status'] != 1) throw new Exception($res['msg'], 10001);

			return ['status'=>1,'msg'=>$res['msg']];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	
}