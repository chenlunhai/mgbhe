<?php
namespace Home\Model;
use Think\Model;
use Think\Exception;
class RedPacketModel extends Model{


	/**
	 * 返回用户现有的红包
	 * @param 2017-12-23 10:13:37
	 * @param array:uid,page
	 */
	public function get_user_red_packet_list($data)
	{
		try {
			if(intval($data['uid']) < 1) throw new Exception('error #uid', 11000);
			
			$limit = D('goods_open_group')->getLimit($data['page']);
			$red_packet = $this->where(['uid'=>$data['uid']])->field('token,money,status,addtime')->limit($limit)->order('id desc')->select();
			
			return ['status'=>1,'data'=>$red_packet];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 返回用户已抢到的红包记录
	 * @param 2017-12-23 10:18:05
	 * @param array:uid,page
	 */
	public function get_user_take_red_packet($data)
	{
		try {
			if(intval($data['uid']) < 1) throw new Exception('error #uid', 11000);

			$limit = D('goods_open_group')->getLimit($data['page']);
			$red_packet = M('red_packet_record')->where(['r.uid'=>$data['uid']])->join('r left join __USER_ACCOUNT__ a on r.gid=a.id')->field('r.money,r.gettime,a.realname')->limit($limit)->order('r.id desc')->select();

			return ['status'=>1,'data'=>$red_packet];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 返回红包已抢明细
	 * @param 2017-12-22 16:39:42
	 * @param array:token,page
	 */
	public function get_red_packet_list($data)
	{
		try {
			$check_res = check_data($data,['token']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

			$rid = $this->where(['token'=>$data['token']])->getField('id');
			if($rid < 1) throw new Exception("token #error", 11000);
			
			$limit 	= D('goods_open_group')->getLimit($data['page'],10);
			$record = M('red_packet_record')->where(['r.uid'=>['gt',0],'r.rid'=>$rid])->join('r left join __USER_ACCOUNT__ a on r.uid=a.id')->field('r.uid,r.money,a.realname')->limit($limit)->order('r.addtime desc')->select();

			 
			return ['status'=>1,'data'=>$record];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 返回用户抢了多少钱
	 * @param 2017-12-22 17:05:26
	 * @param array:uid,token
	 */
	public function get_user_red_packet($data)
	{
		try {
			$check_res = check_data($data,['token','uid']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

			$rid = $this->where(['token'=>$data['token']])->field('cnum,num,money,cmoney,id')->find();
			if(empty($rid)) throw new Exception("token #error", 11000);

			$rid['realname'] = M('user_account')->where(['id'=>$data['uid']])->getField('realname');

			$money = M('red_packet_record')->where(['rid'=>$rid['id'],'uid'=>$data['uid']])->getField('money');
			$rid['user_money'] = $money>0?$money:'0.00';
			return ['status'=>1,'data'=>$rid]; 
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 通过红包令牌返回红包信息
	 * @param 2017-12-22 11:30:28
	 * @param string
	 * @return array
	 */
	public function get_red_packet_info($token)
	{
		try {
			if(empty($token)) throw new Exception("error #token", 11000);
			
			$red_packet = $this->where(['r.token'=>$token])->join('r left join __USER_ACCOUNT__ a on r.uid=a.id')->field('a.realname,status')->find();
			if(empty($red_packet)) throw new Exception("红包不存在", 0);
			
			return ['status'=>1,'msg'=>$red_packet];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 用户领取红包点击抢的动作
	 * @param 2017-12-22 11:34:22
	 * @param array:uid,token
	 * @return array
	 */
	public function up_red_packet($data)
	{
		try {
			$check_res = check_data($data,['token','uid']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

			$red_packet = $this->where(['token'=>$data['token'],'status'=>0])->field('id,grid,addtime,money,num,cnum,uid')->find();
			if(empty($red_packet)) throw new Exception("红包不存在或已过7天时限", 11022);
			
			#得到红包金额
			$red_record = $this->create_red_packet($red_packet);
			if(isset($red_record['status'])) throw new Exception($red_record['msg'], $red_record['code']);

			if($data['uid']>0){
				#判断红包是否能领取
				$check_res = $this->check_red_packet($data['uid'],$red_packet);
				if($check_res['status'] != 1) throw new Exception($check_res['msg'], $check_res['code']);
			}else{
				return ['status'=>-1,'msg'=>U('Login/index')];
			}
			

			 
			$balance = M('user_estate')->where(['id'=>$data['uid']])->getField('balance');
			$in_balance = [
				'uid'=>$data['uid'],'state'=>4,'money'=>$red_record['money'],'current_money'=>$balance,'remark'=>'拼采廉红包','oid'=>$red_packet['id']
			];
			$up_esteate = [
				'balance'=>['exp','balance+'.$red_record['money']],
				'total_balance'=>['exp','total_balance+'.$red_record['money']],
				'total_red_packet'=>['exp','total_red_packet+'.$red_record['money']]
			];
			$up_red_packet_record = [
				'uid'=>$data['uid'],'gettime'=>date('Y-m-d H:i:s',NOW_TIME),
			];
			$up_red_packet = [
				'cnum'=>['exp','cnum+1'],'cmoney'=>['exp','cmoney+'.$red_record['money']],
			];

		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
		#开启事务处理
		$Model = new Model();
		$Model->startTrans();
		try {
			$upRes = $Model->table('__USER_ESTATE__')->where(['id'=>$data['uid']])->limit(1)->save($up_esteate);
			if(!$upRes) throw new Exception("更改用户财产信息失败", 20000);
			$upRes = $Model->table('__RED_PACKET__')->where(['id'=>$red_packet['id']])->limit(1)->save($up_red_packet);
			if(!$upRes) throw new Exception("更改红包数据失败", 20000);
			$inRes = $Model->table('__BALANCE_RECORD__')->add($in_balance);
			if(!$inRes) throw new Exception("写入余额记录失败",20000);
			$upRes = $Model->table('__RED_PACKET_RECORD__')->where(['id'=>$red_record['id'],'uid'=>0])->limit(1)->save($up_red_packet_record);
			if(!$upRes) throw new Exception("该红包已领取",20000);
			
			$Model->commit();
			return ['status'=>1,'msg'=>'领取成功'];
		} catch (Exception $e) {
			$Model->rollback();
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 红包是否过期
	 * @param 2017-12-22 15:51:09
	 * @param string $uid、array:addtime,id,num,cnum,grid
	 * @return array
	 */
	public function check_red_packet($uid,$data)
	{
		try {
			if(intval($uid) < 1) throw new Exception("error #uid", 11000);
			
			$stime = strtotime($data['addtime']);
			if(($stime+604800) < NOW_TIME){	#红包有效期7天，成立说明红包已过期
				$this->where(['id'=>$data['id']])->limit(1)->setField('status',1);
				throw new Exception("红包已过期",11022);
			}
			if($data['cnum'] >= $data['num']){
				$this->where(['id'=>$data['id']])->limit(1)->setField('status',1);
				throw new Exception("红包已抢完",11023);
			}
			$check = M('red_packet_record')->where(['grid'=>$data['grid'],'uid'=>$uid])->count();
			if($check > 0) throw new Exception('本团您已领取过红包', 11024);
			
			return ['status'=>1];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 生产红包随机数额
	 * @param 2017-12-22 11:40:55
	 * @param array:money,num,grid,id
	 * @return array
	 */
	public function create_red_packet($data)
	{
		try {
			$check_res = check_data($data,['money','num','id','grid']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

			$Record = M('red_packet_record');
			$record = $Record->where(['rid'=>$data['id'],'uid'=>0])->field('money,id')->find();
			if(!empty($record)) return $record;

			$min_money = 0.01;
			$min_num = $data['num'] * $min_money;
			if($min_num > $data['money']) throw new Exception("红包异常");
			$min_money *= 100;
			$in = [];
			$total = '0';
			$count_money = $data['money']*100;
			$average = $data['num'] /2;
			for ($i=1; $i <= $data['num']; $i++) { 
				$min = ($data['num'] - $i) * $min_money; #最小金额
				$max = $count_money - $min;	#本次最大金额
				if($average > $key){
					$max /= 3; #校准值
					 
				}
				$count_money -= $money = rand(1,$max);
				$in[] = ['rid'=>$data['id'],'grid'=>$data['grid'],'money'=>$money,'gid'=>$data['uid']];
			}
			 
			$rand_num = rand(0,$data['num']-1);
			$in[$rand_num]['money'] += $count_money;
			foreach ($in as $key => $value) {
				$in[$key]['money'] /= 100;
				$total += $in[$key]['money'];
			}
			shuffle($in);
			 
		 	if(intval($total) != intval($data['money'])) throw new Exception('红包异常', 0);
		 	$inRes = M('red_packet_record')->addAll($in);
			if(!$inRes) throw new Exception("写入红包明细失败", 0);
			
			$record = $Record->where(['rid'=>$data['id'],'uid'=>0])->field('money,id')->find();
			return $record;
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
}