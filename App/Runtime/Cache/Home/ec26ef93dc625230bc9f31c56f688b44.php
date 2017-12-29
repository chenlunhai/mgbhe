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
<title>我的钱包</title>
<link rel="stylesheet" type="text/css" href="/Public/css/wallet.css">
<link rel="stylesheet" type="text/css" href="/Public/css/footer.css">
</head>
<body style="background:#f2f2f2;">
<div class="main">
  <div class="my_wallet">
    <h3>
      <p><?php echo ($user["balance"]); ?></p><span>总余额</span>
    </h3>
    <div class="wal_nav">
      <ul class="u3">
        <li>累计消费<br><span><?php echo ($user["total_consumption"]); ?></span></li>
        <li>累计充值<br><span><?php echo ($user["total_balance"]); ?></span></li>
        <li>累计积分<br><span><?php echo ($user["integral"]); ?></span></li>
      </ul>
      <div class="clearboth"></div>
    </div>
    <div class="wal_con">
      <ul>
        <li id="balance_details"><p><img src="/Public/images/not_22.png">余额详情</p></li>
        <li id="envelopes_list"><p> <img src="/Public/images/not_23.png">红包详情</p></li>
        <li id="integral_details"><p><img src="/Public/images/not_24.png">积分详情<a href="javascript:;" id="balance">换余额</a></p></li>
      </ul>
    </div>
    <div class="wal_fot">
      <ul>
        <li><a href="<?php echo U('User/recharge');?>">充值</a></li>
        <li class="tx"><a href="<?php echo U('User/withdrawals');?>">提现</a></li>
      </ul>
    </div>
  </div>
  <!-- 底部footer -->
</div>


<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>

<script type="text/javascript">
$(document).ready(function(){
  $("#envelopes_list").click(function(){
    location.href="<?php echo U('Order/envelopes_list');?>";
  });

  $("#balance_details").click(function(){
    location.href="<?php echo U('User/balance_details');?>";
  });

  $("#integral_details").click(function(){
    location.href="<?php echo U('User/integral_details');?>";
  });
  
  $("#balance").click(function(event){
    location.href="<?php echo U('User/balance');?>";
    event.stopPropagation();
  });
  
});
</script>


</body>
</html>