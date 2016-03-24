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
	<div class="content clearfix uc-content">
			<h1 class="title"><span>我的关注：</span></h1>
			<form action="<?php echo urldecode(Url::urlFormat("/ucenter/attention_del"));?>" method="post">
			<table class="simple attention">
				<tr>
					<th width="30"></th><th width="100"></th> <th >商品</th> <th width="100">价格</th> <th width="60">库存</th> <th width="110">操作</th>
				</tr>
				<?php foreach($attention['data'] as $key => $item){?>
				<tr class="<?php if($key%2==1){?>odd<?php }else{?>even<?php }?>">
					<td><input type="checkbox" name="id[]" value="<?php echo isset($item['id'])?$item['id']:"";?>" ></td><td><a href="<?php echo urldecode(Url::urlFormat("/index/product/id/$item[gid]"));?>" target="_blank"><img src="<?php echo Common::thumb($item['img'],100,100);?>" width="60" height="60"></a></td> <td><a href="<?php echo urldecode(Url::urlFormat("/index/product/id/$item[gid]"));?>" target="_blank"><?php echo TString::msubstr($item['name'],0,20);?></a>
					<p class="pt5">关注时间：<?php echo isset($item['time'])?$item['time']:"";?></p></td> <td class="red" style="font-size:14px;"><b><?php echo isset($currency_symbol)?$currency_symbol:"";?><?php echo isset($item['sell_price'])?$item['sell_price']:"";?></b></td> <td><?php if($item['store_nums']>0){?>有货<?php }else{?>缺货<?php }?></td> <td><a href="<?php echo urldecode(Url::urlFormat("/index/product/id/$item[gid]"));?>" class=" btn btn-main" target="_blank">去购买</a><p class="pt5">&nbsp;&nbsp;<a href="<?php echo urldecode(Url::urlFormat("/ucenter/attention_del/id/$item[id]"));?>" >取消关注</a></p></td>
				</tr>
				<?php }?>
			</table>
			<div class="page-nav"><p class="fl" style="padding-left: 10px;"><input id="select-all" type="checkbox" >&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" href="javascript:;" id="cancel-attention" class=" btn btn-mini" title="全选" data="true" >取消关注</button></p><?php echo isset($attention['html'])?$attention['html']:"";?></div>
			</form>
		</div>
</div>
<script type="text/javascript">
	$("#select-all").on("click",function(){
		$('input[name="id[]"]').prop('checked',!!$(this).prop('checked'));
	})
</script>

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