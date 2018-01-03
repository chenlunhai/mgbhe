<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta name="baidu-site-verification" content="brSKk1xvoHM7I577">
<meta name="description" content=""/>
<meta name="keywords" content=""/>
<title>消费报销</title>
<link rel="stylesheet" type="text/css" href="/Public/css/style.css?v=0">
</head>
<body style="background:#f2f2f2">
<div class="warp">
	<div class="reimbu">
		<div class="rei_top">今日报销收益<span id="num">--</span>元</div>
		<div class="rei_img"><img src="/Public/images/not_13.png"></div>
		<div class="rei_con">顾客注册无人店，自动成为数钜宝会员，享受消费报销福利。不仅仅是无人店，数钜宝还提供任意场合消费报销渠道。</div>
		<div class="rei_bot">
			<a href="<?php echo U('User/problem');?>">了解数钜宝</a>
			<a href="javascript:;" onclick="go_cds()" class="sy">查看报销收益</a>
		</div>
	</div>
</div>
</body>
</html>
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>
<script type="text/javascript" src="/Public/js/function.js"></script>
<script type="text/javascript" src="/Public/js/disable.js"></script>
<script type="text/javascript">
  $('iframe').css('display','none').css('z-index','-1').css('opacity','0');
</script>


<script type="text/javascript">
function go_cds()
{
	var ajaxData = {
		url:'<?php echo U("User/go_cds");?>',type:'post',dataType:'json',
		beforeSend:function(data){layer.load(2)},
		success:function(data){
			layer.closeAll();
			if(data.status == 1){
				location.href=data.msg;
				return;
			}
			layer.msg(data.msg);
		}
	};
	$.ajax(ajaxData);
}
function get_today_add_money()
{
	var ajaxData = {
		url:'<?php echo U("User/get_today_add_money");?>',type:'post',dataType:'json',
		beforeSend:function(data){layer.load(2)},
		success:function(data){
			layer.closeAll();
			$('#num').html(data.msg);
		}
	};
	$.ajax(ajaxData);
}
get_today_add_money();
</script>