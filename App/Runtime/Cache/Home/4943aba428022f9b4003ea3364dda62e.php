<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta name="baidu-site-verification" content="brSKk1xvoHM7I577">
<meta name="description" content=""/>
<meta name="keywords" content=""/>
<title>扫码支付</title>
<link href="/Public/css/style.css" rel="stylesheet" type="text/css">
</head>
<body style="background:#f0eff5">
<div class="warp">
	<div class="payment">
		<div class="pay_top">
			<h3>支付金额<br><span>￥ <?php echo ($order["total_price"]); ?></span></h3>
		</div>
		<div class="pay_con">
			<h3>支付方式</h3>
			<ul>
				<li>
					<input type="radio" id="radio-1-1" value="1" name="out_trade_type" class="r-radio" checked />
                	<label for="radio-1-1"><img src="/Public/images/not_zfb.png">支付宝支付<div class="img"></div></label>
				</li>
			<!-- 	<li>
					<input type="radio" id="radio-1-2" value="0" name="out_trade_type" class="r-radio" />
                	<label for="radio-1-2"><img src="/Public/images/not_wx.png">微信支付<div class="img"></div></label>
                </li> -->
                <li>
                	<input type="radio" id="radio-1-3" value="2" name="out_trade_type" class="r-radio" />
                	<label for="radio-1-3"><img src="/Public/images/not_shop.png">购物券支付<div class="img"></div><p>剩余购物券：<?php echo ($user["balance"]); ?></p></label>
                </li>
			</ul>
		</div>
		
		<div class="pay_ts"><a href="javascript:;" onclick="order_pay()">支付</a></div>
	</div>
</div>
</body>
</html>
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>
<script type="text/javascript" src="/Public/js/function.js"></script>

<script type="text/javascript">
function order_pay()
{
	var out_trade_type = $('input[name=out_trade_type]:checked');
	if(out_trade_type.length < 1){
		layer.msg('请选择支付方式');
		return;
	}
	var ajaxData = {
		url:'<?php echo U("Order/gopay");?>',type:'post',dataType:'json',data:{out_trade_type:out_trade_type.val()},
		beforeSend:function(data){layer.load(2)},
		success:function(data){
			layer.closeAll();value="" 
			if(data.status == 1 && data.code == 1){
				location.href=data.msg;
				return;
			}
			layer.msg(data.msg);
		}
	};
	$.ajax(ajaxData);
}
</script>