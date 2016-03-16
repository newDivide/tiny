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
<?php echo JS::import('form');?>
<?php echo JS::import('date');?>
<?php echo JS::import('dialog?skin=tinysimple');?>
<script type="text/javascript" charset="UTF-8" src="<?php echo urldecode(Url::urlFormat("#js/jquery.iframe-post-form.js"));?>"></script>
<div class="container clearfix">
	<div id='widget_sub_navs'><?php $widget = Widget::createWidget('sub_navs');$widget->action = "ucsidebar";$widget->sidebar = $sidebar;$widget->act = $actionId;$widget->cache = "false";$widget->run();?></div>
	<div class="content clearfix uc-content">
		<h1 class="title"><span>基本资料：</span></h1>
		<?php if(isset($msg)){?>
		<div class="message_<?php echo isset($msg[0])?$msg[0]:"";?> ie6png"><?php echo isset($msg[1])?$msg[1]:"";?></div>
		<?php }elseif(isset($validator)){?>
		<div class="message_warning ie6png"><?php echo isset($validator['msg'])?$validator['msg']:"";?></div>
		<?php }?>
		<div class="mt10" style="position:relative;">
			<div style="position: absolute;top:10px;right: 10px;">
				<?php if($user['head_pic']==''){?>
				<img id="head-pic" class="ie6png" src="<?php echo urldecode(Url::urlFormat("#images/no-img.png"));?>" width="120" height="120">
				<?php }else{?>
				<img id="head-pic" class="ie6png" src="<?php echo urldecode(Url::urlFormat("@$user[head_pic]"));?>" width="120" height="120">
				<?php }?>
				<p style="padding: 10px 30px;"><a href="javascript:;" id="upload-link">修改头像</a></p>
			</div>
			<form id="info-form" class="simple" action="<?php echo urldecode(Url::urlFormat("/ucenter/info_save"));?>" method="post">
				<table class="form">
					<tr><td class="label">会员帐号：</td><td><?php if(Validator::match('\d+@no.com',$info['email'])){?><input type="text" pattern="email" name="email" value="<?php echo isset($email)?$email:"";?>" alt="邮箱格式错误"> <label></label><?php }else{?><?php echo isset($email)?$email:"";?><?php }?></td></tr>
					<tr><td class="label">会员级别：</td><td><?php echo isset($gname)?$gname:'默认分组';?></td></tr>
					<tr>
						<td class="label">昵称：</td><td><input type="text" pattern="required" name="name" maxlen="20" value="<?php echo isset($name)?$name:"";?>" alt="长度不得超过20个字"> <label></label></td>
					</tr>
					<tr>
						<td class="label">真实姓名：</td><td><input type="text" pattern="required" name="real_name" maxlen="20" value="<?php echo isset($real_name)?$real_name:"";?>" alt="长度不得超过20个字"> <label></label></td>
					</tr>
					<tr>
						<td class="label">性别：</td><td><input name="sex" type="radio" value="0" checked="checked"> <label> 女</label>&nbsp;&nbsp;<input name="sex" type="radio" <?php if(isset($sex) && $sex==1){?>checked="checked"<?php }?> value="1"> <label> 男</label></td>
					</tr>
					<tr>
						<td class="label">生日：</td><td><input name="birthday" type="text" onfocus="WdatePicker()" class="Wdate"  value="<?php echo isset($birthday)?$birthday:"";?>" ><label></label></td>
					</tr>
					<tr>
						<td class="label">手机号码：</td><td><?php if(Validator::mobi($info['mobile'])){?><?php echo isset($mobile)?$mobile:"";?><?php }else{?><input type="text" pattern="mobi" name="mobile" value="<?php echo isset($mobile)?$mobile:"";?>" alt="请正确填写手机号"><label></label><?php }?></td>
					</tr>
					<tr>
						<td class="label">电话号码：</td><td><input type="text" name="phone"  value="<?php echo isset($phone)?$phone:"";?>" empty pattern="phone" alt="请正确填写电话号码"><label></label></td>
					</tr>
					<tr><td class="label">所在地区：</td><td id="area"><select id="province"  name="province" >
						<option value="0">==省份/直辖市==</option>
					</select>
					<select id="city" name="city"><option value="0">==市==</option></select>
					<select id="county" name="county"><option value="0">==县/区==</option></select><input pattern="^\d+,\d+,\d+$" id="test" type="text" style="visibility:hidden;width:0;" value="<?php echo isset($province)?$province:"";?>,<?php echo isset($city)?$city:"";?>,<?php echo isset($county)?$county:"";?>" alt="请选择完整地区信息！"><label></label></td></tr>
					<tr>
						<td class="label">街道地址：</td><td><textarea name="addr" pattern="required" minlen="5" maxlen="120" alt="不需要重复填写省市区，必须大于5个字符，小于120个字符"><?php echo isset($addr)?$addr:"";?></textarea> <label>&nbsp;</label></td>
					</tr>
					<tr>
						<td colspan="2" class="tc"><input type="submit" class="btn" value="保存"></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>
<div id="head-dialog" style="display: none">
	<div class="box" style="width:400px;">
		<h2>上传头像：</h2>
		<div class="content mt20 p10">
			<form enctype="multipart/form-data" action="<?php echo urldecode(Url::urlFormat("/ucenter/upload_head"));?>" method="post"  id="uploadForm">
				<p><input type="file" name="imgFile" ></p>
				<p class="mt20 tc"><button class="btn" id="upload-btn">上传</button></p>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	$("#upload-link").on("click",function (){
		art.dialog({id:'head-dialog',content:document.getElementById('head-dialog'),lock:true});
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

	var form =  new Form('info-form');
	form.setValue('is_default','<?php echo isset($is_default)?$is_default:"";?>');
	$("#areas").Linkage({ url:"<?php echo urldecode(Url::urlFormat("/ajax/area_data"));?>",selected:[<?php echo isset($province)?$province:0;?>,<?php echo isset($city)?$city:0;?>,<?php echo isset($county)?$county:0;?>],callback:function(data){
		var text = new Array();
		var value = new Array();
		for(i in data[0]){
			if(data[0][i]!=0){
				text.push(data[1][i]);
				value.push(data[0][i]);
			}
		}
		$("#test").val(value.join(','));
		FireEvent(document.getElementById("test"),"change");
	}});
	<?php if(isset($invalid)){?>
	autoValidate.showMsg({id:$("input[name='<?php echo isset($invalid['name'])?$invalid['name']:"";?>']").get(0),error:true,msg:'<?php echo isset($invalid['msg'])?$invalid['msg']:"";?>'});
	<?php }?>
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