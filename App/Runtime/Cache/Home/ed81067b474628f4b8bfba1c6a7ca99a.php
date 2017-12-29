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
<title>换余额</title>
<link rel="stylesheet" type="text/css" href="/Public/css/wallet.css">
<link rel="stylesheet" type="text/css" href="/Public/css/footer.css">
</head>
<body style="background:#f2f2f2;">
<div class="main">
  <div class="balance">
    <div class="bala_top">积分兑换余额</div>
    <div class="bala_con">
      <table cellspacing="0" cellspacing="0" border="0">
        <tr>
          <td class="bt"><img src="/Public/images/not_24.png">可用积分</td><td class="right"><?php echo ($data["integral"]); ?></td>
        </tr>
        <tr>
          <td class="bt"><img src="/Public/images/not_22.png">兑换余额</td>
          <td class="right">
            <?php if($data['integral'] > 0): ?><input type="text" name="balance" class="b_input" placeholder="请输入兑换金额" >
            <?php else: ?>
              <input type="text" name="balance" class="b_input" placeholder="当前无积分可兑换" style="color:#e02e24;" disabled><?php endif; ?>
          </td>
        </tr>
      </table>
      <p class="tit">积分换余额的比例为1:1</p>
    </div>
    <div class="bala_fot"><a href="javascript:;" onclick="exchange_balance()">确认兑换</a></div>
  </div>
  <!-- 底部footer -->
  <link rel="stylesheet" type="text/css" href="/Public/css/footer.css">
<div class="footer">
	<ul class="u3">
		<li <?php if(ACTION_NAME == 'index'): ?>class="cur"<?php endif; ?> >
			<a href="<?php echo U('Index/index');?>" ><div class="img img1"></div><p>拼采廉</p></a>
		</li>
		<li <?php if(ACTION_NAME == 'order_list'): ?>class="cur"<?php endif; ?> >
			<a href="<?php echo U('Index/order_list');?>" ><div class="img img2"></div><p>查订单</p></a>
		</li>
		<li <?php if(ACTION_NAME == 'personal'): ?>class="cur"<?php endif; ?> >
			<a href="<?php echo U('User/personal');?>" ><div class="img img3"></div><p>会员中心</p></a>
		</li>
	</ul>
</div>
</div>


<!-- <script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script> -->
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>
<script type="text/javascript" src="/Public/js/function.js"></script>



<script type="text/javascript">
function exchange_balance(){
  var integral = "<?php echo ($data['integral']); ?>";
  if(integral<=0){  }
  var balance = $('input[name=balance]').val();

  //alert(money+','+out_trade_type);

  var ajaxData = {
    url:'<?php echo U("User/balance");?>',type:'post',dataType:'json',data:{money:money,out_trade_type:out_trade_type},
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

</body>
</html>