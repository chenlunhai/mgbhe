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
<title>拼采廉</title>
<link rel="stylesheet" type="text/css" href="/mgbh/Public/css/group.css">
</head>
<body style="background:#f2f2f2;">
<div class="main">
  <div class="index">
    <div id="wrapper">
      <div id="scroller">      
        <ul>
            <li class="hov"><a href="<?php echo U('Index/index');?>">首页</a></li>
            <?php if(is_array($cate)): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Index/classification',['gcid'=>$val['id']]);?>"><?php echo ($val["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>

            <div style="clear:both;"></div>
        </ul>      
      </div>
    </div>

    <div class="addWrap" style="padding-top:40px;">
      <div class="swipe" id="mySwipe">
        <div class="swipe-wrap">
          <?php if(is_array($banner)): $i = 0; $__LIST__ = $banner;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><div><a href="<?php echo ($val["url"]); ?>"><img class="img-responsive" src="<?php echo ($val["img"]); ?>"/></a></div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
      </div>
      
      <ul id="position">
        <li class="cur">  </li>
        <li></li>
        <li></li>
      </ul>
    </div><!--/addWrap-->

    <div class="index_nav">
      <ul class="u4">
        <li><a href="<?php echo U('NoLogin/shop',['guser_limit'=> 0]);?>">
          <div class="img"><img src="/mgbh/Public/images/p_02.png"></div>
          <p>消费进</p>
        </a></li>
        <li><a class="btn01" data-toggle="modal" 
          <?php if(($grade) == "1"): ?>href="<?php echo U('NoLogin/shop',['guser_limit'=> 1]);?>" <?php else: ?> href="#login-modal"<?php endif; ?> >
          <div class="img"><img src="/mgbh/Public/images/p_03.png"></div>
          <p>店家进</p>
        </a></li>
        <li><a href="<?php echo U('Index/regiment');?>">
          <div class="img"><img src="/mgbh/Public/images/p_04.png"></div>
          <p>我的团</p>
        </a></li>
        <li><a href="<?php echo U('Index/search');?>">
          <div class="img"><img src="/mgbh/Public/images/p_05.png"></div>
          <p>全部商品</p>
        </a></li>
      </ul>
      <div class="clearboth"></div>
    </div>

    <div class="shop_con" style="margin:10px auto 0; background:#fff; padding-top:15px;">
      <ul>
        <!-- <li>
          <div class="img">
            <a href="javascript:;"><img src="/mgbh/Public/images/12.jpg"></a>
          </div>
          <p class="title">数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝</p>
          <p class="tit">￥<em>98.00</em>/件<span>￥128.00</span></p>
          <p class="pt"><a href="javascript:;">立即拼团</a></p>
        </li> -->
      </ul>
      <div class="clearboth"></div>
      
    </div><div class="ping_ts"><!-- 暂无更多数据... --></div>

    <div class="cla_con">
      <!-- 首页商品数据 -->
      <ul></ul>
      <!-- 提示信息 -->
      
    </div>

  </div>
  <!-- 底部footer --> 
  <link rel="stylesheet" type="text/css" href="/mgbh/Public/css/footer.css">
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

<script type="text/javascript" src="/mgbh/Public/js/jquery.js"></script>
<script type="text/javascript" src="/mgbh/Public/js/layer.js"></script>
<script type="text/javascript" src="/mgbh/Public/js/function.js"></script>



<div class="modal" id="login-modal">
  <h3>提示</h3>
  <div class="title">您还不是店家，无法查看！</div>
  <div class="bot">
    <a href="javascript:;" onclick='$("#login-modal").modal("hide");' >再逛逛</a>
    <a href="<?php echo ($authentication); ?>" class="rz">去认证</a>
  </div>
</div>

