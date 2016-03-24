<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="HandheldFriendly" content="True">
    <link rel="shortcut icon" href="<?php echo urldecode(Url::urlFormat("@favicon.ico"));?>"/>
    <link rel="bookmark" href="<?php echo urldecode(Url::urlFormat("@favicon.ico"));?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo urldecode(Url::urlFormat("#css/common.css"));?>">
    <link rel="stylesheet" type="text/css" href="<?php echo urldecode(Url::urlFormat("#css/font-awesome.min.css"));?>">
    <link rel="stylesheet" type="text/css" href="<?php echo urldecode(Url::urlFormat("#js/artdialog/tiny-dialog.css"));?>">
    <style type="text/css">
        .swiper-container {width: 100%;}
        .js-template{display:none !important;}
    </style>
    <script src="<?php echo urldecode(Url::urlFormat("#js/jquery.min.js"));?>"></script>
    <script src="<?php echo urldecode(Url::urlFormat("#js/artdialog/dialog-plus-min.js"));?>"></script>
    <script src="<?php echo urldecode(Url::urlFormat("#js/common.js"));?>"></script>
    <script src="<?php echo urldecode(Url::urlFormat("#js/tinyslider.js"));?>"></script>
    <script type="text/javascript">
        var server_url = '<?php echo urldecode(Url::urlFormat("@"));?>__con__/__act__';
        var Tiny = {user:{name:'<?php echo isset($user['name'])?$user['name']:'';?>',id:'<?php echo isset($user['id'])?$user['id']:0;?>',online:<?php echo isset($user['id']) && $user['id']?'true':'false';?>}};
    </script>
    <title><?php if(isset($seo_title) && isset($site_title) && ($seo_title == $site_title)){?><?php echo isset($seo_title)?$seo_title:"";?><?php }else{?><?php echo isset($seo_title)?$seo_title:"";?>-<?php echo isset($site_title)?$site_title:"";?><?php }?></title>
</head>

<body>
    <!-- S 头部区域 -->
    <div id="header">
        <?php include './themes/default/layout/header.php';?>
            </div>
            <!-- E 头部区域 -->
            <!-- S 主控区域 -->
            <div id="main">
               <link type="text/css" rel="stylesheet" href="<?php echo urldecode(Url::urlFormat("#css/ucenter.css"));?>" />
