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
		<?php echo JS::import('form');?>
<h1 class="page_title">导航编辑</h1>
<div id="obj_form" class="form2">
    <form action="<?php echo urldecode(Url::urlFormat("/content/nav_save"));?>" method="post" >
        <?php if(isset($id)){?><input type="hidden" name="id" value="<?php echo isset($id)?$id:"";?>"><?php }?>
    <dl class="lineD">
      <dt>导航名称：</dt>
      <dd>
        <input name="name" type="text" pattern="required" value="<?php echo isset($name)?$name:"";?>">
        <label>导航名称</label>
      </dd>
      </dl>
       <dl class="lineD">
      <dt>连接地址：</dt>
      <dd>
        <input name="link" type="text" class="big" pattern="required" value="<?php echo isset($link)?$link:"";?>" alt="绝对地址或相对地址(如:/ucenter/index)">
        <label></label>
      </dd>
      </dl>
      <dl class="lineD">
      <dt>类型：</dt>
      <dd>
        <select name='type'>
          <option value="main">主导航</option>
          <option value="bottom">底部导航</option>
        </select>
      </dd>
      </dl>
      <dl class="lineD">
      <dt>排序：</dt>
      <dd>
        <input name="sort" type="text" class="small" pattern="int" value="<?php echo isset($sort)?$sort:1;?>">
        <label>数值越大越靠前</label>
      </dd>
      </dl>
       <dl class="lineD">
      <dt>打开方式：</dt>
      <dd>
        <input name="open_type" type="radio" value="0" checked="checked">
        <label>本窗口</label>
        <input name="open_type" type="radio" value="1" >
        <label>新窗口</label>
      </dd>
      </dl>
       <dl class="lineD">
      <dt>是否开启：</dt>
      <dd>
        <input name="enable" type="radio" value="1" checked="checked">
        <label>开启</label>
        <input name="enable" type="radio" value="0" >
        <label>关闭</label>
      </dd>
      </dl>
    <div style="text-align:center"><input type="submit" value="提交" class="button">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="重置" class="button"></div>
    </form>
</div>
<script type="text/javascript">
var form =  new Form();
form.setValue('open_type','<?php echo isset($open_type)?$open_type:"";?>');
form.setValue('enable','<?php echo isset($enable)?$enable:"";?>');
form.setValue('type','<?php echo isset($type)?$type:"";?>');
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