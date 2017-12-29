<?php
namespace Supply\Controller;
use Think\Controller;
use Common\Service\SmsService;
class LoginController extends MainController {
    /**
     * 供货商登陆
     * @param 2017-12-9 11:28:51
     */
    public function index(){
      if(!IS_POST){
      	$this->display();
      	die;
      } 
      $post = I('post.');

      #验证吗是否正确
      $SmsService = new SmsService;
      $check_verify = $SmsService->checkVerify($post);
      if($check_verify['status'] != 1) $this->ajaxReturn($check_verify);

      $res = D('user_account')->exe_supply_login($post);
      $this->ajaxReturn($res);
    }

    public function logout(){
   
      $this->redirect('Login/index');
    }
    /**
     * 验证手机号码是否可以登录供货商后台
     * @param 2017-12-9 11:01:06
     */
    public function check_mobile()
    {
      $post = I('post.');
      $res = D('user_account')->check_mobile($post);
      $this->ajaxReturn($res);
    }
    /**
     * 发送验证码
     * @param 2017-12-9 11:21:18
     */
    public function send_sms()
    {
      $mobile = I('post.mobile','');
      $SmsService = new SmsService;
      $res = $SmsService->sendSms($mobile,2);
      $this->ajaxReturn($res);
    }
}