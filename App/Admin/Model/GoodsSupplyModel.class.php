<?php
namespace Admin\Model;
use Think\Exception;
use Think\Model;
class GoodsSupplyModel extends RunModel{

	/**
	 * 处理供货商商品审核状态
	 * @param 2017/11/6
	 * @param array $data:id,gstatus:1(通过)2(不通过)
	 */
	public function up_goods_supply_status($data)
	{
		try {
			$check_res = check_data($data,['id','gstatus']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg']);

			$up_goods = ['gstatus'=>$data['gstatus']];
			 
			if($data['gstatus'] == 2){	#更改商品状态，商品自动开团
				$goods = $this->where(['id'=>$data['id']])->field('did,gname,gprice,gteam_price,gnum,gimg,gcity,guser_limit,gpay_limit')->find();	#商品资料
				$goods['gid'] = $data['id']; $goods['gsn'] = '0001';
			}
			 
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage()];
		}
		#事务处理
		$Model = new Model();
		$Model->startTrans();
		try {
			$upRes = $Model->table('__GOODS_SUPPLY__')->where(['id'=>$data['id'],'status'=>1])->save($up_goods);
			if(!$upRes) throw new Exception("该商品状态无法更改");
			if(isset($goods)){
				$inRes = $Model->table('__GOODS_OPEN_GROUP__')->add($goods);
				if(!$inRes) throw new Exception("开团记录写入失败");
			}
			$Model->commit();
			return ['status'=>1,'msg'=>'操作成功'];
		} catch (Exception $e) {
			$Model->rollback();
			return ['status'=>0,'msg'=>$e->getMessage()];
		}
	}

}

