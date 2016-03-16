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
               <?php echo JS::import("form");?>
<?php echo JS::import('dialog?skin=tinysimple');?>
<link type="text/css" rel="stylesheet" href="<?php echo urldecode(Url::urlFormat("#css/ucenter.css"));?>" />
<script type="text/javascript" charset="UTF-8" src="<?php echo urldecode(Url::urlFormat("#js/jquery.iframe-post-form.js"));?>"></script>
<div class="container clearfix">
	<div id='widget_sub_navs'><?php $widget = Widget::createWidget('sub_navs');$widget->action = "ucsidebar";$widget->sidebar = $sidebar;$widget->act = $actionId;$widget->cache = "false";$widget->run();?></div>
	<div class=" clearfix uc-content" >
	<h1 class="title"><span>用户中心：</span></h1>
		<dl class="ucenter-index clearfix">
			<dt class="sub-1 clearfix">
				<?php if($user['head_pic']==''){?>
				<img id="head-pic" class="ie6png" src="<?php echo urldecode(Url::urlFormat("#images/no-img.png"));?>" width="120" height="120">
				<?php }else{?>
				<img id="head-pic" class="ie6png" src="<?php echo urldecode(Url::urlFormat("@$user[head_pic]"));?>" width="120" height="120">
				<?php }?>
				<p style="padding: 10px 30px;"><a href="javascript:;" id="upload-link">修改头像</a></p>
			</dt>
			<dd class="sub-2">
				<table width="100%" class="simple">
					<tr>
						<td colspan=2><b><?php echo isset($user['name'])?$user['name']:"";?></b>，欢迎你！<span class="fr">最后一次登录：<?php echo isset($user['login_time'])?$user['login_time']:"";?></span></td>
					</tr>
					<tr>
						<td width="50%" colspan="2">订单交易总金额：<?php echo isset($currency_symbol)?$currency_symbol:"";?><?php echo sprintf("%01.2f",$order['amount']);?></td>
					</tr>
					<tr>
						<td>进行中的订单：<?php echo isset($order['pending'])?$order['pending']:"";?> </td>
						<td>待评价的商品：<?php echo isset($comment['num'])?$comment['num']:"";?></td>
					</tr>
				</table>
			</dd>
		</dl>
	</div>
</div>
<div id="head-dialog" style="display: none">
	<div class="box" style="width:400px;">
		<h2>上传头像：</h2>
		<div class="content mt20 p10">
			<form enctype="multipart/form-data" action="<?php echo urldecode(Url::urlFormat("/ucenter/upload_head"));?>" method="post"  id="uploadForm">
				<p><input type="file" name="imgFile"></p>
				<p class="mt20 tc"><button class="btn" id="upload-btn">上传</button></p>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	$("#upload-link").on("click",function (){
		art.dialog({id:'head-dialog',lock:true,content:document.getElementById('head-dialog')});
	});

	$("#uploadForm").iframePostForm({
		iframeID: 'iframe-post-form',
		json:true,
		post: function(){
			$("#upload-btn").text("上传中...")
		},
		complete: function(data){
			if(data['error']==1){
				alert(data['message']);
			}else{
				var root_url = "<?php echo urldecode(Url::urlFormat("@"));?>"
				$("#head-pic").attr("src",root_url+data['url']+'?i='+Math.random());
				art.dialog({id:'head-dialog'}).close();
			}
			$("#upload-btn").text("上传");
		}
	});
</script>

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