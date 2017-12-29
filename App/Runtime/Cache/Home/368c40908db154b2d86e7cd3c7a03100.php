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
<title>商品详情</title>
<link rel="stylesheet" type="text/css" href="/Public/css/group.css">
</head>
<body style="background:#f2f2f2;">
<div class="main" style="padding-bottom:41px;">
  <div class="war_show">
    
    <div class="show_con">
      <div class="show_img">
        <div class="addWrap">
          <div class="swipe" id="mySwipe">
            <div class="swipe-wrap">
              <div><a href="javascript:;"><img class="img-responsive" src="<?php echo ($data["gimg"]); ?>"/></a></div>
            </div>
          </div>
          
          <ul id="position">
            <li class="cur"></li>
          </ul>
        </div><!--/addWrap-->
      </div>

      <div class="show_c_t">
        <p class="title"><?php echo ($data["gname"]); ?></p>
        <p class="tit">拼团价￥<em><?php echo ($data["gteam_price"]); ?></em>/件 <span>￥<?php echo ($data["gprice"]); ?></span></p>      
        <div class="clearboth"></div>
      </div>

      <div class="show_c_n">
        <div class="cn_top">
          <ul>
            <li class="c_t"><p class="ct"><img src="/Public/images/rp_rq.png">期数</p><p class="tit"><img src="/Public/images/rp_mt.png">满团数</p><p class="tit"><img src="/Public/images/rp_zd.png">起订量</p></li>
            <li class="c_b"><p style="text-align:left;">第<?php echo ($data["gsn"]); ?>期</p><p><?php echo ($data["gnum"]); ?>件</p><p><?php echo ($data["gpay_limit"]); ?>件</p></li>
          </ul>
        </div>
        <div class="cn_bot">
          <h3><img src="/Public/images/rp_yt.png">已团<?php echo ($data["gpay_num"]); ?>件，还差<?php echo ($data['gnum']-$data['gpay_num']); ?>件。</h3>
          <h4>
            <em style="width:<?php echo turnDecimal($data['gpay_num']/$data['gnum'])*100;?>%;"></em>
          </h4>
          <h3><img src="/Public/images/rp_zy.png">参团数满后5天内发货。</h3>
        </div>
      </div>

      <div class="show_c_c">
        <div class="cc_top">
          <div class="center">
            <p class="title"><?php echo ($data["sname"]); ?></p>
            <p class="tit">官方认证</p>
          </div>
          <div class="right"><a href="<?php echo U('NoLogin/shop',['id'=>$data['sid']]);?>"><img src="/Public/images/rp_sd.png">进入店铺</a></div>
        </div>
      </div>

      <div class="show_c_b">
        <p>数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝数钜宝</p>
        <img src="/Public/images/12.jpg">
      </div>

    </div>

  </div>
  <!-- 底部footer -->
  <div class="show_footer">
    <div class="s_f_gwc gwc3">
      <a href="tel:<?php echo ($shop["service_tel"]); ?>">
        <div class="f_g_img"><img src="/Public/images/d_dh.png"></div>
        <p>客服</p>
      </a>
      <a href="<?php echo U('Index/shop',['id'=>$data['sid']]);?>">
        <div class="f_g_img"><img src="/Public/images/d_sp.png"></div>
        <p>店铺</p>
      </a>
    </div>
    <ul>
      <li class="lj"><a onClick="toshare();" href="javascript:;">
        <?php if($user['pid'] == $user['uid'] OR $user['uid'] > 1): ?>立即购买 <?php else: ?> 立即参团<?php endif; ?>
      </a></li>
    </ul>
  </div>

