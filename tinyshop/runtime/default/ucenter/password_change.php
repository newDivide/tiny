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
<div class="container clearfix">
	<div id='widget_sub_navs'><?php $widget = Widget::createWidget('sub_navs');$widget->action = "ucsidebar";$widget->sidebar = $sidebar;$widget->act = $actionId;$widget->cache = "false";$widget->run();?></div>
	<div class="uc-content clearfix">
        <h1 class="title"><span>修改密码：</span></h1>
        <?php if(isset($msg)){?>
        <div class="message_<?php echo isset($msg[0])?$msg[0]:"";?> ie6png"><?php echo isset($msg[1])?$msg[1]:"";?></div>
        <?php }elseif(isset($validator)){?>
        <div class="message_warning ie6png"><?php echo isset($validator['msg'])?$validator['msg']:"";?></div>
        <?php }?>
        <div class="mt10">
            <form id="info-form" class="simple" action="<?php echo urldecode(Url::urlFormat("/ucenter/password_save"));?>" method="post">
                <table class="form">
                 <tr>
                    <td class="label">旧密码：</td><td><input type="password" pattern="required" name="oldpassword" alt="原账户密码"> <label></label></td>
                </tr>
                <tr>
                    <td class="label">新密码：</td><td><input type="password" pattern="required" name="password" bind="repassword" minlen="6" maxlen="20" value="" alt="密码长度6-20个字符"> <label></label></td>
                </tr>
                <tr>
                    <td class="label">确认密码：</td><td><input type="password" pattern="required" name="repassword" bind="password" minlen="6" maxlen="20" value="" alt="密码长度6-20个字符"> <label></label></td>
                </tr>
                <tr>
                    <td colspan="2" class="tc"><input type="submit" class="btn" value="保存" ></td>
                </tr>
            </table>
            <input type='hidden' name='tiny_token_' value='<?php echo Tiny::app()->getToken("");?>'/>
        </form>
    </div>
</div>
</div>
     <?php include './themes/default/apply/passwordchange.php';?>

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