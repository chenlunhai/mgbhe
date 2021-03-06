<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta name="baidu-site-verification" content="brSKk1xvoHM7I577">
<meta name="description" content=""/>
<meta name="keywords" content=""/>
<title>完善资料</title>
<link rel="stylesheet" type="text/css" href="/Public/css/login.css?v=1">
</head>
<body style="background:#f0eff5">
<div class="login">
	<div class="login_top" style="width:30%;"><img src="/Public/images/logo.png"></div>
	<div class="login_con">
		<ul>
	      <li class="yh_g"><label class="zf"></label><input type="text" class="s_input" value="<?php echo ($mobile); ?>" name="mobile" disabled></li>
        <li><label class="name"></label>
            <input type="text" placeholder="请输入真实姓名" class="s_input" name="realname">
          </li>
          <li><label class="mm"></label>
            <input type="password" placeholder="请输入密码" class="s_input" name="password">
          </li>
          <li><label class="mm"></label>
            <input type="password" placeholder="请再次输入密码" class="s_input" name="repassword">
          </li>
          
          <li><label class="add"></label>
              <div class="info">
                <div>
                  <select id="s_province" name="province"></select>
                  <select id="s_city" name="city" ></select>
                  <select class="s_county" id="s_county" name="region"></select>
                  <script class="resources library" src="/Public/js/area.js" type="text/javascript"></script>
                   <script>  region_init("s_province","s_city","s_county",'<?php echo ($puser["province"]); ?>','<?php echo ($puser["city"]); ?>','<?php echo ($puser["region"]); ?>');  </script>  
                </div>
                <div id="show"></div>
              </div>
          </li>
          <li class="yh yh_g"><label class="yh"></label>
            <input type="text" placeholder="" class="s_input" name="pmobile" value="<?php echo ($pmobile); ?>" disabled>
          </li>
	    </ul>
      <div class="user_list"><input type="checkbox" id="radio-1-1" name="agreement" value="1" class="regular-radio" checked="checked" /> 
        <label for="radio-1-1">
          <div class="img"></div>
        </label>
        <a href="<?php echo U('Login/user');?>">用户使用协议</a>
        <div style="clear: both"></div>
      </div>
    </div>
    <div class="login_dl"><a href="javascript:;" onClick="subInfo()">提交</a></div>
</div>

<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>
<script type="text/javascript" src="/Public/js/function.js"></script>
<script type="text/javascript" src="/Public/js/disable.js"></script>
<script type="text/javascript">
  $('iframe').css('display','none').css('z-index','-1').css('opacity','0');
</script>


<script>
function subInfo(){
    var realname = $.trim($('input[name=realname]').val());
    var password = $.trim($('input[name=password]').val());
    var repassword = $.trim($('input[name=repassword]').val());
    var province  = $('select[name=province]').val();
    var city  = $('select[name=city]').val();
    var region  = $('select[name=region]').val();

    //用户使用协议
    var agreement  = $('input[name=agreement]').get(0).checked;
    var icon = 2;

    if(!agreement){
      layer.msg('请您确定您已经阅读“用户使用协议”', {
          icon: icon,
          shade: 0.5,
          time: layerAlertShowTime
        })
        return;
    }

    if(!verifyRealname(realname)){
      layer.msg('姓名输入有误', {
          icon: icon,
          shade: 0.5,
          time: layerAlertShowTime
        })
        return;
    }

    if(password.length <6 ||password.length>16){
      layer.msg('密码长度须6-16之间', {
          icon: icon,
          shade: 0.5,
          time: layerAlertShowTime
        })
        return;
    }

    if(password!=repassword){
      layer.msg('两次密码不一致', {
          icon: icon,
          shade: 0.5,
          time: layerAlertShowTime
      })
      return;
    }

    if(province=="请选择"){
      layer.msg('请选择省份', {
          icon: icon,
          shade: 0.5,
          time: layerAlertShowTime
      })
      return;
    }

    if(city=="请选择"){
      layer.msg('请选择地级市', {
          icon: icon,
          shade: 0.5,
          time: layerAlertShowTime
      })
      return;
    }

    if(region=="请选择"){
      layer.msg('请选择市、县级市', {
          icon: icon,
          shade: 0.5,
          time: layerAlertShowTime
      })
      return;
    }
    var pmobile = $('input[name=pmobile]').val();
    if(!verifyPhone(pmobile)){
      layer.msg('推荐人不存在', {icon: icon,shade: 0.5,time: layerAlertShowTime});
      return;
    }
    var ajaxData = {
        url:'<?php echo U("Login/register");?>',type:'post',dataType:'json',data:{mobile:"<?php echo ($mobile); ?>",realname:realname,password:password,province:province,city:city,region:region,pmobile:pmobile,pid:'<?php echo I("get.pid");?>'},
        beforeSend:function(data){layer.load(2)},
        success:function(data){
          layer.closeAll();
          //alert(data.status);
          if(data.status == 1){
            layer.msg("资料完善成功！", {icon: data.status,shade: 0.5,time: layerAlertShowTime});
            setTimeout(location.replace("<?php echo U('User/personal');?>"),2000);   //2s后跳转到会员中心
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