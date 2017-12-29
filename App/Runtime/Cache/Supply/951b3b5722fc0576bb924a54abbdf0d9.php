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
<title>资讯列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 店主列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">	

	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="r">共有数据：<strong><?php if(empty($count)): ?>0<?php else: echo ($count); endif; ?></strong> 条</span> </div>

	<div class="mt-20">
	<div class="text-c" style="margin-top:10px;margin-bottom:10px;">
	    <table cellpadding="3" cellspacing="0" class="table_98">
			 <form  method="post" id="form1">
			  <tbody>
			  <tr>
				<td>
			  	用户ID：<input type="text" name="uid" value="<?php echo ($assign['uid']); ?>" class="btn">
				开业时间：<input type="text" id="open_stime" style="width:100px" class="input-text" name="open_stime" size="20" value="<?php echo ($assign['open_stime']); ?>">
				- <input type="text" id="open_dtime" style="width:100px" class="input-text" name="open_dtime" size="10" value="<?php echo ($assign['open_dtime']); ?>">

				加入时间：<input type="text" id="stime" style="width:100px" class="input-text" name="stime" size="20" value="<?php echo ($assign['stime']); ?>">
				- <input type="text" id="dtime" style="width:100px" class="input-text" name="dtime" size="10" value="<?php echo ($assign['dtime']); ?>">

				状态：<select name="state" class="s_select">
					<option value="" >请选择</option>
					<option value="0" <?php if($assign['state'] == '0'): ?>selected<?php endif; ?>>正常</option>
					<option value="1" <?php if($assign['state'] == 1): ?>selected<?php endif; ?>>故障报修</option>
				</select>
				
				<input name="submit" class="btn btn-success" type="submit" id="submit" value="查找" onclick="$('input[name=status]').val(0)">
				<input type="hidden" name="status" value="0">
				<input class="btn btn-success" type="submit" value="导出" onclick="subExport()"> 
				</td>
			  </tr>
		  	  </tbody>
		  	  </form>
		</table>
	</div>
		<table class="table table-border table-bordered table-bg table-hover table-sort">
			<thead>
				<tr class="text-c">
				 
					<th>所属用户id </th>
					<th>设备编号</th>
					<th>省-市-区-详细地址 </th>
					<th>店铺二维码</th>
					<th>开业时间</th>
					<th>加入时间</th>
					<th>状态</th>
					
					<th>操作</th>
					 
				</tr>
			</thead>
			<tbody>
			<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr class="text-c">
				<td><?php echo ($val['uid']); ?></td>
				<td><?php echo ($val["shop_sn"]); ?></td>
				<td><?php echo ($val["province"]); ?>-<?php echo ($val["city"]); ?>-<?php echo ($val["region"]); ?>-<?php echo ($val["address"]); ?></td>
				<td><?php echo ($val["qrcode"]); ?></td>
				<td><?php echo ($val["opentime"]); ?></td>
				<td><?php echo ($val["addtime"]); ?></td>
				<td><?php echo getShopRecordStatus($val['state']);?></td>
				<td><a style="text-decoration:none" class="ml-5" onclick="kuaidi('查看用户资料','<?php echo U('Shop/shop_register_show',array('id'=>$val['uid']));?>','900','300')" href="javascript:;" title="查看用户资料">查看</a></td>
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
//alert("<?php echo ($assign['state']); ?>");
$(function(){
	laydate({
	   elem: '#stime'
	})
	laydate({
	   elem: '#dtime'
	})

	laydate({
	   elem: '#open_stime'
	})
	laydate({
	   elem: '#open_dtime'
	})
})

function subExport(){
	$('input[name=status]').val(1);
}

	/*$(function(){
		$('.table-sort').dataTable();
	})*/
</script>
<script type="text/javascript">
function kuaidi(title,url,w,h){
	layer_show(title,url,w,h);
}
</script>
</body>
</html>