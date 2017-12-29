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
</head>
<body style="background:#f0eff5;">
<div class="warp">
	<div class="set">
		<ul>
			<li>数钜宝推荐人<span><?php echo ($data["prealname"]); ?></span></li>
			<li>姓名<span><?php echo ($data["realname"]); ?></span></li>
			<li>电话<span><?php echo ($data["mobile"]); ?></span></li>
			<li><a href="javascript:;" onClick="toshare();">提现银行<span>绑定银行</span></a></li>
			<li>卡号<span></span></li>
			<li><a href="javascript:;">微信<span>绑定微信</span></a></li>
		</ul>
		
		<div class="set_qd">
			<!-- <a href="javascript:;" onclick="verSubmit()">提交</a> -->
			<a href="<?php echo U('Login/logout');?>" >退出</a>
		</div>
	</div>
<div class="a-share">
  <div class="a_con">
    <table cellspacing="0" cellpadding="0" border="0">
    	<tr>
    		<td>
    			<div class="s_into">
    				<select>
    					<option>请选择银行</option>
    					<option>请选择银行</option>
    					<option>请选择银行</option>
    				</select>
    			</div>
    		</td>
    	</tr>
    	<tr>
    		<td>
    			<div class="s_info">
                    <div>
                        <select id="b_province" name="b_province">
                        	<option>请选择省</option>
                        	<option>请选择省</option>
                        	<option>请选择省</option>
                        </select>
                        <select id="b_city" name="b_city">
                        	<option>请选择市</option>
                        	<option>请选择市</option>
                        	<option>请选择市</option>
                        </select>
                    </div>
                </div>
    		</td>
    	</tr>
    	<tr>
    		<td>
    			<div class="s_into">
    				<select>
    					<option>请选择银行</option>
    					<option>请选择银行</option>
    					<option>请选择银行</option>
    				</select>
    			</div>
    		</td>
    	</tr>
    	<tr>
    		<td>
    			<input type="text" class="s_input" placeholder="请输入卡号">
    		</td>
    	</tr>
    </table>
  </div>
  <div class="am-share-foot">
    <a href="javascript:;"   class="a_foot">确定</a>
  </div>
</div>
</div>

<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>
<script type="text/javascript" src="/Public/js/function.js"></script>



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
	//提交
	function verSubmit(){
		// var nickname = $.trim($('input[name=nickname]').val());
	    var mobile = $.trim($('input[name=mobile]').val());
	    // var bank_user = $.trim($('select[name=bank_user]').val());
	    // var bank_address = $.trim($('input[name=bank_address]').val());
	    // var bank_name = $.trim($('input[name=bank_name]').val());
	    // var bank_card = $.trim($('input[name=bank_card]').val());

	    /*var data = <?php echo json_encode($data);?>;
	    var user_arr = eval(data);

	    var index = ['nickname','mobile','bank_user','bank_address','bank_name','bank_card'];
	    var similar_flag = false;
	    for (var i = index.length - 1; i >= 0; i--) {
	    	if($.trim(eval(index[i]))==user_arr[index[i]]){
	    		similar_flag = true;
	    	}
	    };
	    
	    if(similar_flag){  //5
	    	layer.msg('数据未做更改！', {icon: 7,shade: 0.5,time: 2000});
	    	return;
	    }*/

		var ajaxData = {
		    url:'<?php echo U("User/set_up");?>',type:'post',dataType:'json',data:{mobile:mobile},
		    beforeSend:function(data){layer.load(2)},
		    success:function(data){
		      layer.closeAll();
		      //alert(data.status);
		      if(data.status == 1){
		        layer.msg(data.msg, {icon: data.status,shade: 0.5,time: 2000});
		        //setTimeout(location.replace("<?php echo U('User/index');?>"),2000);   //2s后跳转到gourl
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