<?php
namespace Home\Controller;
use Common\Service\CookieService;
use Common\Service\SmsService;
class LoginController extends MainController {

    /**
     * 注册-手机+验证码
     * 注册新用户，下一步完善资料
     * 存在用户，直接登陆并跳转到会员中心personal
     * @param 2017/11/2
     */
    public function index(){
        if(!IS_POST){

            $reurl = U('User/personal');
            if(isset($_GET['reurl'])) $reurl = urldecode( I('get.reurl') );
            $this->assign('reurl',$reurl);

            exit($this->display());
        }
        $post = I('post.');

        $SmsService = new SmsService();
        $check_verify = $SmsService->checkVerify($post);
        if($check_verify['status'] != 1) $this->ajaxReturn(check_verify);

        $res  = D('user_account')->user_login($post);
        $this->ajaxReturn($res);
    }

    /**
     * 新用户注册后的完善资料
     * @param 2017/11/3
     */
    public function register(){
        if(!IS_POST){
            if(!empty(I('get.mobile',''))) $this->assign('mobile',I('get.mobile'));

            $pmobile = '';
            $pid = I('get.pid',0);
            if($pid > 0) $pmobile = M('user_account')->where(['id'=>$pid])->getField('mobile');	#来自分享注册
            
            $this->assign('pmobile',$pmobile);
            exit($this->display());
        }
        $post = I('post.');
        $post['mid'] = parent::$shop_info['id'];
        $res  = D('user_account')->user_register($post);
        $this->ajaxReturn($res);
    }


    /**
     * 用户登录---账号+密码登录
     * @param 2017/11/2
     */
    public function login(){

        if(!IS_POST){
            $reurl = U('User/index');
            if(isset($_GET['reurl'])) $reurl = urldecode( I('get.reurl') );
            $this->assign('reurl',$reurl);

            if(!empty(I('get.mobile',''))) $this->assign('mobile',I('get.mobile'));
            exit($this->display());
        }
        $post = I('post.');
        $res  = D('user_account')->user_account_login($post);
        $this->ajaxReturn($res);
    }

    /**
     * 忘记密码
     * @param 2017/11/2
     */
    public function password(){

        if(!IS_POST){
            #注册时找回密码  or  登录后，修改密码时，找回密码
            $mobile = I('get.mobile');
            if(empty($mobile))
               $mobile = M('user_account')->where(['id'=>parent::$uid])->getField('mobile');
            $this->assign('mobile',$mobile);
          
            exit($this->display());
        }

        #清空cookie，找回成功后重新登录
        $post = I('post.');
        $User = D('user_account');
        $res  = $User->get_pwd($post);
        $this->ajaxReturn($res);
    }

    /**
     * 验证当前手机用户是否注册
     * @param 2017/11/6
     */
    public function checkPhone(){
        $post = I('post.');
        $res  = D('user_account')->check_mobile_exists($post);
        $this->ajaxReturn($res);
    }

    /**
     * 数钜宝用户登陆
     * @param 2017/11/2
     */
    public function verification(){

        if(!IS_POST){
            $reurl = U('User/index');
            if(isset($_GET['reurl'])) $reurl = urldecode( I('get.reurl') );
            $this->assign('reurl',$reurl);

            if(!empty(I('get.mobile',''))) $this->assign('mobile',I('get.mobile'));
            exit($this->display());
        }
        $post = I('post.');
        $res  = D('user_account')->user_login($post);
        $this->ajaxReturn($res);
    }

    /**
     * 发送验证码
     * @param 2017/11/2
     */
    public function sendMes(){
        #发送验证码
        $data = I('post.');
        $res = D('user_account')->sendSms($data);
        $this->ajaxReturn($res);
    }
    
    /**
     * 验证是否数钜宝用户的真实姓名
     * @param 2017/11/10
     */
    public function verifyCDSRealname(){
        $data = I('post.');
        $data['mid'] = parent::$shop_info['id'];
        $res = D('user_account')->user_realname_register($data);
        $this->ajaxReturn($res);
    }

    /**
     * 用户退出
     * @param 2017/11/10
     */
    public function logout(){
        $CookieService = new CookieService();
        $CookieService->unSetCookie();
        $this->redirect('Login/index');
    }

    #测试
    public function test(){
        dump(session('test'));
    }

}