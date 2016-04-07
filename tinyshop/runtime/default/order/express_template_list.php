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
<form action="" method="post">
<div class="tools_bar clearfix">
    <a class="icon-checkbox-checked icon-checkbox-unchecked" href="javascript:;" onclick="tools_select('id[]',this)" title="全选" data="true"> 全选 </a>
    <a  class="icon-remove-2" href="javascript:;" onclick="tools_submit({action:'<?php echo urldecode(Url::urlFormat("/order/express_template_del"));?>',msg:'删除后无法恢复，你真的删除吗？'})" title="删除"> 删除</a>
    <a href='<?php echo urldecode(Url::urlFormat("/order/express_template_edit"));?>' class="icon-plus" > 添加</a>
</div>
<table class="default" >
    <tr>
        <th width="30">选择</th>
        <th width="70">操作</th>
        <th >模板名称</th>
        <th width="60">是否默认 </th>
    </tr>
    <?php $item=null; $obj = new Query("express_template");$obj->page = "1 desc";$items = $obj->find(); foreach($items as $key => $item){?>
        <tr><td width="30"><input type="checkbox" name="id[]" value="<?php echo isset($item['id'])?$item['id']:"";?>"></td>
            <td width="70" class="btn_min"><div class="operat hidden"><a  class="icon-cog action" href="javascript:;"> 处理</a><div class="menu_select"><ul>
                        <li><a href="<?php echo urldecode(Url::urlFormat("/order/express_template_edit/id/$item[id]"));?>"> 编辑</a></li>
                        <li><a href="javascript:confirm_action('<?php echo urldecode(Url::urlFormat("/order/express_template_del/id/$item[id]"));?>')" > 删除</a></li>
                        
                    </ul></div></div> </td>
            <td ><?php echo isset($item['name'])?$item['name']:"";?></td><td width="60"><?php if($item['is_default']){?><span class="icon-checkmark"></span><?php }?></td></tr>
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
    function edit(id){
        art.dialog.open("<?php echo urldecode(Url::urlFormat("/order/order_edit/id/"));?>"+id,{id:'edit_dialog',title:'订单编辑',resize:false,width:900,height:450});
    }
    function send(id){
        art.dialog.open("<?php echo urldecode(Url::urlFormat("/order/order_send/id/"));?>"+id,{id:'send_dialog',title:'发货',resize:false,width:900,height:450});
    }
    function change_status(id,status,op){
        var title = '';
        if(status==null){
            if(op=='del') title = '删除订单';
            else if(op=='note') title = '备注订单';
        }else{
            if(status == 3) title = '审核订单';
            else if(status == 4) title = '完成订单';
            else if(status == 6) title = '作废订单';
        }
        $("#order_id").val(id);
        $("#order_status").val(status);
        $("#order_op").val(op);
        art.dialog({id:'status_dialog',title:title,resize:false,width:500,height:250,content:document.getElementById('status_dialog')});
    }
    function submit_status(){
        var remark= $("#order_remark").val();
        var id = $("#order_id").val();
        var status = $("#order_status").val();
        var op = $("#order_op").val();
        if(remark != ''){
            $.post('<?php echo urldecode(Url::urlFormat("/order/order_status"));?>',{id:id,status:status,op:op,remark:remark},function(data){
                art.dialog({id:'status_dialog'}).close();
                if(data['status']=='success'){
                     alert(data['msg']+"成功！");
                }else{
                     alert(data['msg']+"失败！");
                }
                tools_reload();
            },'json');
        }else{
            art.dialog.tips("<p class='warning'>备注信息不能为空!</p>");
        }
        
    }
    function send_close(){
        art.dialog({id:'send_dialog'}).close();
        art.dialog.tips("<p class='sucess'>发货成功！</p>");
    }
    function close(){
        art.dialog({id:'edit_dialog'}).close();
        art.dialog.tips("<p class='sucess'>订单编辑成功！</p>");
    }
    $("#condition").on("click",function(){
  $("body").Condition({input:"#condition_input",data:{user_id:{name:'用户编号'},real_name:{name:'真实姓名'},mobile:{name:'电话'},sex:{name:'性别',values:{0:"女",1:'男'}}}});
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