<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8" />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta content="-1" http-equiv="Expires">           
<meta content="no-cache" http-equiv="Cache-Control">           
<meta content="no-cache" http-equiv="Pragma">
<meta name = "format-detection" content = "telephone=no">
<title>确认订单</title>
<link rel="stylesheet" type="text/css" href="/Public/css/group.css">
</head>
<body style="background:#f2f2f2;">
<div class="main">
  <div class="order">
    <div class="ord_map">
        <div class="tj">
          <div class="tj_con">
            <ul>
              <?php if(!empty($address)): if(is_array($address)): $i = 0; $__LIST__ = $address;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li id="address<?php echo ($val["id"]); ?>">
                  <div class="t_c_t"><?php echo ($val["realname"]); ?><span><?php echo ($val["mobile"]); ?></span></div>
                  <div class="t_c_c"><?php echo ($val["province"]); echo ($val["city"]); echo ($val["country"]); echo ($val["detail"]); ?></div>
                  <div class="t_c_b">
                    <input type="radio" id="radio-<?php echo ($val["id"]); ?>" name="address" class="regular-check" value="<?php echo ($val["id"]); ?>" <?php if(($i) == "1"): ?>checked<?php endif; ?>/>
                    <label for="radio-<?php echo ($val["id"]); ?>">
                      <div class="t_c_img"></div>收货地址
                    </label>
                    <p><a href="javascript:;" onClick="delAddress(<?php echo ($val["id"]); ?>)"><img src="/Public/images/delete.png">删除</a></p>
                  </div>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                <div class="clearboth"></div><?php endif; ?>
            </ul>
            
            <div class="tj_c_t"><?php if(empty($address)): ?>您还没有添加地址唷~<?php endif; ?></div>       
            
          </div>
          
          <a class="btn01" id="add_addressBtn" onClick="clickShowBox()">添加新地址</a>
          <div class="addressBox" id="addressBox">
            <ul>
              <li>
                <span>收货姓名</span>
                <input type="text" class="s_input" placeholder="请输入收货姓名" name="realname">
              </li>
              <li>
                <span>收货电话</span>
                <input type="text" class="s_input" placeholder="请输入收货电话" name="mobile">
              </li>
              <div class="info">
                <div>
                <li>
                  <span>选择省份</span>
                  <select id="s_province" name="province"></select>
                </li>
                <li>
                  <span>选择城市</span>
                  <select id="s_city" name="city" ></select>
                </li>
                <li>
                  <span>选择区县</span>
                  <select id="s_county" name="country"></select>
                </li>
                  <script class="resources library" src="/Public/js/area.js" type="text/javascript"></script>
                  <script type="text/javascript">
                    region_init('s_province','s_city','s_county');
                  </script>
                  </div>
                  <div id="show"></div>
              </div>
              <li style="height:70px;">
                <span>详细地址</span>
                <textarea class="s_area" name="detail"></textarea>
                <div style="clear:both"></div>
              </li>
            </ul>
            <div class="subit"><a href="javascript:;" onclick="addAddress();">确定</a></div>                        
          </div>
        </div>
      </div>

      <div class="ord_con">
        <ul>
          <li>
            <div class="img"><img src="<?php echo ($data['gimg']); ?>"></div>
            <div class="right">
              <div class="title"><?php echo ($data["gname"]); ?></div>
              
              <div class="tit"><em>￥<span><?php echo ($data["gteam_price"]); ?></span>/件</em>X<?php echo ($data["buy_num"]); ?></div>
            </div>
          </li>
          <div class="clearboth"></div>
        </ul>
      </div>

      <div class="ord_bot">
        <ul>
          <li>共<?php echo ($data["buy_num"]); ?>件商品，合计 ￥<span><?php echo ($data["total_price"]); ?></span></li>
        </ul>
      </div>

      <div class="ord_fot">
        <p><em>合计：￥<span><?php echo ($data["total_price"]); ?></span></em><a href="javascript:;" onClick="submitOrder()" >提交订单</a></p> <!-- cashier.html -->
      </div>

  </div>
  <!-- 底部footer -->
  
</div>

<!-- <script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script> -->
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>
<script type="text/javascript" src="/Public/js/function.js"></script>



