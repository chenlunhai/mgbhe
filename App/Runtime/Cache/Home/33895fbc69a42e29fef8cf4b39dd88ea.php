<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta name="baidu-site-verification" content="brSKk1xvoHM7I577">
<meta name="description" content=""/>
<meta name="keywords" content=""/>
<title>验证</title>
<link href="/Public/css/login.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="login">
	<div class="login_top"><img src="/Public/images/logo.png"></div>
	<div class="login_con">
		<ul>
	      <li><input type="text" class="y_input" placeholder="请输入手机号" name="mobile"><a href="javascript:;" id="mes" onClick="checkGetVerify()">获取验证码</a></li>
	      <li><input type="text" class="s_input" placeholder="请输入验证码" name="verify"></li>
	    </ul>
    </div>
    <div class="login_dl"><a data-toggle="modal" href="#login-modal" onClick="subInfo()">下一步</a></div>
</div>
<div class="modal" id="login-modal">
  <h3>提示</h3>
  <div class="mo_title">您已经是数钜宝用户，可以立即登录！！</div>
  <p><a href="login.html">立即登录</a></p>
</div>

<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>
<script type="text/javascript" src="/Public/js/function.js"></script>

<script type="text/javascript" src="/Public/js/modal.js"></script>
<script type="text/javascript">
$(document).ready(function(){

  $("a.forgot").click(function(){
    $("#login-modal").modal("hide");
    $("#forgetform").modal({show:!0})
  });
  
  $("#signup-modal").modal("hide");
  $("#forgetform").modal("hide");
  $("#login-modal").modal("hide");
  $("#activation-modal").modal("hide");
  $("#setpassword-modal").modal("hide");
  
});
</script>

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
    layer.msg('手机号码格式不正确', {icon: 2,shade: 0.5,time: 2000,closeBtn:1})
    return;
  }

  getVerify();

  /*//var state = 0;
  $.ajax({
    url:'<?php echo U("Login/checkPhone");?>',type:'post',dataType:'json',data:{mobile:mobile},
    beforeSend:function(data){layer.load(2)},
    success:function(data){
      layer.closeAll();
      if(data.status==1){
        layer.msg(data.msg, {icon: 2,shade: 0.5,time: 2000,closeBtn:1});
      }else{
        getVerify();
      }
    }
  })*/
}

function senPhone(){

  var mobile  = $('input[name=mobile]').val();
  if(!verifyPhone(mobile)){
    layer.msg('手机号码格式不正确', {
       icon: 2,
       shade: 0.5,
       time: 2000
     });
    return;
  }

  $.ajax({
    url:'<?php echo U("Login/sendMes");?>',
    type:'post',
    dataType:'json',
    data:{mobile:mobile,state:0},
    success:function(data){
      //alert(data.status);
    }
  })

  return true;
}

//下一步
function subInfo(){
    var mobile  = $.trim($('input[name=mobile]').val());
    var verify  = $.trim($('input[name=verify]').val());
    var icon = 2;
    if(!verifyPhone(mobile)){
      layer.msg('手机号码格式不正确', {
          icon: icon,
          shade: 0.5,
          time: 2000,
      })
      return;
    }

    if(verify.length!=4){
      if(verify.length==0) layer.msg('验证码不能为空', {icon: icon,shade: 0.5,time: 2000,closeBtn:1});
      else layer.msg('验证码格式输入有误', {icon: icon,shade: 0.5,time: 2000,closeBtn:1});
      return;
    }

    var ajaxData = {
      url:'<?php echo U("Login/verification");?>',type:'post',dataType:'json',data:{verify:verify,mobile:mobile},
      beforeSend:function(data){layer.load(2)},
      success:function(data){
        layer.closeAll();
        //alert(data.status);
        if(data.status == 1){
          layer.msg(data.msg, {icon: data.status,shade: 0.5,time: 2000});
          setTimeout(location.replace("<?php echo ($reurl); ?>"),2000);   //2s后跳转到gourl
          return;
        }
        layer.msg(data.msg, {icon: data.status,shade: 0.5,time: 2000})
      }
    }
    $.ajax(ajaxData);
  }

 </script>
</body>
</html>