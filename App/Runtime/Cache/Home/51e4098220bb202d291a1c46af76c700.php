<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta name="baidu-site-verification" content="brSKk1xvoHM7I577">
<meta name="description" content=""/>
<meta name="keywords" content=""/>
<title>店家认证</title>
<link rel="stylesheet" type="text/css" href="/Public/css/style.css">

</head>
<body>
<div class="warp">
	<div class="auth">
		<h3><img src="/Public/images/auth.png">
			<?php if(($data["state"]) == "0"): ?>审核中<?php endif; ?>
			<?php if(($data["state"]) == "1"): ?>认证成功<?php endif; ?>
			<?php if(($data["state"]) == "2"): ?>认证失败<?php endif; ?>
		</h3>
		<table cellspacing="0" cellpadding="0" border="0" class="list">
			<tr>
				<td class="bt">商家名称</td><td class="right"><?php echo ($data["shopname"]); ?></td>
			</tr>
			<tr>
				<td class="bt">法人姓名</td><td class="right"><?php echo ($data["realname"]); ?></td>
			</tr>
			<tr>
				<td class="bt">执照号码</td><td class="right"><?php echo ($data["shopsn"]); ?></td>
			</tr>
      <tr>
        <td class="bt" valign="top" style="line-height:35px;">营业执照</td><td class="right">
        <?php if(is_array($data["imgurl"])): $i = 0; $__LIST__ = $data["imgurl"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><img src="<?php echo ($val); ?>"><?php endforeach; endif; else: echo "" ;endif; ?>
    	</td>   <!-- /Public/images/moren.png -->
      </tr>  
		</table>
		
		<div class="auth_tj">
		<a <?php if(($data["state"]) == "2"): ?>href="<?php echo U('Group/authentication');?>"<?php else: ?>href="javascript:;"<?php endif; ?>>
			<?php if(($data["state"]) == "0"): ?>审核中<?php endif; ?>
			<?php if(($data["state"]) == "1"): ?>认证成功<?php endif; ?>
			<?php if(($data["state"]) == "2"): ?>重新审核<?php endif; ?>
		</a></div>
	</div>
</div>

</body>
</html>