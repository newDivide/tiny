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
		<?php echo JS::import('form');?>
<?php echo JS::import('date');?>
<?php echo JS::import('dialog?skin=brief');?>
<?php echo JS::import('dialogtools');?>
<h1 class="page_title">管理员编辑</h1>
<div id="obj_form" class="form2">
    <form action="<?php echo urldecode(Url::urlFormat("/admin/manager_save"));?>" method="post" >
        <?php if(isset($id)){?><input type="hidden" name="id" id="objId" value="<?php echo isset($id)?$id:"";?>"><?php }?>
    <dl class="lineD">
      <dt><b class="red">*</b> 用户名：</dt>
      <dd>
        <?php if(isset($id) && isset($name) ){?>
        <label><?php echo isset($name)?$name:"";?></label>
        <?php }else{?>
        <input name="name" type="text" pattern="required" value="<?php echo isset($name)?$name:"";?>" alt="用户名不能为空" />
        <label></label>
        <?php }?>
      </dd>
      </dl>
      <dl class="lineD">
      <dt>角色：</dt>
      <dd>
        <select name="roles" id="">
          <option value="administrator">超级管理员</option>
          <?php $item=null; $query = new Query("roles");$items = $query->find(); foreach($items as $key => $item){?>
          <option value="<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></option>
          <?php }?>
        </select>
      </dd>
      </dl>
      <?php if( isset($id) && isset($password)){?>
      <dl class="lineD">
      <dt>密码：</dt>
      <dd>
        <label><a href="javascript:;" onclick="password_dialog()">修改密码</a></label>
      </dd>
      </dl>
      <?php }else{?>
      <dl class="lineD">
      <dt><b class="red">*</b>密码：</dt>
      <dd>
        <input name="password" type="password"  bind="repassword" pattern=".{6,}" value="" alt="密码必需大于6位">
        <label></label>
      </dd>
      </dl><dl class="lineD">
      <dt><b class="red">*</b>确认密码：</dt>
      <dd>
        <input name="repassword" type="password" bind="password" pattern=".{6,}" value="" alt="密码必需大于6位">
        <label></label>
      </dd>
      </dl>
      <?php }?>
    <div style="text-align:center"><input type="submit" value="提交" class="button">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="重置" class="button"></div>
    </form>
</div>
<div id="password_info" style="display: none;width:520px">
  <form class="form2" callback="changePassword">
  <dl class="lineD">
      <dt><b class="red">*</b>密码：</dt>
      <dd>
        <input name="password" type="password"  id="password" bind="repassword" pattern=".{6,}">
        <label>密码必需大于6位</label>
      </dd>
      </dl><dl class="lineD">
      <dt><b class="red">*</b>确认密码：</dt>
      <dd>
        <input name="repassword" type="password" id="repassword" bind="password" pattern=".{6,}" >
        <label>密码必需大于6位</label>
      </dd>
      </dl>
      <div style="text-align:center"><input type="submit" value="提交" class="button">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="重置" class="button"></div>
      </form>
</div>
<script type="text/javascript">
var form =  new Form();
form.setValue('roles','<?php echo isset($roles)?$roles:"";?>');

function password_dialog(){
  art.dialog({id:'password_dialog',title:'密码设定:',content:document.getElementById('password_info')});
}
function changePassword(e){
  var password = $("#password").val();
  var repassword = $("#repassword").val();
  var id = $("#objId").val();
  if(!e){
    $.post("<?php echo urldecode(Url::urlFormat("/admin/manager_password"));?>",{id:id,password:password,repassword:repassword},function(data){
        if(data['status']=="success")
          art.dialog.tips("<p class='success'>密码修改成功！</p>");
        else art.dialog.tips("<p class='"+data['status']+"'>"+data['msg']+"</p>");
          art.dialog({id:"password_dialog"}).close();
    },"json");
  }
  return false;
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