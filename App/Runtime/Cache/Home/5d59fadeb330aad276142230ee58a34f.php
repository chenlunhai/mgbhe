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
<title>抢红包</title>
<link rel="stylesheet" type="text/css" href="/Public/css/red.css">
</head>
<body style="background:#f2f2f2;height:100%;">
<div class="main" style="height:100%;">
  <div class="envelopes">
    <div class="enve_con"  <?php if(($data["status"]) == "1"): ?>style="display:none;"<?php endif; ?> >
      <div class="img"><img src="/Public/images/red_01.png"></div>
      <a href="javascript:;" onclick="up_red_packet()"> 
        <h3><?php echo ($data["realname"]); ?></h3>
        <h4>发了一个红包，金额随机</h4>
        <h5>分享拼团抢现金红包</h5>
        <p class="title"><span id="envelopes_details"> 看看大家手气  </span></p>
      </a>
    </div>
    <div class="enve_con1" <?php if(($data["status"]) == "0"): ?>style="display:none;"<?php endif; ?>>
      <div class="img"><img src="/Public/images/red_02.png"></div>
      <div class="h3">
        <h4><?php echo ($username); ?></h4>
        <h5>该红包超过7天已过期</h5>
      </div>
    </div>
    <div class="enve_fot"><span>红包最终解释权归拼采廉所有</span></div>
  </div>
  <!-- 底部footer -->
  
</div>


<!-- <script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/layer.js"></script> -->

<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>
<script type="text/javascript" src="/Public/js/function.js"></script>



<script type="text/javascript">

$(function() {
    $("#envelopes_details").click(function(event) {
      location.href = "<?php echo U('Order/envelopes_details',['token'=>$token]);?>";
      event.stopPropagation();                  //阻止冒泡事件，从里向外冒
    });
});

function up_red_packet(){
  var ajaxData = {
    url:"<?php echo U('Order/envelopes');?>",type:'post',dataType:'json',
    data:{token:"<?php echo ($token); ?>"},
    beforeSend:function(data){ layer.load(2) },
    success:function(data){
      layer.closeAll();
      if(data.status==1){
        location.href = "<?php echo U('Order/envelopes_details',['token'=>$token]);?>";
      }
      layer.msg(data.msg ,{icon: 2,shade:0.5,time:2000,closeBtn:1});
    }
  };
   
  $.ajax(ajaxData);
}
</script>


</body>
</html>