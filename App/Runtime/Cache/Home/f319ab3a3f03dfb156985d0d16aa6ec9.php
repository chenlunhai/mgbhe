<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta name="baidu-site-verification" content="brSKk1xvoHM7I577">
<meta name="description" content=""/>
<meta name="keywords" content=""/>
<title>个人信息</title>
<link rel="stylesheet" type="text/css" href="/Public/css/style.css">
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>
<script type="text/javascript" src="/Public/js/function.js"></script>
<script type="text/javascript" src="/Public/js/disable.js"></script>
<script type="text/javascript">
  $('iframe').css('display','none').css('z-index','-1').css('opacity','0');
</script>


<script type="text/javascript" src="/Public/js/select2.min.js"></script>
</head>
<body style="background:#f0eff5;">
<div class="warp">
	<div class="set">
		<ul>
            <!-- <li>数钜宝推荐人<span><?php echo ($data["prealname"]); ?></span></li> -->
            <li>麦光宝推荐人<span><?php echo ($data["pmrealname"]); ?></span></li>
			<li>姓名<span><?php echo ($data["realname"]); ?></span></li>
			<li>电话<span><?php echo ($data["mobile"]); ?></span></li>
			<li><a href="javascript:;" onClick="toshare();">提现银行<span><?php if(empty($data["bank_address"])): ?>绑定银行<?php else: echo ($data["bank_user"]); endif; ?></span></a></li>
			<li>卡号<span><?php echo ($data["bank_card"]); ?></span></li>
			<li><a href="http://test.hnyst.net.cn">微信<span>绑定微信</span></a></li>
		</ul>
		
		<div class="set_qd">
			<!-- <a href="javascript:;" onclick="verSubmit()">提交</a> -->
			<a href="<?php echo U('Login/logout');?>" >退出登录</a>
		</div>
	</div>
<div class="a-share">
  <div class="a_con">
    <table cellspacing="0" cellpadding="0" border="0">
    	<tr>
    		<td>
    			<div class="s_into">
    				<select name="bank_user" class="r_select" id="bank_user">
                        <option value="中国工商银行" <?php if($user['bank_user'] == '中国工商银行'): ?>selected<?php endif; ?>>中国工商银行</option>
                        <option value="中国农业银行" <?php if($user['bank_user'] == '中国农业银行'): ?>selected<?php endif; ?>>中国农业银行</option>
                        <option value="中国银行" <?php if($user['bank_user'] == '中国银行'): ?>selected<?php endif; ?>>中国银行</option>
                        <option value="中国建设银行" <?php if($user['bank_user'] == '中国建设银行'): ?>selected<?php endif; ?>>中国建设银行</option>
                        <option value="交通银行" <?php if($user['bank_user'] == '交通银行'): ?>selected<?php endif; ?>>交通银行</option>
                        <option value="中国邮政储蓄银行" <?php if($user['bank_user'] == '中国邮政储蓄银行'): ?>selected<?php endif; ?>>中国邮政储蓄银行</option>
                        <option value="中国光大银行" <?php if($user['bank_user'] == '中国光大银行'): ?>selected<?php endif; ?>>中国光大银行</option>
                        <option value="中国民生银行" <?php if($user['bank_user'] == '中国民生银行'): ?>selected<?php endif; ?>>中国民生银行</option>
                        <option value="中信银行" <?php if($user['bank_user'] == '中信银行'): ?>selected<?php endif; ?>>中信银行</option>
                        <option value="广发银行" <?php if($user['bank_user'] == '广发银行'): ?>selected<?php endif; ?>>广发银行</option>
                        <option value="平安银行" <?php if($user['bank_user'] == '平安银行'): ?>selected<?php endif; ?>>平安银行</option>
                        <option value="浦发银行" <?php if($user['bank_user'] == '浦发银行'): ?>selected<?php endif; ?>>浦发银行</option>
                        <option value="渤海银行" <?php if($user['bank_user'] == '渤海银行'): ?>selected<?php endif; ?>>渤海银行</option>
                        <option value="招商银行" <?php if($user['bank_user'] == '招商银行'): ?>selected<?php endif; ?>>招商银行</option>
                        <option value="华夏银行" <?php if($user['bank_user'] == '华夏银行'): ?>selected<?php endif; ?>>华夏银行</option>
                        <option value="兴业银行" <?php if($user['bank_user'] == '兴业银行'): ?>selected<?php endif; ?>>兴业银行</option>
                        <option value="浙商银行" <?php if($user['bank_user'] == '浙商银行'): ?>selected<?php endif; ?>>浙商银行</option>
                        <option value="晋商银行" <?php if($user['bank_user'] == '晋商银行'): ?>selected<?php endif; ?>>晋商银行</option>
                        <option value="包商银行" <?php if($user['bank_user'] == '包商银行'): ?>selected<?php endif; ?>>包商银行</option>
                        <option value="徽商银行" <?php if($user['bank_user'] == '徽商银行'): ?>selected<?php endif; ?>>徽商银行</option>
                        <option value="北京银行" <?php if($user['bank_user'] == '北京银行'): ?>selected<?php endif; ?>>北京银行</option>
                        <option value="内蒙古银行" <?php if($user['bank_user'] == '内蒙古银行'): ?>selected<?php endif; ?>>内蒙古银行</option>
                        <option value="吉林银行" <?php if($user['bank_user'] == '吉林银行'): ?>selected<?php endif; ?>>吉林银行</option>
                        <option value="上海银行" <?php if($user['bank_user'] == '上海银行'): ?>selected<?php endif; ?>>上海银行</option>
                        <option value="江苏银行" <?php if($user['bank_user'] == '江苏银行'): ?>selected<?php endif; ?>>江苏银行</option>
                        <option value="广州银行" <?php if($user['bank_user'] == '广州银行'): ?>selected<?php endif; ?>>广州银行</option>
                        <option value="长沙银行" <?php if($user['bank_user'] == '长沙银行'): ?>selected<?php endif; ?>>长沙银行</option>
                        <option value="广东南粤银行" <?php if($user['bank_user'] == '广东南粤银行'): ?>selected<?php endif; ?>>广东南粤银行</option>
                      </select>
    			</div>
    		</td>
    	</tr>
    	<tr>
    		<td>
    			<div class="s_info">
                    <div>
                        <select id="b_province" name="b_province">
                        	 
                        </select>
                        <select id="b_city" name="b_city">
                        	 
                        </select>
                        <select style="display:none;" id="county"></select>
                        <script class="resources library" src="/Public/js/area.js?i=0" type="text/javascript"></script>
                        <script>  region_init("b_province","b_city","county","<?php echo ($data["province"]); ?>","","");  </script>  
                    </div>
                </div>
    		</td>
    	</tr>
    	<tr>
    		<td>
    			<div class="s_into">
    				<select id="selg" onClick="getOutBankInfo();">
    					<option value="<?php echo getBankInfo($data['bank_address'],0);?>,<?php echo getBankInfo($data['bank_address'],1);?>"><?php echo getBankInfo($data['bank_address'],1);?></option>
    				</select>
    			</div>
    		</td>
    	</tr>
    	<tr>
    		<td>
    			<input type="text" name="bank_card" id="bank_card" class="s_input" placeholder="请输入卡号" value="<?php echo ($data["bank_card"]); ?>">
    		</td>
    	</tr>
    </table>
  </div>
  <div class="am-share-foot">
    <a href="javascript:;"   class="a_foot" onClick="verSubmit()">确定</a>
  </div>
