<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8" />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta content="-1" http-equiv="Expires">           
<meta content="no-cache" http-equiv="Cache-Control">           
<meta content="no-cache" http-equiv="Pragma">
<meta name = "format-detection" content = "telephone=no">
<title>交易详情</title>
<link rel="stylesheet" type="text/css" href="/Public/css/group.css">
</head>
<body style="background:#f2f2f2;">
<div class="main">
  <div class="success">
    <h3>
      <div class="img"><img src="/Public/images/war_succ.png"></div>支付成功
    </h3>
    <div class="succ_con">
      <h4>￥<?php echo ($data['pay_price']); ?></h4>
      <ul>
        <li><p class="fl">交易时间</p><p class="fr"><?php echo ($data['paytime']); ?></p></li>
        <li><p class="fl">支付方式</p><p class="fr"><?php echo ($data['out_trade_type']); ?></p></li>
        <li><p class="fl">订单编号</p><p class="fr"><?php echo ($data['osn']); ?></p></li>
      </ul>
    </div>
  </div>

  <!-- 底部footer --> 
  <link rel="stylesheet" type="text/css" href="/Public/css/footer.css">
<div class="footer">
	<ul class="u4">
		<li <?php if(ACTION_NAME == 'index'): ?>class="cur"<?php endif; ?> >
			<a href="<?php echo U('Index/index');?>" ><div class="img img1"></div><p>拼采廉</p></a>
		</li>
		<li <?php if(ACTION_NAME == 'regiment'): ?>class="cur"<?php endif; ?> >
			<a href="<?php echo U('Index/regiment');?>" ><div class="img img4"></div><p>我的团</p></a>
		</li>
		<li <?php if(ACTION_NAME == 'order_list'): ?>class="cur"<?php endif; ?> >
			<a href="<?php echo U('Index/order_list');?>" ><div class="img img2"></div><p>查订单</p></a>
		</li>
		<li <?php if(ACTION_NAME == 'personal'): ?>class="cur"<?php endif; ?> >
			<a href="<?php echo U('User/personal');?>" ><div class="img img3"></div><p>会员中心</p></a>
		</li>
	</ul>
</div>
  <!-- <div class="footer">
    <ul class="u3">
      <li class="cur"><a href="index.html">
        <div class="img"><img src="/Public/images/p_foot1.png"></div>
        <p>拼采廉</p>
      </a></li>
      <li><a href="order_list.html">
        <div class="img"><img src="/Public/images/p_foot2.png"></div>
        <p>查订单</p>
      </a></li>
      <li><a href="javascript:;">
        <div class="img"><img src="/Public/images/p_foot3.png"></div>
        <p>会员中心</p>
      </a></li>
    </ul>
  </div> -->

</div>


<!-- <script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script> -->
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>
<script type="text/javascript" src="/Public/js/function.js"></script>





</body>
</html>