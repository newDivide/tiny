<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo isset($admin_title)?$admin_title:"";?>-TinyShop商城</title>
<meta name="author" content="designer:webzhu, date:2012-03-23" />
<link type="image/x-icon" href="<?php echo urldecode(Url::urlFormat("@favicon.ico"));?>" rel="icon">
<link rel="stylesheet" type="text/css" href="<?php echo urldecode(Url::urlFormat("@static/css/base.css"));?>" />
<link rel="stylesheet" type="text/css" href="<?php echo urldecode(Url::urlFormat("@static/css/admin.css"));?>" />
<link rel="stylesheet" type="text/css" href="<?php echo urldecode(Url::urlFormat("@static/css/font_icon.css"));?>" />
<?php echo JS::import('jquery');?>
<script type="text/javascript" src="<?php echo urldecode(Url::urlFormat("@static/js/common.js"));?>"></script>
<!--[if lte IE 7]><script src="<?php echo urldecode(Url::urlFormat("@static/css/fonts/lte-ie7.js"));?>"></script><![endif]-->
</head>
<body >
<div id="header">
	<div class="nav_sub">
			    	您好[<?php echo isset($manager['name'])?$manager['name']:"";?>]&nbsp; | <a href="<?php echo urldecode(Url::urlFormat("/index/index"));?>" target="_blank">返回前台</a> | <a href="<?php echo urldecode(Url::urlFormat("/admin/logout"));?>">退出</a>
	</div>
    <div id="Logo"><a href=""><img src="<?php echo urldecode(Url::urlFormat("@static/images/logo_min.png"));?>"></a></div>
	<ul id="main_nav" class="clearfix">
	<?php foreach($mainMenu as $key => $item){?>
		<li <?php if($key==$menu_index['menu']){?>class="active"<?php }?>><a href="<?php echo urldecode(Url::urlFormat("$item[link]"));?>"  ><?php echo isset($item['name'])?$item['name']:"";?></a></li>
	<?php }?>
	</ul>
</div>
<div id="mainContent">
	<div id="sidebar" >
		<ul class="menu" style="margin-top:15px;">
		<?php foreach($subMenu as $key => $item){?>
			<li class="submenu">
			<ul><li class="sub-index"><b><a href="javascript:;"><?php echo isset($item['name'])?$item['name']:"";?></a></b></li>
			<?php foreach($menu->getNodes($item['link']) as $key => $item){?>
			<?php if(substr($item['link'],-5)!='_edit' && !$item['hidden'] ){?>
				<li><a href='<?php echo urldecode(Url::urlFormat("$item[link]"));?>' <?php if($item['link']==$nav_link){?>class="current"<?php }?> ><?php echo isset($item['name'])?$item['name']:"";?></a></li>
				<?php }?>
			<?php }?>
			</ul>
			</li>
		<?php }?>
		</ul>
	</div>
	<div id="content" >

		<?php if(!isset($msg)){?><?php $msg=Req::post('msg');?><?php }?>
		<?php if(!isset($validator)){?><?php $validator=Req::post('validator');?><?php }?>
		<?php if(isset($msg[0])){?>
		<div id="message-bar" class="message_<?php echo isset($msg[0])?$msg[0]:"";?>"><?php echo isset($msg[1])?$msg[1]:"";?></div>
		<?php }elseif(isset($validator)){?>
		<div class="message_warning"><?php echo isset($validator['msg'])?$validator['msg']:"";?></div>
		<?php }?>
		<?php echo JS::import('dialog?skin=brief');?>
<?php echo JS::import('dialogtools');?>
<form action="" method="post">
<div class="tools_bar clearfix">
    <a class="icon-checkbox-checked icon-checkbox-unchecked" href="javascript:;" onclick="tools_select('id[]',this)" title="全选" data="true"> 全选 </a>
    <a class="icon-delicious" href="<?php echo urldecode(Url::urlFormat("/order/doc_receiving_list"));?>"> 显示全部 </a>
    
   <!--   -->
    
