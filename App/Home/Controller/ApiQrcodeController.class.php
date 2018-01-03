<?php
namespace Home\Controller;
use Common\Service\QrcodeService;
use Think\Controller;
class ApiQrcodeController extends Controller {


	/**
	 * 生成动态二维码
	 * @param 2018-1-2 14:12:56
	 * @param array:shopsn,shoptype
	 */
	public function create_qrcode()
	{
		$post = I('post.');
		$QrcodeService = new QrcodeService();
		$res = $QrcodeService->create_qrcode($post);
		$this->ajaxReturn($res);
	}

}