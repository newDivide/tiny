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
<?php echo JS::import('date');?>
<div class="tab">
<ul class="tab-head">
    <li>正在使用支付</li>
   <!--  <li>全部支付方式</li> -->
</ul>
<div class="tab-body">
    <div>
        <table class="default" >
            <tr>
                <th colspan="2">支付方式</th>
                <th style="width:120px">状态</th>  
                <th style="width:120px">操作</th>                
            </tr>
        </table>
        <div style="overflow: auto; height: 480px;">
        <table class="default" style="border-top: 0">
            <?php foreach($payment_list as $key => $item){?>
            <?php if(class_exists('pay_'.$item['class_name'])){?>
                <tr>
                  <td style="width:160px" class="btn_min"><?php echo isset($item['pay_name'])?$item['pay_name']:"";?></td>
                  <td  class="btn_min"><img src="<?php echo urldecode(Url::urlFormat("@protected/classes/$item[logo]"));?>"></td>
                  <td style="width:120px"><?php if($item['status']==0){?>已开启<?php }else{?>已关闭<?php }?></td>
                  <td class="btn_min" style="width:120px"><a class="icon-pencil" href="<?php echo urldecode(Url::urlFormat("/admin/payment_edit/id/$item[id]"));?>"> 配制</a> <a class="icon-remove-2" href="javascript:confirm_action('<?php echo urldecode(Url::urlFormat("/admin/payment_del/id/$item[id]"));?>')"> 删除</a></td></tr>
            <?php }?>
            <?php }?>
            </table>
        </div>
    </div>
    <div>
        <form action="" method="post">
        <table class="default" >
            <tr>
                <th colspan="2" style="width:320px;">支付方式</th>
                <th>支付描述</th>
                <th style="width:80px">操作</th>                
            </tr>
        </table>
        <div style="overflow: auto; height: 480px;">
        <table class="default" style="border-top: 0">
            <?php $item=null; $query = new Query("pay_plugin");$query->order = "id";$items = $query->find(); foreach($items as $key => $item){?>
                <tr>
                  <td style="width:160px" class="btn_min"><img src="<?php echo urldecode(Url::urlFormat("@protected/classes/$item[logo]"));?>"></td>
                  <td style="width:160px" class="btn_min"><?php echo isset($item['name'])?$item['name']:"";?></td>
                  <td><?php echo isset($item['description'])?$item['description']:"";?></td>
                  <td style="width:80px;"><a href="<?php echo urldecode(Url::urlFormat("/admin/payment_edit/plugin_id/$item[id]"));?>">添加</a></td></tr>
            <?php }?>
        </table>
        </div>
        </form>
    </div>
</div>
</div>
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