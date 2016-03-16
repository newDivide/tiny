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
<style type="text/css">
	#themes-list{margin: auto; text-align: center;}
	#themes-list .card-wrapper {width: 363px; float: left; margin-left: 12px; }
	#themes-list .card {position: relative; transition: all 0.3s; filter: alpha(opacity=70); -moz-opacity: 0.7; opacity: 0.7; margin-bottom: 8px; border:#bbb 1px solid;display: block;border-radius: 4px;}
	#themes-list .card:hover, #themes-list .card.current {filter: alpha(opacity=100); -moz-opacity: 1; opacity: 1; }
	#themes-list .card.current:hover .action{display: block;}
	#themes-list .card.current i.selected{display: block;}
	#themes-list .card i.selected{display: none; position: absolute; bottom: 0; right: 0; color: transparent; padding: 7px 15px; font-size: 20px; transition: all 0.3s; z-index: 10; border-top-left-radius: 80px; background: #7c0000; color: #FFF; }
	#themes-list .card .action {display: none; position: absolute; top: 36px; left: 0; right: 0; z-index: 999; text-align: center; width: 100%; }
	#themes-list .card .action .btn{padding: 10px;font-size: 18px;}
</style>
<div class="clearfix">
<h2 class="page_title">主题设置</h2>
<div class="tab">
	<ul class="tab-head">
		<li>PC主题</li>
		<li>移动主题</li>
	</ul>
	<div class="tab-body">
		<div id="themes-list" >
		<?php foreach($themes_pc as $key => $item){?>
		<div class="card-wrapper"><a id="<?php echo isset($item['file'])?$item['file']:"";?>" class="card theme_pc <?php if($current_theme_pc==$item['file']){?>current<?php }?>" href="javascript:;">
		<img src="<?php echo urldecode(Url::urlFormat("@themes/$item[file]/preview.jpg"));?>">
		<i class="icon-checkmark selected"></i>
		<div class="action"><span class="btn btn-preview btn-orange"><i class="icon-eye-2"></i> 前台预览</span></div>
		</a><div class="tc"><?php echo isset($item['info']['name'])?$item['info']['name']:"";?></div></div>
		<?php }?>
		</div>
		<div id="themes-list" >
		<?php foreach($themes_mobile as $key => $item){?>
		<div class="card-wrapper"><a id="<?php echo isset($item['file'])?$item['file']:"";?>" class="card theme_mobile <?php if($current_theme_mobile==$item['file']){?>current<?php }?>" href="javascript:;">
		<img src="<?php echo urldecode(Url::urlFormat("@themes/$item[file]/preview.jpg"));?>">
		<i class="icon-checkmark selected"></i>
		<div class="action"><span class="btn btn-preview btn-orange"><i class="icon-eye-2"></i> 前台预览</span></div>
		</a><div class="tc"><?php echo isset($item['info']['name'])?$item['info']['name']:"";?></div></div>
		<?php }?>
		</div>
	</div>
</div>

</div>
<script>
	$(".theme_pc").on("click",function () {
		var that = $(this);
		that.removeClass("current");
		var theme = that.attr("id");
		$.post("<?php echo urldecode(Url::urlFormat("/admin/set_theme"));?>",{theme:theme,type:'pc'},function(data){
			if(data['status']=='success'){
				art.dialog.tips('<p class="success">PC主题设置成功！</p>');
				that.addClass("current");
			}
		},'json')
	})
	$(".theme_mobile").on("click",function () {
		var that = $(this);
		that.removeClass("current");
		var theme = that.attr("id");
		$.post("<?php echo urldecode(Url::urlFormat("/admin/set_theme"));?>",{theme:theme,type:'mobile'},function(data){
			if(data['status']=='success'){
				art.dialog.tips('<p class="success">移动主题设置成功！</p>');
				that.addClass("current");
			}
		},'json')
	})
	$('.btn-preview').on("click",function(e){
		window.open('<?php echo urldecode(Url::urlFormat("/index/index"));?>','_blank');
		return false;
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