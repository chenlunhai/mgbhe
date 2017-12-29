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
</head>
<body>

<article class="page-container">
	<form action="" target="nm_iframe" method="post" class="form form-horizontal" id="form-admin-add">
		<!-- <div class="row cl">
			<label class="form-label col-xs-2"><span class="c-red">*</span>会员头像：</label>
			<div class="formControls col-xs-4">
				 <img src="<?php echo ($user["user_logo"]); ?>" width="150" height="150">
			</div>
		</div> -->
		<div class="row cl">
			<label class="form-label col-xs-2"><span class="c-red">*</span>姓名：</label>
			<div class="formControls col-xs-4">
				<input type="text" class="input-text" name="realname" value="<?php echo ($user["realname"]); ?>">
			</div>
		</div>
		<!-- <div class="row cl">
			<label class="form-label col-xs-2"><span class="c-red">*</span>身份证：</label>
			<div class="formControls col-xs-4">
				<input type="text" class="input-text" name="id_card" value="<?php echo ($user["id_card"]); ?>">
			</div>
		</div> -->
		<div class="row cl">
			<label class="form-label col-xs-2"><span class="c-red">*</span>开户银行：</label>
			<div class="formControls col-xs-4">
				<select name="bank_user" class="s_select">
				  <option value="">请选择开户行</option>
				  <option value="中国招商银行" <?php if($user['bank_user'] == '中国招商银行'): ?>selected<?php endif; ?>>中国招商银行</option>
		          <option value="中国农业银行" <?php if($user['bank_user'] == '中国农业银行'): ?>selected<?php endif; ?>>中国农业银行</option>
		          <option value="中国建设银行" <?php if($user['bank_user'] == '中国建设银行'): ?>selected<?php endif; ?>>中国建设银行</option>
		          <option value="中国工商银行" <?php if($user['bank_user'] == '中国工商银行'): ?>selected<?php endif; ?>>中国工商银行</option>
				</select>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-2"><span class="c-red">*</span>开户支行：</label>
			<div class="formControls col-xs-4">
				<input type="text" class="input-text" name="bank_address" value="<?php echo ($user["bank_address"]); ?>">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-2"><span class="c-red">*</span>持卡人：</label>
			<div class="formControls col-xs-4">
				<input type="text" class="input-text" name="bank_name" value="<?php echo ($user["bank_name"]); ?>">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-2"><span class="c-red">*</span>银行卡号：</label>
			<div class="formControls col-xs-4">
				<input type="text" class="input-text" name="bank_card" value="<?php echo ($user["bank_card"]); ?>">
			</div>
		</div>
		<!-- <div class="row cl">
			<label class="form-label col-xs-2"><span class="c-red">*</span>性别：</label>
			<div class="formControls col-xs-4">
				<input type="text" class="input-text" name="sex" value="<?php echo ($user["sex"]); ?>">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-2"><span class="c-red">*</span>出生年月：</label>
			<div class="formControls col-xs-4">
				<input type="text" class="input-text" name="birthday" value="<?php echo ($user["birthday"]); ?>">
			</div>
		</div> -->
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<input class="btn btn-primary radius" type="button"  id="subbtn"value="&nbsp;&nbsp;编辑&nbsp;&nbsp;" onclick="subData()">
			</div>
		</div>
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