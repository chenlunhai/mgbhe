<?php
namespace Supply\Model;
use Think\Model;
use Think\Exception;
use Common\Model\UploadModel;
class GoodsSupplyModel extends Model{


	/**
	 * 添加商品
	 * @param 2017-12-9 17:04:59
	 * @param array $data:gname,gprice,gnum,gimg,gcity,guser_limit,gpay_limit
	 * @return array
	 */
	public function add_goods_supply($data)
	{
		try {
			$check_res = check_data($data,['gname','gprice','gcity','gnum','guser_limit','gpay_limit','gcontent']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg']);

			if(empty($data['gcity'])) throw new Exception("支持城市异常");
			$data['gcity'] = implode(',',$data['gcity']);

			if($_FILES['gimg']['size'] > 0){	#商品图片
				$Upload = new UploadModel();
				$res = $Upload->upload('gimg','./Uploads/GoodsSupply/');
	        	if($res['status'] == 1) $data['gimg'] = $res['msg'][0];
	        	else throw new Exception('图片大小超过限制', 0);
			}
			 
			 
			
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage()];
		}
		#开启事务
		$Model = new Model();
		$Model->startTrans();
		try {
			$gid = $Model->table('__GOODS_SUPPLY__')->add($data);
			if(!$gid) throw new Exception("写入商品时失败",20000);
			if(isset($in_goods_attr)){
				foreach ($in_goods_attr as $key => $value) {
					$in_goods_attr[$key]['gid'] = $gid;
				}
				
				$inRes = $Model->table('__GOODS_SUPPLY_ATTR__')->addAll($in_goods_attr);
				if(!$inRes) throw new Exception("商品规格写入失败", 2000);
			}
			$Model->commit();
			return ['status'=>1,'msg'=>'添加商品成功'];			
		} catch (Exception $e) {
			$Model->rollback();
			return ['status'=>0,'msg'=>$e->getMessage()];
		}
	}
	/**
	 * 修改拼团商品
	 * @param 2017-12-11 15:38:17
	 * @param
	 * @return array
	 */
	public function up_goods_supply($data)
	{
		try {
			$check_res = check_data($data,['gname','gprice','gcity','gnum','guser_limit','gpay_limit','gcontent','id']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg']);

			#验证商品是否可以修改， 已开团、待管理员审核状态不可更改
			$check_up = $this->where(['id'=>$data['id'],'gstatus'=>['between',[1,2]]])->count();
			if($check_up > 0) throw new Exception("当前商品状态无法更改", 0);
			
			if(empty($data['gcity'])) throw new Exception("支持城市异常");
			$data['gcity'] = implode(',',$data['gcity']);

			if($_FILES['gimg']['size'] > 0){	#商品图片
				$Upload = new UploadModel();
				$res = $Upload->upload('gimg','./Uploads/GoodsSupply/');
	        	if($res['status'] == 1) $data['gimg'] = $res['msg'][0];
	        	else throw new Exception('图片大小超过限制', 0);
			}
			 
			if(!empty($data['attr_name'][0])){	#商品规格
				$in_goods_attr = [];
				foreach ($data['attr_name'] as $key => $value) {
					$in_goods_attr[$key] = [
						'attr_name' => $value,'attr_stock'=>$data['attr_stock'][$key],'gid'=>$data['id'],'id'=>$data['attr_id'][$key]
					];
				}
			}

		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage()];
		}
		#开启事务处理
		$Model = new Model();
		$Model->startTrans();
		try {
			$data['gupdatetime'] = date('Y-m-d H:i:s',NOW_TIME);
			$upRes = $Model->table('__GOODS_SUPPLY__')->where(['id'=>$data['id'],'status'=>0])->save($data);
			if(!$upRes) throw new Exception("当前商品状态无法更改");
			
			if(isset($in_goods_attr)){
				$Model->table('__GOODS_SUPPLY_ATTR__')->where(['gid'=>$data['id']])->delete();
				foreach ($in_goods_attr as $key => $value) {
					$Model->table('__GOODS_SUPPLY_ATTR__')->add($value);
				}
			}
			$Model->commit();
			return ['status'=>1,'msg'=>'编辑成功'];			

		} catch (Exception $e) {
			$Model->rollback();
			return ['status'=>0,'msg'=>$e->getMessage()];
		}
	}
	/**
	 * 删除商品规格, 已开团、待管理员审核状态时不可更改
	 * @param 2017-12-11 16:07:11
	 * @param array $data:id,gid
	 * @return array
	 */
	public function del_goods_supply_attr($data)
	{
		try {
			$check_res = check_data($data,['id','gid']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg']);

			#验证商品是否可以修改， 已开团、待管理员审核状态不可更改
			$check_up = $this->where(['id'=>$data['gid'],'gstatus'=>['between',[1,2]]])->count();
			if($check_up > 0) throw new Exception("当前商品状态无法更改", 0);

			$delRes = M('goods_supply_attr')->where(['id'=>$data['id'],'gid'=>$data['gid']])->limit(1)->delete();
			if(!$delRes) throw new Exception("商品规格删除失败");
			
			return ['status'=>1,'msg'=>'删除成功'];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage()];
		}
	}
	/**
	 * 商品删除-物理删除， 已开团、待管理员审核状态时不可更改
	 * @param 2017-12-11 16:10:02
	 * @param array $data:did,id
	 * @return array
	 */
	public function del_goods_supply($data)
	{
		try {
			$check_res = check_data($data,['did','id']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg']);

			#验证商品是否可以修改， 已开团、待管理员审核状态不可更改
			$check_up = $this->where(['id'=>$data['id'],'gstatus'=>['between',[1,2]]])->count();
			if($check_up > 0) throw new Exception("当前商品状态无法删除", 0);

			$where = ['did'=>$data['did'],'id'=>$data['id']];
			$goods = $this->where($where)->field('gimg,gcontent')->find();	#商品主图不删除，详情图片物理删除
			
			#确定该商品是否购买
			$check_pay = M('goods_supply_order_attr')->where(['gid'=>$where['id']])->count();
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage()];
		}
		$Model = new Model();
		$Model->startTrans();
		try {
			$where['status'] = 0;
			$delRes = $Model->table('__GOODS_SUPPLY__')->where($where)->limit(1)->delete();
			if(!$delRes) throw new Exception("当前商品状态无法删除");
			$Model->table('__GOODS_SUPPLY_ATTR__')->where(['gid'=>$where['id']])->delete();

			if(!empty($goods['gcontent'])){	#详情图片物理删除
				$preg ='<&lt;img.*?src=&quot;(.*?)&quot;>';
				preg_match_all($preg,$goods['gcontent'],$res);
				if(!empty($res[1])){
					foreach ($res[1] as $key => $value) {
						if(empty($value)) continue;
						unlink($_SERVER['DOCUMENT_ROOT'].$value);
					}
				}
			}	
			if($check_pay < 1){	#0没有人购买物理删除，>1已有用户购买，为了在我的订单里能正常显示不删除主图
				unlink($_SERVER['DOCUMENT_ROOT'].'/'.$goods['gimg']);
			}
			$Model->commit();
			return ['status'=>1,'msg'=>'删除成功'];
		} catch (Exception $e) {
			$Model->rollback();
			return ['status'=>0,'msg'=>$e->getMessage()];
		}
	}
	/**
	 * 商品提交审核
	 * @param 2017-12-25 10:12:48
	 * @param string id
	 */
	public function up_gstatus($id){
		try {
			if(intval($id) < 1) throw new Exception("error #id", 11000);
			
			$upRes = $this->where(['id'=>$id,'gstatus'=>0])->setField('gstatus',1);
			if(!$upRes) throw new Exception("当前商品状态无法提交审核");
			
			return ['status'=>1,'msg'=>'操作成功'];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 返回分类信息
	 * @param 2017-12-25 16:41:05
	 * @return array
	 */
	public function get_goods_supply_cate()
	{
		$Cate = M('goods_supply_cate');
		$cate = $Cate->where(['pid'=>0])->field('id,name')->order('sort asc')->select();
		foreach ($cate as $key => $value) {
			$cate[$key]['cate'] = $Cate->where(['pid'=>$value['id']])->order('sort asc')->select();
		}
		return $cate;
	}
}