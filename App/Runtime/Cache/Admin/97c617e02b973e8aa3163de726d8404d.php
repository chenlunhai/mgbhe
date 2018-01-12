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
<title>资讯列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 供货商商品审核列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray mt-20">    <span class="r">共有数据：<strong><?php echo ($count); ?></strong> 条</span> </div>
    <div class="mt-20">
    <div class="text-c" style="margin-top:10px;">
        <table cellpadding="3" cellspacing="0" class="table_98">
             <form  method="post" id="form1">
              <tbody>
              <tr>
                <td>
                商品名称：<input type="text" name="gname" value="<?php echo ($assign['gname']); ?>" style="width:250px" class="input-text">
                添加时间：<input type="text" id="stime" style="width:100px" class="input-text" name="stime" size="20" value="<?php echo ($assign['stime']); ?>">
                - <input type="text" id="dtime" style="width:100px" class="input-text" name="dtime" size="10" value="<?php echo ($assign['dtime']); ?>">
                状态：<select name="state" class="s_select">
                    <option value="" >请选择</option>
                    <option value="0" <?php if($assign['state'] == '0'): ?>selected<?php endif; ?>>拼团中</option>
                    <option value="1" <?php if($assign['state'] == 1): ?>selected<?php endif; ?>>已满团</option>
                </select>
                <input name="submit" class="btn btn-success" type="submit" id="submit" value="查找">
                <!-- <input class="btn btn-success" type="submit" value="导出" onclick="subExport()"> -->
                </td>
              </tr>
              </tbody>
              </form>
        </table>
    </div>
        <table class="table table-border table-bordered table-bg table-hover table-sort">
                <tr class="text-c">
                    <th>商品名称</th>
                    <th>商品图片</th>
                    <th>商品原价</th>
                    <th>商品拼团价</th>
                    <th>单次最低量</th>
                    <th>满团数量</th>
                    <th>支持城市</th>
                    <th>添加时间</th>
                    <th>拼团状态</th>
                </tr>
            <tbody>
            <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr class="text-c" id="info<?php echo ($val["id"]); ?>">
                <td><?php echo ($val["gname"]); ?></td>
                <td><a target="_balck" href="<?php echo ($val["gimg"]); ?>"><img src="<?php echo ($val["gimg"]); ?>" width="25" height="25"></a></td>
                <td><?php echo ($val["gprice"]); ?></td>
                <td><?php echo ($val["gteam_price"]); ?></td>
                <td class="xy"><?php echo ($val["gpay_limit"]); ?></td>
                <td><?php echo ($val["gnum"]); ?></td>
                <td><?php echo ($val["gcity"]); ?></td>
                <td><?php echo ($val['gaddtime']); ?></td>
                <td><?php echo ($val['gstatus'] ? '已满团' : '拼团中'); ?></td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
        <div id="page"><?php echo ($page); ?></div>
    </div>
</div>
<script type="text/javascript" src="/Public/admin/js/jquery.js"></script> 
<script type="text/javascript" src="/Public/admin/js/H-ui.js"></script> 
<script type="text/javascript" src="/Public/admin/js/layer/layer.js"></script> 
<script type="text/javascript" src="/Public/admin/js/H-ui.admin.js"></script> 
<script src="/Public/admin/js/laydate/laydate.js"></script>
<script type="text/javascript">
$(function(){
    laydate({
       elem: '#stime'
    })
    laydate({
       elem: '#dtime'
    })
})
function subExport(){
    $('input[name=state]').val(1);
}
</script>
</body>

</html>