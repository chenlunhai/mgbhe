<?php
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);
$order_sn 	= isset($_GET['order_sn']) ? $_GET['order_sn'] : 0;
$money 		= isset($_GET['money']) ? $_GET['money'] : 0;
$notify_url = isset($_GET['notify_url']) ? $_GET['notify_url'] : 0;
if($order_sn == 0 || $money == 0 || $notify_url = 0) die;
/**
 * AOP SDK 入口文件
 * 请不要修改这个文件，除非你知道怎样修改以及怎样恢复
 * @author wuxiao
 */

/**
 * 定义常量开始
 * 在include("AopSdk.php")之前定义这些常量，不要直接修改本文件，以利于升级覆盖
 */
/**
 * SDK工作目录
 * 存放日志，AOP缓存数据
 */
if (!defined("AOP_SDK_WORK_DIR"))
{
	define("AOP_SDK_WORK_DIR", "/tmp/");
}
/**
 * 是否处于开发模式
 * 在你自己电脑上开发程序的时候千万不要设为false，以免缓存造成你的代码修改了不生效
 * 部署到生产环境正式运营后，如果性能压力大，可以把此常量设定为false，能提高运行速度（对应的代价就是你下次升级程序时要清一下缓存）
 */
if (!defined("AOP_SDK_DEV_MODE"))
{
	define("AOP_SDK_DEV_MODE", true);
}
/**
 * 定义常量结束
 */

/**
 * 找到lotusphp入口文件，并初始化lotusphp
 * lotusphp是一个第三方php框架，其主页在：lotusphp.googlecode.com
 */
$lotusHome = dirname(__FILE__) . DIRECTORY_SEPARATOR . "lotusphp_runtime" . DIRECTORY_SEPARATOR;
include($lotusHome . "Lotus.php");
$lotus = new Lotus;
$lotus->option["autoload_dir"] = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'aop';
$lotus->devMode = AOP_SDK_DEV_MODE;
$lotus->defaultStoreDir = AOP_SDK_WORK_DIR;
$lotus->init();

 

