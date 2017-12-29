<?php
namespace Home\Controller;
use Common\Service\MyhzService;
use Common\Service\SjbService;
class TestController extends MainController {

    public function index(){
    	header('content-type:text/html;charset=utf-8');

        // $arr = ['grid'=>11,'id'=>98,'num'=>50,'money'=>1.1];
        
        // $res = D('goods_open_group')->up_open_next_group(17);
        $res =D('goods_supply_cate')->get_goods_supply_cates(); #自动开启下一期
        p($res);
    	 
    	 
    }
    public function test()
    {

    }
}