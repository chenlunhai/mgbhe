<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta name="baidu-site-verification" content="brSKk1xvoHM7I577">
<meta name="description" content=""/>
<meta name="keywords" content=""/>
<title>查明细</title>
<link href="/Public/css/style.css" rel="stylesheet" type="text/css">
</head>
<body style="background:#f0eff5">
<div class="warp">
	<div class="detailed">
		<ul>
			<li>
				<h3><a  class="btn01" id="add_address">2017-10-25 10:10:10 +25.1</a>
				<div class="addressbox" id="addressBox">
					<p>付款人ID：</p>
					<p>购买数量：</p>
					<p>交易额：</p>
					<p>手续费：</p>
					<p>服务费：</p>
					<p>设备编号：</p>
					<p>交易编号：</p>
				</div>
				</h3>
			</li>
		</ul>
		<div class="de_ts">没有更多了</div>
	</div>
</div>
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>
<script type="text/javascript" src="/Public/js/function.js"></script>

<script type="text/javascript">
$(function(){
    $('#add_address').click(function(){
        $('#addressBox').slideToggle(300);
		var isfold = $(this).attr("class");
		var fold_class = isfold=="unfold"?"fold":"unfold";
		$(this).attr("class",fold_class);
    })
})
</script>
</body>
</html>