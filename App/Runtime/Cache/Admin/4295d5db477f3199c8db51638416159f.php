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
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 用户列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">	

	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="r">共有数据：<strong><?php if(empty($count)): ?>0<?php else: echo ($count); endif; ?></strong> 条</span> </div>

	<div class="mt-20">
	<div class="text-c" style="margin-top:10px;margin-bottom:10px;">
	    <table cellpadding="3" cellspacing="0" class="table_98">
			 <form  method="post" id="form1">
			  <tbody>
			  <tr>
				<td>
			  	用户姓名：<input type="text" name="realname" value="<?php echo ($assign['realname']); ?>" class="btn">
				手机号码：<input type="text" name="mobile" value="<?php echo ($assign['mobile']); ?>" class="btn">
				注册时间：<input type="text" id="stime" style="width:100px" class="input-text" name="stime" size="20" value="<?php echo ($assign['stime']); ?>">
				- <input type="text" id="dtime" style="width:100px" class="input-text" name="dtime" size="10" value="<?php echo ($assign['dtime']); ?>">

				<input name="submit" class="btn btn-success" type="submit" id="submit" value="查找" onclick="$('input[name=state]').val(0)">
				<input type="hidden" name="state" value="0">
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
				 
					
					<th>姓名</th>
					<th>电话</th>
					<th>省-市-区</th>
					<th>用户类型</th>
				 	<th>余额</th>
				 	<th>积分</th>
					<th>注册时间</th>
					<th>操作</th>
					 
				</tr>
			</thead>
			<tbody>
			<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr class="text-c">
			 
		
				<td><?php echo ($val["realname"]); ?></td>
				<td><?php echo ($val["mobile"]); ?></td>
				<td><?php echo ($val["province"]); ?>-<?php echo ($val["city"]); ?>-<?php echo ($val["region"]); ?></td>
				<td><?php echo getGrade($val['grade']);?></td>
				<td><?php echo ($val["balance"]); ?></td>
				<td><?php echo ($val["integral"]); ?></td>
				<td><?php echo ($val["addtime"]); ?></td>
				<td>
					<a style="text-decoration:none" class="ml-5" onclick="kuaidi('编辑用户资料','<?php echo U('User/up_user_detail',array('id'=>$val['id']));?>','800','450')" href="javascript:;" title="编辑用户资料">编辑</a>

					<?php if(($val['grade'] == 1) and ($val['supply_grade'] == 0)): ?><a href="javascript:;" onClick="set_supplier(<?php echo ($val["id"]); ?>)">设为供应商</a><?php endif; ?>
					<?php if($val['supply_grade'] == 1): ?><a href="javascript:;" onClick="set_supplier(<?php echo ($val["id"]); ?>, 1)">取消供应商</a><?php endif; ?>
					<a href="javascript:;" onClick="kuaidi('设为代理', '<?php echo U('User/set_agent',array('id'=>$val['id']));?>','800','450')">设为代理</a>
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
	$('input[name=state]').val(1);
}

function delUser(id){
	layer.confirm('确定删除该用户吗？', {
	  btn: ['确定','取消'] //可以无限个按钮
	  ,btn1: function(index, layero){
	  	var icon = 2;
	    $.ajax({
	    	url:'<?php echo U("User/delUser");?>',
	    	type:'post',
	    	dataType:'json',
	    	data:{id:id},
	    	success:function(data){
	    		if(data.status==1) icon = 1;
	    		layer.msg(data.msg, {
				   icon: icon,
				   shade: 0.5,
				   time: 2000
				});
				if(data.status==1) setTimeout('location.reload();',2000);
			}
		    	 
	    })
	  }
	});
}

function sub_shop(id){
	layer.confirm('确定该操作吗？', {icon: 3, title:'提示'}, function(index){
		var icon = 2;
		$.ajax({
	    	url:'<?php echo U("User/up_user_shop_status");?>',
	    	type:'post',
	    	dataType:'json',
	    	data:{id:id},
	    	beforeSend:function(data){layer.load(2)},
	    	success:function(data){
	    		layer.closeAll();
	    		layer.msg(data.msg, {icon: data.status,shade: 0.5,time: 2000});
				
			}
		    	 
	    })
	})
}

function set_supplier(id, unset){
    layer.confirm('确定该操作吗？', {icon: 3, title:'提示'}, function(index){
        var icon = 2;
        $.ajax({
            url:'<?php echo U("User/set_supplier");?>',
            type:'post',
            dataType:'json',
            data:{id:id, state:unset},
            beforeSend:function(data){layer.load(2)},
            success:function(data){
                layer.closeAll();
                if(data.status == 1) setTimeout('location.reload()',2000);
                layer.msg(data.msg, { icon: data.status, shade: 0.5, time: 2000 });
            }
        })
    })
}

function kuaidi(title,url,w,h){
	layer_show(title,url,w,h);
}
</script>
<script type="text/javascript">
	$(function(){
		$('.table-sort').dataTable();
	})
</script>
</body>
</html>