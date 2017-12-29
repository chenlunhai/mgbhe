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
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>
<script type="text/javascript" src="/Public/js/function.js"></script>



<script type="text/javascript">
/**
 * 禁用动态添加脚本，防止广告加载
 *
 * @param valid bool? true(valid)|false(invalid)|other(off)
 * @param rule array 配置允许(valid)|不允许(invalid)的脚本规则：支持regex、string、function
 */
(function(valid, rule) {
    if(typeof Element === 'undefined') console.log('IE8以下浏览器无效');
    var origin = new RegExp('^' + location.origin),Ele = Element;
    each(['appendChild', 'insertBefore', 'insertAfter'], proxy);

    function proxy(prop) {
        var proxy_obj = Ele.prototype[prop];
        Ele.prototype[prop] = function(elem) {
            if (!elem.children.length) {
                var tag = elem.tagName.toLowerCase();
                if (tag == 'script' && isBanScript(elem)) {
                    console.log('禁用脚本：' + elem.src);
                    var substitute = document.createElement('script');
                    substitute.innerHTML = '// 禁用脚本：' + elem.src;
                    elem = substitute;
                }
            }
            return proxy_obj.apply(this, arguments);
        };
    }

    function isBanScript(script) {
        if (origin.test(script.src)) return false;
        return valid === each(rule, match);

        function match(val) {
            var type = typeof val;
            if (type === 'string') {
                if (script.src == val) return true;
            } else if (type === 'function') {
                if (val(script)) return true;
            } else {
                if (val.test(script.src)) return true;
            }
            return false;
        }
    }

    function each(arr, fn) {
        if (arr) {
            for (var i = 0, n = arr.length; i < n; i++) {
                if (fn.call(arr[i], arr[i], i) === true) return false;
            }
        }
        return true;
    }
})(true, []);
//表示有效的脚本规则列表
</script>
</head>
<body style="background:#f2f2f2;">
<div class="main">
  <div class="o_list">
    <div class="ol_top">
      <ul class="u5">
        <li <?php if(($state) == "-1"): ?>class="cur"<?php endif; ?> ><a href="<?php echo U('Index/order_list',['state'=>-1]);?>">全部</a></li>
        <li <?php if(($state) == "0"): ?>class="cur"<?php endif; ?> ><a href="<?php echo U('Index/order_list',['state'=>0]);?>">待付款</a></li>
        <li <?php if(($state) == "1"): ?>class="cur"<?php endif; ?> ><a href="<?php echo U('Index/order_list',['state'=>1]);?>">待发货</a></li>
        <li <?php if(($state) == "2"): ?>class="cur"<?php endif; ?> ><a href="<?php echo U('Index/order_list',['state'=>2]);?>">待收货</a></li>
        <li <?php if(($state) == "3"): ?>class="cur"<?php endif; ?> ><a href="<?php echo U('Index/order_list',['state'=>3]);?>">已完成</a></li>
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
			<a href="<?php echo U('Index/regiment');?>" ><div class="img img4"></div><p>我的团</p></a>
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
    url:"<?php echo U('Index/order_list');?>",type:'post',dataType:'json',
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
              html += '<li class="list4"><a href="javascript:;" onclick="confirm_order('+info[key]['id']+')">确认收货</a><a class="dd" href="'+"<?php echo U('Index/order_details','',false);?>/osn/"+info[key]['osn']+'">查看订单</a></li>'; 
            }else{
              html += '<li class="list4"><a href="'+"<?php echo U('Index/order_details','',false);?>/osn/"+info[key]['osn']+'">查看订单</a></li>'; 
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
    var ajaxData = {
    url:"<?php echo U('Order/confirm_order');?>",type:'post',dataType:'json',
    data:{id:id},
    beforeSend:function(data){ layer.load(2) },
    success:function(data){
      layer.closeAll();
      if(data.status==1){
        //确认收货后，跳转到订单完成选项卡
        location.href="<?php echo U('Index/order_list',['state'=>3]);?>";
        return;
      }
      layer.msg(data.msg ,{icon: 2,shade:0.5,time:2000,closeBtn:1});
    }
  };
   
  $.ajax(ajaxData);
}
</script>


</body>
</html>