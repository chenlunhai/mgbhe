<?php
namespace Home\Model;
use Think\Exception;
use Think\Model;
class GoodsSupplyCateModel extends Model{

	/**
	 * 根据一级类目id返回二级分类，一级分类id为0时返回一级类目
	 * @param 2017-12-12 11:27:53
	 * @param string $id
	 * @return array
	 */
	public function get_goods_supply_cate($id = 0)
	{
		return $this->where(['pid'=>$id])->order('sort asc')->field('id,name')->select();
	}

	/**
	 * 返回所有分类，两级
	 * @param 2017-12-27 10:36:36
	 * @return array
	 */
	public function get_goods_supply_cates()
	{
		$cate = $this->where(['pid'=>0])->field('id,name')->order('sort asc')->select();
		foreach ($cate as $key => $value) {
			$cate[$key]['cate'] = $this->where(['pid'=>$value['id']])->field('id,name')->order('sort asc')->select();
		}
		return ['status'=>1,'data'=>$cate];
	}
}