<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta name="baidu-site-verification" content="brSKk1xvoHM7I577">
<meta name="description" content=""/>
<meta name="keywords" content=""/>
<title>忘记密码</title>
<link href="/Public/css/login.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="login">
	<div class="login_top"><img src="/Public/images/logo.png"></div>
	<div class="login_con">
		<ul>
      <li><label class="zf"></label><input type="text" class="y_input" placeholder="请输入手机号" name="mobile" value="<?php echo ($mobile); ?>"></li>
      <li><label class="yz"></label><input type="text" class="s_input" placeholder="请输入验证码" name="verify"><a href="javascript:;" id="mes" onClick="checkGetVerify()">获取验证码</a></li>
      <li><label class="mm"></label><input type="password" placeholder="请输入密码" class="s_input" name="password"></li>
      <li><label class="mm"></label><input type="password" placeholder="请重复密码" class="s_input" name="repassword"></li>
    </ul>
  </div>
  <div class="login_dl"><a href="javascript:;" onClick="subInfo()">提交</a></div>
</div>


<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>
<script type="text/javascript" src="/Public/js/function.js"></script>



<script>
var status = 1;
var i = 60;
var state = true;
function getVerify(){
  if(i<1){
    $('#mes').attr('onclick','checkGetVerify()').html('获取验证码');
    i=60;
    state = true;
    return;
  }
  if(state) if(!senPhone()) return;
  state = false;
  $('#mes').attr('onclick','').html(i--);
  setTimeout('getVerify()',1000);
}


function checkGetVerify(){
  var mobile  = $('input[name=mobile]').val();
  if(!verifyPhone(mobile)){
    layer.msg('手机号码格式不正确', {icon: 2,shade: 0.5,time: layerAlertShowTime,closeBtn:1})
    return;
  }



  //var state = 0;
  $.ajax({
    url:'<?php echo U("Login/checkPhone");?>',type:'post',dataType:'json',data:{mobile:mobile},
    beforeSend:function(data){layer.load(2)},
    success:function(data){
      layer.closeAll();
      //alert(data.status);
      if(data.status==1){
        layer.msg(data.msg, {icon: 2,shade: 0.5,time: layerAlertShowTime,closeBtn:1});
      }else{
        getVerify();
      }
    }
  })
}

function senPhone(){
  var mobile  = $('input[name=mobile]').val();
  if(!verifyPhone(mobile)){
    layer.msg('手机号码格式不正确', {
       icon: 2,
       shade: 0.5,
       time: layerAlertShowTime
     });
    return;
  }

  $.ajax({
    url:'<?php echo U("Login/sendMes");?>',
    type:'post',
    dataType:'json',
    data:{mobile:mobile,state:1},
    success:function(data){
      //alert(data.status);
    }
  })

  return true;
}

//提交
function subInfo(){
    var verify  = $.trim($('input[name=verify]').val());
    var mobile  = $.trim($('input[name=mobile]').val());
    var password = $.trim($('input[name=password]').val());
    var repassword = $.trim($('input[name=repassword]').val());
    var icon = 2;
   
    if(!verifyPhone(mobile)){
      layer.msg('手机号码格式不正确', {
          icon: icon,
          shade: 0.5,
          time: layerAlertShowTime,
      })
      return;
    }

    if(verify.length!=4){
      if(verify.length==0) layer.msg('验证码不能为空', {icon: 2,shade: 0.5,time: layerAlertShowTime,closeBtn:1});
      else layer.msg('验证码格式输入有误', {icon: 2,shade: 0.5,time: layerAlertShowTime,closeBtn:1});
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

    if(password!=repassword){
      layer.msg('两次密码不一致', {
          icon: icon,
          shade: 0.5,
          time: layerAlertShowTime,
      })
      return;
    }

    var ajaxData = {
      url:'<?php echo U("Login/password");?>',type:'post',dataType:'json',data:{verify:verify,password:password,mobile:mobile},
      beforeSend:function(data){layer.load(2)},
      success:function(data){
        layer.closeAll();
        //alert(data.status);
        if(data.status == 1){
          layer.msg(data.msg, {icon: data.status,shade: 0.5,time: layerAlertShowTime});
          setTimeout(location.replace("<?php echo U('Login/login',false,'');?>/mobile/"+mobile),layerAlertShowTime);   //2s后跳转到gourl
          //location.href="<?php echo U('Login/login');?>";
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