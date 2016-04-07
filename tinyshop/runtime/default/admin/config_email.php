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
<?php $config = Config::getInstance();$email_config = $config->get('email');?>
<h2 class="page_title"><?php echo isset($node_index['name'])?$node_index['name']:"";?></h2>
<div class="form2">
  	<form name="email_form" method="post" action="<?php echo urldecode(Url::urlFormat("/admin/config/group/email"));?>">
    <dl class="lineD">
      <dt>邮件发送方式：</dt>
      <dd>
		<select name="email_sendtype">
			<option value="smtp" selected="">smtp</option>
		</select>
    </dd></dl>
    <dl class="lineD">
      <dt>SMTP地址：</dt>
      <dd>
       		<input size="30" type="text" name="email_host" value="" pattern="\w+\(.\w+){2,}"> 
			<label>发送邮箱的smtp地址。如: smtp.gmail.com或smtp.qq.com</label>
      </dd>
	  
    </dl>
      <dl class="lineD">
      <dt>启用SSL连接：</dt>
      <dd>
        <label><input type="radio" name="email_ssl" value="1" checked="checked">是</label>
        <label><input type="radio" name="email_ssl" value="0">否</label>
		<label>此选项需要服务器环境支持SSL（如果使用Gmail或QQ邮箱，请选择是）</label>
    </dd></dl>
	
   <dl class="lineD">
      <dt>端口：</dt>
      <dd>
        <input name="email_port" pattern="int" type="text" id="textfield" value="">
		<label>smtp的端口。默认为25。具体请参看各STMP服务商的设置说明 （如果使用Gmail或QQ邮箱，请将端口设为465）</label>
    </dd></dl>
	
   <dl class="lineD">
      <dt>邮箱地址：</dt>
      <dd>
        <input name="email_account" pattern="email" type="text" id="textfield" value="">
		<label>邮箱地址请输入完整地址email@email.com格式</label>
    </dd></dl>
	
   <dl class="lineD">
      <dt>邮箱密码：</dt>
      <dd>
        <input name="email_password" pattern="required" type="password" id="textfield" value="<?php echo isset($email_config['email_password'])?$email_config['email_password']:"";?>">
		<label>邮箱密码</label>
    </dd></dl>
	
   <dl class="lineD">
      <dt>发送者姓名：</dt>
      <dd>
        <input name="email_sender_name" type="text" id="textfield" value="">
		<label>发送者姓名</label>
    </dd>
    </dl>
    <dl class="lineD">
      <dt>测试收件地址：</dt>
      <dd>
        <input name="test_email" id="test_email" type="text" id="textfield" value="">
    <label>收件邮箱地址</label> <a href="javascript:;" id="send_email" class="btn btn-mini btn-blue" onclick="">发送测试</a>
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
  var form = new Form('email_form');
  var data = <?php echo JSON::encode($config->get('email'));?>;
  form.init(data);
  $("#send_email").on('click',function(){
    var email = $("#test_email").val();
    $.post('<?php echo urldecode(Url::urlFormat("/admin/send_email_test"));?>',{email:email},function(data){
      art.dialog.tips("<p class='"+data['status']+"'>"+data['msg']+"</p>",2);
    },'json');
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