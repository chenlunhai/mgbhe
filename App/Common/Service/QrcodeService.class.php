<?php
/**
 * 无人店、柜机生成二维码链接
 * @param 2018-1-2 14:16:35
 */
namespace Common\Service;
use Think\Controller;
use Think\Exception;
use Common\Service\CodeService;
class QrcodeService{

	/**
	 * 根据设备号、设备类型、生成二维码链接
	 * @param 2018-1-2 14:17:34
	 * @param array:shopsn,shoptype
	 * @return array
	 */
	public function create_qrcode($data)
	{
		try {
			$check_res = check_data($data,['shopsn','shoptype']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'], 11000);
			
			switch ($data['shoptype']) {
				case 0:	#柜机
					$reurl = 'http://'.$_SERVER['HTTP_HOST'].'/User/box_opendoor/bid/'.$data['shopsn'].'/create_time/'.NOW_TIME;
					break;
				case 1:	#无人店
					$Code = new CodeService;
					$code  = base64_encode($Code->authcode($data['shopsn'],'ENCODE'));
					$reurl = 'http://'.$_SERVER['HTTP_HOST'].'/User/opendoor/shopsn/'.$code.'/create_time/'.NOW_TIME;
					break;
				default:
					throw new Exception("error #shoptype", 11000);
					break;
			}
			return ['status'=>1,'url'=>$reurl];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
}