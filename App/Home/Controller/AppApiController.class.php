<?php
/**
 * APP拉取数据类
 * @param 2017-12-12 17:10:14
 */
namespace Home\Controller;
use Think\Controller;

class AppApiController extends AppApiRunController {

	/**
	 * 拉取首页信息
	 * @param 2017-12-12 17:10:43
	 */
	public function get_index_cate()
	{
		 
		$cate = D('goods_supply_cate')->get_goods_supply_cate(0);
		$banner = D('banner')->get_banner_info();
		$this->ajaxReturn(['status'=>1,'data'=>['cate'=>$cate,'banner'=>$banner]]);
	}
	/**
	 * 拉取首页商品
	 * @param 2017-12-12 18:04:10
	 * @param string $page
	 */
	public function get_index_goods()
	{
		$page = I('post.page',1);
		$goods = D('goods_open_group')->get_index_goods($page);
		$this->ajaxReturn($goods);
	}
	/**
	 * 拉取分类页面-分类
	 * @param 2017-12-12 18:18:12
	 * @param string $gcid
	 */
	public function get_cate_info()
	{
		$gcid = I('post.gcid',0);
		$cate = D('goods_supply_cate')->get_goods_supply_cate($gcid);
		$this->ajaxReturn(['status'=>1,'data'=>$cate]);
	}
	/**
	 * 返回所有分类-两级
	 * @param 2017-12-27 10:41:47
	 */
	public function get_goods_supply_cates()
	{
		$res = D('goods_supply_cate')->get_goods_supply_cates();
		$this->ajaxReturn($res);
	}
	/**
	 * 拉取分类页面-商品
	 * @param 2017-12-13 17:16:21
	 * @param array $data:gcid,page
	 */
	public function get_goods_list()
	{
		$post = I('post.');
		$res  = D('goods_open_group')->get_goods_list($post);
		$this->ajaxReturn($res);
	}
	/**
	 * 拉取单个商品详情，不含商品内容
	 * @param 2017-12-13 17:35:50
	 * @param string $id：开团id
	 */
	public function get_goods_detail()
	{
		$post = I('post.id');
		$res  = D('goods_open_group')->get_goods_detail($post);
		$this->ajaxReturn($res);
	}
	/**
	 * 返回某个店家的开团商品
	 * @param 2017-12-15 11:02:41
	 * @param string $sid(店家id),page
	 */
	public function get_shop_goods()
	{
		$post = I('post.');
		if(!intval($post['sid'])) $this->ajaxReturn(['status'=>0,'msg'=>'error #sid','code'=>11000]);
		$res  = D('goods_open_group')->get_goods_list($post);
		$this->ajaxReturn($res);
	}
	/**
	 * 收货地址列表
	 * @param  2017-12-15 16:15:42
	 */
	public function get_address()
	{
		$res = D('address')->get_address(parent::$user_info['uid']);
		$this->ajaxReturn($res);
	}
	/**
	 * 添加收货地址
	 * @param 2017-12-15 16:11:02
	 * @param array $post:mobile,realname,province,city,country,detail
	 */
	public function add_address()
	{
		$post = I('post.');
		$post['uid'] = parent::$user_info['uid'];
		$res = D('address')->add_address($post);
		$this->ajaxReturn($res);
	}
	/**
	 * 删除收货地址
	 * @param 2017-12-15 16:14:26
	 * @param string $id
	 */
	public function del_address()
	{
		$post = I('post.');
		$post['uid'] = parent::$user_info['uid'];
		$res = D('address')->del_address($post);
		$this->ajaxReturn($res);
	}
	/**
	 * 购买商品
	 * @param 2017-12-15 16:21:03
	 * @param array $post:buy_num,id
	 */
	public function buy_goods()
	{
		$post = I('post.');
		$res = D('goods_open_group_order')->check_buy_goods($post);
		$this->ajaxReturn($res);
	}
	/**
	 * 确认下单，创建订单
	 * @param 2017-12-15 16:30:10
	 * @param array $post:id,buy_num,aid
	 */
	public function create_order()
	{
		$post = I('post.');
		$post['uid'] = parent::$user_info['uid'];

		$res = D("goods_open_group_order")->create_order($post);
		$this->ajaxReturn($res);
	}
	/**
	 * 收银台
	 * @param 2017-12-15 21:48:27
	 * @param array $data:pay_source,out_trade_type,osn
	 */
	public function pay_order()
	{
		$post = I('post.');
		$post['uid'] = parent::$user_info['uid'];

		$res = D("goods_open_group_order")->pay_order($post);
		$this->ajaxReturn($res);
	}
	/**
	 * 返回我的团里的数据
	 * @param 2017-12-18 09:38:10
	 * @param page,state:0(组团中)1(组团成功)(组团失败)
	 */
	public function get_group_order()
	{
		$post = I('post.');
		$post['uid'] = parent::$user_info['uid'];
		$res = D('goods_open_group_order')->get_group_order($post);
		$this->ajaxReturn($res);
	}
	/**
	 * 返回我的团详情
	 * @param 2017-12-18 09:43:19
	 * @param string $grid
	 */
	public function get_group_detail()
	{
		$post = I('post.');
		$res = D('goods_open_group')->get_group_detail($post['grid']);
		$this->ajaxReturn($res);
	}
	/**
	 * 返回我的订单列表
	 * @param 2017-12-18 10:07:35
	 * @param array $post:page,state:0(待支付)1(已支付)2(已发货)3(已收货)4(退款中)5(完成退款)
	 */
	public function get_user_order()
	{
		$post = I('post.');
		$post['uid'] = parent::$user_info['uid'];
		$res = D("goods_open_group_order")->get_user_order($post);
		$this->ajaxReturn($res);
	}
	/**
	 * 返回会员信息
	 * @param 2017-12-18 12:00:39
	 */
	public function get_user_info()
	{
		$uid = parent::$user_info['uid'];
		$res = D("user_account")->get_user_info($uid);
		$this->ajaxReturn($res);
	}
	/**
	 * 返回支付成功信息
	 * @param 2017-12-18 16:28:01
	 * @param array:uid,osn
	 */
	public function get_order_success()
	{
		$post = I('post.');
		$post['uid'] = parent::$user_info['uid'];
		$res = D('goods_open_group_order')->get_order_success($post);
		$this->ajaxReturn($res);
	}
	/**
	 * 返回订单详情
	 * @param 2017-12-19 10:23:43
	 * @param array:uid,osn
	 */
	public function get_order_detail()
	{
		$post = I('post.');
		$post['uid'] = parent::$user_info['uid'];
		$res = D('goods_open_group_order')->get_order_detail($post);
		$this->ajaxReturn($res);
	}
	/**
	 * 红包详情-返回抢到红包人的数据
	 * @param 2017-12-23 10:08:50
	 * @param array:token,uid,page
	 */
	public function get_red_packet_list()
	{
		$post = I('post.');
		$post['uid'] = parent::$user_info['uid'];
		$res = D('red_packet')->get_red_packet_list($post);
		$this->ajaxReturn($res);
	}
	/**
	 * 红包详情-返回自己抢到的数额
	 * @param 2017-12-23 10:10:29
	 * @param array:uid,token
	 */
	public function get_red_packet_info()
	{
		$post = I('post.');
		$post['uid'] = parent::$user_info['uid'];
		$res = D('red_packet')->get_user_red_packet($post);
		$this->ajaxReturn($res);
	}
	/**
	 * 红包记录-返回用户当前拥有红包
	 * @param 2017-12-23 10:17:11
	 * @param array:uid,page
	 */
	public function get_user_red_packet_list()
	{
		$post = I('post.');
		$post['uid'] = parent::$user_info['uid'];
		$res = D('red_packet')->get_user_red_packet_list($post);
		$this->ajaxReturn($res);
	}
	/**
	 * 红包记录-返回用户已抢到的红包
	 * @param 2017-12-23 10:26:04
	 * @param array:uid,page
	 */
	public function get_user_take_red_packet()
	{
		$post = I('post.');
		$post['uid'] = parent::$user_info['uid'];
		$res = D('red_packet')->get_user_take_red_packet($post);
		$this->ajaxReturn($res);
	}

}