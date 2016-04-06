<!doctype html>
<html lang="zh-CN">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta charset="UTF-8">
    <meta name="HandheldFriendly" content="True">
    <link rel="shortcut icon" href="<?php echo urldecode(Url::urlFormat("@favicon.ico"));?>"/>
    <link rel="bookmark" href="<?php echo urldecode(Url::urlFormat("@favicon.ico"));?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo urldecode(Url::urlFormat("#css/common.css"));?>">
    <link rel="stylesheet" type="text/css" href="<?php echo urldecode(Url::urlFormat("#css/simple.css"));?>">
    <link rel="stylesheet" type="text/css" href="<?php echo urldecode(Url::urlFormat("#css/font-awesome.min.css"));?>">
    <link rel="stylesheet" type="text/css" href="<?php echo urldecode(Url::urlFormat("#js/artdialog/tiny-dialog.css"));?>">

    <script src="<?php echo urldecode(Url::urlFormat("#js/jquery.min.js"));?>"></script>
    <script src="<?php echo urldecode(Url::urlFormat("#js/artdialog/dialog-plus-min.js"));?>"></script>
    <script src="<?php echo urldecode(Url::urlFormat("#js/common.js"));?>"></script>
    <?php echo JS::import('form');?>
    <title><?php if(isset($seo_title) && isset($site_title) && ($seo_title == $site_title)){?><?php echo isset($seo_title)?$seo_title:"";?><?php }else{?><?php echo isset($seo_title)?$seo_title:"";?>-<?php echo isset($site_title)?$site_title:"";?><?php }?></title>
</head>
<body>
    <!-- S 头部区域 -->
    <div id="header">
        <div class="container head-main">
            <a href="<?php echo urldecode(Url::urlFormat("/index/index"));?>" class="sub-1 logo"></a>
        </div>
    </div>
    <!-- E 头部区域 -->

    <!-- S 主控区域 -->
    <div id="main" class="simple-main">
        <?php echo JS::import('form');?>
<?php $items=array("填写账户信息","验证身份","设置新密码","完成");?>
<div id='widget_sub_navs'><?php $widget = Widget::createWidget('sub_navs');$widget->action = "crumbs";$widget->items = $items;$widget->step = "4";$widget->current = "1";$widget->cache = "false";$widget->run();?></div>
<div class="simple-box " style="width:600px;margin:40px auto;" >
	<form action="<?php echo urldecode(Url::urlFormat("/simple/forget_act"));?>" method="post" >
		<ul class="form">
			<li><span class="perfix fa">&#xf007;</span><input class="input"  name="account" id="account"  pattern="required" placeholder="邮箱/手机号码"> <label>邮箱/手机号码</label></li>
			<li><span class="perfix fa">&#xf02a;</span><input type="text" class="input-sm" name="verifyCode" id="verifyCode"  pattern="\w{4}" maxlength="4" style="width: 80px;" placeholder="验证码"><label style="display:none"></label><img id="captcha_img"  src="<?php echo urldecode(Url::urlFormat("/simple/captcha/h/40/w/120"));?>"><label><a href="javascript:void(0)" class="red" onclick="document.getElementById('captcha_img').src='<?php echo urldecode(Url::urlFormat("/simple/captcha/h/40/w/120/random/"));?>'+Math.random()">换一张</a></label></li>
			<li><input type="submit" class="btn btn-main" value="找回密码"></li>
		</ul>
	</form>
</div>
    <?php include './themes/default/apply/forget_password.php';?>

    </div>
    <!-- E 主控区域 -->

    <!-- S 底部区域 -->
    <div id="footer">
        <?php include './themes/default/layout/footer.php';?>
        
    </div>
    <!-- E 底部区域 -->
</body>
</html>

<!--Powered by TinyRise-->