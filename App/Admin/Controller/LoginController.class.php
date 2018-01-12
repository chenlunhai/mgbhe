<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends MainController {
    public function index(){
      if(!IS_POST){
        $this->display();
        die;
      } 
      $post = I('post.');
      $res = D('admin')->admin_login($post);
      $this->ajaxReturn($res);
    }

    public function logout(){
   
      $this->redirect('Login/index');
    }
  
}