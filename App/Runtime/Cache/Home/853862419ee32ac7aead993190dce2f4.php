<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta name="baidu-site-verification" content="brSKk1xvoHM7I577">
<meta name="description" content=""/>
<meta name="keywords" content=""/>
<title>麦光宝盒</title>
<link rel="stylesheet" type="text/css" href="/Public/css/style.css?v=2">
</head>
<body style="margin:0 auto;position:relative;overflow:hidden;z-index:1; background:#4ca209;">
<div class="warp" style=" position: relative; width: 100%; height: 100%; z-index: 1;">
	<div class="choice" style="overflow:hidden">
		<div class="cho_bj"><img src="/Public/images/not_18.jpg"></div>
		<div class="cho_con">
			<p class="title">麦光宝盒<br>无人值守超市</p>
			<div class="img"><img src="/Public/images/not_20.png"></div>
			<ul>
				<li><a href="javascript:;" onclick="opendoor()" id="opendoor">开启宝盒</a></li>
				<li><a href="<?php echo U('User/personal');?>">会员中心</a></li>
			</ul>
		</div>
	</div>
</div>
</body>
</html>
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>
<script type="text/javascript" src="/Public/js/function.js"></script>

<script type="text/javascript">
function opendoor(){
	var ajaData = {
		url:'<?php echo U("User/opendoor");?>',type:'post',dataType:'json',
		beforeSend:function(data){layer.load(2)},
		success:function(data){
			layer.closeAll();
			if(data.status == 1) $('#opendoor').html('已开门').attr('onclick','');
			layer.msg(data.msg);
		}
	}
	$.ajax(ajaData);
}
</script>