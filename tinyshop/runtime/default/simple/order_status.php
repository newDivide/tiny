<!doctype html>
<html lang="zh-CN">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta charset="UTF-8">
    <meta name="HandheldFriendly" content="True">
        <?php include './themes/default/layout/import.php';?>
    
    
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
        <?php echo JS::import('dialog?skin=simple');?>
<?php if($order['type']==0){?>
<link type="text/css" rel="stylesheet" href="<?php echo urldecode(Url::urlFormat("#css/simple.css"));?>" />
<?php $items=array("购物车","确认订单信息","选择支付","订购完成");?>
<div id='widget_sub_navs'><?php $widget = Widget::createWidget('sub_navs');$widget->action = "crumbs";$widget->items = $items;$widget->step = "4";$widget->current = "3";$widget->cache = "false";$widget->run();?></div>
<?php }else{?>
<?php $items=array("确认订单信息","选择支付","订购完成");?>
<div id='widget_sub_navs'><?php $widget = Widget::createWidget('sub_navs');$widget->action = "crumbs";$widget->items = $items;$widget->step = "3";$widget->current = "2";$widget->cache = "false";$widget->run();?></div>
<?php }?>
<div class="container">
    <form action="<?php echo urldecode(Url::urlFormat("/payment/dopay"));?>" method="post" target="_blank">
        <input type="hidden" name="order_id" value="<?php echo isset($order['id'])?$order['id']:"";?>">
        <div class="status-bar">
            <span><i class="icon-success-48"></i>订单已成功提交！</span>
       </div>
       <div class="mt10">
        <table class="default mt10 p10">
            <tr> <td style="width:200px;">订单编号：</td><td><i class="icon-order-<?php echo isset($order['type'])?$order['type']:"";?> ie6png"></i><?php echo isset($order['order_no'])?$order['order_no']:"";?> &nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo urldecode(Url::urlFormat("/ucenter/order_detail/id/$order[id]"));?>" target="_blank" class="red"> 查看订单>> </a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:tools_reload()" class=" btn btn-mini">刷新</a></td> </tr>
            <tr> <td style="width:200px;">订单金额：</td><td class="red"><?php echo isset($currency_symbol)?$currency_symbol:"";?><?php echo isset($order['order_amount'])?$order['order_amount']:"";?></td> </tr>
            <tr> <td style="width:200px;">支付方式：</td><td id="pay_name" class="bold"><?php echo isset($order['payment'])?$order['payment']:"";?></td> </tr>
        </table>
        <div class="mt10">
            <a href="javascript:;" id="voucher-btn" style="line-height: 32px;height:32px;font-weight:800"><i class="icon-plus-1-16"></i> 其它支付方式：</a>
        </div>
       <!--  <table class="default mt20"  style="display:none;">
            <?php $item=null; $query = new Query("payment as pa");$query->fields = "pa.*,pp.class_name";$query->join = "left join pay_plugin as pp on pa.plugin_id = pp.id";$query->where = "pa.status = 0 and (pa.client_type = 0 or pa.client_type = 2)";$query->order = "pa.sort desc";$items = $query->find(); foreach($items as $key => $item){?>
            <tr><td width="200px;"><label><input type="radio" id="<?php echo isset($item['class_name'])?$item['class_name']:"";?>" name="payment_id" value="<?php echo isset($item['id'])?$item['id']:"";?>" <?php if($item['id']==$order['payment']){?>checked="checked"<?php }?> data-name="<?php echo isset($item['pay_name'])?$item['pay_name']:"";?>"> <?php echo isset($item['pay_name'])?$item['pay_name']:"";?> </label> <?php if($item['note']!=''){?><span class="fr"><a class="payment-note" href="#" note="<?php echo htmlspecialchars($item['note']);?>">详情</a></span><?php }?>
            </td></tr>
            <?php }?>
        </table> -->
            <div class="clearfix" id="payment-list" style="display:none;">
                <ul class="payment-list">
                    <?php $item=null; $query = new Query("payment as pa");$query->fields = "pa.*,pp.logo,pp.class_name";$query->join = "left join pay_plugin as pp on pa.plugin_id = pp.id";$query->where = "pa.status = 0 and (pa.client_type = 0 or pa.client_type = 2)";$query->order = "pa.sort desc";$items = $query->find(); foreach($items as $key => $item){?>
                    <li ><input type="radio" id="<?php echo isset($item['class_name'])?$item['class_name']:"";?>" name="payment_id" value="<?php echo isset($item['id'])?$item['id']:"";?>" <?php if($item['id']==$order['payment']){?>checked="checked"<?php }?> data-name="<?php echo isset($item['pay_name'])?$item['pay_name']:"";?>"><label><b><?php echo isset($item['pay_name'])?$item['pay_name']:"";?></b> <?php echo isset($item['pay_desc'])?$item['pay_desc']:"";?></label>
                    <div><img src="<?php echo urldecode(Url::urlFormat("@protected/classes/$item[logo]"));?>"></div>
                    </li>
                    <?php }?>
                </ul>
            </div>
        <div class="clearfix">
            <div id='widget_pay_bank'><?php $widget = Widget::createWidget('pay_bank');$widget->action = "bank";$widget->cache = "false";$widget->run();?></div>
            <?php $order_name = '订单号：'.$order['order_no'];?>
            <div id='widget_pay_weixin'><?php $widget = Widget::createWidget('pay_weixin');$widget->action = "weixin";$widget->order_no = $order['order_no'];$widget->order_amount = $order['order_amount'];$widget->order_name = $order_name;$widget->cache = "false";$widget->run();?></div>
        </div>
    </div>

    <div class="mt10 mb20 clearfix">
        <p class="tc"><input class="btn btn-main" type="submit" value="立即支付"></p></div>
    </form>
</div>
        <?php include './themes/default/apply/orderstatus.php';?>
    
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