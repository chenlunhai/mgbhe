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
<title>订单详情</title>
<link rel="stylesheet" type="text/css" href="/Public/css/group.css">
</head>
<body style="background:#f2f2f2;">
<div class="main">
  <div class="details">
    <div class="deta_top">
      <h3>
        <p class="title"><?php echo getTradeStatus($data["trade"]);?></p>
        <p class="tit">订单金额：￥<?php echo ($data["pay_price"]); ?></p>
      </h3>
    </div>
    <div class="deta_add">
      <h3>
        <p class="title"><?php echo ($data["realname"]); ?> <?php echo ($data["mobile"]); ?></p>
        <p class="tit"><?php echo ($data["province"]); ?> <?php echo ($data["city"]); ?> <?php echo ($data["country"]); ?>  <?php echo ($data["address"]); ?></p>
      </h3>
    </div>
    <div class="deta_con">
      <h3><img src="/Public/images/p_sd.png"><span>商品</span></h3>
      <ul>
        <li>
          <div class="img"><img src="<?php echo ($data['gimg']); ?>"></div>
          <div class="title"><?php echo ($data['gname']); ?></div>
          <div class="tit">￥<?php echo ($data['gteam_price']); ?>/件<br>X <?php echo ($data['pay_num']); ?></div>
        </li>
      </ul>
      <h4>共<?php echo ($data['pay_num']); ?>件商品  合计 ￥<span><?php echo ($data['pay_price']); ?></span></h4>
    </div>
    <div class="deta_bot">
      <ul>
        <li><span>订单编号：</span><?php echo ($data['osn']); ?></li>
        <li><span>创建时间：</span><?php echo ($data['addtime']); ?></li>
        <li><span>支付时间：</span><?php echo ($data['paytime']); ?></li>
      </ul>
    </div>
    <div class="deta_fot">
      <?php if($data['trade'] > 0 AND $data['trade'] < 4): ?><!-- <a href="javascript:;">申请退款</a> --><?php endif; ?>
      <?php if(($data["trade"]) == "4"): ?><a href="javascript:;">退款中</a><?php endif; ?>
      <?php if(($data["trade"]) == "5"): ?><a href="javascript:;">完成退款</a><?php endif; ?>
      <!-- 4(退款中)5(完成退款) -->
    </div>
  </div>
  <!-- 底部footer -->
  
</div>


<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>
<script type="text/javascript" src="/Public/js/function.js"></script>
<script type="text/javascript" src="/Public/js/disable.js"></script>
<script type="text/javascript">
  $('iframe').css('display','none').css('z-index','-1').css('opacity','0');
</script>




</body>
</html>