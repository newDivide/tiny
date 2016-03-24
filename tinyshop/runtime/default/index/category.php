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
 <?php include './themes/default/apply/categoryscript.php';?>
<!-- E 脚本处理 -->

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