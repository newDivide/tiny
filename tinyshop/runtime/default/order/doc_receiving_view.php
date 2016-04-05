<!DOCTYPE html>
<html>
<head>
	<title><?php echo isset($title)?$title:"";?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="designer:webzhu, date:2012-03-23" />
<link rel="stylesheet" href="<?php echo urldecode(Url::urlFormat("@static/css/base.css"));?>" />
<link rel="stylesheet" href="<?php echo urldecode(Url::urlFormat("@static/css/admin.css"));?>" />
<link rel="stylesheet" href="<?php echo urldecode(Url::urlFormat("@static/css/font_icon.css"));?>" />
<?php echo JS::import('jquery');?>
<script type="text/javascript" src="<?php echo urldecode(Url::urlFormat("@static/js/common.js"));?>"></script>
<!--[if lte IE 7]><script src="<?php echo urldecode(Url::urlFormat("@static/css/fonts/lte-ie7.js"));?>"></script><![endif]-->
</head>
<body style="background: none;">
    <?php echo JS::import("form");?>
<div style="overflow: auto;width:900px;height: 320px;">
	<?php $query = new Query("doc_receiving as dr");$query->fields = "dr.*,py.pay_name,us.name,us.email,od.order_no,dr.pay_status as pay_status,od.type as order_type";$query->join = "left join user as us on dr.user_id = us.id left join payment as py on dr.payment_id = py.id left join order as od on dr.order_id = od.id";$query->where = "dr.id = $id";$items = $query->find();?>
	<?php $item = $items[0];?>
		<h3 class="lineD ">收款单详情：</h3>

		<table class="default">
		<tr><th width="100">订单编号：</th><td colspan=3><i class="icon-order-<?php echo isset($item['order_type'])?$item['order_type']:"";?>"></i><?php echo isset($item['order_no'])?$item['order_no']:'-';?></td></tr>
		<tr><th width="100">类型：</th><td><?php echo isset($item['doc_type']) && $item['doc_type']?'充值':'订单支付';?></td><th width="100">支付方式：</th><td  class="golden"><?php echo isset($item['pay_name'])?$item['pay_name']:"";?></td></tr>
		<tr><th>支付状态：</th><td class="golden"><?php echo isset($item['pay_status']) && $item['pay_status']?'已支付':'等待支付';?></td><th>金额：</th><td class="golden"><?php echo isset($item['amount'])?$item['amount']:"";?></td></tr>
		<tr><th width="100">用户：</th><td><?php echo isset($item['name'])?$item['name']:"";?></td><th width="100">邮件：</th><td><?php echo isset($item['email'])?$item['email']:"";?></td></tr>
		<tr><th>创建时间：</th><td><?php echo isset($item['create_time'])?$item['create_time']:"";?></td><th>付款时间：</th><td><?php echo isset($item['payment_time'])?$item['payment_time']:'-';?></td></tr>
		<tr><th>备注：</th><td colspan=3><?php echo isset($item['note'])?$item['note']:"";?></td></tr>
		</table>
</div>
</body>
</html>
<!--Powered by TinyRise-->