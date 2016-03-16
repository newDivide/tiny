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
<div style="overflow: auto;width:900px;height: 415px;">
	<h3 class="lineD">商品信息：</h3>
	<table class="default" id="attr_values">
		<tr><td width="40"></td><td width="120">货号</td><td>商品名</td><td>规格</td><td width="60">价格</td><td width="40">数量</td><td width="60">商品促销</td><td width="60">小计</td></tr>
		<?php $item=null; $query = new Query("order_goods as od");$query->fields = "go.img,go.name,pr.pro_no,od.spec,od.goods_price,od.goods_nums,od.prom_goods";$query->join = "left join products as pr on od.product_id = pr.id  left join goods as go on od.goods_id = go.id";$query->where = "order_id = $id";$items = $query->find(); foreach($items as $key => $item){?>
		<?php $spec = unserialize($item['spec']);?>
		<tr><td><img src="<?php echo Common::thumb($item['img'],100,100);?>" width="40"></td><td><?php echo isset($item['pro_no'])?$item['pro_no']:"";?></td><td><?php echo isset($item['name'])?$item['name']:"";?></td><td>
			<?php if(is_array($spec)){?>
			<?php foreach($spec as $key => $ite){?>
				<?php echo isset($ite['name'])?$ite['name']:"";?>:<?php echo isset($ite['value'][2])?$ite['value'][2]:"";?>
			<?php }?>
			<?php }?>
		</td><td><?php echo isset($item['goods_price'])?$item['goods_price']:"";?></td><td><?php echo isset($item['goods_nums'])?$item['goods_nums']:"";?></td><td><?php $prom=unserialize($item['prom_goods']);?><?php echo isset($prom['prom']['name'])?$prom['prom']['name']:"";?></td><td class="golden"><?php echo sprintf("%.2f",($item['goods_price']*$item['goods_nums']));?></td></tr>
		<?php }?>
	</table>


		<?php $item=null; $query = new Query("order as od");$query->fields = "od.*,ex.name as exname,py.pay_name as payname";$query->join = "left join express as ex on od.express = ex.express_company_id left join payment as py on od.payment = py.id";$query->where = "od.id = $id";$items = $query->find(); foreach($items as $key => $item){?>
		<form class="form2" action="<?php echo urldecode(Url::urlFormat("/order/doc_invoice_save"));?>" method="post" >
		<h3 class="lineD mt10">发货信息</h3>
		<table class="default">
		<tr><th width="100">订单编号：</th><td><?php echo isset($item['order_no'])?$item['order_no']:"";?><input type="hidden" name="order_no" value="<?php echo isset($item['order_no'])?$item['order_no']:"";?>"><input type="hidden" name="order_id" value="<?php echo isset($item['id'])?$item['id']:"";?>"><input type="hidden" name="delivery_status" value="<?php echo isset($item['delivery_status'])?$item['delivery_status']:"";?>"></td><th width="100">下单时间：</th><td><?php echo isset($item['create_time'])?$item['create_time']:"";?></td></tr>
		<tr><th>支付方式：</th><td><?php echo isset($item['payname'])?$item['payname']:"";?></td><th>配送费用：</th><td class="golden"><?php echo isset($item['payable_freight'])?$item['payable_freight']:"";?></td></tr>
		<tr><th><b class="red">*</b>物流公司：</th><td class="golden"><select name="express_company_id"><?php $itm=null; $query = new Query("express_company");$query->item = "$itm";$itms = $query->find(); foreach($itms as $key => $itm){?><option value="<?php echo isset($itm['id'])?$itm['id']:"";?>"><?php echo isset($itm['name'])?$itm['name']:"";?></option><?php }?></select></td><th><b class="red">*</b>物流单号：</th><td><input pattern="required" type="text" name="express_no"/></td></tr>
		<tr><th width="100"><b class="red">*</b>收货人姓名：</th><td><input pattern="required" type="text" name="accept_name" value="<?php echo isset($item['accept_name'])?$item['accept_name']:"";?>"/></td><th width="100"><b class="red">*</b>联系手机：</th><td><input pattern="mobi" type="text" name="mobile" value="<?php echo isset($item['mobile'])?$item['mobile']:"";?>"/></td></tr>
		<tr><th>联系电话：</th><td><input type="text" name="phone" value="<?php echo isset($item['phone'])?$item['phone']:"";?>"/></td><th>邮编：</th><td><input type="text" name="zip" value="<?php echo isset($item['zip'])?$item['zip']:"";?>" /></td></tr>
		<tr><th><b class="red">*</b>收货地区：</th><td colspan=3><select id="province"  name="province" >
        <option value="0">==省份/直辖市==</option>
        </select>
        <select id="city" name="city"><option value="0">==市==</option></select>
        <select id="county" name="county"><option value="0">==县/区==</option></select><input pattern="^\d+,\d+,\d+$" id="area" type="text" style="visibility:hidden;width:0;" value="<?php echo isset($item['province'])?$item['province']:"";?>,<?php echo isset($item['city'])?$item['city']:"";?>,<?php echo isset($item['county'])?$item['county']:"";?>" alt="请选择完整地区信息！"><label></label></td></tr>
		<tr><th><b class="red">*</b>收货地址：</th><td colspan=3><input pattern="required" type="text" name="addr" value="<?php echo isset($item['addr'])?$item['addr']:"";?>"></td></tr>
        <tr><th>用户备注：</th><td colspan=3><?php echo isset($item['user_remark'])?$item['user_remark']:"";?></td></tr>
		<tr><th>发货单备注：</th><td colspan=3><textarea name="remark"></textarea></td></tr>
		</table>
		<div class="alone_footer tc"><button class="focus_button" onclick="">发 货</button></div>
		</form>
		<?php }?>

</div>

<script type="text/javascript">
 $("#areas").Linkage({ url:"<?php echo urldecode(Url::urlFormat("/ajax/area_data"));?>",selected:[<?php echo isset($item['province'])?$item['province']:"";?>,<?php echo isset($item['city'])?$item['city']:"";?>,<?php echo isset($item['county'])?$item['county']:"";?>],callback:function(data){
    var text = new Array();
    var value = new Array();
    for(i in data[0]){
      if(data[0][i]!=0){
        text.push(data[1][i]);
        value.push(data[0][i]);
      }
    }
    $("#area").val(value.join(','));
    FireEvent(document.getElementById("area"),"change");
    }});
 function count_amount(){
 	var adjust = $("#adjust").val();
 	var oldVlaue = parseFloat(<?php echo isset($amount)?$amount:"";?>);
 	var order_amount = parseFloat(oldVlaue)+parseFloat(adjust);
 	if(order_amount<0)order_amount = 0.00;
 	$("#order_amount").text(order_amount);
 }
</script>

</body>
</html>
<!--Powered by TinyRise-->