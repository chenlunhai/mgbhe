<?php
namespace Home\Model;
use Think\Model;
use Think\Exception;
class GoodsSupplyModel extends Model{

	/**
	 * 返回商品详情
	 * @param 2017-12-25 16:28:14
	 * @param array:id
	 * @return string
	 */
	public function get_goods_detail($id)
	{
		try {
			
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage()];
		}
	}

}