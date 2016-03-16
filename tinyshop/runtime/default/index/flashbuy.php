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
               <?php echo JS::import('dialog?skin=brief');?>
<?php echo JS::import('dialogtools');?>
<?php echo JS::import('form');?>
<!--E 产品展示-->
<link type="text/css" rel="stylesheet" href="<?php echo urldecode(Url::urlFormat("#css/product.css"));?>" />
<div class="container ">
    <!--S 产品展示-->
    <div class="clearfix mt20" style="position: relative;">
        <!-- S 抢购推荐 -->
        <div class="sidebar fr" style="width: 230px;">
            <div class="mt20">
                <fieldset class="line-title">
                    <legend align="center" class="txt">抢购推荐</legend>
                </fieldset>
                <ul class="content child-category-list ">
                    <?php $item=null; $query = new Query("flash_sale as gb");$query->fields = "*,gb.id as id";$query->join = "left join goods as go on gb.goods_id = go.id";$query->where = "is_end = 0";$query->order = "goods_num desc";$query->limit = "10";$items = $query->find(); foreach($items as $key => $item){?>
                    <?php if($goods['id']!=$item['id']){?>
                    <li class="mt20">
                        <dl>
                            <dt class="img tc"><a href="<?php echo urldecode(Url::urlFormat("/index/flashbuy/id/$item[id]"));?>"><img src="<?php echo Common::thumb($item['img'],220,220);?>" width=220></a></dt>
                            <dd><a href="<?php echo urldecode(Url::urlFormat("/index/product/id/$item[id]"));?>"><?php echo isset($item['title'])?$item['title']:"";?></a></dd>
                            <dd><span class="price">抢购价：<b class="red"><?php echo isset($currency_symbol)?$currency_symbol:"";?><?php echo isset($item['price'])?$item['price']:"";?></b></span><span class="market_price fr"><?php echo isset($item['goods_num'])?$item['goods_num']:"";?>人已购买</span></dd>

                        </dl>
                    </li>
                    <?php }?>
                    <?php }?>
                </ul>
            </div>
        </div>
        <!-- E 抢购推荐 -->
        <div class="content" style="margin-right: 240px;">
            <div class="markting">
                <div class="sub-1">
                    <img class="big-pic" src="<?php echo Common::thumb($goods['img'],367);?>" width='367' height='367'>
                </div>
                <div class="sub-2" id="product-intro">
                    <ul class="product-info" >
                        <li class="product-title"><?php echo TString::msubstr($goods['title'],0,22);?></li>
                        <li class="product-no"><label>货号：</label><span id="pro-no"><?php echo isset($goods['goods_no'])?$goods['goods_no']:"";?></span></li>

                        <li class="product-price markting-price <?php if($goods['is_end']==1){?>end<?php }?>" style="position: relative;"><span id="prom_price" class="price" formula="<?php echo isset($prom['parse']['minus'])?$prom['parse']['minus']:"";?>"><?php echo isset($goods['price'])?$goods['price']:"";?><?php echo isset($currency_unit)?$currency_unit:"";?> </span>
                            <div class="product-btns" style="display:inline;float:right;padding-right: 10px;">
                                <?php if($goods['is_end']==1){?>
                                <span class="btn btn-war disabled">已结束</span>

                                <?php }elseif(time() < strtotime($goods['start_time'])){?>
                                <span class="btn btn-gray disabled">等待开始</span>
                                <?php }else{?>
                                <span id="buy-now" class="btn btn-warning">立即抢购</span>
                                <?php }?>
                            </div>
                        </li>
                    </ul>
                    <div class="markting-info">
                        <ul  >
                            <li >原价<br><del class="del"><?php echo isset($currency_symbol)?$currency_symbol:"";?><?php echo isset($goods['sell_price'])?$goods['sell_price']:"";?></del></li>
                            <li >折扣<br><span class="del"><?php echo sprintf("%0.2f",$goods['price']*10/$goods['sell_price']);?></span></li>
                            <li class="end">节省<br><span class="del"><?php echo $goods['sell_price']-$goods['price'];?></span></li>
                        </ul>
                    </div>

                    <div class="content">
                        <div class="info">
                            <?php if($goods['is_end']==1 ){?>
                            <p class="markting-ext"><i class="icon-time-16 ie6png"></i> 已结束！<span class="fr"><i class="icon-fire-16 ie6png"></i> 共有<?php echo isset($goods['order_num'])?$goods['order_num']:"";?>人购买</span></p>
                            <?php }elseif(time()>strtotime($goods['start_time'])){?>
                            <p class="markting-ext"><span > <i class="icon-time-16 ie6png"></i> 还剩：</span><span id="countdown1"  style="color:#666;"></span><span class="fr"><i class="icon-fire-16 ie6png"></i> <b><?php echo isset($goods['order_num'])?$goods['order_num']:"";?></b>人已经购买</span>
                            </p>
                            <script type="text/javascript">
                                $("#countdown1").countdown({end_time:"<?php echo date('Y/m/d H:i:s',strtotime($goods['end_time']));?>",callback:function(){
                                    $.post("<?php echo urldecode(Url::urlFormat("/ajax/flashbuy_end"));?>",{id:<?php echo isset($id)?$id:"";?>},function(){
                                        location.reload();
                                    });
                                }});
                            </script>
                            <?php }else{?>
                            <p class="markting-ext">
                                <i class="icon-time-16 ie6png"></i><span>距开始：</span><span id="countdown2"  style="color:#666; "></span>
                            </p>
                            <script type="text/javascript">
                                $("#countdown2").countdown({end_time:"<?php echo date('Y/m/d H:i:s',strtotime($goods['start_time']));?>",callback:function(){
                                    location.reload();
                                }});
                            </script>
                            <?php }?>
                        </div>
                    </div>
                    <?php $specs_array = unserialize($goods['specs']);?>
                    <?php if(count($specs_array)>0){?>
                    <fieldset class="line-title">
                        <legend align="center" class="txt">商品规格</legend>
                    </fieldset>
                    <?php }?>
                    <div class="spec-info " style="">
                        <div class="spec-close"></div>
                        <?php foreach(unserialize($goods['specs']) as $key => $spec){?>
                        <dl class="spec-item ">
                            <dt><?php echo isset($spec['name'])?$spec['name']:"";?>：</dt>
                            <dd>
                                <ul class="spec-values" spec_id="<?php echo isset($spec['id'])?$spec['id']:"";?>">
                                    <?php foreach($spec['value'] as $key => $value){?>
                                    <li data-value="<?php echo isset($spec['id'])?$spec['id']:"";?>:<?php echo isset($value['id'])?$value['id']:"";?>"><?php if($value['img']==''){?><span><?php echo isset($value['name'])?$value['name']:"";?></span><?php }else{?><img src="<?php echo Common::thumb($value['img'],100,100);?>"  width="36" height="36"><label><?php echo isset($value['name'])?$value['name']:"";?></label><?php }?><i></i></li>
                                    <?php }?>
                                </ul>
                            </dd>
                        </dl>
                        <?php }?>
                        <dl id="spec-msg" class="spec-item " style="display: none;">
                            <dt></dt>
                            <dd ><p class="msg"><i class="icon icon-alert ie6png"></i><span >请选择您要购买的商品规格</span></p>
                            </dd>
                        </dl>

                    </div>
                </div>
            </div>
            <div class="mt10 tab content">
                <ul class="tab-head">
                    <li>商品详情<i></i></li>
                </ul>
                <div class="tab-body" style="min-height: 200px;">
                    <!--S 商品详情-->
                    <div class="p10">
                        <div>
                            <ul class="attr-list">
                                <li>商品名称：<?php echo isset($goods['name'])?$goods['name']:"";?></li>
                                <li>商品编号：<?php echo isset($goods['pro_no'])?$goods['pro_no']:"";?></li>
                                <li>商品重量：<?php echo isset($goods['weight'])?$goods['weight']:"";?>g</li>
                                <li>上架时间：<?php echo isset($goods['up_time'])?$goods['up_time']:"";?></li>
                                <?php foreach($goods_attrs as $key => $item){?>
                                <li><?php echo isset($item['name'])?$item['name']:"";?>：<?php echo isset($item['vname'])?$item['vname']:"";?></li>
                                <?php }?>
                            </ul>
                        </div>
                        <div class="description">
                            <?php if($goods['description']==''){?>
                            <?php echo isset($goods['content'])?$goods['content']:"";?>
                            <?php }else{?>
                            <?php echo isset($goods['description'])?$goods['description']:"";?>
                            <?php }?>
                        </div>
                    </div>
                    <!--E 商品详情-->
                </div>
            </div>
        </div>
    </div>


