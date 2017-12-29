<?php
namespace Home\Controller;
use Think\Controller;
 
class EmptyController extends Controller {

	/**
     * 控制器异常 or 无该控制器跳转会员中心
     */
    public function _empty(){
    	$this->redirect('User/personal');
    }

}