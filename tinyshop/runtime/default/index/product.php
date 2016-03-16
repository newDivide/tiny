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
<?php echo JS::import('form');?>
<link type="text/css" rel="stylesheet" href="<?php echo urldecode(Url::urlFormat("#css/product.css"));?>" />
<script type='text/javascript' src="<?php echo urldecode(Url::urlFormat("#js/jquery.enlarge.js"));?>"></script>
<div class="bread-crumb">
    <ol class="container">
      <?php foreach($category_nav as $key => $item){?>
      <li><a class="category-<?php echo isset($key)?$key:"";?>" href="<?php echo urldecode(Url::urlFormat("/index/category/cid/$item[id]"));?>"><?php echo isset($item['name'])?$item['name']:"";?> <?php if($item!=end($category_nav)){?><?php }?></a></li>
      <?php }?>
  </ol>
</div>
<div class="container">
    <!--S 产品展示-->
    <div id="product-intro">
        <div class="sub-1">
            <div id="gallery">
                <a class="turn-left ie6png"></a>
                <div class="show-list">
                    <div style="position: absolute;height:800px;">
                        <?php foreach(unserialize($goods['imgs']) as $key => $img){?>
                        <?php if($key <5){?>
                        <a class="small-img" href="javascript:;"><img src="<?php echo Common::thumb($img,367);?>"  source="<?php echo urldecode(Url::urlFormat("@$img"));?>" width="60"></a>
                        <?php }?>
                        <?php }?>
                    </div>
                </div>
                <a class="turn-right ie6png"></a>
            </div>
        </div>
        <div class="sub-2">
            <div id="preview" >
                <div id="imgmini" style="width: 420px;height:420px;"><img class="big-pic" width="420"  src="<?php echo Common::thumb($goods['img'],420);?>" source="<?php echo urldecode(Url::urlFormat("@$goods[img]"));?>"></div>
            </div>
        </div>
        <div class="sub-3">
            <ul class="product-info">
                <li class="product-title"><?php echo TString::msubstr($goods['name'],0,22);?></li>
                <li class="product-no"><label>货号：</label><span id="pro-no"><?php echo isset($goods['goods_no'])?$goods['goods_no']:"";?></span></li>
                <?php if(!empty($prom)){?>
                <?php if(isset($user['group_id'])){?>
                <?php $group_id = ','.$user['group_id'].',';?>
                <?php }?>
                <li class="product-price "><span id="prom_price" class="price" formula="<?php echo isset($prom['parse']['minus'])?$prom['parse']['minus']:"";?>"><?php echo isset($prom['parse']['real_price'])?$prom['parse']['real_price']:"";?> <?php echo isset($currency_unit)?$currency_unit:"";?></span><i class="promo-type"><?php echo isset($prom['name'])?$prom['name']:"";?><?php if($prom['parse']['note']!=''){?><?php }?></i><i class="icon-clock ie6png"></i></li>
                <li>
                    <?php if(isset($group_id)){?>
                    <?php if(stripos(','.$prom['group'].',',$group_id)===false){?>
                    你的会员级别，无法享受此活动。
                    <?php }else{?>
                    <?php echo isset($prom['parse']['note'])?$prom['parse']['note']:"";?> /
                    <i class="icon-clock ie6png"></i>结束时间：<span id="countdown1"  style="color:#333; "></span>
                    <script type="text/javascript">
                        $("#countdown1").countdown({end_time:"<?php echo date('Y/m/d H:i:s',strtotime($prom['end_time']));?>"});
                    </script>
                    <?php }?>
                    <?php }else{?>
                    登录后查看是否享受此活动。
                    <?php }?>
                </li>
                <?php }else{?>
                <li class="product-price"><span id="sell_price" class="price"><?php echo isset($goods['sell_price'])?$goods['sell_price']:"";?><?php echo isset($currency_unit)?$currency_unit:"";?></span></li>
                <?php }?>
                <?php if($goods['store_nums']>0){?>
                <!-- <li class="clearfix"><label></label><span>库存&nbsp;&nbsp;</span><span id="goods_nums">(<?php echo isset($goods['store_nums'])?$goods['store_nums']:"";?>)</span></li> -->
                <?php }else{?>
                <li class="clearfix"><label><b class="f16">无货</b></label><span>此商品暂时售完</span>  <span class="btn btn-gray btn-mini" id="goods-notify">到货通知</span></li>
                <?php }?>
            </ul>
            <?php $specs_array = unserialize($goods['specs']);?>
            <?php if(count($specs_array)>0){?>
            <fieldset class="line-title">
                <legend align="center" class="txt">商品规格</legend>
            </fieldset>
            <?php }else{?>
            <fieldset class="line-title">
            </fieldset>
            <?php }?>
            <div class="spec-info">
                <div class="spec-close"></div>
                <?php foreach(unserialize($goods['specs']) as $key => $spec){?>
                <dl class="spec-item clearfix">
                    <dt><?php echo isset($spec['name'])?$spec['name']:"";?></dt>
                    <dd>
                        <ul class="spec-values clearfix" spec_id="<?php echo isset($spec['id'])?$spec['id']:"";?>">
                            <?php foreach($spec['value'] as $key => $value){?>
                            <li data-value="<?php echo isset($spec['id'])?$spec['id']:"";?>:<?php echo isset($value['id'])?$value['id']:"";?>"><?php if($value['img']==''){?><span><?php echo isset($value['name'])?$value['name']:"";?></span><?php }else{?><img src="<?php echo Common::thumb($value['img'],100);?>"  width="36" height="36"><label><?php echo isset($value['name'])?$value['name']:"";?></label><?php }?><i></i></li>
                            <?php }?>
                        </ul>
                    </dd>
                </dl>
                <?php }?>
                <dl class="spec-item clearfix">
                    <dt>购买量</dt>
                    <dd class="buy-num" id="buy-num-bar"><a href="javascript:;"><i class="icon-minus-16"></i></a><input id="buy-num" name="buy_num" value="1"  maxlength=5><a href="javascript:;"><i class="icon-plus-16"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<span class="vm">库存：<b id="store_nums" class="red"><?php echo isset($goods['store_nums'])?$goods['store_nums']:"";?></b></span></dd>
                </dl>
                <dl id="spec-msg" class="spec-item clearfix" style="display: none;">
                    <dt></dt>
                    <dd ><p class="msg"><i class="icon icon-alert-16"></i><span >请选择您要购买的商品规格</span></p>
                    </dd>
                </dl>
                <dl class="spec-item clearfix">
                    <dd class="product-btns">
                        <a href="javascript:;" id="buy-now" class="btn btn-warning"><i class="icon-basket-32 ie6png"></i><span>立即购买</span></a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="javascript:;" id="add-cart" class="btn btn-main"><i class="icon-cart-1-32 ie6png"></i><span>加入购物车</span></a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="javascript:;" id="attention" class="btn btn-info"><i class="icon-hart-32 ie6png"></i><span>关注</span></a>
                    </dd>
                </dl>
            </div>
        </div>
    </div>

    <!--S 商品详情-->
    <div class="clearfix">
        <div class="sub-left mt20">
            <fieldset class="line-title">
                <legend align="center" class="txt">同类商品推荐</legend>
            </fieldset>
            <ul>
                <?php $path_like = "like '$goods[path]%'";?>
                <?php $item=null; $query = new Query("goods");$query->where = "is_online = 0 and category_id in (select id from tiny_goods_category where path $path_like)";$query->order = "sort desc";$query->limit = "10";$items = $query->find(); foreach($items as $key => $item){?>
                <?php if($goods['id']!=$item['id']){?>
                <li class="product">
                    <dl>
                        <dt class="img tc"><a href="<?php echo urldecode(Url::urlFormat("/index/product/id/$item[id]"));?>"><img src="<?php echo Common::thumb($item['img'],220,220);?>" width=200></a></dt>
                        <dd><a href="<?php echo urldecode(Url::urlFormat("/index/product/id/$item[id]"));?>"><?php echo TString::msubstr($item['name'],0,14);?></a></dd>
                        <dd><span class="price">售价：<b class="red"><?php echo isset($currency_symbol)?$currency_symbol:"";?><?php echo isset($item['sell_price'])?$item['sell_price']:"";?></b></span></dd>
                    </dl>
                </li>
                <?php }?>
                <?php }?>
            </ul>
        </div>
        <div class="sub-right">
            <div class="goods-detail clearfix">
                <div class="content">
                    <!--S 捆绑销售 -->
                    <?php $query = new Query("bundling");$query->where = "CONCAT(',',goods_id,',') like '%,$goods[id],%' and status = 1";$bundling = $query->find();?>
                    <?php if($bundling){?>
                    <div class="tab ">
                        <ul class="tab-head">
                            <?php foreach($bundling as $key => $item){?>
                            <li>优惠套装<?php echo ($key+1);?><i></i></li>
                            <?php }?>
                        </ul>
                        <div class="tab-body" style="min-height: 180px;">
                            <ul class="bundling-list">
                                <?php foreach($bundling as $key => $bun){?>
                                <?php $gids = $goods['id'].','.$bun['goods_id'];$total_price=0.00;?>
                                <li class="sub-1 group-item">
                                    <?php $item=null; $query = new Query("goods");$query->where = "id in($gids)";$query->order = "field(`id`,$gids)";$items = $query->find(); foreach($items as $key => $item){?>
                                    <?php $total_price+=$item['sell_price'];?>
                                    <dl class="product goods-item">
                                        <?php if($key!=0){?><s class="icon-add ie6png icon-plus-16"></s><?php }?>
                                        <dt class="img">
                                            <a href="<?php echo urldecode(Url::urlFormat("/index/product/id/$item[id]"));?>"><img src="<?php echo Common::thumb($item['img'],100,100);?>" width="100"></a>
                                        </dt>
                                        <dd class="title"><a href="<?php echo urldecode(Url::urlFormat("/index/product/id/$item[id]"));?>"><?php echo TString::msubstr($item['name'],0,6);?></a></dd>
                                        <dd class="price"><b class="red price"><?php echo isset($item['sell_price'])?$item['sell_price']:"";?><?php echo isset($currency_unit)?$currency_unit:"";?></b></dd>
                                    </dl>
                                    <?php }?>

                                </li>
                                <li class="sub-2 group-item">
                                    <div class="goods-item" >
                                        <s class="icon-add ie6png icon-equal-16"></s>
                                        <div><?php echo isset($bun['title'])?$bun['title']:"";?></div>
                                        <div>套&nbsp;&nbsp;装&nbsp;&nbsp;价： <?php echo isset($currency_symbol)?$currency_symbol:"";?><?php echo isset($bun['price'])?$bun['price']:"";?></div>
                                        <div>原　　价： <del><?php echo isset($currency_symbol)?$currency_symbol:"";?><?php echo isset($total_price)?$total_price:"";?></del></div>
                                        <div>立即节省： <?php echo isset($currency_symbol)?$currency_symbol:"";?><?php echo $total_price-$bun['price'];?></div>
                                        <div class="mt10"><a href="<?php echo urldecode(Url::urlFormat("/index/bundbuy/id/$bun[id]"));?>" class="btn btn-main">购买套装</a></div>
                                    </div>
                                </li>
                                <?php }?>
                            </ul>
                        </div>
                    </div>
                    <?php }?>
                    <!--S 捆绑销售 -->
                    <div class="tab clearfix">
                        <ul class="tab-head">
                            <li>商品详情<i></i></li>
                            <li>商品评价<i></i></li>
                            <li>商品咨询<i></i></li>
                            <li>售后服务<i></i></li>
                        </ul>
                        <div class="tab-body" style="min-height: 200px;">
                            <!--S 商品详情-->
                            <div class=" clearfix">
                                <div class="">
                                    <ul class="attr-list ">
                                        <li>商品名称：<?php echo isset($goods['name'])?$goods['name']:"";?></li>
                                        <li>商品编号：<?php echo isset($goods['pro_no'])?$goods['pro_no']:"";?></li>
                                        <li>商品重量：<?php echo isset($goods['weight'])?$goods['weight']:"";?>g</li>
                                        <li>上架时间：<?php echo isset($goods['create_time'])?$goods['create_time']:"";?></li>
                                        <?php foreach($goods_attrs as $key => $item){?>
                                        <li><?php echo isset($item['name'])?$item['name']:"";?>：<?php echo isset($item['vname'])?$item['vname']:"";?></li>
                                        <?php }?>
                                    </ul>
                                </div>
                                <div class="description  clearfix" >
                                    <?php echo isset($goods['content'])?$goods['content']:"";?>
                                </div>
                            </div>
                            <!--E 商品详情-->
                            <!--S 商品评价-->
                            <div class="comment-list">
                                <div class="comment-top clearfix">
                                    <ul>
                                        <li>
                                            <div class="tc comment-score"><em class="tc circle "><?php echo isset($comment['a']['percent'])?$comment['a']['percent']:"";?><i style="font-size: 18px;">%</i></em>- 好评度 -</div>
                                            <div class="mt10 score ie6png"><i style="width:<?php echo isset($comment['a']['percent'])?$comment['a']['percent']:"";?>%"></i></div>
                                        </li>
                                        <li class="comment-grade">
                                            <div>
                                                <h1>共有(<?php echo isset($comment['total'])?$comment['total']:"";?>)人参考评价</h1>
                                                <dl class="comment-percent">
                                                    <dt>很好</dt>
                                                    <dd class="bar"><i style="width:<?php echo isset($comment['a']['percent'])?$comment['a']['percent']:"";?>%"></i></dd>
                                                    <dd class="percent"><?php echo isset($comment['a']['percent'])?$comment['a']['percent']:"";?>%</dd>
                                                    <dt>较好</dt>
                                                    <dd class="bar"><i style="width:<?php echo isset($comment['b']['percent'])?$comment['b']['percent']:"";?>%"></i></dd>
                                                    <dd class="percent"><?php echo isset($comment['b']['percent'])?$comment['b']['percent']:"";?>%</dd>
                                                    <dt>一般</dt>
                                                    <dd class="bar"><i style="width:<?php echo isset($comment['c']['percent'])?$comment['c']['percent']:"";?>%"></i></dd>
                                                    <dd class="percent"><?php echo isset($comment['c']['percent'])?$comment['c']['percent']:"";?>%</dd>
                                                </dl>
                                            </div>
                                        </li>
                                        <li class="comment-action">
                                            <div>
                                                <?php $uid = isset($user['id'])?$user['id']:0;?>
                                                <?php $query = new Query("review");$query->where = "goods_id = $id and user_id = $uid and status = 0";$query->limit = "1";$items = $query->find();?>
                                                <?php if($items){?>
                                                <?php foreach($items as $key => $item){?>
                                                <a href="<?php echo urldecode(Url::urlFormat("/index/review/id/$item[id]"));?>" class="btn btn-main">我要评论</a>
                                                <?php }?>
                                                <?php }else{?>
                                                <a href="javascript:;" class="btn btn-gray  disabled">我要评论</a>
                                                <?php }?>
                                                <p class="mt10">仅对购买过该商品的用户开放！</p>

                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="comment tab" id="comment">
                                    <ul class="tab-head">
                                        <li>全部(<?php echo isset($comment['total'])?$comment['total']:"";?>)<i></i></li>
                                        <li>很好(<?php echo isset($comment['a']['num'])?$comment['a']['num']:"";?>)<i></i></li>
                                        <li>较好(<?php echo isset($comment['b']['num'])?$comment['b']['num']:"";?>)<i></i></li>
                                        <li>一般(<?php echo isset($comment['c']['num'])?$comment['c']['num']:"";?>)<i></i></li>
                                    </ul>
                                    <div class="tab-body">
                                        <div id="comment-all" class="js-template">
                                            <div class="page-content">
                                                <div class="comment-item">
                                                    <div class="consult-q">
                                                        <div class="head">
                                                            <img src="{head_pic}" width="80" height="80">
                                                            <strong cla>{uname}</strong>
                                                            <i class="arrow"><b></b></i>
                                                        </div>
                                                        <div class="comment-content">
                                                            <p class="top"><span class="score "><i style="width:{point}%"></i></span><span class="fr">{comment_time|今天}</span></p>
                                                            <p >{content|默认评论}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="page-nav"></div>
                                        </div>

                                        <div id="comment-a" class="js-template">
                                            <div class="page-content">
                                                <div class="comment-item">
                                                    <div class="consult-q">
                                                        <div class="head">
                                                            <img src="{head_pic}" width="80" height="80">
                                                            <strong>{uname}</strong>
                                                            <i class="arrow"><b></b></i>
                                                        </div>
                                                        <div class="comment-content">
                                                            <p class="top"><span class="score "><i style="width:{point}%"></i></span><span class="fr">{comment_time|今天}</span></p>
                                                            <p >{content|默认好评}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="page-nav"></div>
                                        </div>

                                        <div id="comment-b" class="js-template">
                                            <div class="page-content">
                                                <div class="comment-item">
                                                    <div class="consult-q">
                                                        <div class="head">
                                                            <img src="{head_pic}" width="80" height="80">
                                                            <strong>{uname}</strong>
                                                            <i class="arrow"><b></b></i>
                                                        </div>
                                                        <div class="comment-content">
                                                            <p class="top"><span class="score "><i style="width:{point}%"></i></span><span class="fr">{comment_time|今天}</span></p>
                                                            <p >{content|默认中评}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="page-nav"></div>
                                        </div>

                                        <div id="comment-c" class="js-template">
                                            <div class="page-content">
                                                <div class="comment-item">
                                                    <div class="consult-q">
                                                        <div class="head">
                                                            <img src="{head_pic}" width="80" height="80">
                                                            <strong>{uname}</strong>
                                                            <i class="arrow"><b></b></i>
                                                        </div>
                                                        <div class="comment-content">
                                                            <p class="top"><span class="score "><i style="width:{point}%"></i></span><span class="fr">{comment_time|今天}</span></p>
                                                            <p >{content|默认差评}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="page-nav"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!--E 商品评价-->
                            <!--S 商品咨询-->
                            <div class="consult clearfix" >
                                <form>
                                    <div>
                                        <div class="txt-panel mb5">
                                            <textarea name="content" id="consult-content"  class="p5 "></textarea>
                                        </div>
                                        <div class="consult-footer"><span class="fl"><input type="text" class="input" name="verifyCode" id="verifyCode" style="width: 80px;" ><img id="captcha_img"  src="<?php echo urldecode(Url::urlFormat("/simple/captcha/h/40/w/120"));?>"><label><a href="javascript:void(0)" class="red" onclick="document.getElementById('captcha_img').src='<?php echo urldecode(Url::urlFormat("/simple/captcha/h/40/w/120/random/"));?>'+Math.random()" id="change-img">换一张</a></label></span>
                                            <span class="fr">
                                                <input type="submit" id="consult" value="咨询" class="btn btn-main"> <input type="reset" value="取消" class="btn btn-gray">
                                            </span>
                                        </div>
                                    </div>
                                </form>
                                <div id="goods-consult" class="js-template">
                                    <div  class="page-content" id="page-content">
                                        <div class="consult-item">
                                            <div class="consult-q">
                                                <div class="head">
                                                    <img  src="{head_pic}" style="width:80px;height:80px;">
                                                    <strong>{uname|网友}</strong>
                                                    <i class="arrow"><b></b></i>
                                                </div>
                                                <div class="consult-content">{question}
                                                    <p class="tr">{ask_time}</p>
                                                </div>
                                            </div>
                                            <div class="consult-a {content||hidden}" >
                                                <div class="head">
                                                    <img src="<?php echo urldecode(Url::urlFormat("#images/no-img.png"));?>" width="80" height="80">
                                                    <strong>商城客服</strong>
                                                    <i class="arrow"><b></b></i>
                                                </div>
                                                <div class="consult-content">{content}
                                                    <p class="tl">{reply_time|今天}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="page-nav"></div>
                                </div>
                            </div>
                            <!--E 商品咨询-->
                            <!--S 售后保障-->
                            <div class="clearfix">
                                <?php if($goods['sale_protection']){?>
                                <div class="mb20">
                                    <?php echo isset($goods['sale_protection'])?$goods['sale_protection']:"";?>
                                </div>
                                <?php }?>
                                <div >
                                    <?php echo isset($sale_protection)?$sale_protection:"";?>
                                </div>
                            </div>
                            <!--E 售后保障-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--E 商品详情-->
    <div  id="notify-dialog" class="hidden">
        <form id="notify_form"  method="post"  callback="submit_notify">
            <h1>订阅到货通知：</h1>
            <table class="form" style="width:400px;">
                <tr>
                    <td class="label"><b class="red">*</b> 邮箱地址：</td>
                    <td> <input type="text" id="n_email" name="email" pattern="email" ></td>
                </tr>
                <tr>
                    <td class="label">手机号码：</td>
                    <td><input type="text" id="n_mobile" empty name="mobile"   pattern="mobi"></td>
                </tr>
                <tr>
                    <td colspan="2" class="tc"><input type="submit" class="btn" value="到货通知"></td>
                </tr>
            </table>
        </form>
    </div>
