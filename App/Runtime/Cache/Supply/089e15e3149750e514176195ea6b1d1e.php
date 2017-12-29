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
<style>
*{ padding:0; margin:0;}
body{ font-family: "微软雅黑"; padding: 0; margin:0;}
.tab{ margin-top: 20px; margin-bottom:50px;}
.tab tr td{ height: 30px; padding:3px 0; border-bottom:solid 1px #fff;}
.tab tr td.bt{ width: 130px; background: #f1f1f1; font-size: 14px; color: #333; text-align: right; padding-right: 10px;}
.tab tr td.bt span{ color: #f00}
.tab .s_input{height: 18px;    padding: 3px 5px;    border: 1px solid;    border-color: #adadad #e0e0e0 #e0e0e0 #adadad;    font: 12px/18px Arial, "宋体";    vertical-align: middle; outline: none; margin-right: 5px; width: 200px;}
.tab select.s_select{height: 27px;  width: 120px;      border: 1px solid;    border-color: #adadad #e0e0e0 #e0e0e0 #adadad;    font: 12px/18px Arial, "宋体";    vertical-align: middle; outline: none;}
.tab tr td.b-t span{ margin-right: 5px; font-size: 12px; color: #666; padding-bottom:5px; }
.tab tr td.b-t span .c-input{ width: 60px;height: 18px;    padding: 1px 5px;    border: 1px solid;    border-color: #adadad #e0e0e0 #e0e0e0 #adadad;    font: 12px/18px Arial, "宋体";    vertical-align: middle; outline: none; margin-left: 2px;}
.tab tr td.b-t span .c-select{height: 27px;  width: 100px;      border: 1px solid;    border-color: #adadad #e0e0e0 #e0e0e0 #adadad;    font: 12px/18px Arial, "宋体";    vertical-align: middle; outline: none;}
.tab .j_class tr th{ font-size: 14px; color: #666; font-weight: none;padding-right: 5px; text-align: center;}
.tab .j_class tr td .j_input{width: 90px;height: 18px;    padding: 1px 3px;    border: 1px solid;    border-color: #adadad #e0e0e0 #e0e0e0 #adadad;    font: 12px/18px Arial, "宋体";    vertical-align: middle; outline: none; margin-left: 2px;}
.tab .j_class tr td .j_button{height: 22px;  width: 60px;     font: 12px/18px Arial, "宋体";    vertical-align: middle; outline: none;cursor: pointer; margin:0 2px;}
.tab .j_class tr td .file{ border:solid 1px #ccc; font-size: 14px; color: #555; cursor: pointer; width: 150px;}
.tab .j_class tr td .submit{height: 22px;  width: 40px;     font: 12px/18px Arial, "宋体";    vertical-align: middle; outline: none;cursor: pointer; margin:0 2px;}
.tab tr td p{ font-size: 12px; color: #666; margin-bottom:0;}
.tab tr td label{ font-size: 14px; color: #444; margin-right: 10px; cursor: pointer;}
.tab tr td label .s_radio{ margin-left: 5px; cursor: pointer;}
.tab .a_input{height: 18px;    padding: 3px 5px;    border: 1px solid;    border-color: #adadad #e0e0e0 #e0e0e0 #adadad;    font: 12px/18px Arial, "宋体";    vertical-align: middle; outline: none; margin-right: 5px; width: 250px;}
.tab tr td .fil{ border:solid 1px #ccc; font-size: 14px; color: #555; cursor: pointer; width: 200px;}
.tab tr td .submit{height: 22px;  width: 60px;     font: 12px/18px Arial, "宋体";    vertical-align: middle; outline: none;cursor: pointer; margin:0 2px;}
.tab .s_button{ width: 100px; height: 25px; color: #444; cursor: pointer; font-family: "微软雅黑";}

label{ margin-right: 10px;}
label .img{ width: 18px; height: 18px; border:solid 1px #bfbfbf; border-radius: 100%; float: left; margin-right: 5px; }
.r-radio {	display: none;}
.r-radio + label {	-webkit-appearance: none; color: #333;	background-color: #fff;	/* box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05); */	padding:3px 5px;	border-radius: 4px;	display: inline-block;	position: relative;}
.r-radio:checked + label:after {	content: ' ';	width: 20px;	height: 20px;	border-radius: 100%;	position: absolute;	top: 3px;	background: url(/Public/admin/images/f_gou.png) no-repeat; filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod='scale')"; -moz-background-size: 100% 100%; background-size: 100% 100%;	/*  box-shadow: inset 0px 0px 10px rgba(0,0,0,0.3); 	text-shadow: 0px; */	left: 5px;	font-size: 32px;}
.r-radio:checked + label {	background-color: #fff;	color: #333;	/* box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05), inset 15px 10px -12px rgba(255,255,255,0.1), inset 0px 0px 10px rgba(0,0,0,0.1); */}
.r-radio + label:active, .r-radio:checked + label:active {	/* box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px 1px 3px rgba(0,0,0,0.1); */}
.r-radio:checked + label .img{ border-color: #163e71;}
.big-radio + label {	padding: 16px;}
.big-radio:checked + label:after {	width: 24px;	height: 24px;	left: 4px;	top: 4px;}

#in{ margin-bottom:10px;}

</style>

</head>

<body>


<form target="nm_iframe" method="post" class="form form-horizontal" id="form-admin-add" enctype="multipart/form-data">
<table class="tab" cellspacing="1" cellpadding="0">
			<tr>
				<td class="bt"><span>*</span>商品分类</td><td style="padding-left:10px;">
				<select name="gcid" id="" class="s_select">
					<?php if(is_array($cate)): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["id"]); ?>"><?php echo ($val["name"]); ?></option>
					<?php if(is_array($val["cate"])): $i = 0; $__LIST__ = $val["cate"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>">|-- <?php echo ($v["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
				</select>
				</td>
			</tr>
			<tr>
				<td class="bt"><span>*</span>商品名称</td><td style="padding-left:10px;"><input type="text" name="gname" class="input-text" value="<?php echo ($data["gname"]); ?>"></td>
			</tr>
			<tr>
				<td class="bt"><span>*</span>商品现价</td><td style="padding-left:10px;"><input type="text" name="gprice" class="input-text" value="<?php echo ($data["gprice"]); ?>"></td> 
			</tr>
			<tr>
				<td class="bt"><span>*</span>商品拼团价</td><td style="padding-left:10px;"><input type="text" name="gteam_price" class="input-text" value="<?php echo ($data["gteam_price"]); ?>"><span style="color:#f00"></span></td>
			</tr>	
			<tr>
				<td class="bt"><span>*</span>拼团对象</td><td style="padding-left:10px;">
					<div id="in">
					<!-- <input type="radio" id="radio-1-1"  name="guser_limit" value="2" class="r-radio" <?php if($data['guser_limit'] == '2'): ?>checked<?php endif; ?>/>
                	<label for="radio-1-1"><div class="img"></div>全部</label> -->
                	<input type="radio" id="radio-1-2" name="guser_limit" value="1" class="r-radio" <?php if($data['guser_limit'] == '1'): ?>checked<?php endif; ?>/>
                	<label for="radio-1-2"><div class="img"></div>店家</label>
                	<input type="radio" id="radio-1-3" name="guser_limit" value="0" class="r-radio" <?php if($data['guser_limit'] == '0'): ?>checked<?php endif; ?>/>
                	<label for="radio-1-3"><div class="img"></div>消费者</label>
                	</div>
                </td>
			</tr>
		 
			<tr>
				<td class="bt"><span>*</span>单次最低量</td><td style="padding-left:10px;"><input type="text" name="gpay_limit" class="input-text" value="<?php echo ($data["gpay_limit"]); ?>"></td> 
			</tr>
			<tr>
				<td class="bt"><span>*</span>满团数量</td><td style="padding-left:10px;"><input type="text" name="gnum" value="<?php echo ($data["gnum"]); ?>"class="input-text"></td> 
			</tr>
			<tr>
				<td class="bt"><span>*</span>支持城市</td>
				<td style="padding-left:10px;">
		<!-- 			<input type="checkbox" id="radio-2-1" class="r-radio" />
                	<label for="radio-2-1"><div class="img"></div>全部</label> -->
                	<?php if(is_array($area)): $key = 0; $__LIST__ = $area;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($key % 2 );++$key;?><div id="in">
                		<input type="checkbox" id="radio-<?php echo ($key); ?>"   class="r-radio" />
                		<label for="radio-<?php echo ($key); ?>"><div class="img"></div><?php echo ($key); ?></label>
	                	<?php if(is_array($val)): $k = 0; $__LIST__ = $val;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><input type="checkbox" id="radio-<?php echo ($i); ?>-<?php echo ($v["id"]); ?>" name="gcity[]" value="<?php echo ($v["name"]); ?>"  class="r-radio" <?php if(strstr($data['gcity'],$v['name'])): ?>checked<?php endif; ?>/>
	                	<label for="radio-<?php echo ($i); ?>-<?php echo ($v["id"]); ?>"><div class="img"></div><?php echo ($v["name"]); ?></label><?php endforeach; endif; else: echo "" ;endif; ?>
                	</div><?php endforeach; endif; else: echo "" ;endif; ?>
                </td>
			</tr>
			<!-- <tr>
				<td class="bt"><span>*</span>商品重量(g)</td><td style="padding-left:10px;"><input type="text" name="goods_weight" value="<?php echo ($data["goods_weight"]); ?>"class="input-text"><span style="color:#f00">单位为g</span></td>
			</tr>
			
					 	<tr>
				<td class="bt"><span>*</span>商品排序</td><td style="padding-left:10px;"><input type="text" name="sort" value="<?php echo ($data["sort"]); ?>"class="input-text"><span style="color:#f00">最大255，数值越小越靠前</span></td>
			</tr> -->
			<!-- <tr>
				<td class="bt"><span>*</span>发货方式</td>
				<td style="padding-left:10px;">
					<?php if($shop_type == 1): ?><label><input type="radio" name="delivery" value="2" class="s_radio"<?php if($data['delivery'] == 2): ?>checked<?php endif; ?>>全选</label>
				 	
					<label><input type="radio" name="delivery" value="0" class="s_radio"<?php if($data['delivery'] == 0): ?>checked<?php endif; ?>>门店自提</label><?php endif; ?>
					<label><input type="radio" name="delivery" value="1" class="s_radio"<?php if($data['delivery'] == 1): ?>checked<?php endif; ?>>速递到家</label>
				</td>
			</tr>
			<tr>
				<td class="bt"><span>*</span>邮费模板</td>
				<td style="padding-left:10px;">
					<label><input type="radio" name="postage_id" value="0" class="s_radio"<?php if($data['postage_id'] == 0): ?>checked<?php endif; ?>>包邮</label>
					<?php if(is_array($postage)): $i = 0; $__LIST__ = $postage;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><label><input type="radio" name="postage_id" value="<?php echo ($val["id"]); ?>" class="s_radio"<?php if($data['postage_id'] == $val['id']): ?>checked<?php endif; ?>><?php echo ($val["name"]); ?></label><?php endforeach; endif; else: echo "" ;endif; ?>
				</td>
			</tr> -->
			 
			<tr>
				<td class="bt"><span>*</span>商品图片</td>
				<td style="padding-left:10px;"> 
					<input name="gimg" id="gimg" type="file" class="fil"><?php if($data['gimg']): ?><img src="<?php echo ($data["gimg"]); ?>" width="50" height="50"><?php endif; ?>
					<span>图片大小不能超过100KB</span
				</td>
			</tr>
			<tr>
				<td class="bt"><span>*</span>商品内容</td>
				<td style="padding-left:10px;"> 
					 <textarea name="gcontent" id="content" cols="100%" rows="20"><?php echo ($data["gcontent"]); ?></textarea>
				</td>
			</tr>
			
			<tr>
				<td></td><td style="padding-left:10px;"><input type="button" class="btn btn-primary radius" value="添加保存" onClick="checkData()"></td>
			</tr>
		</table>
		<input type="hidden" name="id" value="<?php echo ($data["id"]); ?>">
		<iframe   name="nm_iframe" style="display:none;"></iframe>
</form>
<script type="text/javascript" src="/Public/admin/js/jquery.js"></script> 
<script type="text/javascript" src="/Public/admin/js/H-ui.js"></script> 
<script type="text/javascript" src="/Public/admin/js/layer/layer.js"></script> 
<script type="text/javascript" src="/Public/admin/js/H-ui.admin.js"></script> 
<script type="text/javascript" src="/Public/admin/editor/kindeditor.js"></script>
<script>var editor;KindEditor.ready(function(K) {editor = K.create('#content',{afterBlur: function(){this.sync();}}); });</script>
<script type="text/javascript">
function info(data){
layer.msg(data.msg, {
   icon: data.status,
   shade: 0.5,
   time: 2000
});
if(data.status==1){
	setTimeout('parent.layer.closeAll()',2000);
	setTimeout('parent.location.reload()',2000);
}
}
function checkData(){
 
	var gname   = $('input[name=gname]').val();
	var gprice  = $('input[name=gprice]').val();
	var gteam_price  = $('input[name=gteam_price]').val();
	var gpay_limit  = $('input[name=gpay_limit]').val();
	var gnum  = $('input[name=gnum]').val();
	 
	if(!gname){
		layer.msg('请输入商品名称', {icon: 2,shade: 0.5,time: 2000,closeBtn:1});
		return false;
	}
	if(!gprice){
		layer.msg('请输入商品现价', {icon: 2,shade: 0.5,time: 2000,closeBtn:1});
		return false;
	}
	if(!gteam_price){
		layer.msg('请输入商品拼团价', {icon: 2,shade: 0.5,time: 2000,closeBtn:1});
		return false;
	}
	if(!gpay_limit){
		layer.msg('请输入单次最低量', {icon: 2,shade: 0.5,time: 2000,closeBtn:1});
		return false;
	}
	if(!gnum){
		layer.msg('请输入满团数量', {icon: 2,shade: 0.5,time: 2000,closeBtn:1});
		return false;
	}
	$('form').submit();
}
function getShopCate (name,append_name) {
	var val = $('select[name='+name+']').val();
	if(val<1) return;
	var ajaxData = {
		url:"<?php echo U('Goods/getShopCate');?>",type:'post',dataType:'json',data:{id:val},
		beforeSend:function(data){ layer.load(2)},
		success:function(data) {
			layer.closeAll();
			var info = data.msg;
			var html = '';
			for(var key in info){
				html+='<option value="'+info[key].id+'">'+info[key].name+'</option>';
			}
			$('select[name='+append_name+']').html(html);
		}
	};
	$.ajax(ajaxData);
}
function delattr(id){
	var ajaxData = {
		url:'<?php echo U("Goods/del_goods_supply_attr");?>',type:'post',dataType:'json',data:{id:id,gid:'<?php echo ($data["id"]); ?>'},
		beforeSend:function(data){ layer.load(2) },
		success:function(data){
			layer.closeAll();
			if(data.status == 1){
				$('#attr_info'+id).remove();
			}
		}
	};
	layer.confirm('确定删除吗？', {icon: 3, title:'提示'}, function(index){
		layer.close(index);
		$.ajax(ajaxData);
	});
}
 
</script>
<script type="text/javascript">
//点击checkbook时情况
$("input[type='checkbox']").click(function(){
    var index = $(this).parent('#in').children("input[type='checkbox']").index(this);
    //当前点击“全选”checkbook
    if(index == 0){
        if($(this).is(":checked")){
            $(this).parent('#in').children("input[type='checkbox']").prop("checked",true);
        }else{
            $(this).parent('#in').children("input[type='checkbox']").prop("checked",false);
        }
    }else{
        var selectall_obj = $(this).parent('#in').children("input[type='checkbox']")[0];
        if(selectall_obj.checked){
        	selectall_obj.checked = "";
        }
    }
        
});
 
</script>
</body>
</html>