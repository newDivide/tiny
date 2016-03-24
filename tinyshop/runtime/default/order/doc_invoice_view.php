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
<div style="overflow: auto;width:900px;height: 400px;">
		<?php $query = new Query("doc_invoice as od");$query->fields = "od.*,ex.name as exname";$query->join = "left join express_company as ex on od.express_company_id = ex.id";$query->where = "od.id = $id";$items = $query->find();?>
		<?php $invoice = $items[0]; $area_ids=array($invoice['province'],$invoice['city'],$invoice['county']);$area_ids = implode(',',$area_ids);$areas=array();?>
		<?php $item=null; $query = new Query("area");$query->where = "id in ($area_ids)";$items = $query->find(); foreach($items as $key => $item){?>
		<?php $areas[$item['id']]=$item['name'];?>
		<?php }?>
		<h3 class="lineD ">收货人信息：</h3>

		<table class="default">
		<tr><th width="120">订单编号：</th><td><?php echo isset($invoice['order_no'])?$invoice['order_no']:"";?></td><th width="120">发货单号：</th><td><?php echo isset($invoice['invoice_no'])?$invoice['invoice_no']:"";?></td></tr>
		<tr><th>物流公司：</th><td class="golden"><?php echo isset($invoice['exname'])?$invoice['exname']:"";?></td><th>物流单号：</th><td class="golden"><?php echo isset($invoice['express_no'])?$invoice['express_no']:"";?></td></tr>
		<tr><th width="100">收货人：</th><td><?php echo isset($invoice['accept_name'])?$invoice['accept_name']:"";?></td><th width="100">联系手机：</th><td><?php echo isset($invoice['mobile'])?$invoice['mobile']:"";?></td></tr>
		<tr><th>联系电话：</th><td><?php echo isset($invoice['phone'])?$invoice['phone']:"";?></td><th>邮编：</th><td><?php echo isset($invoice['zip'])?$invoice['zip']:"";?></td></tr>
		<tr><th>发货时间：</th><td><?php echo isset($invoice['create_time'])?$invoice['create_time']:"";?></td><th>发货人：</th><td><?php echo isset($invoice['admin'])?$invoice['admin']:"";?></td></tr>
		<tr><th>收货地址：</th><td colspan=3><?php echo isset($areas[$invoice['province']])?$areas[$invoice['province']]:"";?>,<?php echo isset($areas[$invoice['city']])?$areas[$invoice['city']]:"";?>,<?php echo isset($areas[$invoice['county']])?$areas[$invoice['county']]:"";?><?php echo isset($invoice['addr'])?$invoice['addr']:"";?></td></tr>
		</table>
	
	<h3 class="lineD mt10">商品详情：</h3>
	<table class="default" id="attr_values">
		<tr><td widtd="120">货号</td><td>商品名</td><td>规格</td><td widtd="60">价格</td><td widtd="40">数量</td><td widtd="60">小计</td></tr>
		<?php $item=null; $query = new Query("doc_invoice as di");$query->fields = "go.name,pr.pro_no,od.spec,od.goods_price,od.goods_nums";$query->join = "left join order_goods as od on od.order_id = di.order_id left join products as pr on od.product_id = pr.id  left join goods as go on od.goods_id = go.id";$query->where = "di.id = $id";$items = $query->find(); foreach($items as $key => $item){?>
		<?php $spec = unserialize($item['spec']);?>
		<tr><td><?php echo isset($item['pro_no'])?$item['pro_no']:"";?></td><td><?php echo isset($item['name'])?$item['name']:"";?></td><td>
			<?php if(is_array($spec)){?>
			<?php foreach($spec as $key => $ite){?>
				<?php echo isset($ite['name'])?$ite['name']:"";?>:<?php echo isset($ite['value'][2])?$ite['value'][2]:"";?>
			<?php }?>
			<?php }?>
		</td><td><?php echo isset($item['goods_price'])?$item['goods_price']:"";?></td><td><?php echo isset($item['goods_nums'])?$item['goods_nums']:"";?></td><td class="golden"><?php echo sprintf("%.2f",($item['goods_price']*$item['goods_nums']));?></td></tr>
		<?php }?>
	</table>
</div>
</body>
</html>
<!--Powered by TinyRise-->