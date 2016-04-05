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
        <div class="topbar">
            <div class="layout-2 container">
                <div class="sub-1"><?php if(isset($user['name'])){?>你好:<?php echo isset($user['name'])?$user['name']:"";?> - <?php }?><?php echo isset($site_name)?$site_name:"";?>！
                </div>
                <div class="sub-2">
                    <ul class="nav-x">
                        <li class="item down">
                            <a href="">会员中心<i class="fa">&#xf107;</i></a>
                            <div class="dropdown user-box">
                                <?php $sidebar_nav = array('我的订单'=>'order', '我的关注'=>'attention', '商品咨询'=>'consult', '商品评价'=>'review', '我的消息'=>'message', '收货地址'=>'address', '我的优惠券'=>'voucher', '账户金额'=>'account');?>
                                <ul class="user-center">
                                    <?php foreach($sidebar_nav as $key => $item){?>
                                    <li class="link"><a href="<?php echo urldecode(Url::urlFormat("/ucenter/$item"));?>"><?php echo isset($key)?$key:"";?></a></li>
                                    <?php }?>
                                </ul>
                            </div>
                        </li>
                        <li class="item split"></li>
                        <li class="item down"><a href="">关注商城</a>
                            <div class="dropdown">
                                <img src="http://tinyrise.com/static/images/weixin.jpg">
                            </div>
                        </li>
                        <li class="item split"></li>
                        <li class="item"><a href="<?php echo urldecode(Url::urlFormat("/ucenter/order"));?>">我的订单</a></li>
                        <li class="item split"></li>
                        <?php if($user){?>
                        <li class="item"><a href="<?php echo urldecode(Url::urlFormat("/simple/logout"));?>">安全退出</a></li>
                        <?php }else{?>
                        <li class="item"><a class="normal" href="<?php echo urldecode(Url::urlFormat("/simple/login"));?>">登录</a>/<a class="normal" href="<?php echo urldecode(Url::urlFormat("/simple/reg"));?>">注册</a></li>
                        <?php }?>
                    </ul>
                </div>
            </div>
        </div>
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
    <?php include './themes/default/apply/infoscript.php';?>


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