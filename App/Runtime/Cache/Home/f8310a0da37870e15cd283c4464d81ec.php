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
<title>收银台</title>
<link rel="stylesheet" type="text/css" href="/Public/css/group.css">
</head>
<body style="background:#f2f2f2;">
<div class="main">
  <div class="cashier">
    <div class="cas_top">
      <ul>
        <li><span>订单编号</span><?php echo ($data["osn"]); ?></li>
        <li><span>订单金额</span><em>￥<?php echo ($data["pay_price"]); ?></em></li>
      </ul>
    </div>
    <div class="cas_bot">
      <ul>
       
        <li><a href="javascript:;" onclick="cashier(0)">  <!--  success.html -->
          <div class="img wx"><img src="/Public/images/p_wx.png"></div>
          <div class="right">
            <p class="title">微信支付</p>
            <p class="tit">微信安全支付</p>
          </div>
          <div class="clearboth"></div>
        </a></li>
        
        <li><a href="javascript:;" onclick="cashier(1)">  <!--  success.html -->
          <div class="img zfb"><img src="/Public/images/p_zfb.png"></div>
          <div class="right">
            <p class="title">支付宝支付</p>
            <p class="tit">支付宝安全支付</p>
          </div>
          <div class="clearboth"></div>
        </a></li>
      
        <li class="balance"><a class="btn01" data-toggle="modal" href="#login-modal" >
          <div class="img fk"><img src="/Public/images/p_fk.png"></div>
          <div class="right">
            <p class="title">余额支付</p>
            <p class="tit">当前余额：<span>￥<?php echo ($user["balance"]); ?></span></p>
          </div>
          <div class="clearboth"></div>
        </a></li>
      </ul>
    </div>
  </div>
</div>
<div class="modal" id="login-modal">
  <h3>提示</h3>
  <div class="title" style="text-align:left; margin-left:30px;">您确定使用余额支付吗？</div>
  <div class="bot">
    <a href="javascript:;" onclick='$("#login-modal").modal("hide")'>取消</a>
    <a href="javascript:;" onclick='$("#login-modal").modal("hide");cashier(2)' class="rz">确定</a>
  </div>
</div>

<!-- <script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script> -->
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>
<script type="text/javascript" src="/Public/js/function.js"></script>



 <script type="text/javascript" src="/Public/js/modal.js"></script>
<script type="text/javascript">
/*$(document).ready(function(){
  $("#login-modal").modal("hide");
  $("a.btn01").click(function(){
    $("#login-modal").modal("show");
  });
});*/
</script>

<script type="text/javascript">
//付现-确认付款
function cashier(out_trade_type){
  var osn = "<?php echo ($data['osn']); ?>";
  //alert(osn+":"+out_trade_type);

  var ajaxData = {
    url:'<?php echo U("Order/cashier");?>',type:'post',dataType:'json',data:{out_trade_type:out_trade_type,osn:osn}, 
    beforeSend:function(data){ 
      layer.load(2);
    },
    success:function(data){
      layer.closeAll();
      if(data.status==1 && out_trade_type==2){ 
        //余额支付
        location.href="<?php echo U('Order/order_success','',false);?>/osn/"+data.data.osn;
        return;
      }
      if(data.status==1){
        location.href=data.data.payurl;
        return;
      }
      layer.msg(data.msg ,{icon: 2,shade:0.5,time:2000,closeBtn:1})
    }
  };

  $.ajax(ajaxData);
}
</script>
</body>
</html>