</div>
<script type="text/javascript">
    $("#goods-consult").Paging({
        url:'<?php echo urldecode(Url::urlFormat("/index/get_ask"));?>',
        params:{id:<?php echo isset($goods['id'])?$goods['id']:"";?>}
    });
    $("#comment-all").Paging({
        url:'<?php echo urldecode(Url::urlFormat("/index/get_review"));?>',
        params:{id:<?php echo isset($goods['id'])?$goods['id']:"";?>}
    });
    $("#comment-a").Paging({
        url:'<?php echo urldecode(Url::urlFormat("/index/get_review"));?>',
        params:{id:<?php echo isset($goods['id'])?$goods['id']:"";?>,score:'a'}
    });
    $("#comment-b").Paging({
        url:'<?php echo urldecode(Url::urlFormat("/index/get_review"));?>',
        params:{id:<?php echo isset($goods['id'])?$goods['id']:"";?>,score:'b'}
    });
    $("#comment-c").Paging({
        url:'<?php echo urldecode(Url::urlFormat("/index/get_review"));?>',
        params:{id:<?php echo isset($goods['id'])?$goods['id']:"";?>,score:'c'}
    });

    $("#consult").on("click",function(){

        var content = $("#consult-content").val();
        var verifyCode = $("#verifyCode").val();
        if(!Tiny.user.online)art.dialog.alert('登录后确认才能咨询！');
        else if(content=='')art.dialog.alert("内容不能为空！");
        else if(verifyCode=='')art.dialog.alert("验证码不能为空！");
        else{
            $.post("<?php echo urldecode(Url::urlFormat("/index/goods_consult"));?>",{id:'<?php echo isset($goods['id'])?$goods['id']:"";?>',content:content,verifyCode:verifyCode},function(data){
                if(data['status']=='success'){
                    $("#goods-consult").Paging({
                        url:'<?php echo urldecode(Url::urlFormat("/index/get_ask"));?>',
                        params:{id:<?php echo isset($goods['id'])?$goods['id']:"";?>}
                    });
                    $("#consult-content").val('');
                    $("#verifyCode").val('');
                    FireEvent(document.getElementById('change-img'),"click");
                    art.dialog.tips("<p class='success'>发布成功!</p>");
                }else{
                    art.dialog.alert("<p class='fail'>"+data['msg']+"</p>");
                }
            },'json')
        }

        return false;
    })

    $("#imgmini").enlarge({
        // 鼠标遮罩层样式
        shadecolor: "#FFF",
        shadeborder: "#FF8000",
        shadeopacity: 0.5,
        cursor: "move",

        // 大图外层样式
        layerwidth: 420,
        layerheight: 420,
        layerborder: "#FFF",
        fade: true});
    var skuMap = <?php echo JSON::encode($skumap);?>;
    //更新库存信息
    var store_nums = 0;
    for(i in skuMap){
        store_nums += parseInt(skuMap[i]['store_nums']);
    }
    $("#store_nums").text(store_nums);
    $("#goods_nums").text(store_nums);

    $("#gallery  .small-img").each(function(i){
        if(i==0)$(this).addClass("current");
        $(this).on("mouseenter",function(){
            $(this).parent().find("a").removeClass("current");
            $(this).addClass("current");
            $("#imgmini img").attr("src",$(this).find("img").attr("src"));
            $("#imgmini img").attr("source",$(this).find("img").attr("source"));
        })
    });
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
                    $("#sell_price").text(sku['sell_price']+"<?php echo isset($currency_unit)?$currency_unit:"";?>");
                    $("#store_nums").text(sku['store_nums']);
                    $("#goods_nums").text(sku['store_nums']);
                    if($("#prom_price").size()>0){
                        var formula = $("#prom_price").attr('formula');
                        var prom_price = eval(sku['sell_price']+formula);
                        if(prom_price<=0)prom_price = 0;
                        $("#prom_price").text(prom_price.toFixed(2)+" <?php echo isset($currency_unit)?$currency_unit:"";?>");
                    }

                    $("#market-price").text(sku['market_price']);
                    $("#pro-no").text(sku['pro_no']);
                }
                $("#spec-msg").css("display","none");
                specClose();
            }else{
                $("#store_nums").text("<?php echo isset($goods['store_nums'])?$goods['store_nums']:"";?>");
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
    $("#buy-num-bar a:eq(0)").on("click",function(){
        var num = $("#buy-num-bar input").val();
        if(num>1) num--;
        else num=1;
        $("#buy-num-bar input").val(num);
        btnNumStatus(num);
    });
    $("#buy-num-bar a:eq(1)").on("click",function(){
        var num = $("#buy-num-bar input").val();
        var max = parseInt($("#store_nums").text());
        if(num<max) num++;
        else num=max;
        $("#buy-num-bar input").val(num);
        btnNumStatus(num);
    });
    $("#buy-num-bar input").on("change",function(){
        var value = $(this).val();
        var max = parseInt($("#store_nums").text());
        if((/^\d+$/i).test(value)){
            value = Math.abs(parseInt(value));
            if(value<1) value = 1;
            if(value>max) value = max;
        }else{
            value = 1;
        }
        $(this).val(value);
        btnNumStatus(value);
    })
    function btnNumStatus(value){
        var max = parseInt($("#store_nums").text());
        if(value <= 1){
            $("#buy-num-bar a:eq(0)").addClass('disable');
        }else{
            $("#buy-num-bar a:eq(0)").removeClass('disable');
        }
        if(value >= max){
            $("#buy-num-bar a:eq(1)").addClass('disable');
        }else{
            $("#buy-num-bar a:eq(1)").removeClass('disable');
        }
    }
//立即购买
$("#buy-now").on("click",function(){
    var product = currentProduct();
    if(product){
        var id = product["id"];
        var num = parseInt($("#buy-num").val());
        var max = parseInt($("#store_nums").text());
        if(num > max){
            $("#spec-msg").css("display","");
            showMsgBar('stop',"购买商品数量，超出了允许购买的最大量！");
            return false;
        }else if(max<=0){
            $("#spec-msg").css("display","");
            showMsgBar('stop',"库存不足！");
            return false;
        }
        else{
            $("#spec-msg").css("display","none");
        }
        var url = "<?php echo urldecode(Url::urlFormat("/index/goods_add/id/__id__/num/__num__"));?>";
        url = url.replace("__id__",id);
        url = url.replace("__num__",num);
        window.location.href = url;
    }else{
        $("#spec-msg").css("display","");
        showMsgBar('alert',"请选择您要购买的商品规格！");
    }
});
    //添加到购物车
    $("#add-cart").on("click",function(){
        var product = currentProduct();
        if(product){
            var id = product["id"];
            var num = parseInt($("#buy-num").val());
            var max = parseInt($("#store_nums").text());
            var cart_num = parseInt($("#"+id).find(".num").text());
            if((num+cart_num)>max){
                $("#spec-msg").css("display","");
                showMsgBar('stop',"连同购物车里的商品数量，超出了允许购买的最大量！");
                return false;
            }else if(max<=0){
                $("#spec-msg").css("display","");
                showMsgBar('stop',"库存不足！");
                return false;
            }
            else{
                $("#spec-msg").css("display","none");
            }
            $.post("<?php echo urldecode(Url::urlFormat("/index/cart_add"));?>",{id:id,num:num},function(data){
                updateCart(data);

                var tmp=$($("#imgmini img").get(0).cloneNode(true));
                tmp.css({position: 'absolute','z-index':'9998', border:'solid 1px #ccc', background:'#aaf','overflow':'hidden' ,background:'#fff'});
                var imgView=$("#imgmini").offset();
                tmp.css(imgView);
                tmp.appendTo($('body'));
                var end = $(".shopping").offset();
                step1 = {top:end.top+160,left:end.left+30,width:100,height:100,opacity:0.8};
                step2 = {top:end.top,left:end.left+30,width:100,height:100,opacity:0};

                $(tmp).animate(step1,"slow").animate(step2, "slow",function(){
                    tmp.remove();
                });
            },"json");
        }else{
            $("#spec-msg").css("display","");
            showMsgBar('alert',"请选择您要购买的商品规格！");
        }
    });
    //关闭信息提示
    $(".spec-close").on("click",function(){
        specClose();
    });
    function specClose()
    {
        $(".spec-info").removeClass("noselected");
    }
    //取得当前商品
    function currentProduct(){
        if($(".spec-values").length==0){
            return skuMap[''];
        }
        if($(".spec-values").length == $(".spec-values .selected").not(".disabled").length){
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
    //切换画廊图片
    $(".turn-right,.turn-left").on("click",function(){
        var canvas = $(".show-list >div");
        var num = canvas.find("a").size();
        var flage = -1;
        var current = 0;
        var width = 66;
        var show_num = 5;
        var left = 0;
        current = Math.round((Math.abs(canvas.position().left)/width));
        if($(this).hasClass("turn-left")){
            current--;
        }else{
            current++;
        }
        if(num-current>=show_num && current>=0){
            left = current*flage*width;
            canvas.animate({left:left},200);
        }
    })

    $("#attention").on("click",function(){
        $.post("<?php echo urldecode(Url::urlFormat("/index/attention"));?>",{goods_id:<?php echo isset($id)?$id:"";?>},function(data){
            if(data['status']==2) art.dialog.tips("<p class='warning'>已关注过了该商品！</p>");
            else if(data['status']==1) art.dialog.tips("<p class='success'>成功关注了该商品!</p>");
            else art.dialog.tips("<p class='warning'>你还没有登录！</p>");
        },'json')
    })
    //到货通知
    $("#goods-notify").on("click",function(){
        if(Tiny['user']['online']){
            art.dialog({id:'notify-dialog',content:document.getElementById('notify-dialog')});
        }else{
            art.dialog.tips("<p class='warning'>你还没有登录！</p>");
        }

    })
    function submit_notify(e)
    {
     if(e==null){
        var email = $("#n_email").val();
        var mobile = $("#n_mobile").val();
        $.post("<?php echo urldecode(Url::urlFormat("/index/notify"));?>",{goods_id:<?php echo isset($goods['id'])?$goods['id']:"";?>,email:email,mobile:mobile},function(data){
            if(data['status']!= undefined){
                art.dialog({id:'notify-dialog'}).close();
                art.dialog.tips('<p class="'+data['status']+'">'+data['msg']+'</p>');
            }
        },'json');
        return false;
    }
    return false;
}
</script>
<!--E 产品展示-->

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