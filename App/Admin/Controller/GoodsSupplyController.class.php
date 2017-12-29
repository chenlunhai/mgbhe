<?php
namespace Admin\Controller;
use Think\Controller;
class GoodsSupplyController extends RunController {



	/**
	 * 供货商拼团商品列表
	 * @param 2017-12-11 18:17:22
	 */
	public function goods_list()
	{
		$this->display();
	}
	/**
	 * 供货商拼团商品审核
	 * @param 2017-12-11 18:17:51
	 */
	public function goods_status_list()
	{
		$where = ['gstatus'=>1];
		$Model = M('goods_supply');
		$pageSize = 25;
		$limit = getLimit($pageSize);

		$data = $Model->where($where)->order('id desc')->limit($limit)->select();
		$this->assign('data',$data);

		#分页
        $count = $Model->alias('o')->where($where)->count();
        $this->assign('count',$count);
     
        $Page  = new \Think\Page($count,$pageSize,$where); 
        $show  = $Page->show(); 
        $this->assign('page',$show);
		$this->display(); 
	}
	/**
	 * 更改供货商商品审核状态
	 * @param 2017-12-12 10:15:02
	 */
	public function up_goods_supply_status()
	{
		$post = I('post.');
		$res = D('goods_supply')->up_goods_supply_status($post);
		$this->ajaxReturn($res);
	}
}