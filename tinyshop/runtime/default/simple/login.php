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
                <li><button class="btn btn-main " style="padding:10px 40px; width:100%">登录</button></li>
                <li class="oauth-list">
                    <fieldset class="line-title">
                        <legend align="center" class="txt">其他方式登录</legend>
                    </fieldset>
                    <?php foreach($oauth_login as $key => $item){?>
                    <a href="<?php echo isset($item['url'])?$item['url']:"";?>"><img src="<?php echo urldecode(Url::urlFormat("@protected/classes/oauth/logo/$item[icon]"));?>" ></a>
                    <?php }?>
                </li>
            </ul>
        </form>
    </div>
</div>
<script type="text/javascript">
    <?php if(isset($invalid)){?>
    var form = new Form();
    form.setValue('account', '<?php echo isset($account)?$account:"";?>');
    autoValidate.showMsg({id:$("input[name='<?php echo isset($invalid['field'])?$invalid['field']:"";?>']").get(0),error:true,msg:"<?php echo isset($invalid['msg'])?$invalid['msg']:"";?>"});
    $(".invalid-msg").show();
    <?php }?>
    $("input[pattern]").on("blur",function(event){
        $(".invalid-msg , .valid-msg").hide();
        var current_input = $(this);
        var result = autoValidate.validate(event);
        if(result){
            current_input.parent().removeClass('invalid').addClass('valid');
        }else{
            current_input.parent().removeClass('valid').addClass('invalid');
        }
        if(result){
            if(current_input.attr('id')=='account'){
                $.post("<?php echo urldecode(Url::urlFormat("/ajax/account/account/"));?>"+$(this).val(),function(data){
                    var msg = '合法用户';
                    if(data['status']){
                        msg = '用户不存在';
                        current_input.next().show();
                        current_input.parent().removeClass('valid').addClass('invalid');
                    }
                    autoValidate.showMsg({id:document.getElementById('account'),error:data['status'],msg:msg});
                },'json');
            }
            $(".invalid-msg").show();
        }else{
            current_input.next().show();
        }
    });
</script>

    </div>
    <!-- E 主控区域 -->

    <!-- S 底部区域 -->
    <div id="footer">
        <div class="copyright">
            <!--S 济南泰创软件科技有限公司保留所有版权，非授权用户严禁删除版权信息；擅自删除，后果自负。-->
            <div class="container bootom">
            <div class="sub-1">
                <div class="logo"></div>
            </div>
            <div class="sub-2">
            <div><?php $item=null; $query = new Query("nav");$query->where = "type = 'bottom'";$query->order = "`sort` desc";$items = $query->find(); foreach($items as $key => $item){?>
                <a href="<?php if(strstr($item['link'],'http://')===false){?><?php echo urldecode(Url::urlFormat("$item[link]"));?><?php }else{?><?php echo isset($item['link'])?$item['link']:"";?><?php }?>" target="<?php if($item['open_type']==1){?>_blank<?php }else{?>_self<?php }?>"><?php echo isset($item['name'])?$item['name']:"";?></a>
                <?php }?></div>
            <span>Powered by <a href="http://www.tinyrise.com"><b style="color: #e74503">Tiny</b><b style="color: #999">Shop</b></a></span> © 2015 <a href="http://www.tinyrise.com">tinyrise.com</a> . 保留所有权利 。 </div>
            <div class="sub-3">
                <a target="_blank" href="#"><img src="<?php echo urldecode(Url::urlFormat("#images/v-logo-2.png"));?>" alt="诚信网站"></a>
                <a target="_blank" href="#"><img src="<?php echo urldecode(Url::urlFormat("#images/v-logo-1.png"));?>" alt="诚信网站"></a>
                <a target="_blank" href="#"><img src="<?php echo urldecode(Url::urlFormat("#images/v-logo-3.png"));?>" alt="网上交易保障中心"></a>
            </div>
            </div>
            <!--S 济南泰创软件科技有限公司保留所有版权，非授权用户严禁删除版权信息；擅自删除，后果自负。-->
        </div>
    </div>
    <!-- E 底部区域 -->
</body>
</html>

<!--Powered by TinyRise-->