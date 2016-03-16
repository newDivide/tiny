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
               <link type="text/css" rel="stylesheet" href="<?php echo urldecode(Url::urlFormat("#css/ucenter.css"));?>" />
<div class="container clearfix">
	<div id='widget_sub_navs'><?php $widget = Widget::createWidget('sub_navs');$widget->action = "ucsidebar";$widget->sidebar = $sidebar;$widget->act = $actionId;$widget->cache = "false";$widget->run();?></div>
	<div class="uc-content">
		<h1 class="title"><span>我的订单：</span></h1>
		<div class="box list-item order-status">
			<div class="title"><b>订单号：</b><i class="icon-order-<?php echo isset($order['type'])?$order['type']:"";?>-32"></i><?php echo isset($order['order_no'])?$order['order_no']:"";?><b>下单日期：</b><?php echo isset($order['create_time'])?$order['create_time']:"";?> <b>状态：</b>
				<?php echo $this->order_status($order);?></div>
				<p><?php echo isset($order['create_time'])?$order['create_time']:"";?>&nbsp;&nbsp;<span class="black">订单创建</span></p>
				<?php if($order['pay_status']>0){?>
				<p><?php echo isset($order['pay_time'])?$order['pay_time']:"";?>&nbsp;&nbsp;<span class="black">订单<?php echo isset($order['order_no'])?$order['order_no']:"";?> 付款 <?php echo isset($currency_symbol)?$currency_symbol:"";?><b><?php echo isset($order['order_amount'])?$order['order_amount']:"";?></b></span></p>
				<?php }?>
				<?php if($order['status']>=3){?>
				<p><span class="black">订单<?php echo isset($order['order_no'])?$order['order_no']:"";?> 已审核通过！</span></p>
				<?php }?>
				<?php if($order['delivery_status']>0){?>
				<p><?php echo isset($order['send_time'])?$order['send_time']:"";?>&nbsp;&nbsp;<span class="black">订单<b class="orange">全部商品</b>已发货</span></p>
				<?php }?>
				<?php if($order['status']==4){?>
				<p><?php echo isset($order['completion_time'])?$order['completion_time']:"";?>&nbsp;&nbsp;<span class="black">订单完成</span></p>
				<?php }?>
			</div>
			<div>
				<table class="simple form">
					<tr>
						<th class="tl" style="padding-left: 20px;" colspan=2>收货人信息：</th>
					</tr>
					<tr><td class="label">收货人：</td><td><?php echo isset($order['accept_name'])?$order['accept_name']:"";?></td></tr>
					<tr><td class="label">地&nbsp;&nbsp;&nbsp;&nbsp;址：</td><td><?php echo isset($parse_area[$order['province']])?$parse_area[$order['province']]:"";?> <?php echo isset($parse_area[$order['city']])?$parse_area[$order['city']]:"";?> <?php echo isset($parse_area[$order['county']])?$parse_area[$order['county']]:"";?> <?php echo isset($order['addr'])?$order['addr']:"";?></td></tr>
					<tr><td class="label">电&nbsp;&nbsp;&nbsp;&nbsp;话：</td><td><?php echo isset($order['phone'])?$order['phone']:"";?></td></tr>
					<tr><td class="label">手&nbsp;&nbsp;&nbsp;&nbsp;机：</td><td><?php echo isset($order['mobile'])?$order['mobile']:"";?></td></tr>
				</table>
			</div>
			<div>
				<table class="simple form">
					<tr>
						<th class="tl" style="padding-left: 20px;" colspan=2>支付及配送方式：</th>
					</tr>
					<tr><td class="label">支付方式：</td><td><?php echo isset($order['pay_name'])?$order['pay_name']:"";?></td></tr>
					<tr><td class="label">运&nbsp;&nbsp;&nbsp;&nbsp;费：</td><td><?php echo isset($order['real_freight'])?$order['real_freight']:"";?></td></tr>
					<?php if($order['delivery_status']>0){?>
					<tr><td class="label">物流公司：</td><td><?php echo isset($invoice['ec_name'])?$invoice['ec_name']:"";?></td></tr>
					<tr><td class="label">快递单号：</td><td><?php echo isset($invoice['express_no'])?$invoice['express_no']:"";?>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-mini" href="http://www.kuaidi100.com/chaxun?com=<?php echo isset($invoice['ec_code'])?$invoice['ec_code']:"";?>&nu=<?php echo isset($invoice['express_no'])?$invoice['express_no']:"";?>" target="_blank">查询物流</a>
					</td></tr>
					<?php }?>
				</table>
			</div>
			<?php if($order['is_invoice']==1){?>
			<?php $invoice = explode(':',$order['invoice_title']);?>
			<div>
				<table class="simple form">
					<tr>
						<th class="tl" style="padding-left: 20px;" colspan=2>索要发票信息：</th>
					</tr>
					<tr><td class="label">发票类型：</td><td><?php if($invoice[0]==1){?>单位<?php }else{?>个人<?php }?></td></tr>
					<tr><td class="label">发票抬头：</td><td><?php echo isset($invoice[1])?$invoice[1]:"";?></td></tr>
				</table>
			</div>
			<?php }?>
			<div>
				<h2 class="mt20">购物清单</h2>
				<table class="simple">
					<tr>
						<th width="40"></th><th>商品名称</th><th width="140">商品编号</th><th width="100">规格</th><th width="80">商品价格</th> <th width="80">优惠后价格</th> <th width="40">数量</th> <th width="80">小计</th>
					</tr>
					<?php $total=0.00;$subtotal=0.00;?>
					<?php foreach($order_goods as $key => $item){?>
					<?php $subtotal = ($item['real_price']*$item['goods_nums']);$total+=$subtotal; $subtotal = sprintf ("%01.2f",$subtotal);?>
					<tr class="<?php if($key%2==1){?>even<?php }else{?>odd<?php }?>"><td><a href="<?php echo urldecode(Url::urlFormat("/index/product/id/$item[goods_id]"));?>" target="_blank"><img src="<?php echo Common::thumb($item['img'],100,100);?>" width="40"></a></td><td><a href="<?php echo urldecode(Url::urlFormat("/index/product/id/$item[goods_id]"));?>" target="_blank"><?php echo isset($item['name'])?$item['name']:"";?></a>
					</td><td><?php echo isset($item['pro_no'])?$item['pro_no']:"";?></td> <td> <?php $specs = unserialize($item['spec']);?>
					<?php if(!empty($specs)){?>
					<?php foreach($specs as $key => $spec){?>
					<?php echo isset($spec['name'])?$spec['name']:"";?>：<?php echo isset($spec['value'][2])?$spec['value'][2]:"";?>
					<?php }?>
					<?php }?></td><td><?php echo isset($currency_symbol)?$currency_symbol:"";?><?php echo isset($item['goods_price'])?$item['goods_price']:"";?></td> <td><?php echo isset($currency_symbol)?$currency_symbol:"";?><?php echo isset($item['real_price'])?$item['real_price']:"";?></td> <td><?php echo isset($item['goods_nums'])?$item['goods_nums']:"";?></td> <td><?php echo isset($currency_symbol)?$currency_symbol:"";?><?php echo isset($subtotal)?$subtotal:"";?></td></tr>
					<?php }?>
				</table>
			</div>
			<?php $total = sprintf ("%01.2f",$total);?>
			<div class="box p10 tr order-total">
				<div class="pb10">
					<?php if($order['type']==3){?>
					<p>套餐总金额：<?php echo isset($currency_symbol)?$currency_symbol:"";?><?php echo isset($order['real_amount'])?$order['real_amount']:"";?></p>
					<?php }else{?>
					<p>商品总金额：<?php echo isset($currency_symbol)?$currency_symbol:"";?><?php echo isset($total)?$total:"";?></p>
					<?php }?>
					<p>+ 运费：<?php echo isset($currency_symbol)?$currency_symbol:"";?><?php echo isset($order['real_freight'])?$order['real_freight']:"";?></p>
					<?php if($order['taxes']>0){?>
					<p>+ 税：<?php echo isset($currency_symbol)?$currency_symbol:"";?><?php echo isset($order['taxes'])?$order['taxes']:"";?></p>
					<?php }?>
					<p>- 优惠：<?php echo isset($currency_symbol)?$currency_symbol:"";?><?php echo isset($order['discount_amount'])?$order['discount_amount']:"";?></p>
					<?php if($order['adjust_amount']!=0){?>
					<p><?php if($order['adjust_amount']>0){?>+<?php }else{?>-<?php }?> 价格调整：<?php echo isset($currency_symbol)?$currency_symbol:"";?><?php echo trim($order['adjust_amount'],'-');?></p>
					<p>调价原因：<?php echo isset($order['adjust_note'])?$order['adjust_note']:'无原因';?></p>
					<?php }?>
				</div>
				<div class="t-line pt10 total">
					订单支付金额：<b><?php echo isset($currency_symbol)?$currency_symbol:"";?><?php echo isset($order['order_amount'])?$order['order_amount']:"";?></b>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function order_sign(id) {
			$.post("<?php echo urldecode(Url::urlFormat("/ucenter/order_sign"));?>",{id:id},function(data){
				if(data['status']=='success'){
					location.reload();
				}
			},'json');
		}
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