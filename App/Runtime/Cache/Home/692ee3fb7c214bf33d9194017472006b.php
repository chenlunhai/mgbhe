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
<title>充值</title>
<link rel="stylesheet" type="text/css" href="/Public/css/wallet.css">
<link rel="stylesheet" type="text/css" href="/Public/css/footer.css">
</head>
<body style="background:#f2f2f2">
<div class="main">
  <div class="recharge">
    <h3>
      <p><?php echo ($data["mobile"]); ?></p>
      <span><?php echo ($data["realname"]); ?></span>
    </h3>
    <div class="rec_con">
      <h4>充值</h4>
      <ul>
        <li class="cur"><a href="javascript:;" onClick="toshare('20.00');">20元<br><span>储值卡</span></a></li>
        <li><a href="javascript:;" onClick="toshare('50.00');">50元<br><span>储值卡</span></a></li>
        <li><a href="javascript:;" onClick="toshare('100.00');">100元<br><span>储值卡</span></a></li>
      </ul>
      <div class="clearboth"></div>
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

<div class="am-share">
  <h4 class="am-share-tit"><span class="share_btn"><img src="/Public/images/not_25.png"></span></h4>
  <h3 class="am-share-title">
    确认付款
  </h3>
  <div class="am_con">
    <p>￥<span id="money">20.00</span></p>
    <h5>付款方式</h5>
    <ul>
      <li>
        <input type="radio" id="radio-1-1" name="out_trade_type" class="regular-radio" value="1" checked="">
        <label for="radio-1-1"><img src="/Public/images/not_zfb.png">支付宝</label>
      </li>
      <!-- <li>
        <input type="radio" id="radio-1-2" name="out_trade_type" class="regular-radio" value="0" >
        <label for="radio-1-2"><img src="/Public/images/not_wx.png">微信</label>
      </li> -->
    </ul>
  </div>
  <div class="am-share-foot">
    <a href="javascript:;"   class="a_foot"  onclick="gopay()">确定</a>
  </div>
</div>

</div>


<!-- <script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script> -->
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>
<script type="text/javascript" src="/Public/js/function.js"></script>
<script type="text/javascript" src="/Public/js/disable.js"></script>
<script type="text/javascript">
  $('iframe').css('display','none').css('z-index','-1').css('opacity','0');
</script>


<script type="text/javascript">
//点击弹窗
function toshare(money){
    $('span#money').html(money);

    $(".am-share").addClass("am-modal-active"); 
    if($(".sharebg").length>0){
      $(".sharebg").addClass("sharebg-active");
    }else{
      $("body").append('<div class="sharebg"></div>');
      $(".sharebg").addClass("sharebg-active");
    }
    $(".sharebg-active,.share_btn,.a_foot").click(function(){
      $(".am-share").removeClass("am-modal-active");  
      setTimeout(function(){
        $(".sharebg-active").removeClass("sharebg-active"); 
        $(".sharebg").remove(); 
      },300);
    });
}
</script>


<script type="text/javascript">
function gopay(){
  var money = parseInt($('span#money').html());  
  var out_trade_type = $('input[name=out_trade_type]:checked').val();

  //alert(money+','+out_trade_type);

  var ajaxData = {
    url:'<?php echo U("User/recharge");?>',type:'post',dataType:'json',data:{money:money,out_trade_type:out_trade_type},
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