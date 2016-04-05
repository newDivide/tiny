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
<div style="overflow: auto;width:900px;height: 420px;">
	<?php $query = new Query("doc_refund as dr");$query->fields = "dr.*,us.name as uname, ma.name as mname";$query->join = "left join user as us on dr.user_id = us.id left join manager as ma on dr.admin_id = ma.id";$query->where = "dr.id = $id";$items = $query->find();?>
	<?php $item = $items[0];?>
		<h3 class="lineD ">退款单详情：</h3>

		<table class="default no_lr_border">
		<tr><th width="100">订单编号：</th><td><?php echo isset($item['order_no'])?$item['order_no']:'-';?></td><th width="100">申请人：</th><td><?php echo isset($item['uname'])?$item['uname']:"";?></td></tr>
		<tr><th>申请退款至：</th><td><?php echo $item['refund_type']!=0?($item['refund_type']==1?'银行卡':'其它方式'):'账户余额';?></td><th>退款状态：</th><td class="golden"><?php echo $item['pay_status']!=0?($item['pay_status']==1?'<b class="red">不予退款</b>':'退款成功'):'<b class="golden">申请退款</b>';?></td></tr>
		<tr><th>开户名：</th><td class="golden"><?php echo isset($item['account_name'])?$item['account_name']:'-';?></td><th><?php if($item['refund_type']==2){?>支付方式<?php }else{?>开户行<?php }?>：</th><td class="golden"><?php echo isset($item['account_bank'])?$item['account_bank']:'-';?></td></tr>
		<?php if($item['pay_status']==2){?>
		<tr><th width="100">账号：</th><td><?php echo isset($item['refund_account'])?$item['refund_account']:'-';?></td><th width="100">申请时间：</th><td><?php echo isset($item['create_time'])?$item['create_time']:"";?></td></tr>
		<tr><th>退款渠道：</th><td><?php echo isset($item['channel'])?$item['channel']:'-';?></td><th>退款账号：</th><td><?php echo isset($item['bank_account'])?$item['bank_account']:'-';?></td></tr>
		<?php }?>
		<tr><th>管理员：</th><td><?php echo isset($item['mname'])?$item['mname']:'-';?></td><th>处理时间：</th><td><?php echo isset($item['handling_time'])?$item['handling_time']:'-';?></td></tr>
		<tr><th colspan=4>申请原因：</th></tr>
		<tr><td colspan=4><?php echo isset($item['content'])?$item['content']:"";?></td></tr>
		<tr><th colspan=4>处理意见：</th></tr>
		<tr><td colspan=4><?php echo isset($item['handling_idea'])?$item['handling_idea']:"";?></td></tr>
		</table>

		<?php $item=null; $query = new Query("doc_refund as dr");$query->fields = "od.*,ex.name as exname,py.pay_name as payname";$query->join = "left join order as od on dr.order_id = od.id left join express as ex on od.express = ex.express_company_id left join payment as py on od.payment = py.id";$query->where = "dr.id = $id";$items = $query->find(); foreach($items as $key => $item){?>
		<?php $amount = $item['order_amount'];?>
		<h3 class="lineD mt10">订单信息：</h3>
		<table class="default">
		<tr><th width="100">订单编号：</th><td><i class="icon-order-<?php echo isset($item['type'])?$item['type']:"";?>"></i><?php echo isset($item['order_no'])?$item['order_no']:"";?></td><th width="100">下单时间：</th><td><?php echo isset($item['create_time'])?$item['create_time']:"";?></td></tr>
		<tr><th>支付方式：</th><td><?php echo isset($item['payname'])?$item['payname']:"";?></td><th>支付手续费：</th><td class="golden"><?php echo isset($item['handling_fee'])?$item['handling_fee']:"";?></td></tr>
		<tr><th>订单状态：</th><td colspan="3"><?php echo $this->parseOrderStatus($item);?></td></tr>
		<tr><th>配送方式：</th><td><?php echo isset($item['exname'])?$item['exname']:"";?></td><th>配送费用：</th><td class="golden"><?php echo isset($item['payable_freight'])?$item['payable_freight']:"";?></td></tr>
		<tr><th>实际配送费用：</th><td class="golden"><?php echo isset($item['real_freight'])?$item['real_freight']:"";?></td><th>代金券：</th><td class="golden"><?php if($item['voucher_id']){?><?php $voucher=unserialize($item['voucher']);?><?php echo isset($voucher['value'])?$voucher['value']:"";?><?php }else{?>-<?php }?></td></tr>
		<tr><th>应付商品总金额：</th><td class="golden"><?php echo isset($item['payable_amount'])?$item['payable_amount']:"";?></td><th>实付商品总金额：</th><td class="golden"><?php echo isset($item['real_amount'])?$item['real_amount']:"";?></td></tr>
		<tr><th>发票税金：</th><td class="golden"><?php echo isset($item['taxes'])?$item['taxes']:"";?></td><th>活动优惠金额：</th><td class="golden"><?php echo isset($item['discount_amount'])?$item['discount_amount']:"";?></td></tr>
		<tr><th>原订单总金额：</th><td colspan=3  class="golden"><?php echo sprintf("%.2f",$amount);?> 注：记订单在未调价之前的总金额</td></tr>
		<tr><th>订单折扣或涨价：</th><td colspan=3 ><?php echo isset($item['adjust_amount'])?$item['adjust_amount']:0;?></td></tr>
		<tr><th>调整后订单总金额：</th><td colspan=3   ><span style="display: inline-block;width: 100px" class="golden" id="order_amount"><?php echo isset($item['order_amount'])?$item['order_amount']:"";?> </span> 注：总金额不会小于0元</td></tr>
		<tr><th>调价原因：</th><td colspan=3><?php echo isset($item['adjust_note'])?$item['adjust_note']:"";?></td></tr>
		</table>
		<?php }?>

		<h3 class="lineD mt10">所购商品详情：</h3>
	<table class="default" id="attr_values">
		<tr><td style="width:120px;">货号</td><td>商品名</td><td style="width:60px;">规格</td><td style="width:60px;">价格</td><td style="width:40px;">数量</td><td style="width:60px;">小计</td></tr>
		<?php $item=null; $query = new Query("doc_refund as dr");$query->fields = "go.name,pr.pro_no,od.spec,od.goods_price,od.goods_nums,dr.id";$query->join = "left join order_goods as od on dr.order_id = od.order_id left join products as pr on od.product_id = pr.id  left join goods as go on od.goods_id = go.id";$query->where = "dr.id = $id";$items = $query->find(); foreach($items as $key => $item){?>
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