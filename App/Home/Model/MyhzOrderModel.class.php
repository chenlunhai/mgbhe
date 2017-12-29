<?php
namespace Home\Model;
use Think\Model;
use Common\Service\MyhzService;
use Common\Service\SjbService;
use Think\Exception;
class MyhzOrderModel extends Model{

	/**
	 * 蚂蚁盒子开门动作
	 * @param 2017-12-1 15:04:55
	 * @param array $data:uid,bid
	 * @param return 
	 */
	public function get_box_open($data)
	{
		try {
			$check_res = check_data($data,['uid','bid']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);
			$where = ['id'=>$data['uid']];
			$balance = M('user_estate')->where($where)->getField('balance');
			if($balance < 10) throw new Exception("当前余额低于10，请先充值", 11014);
			
			$mobile = M('user_account')->where($where)->getField('mobile');
			$MyhzService = new MyhzService;
			$res = $MyhzService->get_box_open(['mobile'=>$mobile,'uid'=>$data['uid'],'bid'=>$data['bid']]);
			if($res['status'] != 1) throw new Exception($res['msg'], 0);
			
			return ['status'=>1,'msg'=>'开门成功'];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 蚂蚁盒子支付订单处理
	 * @param 2017-11-30 17:36:15
	 * @param array $data:orderNum,customerMobile,totalPrice,discountTotalPrice,payTotalPrice,boxId
	 */
	public function pay_myhz_order($data)
	{
		try {
			unset($data['status']);
			$check_res = check_data($data,['orderNum','customerMobile','totalPrice','discountTotalPrice','payTotalPrice','boxId']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

			#验证订单是否已经存在
			$check_order = $this->where(['out_osn'=>$data['orderNum']])->count();
			if($check_order) throw new Exception("订单已存在", 11013);
			
			#验证boxId是否存在
			$bid = M('myhz')->where(['bid'=>$data['boxId']])->getField('id');
			if($bid < 1) throw new Exception("error #boxId",11000);
			#验证用户是否存在
			$uid = M('user_account')->where(['mobile'=>$data['customerMobile']])->getField('id');
			if($uid < 1) throw new Exception("error #customerMobile", 11000);
			
			$time = date('Y-m-d H:i:s',NOW_TIME);
			#写入订单
			$in_order = [
				'uid'=>$uid,'bid'=>$bid,'osn'=>self::create_order_sn(),'total_price'=>$data['totalPrice'],'discount_price'=>$data['discountTotalPrice'],'pay_price'=>$data['payTotalPrice'],'addtime'=>NOW_TIME,'out_osn'=>$data['orderNum'],'pay_status'=>1,'addtime'=>$time
			];
			#扣除用户购物券
			$up_estate = [
				'balance' => ['exp','balance-'.$in_order['pay_price']],
				'total_consumption' => ['exp','total_consumption+'.$in_order['pay_price']]
			];

			#余额变动写入明细
			$balance = M('user_estate')->where(['id'=>$uid])->getField('balance');	#当前余额
			$in_balance = [
				'uid'=>$uid,'state'=>2,'money'=>'-'.$in_order['pay_price'],'current_money'=>($balance-$in_order['pay_price']),'remark'=>'麦光宝盒消费','addtime'=>$time
			];
		} catch (Exception $e) {

			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
		#开启事务处理
		$Model = new Model;
		$Model->startTrans();
		try {
			$inRes = $Model->table('__MYHZ_ORDER__')->add($in_order);
			if(!$inRes) throw new Exception("蚂蚁盒子订单写入失败", 20000);
			$in_balance['oid'] = $inRes;
			$inRes = $Model->table('__BALANCE_RECORD__')->add($in_balance);
			if(!$inRes) throw new Exception("余额变动写入明细", 20000);
			$upRes = $Model->table('__USER_ESTATE__')->where(['id'=>$uid])->limit(1)->save($up_estate);
			if(!$upRes) throw new Exception("更改用户财产失败", 20001);
			
			$res['remark'] = '订单状态更改成功';
			$Model->commit();
		} catch (Exception $e) {
			$Model->rollback();
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
		#事务处理成功
		try {
			#请求蚂蚁盒子更改订单状态
			$MyhzService = new MyhzService;
			$res = $MyhzService->pay_order(['orderNum'=>$data['orderNum'],'boxId'=>$data['boxId'],'osn'=>$in_order['osn']]);
			if($res['status'] != 1) throw new Exception($res['msg']);
			
			#本次消费金额上报数钜宝
			$SjbService = new SjbService();
			$SjbService->report_sjb(['order_sn'=>$in_order['osn'],'money'=>$in_order['total_price'],'paytime'=>NOW_TIME,'uid'=>$in_order['uid']]);

			return ['status'=>1,'处理成功'];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage()];
		}
	}
	/**
	 * 生成蚂蚁盒子订单编号
	 * @param 2017/11/9
	 * @return string
	 */
	private static function create_order_sn()
	{
		return '4'.date('YmdHis').rand(10000,99999);
	}
}