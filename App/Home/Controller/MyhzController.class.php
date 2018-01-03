<?php
namespace Home\Controller;
use Think\Controller;
use Common\Service\MyhzService;
use Think\Exception;
class MyhzController extends Controller {

	/**
	 * 蚂蚁盒子消息推送接口-柜机推送过来的
	 * @param 2017/11/9
	 */
	public function index()
	{
		try {

			$json_str = file_get_contents('php://input');
			if(empty($json_str)) throw new Exception("error #paramter");
			$data = json_decode($json_str,true);
			if(empty($data)) throw new Exception('数据异常');
			
			#验证签名
			$MyhzService = new MyhzService;
			$sign = $MyhzService->get_sign($data['timestamp']);
			if($data['sign'] != $sign) throw new Exception('签名异常');
			
			switch ($data['eventType']) {
				case 'new_order':	#新订单
					file_put_contents('new_order.txt',$json_str);	#请求数据-测试使用
					$res = D('myhz_order')->pay_myhz_order(json_decode($data['data'],true));
					
					if($res['status']!=1) throw new Exception($res['msg']);
					break;
				case 'new_user':	#新用户
					file_put_contents('new_user.txt',$json_str);
					break;
				default:
					throw new Exception("error #eventType");
					
					break;
			}
			exit('success');
		} catch (Exception $e) {
			exit(json_encode(['status'=>0,'msg'=>$e->getMessage()]));
		}
	}
}