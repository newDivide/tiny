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
                   <?php include './themes/default/layout/footerscript.php';?>
                </body>
                </html>

<!--Powered by TinyRise-->