<div class="a-share">
  <h3 class="am-share-title">
    <img src="<?php echo ($data["gimg"]); ?>">
    <div class="a_l">
      <p class="a_lt">¥<em id="goods_total_price"><?php echo ($data["gteam_price"]); ?></em></p>
      <p class="a_lb">￥<?php echo ($data["gteam_price"]); ?>/件<span>￥<?php echo ($data["gprice"]); ?></span></p>
    </div>
  </h3>
  <h4 class="am-share-tit"><span class="share_btn"><img src="/Public/images/not_25.png"></span></h4>
  <div class="a_con">
    <ul>
      <li class="a_cn">
        <h4>数量</h4>
        <ul class="btn-numbox">
          <li>
            <ul class="count">
              <li><span id="num-jian" class="num-jian">-</span></li>
              <li><input type="text" class="input-num" id="input-num" value="1" disabled/></li>
              <li><span id="num-jia" class="num-jia">+</span></li>
            </ul>
          </li>
        </ul>
        <div class="clearboth"></div>
      </li>
      <!-- <li class="a_cn">
        <h3>规格</h3>
          <input type="radio" id="radio-1-1" name="radio-1-set" class="regular-radio" checked />
          <label for="radio-1-1">默认</label>
          <input type="radio" id="radio-1-2" name="radio-1-set" class="regular-radio" />
          <label for="radio-1-2">默认</label>
      </li> -->
      
    </ul>
  </div>
  <div class="am-share-foot">
    <a href="javascript:;"  onclick="checkOrder()" class="a_foot">确定</a> <!--  <?php echo U('Order/order');?> -->
  </div>
</div>

</div>


<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>
<script type="text/javascript" src="/Public/js/function.js"></script>



<script type="text/javascript">
  //点击弹窗
  function toshare(){
      $(".a-share").addClass("am-modal-active"); 
      if($(".shareb").length>0){
        $(".shareb").addClass("shareb-active");
      }else{
        $("body").append('<div class="shareb"></div>');
        $(".shareb").addClass("shareb-active");
      }
      $(".shareb-active,.share_btn,.a_foot").click(function(){
        $(".a-share").removeClass("am-modal-active");  
        setTimeout(function(){
          $(".shareb-active").removeClass("shareb-active"); 
          $(".shareb").remove(); 
        },300);
      })
  }


    var num_jia = document.getElementById("num-jia");
    var num_jian = document.getElementById("num-jian");
    var input_num = document.getElementById("input-num");
    num_jia.onclick = function() {
        input_num.value = parseInt(input_num.value) + 1;

        var goods_total_price = $("#goods_total_price").html();  
        goods_total_price = ( parseFloat(goods_total_price) + parseFloat("<?php echo ($data['gteam_price']); ?>") ).toFixed(2);
        $("#goods_total_price").html(goods_total_price);
    }
    num_jian.onclick = function() {
        if(input_num.value <= 1){ input_num.value = 1; }
        else{ 
          input_num.value = parseInt(input_num.value) - 1; 

          var goods_total_price = $("#goods_total_price").html();  
          goods_total_price = ( parseFloat(goods_total_price) - parseFloat("<?php echo ($data['gteam_price']); ?>") ).toFixed(2);
          $("#goods_total_price").html(goods_total_price);
        }
    }
</script>

<script src='/Public/js/hhSwipe.js' type="text/javascript"></script>
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


<script type="text/javascript">
function checkOrder(){
    var buy_num = document.getElementById("input-num").value;
    $.ajax({
      url:"<?php echo U('NoLogin/group');?>",type:'post',dataType:'json',
      data:{id:"<?php echo ($id); ?>",buy_num:buy_num},
      success:function(data){
        layer.closeAll();
        
        if(data.status==1){
          location.href="<?php echo U('Order/order');?>";
          return;
        }
        
        if(data.status==-1){
          layer.confirm('您还未登录，请登录', {btn: ['确定','取消'] }, 
            function(){
              setTimeout(location.href=data.gourl,2000);
            }
          );

          return;
        }

        layer.msg(data.msg,{icon: 2,shade:0.5,time:2000,closeBtn:1});
      }
    }); 
}
  

</script>
</body>
</html>