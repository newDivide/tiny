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
               <?php echo JS::import('dialog?skin=tinysimple');?>
<?php echo JS::import('dialogtools');?>
<!--S 产品展示-->
<link type="text/css" rel="stylesheet" href="<?php echo urldecode(Url::urlFormat("#css/product.css"));?>" />
<script type='text/javascript' src="<?php echo urldecode(Url::urlFormat("#js/jquery.enlarge.js"));?>"></script>
<script type="text/javascript">
	//$("body").addClass("screen_960");
</script>

<div class="bg-base">
    <ol class="bread-crumb container">
      <?php foreach($category_nav as $key => $item){?>
        <?php if($item != end($category_nav)){?>
        <li><a class="category-<?php echo isset($key)?$key:"";?>" href="<?php echo urldecode(Url::urlFormat("/index/category/cid/$item[id]"));?>"><?php echo isset($item['name'])?$item['name']:"";?></a></li>
        <?php }else{?>
        <li><span class="category-<?php echo isset($key)?$key:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></span></li>
        <?php }?>
      <?php }?>
    </ol>
</div>
<div class="container">
<div class="goods-detail mt10 clearfix" style="position: relative;">

    <div class="content">
        <!--S 筛选部分-->
        <div id="selector">
            <div class="spec-attr box">
                <h2><span class="red" ><?php echo isset($current_category['name'])?$current_category['name']:"";?></span> 商品筛选</h2>
                <!--S 品牌-->
                <?php if($has_brand){?>
                <dl class="attr clearfix">
                    <dt class="attr-key">品牌：</dt>
                    <dd class="attr-value">
                        <?php foreach($has_brand as $key => $item){?>
                        <a <?php if(isset($selected['brand']) && $selected['brand']==$item['id']){?> class="select" <?php $url_tem=str_replace("/brand/$item[id]","",$url);?>href="<?php echo urldecode(Url::urlFormat("$url_tem"));?>" <?php }else{?>href="<?php echo urldecode(Url::urlFormat("$url/brand/$item[id]"));?>" <?php }?> ><?php echo isset($item['name'])?$item['name']:"";?>(<?php echo isset($brand_num[$item['id']])?$brand_num[$item['id']]:"";?>)<i></i></a>
                        <?php }?>
                    </dd>
                </dl>
                <?php }?>
                <!--E 品牌-->
                <!--S 价格-->
                <?php if($price_range){?>
                <dl class="attr clearfix">
                    <dt class="attr-key">价格：</dt>
                    <dd class="attr-value">
                        <?php foreach($price_range as $key => $item){?>
                        <a <?php if(isset($selected['price']) && $selected['price']==$item){?> class="select" <?php $url_tem=str_replace("/price/$item","",$url);?>href="<?php echo urldecode(Url::urlFormat("$url_tem"));?>" <?php }else{?>href="<?php echo urldecode(Url::urlFormat("$url/price/$item"));?>" <?php }?> ><?php if(strpos($item,'-')===false){?><?php echo isset($item)?$item:"";?>以上<?php }else{?><?php echo isset($item)?$item:"";?><?php }?><i></i></a>
                        <?php }?>
                    </dd>
                </dl>
                <?php }?>
                <!--E 价格-->

                <?php foreach($spec_attr as $key => $item){?>
                <dl class="attr clearfix">
                    <dt class="attr-key"><?php echo isset($item['name'])?$item['name']:"";?>：</dt>
                    <dd class="attr-value">
                        <?php foreach($item['values'] as $key => $value){?>
                        <a <?php if(isset($selected[$item['id']]) && $selected[$item['id']]==$value['id']){?> class="select" <?php $url_tem=str_replace("/$item[id]/$value[id]","",$url);?>href="<?php echo urldecode(Url::urlFormat("$url_tem"));?>" <?php }else{?>href="<?php echo urldecode(Url::urlFormat("$url/$item[id]/$value[id]"));?>" <?php }?> ><?php echo isset($value['name'])?$value['name']:"";?><i></i></a>
                        <?php }?>
                    </dd>
                </dl>
                <?php }?>
            </div>
            <div id="select-more">
                <div class="attr-extra"><div></div></div>
            </div>
        </div>
        <!--E 筛选部分-->
        <!--S 商品部分-->
        <div class="mt10 product_show  product-list  clearfix">
            <div class="clearfix" >
                <div class="sort-bar">
                    <span>排序：</span>
                    <a href="<?php echo urldecode(Url::urlFormat("$url/sort/0"));?>" <?php if($sort==0){?>class="current"<?php }?>>默认<i class="ie6png"></i></a>

                    <a href="<?php echo urldecode(Url::urlFormat("$url/sort/1"));?>" <?php if($sort==1){?>class="current" <?php }?>>销量<i></i></a>
                    <a href="<?php echo urldecode(Url::urlFormat("$url/sort/2"));?>" <?php if($sort==2){?>class="current"<?php }?>>评论数<i class="ie6png"></i></a>
                    <a <?php if($sort==4){?> href="<?php echo urldecode(Url::urlFormat("$url/sort/3"));?>" class="current-2" <?php }elseif($sort==3){?>href="<?php echo urldecode(Url::urlFormat("$url/sort/4"));?>" class="current"<?php }else{?> href="<?php echo urldecode(Url::urlFormat("$url/sort/4"));?>" <?php }?>>价格<i class="ie6png"></i></a>
                    <a href="<?php echo urldecode(Url::urlFormat("$url/sort/5"));?>" <?php if($sort==5){?>class="current"<?php }?>>最新<i class="ie6png"></i></a>
                </div>
            </div>
            <dl>
                <dd>
            <ul class="clearfix">
                <?php if(isset($goods['data'])){?>
                <?php foreach($goods['data'] as $key => $item){?>
                <li>
                    <dl class="product">
                        <dt class="img"><a href="<?php echo urldecode(Url::urlFormat("/index/product/id/$item[id]"));?>"><img src="<?php echo Common::thumb($item['img'],260,260);?>" width=260></a></dt>
                        <dd class="title"><a href="<?php echo urldecode(Url::urlFormat("/index/product/id/$item[id]"));?>"><?php echo TString::msubstr($item['name'],0,18);?></a></dd>
                        <dd><span class="price"><?php echo isset($currency_symbol)?$currency_symbol:"";?><?php echo isset($item['sell_price'])?$item['sell_price']:"";?></span></dd>
                        <dd class="product-ext">
                            <a href="<?php echo urldecode(Url::urlFormat("/index/product/id/$item[id]"));?>" id="add-cart" class="btn btn-main" style="padding:6px 20px;">商品详情</a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="javascript:;" class="attention btn btn-info fr" val="<?php echo isset($item['id'])?$item['id']:"";?>"><i class="icon-hart-16 ie6png"></i><span>关注</span></a>
                        </dd>
                    </dl>
                </li>
                <?php }?>
                <?php }?>
            </ul>
        </dd>
        </dl>
        </div>
        <div class="page-nav"><?php echo isset($goods['html'])?$goods['html']:"";?></div>
        <!--E 商品部分-->
    </div>
