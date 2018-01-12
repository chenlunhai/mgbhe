<?php
/**
 * app加载h5页面
 */
namespace Home\Controller;
use Think\Controller;

class AppH5Controller extends Controller {

	/**
	 * 支付宝支付
	 * @param 2017-12-29 09:57:46
	 * @param string:osn(订单编号)
	 */
	public function get_alipay_order()
	{
		if(!IS_POST) exit('error');
		$osn = I('post.osn');
		if(!isset($osn[19])) $this->ajaxReturn(['status'=>0,'msg'=>'error #osn']);

		switch ($osn[0]) {
			case 6:
				$order = M('goods_open_group_order')->where(['osn'=>$osn,'pay_status'=>0])->field('pay_price,osn')->find();
				if(empty($order)) $this->ajaxReturn(['status'=>0,'msg'=>'error #order']);
				$reurl = 'http://'.$_SERVER['HTTP_HOST'].U('Order/shop_success');
				break;
			case 8:
				$order = M('order_balance')->where(['osn'=>$osn,'pay_status'=>0])->field('money pay_price,osn')->find();
				if(empty($order)) $this->ajaxReturn(['status'=>0,'msg'=>'error #order']);
				$reurl = 'http://'.$_SERVER['HTTP_HOST'].U('Order/shop_success');
				break;
			case 9:
				$order = M('order')->where(['osn'=>$osn,'pay_status'=>0])->field('oprice pay_price,osn')->find();
				if(empty($order)) $this->ajaxReturn(['status'=>0,'msg'=>'error #order']);
				$reurl = 'http://'.$_SERVER['HTTP_HOST'].U('Order/shop_success');
				break;
			default:
				$this->ajaxReturn(['status'=>0,'msg'=>'error #order']);
				break;
		}
		$gourl = 'http://'.$_SERVER['HTTP_HOST'].'/App/Alipay/app/AopSdk.php?money='.$order['pay_price'].'&order_sn='.$order['osn'];
        $res   = file_get_contents($gourl);
        $this->ajaxReturn(['status'=>1,'msg'=>$res,'reurl'=>$reurl]);
	}
	#返回安卓版本号
	public function get_version(){
		 
		$res = [
			'status' 	=> 1,
			'first'  	=> '0',											#更新版本	：0可选，1强制
			'version' 	=> '1.0',										#当前版本
			'download' 	=> 'https://www.pgyer.com/bBS7',				#下载链接
			'wxpay' 	=> 0,											#微信支付	:0关闭，1开启
			'alipay' 	=> 1,											#支付宝		:0关闭，1开启
			'app_download' =>'http://test.mgbh.wlylai.com/app-debug.apk',#直接安装的那种
			'load_url'	=> 'http://mgbh.wlylai.com',				#加载地址
		];
		$this->ajaxReturn($res);
	}
	#返回IOS版本号
	public function get_ios_version(){
		$res = [
			'first'  	=> '1',											#更新版本	：0可选，1强制
			'version' 	=> '1.0',										#当前版本
			'load_url'	=> 'http://mgbh.wlylai.com',					#加载地址
		];
		$this->ajaxReturn($res);
	}
}