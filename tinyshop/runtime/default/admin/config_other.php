<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo isset($admin_title)?$admin_title:"";?>-TinyShop商城</title>
<meta name="author" content="designer:webzhu, date:2012-03-23" />
<link type="image/x-icon" href="<?php echo urldecode(Url::urlFormat("@favicon.ico"));?>" rel="icon">
<link rel="stylesheet" type="text/css" href="<?php echo urldecode(Url::urlFormat("@static/css/base.css"));?>" />
<link rel="stylesheet" type="text/css" href="<?php echo urldecode(Url::urlFormat("@static/css/admin.css"));?>" />
<link rel="stylesheet" type="text/css" href="<?php echo urldecode(Url::urlFormat("@static/css/font_icon.css"));?>" />
<?php echo JS::import('jquery');?>
<script type="text/javascript" src="<?php echo urldecode(Url::urlFormat("@static/js/common.js"));?>"></script>
<!--[if lte IE 7]><script src="<?php echo urldecode(Url::urlFormat("@static/css/fonts/lte-ie7.js"));?>"></script><![endif]-->
</head>
<body >
<div id="header">
	<div class="nav_sub">
			    	您好[<?php echo isset($manager['name'])?$manager['name']:"";?>]&nbsp; | <a href="<?php echo urldecode(Url::urlFormat("/index/index"));?>" target="_blank">返回前台</a> | <a href="<?php echo urldecode(Url::urlFormat("/admin/logout"));?>">退出</a>
	</div>
    <div id="Logo"><a href=""><img src="<?php echo urldecode(Url::urlFormat("@static/images/logo_min.png"));?>"></a></div>
	<ul id="main_nav" class="clearfix">
	<?php foreach($mainMenu as $key => $item){?>
		<li <?php if($key==$menu_index['menu']){?>class="active"<?php }?>><a href="<?php echo urldecode(Url::urlFormat("$item[link]"));?>"  ><?php echo isset($item['name'])?$item['name']:"";?></a></li>
	<?php }?>
	</ul>
</div>
<div id="mainContent">
	<div id="sidebar" >
		<ul class="menu" style="margin-top:15px;">
		<?php foreach($subMenu as $key => $item){?>
			<li class="submenu">
			<ul><li class="sub-index"><b><a href="javascript:;"><?php echo isset($item['name'])?$item['name']:"";?></a></b></li>
			<?php foreach($menu->getNodes($item['link']) as $key => $item){?>
			<?php if(substr($item['link'],-5)!='_edit' && !$item['hidden'] ){?>
				<li><a href='<?php echo urldecode(Url::urlFormat("$item[link]"));?>' <?php if($item['link']==$nav_link){?>class="current"<?php }?> ><?php echo isset($item['name'])?$item['name']:"";?></a></li>
				<?php }?>
			<?php }?>
			</ul>
			</li>
		<?php }?>
		</ul>
	</div>
	<div id="content" >

		<?php if(!isset($msg)){?><?php $msg=Req::post('msg');?><?php }?>
		<?php if(!isset($validator)){?><?php $validator=Req::post('validator');?><?php }?>
		<?php if(isset($msg[0])){?>
		<div id="message-bar" class="message_<?php echo isset($msg[0])?$msg[0]:"";?>"><?php echo isset($msg[1])?$msg[1]:"";?></div>
		<?php }elseif(isset($validator)){?>
		<div class="message_warning"><?php echo isset($validator['msg'])?$validator['msg']:"";?></div>
		<?php }?>
		<?php echo JS::import('dialog?skin=brief');?>
