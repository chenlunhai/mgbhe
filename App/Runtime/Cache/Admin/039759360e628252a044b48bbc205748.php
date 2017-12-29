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
				<td class="bt">部门/店铺</td><td class="cen"></td>
				<td class="bt">姓名</td><td class="cen"><?php echo ($user["name"]); ?></td>
				<td class="bt">职位</td><td class="cen"></td>
			</tr>
			<tr>
				<td class="bt">性别</td><td class="cen"><?php echo ($user["sex"]); ?></td>
				<td class="bt">民族</td><td class="cen"><?php echo ($user["familyname"]); ?></td>
				<td class="bt">婚姻状况</td><td class="cen"><?php echo ($user["marriages"]); ?></td>
			</tr>
			<tr>
				<td class="bt">电话</td><td class="cen"><?php echo ($user["mobile"]); ?></td>
				<td class="bt">紧急电话</td><td class="cen"><?php echo ($user["urgen_mobile"]); ?></td>
				<td class="bt">文化程度</td><td class="cen"><?php echo ($user["cultrue"]); ?></td>
			</tr>
			<tr>
				<td class="bt">工龄(年)</td><td class="cen"><?php echo ($user["year"]); ?></td>
				
				<!-- <td class="bt">工龄截止日期</td><td class="cen">2019-10-10</td> -->
				<td class="bt">聘用时间</td><td class="cen"><?php echo ($user["jointime"]); ?></td>
				<td class="bt">工服领用</td><td class="cen"><?php echo ($user["workclothing"]); ?></td>
			</tr>
			<tr>
				<td class="bt">年龄(岁)</td><td class="cen"></td>
				<td class="bt">出生日期</td><td class="cen"><?php echo ($user["birthday"]); ?></td>
				<td class="bt">身份在号码</td><td class="cen"><?php echo ($user["id_card"]); ?></td>
				
			</tr>
			<tr>
				<td class="bt">户籍所在地</td><td class="cen" colspan="5"><?php echo ($user["province"]); echo ($user["city"]); echo ($user["region"]); echo ($user["address"]); ?></td>
			</tr>
			<tr>
				<td class="bt">是否住宿</td><td class="cen"><?php echo ($user["stay"]); ?></td>
				<td class="bt">在职状态</td><td class="cen"></td>
				<td class="bt">底薪</td><td class="cen"><?php echo ($user["job_info"]["b_wage"]); ?></td>
			</tr>
			<tr>
				
				<td class="bt">工龄工资</td><td class="cen"><?php echo ($user["job_info"]["s_wage"]); ?></td>
				<td class="bt">全勤奖</td><td class="cen"><?php echo ($user["job_info"]["t_wage"]); ?></td>
				<td class="bt">话补</td><td class="cen"><?php echo ($user["job_info"]["m_wage"]); ?></td>
			</tr>
			<tr>
				<td class="bt">备注</td><td class="cen" colspan="5"><?php echo ($user["remark"]); ?></td>
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