<!-- <script type="text/javascript" src="/mgbh/Public/js/jquery.js"></script> -->
<script type="text/javascript" src="/mgbh/Public/js/iscro.js"></script>
<script type="text/javascript">
  var myScroll;
  function loaded () {
    if($('#scroller ul li').size()) {
      var wid = 40;
      $('#scroller ul li').each(function() {
        wid += $(this).width();
      });
      $('#scroller').css('width', wid);
      var win_width = $(window).width();
      // if(wid < win_width) {
      //  $('#sj_con').hide();
      // }
      
      myScroll = new IScroll('#wrapper', { eventPassthrough: true, scrollX: true, scrollY: false, preventDefault: false }); 
      
      var wrapper_list_li_right = $('#wrapper li.hov').position().left + $('#wrapper li.hov').width();
      var wrapper_list_li_padding = parseInt($('#wrapper li.hov').css('padding-left')) + parseInt($('#wrapper li.hov').css('padding-right'));
      var scroller_padding = parseInt($('#wrapper #scroller').css('padding-left')) + parseInt($('#wrapper #scroller').css('padding-right'));
      //console.log(scroller_padding);
      var translate_x = win_width - scroller_padding - wrapper_list_li_right - wrapper_list_li_padding;
      var wrapper_canvas = $('#wrapper #scroller');
      if(translate_x < 0) {
        wrapper_canvas.css({'-webkit-transform':'translateX(' + translate_x + 'px)'});  
        wrapper_canvas.css({'-webkit-transition-duration':'300ms'});
      }
    } else {
      $('#wrapper').remove();
      $('#con_bar').css('margin-top', '-1px');
    }
  }
  $(window).load(function() {
    loaded();
    if($('#more').next('div').text().trim() == ''){
      $('#more').css('background','url()');
    }
  });
</script>
<script src='/mgbh/Public/js/hhSwipe.js' type="text/javascript"></script>
<script type="text/javascript">
  var bullets = document.getElementById('position').getElementsByTagName('li');

  var banner = Swipe(document.getElementById('mySwipe'), {
    auto: 2000,
    continuous: true,
    disableScroll:false,
    callback: function(pos) {
      var i = bullets.length;
      while (i--) {
        bullets[i].className = ' ';
      }
      bullets[pos].className = 'cur';
    }
  })

</script>
<script type="text/javascript" src="/mgbh/Public/js/modal.js"></script>

<!-- 分页加载首页数据 -->
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
    url:"<?php echo U('NoLogin/index');?>",type:'post',dataType:'json',
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
          html += '<div class="img">';
          if("<?php echo ($grade); ?>"==1){
            //店家用户 -  可参与所有团
            html += '<a  href="'+"<?php echo U('NoLogin/group','',false);?>/gid/"+info[key]['id']+'"><img src="'+info[key]['gimg']+'"></a>';
          }else if("<?php echo ($grade); ?>"==0){
            //消费者用户 -  只可参与消费团
            if(info[key]['guser_limit']==0){
              //消费者 商品
              html += '<a href="'+"<?php echo U('NoLogin/group','',false);?>/gid/"+info[key]['id']+'"><img src="'+info[key]['gimg']+'"></a>';
            }else if(info[key]['guser_limit']==1){
              //店家 商品
              html += '<a data-toggle="modal" href="#login-modal" ><img src="'+info[key]['gimg']+'"></a>';
            }
            
          }
          //html += '<a href="javascript:;"><img src="'+info[key]['gimg']+'"></a>';
          html += '</div>';
          html += '<p class="title">'+info[key]['gname']+'</p>';
          html += '<p class="tit">￥<em>'+info[key]['gteam_price']+'</em>/件<span>￥'+info[key]['gprice']+'</span></p>';
          html += '<p class="pt">';  //<a href="javascript:;">立即拼团</a>
          if("<?php echo ($grade); ?>"==1){
            //店家用户 -  可参与所有团
            html += '<a  href="'+"<?php echo U('NoLogin/group','',false);?>/gid/"+info[key]['id']+'">立即拼团</a>';
          }else if("<?php echo ($grade); ?>"==0){
            //消费者用户 -  只可参与消费团
            if(info[key]['guser_limit']==0){
              //消费者 商品
              html += '<a href="'+"<?php echo U('NoLogin/group','',false);?>/gid/"+info[key]['id']+'">立即拼团</a>';
            }else if(info[key]['guser_limit']==1){
              //店家 商品
              html += '<a data-toggle="modal" href="#login-modal" >立即拼团</a>';
            }
            
          }
          html += '</p>';
          html += '</li>';

        }
        $('div.shop_con>ul').append(html);
        
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
</body>
</html>