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
<?php echo JS::import('validator');?>
<h2 class="page_title"><?php echo isset($node_index['name'])?$node_index['name']:"";?></h2>
<div class="form2">
	<form name="config_form" method="post" action="<?php echo urldecode(Url::urlFormat("/admin/config/group/globals"));?>">
    <dl class="lineD">
      <dt>站点名称：</dt>
      <dd>
        <input name="site_name" type="text" value="">
      </dd>
    </dl>
    <dl class="lineD">
        <dt>Logo：</dt>
        <dd>
          <div id="img-show" >
            <?php if(isset($site_logo)){?>
              <img height='50' src="<?php echo urldecode(Url::urlFormat("@$site_logo"));?>">
            <?php }?>
          </div>
          <div>
          <?php $path = Tiny::getPath('uploads_url');?>
          <input name="site_logo" type="hidden" id="logo" value="<?php echo isset($site_logo)?$site_logo:"";?>" /><label></label><button class="button select_button">选择图片</button>
          </div>
        </dd>
      </dl>
    <dl class="lineD">
      <dt>关键字：</dt>
      <dd>
        <input name="site_keywords" type="text" size=60 value="">
        <label>多个使用英文的“|”分割</label>
      </dd>
    </dl>
    <dl class="lineD">
      <dt>描述信息：</dt>
      <dd>
        <input name="site_description" type="text" size=60 value="">
        <label>多个使用英文的“|”分割 </label>
      </dd>
    </dl>
    <dl class="lineD">
      <dt>公司/备案号：</dt>
      <dd>
        <input name="site_icp" type="text" size=40 value=""/>
        <span> 例如：xxxxxx有限公司/鲁ICP备xxxxxxx号 </span>
      </dd>
    </dl>
    <dl class="lineD">
      <dt>网址：</dt>
      <dd>
        <input name="site_url" type="text"  size=40 value=""/>
        <span>  </span>
      </dd>
    </dl>
    <dl class="lineD">
      <dt>邮箱：</dt>
      <dd>
        <input name="site_email" type="text" size=40 value=""/>
        <span>  </span>
      </dd>
    </dl>
    <dl class="lineD">
      <dt>手机：</dt>
      <dd>
        <input name="site_mobile" type="text" size=40 value=""/>
        <span>  </span>
      </dd>
    </dl>
    <dl class="lineD">
      <dt>联系电话：</dt>
      <dd>
        <input name="site_phone" type="text" size=40 value=""/>
        <span>  </span>
      </dd>
    </dl>
    <dl class="lineD">
      <dt>邮政编码：</dt>
      <dd>
        <input name="site_zip" type="text" size=40 value=""/>
        <span>  </span>
      </dd>
    </dl>
    <dl class="lineD">
      <dt>联系地址：</dt>
      <dd>
        <input name="site_addr" type="text" size=40 value=""/>
        <span></span>
      </dd>
    </dl>
	   <div class="center">
      <input type="submit" name="submit" class="button action fn" value="确 定">
    </div>
    </form>
</div>

<script>
	<?php if(isset($message)){?>
	art.dialog.tips('<p class="success"><?php echo isset($message)?$message:"";?></p>');
	<?php }?>
	var form = new Form('config_form');
	<?php $config = Config::getInstance();?>
	var data = <?php echo JSON::encode($config->get('globals'));?>;
	form.init(data);

  $(".select_button").on("click",function(){
      uploadFile();
      return false;
    });
function uploadFile(){
  art.dialog.open('<?php echo urldecode(Url::urlFormat("/admin/photoshop?type=2"));?>',{id:'upimg_dialog',title:'选择图片',width:613,height:380});
}
function setImg(value){
  $("#logo").val(value);
  var img = "<?php echo urldecode(Url::urlFormat("@"));?>"+value;
  $("#img-show").html("<img height='50' src='"+img+"'>");
  art.dialog({id:'upimg_dialog'}).close();
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