</div>
<script type="text/javascript">

    var skuMap = <?php echo JSON::encode($skumap);?>;

    $(".spec-values li").each(function(){
        $(this).on("click",function(){
            var disabled = $(this).hasClass('disabled');
            if(disabled) return;
            var flage = $(this).hasClass('selected');

            $(this).parent().find("li").removeClass("selected");
            if(!flage){
                $(this).addClass("selected");
            }
            changeStatus();
            if($(".spec-values").length == $(".spec-values .selected").length){
                var sku = new Array();
                $(".spec-values .selected").each(function(i){
                    sku[i]= $(this).attr("data-value");
                })
                var sku_key = ";"+sku.join(";")+";";
                if(skuMap[sku_key]!=undefined){
                    var sku = skuMap[sku_key];
                    //$("#sell_price").text("<?php echo isset($currency_symbol)?$currency_symbol:"";?>"+sku['sell_price']);
                    //$("#store_nums").text(sku['store_nums']);
                    //$("#market-price").text(sku['market_price']);
                    $("#pro-no").text(sku['pro_no']);
                    specClose();
                }
                $("#spec-msg").css("display","none");
            }
        })
})
function changeStatus(){
    var specs_array = new Array();
    $(".spec-values").each(function(i){
        var selected = $(this).find(".selected");
        if(selected.length>0)specs_array[i]=selected.attr("data-value");
        else specs_array[i] = "\\\d+:\\\d+";
    });
    $(".spec-values").each(function(i){
        var selected = $(this).find(".selected");
        $(this).find("li").removeClass("disabled");
        var k = i;
        $(this).find("li").each(function(){

            var temp = specs_array.slice();
            temp[k] = $(this).attr('data-value');
            var flage = false;
            for(sku in skuMap){
                var reg = new RegExp(';'+temp.join(";")+';');
                if(reg.test(sku) && skuMap[sku]['store_nums']>0) flage = true;
            }
            if(!flage)$(this).addClass("disabled");
        })

    });
}
//关闭信息提示
$(".spec-close").on("click",function(){
    specClose();
});
function specClose()
{
    $(".spec-info").removeClass("noselected");
}
    //立即抢购
    $("#buy-now").on("click",function(){
        var product = currentProduct();
        if(product){
            var id = product["id"];
            var url = "<?php echo urldecode(Url::urlFormat("/simple/order_info/type/flashbuy/id/$id/pid/"));?>"+id;
            window.location.href = url;
        }else{
            $("#spec-msg").css("display","");
            showMsgBar('alert',"请选择您要购买的商品规格！");
        }
    });

    //取得当前商品
    function currentProduct(){
        if($(".spec-values").length==0)return skuMap[''];
        if($(".spec-values").length == $(".spec-values .selected").length){
            var sku = new Array();
            $(".spec-values .selected").each(function(i){
                sku[i]= $(this).attr("data-value");
            })
            var sku_key = ";"+sku.join(";")+";";
            if(skuMap[sku_key]!=undefined){
                return skuMap[sku_key];
            }else return null;
        }
        else return null;
    }
    //展示信息
    function showMsgBar(type,text){
        $(".spec-info").addClass("noselected");
        $(".msg").find("span").text(text);
        $(".msg").find("i").attr("class","icon icon-"+type+"-16");
    }

</script>
<!--E 产品展示-->

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