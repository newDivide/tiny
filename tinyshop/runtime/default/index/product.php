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
        <div class="sub-right">
            <div class="goods-detail clearfix">
                <div class="content">
                    <div class="tab clearfix">
                        <ul class="tab-head">
                            <li>商品详情<i></i></li>
                            <li>商品评价<i></i></li>
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
                                <div class="description  clearfix" style="text-align: center;">
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

<?php include './themes/default/apply/productscript.php';?>
<!--E 产品展示-->

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