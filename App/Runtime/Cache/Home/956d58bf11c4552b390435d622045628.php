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
  <div class="r_details">
    <div class="rd_con">
        <ul>
            <li>
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

    <div class="ils_top">
    	<h3>拼团剩余<span><?php echo ($data["gnum"]-$data["gpay_num"]); ?></span>件</h3>
    	<div class="it_con"><em style="width:50%;"></em></div>
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
    		<li class="left"><a href="javascript:;">快邀请好友参团吧</a></li>
    		<li class="right"><a href="<?php echo U('Index/index');?>">
    			<div class="img"><img src="/Public/images/p_foot11.png"></div>
    			<p>拼采廉</p>
    		</a></li>
    	</ul>
    </div>
  </div>
</div>


<!-- <script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/layer.js"></script> -->

</body>
</html>