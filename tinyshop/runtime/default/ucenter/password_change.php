<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="HandheldFriendly" content="True">
    <?php include './themes/default/layout/import.php';?>
    
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
<script type="text/javascript">
    var form =  new Form('info-form');
    form.setValue('is_default','<?php echo isset($is_default)?$is_default:"";?>');
    $("#areas").Linkage({ url:"<?php echo urldecode(Url::urlFormat("/ajax/area_data"));?>",selected:[<?php echo isset($province)?$province:0;?>,<?php echo isset($city)?$city:0;?>,<?php echo isset($county)?$county:0;?>],callback:function(data){
        var text = new Array();
        var value = new Array();
        for(i in data[0]){
          if(data[0][i]!=0){
            text.push(data[1][i]);
            value.push(data[0][i]);
        }
    }
    $("#test").val(value.join(','));
    FireEvent(document.getElementById("test"),"change");
}});
    <?php if(isset($invalid)){?>
    autoValidate.showMsg({id:$("input[name='<?php echo isset($invalid['name'])?$invalid['name']:"";?>']").get(0),error:true,msg:'<?php echo isset($invalid['msg'])?$invalid['msg']:"";?>'});
    <?php }?>
</script>

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