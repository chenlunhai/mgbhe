<?php
/* *
 * 功能：支付宝手机网站支付接口(alipay.trade.wap.pay)接口调试入口页面
 * 版本：2.0
 * 修改日期：2016-11-01
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 请确保项目文件有可写权限，不然打印不了日志。
 */

header("Content-type: text/html; charset=utf-8");
 
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);
$order_sn = isset($_GET['p']) ? $_GET['p'] : 0;
require_once dirname ( __FILE__ ).'/../function/function.php';
/* 获得订单详情 */
if(empty($order_sn)) die('参数错误');
$url = 'http://'.$_SERVER['HTTP_HOST'].'/index.php?s=/Pay/get_pay_order_info';
$res = https_request($url,$order_sn);
$info = json_decode($res);
 
if(!is_object($info)) die;

require_once dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'service/AlipayTradeService.php';
require_once dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'buildermodel/AlipayTradeWapPayContentBuilder.php';
require dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'./../config.php';
 
    //商户订单号，商户网站订单系统中唯一订单号，必填
    $out_trade_no = $info->order_sn;

    //订单名称，必填
    $subject = $info->pay_title;

    //付款金额，必填
    $total_amount = $info->total_prices;

    //商品描述，可空
    // $body = $_POST['WIDbody'];

    //超时时间
    $timeout_express="1m";

    $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
    // $payRequestBuilder->setBody($body);
    $payRequestBuilder->setSubject($subject);
    $payRequestBuilder->setOutTradeNo($out_trade_no);
    $payRequestBuilder->setTotalAmount($total_amount);
    $payRequestBuilder->setTimeExpress($timeout_express);

    $payResponse = new AlipayTradeService($config);
    $result=$payResponse->wapPay($payRequestBuilder,$info->reurl,$config['notify_url']);

    return ;
 