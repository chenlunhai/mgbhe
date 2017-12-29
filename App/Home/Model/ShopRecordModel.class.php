<?php
namespace Home\Model;
use Think\Model;
use Think\Exception;
class ShopRecordModel extends Model{

	/**
	 * 增加店主可提现余额
	 * @param 2017-12-8 15:21:24
	 * @param array $data:money,oid,state
	 * @return array
	 */
	public function add_shop_money($data)
	{
		try {
			$check_res = check_data($data,['money','oid','state']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

			#验证订单是否已经增加过余额
			$check_oid = $this->where(['oid'=>$data['oid']])->count();
			if($check_oid > 0) throw new Exception("订单已交易完成");
			
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage()];
		}
	}


}