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
<form action="" method="post">
<div class="tools_bar clearfix">
    <a class="icon-checkbox-checked icon-checkbox-unchecked" href="javascript:;" onclick="tools_select('id[]',this)" title="全选" data="true"> 全选 </a>
    <a  class="icon-plus" href="<?php echo urldecode(Url::urlFormat("/content/ad_edit"));?>" title="添加"> 添加</a><a href="javascript:;" class="icon-loop-2" onclick="tools_reload()"> 刷新</a>
    
</div>
<table class="default" >
    <tr>
        <th style="width:30px">选择</th>
        <th style="width:70px">操作</th>
        <th>名称</th>
        <th style="width:100px">广告尺寸</th>
        <th style="width:100px">广告类型</th>
        
        <th style="width:80px">开始时间</th>
        <th style="width:80px">结束时间</th>
        <th style="width:60px">是否开启</th>
    </tr>
    <?php $item=null; $obj = new Query("ad");$obj->page = "1";$items = $obj->find(); foreach($items as $key => $item){?>
        <tr><td style="width:30px"><input type="checkbox" name="id[]" value="<?php echo isset($item['id'])?$item['id']:"";?>"></td>
          <td style="width:70px" class="btn_min"><div class="operat hidden"><a  class="icon-cog action" href="javascript:;"> 处理</a><div class="menu_select"><ul>
                <li><a class="icon-file-css" href="javascript:;" onclick="ad_show(<?php echo isset($item['id'])?$item['id']:"";?>)" title="添加"> 调用代码</a></li>
                <?php if($item['is_open']==0){?>
                <li><a class="icon-unlocked" href="javascript:;" onclick="change_open(<?php echo isset($item['id'])?$item['id']:"";?>,1)"> 开启</a></li>
                <?php }else{?>
                <li><a class="icon-lock-2" href="javascript:;" onclick="change_open(<?php echo isset($item['id'])?$item['id']:"";?>,0)"> 关闭</a></li>
                <?php }?>
                <li><a class="icon-pencil" href="<?php echo urldecode(Url::urlFormat("/content/ad_edit/id/$item[id]"));?>"> 编辑</a></li>
                <li><a class="icon-close" href="javascript:;" onclick="confirm_action('<?php echo urldecode(Url::urlFormat("/content/ad_del/id/$item[id]"));?>')"> 删除</a></li>
            </ul></div></div> </td>
          <td ><?php echo isset($item['name'])?$item['name']:"";?></td><td style="width:100px;"><?php echo isset($item['width'])?$item['width']:"";?> x <?php echo isset($item['height'])?$item['height']:"";?></td><td style="width:100px"><?php echo isset($parse_type[$item['type']])?$parse_type[$item['type']]:"";?></td><td style="width:80px"><?php echo substr($item['start_time'],0,16);?></td><td style="width:80px"><?php echo substr($item['end_time'],0,16);?></td><td style="width:60px"><?php echo isset($item['is_open']) && $item['is_open']?'<b class="green">开启</b>':'<b class="red">关闭</b>';?></td></tr>
    <?php }?>
</table>
</form>
<div class="page_nav">
<?php echo $obj->pageBar();?>
</div>
<script type="text/javascript">
  function change_open(id,is_open){
    $.post("<?php echo urldecode(Url::urlFormat("/content/change_open"));?>",{id:id,is_open:is_open},function(data){
        if(data['status']=='success')tools_reload();
        else art.dialog.tips("<p class='fail'>"+data['msg']+"</p>");
    },'json');
  }
  function ad_show(id){
        art.dialog.open("<?php echo urldecode(Url::urlFormat("/content/ad_show/id/"));?>"+id,{id:'edit_dialog',title:'调用代码',resize:false});
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