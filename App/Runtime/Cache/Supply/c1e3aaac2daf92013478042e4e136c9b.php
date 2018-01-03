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
<script src="/Public/admin/js/laydate/laydate.js"></script>
<title>资讯列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 订单列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">	
	<div class="cl pd-5 bg-1 bk-gray mt-20">   <span class="r">共有数据：<strong><?php echo ($count); ?></strong> 条</span> </div>
	<div class="text-c" style="margin-top:10px;">
	    <table cellpadding="3" cellspacing="0" class="table_98">
			 <form  method="post" id="form1">
			  <tbody>
			  <tr>
				<td>
				订单状态：<select name="trade" id="">
					<option value="0">请选择</option>
					<option value="1" <?php if($assign['trade'] == 1): ?>selected<?php endif; ?>>已付款</option>
					<option value="3" <?php if($assign['trade'] == 3): ?>selected<?php endif; ?>>已发货</option>
				</select>
				订单编号：<input type="text" class="input-text" name="order_sn" style="width:150px" value="<?php echo ($assign['order_sn']); ?>">
				时间范围：<input type="text" id="stime" style="width:100px" class="input-text" name="stime" size="20" value="<?php echo ($assign['stime']); ?>">
				-<input type="text" id="dtime" style="width:100px" class="input-text" name="dtime" size="10" value="<?php echo ($assign['dtime']); ?>">
				<input name="submit" class="btn btn-success" type="submit" id="submit" value="查找">
				<input type="hidden" name="state" value="0">
				<input class="btn btn-success" type="submit" value="导出" onclick="subExport()">
				</td>
			  </tr>
		  	  </tbody>
		  	  </form>
		</table>
	</div>
	<div class="mt-20">
		<table class="table table-border table-bordered table-bg table-hover table-sort">
			<thead>
				<tr class="text-c">
					<th style="max-width:130px;">订单编号</th>
					<th style="width:80px;">下单人手机号</th>
					<th style="width:80px;">下单人姓名</th>
					<th>订单信息</th>
					<th style="width:55px">订单总价</th>
					 
					<th style="width:100px; max-width:15%">收货地址</th>
					<th style="width:40px;">收货人</th>
					<th style="width:80px;">收货人电话</th>
					<th>下单时间</th>
					<th>确定收货时间</th>
					<th style="width:36px;">操作</th>
				</tr>
			</thead>
			<tbody>
			<?php if(is_array($data)): $key = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($key % 2 );++$key;?><tr class="text-c">
				<td><?php echo ($val["osn"]); ?></td>
				<td><?php echo ($val["mobile"]); ?></td>
				<td><?php echo ($val["realname"]); ?></td>
				<td style=" padding:0">
				<table>
					 
					<tr>
						<td style="padding:0; border-left:none">商品名称</td>
						<td style="padding:0; width:40px;">商品数量</td>
						<td style="padding:0; width:60px;">商品单价</td>
					</tr>
			 
					<tr>
						<td style="width:200px; padding:0;border-left:none"><?php echo ($val["gname"]); ?></td>
						 
						<td style="padding:0"><?php echo ($val["gteam_price"]); ?></td>
						<td style="padding:0"><?php echo ($val["pay_num"]); ?></td>
					</tr>
					 
				</table>
				</td>
				<td><?php echo ($val["total_price"]); ?></td>
				 
				<td><?php echo ($val["address"]); ?></td>
				<td><?php echo ($val["realname"]); ?></td>
				<td><?php echo ($val["mobile"]); ?></td>
				<td><?php echo ($val['addtime']); ?></td>
				<td><?php echo ($val['get_goods_time']); ?></td>
				<td>
				<?php if($val['trade'] == 1): ?><a href="javascript:;" onclick="upOrderDelivery(<?php echo ($val["id"]); ?>)"><i class="Hui-iconfont">&#xe6df;</i>发货</a>
				<?php else: ?> 
				<?php echo getTradeStatus($val['trade']); endif; ?>
				</td>

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
<script type="text/javascript" src="/Public/admin/js/jquery.ui.js"></script>
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
	$('input[name=state]').val(1);
}
function upOrderDelivery(id){
layer.prompt({title:'请输入快递编号'},function(val, index){
   var ajaxData = {
   	url:'<?php echo U("Order/up_trade");?>',type:'post',dataType:'json',data:{id:id,delivery_sn:val},
   	beforeSend:function(data){ layer.load(2)},
   	success:function(data){
   		layer.closeAll();
   		if(data.status==1){
   			setTimeout('location.reload()',2000);
   		}
   		layer.msg(data.msg, {
		   icon: data.status,
		   shade: 0.5,
		   time: 2000
		});
   	}
   };
   $.ajax(ajaxData);
});
}
</script>
</body>
</html>