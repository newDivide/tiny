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
        <?php include './themes/default/layout/topbar.php';?>
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
               <?php echo JS::import('form');?>
<link type="text/css" rel="stylesheet" href="<?php echo urldecode(Url::urlFormat("#css/ucenter.css"));?>" />
<div class="container clearfix">
	<div id='widget_sub_navs'><?php $widget = Widget::createWidget('sub_navs');$widget->action = "ucsidebar";$widget->sidebar = $sidebar;$widget->act = $actionId;$widget->cache = "false";$widget->run();?></div>
	<div class="content clearfix uc-content">
     <h1 class="title"><span>申请退款：</span></h1>
     <?php if(isset($msg)){?>
     <div class="message_<?php echo isset($msg[0])?$msg[0]:"";?> ie6png"><?php echo isset($msg[1])?$msg[1]:"";?></div>
     <?php }elseif(isset($validator)){?>
     <div class="message_warning ie6png"><?php echo isset($validator['msg'])?$validator['msg']:"";?></div>
     <?php }?>
     <div >
        <form class="box" action="<?php echo urldecode(Url::urlFormat("/ucenter/refund_act"));?>" method="post">
           <h2>直接退款申请:</h2>
           <table class="form">
              <tr><td class="label">订单编号：</td><td><input name="order_no" pattern="required" type="text" alt="请填写正确的订单编号"></td></tr>
              <tr><td class="label">退款方式：</td>
                  <td id="refund_type">
                      <label class="attr"><input class="radio" type="radio" name="refund_type" value="1" checked="checked" >退款至银行卡（跨行退款需支付银行手续费）</label><br>
                      <label class="attr"><input class="radio" type="radio" name="refund_type" value="2" >其它方式:（如支付宝、财付通等等）</label>
                  </td></tr>
                  <tr class="refund_radio refund_0 hidden"><td class="label">开户行/支付方式：</td><td><input name="account_bank" type="text" pattern="required" alt="不能为空！"></td></tr>
                  <tr class="refund_radio refund_1 hidden"><td class="label">开户名：</td><td><input name="account_name" type="text" pattern="required" alt="开户名不能为空！"></td></tr>
                  <tr class="refund_radio refund_2 hidden"><td class="label" >账号：</td><td><input name="refund_account" type="text" pattern="required" alt="账号不能为空！"></td></tr>
                  <tr><td class="label">申请退款原因：</td><td><textarea name="content" minlen=5 pattern="required" alt="内容至少包含5字!" ></textarea><label>&nbsp;</label></td></tr>
                  <tr><td class="label"> </td><td><input type="submit" class="btn" value="申请退款"></td></tr>
              </table>
              <input type='hidden' name='tiny_token_' value='<?php echo Tiny::app()->getToken("");?>'/>
          </form>
      </div>
      <div id="voucher-n" class="mt10">
        <table class="simple">
            <tr><th >订单编号</th> <th width="120">退款方式</th> <th width="140">申请时间</th> <th width="140">处理状态</th> <th width="150">操作</th></tr>
            <tbody class="page-content">
               <?php $item=null; $refund = new Query("doc_refund");$refund->where = "user_id = $user[id]";$refund->page = "1";$items = $refund->find(); foreach($items as $key => $item){?>
               <tr class="{odd-even}">
                  <td><a href="<?php echo urldecode(Url::urlFormat("/ucenter/order_detail/id/$item[order_id]"));?>"><?php echo isset($item['order_no'])?$item['order_no']:"";?></a></td> <td><?php if($item['refund_type']==0){?>至账户余额<?php }elseif($item['refund_type']==1){?>至银行卡<?php }else{?>其它方式<?php }?></td> <td><?php echo isset($item['create_time'])?$item['create_time']:"";?></td> <td><?php if($item['pay_status']==0){?>等待处理<?php }elseif($item['pay_status']==1){?>不予退款<?php }else{?>退款成功<?php }?></td> <td><?php if($item['pay_status']==0){?><a class="btn btn-gray btn-mini" href="<?php echo urldecode(Url::urlFormat("/ucenter/refund_del/order_no/$item[order_no]"));?>">取消</a><?php }?> <a class="btn btn-main btn-mini"  href="<?php echo urldecode(Url::urlFormat("/ucenter/refund_detail/id/$item[id]"));?>">详情</a></td>
              </tr>
              <?php }?>
          </tbody>
      </table>
      <div class="page-nav"><?php echo $refund->pageBar();?></div>
  </div>
</div>
</div>
<script type="text/javascript">
    $("input[name='refund_type']").on("click",function(){
    	var val = $(this).val();
    	switch(val){
    		case '0':
         $(".refund_0").addClass("hidden");
         $(".refund_1").addClass("hidden");
         $(".refund_2").addClass("hidden");
         break;
         case '2':
         $(".refund_0").removeClass("hidden");
         $(".refund_1").addClass("hidden");
         $(".refund_2").removeClass("hidden");
         break;
         case '1':
         $(".refund_0").removeClass("hidden");
         $(".refund_1").removeClass("hidden");
         $(".refund_2").removeClass("hidden");
         break;
     }
     $(".refund_radio input").css('display','');
     $(".hidden input").css('display','none');
 })
    $(".hidden input").css('display','none');
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