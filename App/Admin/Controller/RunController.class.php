<?php
namespace Admin\Controller;
use Think\Controller;
use Common\Service\LogService;
class RunController extends MainController {
     
    public function _initialize(){
        parent::_initialize();
    	$this->getLoginUser(); #获得当前登陆管理员
    }





    public function msg($i,$m){
        $arr = [
            'status' => $i,
            'msg'    => $m,
        ];
        exit('<script>window.parent.info('.json_encode($arr).');</script>');
    }




    public function getLoginUser(){
    	$admin_info = session('admin_info');
        $this->assign('admin_info',$admin_info);
    	if($admin_info['id'] < 1){
    		$this->redirect('Login/index');
    	}
        parent::$adminid   = $admin_info['id'];
        parent::$adminname = $admin_info['adminname'];
    }
   
}