<?php
namespace Home\Controller;
use Think\Controller;
 
class AppPayApiController extends Controller {

	/**
     * 支付APP，获取支付详细订单信息
     * @param 2017/11/11
     */
    public function setOrder(){
		if(!IS_POST) return $this->ajaxReturn(['status'=>0,'msg'=>'post传值']);
		$post = file_get_contents('php://input');
		$data = json_decode($post,true);
		if(empty($data)) return $this->ajaxReturn(['status'=>0,'msg'=>'数据格式错误']);
		if(empty($data['order_sn'])) return ['status'=>0,'msg'=>'order_sn&参数错误'];

		$reurl = '';#支付成功返回连接
		
		#获取订单支付金额
		switch ($data['order_sn'][0]) {
			case 8:
				$pay_order = M('order_balance')->where(['osn'=>$data['order_sn'],'pay_status'=>0])->field('money,out_trade_type')->find();
				break;
			case 5:
				$reurl = 'http://'.$_SERVER['HTTP_HOST'].'/Order/order_success/osn/'.$data['order_sn'];
				$pay_order = M('order')->where(['osn'=>$data['order_sn'],'pay_status'=>0])->field('oprice money,out_trade_type')->find();
				break;
			default:
				$this->ajaxReturn(['status'=>0,'msg'=>'订单异常']);
				break;
		}
		if($pay_order['money'] < 0.01) $this->ajaxReturn(['status'=>0,'msg'=>'订单不存在']);
	 
	 	
		
		if($pay_order['out_trade_type'] == 0){	#微信支付-弃用
			$data['total_fee'] = $pay_order['money']*100;
			$Wechat = new \Org\Util\Wechat();
			$pay    = $Wechat->appPay($data);
			
			if($pay['return_code']=='ok'){
				$arr = $Wechat->appPayData($pay['info']['prepay_id']);
				return $this->ajaxReturn(['status'=>1,'out_trade_type'=>'0','msg'=>$arr]);
			}
		}elseif($pay_order['out_trade_type'] == 1){	#支付宝支付
			$gourl = 'http://'.$_SERVER['HTTP_HOST'].'/App/Alipay/app/AopSdk.php?money='.$pay_order['money'].'&order_sn='.$data['order_sn'];
			$res   = file_get_contents($gourl);
			$this->ajaxReturn(['status'=>1,'out_trade_type'=>1,'msg'=>$res,'reurl'=>$reurl]);
		}
		return $this->ajaxReturn(['status'=>0,'msg'=>'错误，请检查订单号']);

    }

    /**
     * app用户支付完成
     * @param 2017//11/11
     */
	// public function successOrder(){
	// 	$post = file_get_contents('php://input');
	// 	$data = json_decode($post,true);
	// 	if(empty($data)) $this->ajaxReturn(['status'=>0,'msg'=>'数据格式错误']);

	// 	$res  = D('Home/pay')->upPayInfo($data);
	// 	$this->ajaxReturn($res);
	// }
}