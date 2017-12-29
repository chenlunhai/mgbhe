<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta name="baidu-site-verification" content="brSKk1xvoHM7I577">
<meta name="description" content=""/>
<meta name="keywords" content=""/>
<title>我的钱包</title>
<link rel="stylesheet" type="text/css" href="/Public/css/style.css?v=0">
</head>
<body>
<div class="warp">
	<div class="wallet">
		<div class="wall_top">
			<ul>
				<li><p><?php echo ($user["balance"]); ?></p>当前余额</li>
				<li><p><?php echo ($user["total_consumption"]); ?></p>累计消费</li>
				<li><p><?php echo ($user["total_balance"]); ?></p>累计充值</li>
				<div class="clearboth"></div>
			</ul>
		</div>
		<div class="wall_con">
			<ul>
				<li><a href="javascript:;" onclick="gopay(20)"><img src="/Public/images/not_02.png"><span>20元储值卡</span>去充值</a></li>
				<li><a href="javascript:;" onclick="gopay(50)"><img src="/Public/images/not_06.png"><span>50元储值卡</span>去充值</a></li>
				<li><a href="javascript:;" onclick="gopay(100)"><img src="/Public/images/not_02.png"><span>100元储值卡</span>去充值</a></li>
			</ul>
		</div>
		<!-- <div class="wall_ti"><a href="<?php echo U('User/recharge');?>">查看充值明细</a></div> -->
		<!-- <div class="wall_bot">
			<ul>
				<li><a href="<?php echo U('User/detailed');?>"><span>今日收入：100</span>查明细</a></li>
				<li><span>累计收入：100</span></li>
				<li><a href="<?php echo U('User/detailed');?>"><span>可提现收入：100</span>查明细</a></li>
			</ul>
		</div> -->
	</div>
</div>
</body>
</html>
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>
<script type="text/javascript" src="/Public/js/function.js"></script>



<script type="text/javascript">
function gopay(m)
{
	var ajaxData = {
		url:'<?php echo U("User/balance_pay");?>',type:'post',dataType:'json',data:{money:m},
		beforeSend:function(data){layer.load(2)},
		success:function(data){
			layer.closeAll();
			if(data.status == 1){
				location.href=data.msg;
				return;
			}
			layer.msg(data.msg);
		}
	}
	$.ajax(ajaxData);
}
</script>