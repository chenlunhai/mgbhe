<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="lib/html5.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>
<script type="text/javascript" src="lib/PIE_IE678.js"></script>
<![endif]-->
<link href="/Public/admin/css/H-ui.min.css" rel="stylesheet" type="text/css" />

<link href="/Public/admin/css/style.css" rel="stylesheet" type="text/css" />
<link href="/Public/admin/css/iconfont.css" rel="stylesheet" type="text/css" />
<!--[if IE 6]>
<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="/Public/admin/css/icheck.css" />
<link rel="stylesheet" type="text/css" href="/Public/admin/css/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="/Public/admin/css/H-ui.admin.css" />
<TITLE>会员电子化管理系统</TITLE>
</head>
<body>
<header class="navbar-wrapper">
	<div class="navbar navbar-fixed-top">
		<div class="container-fluid cl"> <a class="logo navbar-logo f-l mr-10 hidden-xs" href="main.php">会员电子化管理系统</a>  <span class="logo navbar-slogan f-l mr-10 hidden-xs"></span> <a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
			<nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
				<ul class="cl">
					<li>管理员</li>
					<li class="dropDown dropDown_hover"> <a href="#" class="dropDown_A"><?php echo ($admin_info["adminname"]); ?> <i class="Hui-iconfont">&#xe6d5;</i></a>
						<ul class="dropDown-menu menu radius box-shadow">
						  <li><a href="<?php echo U('Login/logout');?>">安全退出</a></li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	</div>
</header>

<aside class="Hui-aside">
	<input runat="server" id="divScrollValue" type="hidden" value="" />
	<div class="menu_dropdown bk_2">
		 
		<dl id="menu-article">
			<dt><em class="m_cn"><img src="/Public/admin/images/x_15.png"></em> <strong>认证中心</strong><i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd style="display: block;">
				<ul>
                    <li><a _href="<?php echo U('Shop/member_certification_list');?>" data-title="实名认证" href="javascript:void(0)"><div class="img"><img src="/Public/admin/images/x_06.png"></div>消费者实名认证</a></li>
                    <li><a _href="<?php echo U('Shop/wrd_register_list');?>" data-title="无人店申请" href="javascript:void(0)"><div class="img"><img src="/Public/admin/images/x_02.png"></div>无人店申请</a></li>
                    <li><a _href="<?php echo U('Shop/shop_register_list');?>" data-title="店家认证列表" href="javascript:void(0)"><div class="img"><img src="/Public/admin/images/x_md.png"></div>店家认证列表</a></li>
                    <li><a _href="<?php echo U('Shop/supplier_register_list');?>" data-title="厂家认证列表" href="javascript:void(0)"><div class="img"><img src="/Public/admin/images/x_xt.png"></div>厂家认证列表</a></li>
				</ul>
			</dd>
		</dl>
		<dl id="menu-article">
			<dt><em class="m_cn"><img src="/Public/admin/images/x_md.png"></em> <strong>店家管理</strong><i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd style="display: block;">
				<ul>
                    <li><a _href="<?php echo U('Shop/shoplist');?>" data-title="店家列表" href="javascript:void(0)"><div class="img"><img src="/Public/admin/images/x_01.png"></div>店家列表</a></li>
				</ul>
			</dd>
		</dl>
		<dl id="menu-article">
			<dt><em class="m_cn"><img src="/Public/admin/images/x_yh.png"></em> <strong>用户管理</strong><i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd style="display: block;">
				<ul>
                    <li><a _href="<?php echo U('User/index');?>" data-title="用户列表" href="javascript:void(0)"><div class="img"><img src="/Public/admin/images/x_06.png"></div>用户列表</a></li>
                    <li><a _href="<?php echo U('User/withdrawals');?>" data-title="提现记录" href="javascript:void(0)"><div class="img"><img src="/Public/admin/images/x_05.png"></div>提现记录</a></li>
				</ul>
			</dd>
		</dl>
		<dl id="menu-article">
			<dt><em class="m_cn"><img src="/Public/admin/images/x_yh.png"></em> <strong>供货商管理</strong><i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd style="display: block;">
				<ul>
                    <li><a _href="<?php echo U('Supplier/index');?>" data-title="供货商列表" href="javascript:void(0)"><div class="img"><img src="/Public/admin/images/x_06.png"></div>供货商列表</a></li>
                    <li><a _href="<?php echo U('Supplier/order_list');?>" data-title="订单列表" href="javascript:void(0)"><div class="img"><img src="/Public/admin/images/x_04.png"></div>订单列表</a></li>
                    <li><a _href="<?php echo U('Supplier/revenues');?>" data-title="收支列表" href="javascript:void(0)"><div class="img"><img src="/Public/admin/images/x_12.png"></div>货款记录</a></li>
                    <li><a _href="<?php echo U('Supplier/withdrawals');?>" data-title="提现记录" href="javascript:void(0)"><div class="img"><img src="/Public/admin/images/x_05.png"></div>提现记录</a></li>
				</ul>
			</dd>
		</dl>
		<dl id="menu-article">
			<dt><em class="m_cn"><img src="/Public/admin/images/x_yh.png"></em> <strong>供货商商品管理</strong><i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd style="display: block;">
				<ul>
                    <li><a _href="<?php echo U('GoodsSupply/goods_list');?>" data-title="供货商商品列表" href="javascript:void(0)"><div class="img"><img src="/Public/admin/images/x_06.png"></div>供货商商品列表</a></li>
                    <li><a _href="<?php echo U('GoodsSupply/goods_status_list');?>" data-title="供货商商品审核" href="javascript:void(0)"><div class="img"><img src="/Public/admin/images/x_06.png"></div>供货商商品审核</a></li>
				</ul>
			</dd>
		</dl>
	</div>

</aside>

<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>
<section class="Hui-article-box">
	<div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
		<div class="Hui-tabNav-wp">
			<ul id="min_title_list" class="acrossTab cl">
				<li class="active"><span title="我的桌面" data-href="<?php echo U('Index/welcome');?>">我的桌面</span><em></em></li>
			</ul>
		</div>
		<div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a></div>
	</div>
	<div id="iframe_box" class="Hui-article">
		<div class="show_iframe">
			<div style="display:none" class="loading"></div>
			<iframe scrolling="yes" frameborder="0" src="<?php echo U('Index/welcome');?>"></iframe>
		</div>
	</div>
</section>
<script type="text/javascript" src="/Public/admin/js/jquery.js"></script> 
<script type="text/javascript" src="/Public/admin/js/H-ui.js"></script> 
<script type="text/javascript" src="/Public/admin/js/layer/layer.js"></script> 
<script type="text/javascript" src="/Public/admin/js/H-ui.admin.js"></script> 
<script type="text/javascript">
/*资讯-添加*/
function article_add(title,url){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}
/*图片-添加*/
function picture_add(title,url){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}
/*产品-添加*/
function product_add(title,url){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}
/*用户-添加*/
function member_add(title,url,w,h){
	layer_show(title,url,w,h);
}
</script> 
 
</body>
</html>