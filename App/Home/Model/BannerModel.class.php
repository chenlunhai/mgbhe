<?php
namespace Home\Model;
use Think\Exception;
use Think\Model;
class BannerModel extends Model{

	/**
	 * 返回banner图
	 * @param 2017-12-12 11:34:43
	 * @return array;
	 */
	public function get_banner_info()
	{
		$banner = $this->order('sort asc')->field('img,url')->select();
		foreach ($banner as $key => $value) {
			$banner[$key]['img'] = C('IMG_URL').$value['img'];
		}
		return $banner;
	}

}



