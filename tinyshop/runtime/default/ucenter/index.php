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
    <?php include './themes/default/apply/ucenterindex.php';?>

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