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
<title>提现</title>
<link rel="stylesheet" type="text/css" href="/Public/css/wallet.css">
<link rel="stylesheet" type="text/css" href="/Public/css/footer.css">
</head>
<body style="background:#f2f2f2;">
<div class="main">
  <div class="with">
    <div class="with_top">提现到银行卡</div>
    <div class="with_con">
      <p class="title"><?php echo ($user["bank_user"]); ?>(<?php echo ($user["realname"]); ?>)</p>
      <input type="text" class="w_input" id="money" placeholder="请输入提现金额">
      <p class="tit">可提现余额<?php echo ($user["balance"]); ?></p>
    </div>
    <div class="with_fot"><a href="javascript:;" onclick="user_cash()">提现</a></div>
  </div>
  <!-- 底部footer -->
  <link rel="stylesheet" type="text/css" href="/Public/css/footer.css">
<div class="footer">
	<ul class="u4">
		<li <?php if(ACTION_NAME == 'index'): ?>class="cur"<?php endif; ?> >
			<a href="<?php echo U('Index/index');?>" ><div class="img img1"></div><p>拼采廉</p></a>
		</li>
		<li <?php if(ACTION_NAME == 'regiment'): ?>class="cur"<?php endif; ?> >
			<a href="<?php echo U('Group/regiment');?>" ><div class="img img4"></div><p>我的团</p></a>
		</li>
		<li <?php if(ACTION_NAME == 'order_list'): ?>class="cur"<?php endif; ?> >
			<a href="<?php echo U('Group/order_list');?>" ><div class="img img2"></div><p>查订单</p></a>
		</li>
		<li <?php if(ACTION_NAME == 'personal'): ?>class="cur"<?php endif; ?> >
			<a href="<?php echo U('User/personal');?>" ><div class="img img3"></div><p>会员中心</p></a>
		</li>
	</ul>
</div>
</div>


 

<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>
<script type="text/javascript" src="/Public/js/function.js"></script>
<script type="text/javascript" src="/Public/js/disable.js"></script>
<script type="text/javascript">
  $('iframe').css('display','none').css('z-index','-1').css('opacity','0');
</script>


<script type="text/javascript">
function user_cash()
{
  var money = $.trim($('#money').val());
  if(money < 1){
    layer.msg('提现金额必须大于1');
    return;
  }
  var ajaxData = {
    url:'<?php echo U("User/withdrawals");?>',type:'post',dataType:'json',data:{money:money},
    beforeSend:function(data){layer.load(2)},
    success:function(data){
      layer.closeAll();
      if(data.status == 1) setTimeout('location.reload()',2000);
      layer.msg(data.msg, {icon: data.status,shade: 0.5,time: 2000,closeBtn:1});
    }
  }
  $.ajax(ajaxData);
}
</script>

</body>
</html>