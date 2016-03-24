<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="HandheldFriendly" content="True">
    <?php include './themes/default/layout/import.php';?>
</head>

<body>
    <!-- S 头部区域 -->
    <div id="header">
        <?php include './themes/default/layout/header.php';?>
            </div>
            <!-- E 头部区域 -->
            <!-- S 主控区域 -->
            <div id="main">
               <link type="text/css" rel="stylesheet" href="<?php echo urldecode(Url::urlFormat("#css/ucenter.css"));?>" />
<div class="container clearfix">
	<div id='widget_sub_navs'><?php $widget = Widget::createWidget('sub_navs');$widget->action = "ucsidebar";$widget->sidebar = $sidebar;$widget->act = $actionId;$widget->cache = "false";$widget->run();?></div>
	<div class="uc-content">
			<h1 class="title"><span>我的订单：</span></h1>
			<table class="simple">
				<tr>
					<th >订单编号</th> <th width="100">收货人</th> <th width="100">订单金额</th> <th width="160">下单时间</th> <th width="166">订单状态</th>
				</tr>
				<?php $item=null; $obj = new Query("order");$obj->where = "user_id = $user[id]";$obj->order = "id desc";$obj->page = "1";$items = $obj->find(); foreach($items as $key => $item){?>
				<tr class="<?php if($key%2==1){?>even<?php }else{?>odd<?php }?>">
					<td><a href="<?php echo urldecode(Url::urlFormat("/ucenter/order_detail/id/$item[id]"));?>"><i class="icon-order-<?php echo isset($item['type'])?$item['type']:"";?>-32  ie6png"></i><?php echo isset($item['order_no'])?$item['order_no']:"";?></a></td> <td><?php echo isset($item['accept_name'])?$item['accept_name']:"";?></td> <td><?php echo isset($currency_symbol)?$currency_symbol:"";?><?php echo isset($item['order_amount'])?$item['order_amount']:"";?></td> <td><?php echo isset($item['create_time'])?$item['create_time']:"";?></td> <td><?php echo $this->order_status($item);?></td>
				</tr>
				<?php }?>
			</table>
			<div class="page-nav"><?php echo $obj->pagebar();?></div>
	</div>
</div>
     <?php include './themes/default/apply/orderscript.php';?>

           </div>
           <!-- E 主控区域 -->

           <!-- S 底部区域 -->
           <div id="footer">
                     <?php include './themes/default/layout/footer.php';?>
                    </div>
                    <!-- E 底部区域 -->
                    <?php include './themes/default/layout/footerscript.php';?>
                </body>
                </html>

<!--Powered by TinyRise-->