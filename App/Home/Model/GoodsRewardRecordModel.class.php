<?php
namespace Home\Model;
use Think\Model;
use Think\Exception;
class GoodsRewardRecordModel extends Model{
	private static $ratio = 0.2;
	private static $red_tnum = 50;	#红包总数
	/**
	 * 订单写入奖励记录
	 * @param 2017-12-18 15:52:38
	 * @param array:grid(开团id),id(订单id)
	 */
	public function add_reward($data)
	{
		try {
			$check_res = check_data($data,['grid','id']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

			 
			$res = $this->add_qs_reward($data);	#写入前三人参团奖励
			$this->add_p_reward($data);	#拼团者推荐人奖励
			$this->add_g_reward($data);	#供货商推荐人奖励
			$this->add_a_reward($data);	#省市代奖励
			$this->add_s_reward($data);	#三码飞店家团购交易完成后，该商品厂家、拼团者、拼团的推荐人各得到一个M*5%的红包，可以将该红包分享出去让大家抢（50份随机红包），抢到之后进入余额
			return ['status'=>1,'msg'=>'处理成功'];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	 /**
	  * 前三人参与拼团奖励积分
	  * @param 2017-12-18 15:12:45
	  * @param array:grid
	  */
	public function add_qs_reward($data)
	 {
	 	try {
	 		$check_res = check_data($data,['grid']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);
	 		
	 		

	 		$order =  M('goods_open_group_order')->where(['grid'=>$data['grid'],'pay_status'=>1,'trade'=>['in','1,2,3']])->group('uid')->field('uid,pay_price')->order('paytime asc')->limit(3)->select();
	 		if(empty($order)) throw new Exception("订单状态异常", 11010);
	 		 
	 	 	
	 		$ratio = [0.03,0.02,0.01];
	 		$in = [];
	 		foreach ($order as $key => $value) {
	 			#是否已经存在
				$check = $this->where(['grid'=>$data['grid'],'state'=>2,'uid'=>$value['uid']])->count();
				if($check > 0) continue;
				 
	 			$mprice = turnDecimal($value['pay_price'] * self::$ratio);
	 			$money = turnDecimal($mprice * $ratio[$key]);
	 			if($money < 0.01) continue;
	 			$in[] = [
	 				'uid'=>$value['uid'],'money'=>$money,'grid'=>$data['grid'],'oid'=>$data['id'],'state'=>2,'ratio'=>self::$ratio,'mprice'=>$mprice,'gid'=>$value['uid']
	 			];
	 		}
	 		if(empty($in)) throw new Exception("没有数据需要写入",0);
	 		$inRes = $this->addAll($in);
	 		if(!$inRes) throw new Exception("前三购买奖励写入失败");
	 		
	 		return ['status'=>1,'msg'=>'前三购买奖励写入成功'];
	 	} catch (Exception $e) {
	 		return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
	 	}
	 }
	/**
	 * 拼团者的上级奖励积分
	 * @param 2017-12-18 17:16:19
	 * @param array:grid,id
	 */
	public function add_p_reward($data)
	{
		try {
			$check_res = check_data($data,['id','grid']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

			#是否已经存在
			$check = $this->where(['oid'=>$data['id'],'state'=>0])->count();
			if($check > 0) throw new Exception('已计算奖金');
			
			$order =  M('goods_open_group_order')->where(['id'=>$data['id'],'pay_status'=>1,'trade'=>['in','1,2,3']])->field('uid,pay_price')->find();
	 		if(empty($order)) throw new Exception("订单状态异常", 11010);
	 		 
	 		$mprice = $order['pay_price'] * self::$ratio;
	 		$money = turnDecimal($mprice * 0.05);
	 		if($money < 0.01) throw new Exception("奖励低于0.01");

	 		$User = D('user_account');
	 		$in = [];
	 		$pids = $User->get_parent_uids($order['uid']);
 			foreach ($pids as $k => $v) {
 				if($v < 1) continue;
 				$in[] = ['uid'=>$v,'money'=>$money,'gid'=>$order['uid'],'oid'=>$data['id'],'grid'=>$data['grid'],'state'=>0,'ratio'=>self::$ratio,'mprice'=>$mprice];
 			}
	 		if(empty($in)) throw new Exception("无人领取");
	 		
	 		$inRes = $this->addAll($in);
	 		if(!$inRes) throw new Exception("拼团者推荐人奖励写入失败");
	 		
	 		return ['status'=>1,'msg'=>'拼团者推荐人奖励写入成功'];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 供货商推荐人奖励
	 * @param 2017-12-19 11:33:46
	 * @param array:grid,id
	 */
	public function add_g_reward($data)
	{
		try {
			$check_res = check_data($data,['grid','id']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

			#是否已经存在
			$check = $this->where(['oid'=>$data['id'],'state'=>1])->count();
			if($check > 0) throw new Exception('已计算奖金');

			$uid =  M('goods_open_group')->where(['id'=>$data['grid']])->getField('uid');	#供货商用户id
	 		if(empty($uid)) throw new Exception("该团不存在供货商");

	 		$order =  M('goods_open_group_order')->where(['id'=>$data['id'],'pay_status'=>1,'trade'=>['in','1,2,3']])->field('uid,pay_price')->find();
	 		if(empty($order)) throw new Exception("订单状态异常", 11010);

	 		$mprice = turnDecimal($order['pay_price'] * self::$ratio);
	 		$money = turnDecimal($mprice * 0.05);
	 		if($money < 0.01) throw new Exception("奖励低于0.01");
	 		$ids = D('user_account')->get_parent_uids($uid);
	 		$in = [];
	 		foreach ($ids as $k => $v) {
 				if($v < 1) continue;
 				$in[] = ['uid'=>$v,'money'=>$money,'gid'=>$uid,'state'=>1,'ratio'=>self::$ratio,'mprice'=>$mprice,'oid'=>$data['id'],'grid'=>$data['grid']];
 			}
 			if(empty($in)) throw new Exception("供货商推荐人为空");
 			
 			$inRes = $this->addAll($in);
	 		if(!$inRes) throw new Exception("供货商推荐人奖励写入失败");
	 		return ['status'=>1,'msg'=>"供货商推荐人奖励写入成功"];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 省代市代奖励
	 * @param 2017-12-19 15:42:06
	 * @param array:grid,id
	 */
	public function add_a_reward($data)
	{
		try {
			$check_res = check_data($data,['grid','id']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

			#是否已经存在
			$check = $this->where(['oid'=>$data['id'],'state'=>3])->count();
			if($check > 0) throw new Exception('已计算奖金');

			$order = M('goods_open_group_order')->where(['id'=>$data['id'],'pay_status'=>1,'trade'=>['in','1,2,3']])->field('uprovince,ucity,pay_price,uid')->find();
			if(empty($order)) throw new Exception("订单状态异常", 11010);
			
			$mprice = turnDecimal($order['pay_price'] * self::$ratio);
			$pmoney = turnDecimal($mprice * 0.05);
			$cmoney = turnDecimal($mprice * 0.15);
			
			$User = M('user_account');
			$Agent = M('agent_record');
			$in = [];

			if($pmoney > 0){	#计算省代奖金
				$total_fee = $Agent->where(['province'=>$order['uprovince']])->getField('sum(money)');	#该省所交代理费
				$province = $User->where(['a.province'=>$order['uprovince'],'e.agent_grade'=>2])->join('a left join  __USER_ESTATE__ e on a.id=e.id')->field('e.agent_fee,a.id')->select();
				foreach ($province as $key => $value) {
					$umoney = turnDecimal($value['agent_fee'] / $total_fee * $pmoney);
					if($umoney < 0.01) continue;

					$in[] = ['uid'=>$value['id'],'money'=>$umoney,'grid'=>$data['grid'],'oid'=>$data['id'],'gid'=>$order['uid'],'mprice'=>$mprice,'state'=>3];
				}
			}
			
			if($cmoney > 0){	#计算市代奖金
				$total_fee = $Agent->where(['province'=>$order['uprovince'],'city'=>$order['ucity'],'state'=>1])->getField('sum(money)');	#该市所交代理费
				$city = $User->where(['a.city'=>$order['ucity'],'e.agent_grade'=>1])->join('a left join  __USER_ESTATE__ e on a.id=e.id')->field('e.agent_fee,a.id')->select();
				foreach ($city as $key => $value) {
					$umoney = turnDecimal($value['agent_fee'] / $total_fee * $cmoney);
					if($umoney < 0.01) continue;
					$in[] = ['uid'=>$value['id'],'money'=>$umoney,'grid'=>$data['grid'],'oid'=>$data['id'],'gid'=>$order['uid'],'mprice'=>$mprice,'state'=>3];
				}
			}
 			if(empty($in)) throw new Exception("该订单无人得代理奖");
			 
			$inRes = $this->addAll($in);
	 		if(!$inRes) throw new Exception("代理奖写入失败");
	 		return ['status'=>1,'msg'=>"代理奖写入成功"];

		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	// /**
	//  * 省代市代奖励-一次执行，现在改为了每个订单一条记录
	//  * @param 2017-12-19 15:42:06
	//  * @param array:grid,mprice
	//  */
	// public function add_a_reward($data)
	// {
	// 	try {
	// 		$check_res = check_data($data,['grid','mprice']);
	// 		if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

	// 		$pmoney = turnDecimal($data['mprice'] * 0.05);	#省代奖励
	// 		$order = M('goods_open_group_order')->where(['grid'=>$data['grid'],'pay_status'=>1,'trade'=>['in','1,2,3']])->field('uprovince,ucity,pay_price')->select();
			 
	// 		$tmp_province = [];
	// 		$tmp_order = $order;
	// 		foreach ($order as $key => $value) {
	// 			foreach ($tmp_order as $k => $v) {
	// 				if($value['uprovince'] == $v['uprovince']){
	// 					$tmp_province[$value['uprovince']]['pay_price'] += $v['pay_price'];
	// 					unset($tmp_order[$k]);
	// 				}
	// 			}
	// 		}
	// 		$tmp_order = $order;
	// 		foreach ($order as $key => $value) {
	// 			foreach ($tmp_order as $k => $v) {
	// 				if($value['uprovince'] == $v['uprovince'] && $value['ucity'] == $v['ucity']){
	// 					$tmp_province[$value['uprovince']]['city'][$value['ucity']] += $v['pay_price'];
	// 					unset($tmp_order[$k]);
	// 				}
	// 			}
	// 		}unset($tmp_order);
	// 		$User = M('user_account');
	// 		$Agent = M('agent_record');
	// 		$in = [];
 
	// 		foreach ($tmp_province as $key => $value) {
	// 			$money = turnDecimal($value['pay_price'] * 0.05);
	// 			$uprovince = $User->where(['a.province'=>$key,'e.agent_grade'=>2])->join('a left join  __USER_ESTATE__ e on a.id=e.id')->field('e.agent_fee,a.id')->select();
	// 			if(empty($uprovince)) continue;
	// 			$total_fee = $Agent->where(['province'=>$key])->getField('sum(money)');	#该省所交代理费

	// 			foreach ($uprovince as $k => $v) {
	// 				$umoney = turnDecimal($v['agent_fee'] / $total_fee * $money);
	// 				$in[] = ['uid'=>$v['id'],'money'=>$umoney,'gid'=>$data['grid']];
	// 			}
			 
	// 			foreach ($value['city'] as $k => $v) {
	// 				$cmoney = turnDecimal($v * 0.15);
	// 				$ucity = $User->where(['a.province'=>$key,'a.city'=>$k,'e.agent_grade'=>1])->join('a left join  __USER_ESTATE__ e on a.id=e.id')->field('e.agent_fee,a.id')->select();
	// 				if(empty($ucity)) continue;
	// 				$total_fee = $Agent->where(['province'=>$key,'city'=>$k,'state'=>1])->getField('sum(money)');	#该市所交代理费
	// 				foreach ($ucity as $kk => $vv) {
	// 					$umoney = turnDecimal($vv['agent_fee'] / $total_fee * $cmoney);
	// 					$in[] = ['uid'=>$vv['id'],'money'=>$umoney,'gid'=>$data['grid']];
	// 				}
	// 			}
	// 		}
			 
	// 		$this->where(['grid'=>$data['grid'],'astate'=>0])->setField('adata',json_encode($in));
	// 	} catch (Exception $e) {
	// 		return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
	// 	}
	// }
	/**
	 * 三码飞店家团购交易完成后，该商品厂家、拼团者、拼团的推荐人各得到一个M*5%的红包，可以将该红包分享出去让大家抢（50份随机红包），抢到之后进入余额
	 * @param 2017-12-20 10:01:26
	 */
	public function add_s_reward($data){
		try {
			$check_res = check_data($data,['grid','id']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

			$group = M('goods_open_group')->where(['id'=>$data['grid']])->field('guser_limit,uid')->find();
			if($group['guser_limit'] != 1) throw new Exception("该团不是店家团", 0);

			$order = M('goods_open_group_order')->where(['id'=>$data['id'],'pay_status'=>1,'trade'=>['in','0,1,2']])->field('pay_price,uid')->find();
			if(empty($order)) throw new Exception("订单状态异常", 11010);

			#是否存在
			$check = M('red_packet')->where(['oid'=>$data['id'],'gid'=>$order['uid']])->count();
			if($check > 1) throw new Exception("已发放过奖励");

			$mprice = turnDecimal($order['pay_price'] * self::$ratio);
			$money  = turnDecimal($mprice * 0.05);
			if($money < 0.5) throw new Exception("奖励金额低于0.5");
			$date = date('Ymd',NOW_TIME);
			$in = [];
			#给拼团者这奖励红包
			$in[0] = ['uid'=>$order['uid'],'money'=>$money,'state'=>0,'oid'=>$data['id'],'grid'=>$data['grid'],'status'=>0,'gid'=>$order['uid'],'token'=>$date.$this->red_rand_token(8),'num'=>self::$red_tnum];
			#给商品厂家奖励红包
			$in[1] = ['uid'=>$group['uid'],'money'=>$money,'state'=>1,'oid'=>$data['id'],'grid'=>$data['grid'],'status'=>0,'gid'=>$order['uid'],'token'=>$date.$this->red_rand_token(8),'num'=>self::$red_tnum];
			#给拼团这推荐人奖励红包
			$ids = D('user_account')->get_parent_uids($order['uid']);
			foreach ($ids as $k => $v) {
 				if($v < 1) continue;
 				$in[] = ['uid'=>$v,'money'=>$money,'state'=>2,'oid'=>$data['id'],'grid'=>$data['grid'],'status'=>0,'gid'=>$order['uid'],'token'=>$date.$this->red_rand_token(8),'num'=>self::$red_tnum];
 			}
 			if(empty($in)) throw new Exception("没有数据需要写入");
 			
 			$inRes = M('red_packet')->addAll($in);
 			if(!$inRes) throw new Exception("红包记录写入失败");
 			
 			return ['status'=>1,'msg'=>'红包奖励写入成功'];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	function red_rand_token($nc, $a='0123456789'){
        $l=strlen($a)-1; $r='';   
        while($nc-->0) $r.=$a{mt_rand(0,$l)};   
        $rand= mt_rand(1,9).$r;  
        return $rand;
    }
}