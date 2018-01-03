<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta name="baidu-site-verification" content="brSKk1xvoHM7I577">
<meta name="description" content=""/>
<meta name="keywords" content=""/>
<title>店家认证</title>
<link rel="stylesheet" type="text/css" href="/Public/css/style.css">
</head>
<body>
<div class="warp">
	<div class="auth">
		<h3><img src="/Public/images/auth.png">店家认证</h3>
		<table cellspacing="0" cellpadding="0" border="0">
			<tr>
        
        <input type="text" class="a_input" name="id" placeholder="请输入营业执照上商家名称" value="<?php echo ($data['id']); ?>" hidden>

				<td class="bt">商家名称</td><td class="right"><input type="text" class="a_input" name="shopname" placeholder="请输入营业执照上商家名称" value="<?php echo ($data['shopname']); ?>"></td>
			</tr>
			<tr>
				<td class="bt">法人姓名</td><td class="right"><input type="text" class="a_input" name="realname" placeholder="请输入营业执照上法人姓名"  value="<?php echo ($data['realname']); ?>"></td>
			</tr>
			<tr>
				<td class="bt">执照号码</td><td class="right"><input type="text" class="a_input" name="shopsn" placeholder="请输入营业执照上执照号码"  value="<?php echo ($data['shopsn']); ?>"></td>
			</tr>
      <tr>
          <td class="bt" valign="top" style=" line-height:40px;">开店地址</td>
          <td>
            <div class="info">
                    <div>
                      <select id="s_province" name="s_province"></select>
                      <select id="s_city" name="s_city" ></select>
                      <select class="s_county" id="s_county" name="s_county"></select>
                      <script class="resources library" src="/Public/js/area.js" type="text/javascript"></script>
                      <script type="text/javascript">region_init('s_province','s_city','s_county');</script>
                    </div>
                    <div id="show"></div>
                  </div>
                  <input type="text" class="a_input" placeholder="请输入联系地址" name="address">
          </td>
        </tr>
		</table>
		<h4><p>上传营业执照</p></h4>
		<div class="auth_con">
			<div class="img upload"  data-id="selectfiles">
        <img id="selectfiles" src="/Public/images/moren.png">
      </div>
		</div>
    <input type="hidden" name="upload_state" value="1">
		<div class="auth_tj">
      <a href="javascript:;" onclick="verSubmit()" id="mes">认证</a>
    </div>
	</div>
  
  <!-- 底部 -->
  <link rel="stylesheet" type="text/css" href="/Public/css/footer.css">
<div class="footer">
	<ul class="u4">
		<li <?php if(ACTION_NAME == 'index'): ?>class="cur"<?php endif; ?> >
			<a href="<?php echo U('Index/index');?>" ><div class="img img1"></div><p>拼采廉</p></a>
		</li>
		<li <?php if(ACTION_NAME == 'regiment'): ?>class="cur"<?php endif; ?> >
			<a href="<?php echo U('Group/regiment');?>" ><div class="img img4"></div><p>我的团</p></a>
		</li>
		<li <?php if(ACTION_NAME == 'order_list'): ?>class="cur"<?php endif; ?> >
			<a href="<?php echo U('Group/order_list');?>" ><div class="img img2"></div><p>查订单</p></a>
		</li>
		<li <?php if(ACTION_NAME == 'personal'): ?>class="cur"<?php endif; ?> >
			<a href="<?php echo U('User/personal');?>" ><div class="img img3"></div><p>会员中心</p></a>
		</li>
	</ul>
</div>
</div>

<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>
<script type="text/javascript" src="/Public/js/function.js"></script>
<script type="text/javascript" src="/Public/js/disable.js"></script>
<script type="text/javascript">
  $('iframe').css('display','none').css('z-index','-1').css('opacity','0');
</script>


<link rel="stylesheet" type="text/css" href="/Public/js/aliyun/style.css">
<script type="text/javascript" src="/Public/js/aliyun/lib/plupload-2.1.2/js/plupload.full.min.js"></script>
<script type="text/javascript" src="/Public/js/aliyun/upload.js"></script>

<script type="text/javascript">
//认证
function  verSubmit() {
    var shopname = $.trim($('input[name=shopname]').val());
    var realname  = $.trim($('input[name=realname]').val());
    var shopsn  = $.trim($('input[name=shopsn]').val());
    var province = $.trim($('select[name=s_province]').val());
    var city  = $.trim($('select[name=s_city]').val());
    var region  = $.trim($('select[name=s_county]').val());
    var address  = $.trim($('input[name=address]').val());
    
    var icon = 2;
    if(!shopname){
      layer.msg('请输入商家名称', { icon: icon,shade: 0.5,time: 4000})
      return;
    }
    if(!realname){
      layer.msg('请输入法人姓名', {icon: icon,shade: 0.5,time: 4000})
      return;
    }
    if(!shopsn){
      layer.msg('请输入执照号码', { icon: icon,shade: 0.5,time: 4000 })
      return;
    }
    if(!province){
      layer.msg('请选择省份', { icon: icon,shade: 0.5,time: 4000 })
      return;
    }
    if(!city){
      layer.msg('请选择城市', { icon: icon,shade: 0.5,time: 4000 })
      return;
    }
    if(!region){
      layer.msg('请选择区域', { icon: icon,shade: 0.5,time: 4000 })
      return;
    }
    if(!address){
      layer.msg('请输入地址', { icon: icon,shade: 0.5,time: 4000 })
      return;
    }
    

    if(1 != uploader.files.length){
      layer.msg('请上传营业执照', {icon: 2,shade: 0.5,time: 2000,closeBtn:1});
      return;
    }
    set_upload_param(uploader);
    uploader.start();
}


function subData(info){ //图片上传成功之后回调
  //通过id判断是否重新认证
  var shopname = $.trim($('input[name=shopname]').val());
  var realname  = $.trim($('input[name=realname]').val());
  var shopsn  = $.trim($('input[name=shopsn]').val());
  var province = $.trim($('select[name=s_province]').val());
  var city  = $.trim($('select[name=s_city]').val());
  var region  = $.trim($('select[name=s_county]').val());
  var address  = $.trim($('input[name=address]').val());

  var ajaxData = {
    url:"<?php echo U('Group/authentication');?>",type:'post',dataType:'json',data:{shopname:shopname,shopsn:shopsn,realname:realname,province:province,city:city,region:region,address:address,imgurl:JSON.stringify(info)},
    beforeSend:function(data){layer.load(2)},
    success:function(data){
      layer.closeAll();
      if(data.status == 1){
        $('#mes').html(data.msg);
      }
      $('#mes').attr('onClick','subData('+info+')');
      layer.msg(data.msg, {icon: data.status,shade: 0.5,time: 2000});
    }
  }
  $.ajax(ajaxData);
}

</script>
</body>
</html>