</div>
</div>
<!-- S 脚本处理 -->
<script>
    var attr_extra = '';
    $(".attr").each(function(i){
        var self = $(this);
        if(i>3){
            //self.css("display","none");
           // attr_extra += self.find(".attr-key:eq(0)").text()+"、";
        }
        if(self.find(".attr-value").get(0).scrollHeight>self.height()){
            var span = $("<div class='o-more'>更多<b></b></div>");
            self.append(span);
            if(self.find('.select').size()>0){
                span.html('收起<b></b>');
                span.parent().addClass("unflod");
            }
            span.on("click",function(){
                if($(this).text()=='更多'){
                    $(this).html('收起<b></b>');
                    $(this).parent().addClass("unflod");
                }
                else {
                    $(this).html('更多<b></b>');
                    $(this).parent().removeClass("unflod");
                }
            });
        }
    });

    attr_extra = $(".attr:gt(3) .attr-key").text();
    attr_extra = $.trim(attr_extra);
    attr_extra = attr_extra.replace(/：/gi,'、');
    attr_extra = attr_extra.replace(/、$/gi,'');
    if($(".attr:gt(3)").size()>0){

        if($(".attr:gt(3)").find(".select").size()>0){
            $(".attr:gt(3)").css("display","block");
            $(".attr-extra div:eq(0)").html('收起<b></b>');
            $(".attr-extra").addClass("unflod");
        }else{
            $(".attr:gt(3)").css("display","none");
            $(".attr-extra div:eq(0)").html('更多选项（'+attr_extra+'）<b></b>');
            $(".attr-extra").removeClass("unflod");
        }
    }else{
        $("#select-more").css("display","none");
    }
    $(".attr-extra:eq(0)").on("click",function(){
        if($(".attr:hidden").size()>0){
            $(".attr:gt(3)").css("display","block");
            $(".attr-extra div:eq(0)").html('收起<b></b>');
            $(".attr-extra").addClass("unflod");
        }else{
            $(".attr:gt(3)").css("display","none");
            $(".attr-extra div:eq(0)").html('更多选项（'+attr_extra+'）<b></b>');
            $(".attr-extra").removeClass("unflod");
        }

    })

$(".attention").on("click",function(){
    var id = $(this).attr("val");
        $.post("<?php echo urldecode(Url::urlFormat("/index/attention"));?>",{goods_id:id},function(data){
            if(data['status']==2) art.dialog.tips("<p class='warning'>已关注过了该商品！</p>");
            else if(data['status']==1) art.dialog.tips("<p class='success'>成功关注了该商品!</p>");
            else art.dialog.tips("<p class='warning'>你还没有登录！</p>");
        },'json')
    })
</script>
<!-- E 脚本处理 -->

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