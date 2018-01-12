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
<title>资讯列表</title>
<style type="text/css">
table{ width: 100%; border-top:solid 1px #ccc; border-left: solid 1px #ccc; margin:10px auto;}
table tr td{ height: 30px; line-height: 30px; border-right: solid 1px #ccc; border-bottom:solid 1px #ccc;}
table tr td.bt{ font-size: 14px;color: #444; text-align: center; background: #f5f5f5;}
table tr td.cen{ font-size: 14px; color: #666; text-align: center;}
</style>
</head>
<body>

<article class="page-container">
	<form action="" target="nm_iframe" method="post" class="form form-horizontal" id="form-admin-add">
		<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="bt">申请用户id</td><td class="cen"><?php echo ($user["id"]); ?></td>
				<td class="bt">姓名</td><td class="cen"><?php echo ($user["realname"]); ?></td>
				<td class="bt">昵称</td><td class="cen"><?php echo ($user["nickname"]); ?></td>
			</tr>
			<tr>
				<td class="bt">手机号码</td><td class="cen"><?php echo ($user["mobile"]); ?></td>
				<td class="bt">注册时间</td><td class="cen"><?php echo ($user["addtime"]); ?></td>
				<td class="bt">省-市-区</td><td class="cen"><?php echo ($user["province"]); ?>-<?php echo ($user["city"]); ?>-<?php echo ($user["region"]); ?></td>
			</tr>
			<tr>
				<td class="bt">开户行-开户支行</td><td class="cen"><?php echo ($user["bank_user"]); ?>-<?php echo ($user["bank_address"]); ?></td>
				<td class="bt">开户卡号</td><td class="cen"><?php echo ($user["bank_card"]); ?></td>
				<td class="bt">开户姓名</td><td class="cen"><?php echo ($user["bank_name"]); ?></td>
			</tr>
			<tr>
				<td class="bt">身份证号码</td><td class="cen"><?php echo ($user["id_card"]); ?></td>
				<td class="bt"></td><td class="cen"></td>
				<td class="bt"></td><td class="cen"></td>
			</tr>
			<tr>
				<td class="bt">供应商名称</td><td class="cen"><?php echo ($supplier["shopname"]); ?></td>
				<td class="bt">法人姓名</td><td class="cen"><?php echo ($supplier["realname"]); ?></td>
				<td class="bt">供应商执照号</td><td class="cen"><?php echo ($supplier["shopsn"]); ?></td>
			</tr>
			<tr>
				<td class="bt">联系电话</td><td class="cen"><?php echo ($supplier["mobile"]); ?></td>
				<td class="bt">省-市-区</td><td class="cen"><?php echo ($user["province"]); ?>-<?php echo ($user["city"]); ?>-<?php echo ($user["region"]); ?></td>
				<td class="bt">详细地址</td><td class="cen"><?php echo ($supplier["address"]); ?></td>
			</tr>
			<tr>
				<td class="bt">营业执照</td>
				<td class="cen" colspan="5"><img src="<?php echo ($supplier["imgurl"]); ?>" /></td>
			</tr>
		</table>
		<input type="hidden" name="uid" value="<?php echo ($user["id"]); ?>">
		<iframe   name="nm_iframe" style="display:none;"></iframe>
	</form>
</article>
<script type="text/javascript" src="/Public/admin/js/jquery.js"></script> 
<script type="text/javascript" src="/Public/admin/js/H-ui.js"></script> 
<script type="text/javascript" src="/Public/admin/js/layer/layer.js"></script> 
<script type="text/javascript" src="/Public/admin/js/H-ui.admin.js"></script> 
<script type="text/javascript">
function info(data){
	layer.msg(data.msg, {
	   icon: data.status,
	   shade: 0.5,
	   time: 2000
	});
	$('#subbtn').val(data.msg);
	if(data.status==1){
		setTimeout('parent.layer.closeAll()',2000);
		setTimeout('parent.location.reload()',2000);
	}
}

function subData (obj) {
	$('#subbtn').val('正在处理...').attr('onclick','');
	$('form').submit();
}
</script>
<script type="text/javascript">
	$(function(){
		$('.table-sort').dataTable();
	})
</script>
</body>
</html>