<?php
/**
 * 返回申请成为店主的状态
 * @param  2017/11/06
 * @param $i string
 * @return string
 */
function getShopRegisterStatus($i){
	$arr = ['待处理','已通过','未通过'];  //0(待处理)1(已通过)2(未通过) 
	return $arr[$i];
}

/**
 * 返回店主的状态
 * @param  2017/11/06
 * @param $i string
 * @return string
 */
function getShopRecordStatus($i){
	$arr = ['正常','故障报修'];  //0(正常)1(故障报修) 
	return $arr[$i];
}

function getShopStatus($i){   
	$arr = ['禁止访问','正常'];
	return $arr[$i];
}
function getShopName($i){
	$grade = M('shop')->field('shop_name')->find($i);
	return $grade['shop_name'];
}
function getStoreName($i){
	if($i < 1) return '无';
	$grade = M('store')->field('name')->find($i);
	return $grade['name'];
}
function getEstateState($i){
	$arr  = ['门店收银','微信支付'];
	return $arr[$i];
}
function get_integral_type($i){
	$arr = [1=>'分享积分',2=>'养生积分',3=>'联盟积分',4=>'福利积分',5=>'财富积分',6=>'养元积分'];
	return $arr[$i];
}
function get_ad_cate_name($i){
	if($i < 1) return '无';
	$grade = M('ad_cate')->field('name')->find($i);

	return $grade['name'];
}
#获得交易来源
function get_pay_soucre($i){
	$arr = ['门店收银','充值会员卡','商城下单','积分充值'];
	return $arr[$i];
}
/**
 * 通过订单编号获取用户编号
 * @param  2017/10/12
 * @param  $order_sn string
 * @return  string
 */
function getShopBalancePushSn($order_sn)
{
	if(empty($order_sn)) return '';
	return M('pay_order')->where(['p.order_sn'=>$order_sn])->join('p left join __USER__ u on p.uid=u.id')->getField('u.push_sn');
}

/**
 * 返回订单状态
 * @date  2017/11/06
 * @param  $i  string
 * @return  string
 */
function getOrderStatus($i){
	//0(待支付)1(已支付)2(已发货)3(已收货)4(退款中)5(完成退款)
	$arr = ['待支付','已支付','已发货','已收货','退款中','完成退款'];
	return $arr[$i];
}

/**
 * 返回提现类型
 * @date  2017/12/29
 * @param  $i  string
 * @return  string
 */
function getCashType($i){
	//1(提至银行)2(提至支付宝)
	$arr = ['','提至银行','提至支付宝'];
	return $arr[$i];
}

/**
 * 返回提现状态
 * @date  2017/12/29
 * @param  $i  string
 * @return  string
 */
function getCashState($i){
	// 0(未处理)1(通过)2(不通过)
	$arr = ['未处理','已通过','不通过'];
	return $arr[$i];
}

?>