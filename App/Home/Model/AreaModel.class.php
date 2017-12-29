<?php
namespace Home\Model;
use Think\Exception;
use Think\Model;
class AreaModel extends Model{



	/**
	 * 返回区域信息
	 * @param 2017-12-15 10:02:18
	 * @param string $pid
	 */
	public function get_area_info($pid = 0)
	{
		return $this->where(['pid'=>$pid])->field('id,name')->select();
	}

}