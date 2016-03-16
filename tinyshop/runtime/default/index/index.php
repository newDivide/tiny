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
               <div class="banner ">
    <div class="slider" style="height: 396px;" config-data={ "direction": "left"} >
        <ul class="cycle-slideshow">
            <?php $item=null; $query = new Query("ad");$query->where = "number = 'qgiowmka-us4k-p0up-vs3c-blkqmtb7'";$items = $query->find(); foreach($items as $key => $item){?> <?php $lists = unserialize($item['content']);?> <?php foreach($lists as $key => $ad){?>
            <li style="background-image:url(<?php echo urldecode(Url::urlFormat("@$ad[path]"));?>) ">
                <a href="<?php echo urldecode(Url::urlFormat("$ad[url]"));?>" target="_blank"></a>
            </li>
            <?php }?> <?php }?>
        </ul>
    </div>
</div>

<!-- S 商品展示 -->
<div class="lists container">
    <?php $cate_index=0;?> <?php foreach($category as $key => $categ){?> <?php $cate_index++;?>
    <div>
        <div class="title-nav">
            <span class="floor-tag"><?php echo isset($cate_index)?$cate_index:"";?>F / </span>
            <span class="title"><a href="<?php echo urldecode(Url::urlFormat("/index/category/cid/$categ[id]"));?>"><?php echo isset($categ['title'])?$categ['title']:"";?></a></span>
        </div>
        <div class="item">
            <div class="sub-1">
                <div class="slider clearfix" style="height: 360px;" config-data={ "direction": "left"}>
                    <?php if($categ['imgs']){?>
                    <ul class="cycle-slideshow">
                        <?php $images = unserialize($categ['imgs']);?> <?php foreach($images as $key => $img){?>
                        <li style="background-image:url(<?php echo Common::thumb($img,190,190);?>) "></li>
                        <?php }?>
                    </ul>
                    <?php }?>
                </div>
                <div>
                    <ul class="category-tags">
                        <?php foreach($categ['child'] as $key => $child){?>
                        <li><a href="<?php echo urldecode(Url::urlFormat("/index/category/cid/$child[id]"));?>"><?php echo isset($child['title'])?$child['title']:"";?></a></li>
                        <?php }?>
                    </ul>
                </div>
            </div>
            <div class="sub-2">
                <ul class="index-products">
                    <?php $path_like = "like '$categ[path]%'";?> <?php $item=null; $query = new Query("goods");$query->where = "is_online = 0 and category_id in (select id from tiny_goods_category where path $path_like)";$query->order = "sort desc";$query->limit = "6";$items = $query->find(); foreach($items as $key => $item){?>
                    <li>
                        <dl class="product">
                           <dt class="img">
                               <a href="<?php echo urldecode(Url::urlFormat("/index/product/id/$item[id]"));?>"><img src="<?php echo Common::thumb($item['img'],220,220);?>" width="220"></a>
                           </dt>
                           <dd class="title"><a href="<?php echo urldecode(Url::urlFormat("/index/product/id/$item[id]"));?>"><?php echo isset($item['name'])?$item['name']:"";?></a></dd>
                           <dd class="price"><?php echo isset($item['sell_price'])?$item['sell_price']:"";?><?php echo isset($currency_unit)?$currency_unit:"";?></dd>
                       </dl>
                   </li>
                   <?php }?>
               </ul>
           </div>
       </div>
   </div>
   <?php }?>
   <!-- E 商品展示 -->

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