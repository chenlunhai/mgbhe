<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta http-equiv="Content-Security-Policy" content="script-src 'self'">
<meta name="baidu-site-verification" content="brSKk1xvoHM7I577">
<meta name="description" content=""/>
<meta name="keywords" content=""/>
<title>会员中心</title>
<link rel="stylesheet" type="text/css" href="/Public/css/style.css?=2">
<link href="/Public/css/hengshu.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/Public/js/jquery.SuperSlide.2.1.1.js"></script>
<script type="text/javascript" src="/Public/js/jquery-1.10.2.min.js"></script>

<link rel="stylesheet" type="text/css" href="/Public/css/group.css">
</head>
<body>
<div class="warp">
	<div class="per_top">
		<div class="per_t_img"><img src="/Public/images/not_bj.jpg"></div>
		<div class="per_t_c">
			<div class="p_top_l">
				<p><img src="/Public/images/logo.png"></p>
			</div>
			<div class="p_top_r">
				<p><?php echo ($user["realname"]); ?></p>
				<p><?php echo ($user["mobile"]); ?></p>
				<!-- <p>身份：省代XX</p> -->
				<!-- <p class="ye"><span>余额</span><?php echo ($user["estate_info"]["balance"]); ?></p> -->
			</div>
		</div>
		<div class="clearboth"></div>
	</div>
	<div class="per_con">
		<h3><a href="<?php echo U('Group/authentication_center');?>"><p><img src="/Public/images/not_07.png">认证中心<span>去认证<em></em></span></p></a></h3>
		<ul>
			<li><a href="<?php echo U('User/my_wallet');?>"><img src="/Public/images/not_03.png">我的钱包</a></li>
			<li><a  <?php if($user['is_shoper'] == 0): ?>href="<?php echo ($authentication); ?>"<?php else: ?>href="<?php echo U('User/shop');?>"<?php endif; ?>  ><img src="/Public/images/not_07.png"> <?php if($user['is_shoper'] == 0): ?>店家认证<?php else: ?>我的店铺<?php endif; ?> </a></li>
			<li><a href="<?php echo U('User/show_cds_profit');?>"><img src="/Public/images/not_05.png">消费报销</a></li>
			<li><a href="<?php echo U('User/set_up');?>"><img src="/Public/images/not_04.png">个人信息</a></li>
			<li><a href="<?php echo U('User/show_share_img');?>"><img src="/Public/images/not_27.png">邀请好友</a></li>
			<!-- <li><a href="<?php echo U('User/shopping');?>"><img src="/Public/images/not_21.png">购物记录</a></li> -->
		</ul>
		
	</div>
	<div class="per_adve"><a  <?php if($user['is_shoper'] == 0): ?>href="<?php echo ($authentication); ?>"<?php else: ?>href="<?php echo U('User/shop');?>"<?php endif; ?> ><img src="/Public/images/not_09.png"></a></div>
	<div class="copyright">服务热线：400-885-0271<br>湖南麦光宝盒科技发展有限公司&nbsp;湘ICP备17016834号-1</div>

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
</body>
</html>