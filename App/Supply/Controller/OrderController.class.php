<?php
namespace Supply\Controller;
use Think\Controller;
use Common\Model\AreaModel;
class OrderController extends SeachController {


	/**
	 * 订单列表
	 * @param  2017-12-25 09:43:25
	 */
	public function order_list()
	{
        $seach = $this->seach();
        $where = $seach['where'];
        
        $where['o.group_trade'] = 1;
        $where['o.pay_status'] = 1;
	    $pageSize = 25;    
        $limit = getLimit($pageSize);

        #查询数据
        $Model = M('goods_open_group_order');
        $data  = $Model->where($where)->join('o left join __USER_ACCOUNT__ a on o.uid=a.id')->join('left join __GOODS_OPEN_GROUP__ g on o.grid=g.id')->field('g.gname,g.gteam_price,a.realname,a.mobile,o.*')->order('o.id desc')->limit($limit)->select();
        $this->assign('data',$data);
        
        #分页
        $count = $Model->alias('o')->where($where)->count();
        $this->assign('count',$count);
        $Page  = new \Think\Page($count,$pageSize,$seach['seach']); 
        $show  = $Page->show(); 
        $this->assign('page',$show);
        $this->display();
	}
    /**
     * 订单发货
     * @param 2017-12-25 14:57:30
     * @param array:id,delivery_sn
     */
    public function up_trade()
    {
        $post = I('post.');
        $post['trade'] = 2;
        $post['did'] = parent::$adminid;
        $res = D('goods_open_group_order')->up_order_trade($post);
        $this->ajaxReturn($res);
    }
}