<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta name="baidu-site-verification" content="brSKk1xvoHM7I577">
<meta name="description" content=""/>
<meta name="keywords" content=""/>
<title>申请开店</title>
<link href="/Public/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="warp">
	<div class="apply">
		<div class="app_top">
			<img src="/Public/images/not_01.png">成为店主，不用职守赚收益
		</div>
		<div class="app_con">
			<table cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td class="bt">姓名</td>
					<td><input type="text" class="a_input" placeholder="请输入姓名" name="realname" value="<?php echo ($user['realname']); ?>"></td>
				</tr>
				<tr>
					<td class="bt">电话</td>
					<td><input type="text" class="a_input" placeholder="请输入电话" name="mobile" value="<?php echo ($user['mobile']); ?>"></td>
				</tr>
				<tr>
					<td class="bt" valign="top" style=" line-height:40px;">开店地址</td>
					<td>
						<div class="info">
			              <div>
			                <select id="s_province" name="province"></select>
			                <select id="s_city" name="city" ></select>
			                <select class="s_county" id="s_county" name="region"></select>
			                <script class="resources library" src="/Public/js/area.js" type="text/javascript"></script>
			                <script>  region_init("s_province","s_city","s_county",'<?php echo ($user["region"]); ?>','<?php echo ($user["city"]); ?>','<?php echo ($user["region"]); ?>');  </script>  
			              </div>
			              <div id="show"></div>
			            </div>
			            <input type="text" class="a_input" placeholder="请输入联系地址" name="address" value="<?php echo ($user['address']); ?>">
					</td>
				</tr>
				<tr>
					<td class="bt" valign="top" style=" line-height:40px;">留言</td>
					<td><textarea class="textarea" placeholder="请输入留言内容" name="message"><?php echo ($user['message']); ?></textarea></td>
				</tr>
			</table>
			<div class="app_qd"><a href="javascript:;" onclick="verSubmit();">提交申请</a></div>
		</div>
	</div>
</div>

<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>
<script type="text/javascript" src="/Public/js/function.js"></script>



<script type="text/javascript">
  function  verSubmit() {
    var realname = $('input[name=realname]').val();
    var mobile = $('input[name=mobile]').val();
    var province = $('select[name=province]').val();
    var city = $('select[name=city]').val();
    var region = $('select[name=region]').val();
    var address = $('input[name=address]').val();
    var message = $('textarea[name=message]').val();

    
    var icon = 2;
    if(!realname){
      layer.msg('请输入姓名', {
        icon: icon,
        shade: 0.5,
        time: 2000
      })
      return;
    }
    if(!mobile){
      layer.msg('请输入联系电话', {
        icon: icon,
        shade: 0.5,
        time: 2000
      })
      return;
    }

    if(province=="省份"){
    	layer.msg('请选择省份', {
	        icon: icon,
	        shade: 0.5,
	        time: 2000
	    })
	    return;
    }

    if(city=="地级市"){
    	layer.msg('请选择地级市', {
	        icon: icon,
	        shade: 0.5,
	        time: 2000
	    })
	    return;
    }

    if(region=="市、县级市"){
    	layer.msg('请选择市、县级市', {
	        icon: icon,
	        shade: 0.5,
	        time: 2000
	    })
	    return;
    }

    if(!address){
      layer.msg('请输入联系地址', {
        icon: icon,
        shade: 0.5,
        time: 2000
      })
      return;
    }

    var ajaxData = {
	    url:'<?php echo U("User/apply");?>',type:'post',dataType:'json',data:{realname:realname,mobile:mobile,province:province,city:city,region:region,address:address,message:message},
	    beforeSend:function(data){layer.load(2)},
	    success:function(data){
	      layer.closeAll();
	      //alert(data.status);
	      if(data.status == 1){
	        layer.msg(data.msg, {icon: data.status,shade: 0.5,time: 2000});
	        //setTimeout(location.replace("<?php echo U('User/index');?>"),2000);   //2s后跳转到gourl
	        return;
	      }
	      
	      //alert(data.msg);
	      layer.msg(data.msg, {icon: data.status,shade: 0.5,time: 2000});
	      
	    }
	}
	$.ajax(ajaxData);
  }
</script>
</body>
</html>