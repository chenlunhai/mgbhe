<?php
namespace Home\Controller;
use Think\Controller;
class OrderController extends RunController {
	/**
	 * 购买商品
	 * @param 2017-12-18 
	 */
	/*public function checkOrder(){
		#未登陆
        if(empty(parent::$uid)) $this->ajaxReturn(['status'=>-1,'msg'=>"您还未登录，请登录",'gourl'=>U('Login/index',['reurl'=>urlencode(getFullUrl())]) ]);

        $post = I('post.');
        $res = D('goods_open_group_order')->check_buy_goods($post);

        if($res["status"]) session('orderInfo',$res["data"]);
        $this->ajaxReturn($res);
	}*/

	public function test(){
		dump(session('orderInfo'));
	}

	/**
	 * 确认拼团订单
	 * @param 2017/12/18
	 */
	public function order(){
		$address = D('address')->get_address(parent::$uid);
		$address = $address["data"]["address"];
		$this->assign('address',$address);  //dump($address);

		$data = session('orderInfo');
		$this->assign('data',$data);        //dump($data);

		
		$this->display();
	}

	/**
	 * 添加收货地址
	 * @param 2017/12/18
	 */
	public function addAddress(){
		$post = I('post.');
		$post['uid'] = parent::$uid;
		$res = D('address')->add_address($post);
		$this->ajaxReturn($res);
	}

	/**
	 * 删除收货地址
	 * @param 2017/12/18
	 */
	public function delAddress(){
		$post = I('post.');
		$post['uid'] = parent::$uid;
		$res = D('address')->del_address($post);
		$this->ajaxReturn($res);
	}

	/**
	 * 提交订单-创建订单
	 * @param 2017/12/18
	 */
	public function create_order(){
		$post = I('post.');
		$post['uid'] = parent::$uid;

		$res = D("goods_open_group_order")->create_order($post);
		
		$this->ajaxReturn($res);
	}

	/**
	 * 显示拼团订单信息
	 * @param 2017/12/18
	 */
	public function cashier(){
		if(!$_POST){
			$osn = I('get.osn',0);
			if(strlen($osn) != 20) exit($this->display('order_error'));

			$pay_price = D("goods_open_group_order")->where(['osn'=>$osn,'uid'=>parent::$uid])->getField('pay_price');
			$data['pay_price'] = $pay_price;
			$data['osn'] = $osn;   
			$this->assign('data',$data);  //dump($data);

	 		$user = D('user_estate')->get_user_estate(parent::$uid,'balance');
	 		$this->assign('user',$user);  //dump($user);

	 		$this->assign('getclient',getclient());
			exit($this->display());
		}


		$post = I('post.');
		$post['uid'] = parent::$uid;
		$post['pay_source'] = 'WEB';

		$res = D("goods_open_group_order")->pay_order($post);
		$this->ajaxReturn($res);
	}

	/**
	 * 支付成功
	 * @param 2017/12/18
	 */
	public function order_success(){
		$post = [];
		$post['osn'] = I('get.osn',0)?I('get.osn',0):I('get.out_trade_no',0);
		$post['uid'] = parent::$uid;
		
		//dump($post); exit();
		$res = D('goods_open_group_order')->get_order_success($post);
		if($res['status']){
			$this->assign('data',$res['data']);  //dump($res['data']);
		}else $this->error($res['msg']);
		$this->display();
	}

	/**
	 * 确认收货
	 * @param 2017/12/25
	 */
	public function confirm_order(){
		$post = I('post.');
		$post['uid'] = parent::$uid;
		$res = D('goods_open_group_order')->get_sure_goods($post);
		$this->ajaxReturn($res);

	}


	/**
	 * 红包记录
	 * @param 2017/12/23
	 */
	public function envelopes_list(){
		if(!$_POST){
			$this->assign('state',1);  #默认展示用户当前拥有红包

			$user = M('user_account')->where(['u.id'=>parent::$uid])->join('u left join __USER_ESTATE__ e on u.id=e.id')->field('u.realname,e.total_red_packet')->find();

			$user['urp'] = D('red_packet')->where(['uid'=>parent::$uid])->count();
			$user['utrp'] = M('red_packet_record')->where(['uid'=>parent::$uid])->count();

			$this->assign('user',$user);  //p($user);
			exit($this->display());
		}


		$post = I('post.');
		$post['uid'] = parent::$uid;
		if($post['state']){
			#返回用户当前拥有红包
			$res = D('red_packet')->get_user_red_packet_list($post);
		}else{
			#返回用户已抢到的红包
			$res = D('red_packet')->get_user_take_red_packet($post);
		}
		$this->ajaxReturn($res);

	}

	/**
	 * 抢红包 -  抢得过程
	 * @param 2017/12/23
	 */
	public function envelopes(){
		$post = I('post.');
		$post['uid'] = parent::$uid;
		$res = D('red_packet')->up_red_packet($post);
		$this->ajaxReturn($res);
	}

	/**
	 * 红包详情
	 * @param 2017/12/23
	 */
	public function envelopes_details(){
		if(!$_POST){
			$get = I('get.');
			$get['uid'] = parent::$uid;  
			$res = D('red_packet')->get_user_red_packet($get);    //p($res);
			if($res['status']) $this->assign('data',$res['data']);
			else $this->error($res['msg']);

			$this->assign('token',$get['token']);

			exit($this->display());
		}


		$post = I('post.');
		$post['uid'] = parent::$uid;
		$res = D('red_packet')->get_red_packet_list($post);
		$this->ajaxReturn($res);
	}


	/**
	 * 去支付
	 * @param 2017/11/10
	 */
	public function gopay()
	{
		if(!IS_POST) die;
		$post = I('post.');
		$post['uid'] = parent::$uid;
		$res = D('order')->create_order($post);
		$this->ajaxReturn($res);
	}

	/**
	 * 显示订单信息
	 * @param 2017/11/10
	 */
	public function payment()
	{
		$oid = I('get.oid',0);
		$order = D('Order')->show_order($oid);	//生成支付订单
 		if($order['status'] != 1) exit($this->display('order_error'));
		$this->assign('order',$order['msg']);

 		$user = D('user_estate')->get_user_estate(parent::$uid,'balance');
 		$this->assign('user',$user);
		$this->display();
	}

}