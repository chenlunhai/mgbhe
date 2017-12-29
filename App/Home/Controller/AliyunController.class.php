<?php
namespace Home\Controller;
use Think\Controller;
use Common\Service\AliyunService;
class AliyunController extends Controller {



	/**
	 * 返回阿里云对象存储oss配置信息-true
	 * @return  array  
	 */
	public function get_config(){
		$state = I('get.state',0);
		$dir = 'user-dir/';
		switch ($state) {
			case '1':
				$dir = 'mgb_shop/';
				break;
		}
		$AliyunService = new AliyunService();
		$AliyunService->get_config($dir);
	}
	/**
	 * 返回ossAPP上传令牌
	 * @return  json string
	 */
	public function get_app_config()
	{
		$str = file_get_contents('http://'.$_SERVER['HTTP_HOST'].'/App/Common/Vendors/aliyunsts/sts.php');
		echo $str;
	}
	/**
	 *  返回ossAPP上传文件的目录
	 */
	public function get_up_dir()
	{
		$state = I('get.state',0);
		$dir = 'user-dir/';
		switch ($state) {
			case '1':
				$dir = 'pay_flow_integral/'.date('Y-m-d',NOW_TIME).'/';
				break;
			
			case '2':
				$dir = 'id_card_img/'.date('Y-m-d',NOW_TIME).'/';
				break;
			case '3':
				$dir = 'bill/'.date('Y-m-d',NOW_TIME).'/';
				break;
		}
		echo $dir;
	}
}