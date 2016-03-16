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
        <div class="topbar">
            <div class="layout-2 container">
                <div class="sub-1"><?php if(isset($user['name'])){?>你好:<?php echo isset($user['name'])?$user['name']:"";?> - <?php }?><?php echo isset($site_name)?$site_name:"";?>！
                </div>
                <div class="sub-2">
                    <ul class="nav-x">
                        <li class="item down">
                            <a href="">会员中心<i class="fa">&#xf107;</i></a>
                            <div class="dropdown user-box">
                                <?php $sidebar_nav = array('我的订单'=>'order', '我的关注'=>'attention', '商品咨询'=>'consult', '商品评价'=>'review', '我的消息'=>'message', '收货地址'=>'address', '我的优惠券'=>'voucher', '账户金额'=>'account');?>
                                <ul class="user-center">
                                    <?php foreach($sidebar_nav as $key => $item){?>
                                    <li class="link"><a href="<?php echo urldecode(Url::urlFormat("/ucenter/$item"));?>"><?php echo isset($key)?$key:"";?></a></li>
                                    <?php }?>
                                </ul>
                            </div>
                        </li>
                        <li class="item split"></li>
                        <li class="item down"><a href="">关注商城</a>
                            <div class="dropdown">
                                <img src="http://tinyrise.com/static/images/weixin.jpg">
                            </div>
                        </li>
                        <li class="item split"></li>
                        <li class="item"><a href="<?php echo urldecode(Url::urlFormat("/ucenter/order"));?>">我的订单</a></li>
                        <li class="item split"></li>
                        <?php if($user){?>
                        <li class="item"><a href="<?php echo urldecode(Url::urlFormat("/simple/logout"));?>">安全退出</a></li>
                        <?php }else{?>
                        <li class="item"><a class="normal" href="<?php echo urldecode(Url::urlFormat("/simple/login"));?>">登录</a>/<a class="normal" href="<?php echo urldecode(Url::urlFormat("/simple/reg"));?>">注册</a></li>
                        <?php }?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container head-main">
            <div class="sub-1 logo"></div>
            <div class="sub-2">
                <form id="search-form" class="search-form" action="<?php echo urldecode(Url::urlFormat("/"));?>" method="get">
                    <input type="hidden" name="con" value="index">
                    <input type="hidden" name="act" value="search">
                    <input type='hidden' name='tiny_token_' value='<?php echo Tiny::app()->getToken("");?>'/>
                    <input  class="search-keyword" id="search-keyword" class="txt-keyword" name="keyword" value="<?php echo isset($keyword)?$keyword:"";?>" type="text">
                    <button class="btn-search ">搜索</button>

                    <p id="tags-list"><?php $item=null; $query = new Query("tags");$query->order = "is_hot desc,sort desc,num desc";$query->limit = "3";$items = $query->find(); foreach($items as $key => $item){?><a href="#"><?php echo isset($item['name'])?$item['name']:"";?></a><?php }?></p>
                </form>
            </div>
            <div class="sub-3">
                <div class="shopping" id="shopping-cart"><i class="icon-cart-32"></i>购物车
                    <div class="dropdown">
                        <ul class="cart-box " id="cart-list">
                            <?php $total=0.00;?><?php if($cart){?><?php foreach($cart as $key => $item){?> <?php $total += $item['amount'];?>
                            <li class="cart-item" id="<?php echo isset($item['id'])?$item['id']:"";?>">
                                <div class="pic">
                                    <a class="card-pic" href="<?php echo urldecode(Url::urlFormat("/index/product/id/$item[goods_id]"));?>" target="_blank" title="<?php echo isset($item['name'])?$item['name']:"";?>"><img src="<?php echo urldecode(Url::urlFormat("@$item[img]"));?>" width="50" height="50"></a>
                                </div>
                                <div class="spec">
                                    <?php foreach($item['spec'] as $key => $spec){?>
                                    <p title="<?php echo isset($spec['name'])?$spec['name']:"";?>:<?php echo isset($spec['value'][2])?$spec['value'][2]:"";?>"><?php echo isset($spec['value'][2])?$spec['value'][2]:"";?></p>
                                    <?php }?>
                                </div>
                                <div class="num"><?php echo isset($item['num'])?$item['num']:"";?></div>
                                <div class="price" title="<?php echo isset($item['amount'])?$item['amount']:"";?>"><?php echo isset($item['amount'])?$item['amount']:"";?></div>
                                <a class="icon-close-16 ie6png" productid="<?php echo isset($item['id'])?$item['id']:"";?>"></a>
                            </li>
                            <?php }?>
                            <?php }else{?>
                            <li><div>购物车中还没有商品，赶紧选购吧！</div></li>
                            <?php }?>

                        </ul>
                        <div class="cart-count">
                            <span>合计：</span><span class="cart-total"><?php echo isset($total)?$total:"";?></span>
                            <a href="<?php echo urldecode(Url::urlFormat("/simple/cart"));?>" class="btn btn-main">去购物车结算</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- S 导航栏 -->
        <div class="nav">
            <ul class="container">
                <li class="category-box">
                    <div class="link">
                    <a href="javascript:;">全部商品分类<i class="triangle-b"></i></a>
                    </div>
                    <ul class="category">
                        <?php $current_category_ids='';$parent_category='';?>
                        <?php foreach($category as $key => $categ){?>
                        <li><a href="<?php echo urldecode(Url::urlFormat("/index/category/cid/$categ[id]"));?>">
                            <?php if(isset($categ['id'])){?>
                            <?php $current_category_ids=$categ['id'].',';$parent_category=$categ['id'];?>
                            <?php }?> <?php echo isset($categ['title'])?$categ['title']:"";?><i class="fa">&#xf105;</i></a>
                            <div class="category-sub">
                                <ul class="sub">
                                    <?php foreach($categ['child'] as $key => $child){?>
                                    <li>
                                        <h5><a href="<?php echo urldecode(Url::urlFormat("/index/category/cid/$child[id]"));?>">
                                            <?php if(isset($child['id'])){?>
                                            <?php $current_category_ids.=$child['id'].',';?>
                                            <?php }?>
                                            <?php echo isset($child['title'])?$child['title']:"";?></a></h5>
                                            <p>
                                                <?php if(isset($child['child'])){?>
                                                <?php foreach($child['child'] as $key => $grandson){?>
                                                <a href="<?php echo urldecode(Url::urlFormat("/index/category/cid/$grandson[id]"));?>">
                                                    <?php if(isset($grandson['id'])){?>
                                                    <?php $current_category_ids.=$grandson['id'].',';?><?php }?>
                                                    <?php echo isset($grandson['title'])?$grandson['title']:"";?></a>
                                                    <?php }?>
                                                    <?php }?>
                                                </p>
                                            </li>
                                            <?php }?>
                                        </ul>
                                    </div>
                                </li>
                                <?php }?>
                            </ul>
                        </li>
                        <li class="link"><a href="<?php echo urldecode(Url::urlFormat("/index/index"));?>">首页</a></li>
                        <?php $item=null; $query = new Query("nav");$query->where = "type = 'main' and enable = 1";$query->order = "`sort` desc";$items = $query->find(); foreach($items as $key => $item){?>
                        <li class="link"><a href="<?php if(strstr($item['link'],'http://')===false){?><?php echo urldecode(Url::urlFormat("$item[link]"));?><?php }else{?><?php echo isset($item['link'])?$item['link']:"";?><?php }?>" target="<?php if($item['open_type']==1){?>_blank<?php }else{?>_self<?php }?>"><?php echo isset($item['name'])?$item['name']:"";?></a></li>
                        <?php }?>
                    </ul>
                </div>
                <!-- E 导航栏 -->
            </div>
            <!-- E 头部区域 -->
            <!-- S 主控区域 -->
            <div id="main">
               <div class="bg-base">