</div>
</div>


<script type="text/javascript">
//点击弹窗
    function toshare(){
        $(".a-share").addClass("am-modal-active"); 
        if($(".sharebg").length>0){
          $(".sharebg").addClass("sharebg-active");
        }else{
          $("body").append('<div class="sharebg"></div>');
          $(".sharebg").addClass("sharebg-active");
        }
        $(".sharebg-active,.share_btn,.a_foot").click(function(){
          $(".a-share").removeClass("am-modal-active");  
          setTimeout(function(){
            $(".sharebg-active").removeClass("sharebg-active"); 
            $(".sharebg").remove(); 
          },300);
        }) 
    }
</script>


<script type="text/javascript">
$(document).ready(function() {
  $("#b_province").change(function(){ 
   getOutBankInfo();
  }); 
  $('#b_city').change(function(){
    getOutBankInfo();
  })
  $('#bank_user').change(function(){
    getOutBankInfo();
  })
  
});
function  getOutBankInfo () {
    var optionone = $("#bank_user option:selected").val(); //银行
    var pro = $('#b_province').val(); //省
    var address = $("#b_city option:selected").val(); //市
    $('#selg').empty();
    if (optionone && pro && address) {
        var arr = '北京,上海,重庆,天津';
        var province = pro;
       
        if(arr.indexOf(pro) < 0){
          province = pro+'省';
        }else{
          province = pro+'市';
        }
        $.ajax({
            url:'<?php echo U("User/get_bank_info");?>',type: 'post',data: {optionone:optionone,city:address,province:province},dataType: 'json',
            beforeSend:function(data){layer.load(2)},
            success:function(data){
            layer.closeAll();
            var info = data.info;
            if(info.length>0){
              $("#selg").select2({
                data: info,
                placeholder: '请选择',
                allowClear: true
              });   
              $('#nuj').css("display","none");
            }else{
               $('#nuj').show();
            }
          }
        })
        $('#selg').attr('onClick','');
    }
}
//提交
function verSubmit(){
    var bank_user = $('#bank_user').val();
    var bank_card = $('#bank_card').val();
    var bank_address = $('#selg').val();
    if(!bank_user){
        layer.msg('请选择开户银行', {icon: 2,shade: 0.5,time: 2000,closeBtn:1});
        return;
    }
    if(!bank_card){
        layer.msg('请输入开户卡号', {icon: 2,shade: 0.5,time: 2000,closeBtn:1});
        return;
    }
    if(!bank_address){
        layer.msg('请选择开户支行', {icon: 2,shade: 0.5,time: 2000,closeBtn:1});
        return;
    }
	var ajaxData = {
	    url:'<?php echo U("User/set_up");?>',type:'post',dataType:'json',data:{bank_user:bank_user,bank_card:bank_card,bank_address:bank_address},
	    beforeSend:function(data){layer.load(2)},
	    success:function(data){
	      layer.closeAll();
	      if(data.status == 1)    setTimeout('location.reload()',2000);
	      layer.msg(data.msg, {icon: data.status,shade: 0.5,time: 2000});
	    }
	}
	$.ajax(ajaxData);
}
</script>
</body>
</html>