<?php echo JS::import('dialogtools');?>
<?php echo JS::import('form');?>
<?php echo JS::import('validator');?>
<h2 class="page_title"><?php echo isset($node_index['name'])?$node_index['name']:"";?></h2>
<div class="form2">
	<form name="config_form" method="post" action="<?php echo urldecode(Url::urlFormat("/admin/config/group/other"));?>">
    <dl class="lineD">
      <dt>用户注册方式：</dt>
      <dd>
        <input name="other_reg_way[]" type="checkbox"  value="0"/><label>邮箱注册</label>
        <input name="other_reg_way[]" type="checkbox"   value="1"/><label>手机注册</label>
      </dd>
    </dl>
    <dl class="lineD">
      <dt>注册邮箱验证：</dt>
      <dd>
        <input name="other_verification_eamil" type="checkbox"   value="1"/><label>开启</label>
      </dd>
    </dl>
    <dl class="lineD">
      <dt>货币符号：</dt>
      <dd>
        <input name="other_currency_symbol" type="text" class="small" value=""><label>(例如：人民币“<?php echo isset($currency_symbol)?$currency_symbol:"";?>”)</label>
      </dd>
    </dl>
    <dl class="lineD">
      <dt>货币单位：</dt>
      <dd>
        <input name="other_currency_unit" type="text" class="small"  value="">
        <label>(例如：人民币“元”)</label>
      </dd>
    </dl>
    <dl class="lineD">
      <dt>发票功能：</dt>
      <dd>
        <input name="other_is_invoice" type="checkbox"   value="1"/><label>开启</label>
      </dd>
    </dl>
    <dl class="lineD">
      <dt>税率：</dt>
      <dd>
        <input name="other_tax" type="text"  style="width:40px;"  class="tiny" value=""/>%
        <span>  </span>
      </dd>
    </dl>
    <dl class="lineD">
      <dt><b class="red">*</b>消费时长：</dt>
      <dd>
        <input name="other_grade_days" type="text" class="small" pattern="int" value="365">
        <label>（天）默认365天，会员升级，消费金额需要统计的最近时长。</label>
      </dd>
    </dl>
    <dl class="lineD">
      <dt><b class="red">*</b>抢购订单作废时长：</dt>
      <dd>
        <input name="other_order_delay_flash" type="text" class="small" pattern="int" value="120">
        <label>（分钟）默认120分钟，自下单之时起，用户在多长时间内没有支付，订单将自动作废。</label>
      </dd>
    </dl>
    <dl class="lineD">
      <dt><b class="red">*</b>团购订单作废时长：</dt>
      <dd>
        <input name="other_order_delay_group" type="text" class="small" pattern="int" value="120">
        <label>（分钟）默认120分钟，自下单之时起，用户在多长时间内没有支付，订单将自动作废。</label>
      </dd>
    </dl>
    <dl class="lineD">
      <dt><b class="red">*</b>捆绑订单作废时长：</dt>
      <dd>
        <input name="other_order_delay_bund" type="text" class="small" pattern="int" value="0">
        <label>（分钟）默认不限制（0表示不限制），自下单之时起，用户在多长时间内没有支付，订单将自动作废。</label>
      </dd>
    </dl>
    <dl class="lineD">
      <dt><b class="red">*</b>默认订单作废时长：</dt>
      <dd>
        <input name="other_order_delay" type="text" class="small" pattern="int" value="0">
        <label>（分钟）默认不限制（0表示不限制），自下单之时起，用户在多长时间内没有支付，订单将自动作废。</label>
      </dd>
    </dl>
    <div class="center">
      <input type="submit" name="submit" class="button action fn" value="确 定">
    </div>
  </form>
</div>

<script>
	<?php if(isset($message)){?>
	art.dialog.tips('<p class="success"><?php echo isset($message)?$message:"";?></p>');
	<?php }?>
	var form = new Form('config_form');
	<?php $config = Config::getInstance();?>
	var data = <?php echo JSON::encode($config->get('other'));?>;
  form.init(data);
	form.setValue("other_reg_way[]",data['other_reg_way']);
</script>

	</div>
</div>
<script type="text/javascript">
	$(function () {
		if('<?php echo Req::args("con");?>'=='admin'){
			$(".submenu .current").parent().parent().parent().addClass('current');
		}else{
			$(".submenu").addClass('current');
		}
		$(".submenu .sub-index").on("click",function(){
			$(this).parent().parent().toggleClass('current');
		})
	})

</script>
</body>
</html>

<!--Powered by TinyRise-->