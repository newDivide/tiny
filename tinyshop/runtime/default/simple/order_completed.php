<!doctype html>
<html lang="zh-CN">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta charset="UTF-8">
    <meta name="HandheldFriendly" content="True">
    <link rel="shortcut icon" href="<?php echo urldecode(Url::urlFormat("@favicon.ico"));?>"/>
    <link rel="bookmark" href="<?php echo urldecode(Url::urlFormat("@favicon.ico"));?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo urldecode(Url::urlFormat("#css/common.css"));?>">
    <link rel="stylesheet" type="text/css" href="<?php echo urldecode(Url::urlFormat("#css/simple.css"));?>">
    <link rel="stylesheet" type="text/css" href="<?php echo urldecode(Url::urlFormat("#css/font-awesome.min.css"));?>">
    <link rel="stylesheet" type="text/css" href="<?php echo urldecode(Url::urlFormat("#js/artdialog/tiny-dialog.css"));?>">

    <script src="<?php echo urldecode(Url::urlFormat("#js/jquery.min.js"));?>"></script>
    <script src="<?php echo urldecode(Url::urlFormat("#js/artdialog/dialog-plus-min.js"));?>"></script>
    <script src="<?php echo urldecode(Url::urlFormat("#js/common.js"));?>"></script>
    <?php echo JS::import('form');?>
    <title><?php if(isset($seo_title) && isset($site_title) && ($seo_title == $site_title)){?><?php echo isset($seo_title)?$seo_title:"";?><?php }else{?><?php echo isset($seo_title)?$seo_title:"";?>-<?php echo isset($site_title)?$site_title:"";?><?php }?></title>
</head>
<body>
    <!-- S 头部区域 -->
    <div id="header">
        <div class="container head-main">
            <a href="<?php echo urldecode(Url::urlFormat("/index/index"));?>" class="sub-1 logo"></a>
        </div>
    </div>
    <!-- E 头部区域 -->

    <!-- S 主控区域 -->
    <div id="main" class="simple-main">
        <?php if($order['type']==0){?>
<?php $items=array("购物车","确认订单信息","选择支付","订购完成");?>
<div id='widget_sub_navs'><?php $widget = Widget::createWidget('sub_navs');$widget->action = "crumbs";$widget->items = $items;$widget->step = "4";$widget->current = "4";$widget->cache = "false";$widget->run();?></div>
<?php }else{?>
<?php $items=array("确认订单信息","选择支付","订购完成");?>
<div id='widget_sub_navs'><?php $widget = Widget::createWidget('sub_navs');$widget->action = "crumbs";$widget->items = $items;$widget->step = "3";$widget->current = "3";$widget->cache = "false";$widget->run();?></div>
<?php }?>
<div class="container">
    <input type="hidden" name="order_id" value="<?php echo isset($order['id'])?$order['id']:"";?>">
    <div class="status-bar">
        <span>
        <?php if($order['pay_status']==1){?>
        <i class='icon-success-48'></i>支付成功，订购已完成！
        <?php }elseif(isset($payment_type) && $payment_type =='received'){?>
        货到付款方式，<?php if($order['status']<3){?>等待订单审核……<?php }else{?>订单审核通过！<?php }?></b>
        <?php }?>
        </span>
    </div>
    <div>
        <table class="default">
            <tr> <td style="width:200px;">订单编号：</td><td><i class="icon-order-<?php echo isset($order['type'])?$order['type']:"";?>"></i><?php echo isset($order['order_no'])?$order['order_no']:"";?> &nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo urldecode(Url::urlFormat("/ucenter/order_detail/id/$order[id]"));?>" target="_blank"> 查看订单</a></td> </tr>
            <tr> <td style="width:200px;">订单金额：</td><td class="red"><?php echo isset($currency_symbol)?$currency_symbol:"";?><?php echo isset($order['order_amount'])?$order['order_amount']:"";?></td> </tr>
            <tr> <td style="width:200px;">支付方式：</td><td id="pay_name"><?php echo isset($order['payname'])?$order['payname']:"";?></td> </tr>
        </table>
    </div>
    <div class="mt10 mb10 clearfix">
        <p class="tc mb10 "><a class="btn btn-main"  href="<?php echo urldecode(Url::urlFormat("/index/index"));?>">继续购物</a>&nbsp;&nbsp;<a class="btn btn-gray"  href="<?php echo urldecode(Url::urlFormat("/ucenter/index"));?>">用户中心</a></p></div>
    </div>

    </div>
    <!-- E 主控区域 -->

    <!-- S 底部区域 -->
    <div id="footer">
        <?php include './themes/default/layout/footer.php';?>
       
    </div>
    <!-- E 底部区域 -->
</body>
</html>

<!--Powered by TinyRise-->