<?php echo JS::import('form');?>
<?php echo JS::import('date');?>
<?php echo JS::import('dialog?skin=tinysimple');?>
<script type="text/javascript" charset="UTF-8" src="<?php echo urldecode(Url::urlFormat("#js/jquery.iframe-post-form.js"));?>"></script>
<div class="container clearfix">
	<div id='widget_sub_navs'><?php $widget = Widget::createWidget('sub_navs');$widget->action = "ucsidebar";$widget->sidebar = $sidebar;$widget->act = $actionId;$widget->cache = "false";$widget->run();?></div>
	<div class="content clearfix uc-content">
		<h1 class="title"><span>基本资料：</span></h1>
		<?php if(isset($msg)){?>
		<div class="message_<?php echo isset($msg[0])?$msg[0]:"";?> ie6png"><?php echo isset($msg[1])?$msg[1]:"";?></div>
		<?php }elseif(isset($validator)){?>
		<div class="message_warning ie6png"><?php echo isset($validator['msg'])?$validator['msg']:"";?></div>
		<?php }?>
		<div class="mt10" style="position:relative;">
			<div style="position: absolute;top:10px;right: 10px;">
				<?php if($user['head_pic']==''){?>
				<img id="head-pic" class="ie6png" src="<?php echo urldecode(Url::urlFormat("#images/no-img.png"));?>" width="120" height="120">
				<?php }else{?>
				<img id="head-pic" class="ie6png" src="<?php echo urldecode(Url::urlFormat("@$user[head_pic]"));?>" width="120" height="120">
				<?php }?>
				<p style="padding: 10px 30px;"><a href="javascript:;" id="upload-link">修改头像</a></p>
			</div>
			<form id="info-form" class="simple" action="<?php echo urldecode(Url::urlFormat("/ucenter/info_save"));?>" method="post">
				<table class="form">
					<tr><td class="label">会员帐号：</td><td><?php if(Validator::match('\d+@no.com',$info['email'])){?><input type="text" pattern="email" name="email" value="<?php echo isset($email)?$email:"";?>" alt="邮箱格式错误"> <label></label><?php }else{?><?php echo isset($email)?$email:"";?><?php }?></td></tr>
					<tr><td class="label">会员级别：</td><td><?php echo isset($gname)?$gname:'默认分组';?></td></tr>
					<tr>
						<td class="label">昵称：</td><td><input type="text" pattern="required" name="name" maxlen="20" value="<?php echo isset($name)?$name:"";?>" alt="长度不得超过20个字"> <label></label></td>
					</tr>
					<tr>
						<td class="label">真实姓名：</td><td><input type="text" pattern="required" name="real_name" maxlen="20" value="<?php echo isset($real_name)?$real_name:"";?>" alt="长度不得超过20个字"> <label></label></td>
					</tr>
					<tr>
						<td class="label">性别：</td><td><input name="sex" type="radio" value="0" checked="checked"> <label> 女</label>&nbsp;&nbsp;<input name="sex" type="radio" <?php if(isset($sex) && $sex==1){?>checked="checked"<?php }?> value="1"> <label> 男</label></td>
					</tr>
					<tr>
						<td class="label">生日：</td><td><input name="birthday" type="text" onfocus="WdatePicker()" class="Wdate"  value="<?php echo isset($birthday)?$birthday:"";?>" ><label></label></td>
					</tr>
					<tr>
						<td class="label">手机号码：</td><td><?php if(Validator::mobi($info['mobile'])){?><?php echo isset($mobile)?$mobile:"";?><?php }else{?><input type="text" pattern="mobi" name="mobile" value="<?php echo isset($mobile)?$mobile:"";?>" alt="请正确填写手机号"><label></label><?php }?></td>
					</tr>
					<tr>
						<td class="label">电话号码：</td><td><input type="text" name="phone"  value="<?php echo isset($phone)?$phone:"";?>" empty pattern="phone" alt="请正确填写电话号码"><label></label></td>
					</tr>
					<tr><td class="label">所在地区：</td><td id="area"><select id="province"  name="province" >
						<option value="0">==省份/直辖市==</option>
					</select>
					<select id="city" name="city"><option value="0">==市==</option></select>
					<select id="county" name="county"><option value="0">==县/区==</option></select><input pattern="^\d+,\d+,\d+$" id="test" type="text" style="visibility:hidden;width:0;" value="<?php echo isset($province)?$province:"";?>,<?php echo isset($city)?$city:"";?>,<?php echo isset($county)?$county:"";?>" alt="请选择完整地区信息！"><label></label></td></tr>
					<tr>
						<td class="label">街道地址：</td><td><textarea name="addr" pattern="required" minlen="5" maxlen="120" alt="不需要重复填写省市区，必须大于5个字符，小于120个字符"><?php echo isset($addr)?$addr:"";?></textarea> <label>&nbsp;</label></td>
					</tr>
					<tr>
						<td colspan="2" class="tc"><input type="submit" class="btn" value="保存"></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>
<div id="head-dialog" style="display: none">
	<div class="box" style="width:400px;">
		<h2>上传头像：</h2>
		<div class="content mt20 p10">
			<form enctype="multipart/form-data" action="<?php echo urldecode(Url::urlFormat("/ucenter/upload_head"));?>" method="post"  id="uploadForm">
				<p><input type="file" name="imgFile" ></p>
				<p class="mt20 tc"><button class="btn" id="upload-btn">上传</button></p>
			</form>
		</div>
	</div>
</div>
	<?php include './themes/default/apply/infoscript.php';?>

           </div>
           <!-- E 主控区域 -->

           <!-- S 底部区域 -->
           <div id="footer">
                 <?php include './themes/default/layout/footer.php';?>
                    </div>
                    <!-- E 底部区域 -->
                   <?php include './themes/default/layout/footerscript.php';?>
                </body>
                </html>

<!--Powered by TinyRise-->