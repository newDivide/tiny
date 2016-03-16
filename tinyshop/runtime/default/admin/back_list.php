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
<?php echo JS::import('validator');?>
<form id="main_form" action="<?php echo urldecode(Url::urlFormat("/admin/zip"));?>" method="post">
<div class="tools_bar">
    <a class="icon-checkbox-checked icon-checkbox-unchecked" href="javascript:;" onclick="tools_select('back[]',this)" title="全选" data="true"> 全选 </a>
    <a  class="icon-download-2" href="javascript:;" onclick="tools_submit()" title="打包下载"><i>下载</i></a>
    <a  class="icon-remove-2" href="javascript:;" onclick="tools_submit({action:'<?php echo urldecode(Url::urlFormat("/admin/back_del"));?>',msg:'删除后无法恢复，你真的删除吗？',select_id:'back'})" title="删除"><i>删除</i></a>
    <a  class="icon-upload" href="javascript:;" onclick="upload_recover();return false;" title="本地导入"><i>导入</i></a>
</div>
<table class="default">
    <tr>
        <th style="width:30px">选择</th>
        <th style="width:70px">操作</th>
        <th>文件名</th>
        <th style="width:100px">文件大小</th>
        
    </tr>
    <?php foreach($files as $key => $item){?>
        <?php $file_name = basename($item);?>
        <tr><td><input type="checkbox" value="<?php echo isset($file_name )?$file_name :"";?>" name="back[]" ></td>
        <td style="width:70px" class="btn_min"><div class="operat hidden"><a  class="icon-cog action" href="javascript:;"> 处理</a><div class="menu_select"><ul>
                <li><a href="<?php echo urldecode(Url::urlFormat("/admin/down/back/$file_name"));?>" class="icon-download-2"> 下载</a></li>
               <li><a href="javascript:confirm_action('<?php echo urldecode(Url::urlFormat("/admin/back_del?back=$file_name"));?>')" class="icon-remove-2"> 删除</a></li>
               <li><a href="javascript:confirm_action('<?php echo urldecode(Url::urlFormat("/admin/back_recover?back=$file_name"));?>','你确定要还原吗？')" class="icon-undo"> 还原</a></li>
            </ul></div></div> </td>
        <td><?php echo isset($file_name)?$file_name:"";?></td>
        <td><?php echo intval(filesize($item)/1024).'K';?></td>
        </tr>
    <?php }?>
</table>
</form>
<div id="dialog_form" style="display:none">
<form action="<?php echo urldecode(Url::urlFormat("/admin/upload_recover"));?>" method="post" enctype="multipart/form-data" >
    <input name="sqlfile" type="file">
    <input type="submit" value="上传" class="button" />
</form>
</div>
<script>
function upload_recover()
{
    art.dialog({title:"恢复数据库：",content:document.getElementById("dialog_form")});
}
    
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