<?php
namespace Home\Controller;
use Think\Controller;
class PayController extends MainController {

	/**
	 * 网页支付获取获得订单详情
	 * @param 2017/11/9
	 */
	public function get_pay_order_info()
	{
		$osn  = file_get_contents('php://input');
		if(empty($osn)) die;

		$order = ['total_prices'=>'0.00','title'=>'微信支付','order_sn'=>$osn];
		switch ($osn[0]) {
			case 8:	#余额充值订单
				$balance = M('order_balance')->where(['osn'=>$osn,'pay_status'=>0])->getField('money');
				if($balance < 0.01) die;
				 
				$order['total_prices']  = $balance;
				$order['reurl'] = 'http://'.$_SERVER['HTTP_HOST'].U('Order/balance_success');
				$order['pay_title'] = C('OBJECT_NAME').'-余额充值';
				break;
			case 5:	#大盒子消费订单
				$oprice = M('order')->where(['osn'=>$osn,'pay_status'=>0])->getField('oprice');
				if($oprice < 0.01) die;

				$order['total_prices']  = $oprice;
				$order['reurl'] = 'http://'.$_SERVER['HTTP_HOST'].U('Order/order_success');
				$order['pay_title'] = C('OBJECT_NAME');
				break;
			case 6:	#拼采廉订单
				$oprice = M('goods_open_group_order')->where(['osn'=>$osn,'pay_status'=>0])->getField('pay_price');
				if($oprice < 0.01) die;
				$order['total_prices']  = $oprice;
				$order['reurl'] = 'http://'.$_SERVER['HTTP_HOST'].U('Order/order_success');
				$order['pay_title'] = C('OBJECT_NAME');
				break;
			default:
				# code...
				break;
		}
		exit(json_encode($order));
	 
	}
	/**
	 * 订单支付成功回调
	 * @param 2017/11/9
	 */
	public function pay_complete()
	{
		$json  = json_decode(file_get_contents('php://input'),true);
	 	if(empty(json)) die;

		switch ($json['order_sn'][0]) {
			case 8:	#余额充值订单
				$res = D('order_balance')->pay_complete($json);
				break;
			case 5:	#大盒子消费订单
				$res = D('order')->complete_order($json);
				break;
			case 6:
				$res = D('goods_open_group_order')->complete_order($json);
				break;
			default:
				# code...
				break;
		}
		exit(json_encode($res));
	}
}