</div>
<table class="default" >
    <tr>
        <th width="30">选择</th>
        <th width="70">查看</th>
        <th width="100">类型</th>
        <th width="100">支付方式</th>
        <th width="80">支付状态</th>
        <th width="80">金额</th>
        <th width="80">用户</th>
        <th width="120">订单编号</th>
        <th width="80">付款时间</th>
        
    </tr>
    <?php $item=null; $obj = new Query("doc_receiving as dr");$obj->fields = "dr.id,dr.doc_type,py.pay_name,dr.amount,us.name,od.order_no,dr.create_time,dr.payment_time,dr.pay_status as pay_status";$obj->join = "left join user as us on dr.user_id = us.id left join payment as py on dr.payment_id = py.id left join order as od on dr.order_id = od.id";$obj->where = "$where";$obj->page = "1";$obj->order = "dr.id desc";$items = $obj->find(); foreach($items as $key => $item){?>
        <tr><td width="30"><input type="checkbox" name="id[]" value="<?php echo isset($item['id'])?$item['id']:"";?>"></td>
            <td width="70"><a href="javascript:view(<?php echo isset($item['id'])?$item['id']:"";?>)" class=" icon-eye"> 查看</a></td>
            <td width="100"><?php echo isset($item['doc_type']) && $item['doc_type']?'充值':'订单支付';?></td>
            <td width="100"><?php echo isset($item['pay_name'])?$item['pay_name']:"";?></td>
            <td width="80"><?php echo isset($item['pay_status']) && $item['pay_status']?'已支付':'等待支付';?></td>
            <td width="80"><?php echo isset($item['amount'])?$item['amount']:"";?></td>
            <td width="80"><?php echo isset($item['name'])?$item['name']:"";?></td>
            <td width="120"><?php echo isset($item['order_no'])?$item['order_no']:'－';?></td>
            <td width="80"><?php echo substr($item['payment_time'],0,10);?></td>
            </tr>
    <?php }?>
</table>
</form>
<div class="page_nav">
<?php echo $obj->pageBar();?>
</div>
<div id="status_dialog" style="display: none; position: relative;" class="form2">
    <h3 id="order_title">备注信息：</h3>
        <input type="hidden" name="id" id="order_id" value="">
        <input type="hidden" name="status" id="order_status" value="">
        <input type="hidden" name="op" id="order_op" value="">
        <textarea id="order_remark" name="remark"></textarea>
    <div class="tc"><button class="focus_button" onclick="submit_status()">保存</button></div>
</div>
<script type="text/javascript">
    function view(id){
        art.dialog.open("<?php echo urldecode(Url::urlFormat("/order/doc_receiving_view/id/"));?>"+id,{id:'view_dialog',title:'查看发货单',resize:false,width:900,height:320});
    }
   <?php $payment="";?>
    <?php $item=null; $query = new Query("payment");$items = $query->find(); foreach($items as $key => $item){?>
        <?php $payment.=$item['id'].':'."'".$item['pay_name']."',";?>
    <?php }?>
    <?php $payment=trim($payment,',');?>
    $("#condition").on("click",function(){
  $("body").Condition({input:"#condition_input",okVal:'高级搜索',callback:function(data){tools_submit({action:'<?php echo urldecode(Url::urlFormat("/order/doc_receiving_list"));?>',method:'get'});},data:{order_no:{name:'订单编号'},'dr.doc_type':{name:'单据类型',values:{0:'订单付款',1:'充值'}},'dr.pay_status':{name:'支付状态',values:{0:'等待支付',1:'已支付'}},'dr.payment_id':{name:'支付方式',values:{<?php echo isset($payment)?$payment:"";?>}}
  }});
})
</script>
	</div>
</div>
<script type="text/javascript">
	$(function () {
		if('<?php echo Req::args("con");?>'=='admin'){
			$(".submenu .current").parent().parent().parent().addClass('current');
		}else{
			$(".submenu").addClass('current');
		}
		$(".submenu .sub-index").on("click",function(){
			$(this).parent().parent().toggleClass('current');
		})
	})

</script>
</body>
</html>

<!--Powered by TinyRise-->