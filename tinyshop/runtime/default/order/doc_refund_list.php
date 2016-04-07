<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo isset($admin_title)?$admin_title:"";?>echo的二手店</title>
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
<?php echo JS::import('form');?>
<form action="" method="post">
<div class="tools_bar clearfix">
    <a class="icon-checkbox-checked icon-checkbox-unchecked" href="javascript:;" onclick="tools_select('id[]',this)" title="全选" data="true"> 全选 </a>
    <a class="icon-delicious" href="<?php echo urldecode(Url::urlFormat("/order/doc_refund_list"));?>"> 显示全部 </a>
    
    
    
</div>
<table class="default" >
    <tr>
        <th width="30">选择</th>
        <th style="width:70px">操作</th>
        <th >订单编号</th>
        <th width="100">退款类型</th>
        <th width="80">退款状态</th>
        <th width="160">申请日期</th>        
    </tr>
    <?php $item=null; $obj = new Query("doc_refund as dr");$obj->where = "$where";$obj->order = "id desc";$obj->page = "1";$items = $obj->find(); foreach($items as $key => $item){?>
        <tr><td width="30"><input type="checkbox" name="id[]" value="<?php echo isset($item['id'])?$item['id']:"";?>"></td>
            <td style="width:70px" class="btn_min"><div class="operat hidden"><a  class="icon-cog action" href="javascript:;"> 处理</a><div class="menu_select"><ul>
                <li><a href="javascript:view(<?php echo isset($item['id'])?$item['id']:"";?>)" class=" icon-eye"> 查看</a></li>
                <?php if($item['pay_status'] == 0){?>
                <li><a class="icon-credit" href="javascript:;" onclick="edit(<?php echo isset($item['id'])?$item['id']:"";?>)"> 退款</a></li>
                <?php }elseif($item['pay_status'] == 1){?>
                <li><a class="icon-credit" href="javascript:;" onclick="edit(<?php echo isset($item['id'])?$item['id']:"";?>)"> 重新退款</a></li>
                <?php }?>
            </ul></div></div> </td>
            <td ><?php echo isset($item['order_no'])?$item['order_no']:"";?></td>
            <td width="100"><?php echo $item['refund_type']!=0?($item['refund_type']==1?'银行卡':'其它方式'):'账户余额';?></td>
            <td width="80" id="pay_status_<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo $item['pay_status']!=0?($item['pay_status']==1?'<b class="red">不予退款</b>':'退款成功'):'<b class="golden">申请退款</b>';?></td>
            <td width="160"><?php echo isset($item['create_time'])?$item['create_time']:"";?></td>
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
        art.dialog.open("<?php echo urldecode(Url::urlFormat("/order/doc_refund_view/id/"));?>"+id,{id:'view_dialog',title:'查看退款单',resize:false,width:900,height:420});
    }
    function edit(id){
        art.dialog.open("<?php echo urldecode(Url::urlFormat("/order/doc_refund_edit/id/"));?>"+id,{id:'edit_dialog',title:'退款',resize:false,width:900,height:450});
        
    }
    function updateInfo(obj){
        var text = obj['pay_status']==1?'<b class="red">不予退款</b>':'退款成功';
        $("#pay_status_"+obj['id']).html(text);
        art.dialog.tips("<p class='success'>处理成功！</p>");
        art.dialog({id:'edit_dialog'}).close();
    }
   
$("#condition").on("click",function(){
  $("body").Condition({input:"#condition_input",okVal:'高级搜索',callback:function(data){tools_submit({action:'<?php echo urldecode(Url::urlFormat("/order/doc_refund_list"));?>',method:'get'});},data:{order_no:{name:'订单编号'},'dr.pay_status':{name:'退款状态',values:{0:'申请退款',1:'不予退款',2:'退款成功'}},'refund_type':{name:'退款方式',values:{0:'至账户余额',1:'至银行卡',2:'其它方式'}}
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