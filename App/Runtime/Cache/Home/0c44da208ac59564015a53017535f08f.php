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
<title>商品列表</title>
<link rel="stylesheet" type="text/css" href="/Public/css/group.css">
<link rel="stylesheet" type="text/css" href="/Public/css/footer.css">
</head>
<body style="background:#f2f2f2;">

<div class="main">
  <div class="class">

    <!-- <div id="wrapper">
      <div id="scroller">      
        <ul>
            <li <?php if(empty($gcid)): ?>class="hov"<?php endif; ?> ><a href="<?php echo U('Index/index');?>">首页</a></li>
            <?php if(is_array($cate)): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li <?php if($gcid == $val['id']): ?>class="hov"<?php endif; ?> >
                <a href="javascript:;" onclick="chooseHeadCate(<?php echo ($val["id"]); ?>,this)"><?php echo ($val["name"]); ?></a>
              </li><?php endforeach; endif; else: echo "" ;endif; ?>
            <div style="clear:both;"></div>
        </ul>   
      </div>
    </div>
    <div class="cla_top">
      <ul>
        <?php if(is_array($subCate[$gcid])): $i = 0; $__LIST__ = $subCate[$gcid];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li><a href="javascript:;" onclick="chooseSubCate(<?php echo ($val["id"]); ?>,this)"><?php echo ($val["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>
      <div class="clearboth"></div>
    </div> -->

    <div class="sear">
      <form method="get">
        <input type="text" class="s-input" placeholder="搜索商品名称" name="gname">
        <input type="button" class="s-button" style="cursor:pointer;" onclick="search_gname($(this).prev().val())">
        <div style="clear:both"></div>
      </form>
    </div>


    <div class="shop_con" style="margin:10px auto 0; background:#fff; padding-top:15px;">
      <ul>
        <!-- <li>
          <div class="img">
            <a href="javascript:;"><img src="/Public/images/12.jpg"></a>
          </div>
          <p class="title">数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝</p>
          <p class="tit">￥<em>98.00</em>/件<span>￥128.00</span></p>
          <p class="pt"><a href="javascript:;">立即拼团</a></p>
        </li> -->
      </ul>
      <div class="clearboth"></div>
      <div class="ping_ts"><!-- 暂无更多数据... --></div>
    </div>


    <!-- <div class="cla_con">
      <ul>
        
      </ul>
      <div class="ping_ts"> 暂无更多数据... </div>
    </div> -->

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

<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/iscro.js"></script>
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
<script type="text/javascript">
  $('.cla_top ul li:nth-child(5n)').css('border-right','none');
</script>


<!-- 分页加载首页数据 -->
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>
<script type="text/javascript" src="/Public/js/function.js"></script>



<script type="text/javascript">
var gcid = "<?php echo ($gcid); ?>";   //加载数据的分类id
var gname = "";

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
  //alert(gcid+","+gname+","+page);
  var index = layer.load(2); 
  var ajaxData = {
    url:"<?php echo U('Index/classification');?>",type:'post',dataType:'json',
    data:{page:page,gcid:gcid,gname:window.gname},
    beforeSend:function(data){ layer.load(2) },
    success:function(data){
      layer.closeAll();

      if(data.status==1){
        var info = data.data;
        var len  = info.length;
       /* alert(page+':'+gcid);
        alert(len);*/

        var html = '';
        for(var key in info){
          html += '<li>'; 
          html += '<div class="img">'; 
          html += '<a href="javascript:;"><img src="'+info[key]['gimg']+'"></a>'; 
          html += '</div>'; 
          html += '<p class="title">'+info[key]['gname']+'</p>'; 
          html += '<p class="tit">￥<em>'+info[key]['gteam_price']+'</em>/件<span>￥'+info[key]['gprice']+'</span></p>';
          html += '<p class="pt"><a href="'+"<?php echo U('Index/group','',false);?>/gid/"+info[key]['id']+'">立即拼团</a></p>';
          html += '</li>';

          /*html += '<li>';  
          html += '<div class="img"><a href="javascript:;"><img src="'+info[key]['gimg']+'"></a></div>';
          html += '<div class="right">';
          html += '<div class="title">'+info[key]['gname']+'</div>';
          html += '<div class="cl_bot"><p>￥<em>'+info[key]['gteam_price']+'</em>/件<span>￥'+info[key]['gprice']+'</span></p><a href="'+"<?php echo U('Index/group','',false);?>/gid/"+info[key]['id']+'">立即拼团</a></div>';
          html += '</div>';
          html += '<div class="clearboth"></div>';
          html += '</li>';*/
        }
  
        $('div.shop_con>ul').append(html);
        
         
        if(page==1 && len==0){ kk = false; $('div.shop_con>.ping_ts').html('暂无数据'); }
        else{
          if(len<6){
            kk = false; $('div.shop_con>.ping_ts').html('没有更多...');
          }else{
            kk=true; $('div.shop_con>.ping_ts').html('下拉加载更多...');
          }
        }
      }else{
        kk=false; $('div.shop_con>.ping_ts').html('没有更多...');
      }
    }
  };
   
  $.ajax(ajaxData);
}
</script>

<script type="text/javascript">
//搜索商品名称
function search_gname(gname){
  $('div.shop_con>ul').empty(); $('div.shop_con>.ping_ts').empty();
  window.gname = gname;
  page = 1;
  kk = true;

  loadNews();
}

//点击头部分类
function chooseHeadCate(id,obj){
  $(obj).parent('li').siblings().removeClass('hov');
  $(obj).parent('li').addClass('hov');

  var str=<?php echo json_encode($subCate);?>;
  var arr_obj=eval(str);

  var html = '';
  //二级分类数据对象
  var index = parseInt(id);
  var subdata = arr_obj[index];
  for(var k in subdata){
    html += '<li><a href="javascript:;" onclick="chooseSubCate('+subdata[k]['id']+',this)">'+subdata[k]['name']+'</a></li>'
  }
  $('.cla_top>ul').html(html);
  /*console.log(html);
  console.log(subdata);
  console.log(arr_obj);*/

  $('div.cla_con>ul').empty(); $('div.cla_con>.ping_ts').empty();
  window.gcid = id;
  window.page = 1;
  window.kk = true; 
  loadNews();
}

//点击二级分类
function chooseSubCate(id,obj){
  $(obj).parent('li').addClass('cur');
  $(obj).parent('li').siblings().removeClass('cur');
  
  $('div.cla_con>ul').empty(); $('div.cla_con>.ping_ts').empty();
  window.gcid = id;
  window.page = 1;
  window.kk = true;
  loadNews();
}

</script>
</body>
</html>