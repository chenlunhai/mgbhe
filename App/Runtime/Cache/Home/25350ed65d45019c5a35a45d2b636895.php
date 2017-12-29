<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta name="baidu-site-verification" content="brSKk1xvoHM7I577">
<meta name="description" content=""/>
<meta name="keywords" content=""/>
<title>搜索</title>
<link rel="stylesheet" type="text/css" href="/Public/css/group.css">
<link rel="stylesheet" type="text/css" href="/Public/css/footer.css">
</head>
<body style="background:#f2f2f2">
<div class="main" style="padding:0;">
	<div class="wa_cla">
    <div class="sear">
      <a href="javascript:;"><img src="/Public/images/st_ss.png">搜索商品</a>
    </div>
    <div class="content-list">
      <ul class="goods-class">
        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li <?php if(($i) == "1"): ?>class="active"<?php endif; ?> id="<?php echo ($val['id']); ?>"><?php echo ($val['name']); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
          <!-- <li>分类2</li>
          <li>分类3</li>
          <li>分类4</li>
          <li>分类5</li>
          <li>分类6</li>
          <li>分类7</li>
          <li>分类8</li>
          <li>分类9</li>
          <li>分类10</li>
          <li>分类11</li>
          <li>分类12</li> -->
      </ul>
      <div class="goods-box">
        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><div class="goods-list">
              <h5 id="<?php echo ($val['id']); ?>"><?php echo ($val['name']); ?><!-- <a href="javascript:;">查看更多></a> --></h5>
              <div class="goods-item clearfix">
                <?php if(is_array($val["cate"])): $i = 0; $__LIST__ = $val["cate"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Index/classification',['gcid'=>$v['id']]);?>" id="<?php echo ($v['id']); ?>"><?php echo ($v['name']); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
              </div>
          </div><?php endforeach; endif; else: echo "" ;endif; ?>
        <!--   <div class="goods-list">
              <h5>分类1<a href="javascript:;">查看更多></a></h5>
              <div class="goods-item clearfix">
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
              </div>
          </div>
          <div class="goods-list">
              <h5>分类2</h5>
              <div class="goods-item clearfix">
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
              </div>
          </div>
          <div class="goods-list">
              <h5>分类3</h5>
              <div class="goods-item clearfix">
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
              </div>
          </div>
          <div class="goods-list">
              <h5>分类4</h5>
              <div class="goods-item clearfix">
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
              </div>
          </div>
          <div class="goods-list">
              <h5>分类5</h5>
              <div class="goods-item clearfix">
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
              </div>
          </div>
          <div class="goods-list">
              <h5>分类6</h5>
              <div class="goods-item clearfix">
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
              </div>
          </div>
          <div class="goods-list">
              <h5>分类7</h5>
              <div class="goods-item clearfix">
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
              </div>
          </div>
          <div class="goods-list">
              <h5>分类8</h5>
              <div class="goods-item clearfix">
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
              </div>
          </div>
          <div class="goods-list">
              <h5>分类9</h5>
              <div class="goods-item clearfix">
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
              </div>
          </div>
          <div class="goods-list">
              <h5>分类10</h5>
              <div class="goods-item clearfix">
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
              </div>
          </div>
          <div class="goods-list">
              <h5>分类11</h5>
              <div class="goods-item clearfix">
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
              </div>
          </div>
          <div class="goods-list">
              <h5>分类12</h5>
              <div class="goods-item clearfix">
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
                  <a href=""  target="_blank">商品</a>
              </div>
          </div> -->
      </div>
    </div>
  </div>

  <!-- 底部footer -->
</div>
<!-- <script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script> -->
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>
<script type="text/javascript" src="/Public/js/function.js"></script>



<script type="text/javascript">

(function () {
    var click_status='left';
    $(".goods-class li").click(function () {/*点击左边分类菜单跳转*/
        var index=$(this).index(".goods-class li");
        $(".goods-class li").removeClass('active').eq(index).addClass('active');
        GoodsBoxMove(index);
        click_status="left";
    });
    function GoodsBoxMove(index){/*实现跳转*/
        click_status="right";

        var goods_top=$(".goods-list").eq(index).position().top,sear=$(".sear").outerHeight();
        $('html,body').animate({scrollTop:(goods_top-sear)},200);
    }
    /*当左侧商品滚动当前分类时，左侧菜单亦随之变化*/
    $(window).scroll(function () {
        var win_scroltop=$(window).scrollTop(),$goods=$(".goods-list"),goods_top=null;
        for(var i=0;i<$goods.length;i++){
          console.log($(".goods-box").offset().top);
            goods_top=$goods.eq(i).position().top - $(".sear").height();
            if(win_scroltop<=goods_top){
                GoodsClassMove(i);
                break;
            }
        }
    });
    function GoodsClassMove(index) {/*左侧菜单随之变化*/
        $(".goods-class li").removeClass('active').eq(index).addClass('active');
        $(".goods-class").scrollTop($(".goods-class li").eq(index).position().top);
    }
})();



</script>
</body>
</html>