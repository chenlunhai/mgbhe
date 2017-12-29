<?php
/**
 * APP用户登陆
 */
namespace Home\Controller;
use Think\Controller;
class AppLoginController extends Controller {

	/**
	 * 手机号登陆
	 * @param 2017-12-12 14:30:14
	 * @param array $post:mobile
	 */
	public function user_login()
	{
		$post = I('post.');
		$res = D('user_account')->user_login($post);
		if($res['status'] == 1 && $res['code'] == 1){
			$res['access_token'] = D('access_token')->get_access_token($res['msg']);
		}
		$this->ajaxReturn($res);
	}
	/**
	 * 数钜宝用户手机号+真实姓名注册
	 * @param 2017-12-12 16:19:35
	 * @param array $post:mobile,realname
	 */
	public function user_register_cds()
	{
		$post = I('post.');
		$res = D('user_account')->user_realname_register($post);
		if($res['status'] == 1){
			$res['access_token'] = D('access_token')->get_access_token($res['msg']);
		}
		$this->ajaxReturn($res);
	}
	/**
	 * 用户注册，完善资料
	 * @param 2017-12-12 16:22:32
	 * @param array $post:mobile,province,city,region,password,realname,pmobile
	 */
	public function user_register()
	{
		$post = I('post.');
		$res = D('user_account')->user_register($post);
		if($res['status'] == 1){
			$res['access_token'] = D('access_token')->get_access_token($res['msg']);
		}
		$this->ajaxReturn($res);
	}
	/**
	 * 返回区域信息
	 * @param 2017-12-15 10:06:56
	 */
	public function get_area_info()
	{
		$pid = I('post.pid',0);
		$area = D('area')->get_area_info($pid);
		$this->ajaxReturn(['status'=>1,'data'=>$area]);
	}
	/**
	 * 发送验证码
	 * @param 2017-12-12 14:31:38
	 * @param string $mobile:手机号, string state:0(注册)1(找回密码)2(无类型)
	 */
	public function send_sms()
	{
		$post = I('post.');
		$res = D('user_account')->sendSms($post,1);
		$this->ajaxReturn($res);
	}


}