<script type="text/javascript">
function clickShowBox(){
 $('#addressBox').slideToggle(300);
 var el =document.getElementById("addressBox");
}

var Gid  = document.getElementById ;
var showArea = function(){
  Gid('show').innerHTML = "<h3>省" + Gid('s_province').value + " - 市" +  
  Gid('s_city').value + " - 县/区" + 
  Gid('s_county').value + "</h3>"
  }
Gid('s_county').setAttribute('onchange','showArea()');

//添加收货地址
function addAddress(){
  var type = $('.tj_con ul').length;
  var realname = $('input[name=realname]').val();
  var mobile = $('input[name=mobile]').val();
  var detail = $('textarea[name=detail]').val();
  var province = $('select[name=province]').val();
  var city = $('select[name=city]').val();
  var country = $('select[name=country]').val();
  if(!realname){
    layer.msg('请输入收货姓名' ,{icon: 2,shade:0.5,time:2000,closeBtn:1});
    return;
  }
  if(!verifyPhone(mobile)){
    layer.msg('请正确输入收货电话' ,{icon: 2,shade:0.5,time:2000,closeBtn:1});
    return;
  }
  if(!detail){
    layer.msg('请输入详细地址' ,{icon: 2,shade:0.5,time:2000,closeBtn:1});
    return;
  }

  var ajaxData = {
    url:'<?php echo U("Order/addAddress");?>',type:'post',dataType:'json',data:{realname:realname,mobile:mobile,detail:detail,province:province,city:city,country:country},
    beforeSend:function(data){layer.load(2)},
    success:function(data){
      layer.closeAll();
      if(data.status==1){
        html = '';
        html+='<li id="address'+data.data.id+'">';
          html+='<div class="t_c_t">'+realname+'<span>'+mobile+'</span></div>';
          html+='<div class="t_c_c">'+province+city+country+detail+'</div>';
          html+='<div class="t_c_b">';
            html+='<input type="radio" id="radio-'+data.data.id+'" value="'+data.data.id+'" name="address" class="regular-check" checked />';
            html+='<label for="radio-'+data.data.id+'">';
              html+='<div class="t_c_img"></div>收货地址';
            html+='</label>';
            html+='<p><a href="javascript:;" onClick="delAddress('+data.data.id+');"><img src="/Public/images/delete.png">删除</a></p>';
          html+='</div>';
        html+='</li>';
        if(type>0){
          $('.tj_con ul').append(html);
        }else{
          $('.tj_con').html('<ul>'+html+'</ul>');
        }
        clickShowBox();
        getPostageFee();
      }
    }
  }
  $.ajax(ajaxData);
}

//删除地址
function delAddress(id){
  layer.confirm('确定删除吗？', {icon: 3, title:'提示'}, function(index){
    var ajaxData = {
      url:'<?php echo U("Order/delAddress");?>',type:'post',dataType:'json',data:{id:id},
      beforeSend:function(data){layer.load(2)},
      success:function(data){
        layer.closeAll();
        if(data.status==1){
          $('.tj_con ul>li#address'+id).hide();
        }
      
        if($(".tj_con ul>li:hidden").length == $(".tj_con ul>li").length){
          var html = '您还没有添加地址唷~';
          $(".tj_c_t").html(html);
        }
      }
    }
    $.ajax(ajaxData);
  });
}

//提交订单
function submitOrder(){
  var address = $('input[name=address]:checked');
  if(address.length!=1){
    layer.msg('请选择收货地址' ,{icon: 2,shade:0.5,time:2000,closeBtn:1});
    return;
  }
  var id = "<?php echo ($data['id']); ?>";
  var buy_num = "<?php echo ($data['buy_num']); ?>";
  var aid = address.val();

  var ajaxData = {
    url:'<?php echo U("Order/create_order");?>',type:'post',dataType:'json',data:{id:id,buy_num:buy_num,aid:aid}, 
    success:function(data){
      layer.closeAll();
      if(data.status==1){
        location.href='<?php echo U("Order/cashier",'',false);?>/osn/'+data.data.osn;
        return;
      }
      layer.msg(data.msg ,{icon: 2,shade:0.5,time:2000,closeBtn:1})
    }
  };
  $.ajax(ajaxData);
}
</script>
</body>
</html>