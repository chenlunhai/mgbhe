<?php
namespace Home\Model;
use Think\Model;
use Think\Exception;
class UserEstateModel extends Model{

 	/**
 	 * 返回用户财产信息
 	 * @param 2017/11/9
 	 * @param string $uid,string $field
 	 */
 	public function get_user_estate($uid,$field='*')
 	{
 		return M('user_estate')->where(['id'=>$uid])->field($field)->find();
 	}
 	/**
 	 * 用户提现
 	 * @param 2017-12-29 17:15:01
 	 * @param array:uid,money
 	 * @return array
 	 */
 	public function up_user_balance($data)
 	{
 		try {
 			if(intval($data['uid']) < 1) throw new Exception("error #uid", 11000);
 			if($data['money'] < 1) throw new Exception("提现金额必须大于1");

 			#余额是否足够
 			$balance = $this->where(['id'=>$data['uid']])->getField('balance');
 			if($balance < $data['money']) throw new Exception("余额不足", 0);
 			
 			#信息是否完整
 			$user = M('user_account')->where(['id'=>$data['uid']])->field('bank_user,bank_address,bank_card,realname')->find();
 			if(empty($user['bank_address']) || empty($user['bank_user']) || empty($user['bank_card']) || empty($user['realname'])) throw new Exception("请先完善个人信息", 11025);
 			
 			#写入余额记录
 			$in_balance = [
 				'uid'=>$data['uid'],'money'=>'-'.$data['money'],'current_money'=>$balance-$data['money'],'state'=>6,'remark'=>'申请提现',
 			];
 			#写入提现记录
 			$in_cash = [
 				'uid'=>$data['uid'],'money'=>$data['money'],'fee'=>0,'account'=>$user['bank_user'].','.$user['bank_card'].','.$user['address'].','.$user['realname'],'cash_type'=>1,'state'=>0
 			];
 		} catch (Exception $e) {
 			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
 		}
 		$Model = new Model();
 		$Model->startTrans();
 		try {
 			$upRes = $this->where(['id'=>$data['uid'],'balance'=>['egt',$data['money']]])->limit(1)->setDec('balance',$in_cash['money']);
 			if(!$upRes) throw new Exception("修改财产信息失败", 20001);
 			$inRes = $Model->table('__USER_CASH_RECORD__')->add($in_cash);
 			if(!$inRes) throw new Exception("写入提现记录失败", 20000);
 			$in_balance['oid'] = $inRes;
 			$inRes = $Model->table('__BALANCE_RECORD__')->add($in_balance);
 			if(!$inRes) throw new Exception("写入余额记录失败", 20000);
 			

 			$Model->commit();
 			return ['status'=>1,'msg'=>'操作成功'];
 		} catch (Exception $e) {
 			$Model->rollback();
 			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
 		}
 	}
 	/**
 	 * 积分换余额
 	 * @param 2017-12-23 15:22:27
 	 * @param array:uid,money
 	 * @return array
 	 */
 	public function turn_integral_balance($data)
 	{
 		try {
 			if(intval($data['uid']) < 1) throw new Exception("error #uid", 11000);
 			if($data['money'] < 1) throw new Exception("转换数额必须大于1");
	
			$user = $this->get_user_estate($data['uid'],'balance,integral');
			if($user['integral'] < $data['money']) throw new Exception("积分不足");

			$in_balance = [
				'uid'=>$data['uid'],'state'=>5,'money'=>$data['money'],'current_money'=>$user['balance']+$data['money'],'remark'=>'通过积分兑换',
			];
			$in_integral = [
				'uid'=>$data['uid'],'state'=>0,'money'=>'-'.$data['money'],'current_money'=>$user['integral']-$data['money'],'remark'=>'兑换余额'
			];
			$up_estate = [
				'balance'=>['exp','balance+'.$data['money']],'total_balance'=>['exp','total_balance+'.$data['money']],
				'integral'=>['exp','integral-'.$data['money']],
			];
 		} catch (Exception $e) {
 			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
 		}
 		#开启事务处理
 		$Model =  new Model();
 		$Model->startTrans();
 		try {
 			$upRes = $Model->table('__USER_ESTATE__')->where(['id'=>$data['uid'],'integral'=>['egt',$data['money']]])->limit(1)->save($up_estate);
 			if(!$upRes) throw new Exception("积分不足", 20001);
 			$inRes = $Model->table('__INTEGRAL_RECORD__')->add($in_integral);
 			if(!$inRes) throw new Exception("写入积分明细失败", 20000);
 			$inRes = $Model->table('__BALANCE_RECORD__')->add($in_balance);
 			if(!$inRes) throw new Exception("写入余额明细失败", 20000);

			$Model->commit();
			return ['status'=>1,'msg'=>'操作成功']; 			
 		} catch (Exception $e) {
 			$Model->rollback();
 			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
 		}
 	}
}