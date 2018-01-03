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
<title>我的订单</title>
<link rel="stylesheet" type="text/css" href="/Public/css/group.css">

</head>
<body style="background:#f2f2f2;">
<div class="main">
  <div class="o_list">
    <div class="ol_top">
      <ul class="u5">
        <li <?php if(($state) == "0"): ?>class="cur"<?php endif; ?> ><a href="<?php echo U('Group/order_list',['state'=>0]);?>">待付款</a></li>
        <li <?php if(($state) == "-1"): ?>class="cur"<?php endif; ?> ><a href="<?php echo U('Group/order_list',['state'=>-1]);?>">待满团</a></li>
        <li <?php if(($state) == "1"): ?>class="cur"<?php endif; ?> ><a href="<?php echo U('Group/order_list',['state'=>1]);?>">待发货</a></li>
        <li <?php if(($state) == "2"): ?>class="cur"<?php endif; ?> ><a href="<?php echo U('Group/order_list',['state'=>2]);?>">待收货</a></li>
        <li <?php if(($state) == "3"): ?>class="cur"<?php endif; ?> ><a href="<?php echo U('Group/order_list',['state'=>3]);?>">已完成</a></li>
      </ul>
    </div>
    <div class="ol_con">
      
      <!-- <ul>
        <li class="list1">订单号：012131213561231564213<span>待收货</span></li>
        <li class="list2">
          <div class="img"><img src="/Public/images/12.jpg"></div>
          <div class="title">数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝</div>
          <div class="tit"><span>￥98.00</span>/件<br>X1</div>
        </li>
        <li class="list3">共<span>1</span>个商品，总额:<span>￥98.00</span>元</li>
        <li class="list4"><a href="javascript:;">确认收货</a></li>
      </ul>
      <ul>
        <li class="list1">订单号：012131213561231564213<span>待收货</span></li>
        <li class="list2">
          <div class="img"><img src="/Public/images/12.jpg"></div>
          <div class="title">数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝</div>
          <div class="tit"><span>￥98.00</span>/件<br>X1</div>
        </li>
        <li class="list3">共<span>1</span>个商品，总额:<span>￥98.00</span>元</li>
        <li class="list4"><a href="javascript:;">确认收货</a></li>
      </ul> -->

    </div>
    <div class="ping_ts"><!-- 暂无更多数据... --></div>
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
//去除广告
//window.onload =function(){ 
  //$("div[id^=ads]").hide();    //$("div[id^=ads][id$=_wrap]").hide();
//}

function getTradeStatus(i){
    var arr = ['待付款','待发货','已发货','已收货','退款中','退款成功'];
    return arr[i];
}

var state = "<?php echo ($state); ?>";
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
  //alert(page+','+state);
  var index = layer.load(2);
  var ajaxData = {
    url:"<?php echo U('Group/order_list');?>",type:'post',dataType:'json',
    data:{page:page,state:state},
    beforeSend:function(data){ layer.load(2) },
    success:function(data){
      layer.closeAll();

      if(data.status==0){
        kk=false;
        layer.msg(data.msg ,{icon: 2,shade:0.5,time:2000,closeBtn:1});
        return;
      }

      if(data.status==1){
        var info = data.data;
        var len  = info.length;  //alert(len);

        var html = '';
        for(var key in info){
          html += '<ul>';

          html += '<li class="list1">订单号：'+info[key]['osn']+'<span>'+getTradeStatus(info[key]['trade'])+'</span></li>';
          html += '<li class="list2">';
          html += '<div class="img"><img src="'+info[key]['gimg']+'"></div>';
          html += '<div class="title">'+info[key]['gname']+'</div>';  
          html += '<div class="tit"><span>￥'+info[key]['gteam_price']+'</span>/件<br>X'+info[key]['pay_num']+'</div>'; 
          html += '</li>';   
          html += '<li class="list3">共<span>'+info[key]['pay_num']+'</span>个商品，总额:<span>￥'+info[key]['total_price']+'</span>元</li>'; 

          if(info[key]['trade']==0){
            html += '<li class="list4"><a href="'+"<?php echo U('Order/cashier','',false);?>/osn/"+info[key]['osn']+'">去付款</a><a href="javascript:;" class="dd" hidden>取消订单</a></li>'; 
          }else{
            if(info[key]['trade']==2){
              html += '<li class="list4"><a href="javascript:;" onclick="confirm_order('+info[key]['id']+')">确认收货</a><a class="dd" href="'+"<?php echo U('Group/order_details','',false);?>/osn/"+info[key]['osn']+'">查看订单</a></li>'; 
            }else{
              html += '<li class="list4"><a href="'+"<?php echo U('Group/order_details','',false);?>/osn/"+info[key]['osn']+'">查看订单</a></li>'; 
            }
          }
          
          html += '</ul>';
        }
        
        $('div.ol_con').append(html);
        
        if(page==1 && len==0){ kk = false; $('.ping_ts').html('暂无数据'); }
        else{
          if(len<6){
            kk = false; $('.ping_ts').html('没有更多...');
          }else{
            kk=true; $('.ping_ts').html('下拉加载更多...');
          }
        }

      }

    }
  };
   
  $.ajax(ajaxData);
}

//确认收货
function confirm_order(id){
layer.confirm('您要确认收货吗？', {icon: 3, title:'提示'}, function(index){
    layer.close(index);
      var ajaxData = {
      url:"<?php echo U('Order/confirm_order');?>",type:'post',dataType:'json',
      data:{id:id},
      beforeSend:function(data){ layer.load(2) },
      success:function(data){
        layer.closeAll();
        if(data.status==1){
          setTimeout('location.href="<?php echo U("Group/order_list",["state"=>3]);?>";',2000);
        }
        layer.msg(data.msg ,{icon: data.status,shade:0.5,time:2000});
      }
    };
     
    $.ajax(ajaxData);
});
    
}
</script>


</body>
</html>