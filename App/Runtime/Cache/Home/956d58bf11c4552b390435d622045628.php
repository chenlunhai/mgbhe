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
<title>
    <?php if($user['pid'] == $user['uid'] OR $user['uid'] > 1): ?>团详情 <?php else: ?> 参与拼团<?php endif; ?>
</title>
<link rel="stylesheet" type="text/css" href="/Public/css/group.css?v=1">
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>
<script type="text/javascript" src="/Public/js/function.js"></script>
<script type="text/javascript" src="/Public/js/disable.js"></script>
<script type="text/javascript">
  $('iframe').css('display','none').css('z-index','-1').css('opacity','0');
</script>


</head>
<body style="background:#f2f2f2;">
<div class="main">
  <div class="r_details">
    <div class="rd_con">
        <ul>
            <li class="r_li">
                <div class="img">
                    <a href="javascript:;"><img src="<?php echo ($data['gimg']); ?>"></a>
                </div>
                <div class="right">
                    <p class="title"><?php echo ($data["gname"]); ?></p>
                    <p class="tit">￥<em><?php echo ($data["gteam_price"]); ?></em>/件<span>￥<?php echo ($data["gprice"]); ?></span></p>
                </div>
                <div class="clearboth"></div>
            </li>
        </ul>
    </div>

    <!--特别注意，请勿删除。如若删除，后果自负。-->
    <div class="deta" style="display:none">
        <img src="<?php echo ($data['gimg']); ?>">
        <p class="title"><?php echo ($data["gname"]); ?></p>
        <p class="tit">￥<em><?php echo ($data["gteam_price"]); ?></em>/件<span>￥<?php echo ($data["gprice"]); ?></span></p>
    </div>

    <div class="ils_top">
    	<h3>拼团剩余<span><?php echo ($data["gnum"]-$data["gpay_num"]); ?></span>件</h3>
    	<div class="it_con"><em style="width:<?php echo turnDecimal($data['gpay_num']/$data['gnum'])*100;?>%;"></em></div>
    	<div class="title"><img src="/Public/images/rp_yt.png">已团<?php echo ($data["gpay_num"]); ?>件，还差<?php echo ($data["gnum"]-$data["gpay_num"]); ?>件。</div>
    	<div class="tit">快邀请好友一起来拼团吧！</div>
    </div>
    <div class="ils_con">
    	<h3><em></em>拼团详情</h3>
    	<ul>
            <?php if(is_array($data["order_detail"])): $i = 0; $__LIST__ = $data["order_detail"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li>
    	    		<p class="bt"><?php echo ($val["mobile"]); ?></p><p class="right"><?php echo ($val["paytime"]); ?> 参团</p>
                    <!-- 开团Or参团 -->
    	    	</li><?php endforeach; endif; else: echo "" ;endif; ?>
    	</ul>
    </div>
    <div class="ils_bot">
    	<h3><em></em>拼团玩法</h3>
    	<ul>
    		<li>
    			<em>1</em>
    			<p>选择<br>心仪商品</p>
    		</li>
    		<li>
    			<em>2</em>
    			<p>支付开团<br>或参团</p>
    		</li>
    		<li>
    			<em>3</em>
    			<p>邀请好友<br>参团支付</p>
    		</li>
    		<li>
    			<em>4</em>
    			<p>达到件数<br>团购成功</p>
    		</li>
    	</ul>
    </div>
    <div class="ils_fot">
    	<ul>
            <?php if(($share) == "1"): ?><li class="left"><a href="<?php echo U('Index/group',['gid'=>$data['grid']]);?>">我要参团</a></li>
    		<?php else: ?>
            <li class="left"><a href="javascript:;" onClick="toshare();">快邀请好友参团吧</a></li><!--   --><?php endif; ?>
    		<li class="right"><a href="<?php echo U('Index/index');?>">
    			<div class="img"><img src="/Public/images/p_foot11.png"></div>
    			<p>拼采廉</p>
    		</a></li>
    	</ul>
    </div>
  </div>
<div class="c-share">
  <div class="m_con">
    <div class="img"><img src="/Public/images/inv_01.png"></div>
  </div>
  <div class="a-share-foot">
    <ul>
        <li><a href="javascript:;"   class="a_foot">我知道了</a></li>
        <li><a href="javascript:;" onclick="go_share()">生成邀请二维码</a></li>
    </ul>
  </div>
</div>
</div>
 

<script type="text/javascript">
function go_share(){
    var ajaxData = {
        type:'post',dataType:'json',url:'<?php echo U("Group/get_group_sahre");?>',data:{grid:'<?php echo ($data["grid"]); ?>'},
        beforeSend:function(data){layer.load(2)},
        success:function(data){
            layer.closeAll();
            if(data.status == 1){
                location.href=data.url;
                return;
            }
            layer.msg(data.msg);
        }
    }
    $.ajax(ajaxData);
} 
</script>
<script type="text/javascript">
//点击弹窗
    function toshare(){
        $(".c-share").addClass("am-modal-active"); 
        if($(".sharebg").length>0){
          $(".sharebg").addClass("sharebg-active");
        }else{
          $("body").append('<div class="sharebg"></div>');
          $(".sharebg").addClass("sharebg-active");
        }
        $(".shareb-active,.share_btn,.a_foot").click(function(){
          $(".c-share").removeClass("am-modal-active");  
          setTimeout(function(){
            $(".sharebg-active").removeClass("sharebg-active"); 
            $(".sharebg").remove(); 
          },300);
        })  
    }
</script>

</body>
</html>