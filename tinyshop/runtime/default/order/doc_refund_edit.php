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
    <?php echo JS::import('form');?>
<div style="overflow: auto;width:900px;height: 380px;border:none;margin-top:40px;">
	<table class="default mt10" id="attr_values" style="border-left:none;border-right:none;">
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
	<?php $query = new Query("doc_refund as dr");$query->fields = "dr.*,od.status,od.delivery_status,us.name as uname, ma.name as mname,od.real_amount,od.real_freight,od.handling_fee,od.taxes,od.adjust_amount,od.order_amount,od.order_amount,od.discount_amount";$query->join = "left join user as us on dr.user_id = us.id left join manager as ma on dr.admin_id = ma.id left join order as od on dr.order_no = od.order_no";$query->where = "dr.id = $id";$items = $query->find();?>
	<?php $item = $items[0];?>
		<h3 class="lineD alone_header ">退款单详情：</h3>
		<form class="form2 mt10 " action="<?php echo urldecode(Url::urlFormat("/order/doc_refund_save"));?>" method="post">
			<input name="id" type="hidden" value="<?php echo isset($id)?$id:"";?>">
		<table class="default no_lr_border">
		<tr><th width="100">订单编号：</th><td><?php echo isset($item['order_no'])?$item['order_no']:'-';?></td><th width="100">申请人：</th><td><?php echo isset($item['uname'])?$item['uname']:"";?></td></tr>
		<tr><th>订单状态：</th><td colspan="3"><?php echo $this->parseOrderStatus($item);?></td></tr>
		<tr><th>退款到：</th><td><?php echo $item['refund_type']!=0?($item['refund_type']==1?'银行卡':'其它方式'):'账户余额';?></td><th>退款状态：</th><td class="golden"><?php echo $item['pay_status']!=0?($item['pay_status']==1?'<b class="red">不予退款</b>':'退款成功'):'<b class="golden">申请退款</b>';?></td></tr>
		<tr><th>开户名：</th><td class="golden"><?php echo isset($item['account_name'])?$item['account_name']:'-';?></td><th><?php if($item['refund_type']==2){?>支付方式<?php }else{?>开户行<?php }?>：</th><td class="golden"><?php echo isset($item['account_bank'])?$item['account_bank']:'-';?></td></tr>
		<tr><th width="100">账号：</th><td><?php echo isset($item['refund_account'])?$item['refund_account']:'-';?></td><th width="100">申请时间：</th><td><?php echo isset($item['create_time'])?$item['create_time']:"";?></td></tr>
		<tr><th colspan=4>申请原因：</th></tr>
		<tr><td colspan=4><?php echo isset($item['content'])?$item['content']:"";?></td></tr>
		
		<tr><th width="100">实付商品金额：</th><td><?php echo isset($item['real_amount'])?$item['real_amount']:'-';?></td><th width="100">实付运费金额：</th><td><?php echo isset($item['real_freight'])?$item['real_freight']:"";?></td></tr>
		<tr><th width="100">保价：</th><td>-</td><th width="100">手续费：</th><td><?php echo isset($item['handling_fee'])?$item['handling_fee']:"";?></td></tr>
		<tr><th width="100">税金：</th><td><?php echo isset($item['taxes'])?$item['taxes']:'-';?></td><th width="100">调价：</th><td><?php echo isset($item['adjust_amount'])?$item['adjust_amount']:"";?></td></tr>
		<tr><th width="100">订单总金额：</th><td><?php echo isset($item['order_amount'])?$item['order_amount']:'-';?></td><th width="100">优惠金额：</th><td><?php echo isset($item['discount_amount'])?$item['discount_amount']:"";?></td></tr>
		<tr><th >处理方式：</th><td colspan=3><input name="pay_status" type="radio" value="2" checked="checked" ><label>同意</label> <input name="pay_status" type="radio" value="1" <?php if($item['pay_status']==1){?> checked="checked" <?php }?>><label>拒绝</label> <label class="red">(注：这里只是对退款申请的处理，实际退款，要到会员中心或银行等退款处理)</label></td></tr>
		<tr class="channel_tr"><th >退款渠道：</th><td colspan=3><input name="channel" pattern="required" type="text"  value="<?php echo isset($item['channel'])?$item['channel']:"";?>" alt="退款渠道不能为空"> <label>如银行名，账户余额、支付宝等</label></td></tr>
		<tr class="channel_tr"><th width="100">退款到账号：</th><td><input name="bank_account" value="<?php echo isset($item['bank_account'])?$item['bank_account']:"";?>" pattern="required" type="text"></td><th width="100">退款金额：</th><td><input name="amount" pattern="float" value="<?php echo isset($item['amount'])?$item['amount']:"";?>" type="text"></td></tr>
		<tr><th colspan=4>处理意见：</th></tr>
		<tr><td colspan=4><textarea name="handling_idea" pattern="required" alt="处理信息不能为空！" > <?php echo isset($item['handling_idea'])?$item['handling_idea']:"";?></textarea> <label></label></td></tr>

		</table>
			<div class="alone_footer tc"><button class="focus_button" onclick="">处 理</button></div>
		    
		</form>

</div>
<script type="text/javascript">
	function actionChange(status){
		if(status==2){
			$(".channel_tr").css("display","")
			$(".channel_tr").find("input").removeAttr("disabled");
		}else{
			$(".channel_tr").css("display","none");
			$(".channel_tr").find("input").attr("disabled","disabled");
		}
		
	}
	$("input:[name='pay_status']").on("change",function(){
		actionChange($(this).val());
	})
	 <?php if($item['pay_status']==1){?>
	 	actionChange(1);
	 <?php }?>
</script>
</body>
</html>
<!--Powered by TinyRise-->