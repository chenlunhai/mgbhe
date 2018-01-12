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
<title>红包记录</title>
<link rel="stylesheet" type="text/css" href="/Public/css/red.css">
</head>
<body style="background:#f2f2f2;">
<div class="main">
  <div class="record">
    <div class="rec_top">
      <h3><?php echo ($user["realname"]); ?><span>共收到</span></h3>
      <h4><?php echo ($user["total_red_packet"]); ?><span>元</span></h4>
    </div>
    <div class="rec_con">
      <a <?php if(($state) == "1"): ?>class="cur"<?php endif; ?> class="" href="javascript:;" onclick="get_red_packet(1,this)"><span><?php echo ($user['urp']); ?></span><br>我的红包</a>
      <a <?php if(($state) == "0"): ?>class="cur"<?php endif; ?> href="javascript:;" onclick="get_red_packet(0,this)"><span><?php echo ($user['utrp']); ?></span><br>抢到红包</a>
      <div class="clearboth"></div>
    </div>
    <ul>
      <!-- <li><a><p class="left"><span>张三</span><em>抢</em><br>12-20</p><p class="right">38.00元</p></a></li>
      <li><p class="left"><span>张三</span><em>抢</em><br>12-20</p><p class="right">38.00元</p></li>
      <li><p class="left"><span>张三</span><br>12-20</p><p class="right">38.00元</p></li> -->
    </ul>
    <div class="ping_ts"><!-- 暂无更多红包... --></div>
  </div>
  <!-- 底部footer -->
  
</div>


<!-- <script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/layer.js"></script> -->

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
var state = "<?php echo ($state); ?>";
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
    url:"<?php echo U('Order/envelopes_list');?>",type:'post',dataType:'json',
    data:{page:page,state:state},
    beforeSend:function(data){ layer.load(2) },
    success:function(data){
      layer.closeAll();
      if(data.status==1){
        var info = data.data;
        var len  = info.length;

        var html = '';
        for(var key in info){
      
          html += '<li>';

          if(state==1){
            var href = '"<?php echo U('NoLogin/envelopes','',false);?>/token/'+info[key]['token']+'"';
          }else{
            var href = 'javascript:;';
          }
          html += '<a href='+href+'><p class="left">';
  
          html += '<span><?php echo ($user["realname"]); ?></span>';

          if(state==0)  html += '<em>抢</em>';

          html += '<br>';
          if(state==0)  html += info[key]['gettime'];
          else html += info[key]['addtime'];
          html += '</p>';
          html += '<p class="right">'+info[key]['money']+'元</p></a>';
          html += '</li>';

        }
        $('div.rec_con').next().append(html);
        
        if(page==1 && len==0){ kk = false; $('.ping_ts').html('暂无红包'); }
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

function get_red_packet(state,obj){
  $('div.rec_con').next().empty();
  page = 1;kk = true;
  window.state = state;

  loadNews();

  $(obj).addClass('cur');
  $(obj).siblings().removeClass('cur');
}

</script>

</body>
</html>