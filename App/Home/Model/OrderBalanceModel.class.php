<?php
namespace Home\Model;
use Think\Model;
use Think\Exception;
class OrderBalanceModel extends Model{

	/**
	 * 充值购物券
	 * @param 2017/11/9
	 * @param array $data,key:uid,money,out_trade_type
	 * @return array
	 */
	public function pay_balance($data)
	{
		try {
			if(getclient()) throw new Exception("非常抱歉，目前暂不支持微信支付", 11012);
			$check_res = check_data($data,['money','uid','out_trade_type']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);
			if($data['money'] < 0.01)  throw new Exception('充值金额异常', 11004);
			if($data['out_trade_type'] != 0 && $data['out_trade_type'] != 1) throw new Exception('支付方式异常', 11005);
			
			$in_order_balance = [
				'uid'=>$data['uid'],'money'=>$data['money'],'out_trade_type'=>$data['out_trade_type'],'osn'=>$this->create_order_sn()
			];
			$inRes = $this->add($in_order_balance);
			if(!$inRes) throw new Exception('余额充值订单写入失败', 20000);
			
			$pay_url = getPayUrl($in_order_balance['osn'],$in_order_balance['out_trade_type']);
			return ['status'=>1,'msg'=>$pay_url];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}


	/**
	 * 充值成功回调函数
	 * @param 2017/11/9
	 * @param array $data,key:order_sn,out_trade_no,total_fee
	 */
	public function pay_complete($data)
	{
		try {
			$check_res = check_data($data,['order_sn','out_trade_no','total_fee']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

			$order = $this->where(['osn'=>$data['order_sn'],'money'=>$data['total_fee'],'pay_status'=>0])->field('uid,money,id')->find();
			if(empty($order)) throw new Exception('订单异常', 11006);
			
			$estate = D('user_estate')->get_user_estate($order['uid'],'balance');
			//充值成功
			$in_balance = [
				'uid'=>$order['uid'],'money'=>$order['money'],'state'=>0,'oid'=>$order['id'],'remark'=>'余额充值','current_money'=>($estate['balance']+$order['money'])
			];
			$up_estate = [
				'balance'=>['exp','balance+'.$order['money']],'total_balance'=>['exp','total_balance+'.$order['money']]
			];
			$up_order = [
				'pay_status'=>1,'paytime'=>date('Y-m-d H:i:s',NOW_TIME),'out_trade_no'=>$data['out_trade_no']
			];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
		
		#事务处理
		$Model = new Model();
		$Model->startTrans();
		try {
			$upRes = $Model->table('__ORDER_BALANCE__')->where(['id'=>$order['id'],'pay_status'=>0])->save($up_order);
			if(!$upRes) throw new Exception("error #update order_balance", 20001);
			$inRes = $Model->table('__BALANCE_RECORD__')->add($in_balance);
			if(!$inRes) throw new Exception('error #insert balance_record', 20000);
			$upRes = $Model->table('__USER_ESTATE__')->where(['id'=>$order['uid']])->limit(1)->save($up_estate);
			if(!$upRes) throw new Exception("error #update user_estate", 20001);
			
			$Model->commit();
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
		return '8'.date('YmdHis').rand(10000,99999);
	}

}