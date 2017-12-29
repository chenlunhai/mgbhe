<?php
namespace Home\Model;
use Think\Model;
use Think\Exception;
use Common\Service\WrcsService;
use Common\Service\SjbService;
class OrderModel extends Model{

	/**
	 * 返回订单资料
	 * @param 2017/11/10
	 * @param string $id
	 * @return array
	 */
	public function show_order($oid)
	{
		try {
			if(intval($oid) < 1) throw new Exception('订单异常', 10004);
			$WrcsService = new WrcsService();
			$order = $WrcsService->get_order_info($oid);
			if($order['status'] != 1) throw new Exception($order['msg'], $order['code']);
			
			session('oid',$order['msg']['id']);
			return ['status'=>1,'msg'=>$order['msg']];
		} catch (Exception $e) {
			session('oid',null);
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 创建订单并支付
	 * @param 2017/11/10
	 * @param array $data:uid,oid,out_trade_type
	 * @return array
	 */
	public function create_order($data)
	{
		try {
			$oid = session('oid');
			if(empty($oid)) throw new Exception('订单不存在，请重新扫码',10007);
			
			$check_res = check_data($data,['uid','out_trade_type']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);
			$check_trade_type = [0,1,2];
			if(!in_array($data['out_trade_type'], $check_trade_type)) throw new Exception("支付方式选择有误", 11009);
			$data['oid'] = $oid; unset($oid);

			$WrcsService = new WrcsService();
			$order = $WrcsService->get_order_info($data['oid']);
			if($order['status'] != 1) throw new Exception($order['msg'], $order['code']);

			$shop = M('shop_record')->where(['xid'=>$order['msg']['store_id']])->field('id,shopname')->find();
			if(empty($shop)) throw new Exception('该店设置异常', 11017);
			
			#预生成订单
			$in_order = [
				'uid'=>$data['uid'],'osn'=>self::create_order_sn(),'oprice'=>$order['msg']['total_price'],'sid'=>$shop['id'],'sname'=>$shop['shopname'],'pay_status'=>0,'out_trade_type'=>$data['out_trade_type'],'wid'=>$data['oid']
			];

			#余额支付
			if($in_order['out_trade_type'] == 2){
				$balance = D('user_estate')->get_user_estate($data['uid'],'balance');
				if($in_order['oprice'] > $balance['balance']) throw new Exception('购物券不足', 11008);
			}
			$inRes  = $this->add($in_order);
			if(!$inRes) throw new Exception('写入订单失败', 20000);	

			if($in_order['out_trade_type'] != 2){	#现金支付
				$payurl = getPayUrl($in_order['osn'],$in_order['out_trade_type']);
				return ['status'=>1,'msg'=>$payurl,'code'=>1];
			}

			$res = $this->complete_order(['order_sn'=>$in_order['osn'],'total_fee'=>$in_order['oprice'],'out_trade_no'=>'']);
			if($res['status'] != 1) throw new Exception($res['msg'], $res['code']);
			
			return ['status'=>1,'msg'=>U('Order/order_success'),'code'=>1];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 订单支付完成回调函数
	 * @param 2017/11/10
	 * @param array $data:order_sn,out_trade_no,total_fee
	 * @return array
	 */
	public function complete_order($data)
	{
		try {
			$check_res = check_data($data,['order_sn','out_trade_no','total_fee']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

			#验证订单是否支付完成
			$order = $this->where(['osn'=>$data['order_sn'],'pay_status'=>0,'oprice'=>$data['total_fee']])->field('wid,uid,id,oprice,out_trade_type')->find();
			if(empty($order)) throw new Exception("订单不存在或已支付", 11010);
			
			$up_estate = ['total_consumption'=>['exp','total_consumption+'.$order['oprice']]];
			$up_estate_where = ['id'=>$order['uid']];
			if($order['out_trade_type'] == 2){	#余额支付
				$balance = D('user_estate')->get_user_estate($order['uid'],'balance');
				if($balance['balance'] < $order['oprice']) throw new Exception('购物券不足', 11008);
				$in_balance = [
					'uid'=>$order['uid'],'state'=>1,'money'=>'-'.$order['oprice'],'current_money'=>($balance['balance']-$order['oprice']),'oid'=>$order['id'],'remark'=>'麦光宝盒消费'
				];
				$up_estate['balance'] = ['exp','balance-'.$order['oprice']];
				$up_estate_where['balance'] = ['egt',$order['oprice']];
			}

			$up_order = ['pay_status'=>1,'paytime'=>date('Y-m-d H:i:s',NOW_TIME),'out_trade_no'=>$data['out_trade_no']];

		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
		#开启事务处理
		$Model = new Model();
		$Model->startTrans();
		try {
			$upRes = $Model->table('__USER_ESTATE__')->where($up_estate_where)->limit(1)->save($up_estate);
			if(!$upRes) throw new Exception("购物券不足", 11008);
			if(isset($in_balance)){
				$inRes = $Model->table('__BALANCE_RECORD__')->add($in_balance);
				if(!$inRes) throw new Exception("写入购物券变动明细失败", 20000);
				$up_order['out_trade_no'] = $inRes;
			}

			$upRes = $Model->table('__ORDER__')->where(['id'=>$order['id'],'pay_status'=>0])->save($up_order);
			if(!$upRes) throw new Exception("更改订单状态失败", 20001);

			$Model->commit();
			#修改大盒子订单状态
			$WrcsService = new WrcsService();
			$WrcsService->up_order($order['wid']);

			#本次消费金额上报数钜宝
			$SjbService = new SjbService();
			$SjbService->report_sjb(['order_sn'=>$data['order_sn'],'money'=>$order['oprice'],'paytime'=>NOW_TIME,'uid'=>$order['uid']]);
			return ['status'=>1,'msg'=>'处理成功'];			
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 生成购物券充值订单号
	 * @param 2017/11/9
	 * @return string
	 */
	private function create_order_sn()
	{
		return '5'.date('YmdHis').rand(10000,99999);
	}

}