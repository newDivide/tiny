<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="HandheldFriendly" content="True">
    <?php include './themes/default/layout/import.php';?>

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
	<div class="uc-content">
			<h1 class="title"><span>退款详情：</span></h1>
			<div class=" box" >
				<h2>申请详情:</h2>
				<div class="p10">
					<table class="simple">
						<tr> <td><b>订单编号：</b><a href="<?php echo urldecode(Url::urlFormat("/ucenter/order_detail/id/$refund[order_id]"));?>" target="_blank"><?php echo isset($refund['order_no'])?$refund['order_no']:"";?></a></td> <td><b>创建时间：</b><?php echo isset($refund['create_time'])?$refund['create_time']:"";?></td> </tr>
						<?php if($refund['refund_type']==0){?>
						<tr> <td><b>退款方式：</b>账户余额</td> <td></td> </tr>
						<?php }elseif($refund['refund_type']==1){?>
						<tr> <td><b>退款方式：</b>银行卡</td> <td><b>开户银行：</b><?php echo isset($refund['account_bank'])?$refund['account_bank']:"";?></td></tr>
						<tr> <td><b>开户名称：</b><?php echo isset($refund['account_name'])?$refund['account_name']:"";?></td> <td><b>银行账号：</b><?php echo isset($refund['refund_account'])?$refund['refund_account']:"";?></td></tr>
						<?php }else{?>
						<tr> <td><b>退款方式：</b>其它</td> <td><b>对应方式：</b><?php echo isset($refund['account_bank'])?$refund['account_bank']:"";?></td></tr>
						<tr> <td><b>对应账号：</b><?php echo isset($refund['refund_account'])?$refund['refund_account']:"";?></td> <td></td></tr>
						<?php }?>
						<tr> <td colspan=2><b>退款原因：</b><?php echo isset($refund['content'])?$refund['content']:"";?></td> </tr>
					</table>
				</div>
			</div>
			<div class=" box mt20" >
				<h2>处理详情：</h2>
				<div class="p10">
					<table class="simple">
						<?php if($refund['pay_status']==0){?>
						<tr><td>正在处理中……</td></tr>
						<?php }elseif($refund['pay_status']==2){?>
						<tr><td><b>处理结果：</b>退款成功</td><td><b>处理时间：</b><?php echo isset($refund['handling_time'])?$refund['handling_time']:"";?></td></tr>
						<tr><td><b>退到渠道：</b><?php echo isset($refund['channel'])?$refund['channel']:"";?></td><td><b>退款账号：</b><?php echo isset($refund['bank_account'])?$refund['bank_account']:"";?></td></tr>
						<tr><td colspan=2><b>退款金额：</b><?php echo isset($refund['amount'])?$refund['amount']:"";?></td></tr>
						<?php }else{?>
						<tr><td><b>处理结果：</b>不予退款</td><td><b>处理时间：</b><?php echo isset($refund['handling_time'])?$refund['handling_time']:"";?></td></tr>
						<tr><td colspan=2><b>处理意见：</b><?php echo isset($refund['handling_idea'])?$refund['handling_idea']:"";?></td></tr>
						<?php }?>
					</table>
				</div>
			</div>
			<p class="tc mt20"><a href="javascript:history.go(-1);" class="btn btn-main">返回</a></p>
	</div>
</div>

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