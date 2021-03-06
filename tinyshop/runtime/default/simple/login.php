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
        <div class="magic-bg">
    <div class="simple-box " >
        <div class="title">
            <div class="sub-1"><h1>会员登录</h1></div>
            <div class="sub-2"><a href="<?php echo urldecode(Url::urlFormat("/simple/reg"));?>">立即注册</a></div>
        </div>
        <form action="<?php echo urldecode(Url::urlFormat("/simple/login_act"));?>" class="reg-box" method="post" callback="checkReadme">
            <input type="hidden" name="redirectURL" value="<?php echo isset($redirectURL)?$redirectURL:$this->perPage();?>">
            <ul class="form  ">
                <li><span class="perfix fa">&#xf007;</span><input name="account" id="account"  class="input" pattern="required" placeholder="邮箱/用户名/已验证手机"><label></label></li>
                <li><span class="perfix fa">&#xf084;</span><input class="input" name="password" type="password" placeholder="密码" pattern="required" alt="密码不能为空"></li>
                <li><input name="autologin" id="readme" type="checkbox" value="1"> <label>自动登录</label> <label>[<a href="<?php echo urldecode(Url::urlFormat("/simple/forget_password"));?>">忘记密码?</a>]</label></li>
                <li><button class="btn btn-main " style="padding:10px 40px; width:100%;box-sizing: border-box;-webkit-box-sizing:border-box;">登录</button></li>
            </ul>
        </form>
    </div>
</div>
    <?php include './themes/default/apply/loginscript.php';?>


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