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
               <link type="text/css" rel="stylesheet" href="<?php echo urldecode(Url::urlFormat("#css/ucenter.css"));?>" />
<div class="container clearfix">
	<div id='widget_sub_navs'><?php $widget = Widget::createWidget('sub_navs');$widget->action = "ucsidebar";$widget->sidebar = $sidebar;$widget->act = $actionId;$widget->cache = "false";$widget->run();?></div>
	<div class="clearfix uc-content">
			<h1 class="title"><span>商品评价：</span></h1>
			<div class="tab">
				<ul class="tab-head">
					<li>待评价商品<i></i></li>
					<li>已评价商品<i></i></li>
				</ul>
				<div class="tab-body" >
					<div id="review-n" class="js-template">
						<table class="simple">
							<tr><th width="160">订单编号</th> <th >商品名称</th> <th width="140">购买时间</th> <th width="80">评价</th></tr>
							<tbody class="page-content">
								<tr class="{odd-even}">
									<td>{order_no}</td> <td><a href="<?php echo urldecode(Url::urlFormat("/index/product/id/"));?>{gid}" target="_blank">{name}</a></td> <td>{buy_time}</td> <td><a class="btn btn-mini" href="<?php echo urldecode(Url::urlFormat("/index/review/id/"));?>{id}" target="_blank">评价</a></td>
								</tr>
							</tbody>
						</table>
						<div class="page-nav"></div>
					</div>
					<div id="review-y" class="js-template">
						<table class="simple">
							<tr><th width="160">订单编号</th> <th>商品名称</th> <th width="100">评价时间</th> <th width="80">我的评分</th></tr>
							<tbody class="page-content">
								<tr class="{odd-even}">
									<td>{order_no}</td> <td><a href="<?php echo urldecode(Url::urlFormat("/index/product/id/"));?>{gid}" target="_blank">{name}</a></td> <td>{comment_time}</td> <td><span class="score ">{point}</i></span></td>
								</tr>
							</tbody>
						</table>
						<div class="page-nav"></div>
					</div>
				</div>
			</div>
	</div>
</div>
<script type="text/javascript">
	$("#review-n").Paging({
		url:'<?php echo urldecode(Url::urlFormat("/ucenter/get_review"));?>',
		params:{status:'n'}
	});
	$("#review-y").Paging({
		url:'<?php echo urldecode(Url::urlFormat("/ucenter/get_review"));?>',
		params:{status:'y'}
	});
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