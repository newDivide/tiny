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
<?php echo JS::import('dialog?skin=tinysimple');?>
<?php echo JS::import('dialogtools');?>
<div class="container clearfix">
    <div id='widget_sub_navs'><?php $widget = Widget::createWidget('sub_navs');$widget->action = "ucsidebar";$widget->sidebar = $sidebar;$widget->act = $actionId;$widget->cache = "false";$widget->run();?></div>
    <div class="content clearfix uc-content">
        <h1 class="title"><span>收货地址：</span></h1>
        <?php if(isset($msg)){?>
        <div class="message_<?php echo isset($msg[0])?$msg[0]:"";?> ie6png"><?php echo isset($msg[1])?$msg[1]:"";?></div>
        <?php }elseif(isset($validator)){?>
        <div class="message_warning ie6png"><?php echo isset($validator['msg'])?$validator['msg']:"";?></div>
        <?php }?>
        <div class="mt20 tr"><a id="address_other" class="btn btn-main" href="javascript:;">添加新地址</a></div>
        <table class="simple address-list mt20">
            <tr>
                <th>收货人</th> <th>所在地区</th> <th>街道地址</th> <th>邮编</th> <th>电话/手机</th><th></th> <th>操作</th>
            </tr>
           <?php foreach($address as $key => $item){?>
           <tr class="<?php if($key%2==1){?>odd<?php }else{?>even<?php }?>">
               <td><?php echo isset($item['accept_name'])?$item['accept_name']:"";?></td> <td><?php echo isset($parse_area[$item['province']])?$parse_area[$item['province']]:"";?>,<?php echo isset($parse_area[$item['city']])?$parse_area[$item['city']]:"";?>,<?php echo isset($parse_area[$item['county']])?$parse_area[$item['county']]:"";?></td> <td><?php echo isset($item['addr'])?$item['addr']:"";?></td> <td><?php echo isset($item['zip'])?$item['zip']:"";?></td> <td><?php echo isset($item['mobile'])?$item['mobile']:"";?>/<?php echo isset($item['phone'])?$item['phone']:"";?> </td><td><?php if($item['is_default']==1){?><b>默认地址</b><?php }?></td> <td><a  href="javascript:;" data-value="<?php echo isset($item['id'])?$item['id']:"";?>" class="modify">修改</a> | <a href="javascript:confirm_action('<?php echo urldecode(Url::urlFormat("/ucenter/address_del/id/$item[id]"));?>')">删除</a></td>
           </tr>
           <?php }?>
        </table>
        <div class="mt10">最多可保存20个有效地址！</div>
    </div>
</div>
<script type="text/javascript">

    $("#address_other").on("click",function(){
        art.dialog.open('<?php echo urldecode(Url::urlFormat("/simple/address_other"));?>',{width:960,height:462,lock:true});
        return false;
    })

    $(".address-list .modify").each(function(){

        $(this).on("click",function(){
            var id = $(this).attr("data-value");
            art.dialog.open('<?php echo urldecode(Url::urlFormat("/simple/address_other/id/"));?>'+id,{width:960,height:462,lock:true});
        });
    });
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