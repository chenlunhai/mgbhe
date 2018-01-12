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
<title>余额详情</title>
<link rel="stylesheet" type="text/css" href="/Public/css/wallet.css">
<link rel="stylesheet" type="text/css" href="/Public/css/footer.css">
</head>
<body style="background:#f2f2f2;">
<div class="main">
  <div class="details">
    <ul>
      <!-- <li>
        <div class="left">
          <p class="title">积分兑换余额</p>
          <p class="tit">2017-12-23 16:00:00</p>
        </div>
        <div class="right">5.00</div>
      </li> -->
    </ul>

    <div class="ping_ts">   </div>
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
var w = $(window);
var kk = true;
var pagecount = 0;
var page = 1;
window.onscroll = function()
{
  var scrollh = $(document).height();
  scrollh = scrollh-36;
  var c=document.documentElement.clientHeight || document.body.clientHeight, t=$(document).scrollTop();
  if(kk != false && (t + w.height()) >= scrollh){
    kk=false;
    page++;
    loadNews();
  }
}

loadNews();

function loadNews(){

  var index = layer.load(2);
  var ajaxData = {
    url:"<?php echo U('User/balance_details');?>",type:'post',dataType:'json',
    data:{page:page},
    beforeSend:function(data){ layer.load(2) },
    success:function(data){
      layer.closeAll();
      if(data.status==1){
        var info = data.data;
        var len  = info.length;

        var html = '';
        for(var key in info){
        
          html += '<li>';
          html += '<div class="left">';
          html += '<p class="title">'+info[key]['remark']+'</p>';
          html += '<p class="tit">'+info[key]['addtime']+'</p>';
          html += '</div>';
          html += '<div class="right">'+info[key]['money']+'元</div>';
          html += '</li>';

        }
        $('div.details').find('ul').append(html);
        
        if(page==1 && len==0){ kk = false; $('.ping_ts').html('暂无数据'); }
        else{
          if(len<6){
            kk = false; $('.ping_ts').html('没有更多...');
          }else{
            kk=true; $('.ping_ts').html('下拉加载更多...');
          }
        }
      }else{
        kk=false; $('.ping_ts').html('没有更多...');
      }
    }
  };
   
  $.ajax(ajaxData);
}
</script>

</body>
</html>