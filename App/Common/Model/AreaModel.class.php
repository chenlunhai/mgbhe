<?php
namespace Common\Model;
use Think\Model;
use Think\Exception;
class AreaModel{


	/**
	 * 返回可拼团的城市
	 * @param 2017-12-11 14:38:31
	 * @return array
	 */
	public function get_open_area()
	{
		try {
			$area = M('area')->where(['a.level'=>1,'a.isopen'=>1])->join('a left join __AREA__ aa on a.pid=aa.id')->field('aa.name pname,a.name,a.id')->select();
			if(empty($area)) throw new Exception("没有城市开通拼团");
			
			$new_area = [];
			foreach ($area as $key => $value) {
				$new_area[$value['pname']][] = $value;
			}unset($area);
			
			return ['status'=>1,'msg'=>$new_area];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage()];
		}
	}

}