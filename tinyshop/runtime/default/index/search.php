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
<div class="bg-base">
    <ol class="bread-crumb container">
        <li>搜索结果:</li>
        <li><b>"<?php echo isset($keyword)?$keyword:"";?>"</b></li>
    </ol>
</div>
<div class="container">
    <div class="goods-detail mt10 clearfix" style="position: relative;">
        <div class="content">
            <!--S 筛选部分-->
            <div id="selector">

                <div class="spec-attr box">
                <h2><span><?php echo isset($keyword)?$keyword:"";?></span>  商品筛选</h2>

                    <!--S 分类-->
                    <?php $item=null; $query = new Query("goods_category");$query->where = "parent_id = 0";$items = $query->find(); foreach($items as $key => $item){?>
                    <?php if(isset($has_category[$item['id']])){?>
                    <dl class="attr clearfix">
                        <dt class="attr-key"><?php echo isset($item['name'])?$item['name']:"";?>：</dt>
                        <dd class="attr-value">
                            <?php foreach($has_category[$item['id']] as $key => $value){?>
                            <a <?php if(isset($selected['cid']) && $selected['cid']==$value['id']){?> class="select" <?php $url_tem=str_replace("/cid/$value[id]","",$url);?>href="<?php echo urldecode(Url::urlFormat("$url_tem"));?>" <?php }else{?>href="<?php echo urldecode(Url::urlFormat("$url/cid/$value[id]"));?>" <?php }?> ><?php echo isset($value['name'])?$value['name']:"";?>(<?php echo isset($value['num'])?$value['num']:"";?>)<i></i></a>
                            <?php }?>
                        </dd>
                    </dl>
                    <?php }?>
                    <?php }?>
                    <!--E 分类-->
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

                    <!--S 规格与属性-->
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
                    <!--E 规格与属性-->

                </div>
                <div id="select-more">
                    <div class="attr-extra"><div></div></div>
                </div>
            </div>
            <!--E 筛选部分-->
            <!--S 商品部分-->
            <div class="mt10 product_show  product-list  clearfix">
                <div class=" clearfix " style="margin-left: 12.5px;padding: 4px 0;">
                    <div class="sort-bar">
                        <span>排序：</span>
                        <a href="<?php echo urldecode(Url::urlFormat("$url/sort/0"));?>" <?php if($sort==0){?>class="current"<?php }?>>默认<i></i></a>
                        <a href="<?php echo urldecode(Url::urlFormat("$url/sort/1"));?>" <?php if($sort==1){?>class="current"<?php }?>>销量<i></i></a>
                        <a href="<?php echo urldecode(Url::urlFormat("$url/sort/2"));?>" <?php if($sort==2){?>class="current"<?php }?>>评论数<i></i></a>
                        <a <?php if($sort==4){?> href="<?php echo urldecode(Url::urlFormat("$url/sort/3"));?>" class="current-2" <?php }elseif($sort==3){?>href="<?php echo urldecode(Url::urlFormat("$url/sort/4"));?>" class="current"<?php }else{?> href="<?php echo urldecode(Url::urlFormat("$url/sort/4"));?>" <?php }?>>价格<i></i></a>
                        <a href="<?php echo urldecode(Url::urlFormat("$url/sort/5"));?>" <?php if($sort==5){?>class="current"<?php }?>>最新<i></i></a>
                    </div>
                </div>
                <dl>
                    <dd>
                        <ul>
                            <?php if(isset($goods['data'])){?>
                            <?php foreach($goods['data'] as $key => $item){?>
                            <li>
                                <dl class="product">
                                    <dt class="img"><a href="<?php echo urldecode(Url::urlFormat("/index/product/id/$item[id]"));?>"><img src="<?php echo Common::thumb($item['img'],220,220);?>" width=220></a></dt>
                                    <dd class="title"><a href="<?php echo urldecode(Url::urlFormat("/index/product/id/$item[id]"));?>"><?php if($keyword){?><?php echo preg_replace("/($keyword)/i","<b class='red'>$1</b>",TString::msubstr($item['name'],0,18));?><?php }else{?><?php echo TString::msubstr($item['name'],0,18);?><?php }?></a></dd>
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
        <?php include './themes/default/layout/searchscript.php';?>

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