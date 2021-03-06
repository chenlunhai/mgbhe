<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta name="baidu-site-verification" content="brSKk1xvoHM7I577">
<meta name="description" content=""/>
<meta name="keywords" content=""/>
<title>登录</title>
<link href="/Public/css/login.css" rel="stylesheet" type="text/css">
</head>
<body style="background:#f0eff5">
<div class="login">
	<div class="login_top"><img src="/Public/images/logo.png"></div>
	<div class="login_con">
		<ul>
	      <li><label class="zf"></label><input type="text" placeholder="请输入手机号" class="s_input" name="mobile" value="<?php echo ($mobile); ?>"></li>
	      <li><label class="mm"></label><input type="password" placeholder="请输入密码" class="s_input" name="password"></li>
	    </ul>
    </div>
    <div class="login_dl"><a href="javascript:;" onClick="subInfo()">登录</a></div>
    <div class="login_w">
        <p class="password"><a href="javascript:;" name="forget">忘记密码？</a></p>
        <p class="reset"><a href="<?php echo U('Login/index');?>">去注册</a></p>
        <!-- <p class="reset"><a href="<?php echo U('Login/mobileLogin');?>">手机验证码登录</a></p> -->
        <div style="clear:both"></div>
    </div>
</div>

<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>
<script type="text/javascript" src="/Public/js/function.js"></script>
<script type="text/javascript" src="/Public/js/disable.js"></script>
<script type="text/javascript">
  $('iframe').css('display','none').css('z-index','-1').css('opacity','0');
</script>


<script type="text/javascript">
window.onload=function(){
  $("a[name=forget]").click(
    function(){
      var mobile = $.trim($("input[name=mobile]").val());  
      //是手机账号登录的情况
      if(verifyPhone(mobile)){location.href = "<?php echo U('Login/password',false,'');?>/mobile/"+mobile;}
      else{location.href = "<?php echo U('Login/password');?>";}
    }
  );
};

//登录
function  subInfo() {
  var mobile  = $.trim($('input[name=mobile]').val());
  var password = $.trim($('input[name=password]').val());
  var icon = 2;
  if(!verifyPhone(mobile)){
    layer.msg('用户名格式不正确', {
        icon: icon,
        shade: 0.5,
        time: layerAlertShowTime,
      })
      return;
  }
  
  if(password.length <6 ||password.length>16){
    layer.msg('密码长度须6-16之间', {
        icon: icon,
        shade: 0.5,
        time: layerAlertShowTime,
      })
      return;
  }


  var ajaxData = {
      url:'<?php echo U("Login/login");?>',type:'post',dataType:'json',data:{mobile:mobile,password:password},
      beforeSend:function(data){layer.load(2)},
      success:function(data){
        layer.closeAll();
        //alert(data.status);
        if(data.status == 1){
          layer.msg("登录成功！", {icon: data.status,shade: 0.5,time: layerAlertShowTime});
          setTimeout(location.replace("<?php echo ($reurl); ?>"),layerAlertShowTime);   //2s后跳转到gourl
          
          return;
        }
        layer.msg(data.msg, {icon: data.status,shade: 0.5,time: layerAlertShowTime})
      }
    }
    $.ajax(ajaxData);
}
</script>
</body>
</html>