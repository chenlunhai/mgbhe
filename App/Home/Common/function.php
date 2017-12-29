<?php;
/* 是否微信客户端 */
function getclient(){ 
    $client = $_SERVER['HTTP_USER_AGENT'];
    return strpos($client,'MicroMessenger') ? 1 : 0;
}
#去支付链接
function getPayUrl($order_sn,$out_trade_type = 0){
    if($out_trade_type == 0){
        return 'http://'.$_SERVER['HTTP_HOST'].'/App/Wxpay/example/jsapi.php?p='.$order_sn;
    }
   
    return 'http://'.$_SERVER['HTTP_HOST'].'/App/Alipay/web/wappay/pay.php?p='.$order_sn;
}
