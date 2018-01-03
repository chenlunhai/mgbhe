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
<link href="/Public/admin/css/css.css" rel="stylesheet" type="text/css" />
<title>后台系统登陆</title>

</head>
<body>
  <div class="box_logo"><img src="/Public/admin/images/m_logo.png"></div>
  <div class="box_left">
    <div class="leftboxtop"></div>
    <div class="leftboxcn">
      <h3><span>供应商登陆</span>User Login</h3>
      <ul>
        <li>
          <label class="zf"></label>
          <input type="text" placeholder="手机号" class="s-input" name="mobile">
        </li>
        <li class="en">
          <label class="mm"></label>
          <input type="text" placeholder="验证码" class="s-input" name="verify"><a href="javascript:;" id="mes" onClick="check_mobile()">获取验证码</a>
        </li>
      </ul>
      <div class="loginBtnBox">
        <input type="button" value="登 录" onclick="verSubmit();" class="loginBtn">
      </div>
    </div>
    <div class="leftboxbot"></div>
    <div class="bottombox">

    </div>
  </div>
<!-- </div> -->

<script type="text/javascript" src="/Public/admin/js/jquery.js"></script> 
<script type="text/javascript" src="/Public/admin/js/H-ui.js"></script> 
<script type="text/javascript" src="/Public/admin/js/layer/layer.js"></script> 
<script type="text/javascript" src="/Public/admin/js/H-ui.admin.js"></script> 
<script>
function check_mobile()
{
  var mobile  = $.trim($('input[name=mobile]').val());
  if(check_mobile_format(mobile) != 1) return;

  var ajaxData = {
    url:'<?php echo U("Login/check_mobile");?>',type:'post',dataType:'json',data:{mobile:mobile},
    beforeSend:function(data){layer.load(2)},
    success:function(data){
      layer.closeAll();
      if(data.status == 1){
        getVerify();
        return;
      }
      layer.msg(data.msg);
    }
  };
  $.ajax(ajaxData);
}
var status = 1;
var i = 60;
var state = true;
function getVerify(){
  if(i<1){
    $('#mes').attr('onclick','check_mobile()').html('获取验证码');
    i=60;
    state = true;
    return;
  }
  if(state) if(!senPhone()) return;
  state = false;
  $('#mes').attr('onclick','').html(i--);
  setTimeout('getVerify()',1000);
}
function senPhone(){
  var mobile  = $('input[name=mobile]').val();
  if(check_mobile_format(mobile) != 1) return;

  var ajaxData = {
    url:'<?php echo U("Login/send_sms");?>',type:'post',dataType:'json',data:{mobile:mobile},
    beforeSend:function(){layer.load(2)},
    success:function(data){
      layer.closeAll();
      layer.msg(data.msg);
    }
  };
  $.ajax(ajaxData);
  return true;
}
function verSubmit(){
    var mobile  = $.trim($('input[name=mobile]').val());
    if(check_mobile_format(mobile) != 1) return;

    var verify = $.trim($('input[name=verify]').val());
    if(verify.length !=4 ){
      layer.msg('验证码格式不正确');
      return;
    }

    var ajaxData = {
      url:'<?php echo U("Login/index");?>',type:'post',dataType:'json',data:{mobile:mobile,verify:verify},
      beforeSend:function(data){layer.load()},
      success:function(data){
        layer.closeAll();
        layer.msg(data.msg);
        if(data.status == 1)  setTimeout('location.href="<?php echo U("Index/index");?>"',1000);
      }
    };
    $.ajax(ajaxData);
}
function check_mobile_format(mobile){
  reg = /^1[3|4|5|8|7][0-9]\d{8}$/;
  if(!reg.test(mobile)){
    layer.msg('手机号码格式不正确');
    return 0;
  }
  return 1;
}
</script>
</body>
</html>