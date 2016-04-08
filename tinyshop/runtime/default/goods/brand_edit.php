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
<?php echo JS::import('editor');?>
<script>
      var editor;
      KindEditor.ready(function(K) {
        editor = K.create('textarea[name="content"]', {
          uploadJson : '<?php echo urldecode(Url::urlFormat("/admin/upload_image"));?>'
        });
      });
    </script>
<h1 class="page_title">品牌编辑</h1>
<!-- tab开始 -->
<form action="<?php echo urldecode(Url::urlFormat("/goods/brand_save"));?>" method="post" enctype="multipart/form-data" callback="check_invalid">
        <?php if(isset($id)){?><input type="hidden" name="id" value="<?php echo isset($id)?$id:"";?>"><?php }?>
<div id="obj_form" class="form2 tab" >
  <!-- tab头部分 start -->
  <ul class="tab-head"><li>基本信息</li></ul>
  <!-- tab头部分 end -->
  <!-- tab 内容部分开始 start -->
    <div class="tab-body ">
    <!-- 基本信息 start-->
      <div>
      <dl class="lineD">
        <dt>品牌名称：</dt>
        <dd>
          <input name="name" type="text" pattern="required" value="<?php echo isset($name)?$name:"";?>" alt="名称不能为空">
          <label>*品牌名称</label>
        </dd>
        </dl><dl class="lineD">
        <dt>网址：</dt>
        <dd>
          <input name="url" type="text" pattern="url" value="<?php echo isset($url)?$url:"";?>" alt="Url地址格式错误">
          <label>对应连接地址</label>
        </dd>
        </dl><dl class="lineD">
        <dt>排序：</dt>
        <dd>
          <input name="sort" type="text" pattern="int" value="<?php echo isset($sort)?$sort:"";?>" style="width:40px;" alt="必需为数字">
          <label>数字</label>
        </dd>
        </dl><dl class="lineD">
        <dt>Logo：</dt>
        <dd>
          <?php $path = Tiny::getPath('uploads_url');?>
          <input name="logo" type="hidden" id="logo" value="<?php echo isset($logo)?$logo:"";?>" /><label></label><button class="button select_button">选择图片</button>
        </dd>
      </dl>
      <dl >
        <dt></dt>
        <dd id="img-show" >
          <?php if(isset($logo) && $logo!=''){?>
            <img height="100" src="<?php echo urldecode(Url::urlFormat("@$logo"));?>">
          <?php }?>
        </dd>
      </dl>
      </div>
      <!-- 基本信息 end -->
      <!-- SEO信息 start -->
      <!-- SEO信息 end -->
      <!-- 详细说明 start -->
      <!-- 详细说明 end -->
    </div>
    <!-- tab 内容部分开始 end -->
    <div style="text-align:center"><input type="submit" value="提交" class="button">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="重置" class="button"></div>
    
</div>
</form>
<script>
$(".select_button").on("click",function(){
      uploadFile();
      return false;
    });
function uploadFile(){
  art.dialog.open('<?php echo urldecode(Url::urlFormat("/admin/photoshop?type=2"));?>',{id:'upimg_dialog',title:'选择图片',width:613,height:380});
}
function setImg(value){
  $("#logo").val(value);
  $("#img-show").html("<img height='100' src='<?php echo urldecode(Url::urlFormat("@"));?>"+value+"'>");
  art.dialog({id:'upimg_dialog'}).close();
}
function check_invalid(e){
  if(e==null){
    return true;
  }
  else{
    var index = $('.tab-body > *').has(e).index();
    tabs_select(0,index);
    return false;
  }  
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