<div class="container">
<!--S 产品展示-->
<ol class="bread-crumb">
  <li><a href="#">商城▪团购</a></li>
  <li><a href="#">聚划算▪低价团</a></li>
</ol>
<ul class="product-list clearfix">
<?php $item=null; $groupbuy = new Query("groupbuy as gb");$groupbuy->fields = "*,gb.id as id";$groupbuy->join = "left join goods as go on gb.goods_id = go.id";$groupbuy->order = "is_end , goods_num desc";$groupbuy->limit = "12";$groupbuy->page = "1";$items = $groupbuy->find(); foreach($items as $key => $item){?>
    <li class="item">
        <dl class="product">
            <dt class="img"><a href="<?php echo urldecode(Url::urlFormat("/index/groupbuy/id/$item[id]"));?>"><img src="<?php echo Common::thumb($item['img'],600,360);?>" ></a></dt>
            <dd class="title"><a href="<?php echo urldecode(Url::urlFormat("/index/groupbuy/id/$item[id]"));?>"><?php echo TString::msubstr($item['title'],0,15);?></a></dd>
            <dd class="price"><i><?php echo isset($currency_symbol)?$currency_symbol:"";?></i><?php echo isset($item['price'])?$item['price']:"";?></dd>
            <dd class="status"><?php if($item['is_end']==0){?><a class="btn btn-main" href="<?php echo urldecode(Url::urlFormat("/index/groupbuy/id/$item[id]"));?>">立即团购</a><?php }else{?><span class="btn btn-gray disabled">团购结束</span><?php }?></dd>
        </dl>
    </li>
    <?php }?>
