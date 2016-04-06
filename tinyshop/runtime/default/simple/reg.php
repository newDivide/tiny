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
        <?php echo JS::import('dialog?skin=tinysimple');?>
<?php echo JS::import('dialogtools');?>
<?php $config = Config::getInstance(); $other = $config->get('other'); $reg_way = isset($other['other_reg_way'])?$other['other_reg_way']:0;$reg_way = explode(',',$reg_way);$reg_way = array_flip($reg_way);?>
<div class="magic-bg right" >
    <div class="simple-box "  style="width:480px;height:540px;left:100px">
        <div class="title">
        <div class="sub-1"><h1>用户注册</h1></div><div class="sub-2"><a href="<?php echo urldecode(Url::urlFormat("/simple/login"));?>">会员登录</a></div>
        </div>
        <form action="<?php echo urldecode(Url::urlFormat("/simple/reg_act"));?>" class="reg-box" method="post" callback="checkReadme">

            <input type="hidden" name="redirectURL" value="<?php echo isset($redirectURL)?$redirectURL:$this->perPage();?>">
            <ul class="form  ">
                <?php if(isset($reg_way[0])){?>
                <li><span class="perfix fa">&#xf007;</span><input name="email" id="email"  class="input" pattern="email" placeholder="邮箱(例如:demo@tinyx.com)" alt="邮箱格式不正确!"></li>
                <?php }?>
                <?php if(isset($reg_way[1])){?>
                <?php if(class_exists('SMS')){?>
                <li>
                    <span class="perfix fa">&#xf095;</span><input type="text" id="mobile" class="input" name="mobile" pattern="mobi" value="<?php echo isset($mobile)?$mobile:"";?>" alt="正确的手机号码">
                </li>
                <?php }else{?>
                <li>
                    非对应授权版本无法使用手机注册用户功能！
                </li>
                <?php }?>
                <?php }?>
                <li><span class="perfix fa">&#xf023;</span><input bind="repassword" minlen=6 maxlen=20 class="input" type="password" name="password" pattern="required" placeholder="密码" alt="6-20任意字符组合"></li>
                <li><span class="perfix fa">&#xf084;</span><input bind="password" minlen=6 maxlen=20 class="input" type="password"  name="repassword" pattern="required" placeholder="确认密码" alt="6-20任意字符组合"></li>

                <?php if(isset($reg_way[1]) && class_exists('SMS') && SMS::getInstance()->getStatus()){?>
                <li>
                    <span class="perfix fa">&#xf02a;</span><input type="text" class="input-sm" name="mobile_code" pattern="\d{6}" alt="6位短信验证码"><label></label><input id="sendSMS" type="button" class="btn btn-default" value="获取短信验证码"></dd>
                </li>
                <?php }else{?>
                <li>
                    <span class="perfix fa">&#xf02a;</span><input type="text" class="input-sm" name="verifyCode" id="verifyCode"  pattern="\w{4}" maxlength="4" style="width: 80px;" alt="验证码不正确"><img id="captcha_img"  src="<?php echo urldecode(Url::urlFormat("/simple/captcha/h/40/w/120/bc/f1f1f1"));?>"><label><a href="javascript:void(0)" class="red" onclick="document.getElementById('captcha_img').src='<?php echo urldecode(Url::urlFormat("/simple/captcha/h/40/w/120/bc/f1f1f1/random/"));?>'+Math.random()">换一张</a></label>
                </li>
                <?php }?>
                <li>
                <dt>&nbsp;</dt><dd><input id="readme" type="checkbox" alt="同意后才可注册"><label></label><label>我已阅读并同意用户注册协议</label></dd>
            </li>
            <li><button class="btn btn-main " style="padding:10px 40px; width:100%;box-sizing:border-box;-webkit-box-sizing:border-box;">同意协议，立即注册</button></li>
            <input type='hidden' name='tiny_token_reg' value='<?php echo Tiny::app()->getToken("reg");?>'/>
            </ul>

    </form>
</div>
</div>
<div id="license-content" style="display:none;">
    <div style="height:400px;overflow:auto">
    <?php $item=null; $query = new Query("help");$query->where = "id = 14";$items = $query->find(); foreach($items as $key => $item){?>
    <?php echo isset($item['content'])?$item['content']:"";?>
    <?php }?>
    </div>
    <div class="mt10 tc"><a href="javascript:closeLicense();" class="btn btn-main">同意用户注册协议</a></div>
</div>

<?php echo JS::import('form');?>
        <?php include './themes/default/apply/regscript.php';?>

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