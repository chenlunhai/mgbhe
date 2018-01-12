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
<title>供货商货款记录</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span>供货商货款记录 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">	
	<div class="cl pd-5 bg-1 bk-gray mt-20">    <span class="r">共有数据：<strong><?php echo ($count); ?></strong> 条</span> </div>
	<div class="mt-20">
	<div class="text-c" style="margin-top:10px;">
	    <table cellpadding="3" cellspacing="0" class="table_98">
			 <form  method="post" id="form1">
			  <tbody>
			  <tr>
				<td>
				订单号：<input type="text" name="osn" value="<?php echo ($assign['osn']); ?>" style="width:250px" class="input-text">
				供货商：<input type="text" name="sname" value="<?php echo ($assign['sname']); ?>" style="width:100px" class="input-text">
                时间：<input type="text" id="stime" style="width:100px" class="input-text" name="stime" size="20" value="<?php echo ($assign['stime']); ?>">
                - <input type="text" id="dtime" style="width:100px" class="input-text" name="dtime" size="10" value="<?php echo ($assign['dtime']); ?>">
				<input name="submit" class="btn btn-success" type="submit" id="submit" value="查找">
				<!-- <input type="hidden" name="state" value="0">
                <input class="btn btn-success" type="submit" value="导出" onclick="subExport()"> -->
				</td>
			  </tr>
		  	  </tbody>
		  	  </form>
		</table>
	</div>
		<table class="table table-border table-bordered table-bg table-hover table-sort">
				<tr class="text-c">
					<th>时间</th>
					<th>订单号</th>
					<th>供货商</th>
					<th>金额</th>
					<th>交易费</th>
					<th>操作</th>
				</tr>
			<tbody>
			<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr class="text-c" id="info<?php echo ($val["id"]); ?>">
				<td><?php echo ($val["addtime"]); ?></td>
				<td><?php echo ($val["osn"]); ?></td>
				<td><?php echo ($val["sname"]); ?></td>
				<td><?php echo ($val["money"]); ?></td>
				<td><?php echo ($val["fee"]); ?></td>
				<td></td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
		</table>
		<div id="page"><?php echo ($page); ?></div>
	</div>
</div>
<script type="text/javascript" src="/Public/admin/js/jquery.js"></script> 
<script type="text/javascript" src="/Public/admin/js/H-ui.js"></script> 
<script type="text/javascript" src="/Public/admin/js/layer/layer.js"></script> 
<script type="text/javascript" src="/Public/admin/js/H-ui.admin.js"></script> 
<script src="/Public/admin/js/laydate/laydate.js"></script>
<script type="text/javascript">
$(function(){
    laydate({
       elem: '#stime'
    })
    laydate({
       elem: '#dtime'
    })
})
function subExport(){
	$('input[name=state]').val(0);
}
function kuaidi(title,url,w,h){
	layer_show(title,url,w,h);
}
</script>
</body>

</html>