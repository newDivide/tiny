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
                    <script>
                        $(".slider").Slider();
                        $(".category li").mouseenter(function() {
                            $(this).addClass("hover");
                        }).mouseleave(function() {
                            $(this).removeClass("hover");
                        });

                        $("#tags-list a").each(function(){
                            $(this).on("click",function(){
                                $("#search-keyword").val($(this).text());
                                $("#search-form").submit();
                            })
                        });
                        $(".category-box").mouseenter(function(){
                            $(this).addClass("on");
                        }).mouseleave(function(){
                            $(this).removeClass("on");
                        });

                        function updateCart(data){
                            var card_items = '';
                            for(var i in data){
                                var spec = data[i]['spec'];
                                var spec_str = '';
                                for(var k in spec){
                                    spec_str +="<p>"+spec[k]['value'][2]+"</p>";
                                }
                                card_items += '<div class="cart-item" id="'+i+'"><div class="pic"><img src="<?php echo urldecode(Url::urlFormat("@"));?>'+data[i]['img']+'" width="50" height="50"></div><div class="spec">'+spec_str+'</div><div class="num">'+data[i]['num']+'</div><div class="price">'+(data[i]['amount'])+'</div><a class="icon-close-16 ie6png" productid="'+data[i]['id']+'"></a></div>';
                            }
                            $("#cart-list").empty().append(card_items);
                            changeCartInfo();
                            bindDelEvent();
                        }
                        bindDelEvent();
                        function bindDelEvent(){
                            $("#shopping-cart .icon-close-16").on("click",function(){
                                var btn_close = $(this);
                                $.post("<?php echo urldecode(Url::urlFormat("/index/cart_del"));?>",{id:btn_close.attr("productid")},function(){
                                    btn_close.parent().remove();
                                    changeCartInfo();
                                    $("#card-wrap").css({top:1-$("#card-wrap").outerHeight()},"fast");
                                },"json");
                            });
                        }

                        function changeCartInfo(){
                            $(".cart-product-num").text($(".cart-item").size());
                            var total = 0.00;
                            $(".cart-item .price").each(function(){
                                total += parseFloat($(this).text());
                            });
                            $(".cart-total").text(total.toFixed(2));
                            if($(".cart-item").size()==0){
                                $("#cart-list").empty().append('<li><div>购物车中还没有商品，赶紧选购吧！</div></li>');
                            }
                        }
                        $("#tags-list a").each(function(){
                            $(this).on("click",function(){
                                $("#search-keyword").val($(this).text());
                                $("#search-form").submit();
                            })
                        });
                    </script>
                </body>
                </html>

<!--Powered by TinyRise-->