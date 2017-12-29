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
<link href="/Public/admin/css/H-ui.login.css" rel="stylesheet" type="text/css" />
<title>微营销后台系统登陆</title>

</head>
<body>
<div class="header"></div>
<div class="loginWraper">
  <div id="loginform" class="loginBox">

    <form name="Login" class="form form-horizontal"  method="post" onSubmit="return CheckForm();">
      <div class="row cl">
        <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
        <div class="formControls col-xs-8">
         
          
          <input type="text" name="adminname" id="item1" placeholder="账户" class="input-text size-L" autocomplete="off" >
        </div>
      </div>
      <div class="row cl">
        <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
        <div class="formControls col-xs-8">
          <input type="password" name="password" id="item2" placeholder="密码"  value="" class="input-text size-L" autocomplete="off">
        </div>
      </div>
       
      <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
      </div>
      </div>
      <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
         
        </div>
      </div>
      <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
          <input name="" type="submit" class="btn btn-success radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
          <input name="" type="reset" class="btn btn-default radius size-L" value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">

        </div>
      </div>
    </form>
  </div>
</div>
<div class="footer">Copyright  微营销管理系统 v2.0</div>
<script type="text/javascript" src="/Public/admin/js/jquery.js"></script> 
<script type="text/javascript" src="/Public/admin/js/H-ui.js"></script> 
<script type="text/javascript" src="/Public/admin/js/layer/layer.js"></script> 
<script type="text/javascript" src="/Public/admin/js/H-ui.admin.js"></script> 
<script language=javascript>
function CheckForm()
{
  if(document.Login.adminname.value == "")
  {
    alert("请输入用户名！");
    document.Login.adminname.focus();
    return false;
  }
  if(document.Login.password.value == "")
  {
    alert("请输入密码！");
    document.Login.password.focus();
    return false;
  } 
  $.ajax({
    url:'<?php echo U("Login/index");?>',
    type:'post',
    dataType:'json',
    data:{adminname:document.Login.adminname.value,password:document.Login.password.value},
    success:function(data){
      if(data.status==1){
        location.href="<?php echo U('Index/index');?>";
        return;
      }
      alert(data.msg);
    }

  })
  return false;
}
//-->
</script>
</body>
</html>