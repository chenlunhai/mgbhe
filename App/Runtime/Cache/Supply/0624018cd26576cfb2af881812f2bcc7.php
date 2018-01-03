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

<script src="/Public/admin/js/laydate/laydate.js"></script>

<title>资讯列表</title>

</head>

<body>

<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 货款提现 <a
        class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
        href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a></nav>

<div class="page-container">

    <div class="cl pd-5 bg-1 bk-gray mt-20"></div>

    <div class="text-c" style="margin-top:10px;">
        <br/>
        <table cellpadding="3" cellspacing="0" class="table_98">


            <tbody>
            <tr>

                <td>可提现金额：</td>
                <td style="float: left;height: 50px;line-height: 50px; vertical-align: bottom"><i style="color:red"><?php echo ($money["supply_money"]); ?></i>

                    <input type="hidden" id="totalmoney" value="<?php echo ($money["supply_money"]); ?>">
                </td>
            </tr>
            <tr>
                <td>

                    提现金额：

                </td>
                <td style="float: left; height: 50px;line-height: 50px; vertical-align: bottom">
                    <input type="number" class="input-text" name="cashnum" id="cashnum" style="width:150px" value="">
                </td>

            </tr>
            <tr style="display: none;">

                <td>

                    提现到：
                </td>
                <td style="float: left;height: 50px;">
                    <select name="trade" id="" style="height: 35px;" class="select" disabled="disabled">

                        <option value="0">银行卡</option>

                        <option value="1">银行卡</option>

                        <option value="2">支付宝</option>

                    </select>
                </td>
            </tr>
            <tr>
                <td>银行帐号：</td>
                <td style="float: left;height: 50px;line-height: 50px; vertical-align: bottom">
                    <?php echo ($card); ?>
                </td>

            </tr>
            <tr>
                <td>帐号详情：</td>
                <td style="float: left;height: 50px;line-height: 50px; vertical-align: bottom">
                    <?php echo ($userinfo); ?>
                </td>

            </tr>
            <tr>
                <td></td>
                <td style="float: left;">

                    <input name="submit" class="btn btn-success" type="button" id="submit" onclick="upOrderDelivery()"
                           value="提现">
                </td>

            </tr>

            </tbody>


        </table>

    </div>

    <div class="mt-20">


    </div>

</div>

<script type="text/javascript" src="/Public/admin/js/jquery.js"></script> 
<script type="text/javascript" src="/Public/admin/js/H-ui.js"></script> 
<script type="text/javascript" src="/Public/admin/js/layer/layer.js"></script> 
<script type="text/javascript" src="/Public/admin/js/H-ui.admin.js"></script> 

<script type="text/javascript">

    function upOrderDelivery() {

        var money = $('#cashnum').val();
        var totalmoney = $('#totalmoney').val();
        if (parseInt(money) > parseInt(totalmoney)) {
            layer.msg('提现金额不能大于账户余额', {

                icon: 0,

                shade: 0.5,

                time: 2000

            });
            return false;
        }

        $.ajax({
            //提交数据的类型 POST GET
            type: "POST",
            //提交的网址
            url: '<?php echo U("Money/cash");?>',
            //提交的数据
            data: {cash: money},
            //返回数据的格式
            datatype: "html",//"xml", "html", "script", "json", "jsonp", "text".
            //在请求之前调用的函数
            beforeSend: function (data) {
                layer.load(2)
            },
            //成功返回之后调用的函数
            success: function (data) {
                if (data.status == 1) {

                    setTimeout('location.reload()', 2000);

                }
                layer.msg(data.msg, {

                    icon: data.status,

                    shade: 0.5,

                    time: 2000

                });

            },
            //调用执行后调用的函数
            complete: function (XMLHttpRequest, textStatus) {

            },
            //调用出错执行的函数
            error: function () {
                layer.msg('系统错误！', {

                    icon: data.status,

                    shade: 0.5,

                    time: 2000

                });
            }
        });


    }

</script>

</body>

</html>