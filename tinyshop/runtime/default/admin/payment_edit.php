<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo isset($admin_title)?$admin_title:"";?>echo的二手店</title>
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
		<?php echo JS::import('form');?>
<?php echo JS::import('editor');?>
<?php echo JS::import('dialog?skin=brief');?>
<?php echo JS::import('dialogtools');?>
	<script>
		var description , note;
		var items = [
					'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
					'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
					'insertunorderedlist', '|', 'link'];
		KindEditor.ready(function(K) {
			note = K.create('textarea[name="note"]', {
				resizeType : 1,
				allowPreviewEmoticons : false,
				allowImageUpload : false,
				items : items
			});
		});
		KindEditor.ready(function(K) {
			description = K.create('textarea[name="description"]', {
				resizeType : 1,
				allowPreviewEmoticons : false,
				allowImageUpload : false,
				items : items
			});
		});
	</script>
<h1 class="page_title">商品编辑</h1>
<form action="<?php echo urldecode(Url::urlFormat("/admin/payment_save"));?>" method="post" callback="check_invalid" >
  <?php if(isset($id)){?>
  <input type="hidden" name="id" value="<?php echo isset($id)?$id:"";?>">
  <?php }?>
  <input type="hidden" name="plugin_id" value="<?php echo isset($plugin_id)?$plugin_id:$pay_plugin['id'];?>">
  <div class="form2">
  	<dl class="lineD">
      <dt><b class="red">*</b>支付方式名称：</dt>
      <dd>
        <input class="normal" name="pay_name" type="text" value="<?php echo isset($pay_name)?$pay_name:$pay_plugin['name'];?>" pattern="required" alt="支付方式名称不能为空！" /><label> 用来显示的支付名称！</label>
      </dd>
    </dl>
		<?php foreach($config_form as $key => $item){?>
      	<dl class="lineD">
	      <dt><b class="red">*</b><?php echo isset($item['caption'])?$item['caption']:"";?>：</dt>
	      <dd>
	        <input class="normal" name="<?php echo isset($item['field'])?$item['field']:"";?>" pattern="required" type="text" value="" />
	      </dd>
	    </dl>
		<?php }?>
	     <dl class="lineD">
	      <dt><b class="red">*</b>手续费设置：</dt>
	      <dd>
				<label><input type="radio"  checked="checked" value="1" name="fee_type">百分比</label>
				<label><input type="radio"  value="2" name="fee_type">固定额度</label>
				<p id="pay_fee">
						费率：<input type="text" alt="费率不能为空！" pattern="required" value="<?php echo isset($pay_fee)?$pay_fee:0.00;?>" name="pay_fee" class="tiny"> % &nbsp;&nbsp; 说明：顾客将支付订单总金额乘以此费率作为手续费；
				</p>
				<p id="pay_fee_fix" style="display:none;">
					金额：<input class="tiny" name="pay_fee_fix" value="<?php echo isset($pay_fee)?$pay_fee:0.00;?>" pattern="required" alt="金额不能为空！" type="text"> 元 &nbsp;&nbsp; 说明：顾客每笔订单需要支付的手续费；
				</p>
	      </dd>
	    </dl>
		<dl class="lineD">
	      <dt><b class="red">*</b>排序：</dt>
	      <dd>
	      	<input class="small" name="sort" type="text" value="<?php echo isset($sort)?$sort:"";?>" pattern="int" alt="排序不能为空！" />
	      </dd>
	    </dl>
	    <dl class="lineD">
	      <dt><b class="red">*</b>是否开启：</dt>
	      <dd>
	      	<label class='attr'><input name="status" type="radio" value="0" checked="checked" />开启</label>
			<label class='attr'><input name="status" type="radio" value="1" />关闭</label>
			<label></label>
	      </dd>
	    </dl>
		<dl class="lineD">
	      <dt><b class="red">*</b>支持终端：</dt>
	      <dd>
	      	<label class='attr'><input name="client_type" type="radio" value="0" checked="checked" />PC</label>
			<label class='attr'><input name="client_type" type="radio" value="1" />移动</label>
			<label class='attr'><input name="client_type" type="radio" value="2" />PC+移动</label>
			<label></label>
	      </dd>
	    </dl>
	    <dl class="lineD">
	      <dt><b class="red">*</b>简述：</dt>
	      <dd>
	        <textarea class="normal" name="description"  style="width:400px;" ><?php echo isset($description)?$description:$pay_plugin['description'];?></textarea>
	      </dd>
	    </dl>
	    <dl class="lineD">
	      <dt><b class="red"></b>支付说明：</dt>
	      <dd>
	      	<textarea id="note" name="note" style="width:700px;height:180px;visibility:hidden;"><?php echo isset($note)?$note:"";?></textarea>
						<label>此信息会展示在用户的支付页面</label>
	      </dd>
	    </dl>

	    <div style="text-align:center;margin-top:20px;">
  <input type="submit" class="focus_button" value="提交">
  &nbsp;&nbsp;&nbsp;&nbsp;
  <input type="reset" value="重置" class="button"></div>
  </div>
</form>

<script language="javascript">
//DOM加载完毕
$(function(){
	var form = new Form();
	form.setValue("status","<?php echo isset($status)?$status:"";?>");
	form.setValue("fee_type","<?php echo isset($fee_type)?$fee_type:1;?>");
	form.setValue("client_type","<?php echo isset($client_type)?$client_type:0;?>");
	changeFee(<?php echo isset($fee_type)?$fee_type:1;?>);
	//展示支付费用
	$('input[name="fee_type"]').each(function(){
		$(this).on("click",function(){
			var value = $(this).val();
			changeFee(value);
		})
	});
	//
	function changeFee(value){
		if(value==1){
			$("#pay_fee").show();
			$("#pay_fee_fix").hide();
		}else{
			$("#pay_fee").hide();
			$("#pay_fee_fix").show();
		}
	}
});
$(function(){
    var form = new Form();
    <?php if(isset($config) && $config){?>
    <?php foreach(unserialize($config) as $key => $item){?>
    form.setValue("<?php echo isset($key)?$key:"";?>","<?php echo isset($item)?$item:"";?>");
    <?php }?>
    <?php }?>
});
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