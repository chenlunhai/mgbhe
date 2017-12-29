<?php
namespace Home\Model;
use Think\Exception;
use Think\Model;
class GoodsOpenGroupModel extends Model{


	/**
	 * 当拼团成功之后自动开启下一期拼团
	 * @param 2017-12-26 17:04:16
	 * @param string:id
	 * @return array
	 */
	public function up_open_next_group($id)
	{
		try {

			if(intval($id) < 1) throw new Exception("error #id", 11000);
			
			$group = $this->where(['id'=>$id,'gstatus'=>1])->find();
			if(empty($group)) throw new Exception("未查询到数据", 0);
			
			$group['oaddtime'] = date('Y-m-d H:i:s',NOW_TIME);
			$group['gstatus']  = $group['gpay_num'] = 0;
			unset($group['id']);
			$group['gsn'] += 0.0001;

			$gsn_exists = $this->where(['gsn'=>$group['gsn'],'gid'=>$group['gid']])->count();
			if($gsn_exists > 0) throw new Exception("失败该旗号已存在", 0);
			
			$inRes = $this->add($group);
			if(!$inRes) throw new Exception("下一期记录写入失败",0);
			
			return ['status'=>1,'msg'=>"success"];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 返回团详情
	 * @param 2017-12-16 18:36:40
	 * @param string $grid
	 */
	public function get_group_detail($grid)
	{
		try {
			if(intval($grid) < 1) throw new Exception("error #grid", 11000);
			
			$order = $this->where(['id'=>$grid])->field('gimg,gname,gprice,gteam_price,gnum,gpay_num')->find();
			$order['gimg'] = C('IMG_URL').$order['g img'];
			if(empty($order)) throw new Exception("该团不存在", 0);
 
			$order['order_detail'] =  M('goods_open_group_order')->where(['o.grid'=>$grid,'o.pay_status'=>1])->join('o left join __USER_ACCOUNT__ a on o.uid=a.id')->field('a.mobile,o.paytime')->order('o.id desc')->select();	#拉取详情信息
			if(!empty($order['order_detail'])){
				foreach ($order['order_detail'] as $key => $value) {
					$order['order_detail'][$key]['mobile'] = substr($value['mobile'], 0,3).'****'.substr($value['mobile'],7);
				}
			}
			return ['status'=>1,'data'=>$order];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}

	/**
	 * 返回单个商品详情,不含商品内容
	 * @param 2017-12-13 17:23:23
	 * @param string $id
	 * @return array
	 */
	public function get_goods_detail($id)
	{
		try {
			if(intval($id) < 1) throw new Exception("error #id", 11000);
			$where = ['g.id'=>$id];
			$goods = $this->where($where)->join('g left join __USER_SHOP__ s on g.did=s.id')->field('g.gid,g.gpay_num,g.guser_limit,g.gpay_limit,g.did sid,g.gname,g.gprice,g.gteam_price,g.gnum,g.gimg,s.sname,g.gsn,g.gstatus')->find();
			$goods['gsn'] = substr($goods['gsn'],2);
			if(empty($goods)) throw new Exception("商品不存在", 11016);
			
			$goods['gimg'] = C('IMG_URL').$goods['gimg'];
			return ['status'=>1,'data'=>$goods];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
 
	/**
	 * 返回首页开团商品
	 * @param 2017-12-12 11:37:05
	 * @return array
	 */
	public function get_index_goods($page)
	{

		$where = ['is_index'=>1,'gstatus'=>0];
		$limit = $this->getLimit($page);
		$goods = $this->where($where)->field('gname,gimg,gprice,gteam_price,gnum,id,guser_limit,gstatus')->order('gsort asc')->limit($limit)->select();
		if(empty($goods)) return ['status'=>0,'data'=>[]];
		foreach ($goods as $key => $value) {
			$goods[$key]['gimg'] = C('IMG_URL').$value['gimg'];
		}
		return ['status'=>1,'data'=>$goods];
	}
	/**
	 * 返回列表页开团商品
	 * @param 2017-12-12 14:09:20
	 * @param array $data:gcid,gname,page,sid,guser_limit
	 * @return array
	 */
	public function get_goods_list($data)
	{
		$where = ['gstatus'=>0];
		if(!empty($data['gcid'])){	#根据分类id查询数据
			$cid = M('goods_supply_cate')->where(['pid'=>$data['gcid'],'level'=>1])->getField('group_concat(id)');
			if(!empty($cid)) $where['gcid'] = ['in',$cid];
			else $where['gcid'] = $data['gcid'];
		}

		if(!empty($data['gname']))  $where['gname'] = ['like','%'.$data['gname'].'%'];	#筛选商品名称
		if(!empty($data['sid'])) $where['did'] = $data['sid'];	#筛选店家
		if(strlen($data['guser_limit'])) $where['guser_limit'] = $data['guser_limit'];	#筛选拼团类型
		$limit = $this->getLimit($data['page']);

		 
		$goods = $this->where($where)->field('gname,gimg,gprice,gteam_price,gnum,id,guser_limit,gstatus')->order('gsort asc')->limit($limit)->select();
		if(empty($goods)) return ['status'=>1,'data'=>[]];
		foreach ($goods as $key => $value) {
			$goods[$key]['gimg'] = C('IMG_URL').$value['gimg'];
		}
		return ['status'=>1,'data'=>$goods];
	}

	/**
	 * 返回每页查询数量
	 * @param 2017-12-12 11:54:57
	 * @param string $page
	 * @return string
	 */
	public  function getLimit($page = 1,$pageSize = 6)
	{
		if(intval($page) < 1) $page = 1;
		$start = ($page-1) * $pageSize;
		$limit = $start.','.$pageSize;
		return $limit;
	}
}