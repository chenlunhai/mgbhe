<?php
/**
 * 无人店通信类
 * @param 2017/11/2
 */
namespace Common\Service;
use Think\Controller;
use Think\Model;
use Think\Exception;
class WrcsService{
	protected static $db_config = 'mysql://m_wrcs:@siwu1110@rm-wz9lf712zaeithw4mo.mysql.rds.aliyuncs.com/m_wrcs#utf8';
	protected static $db_prefix = 'z_';
	/**
	 * 查询订单
	 * @param 2017/11/9
	 * @param string $id
	 * @return array
	 */
	public function get_order_info($id)
	{
		try {
			if($id < 1) throw new Exception('订单ID异常', 10004);
			
			$Order = M('orders',self::$db_prefix,self::$db_config); 
			$order = $Order->where(['id'=>$id,'status'=>0])->field('total_price,store_id,id')->find();
			if(empty(order)) throw new Exception('订单不存在', 10002);
			
			if($order['total_price'] < 0.01) throw new Exception('支付金额过低',10003);
			
			return ['status'=>1,'msg'=>$order];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 更改指定订单状态
	 * @param 2017/11/10
	 * @param string $id
	 * @return array
	 */
	public function up_order($id)
	{
		try {
			if($id < 1) throw new Exception('订单ID异常', 10004);
			$Order = M('orders',self::$db_prefix,self::$db_config); 
			$where = ['id'=>$id,'status'=>0];
			$order = $Order->where($where)->field('total_price,store_id,id')->find();
			if(empty($order)) throw new Exception('订单不存在或已支付', 10002);
			
			$up_order = ['status'=>1,'pay_method'=>'已支付'];
			$upRes = $Order->where($where)->limit(1)->save($up_order);
			if(!$upRes) throw new Exception("更改大盒子订单状态失败", 10006);

			return ['status'=>1,'msg'=>'处理成功'];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 开门动作
	 * @param 2017/11/10
	 * @param string $mobile
	 */
	public function opendoor($mobile)
	{
		try {
			if(empty($mobile)) throw new Exception('error #mobile',11000);
			
			$in = [
				'mobile' => $mobile,'detail'=>'用户开门','create_time'=>NOW_TIME
			];
			$Lock = M('locklog',self::$db_prefix,self::$db_config); 
			$inRes = $Lock->add($in);
			if(!$inRes) throw new Exception("写入开门记录失败", 10005);
			
			sleep(2);
			return ['status'=>1,'msg'=>'开门成功'];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
}
 