$aop = new AopClient;
$aop->gatewayUrl = "https://openapi.alipay.com/gateway.do";
$aop->appId = "2017091508748254";
$aop->rsaPrivateKey = 'MIIEowIBAAKCAQEAyHEuQfO2izefRoalXbGcHzC8mSGq9WSFNDkT79Pem+JrvfcLMUu+QJ8tLUz+WboAoeHBR4gG0/jBsGMuYyT5eBEK9TpNz+qQ5pFVdtrosudViesDBRsp07BJU8NJzSj+lpEvCdQ3OxmelavL94JEj9gco/d/DZRnRRXShY/RCV3SQj/psaZEUI2rxwL6WeEf3V7hisIOnls086fLnEalGGNb096epyGyClmqAzTEj5FkCUnVOT6DxiDaNJ/X+G4IJzj/JaItJQTtu98Mw64ODAHRzsbtykvPv0tjzsCuSpf5uAq3y75BGkBTYfuS2Oi6dc9SjEscrtA50Nf4E5qdoQIDAQABAoIBACH2C0Bhaqxr4DCy35HgZfNi7pGDgtPRFECk6xvXagA/fMHS+bKAgtuwHJdwVCgfu7ux5G2aPo3rt+WK6HEj8qDFQnYKSuTPeX2XYkOhE4w8ZeHYT8qtr4iOdd4bWIXKTFh2gOHJcxIwZQ427XgiOjulAjVF2eETI+wwplq641ASqIgajKT3XhzCNXcOgtXXCEp3dTLvj8/HSuzyTP0pzzJljSX0qOWe+lUzE2bE+X47epx1rxML/UF8MUz7Y6jCcEMhTgG5uQ800iJB5sU2UIsk2B6oPuXZuKtt6EkjCN+yGFOhWCt6Ba7kvRKPjIWO7plMjUWgKbpQ2T0V89fNpYECgYEA8ExB3gdTp4vN52ytgG6m4d2+cnTakiAqtN6u/EjlpXDmoDforwf5AY0FgAJC6EDFpiVA64zRli6BVtJjV4/Hz/y0X8IzrD2cbROqjriSYERvqKnw98ck9XUpVrlpEQyokx4hjLGT41XdpqRNcfmj5Y0laTpc5gCvYbRcsBsLg18CgYEA1Yo1oupqJkOikxQn4F24cN5vAyJWFfXpD3obn8DHQuCNti3+clXwnw5bV+LfaST/jKWwHdpHqiVsLNrvZEdPU1Wj82wbQf04hI0vHrWYmFnj+djWwU6SmT+nITWK13YezQRLBHGJ4OGnv2KlS+mzxH0QTrX0f9hOIk2PjEPGfv8CgYAuLGkHsd64Nhv1mSNpp1l30zUSJzQMmhO6t4NmRNejx6L5LGUQpPaK/r8MzuJuYGvaNhRYbrGjKwJ9XWXrYFxjscozEEz/jsMtDndaf0rZJq1R+n2sDt8iL0YnPO9ccFNAGa0WrNSe/VPe/nlHKlH8/PcwVh+drooEuzSIPloi/wKBgHhKUQijMIS5mP1tX0E+ykWap8KGNyRL0KwNRz5o5FbCFFJJ+ooB63hOKBqMDPo4A1UBiQJoEfLA/f0On8hHe2IgXikj/v7fXFUfCyordfhsusXl5qQiVObLOqS0erABNDydbHzmUJtDwrFHKoJm9gN7yBHu4fqaqPkd4/1JuKmVAoGBAOyo5T0mEW5/855PwQU9HAN4WPOoaZhYMIt+CoAtes9F2EGPO6TUb7CLmWm3tJUTFagLyV+vEpyAVejTSlQ7LHVprC8h3Xn5Ais4sUUWBYnUuCyANQKaPKqwHj3RuhNy1BnzXCCepJnONCNASBqaxTOz794lVFZAx1zwjhklJ1I+' ;
$aop->format = "json";
$aop->charset = "UTF-8";
$aop->signType = "RSA2";
$aop->alipayrsaPublicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAyHEuQfO2izefRoalXbGcHzC8mSGq9WSFNDkT79Pem+JrvfcLMUu+QJ8tLUz+WboAoeHBR4gG0/jBsGMuYyT5eBEK9TpNz+qQ5pFVdtrosudViesDBRsp07BJU8NJzSj+lpEvCdQ3OxmelavL94JEj9gco/d/DZRnRRXShY/RCV3SQj/psaZEUI2rxwL6WeEf3V7hisIOnls086fLnEalGGNb096epyGyClmqAzTEj5FkCUnVOT6DxiDaNJ/X+G4IJzj/JaItJQTtu98Mw64ODAHRzsbtykvPv0tjzsCuSpf5uAq3y75BGkBTYfuS2Oi6dc9SjEscrtA50Nf4E5qdoQIDAQAB';
//实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
$request = new AlipayTradeAppPayRequest();
//SDK已经封装掉了公共参数，这里只需要传入业务参数
$bizcontent = json_encode([
	'subject'=>'麦光宝盒','out_trade_no'=>$order_sn,'product_code'=>'QUICK_MSECURITY_PAY','total_amount'=>$money,
]);
$notify_url = 'http://'.$_SERVER['HTTP_HOST'].'/App/Alipay/web/notify_url.php';
$request->setNotifyUrl($notify_url);
$request->setBizContent($bizcontent);
//这里和普通的接口调用不同，使用的是sdkExecute
 
$response = $aop->sdkExecute($request);
//htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
// echo htmlspecialchars($response);//就是orderString 可以直接给客户端请求，无需再做处理
echo $response;