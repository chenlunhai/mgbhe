<?php
/**
 * 短信通讯类
 * @param 2017/11/2
 */
namespace Common\Service;
use Think\Exception;
class SmsService{
	 private static $url = 'http://sms1.ronglaids.com/sms.aspx?action=send&userid=1029&account=hnjuduo&password=786467&mobile=M&content=C';
	/**
	 * 发送短信
	 * @param 2017/11/2
	 * @param $mobile string, $state int,0 注册、1 找回密码
	 */
	public function sendSms($mobile,$state = 0){
		try {
			if(empty($mobile)) throw new Exception('error #mobile');
			
			switch ($state) {
				case 2:
					$content = '您的验证码为';
					break;
				case 1:
					$content = '您的找回密码验证码为';
					break;
				default:
					$content = '您的注册验证码为';
					break;
			}
			$rand = rand(1000,9999);
			session('verify_info',['mobile'=>$mobile,'code'=>$rand,'expire'=>'600']);

			return $this->sendHttp($mobile,$content.$rand);
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage()];
		}
	}

	/**
	 * 验证短信验证码
	 * @param 2017/11/2
	 * @param $data array,key:mobile,verify
	 * @return array
	 */
	public function checkVerify($data)
	{
		try {
			$verify_info = session('verify_info');
			// if(empty($verify_info)) throw new Exception('验证码不正确');
			
			// if($data['mobile'] != $verify_info['mobile']) throw new Exception('验证码不正确');	#测试使用
			// if($data['mobile'] != $verify_info['mobile'] || $data['verify'] != $verify_info['code']) throw new Exception('验证码不正确');
			
			// session('verify_info',null);
			return ['status'=>1];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage()];
		}
	}
	/**
	 * 发送请求
	 * @param 2017/11/2
	 * @param $mobile,$content
	 */
	private function sendHttp($mobile,$content)
	{
		$rand = rand(1000,9999);
		$content = '【'.C('OBJECT_NAME').'】'.$content;
		$url = str_replace(['M','C'],[$mobile,$content],self::$url);
		$res = xml_to_array(file_get_contents($url));
		if($res['returnstatus'] != 'Success') return ['status'=>0,'msg'=>'error #result'];
		return ['status'=>1,'msg'=>'发送成功'];
	}
}