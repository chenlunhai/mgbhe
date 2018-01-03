<?php
namespace Home\Controller;
use Common\Service\MyhzService;
use Common\Service\SjbService;
use Common\Service\WechatService;
class TestController extends MainController {

    public function index(){
    	header('content-type:text/html;charset=utf-8');

        $res = D('goods_open_group_order')->add_seller_money(['pay_price'=>100,'did'=>20,'osn'=>'123']);
        p($res);
    	 
    	 
    }
    public function test()
    {
        $WechatService = new WechatService;
        if(isset($_GET['code'])){
            p($_GET);die;
        }
        $res = $WechatService->get_code();
        p($res);
    }
}