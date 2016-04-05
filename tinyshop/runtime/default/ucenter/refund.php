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
    <style>
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
    <?php include './themes/default/apply/refundscript.php';?>

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