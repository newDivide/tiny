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
<?php echo JS::import('form');?>
<?php echo JS::import('date');?>
<form action="" method="post">
<div class="tools_bar clearfix">
    <a  class="icon-plus" href="<?php echo urldecode(Url::urlFormat("/admin/fare_edit"));?>" title="添加"> 添加</a><a href="javascript:;" class="icon-loop-2"
onclick="tools_reload()"> 刷新</a>
</div>
</form>
<?php $item=null; $obj = new Query("fare");$obj->page = "1";$obj->pagesize = "3";$obj->order = "is_default desc";$items = $obj->find(); foreach($items as $key => $item){?>
<div class="btn_min" style="text-align: right;padding:5px 10px; margin-top:10px; margin-bottom:0; border:#dbdbdb 1px solid;border-bottom:0;background:#f7f7f7;"><span class="fl "><b class="foreColor"><?php echo isset($item['name'])?$item['name']:"";?></b></span> &nbsp;&nbsp;&nbsp;&nbsp;<a class="icon-pencil" href="<?php echo urldecode(Url::urlFormat("/admin/fare_edit/id/$item[id]"));?>"> 编辑</a><a class="icon-close" href="javascript:;" onclick="confirm_action('<?php echo urldecode(Url::urlFormat("/admin/fare_del/id/$item[id]"));?>')"> 删除</a></div>
<table class="default <?php if($item['is_default']==1){?>is-used<?php }?>" >
    <tr><th>运送到</th> <th style="width:100px;">首重(g)</th> <th style="width:100px;">运费(元)</th> <th style="width:100px;">续重(g)</th> <th style="width:100px;">运费(元)</th></tr>
    <tr><td>全国</td> <td><?php echo isset($item['first_weight'])?$item['first_weight']:"";?></td> <td><?php echo isset($item['first_price'])?$item['first_price']:"";?></td> <td><?php echo isset($item['second_weight'])?$item['second_weight']:"";?></td> <td><?php echo isset($item['second_price'])?$item['second_price']:"";?></td></tr>
    <?php $zoning = unserialize($item['zoning']);?>
    <?php foreach($zoning as $key => $area){?>
    <tr><td><?php echo isset($area['names'])?$area['names']:"";?></td> <td><?php echo isset($area['f_weight'])?$area['f_weight']:"";?></td> <td><?php echo isset($area['f_price'])?$area['f_price']:"";?></td> <td><?php echo isset($area['s_weight'])?$area['s_weight']:"";?></td> <td><?php echo isset($area['s_price'])?$area['s_price']:"";?></td></tr>
    <?php }?>
    <?php if($item['is_default']!=1){?>
    <tr> <td colspan="5"><a href="<?php echo urldecode(Url::urlFormat("/admin/fare_use/id/$item[id]"));?>" class="button focus_button fr">使用此模板</a></td> </tr>
    <?php }?>
</table>
<?php }?>
<div class="page_nav">
<?php echo $obj->pageBar();?>
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