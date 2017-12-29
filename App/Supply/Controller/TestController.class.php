<?php
namespace Supply\Controller;
use Think\Controller;
class TestController extends Controller {

	public function index()
	{
		$res = D('goods_supply')->del_goods_supply(['uid'=>20,'id'=>6]);
		p($res);
	}



}