</ul>
<div class=" mt10 page-nav"><?php echo $groupbuy->pageBar();?></div>
<!--E 产品展示-->
</div>
</div>

           </div>
           <!-- E 主控区域 -->

           <!-- S 底部区域 -->
           <div id="footer">
            <div class="promise">
                <div class="clearfix container">
                    <dl>
                        <dt class="icon-1"></dt>
                        <dd>
                            <p class="title">诚信交易</p>
                            <p>所有产品均出正规渠道采购</p>
                        </dd>
                    </dl>
                    <dl>
                        <dt class="icon-2"></dt>
                        <dd>
                            <p class="title">60元包邮</p>
                            <p>全国各地，满60元快递包邮</p>
                        </dd>
                    </dl>
                    <dl>
                        <dt class="icon-3"></dt>
                        <dd>
                            <p class="title">极速更新</p>
                            <p>所有商品信息及时更新</p>
                        </dd>
                    </dl>
                    <dl>
                        <dt class="icon-4"></dt>
                        <dd>
                            <p class="title">7天退换货</p>
                            <p>会员享受7天无理由退换货</p>
                        </dd>
                    </dl>
                    <dl>
                        <dt class="icon-5"></dt>
                        <dd>
                            <p class="title">真实拍摄</p>
                            <p>100%真实拍摄，杜绝虚假</p>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="helps clearfix container">
                <?php $item=null; $query = new Query("help_category");$query->order = "sort desc";$query->limit = "5";$items = $query->find(); foreach($items as $key => $item){?>
                <dl >
                    <dt class="clearfix"><span class="icon-<?php echo isset($item['alias'])?$item['alias']:"";?> fl"></span><a href="javascript:;"><?php echo isset($item['name'])?$item['name']:"";?></a></dt>
                    <?php $help=null; $query = new Query("help");$query->where = "category_id = $item[id]";$query->item = "$help";$query->cache = "true";$query->cacheTime = "1200";$items = $query->find(); foreach($items as $key => $help){?>
                    <dd><a href="<?php echo urldecode(Url::urlFormat("/index/help/id/$help[id]"));?>"><?php echo isset($help['title'])?$help['title']:"";?></a></dd>
                    <?php }?>
                </dl>
                <?php }?>
                <div class="col-contact">
                    <p class="phone">400-100-5678</p>
                    <p>周一至周日 8:00-18:00
                        <br>（仅收市话费）</p>
                        <a class="btn btn-main">24小时在线客服</a>
                    </div>
                </div>
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