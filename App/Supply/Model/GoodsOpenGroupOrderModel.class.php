<?php
namespace Supply\Model;
use Think\Model;
use Think\Exception;

class GoodsOpenGroupOrderModel extends Model{

	/**
	 * 更改订单状态
	 * @param 2017-12-25 15:03:31
	 * @param array:id,trade,delivery_sn,did
	 * @return array
	 */
	public function up_order_trade($data)
	{
		try {
			$check_res = check_data($data,['id','trade','did']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg']);

			switch ($data['trade']) {
				case 2:	#订单发货
					$res = $this->up_order_delivery($data);
					if($res['status'] != 1) throw new Exception($res['msg'], $res['code']);
					break;
				
				default:
					throw new Exception('error #trade', 11000);
					break;
			}
			return $res;
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 订单发货
	 * @param 2017-12-25 15:07:25
	 * @param array:id,delivery_sn,did
	 */
	public function up_order_delivery($data)
	{
		try {
			$check_res = check_data($data,['id','delivery_sn','did']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

			$upRes = $this->where(['id'=>$data['id'],'trade'=>1,'did'=>$data['did']])->save(['trade'=>2,'delivery_sn'=>$data['delivery_sn'],'delivery_time'=>date('Y-m-d H:i:s',NOW_TIME)]);
			if(!$upRes) throw new Exception("当前订单无法进行发货操作", 0);
			
			return ['status'=>1,'msg'=>'操作成功'];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}


}