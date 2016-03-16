<!doctype html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<title>TinyShop商城</title>
	<link type="text/css" rel="stylesheet" href="<?php echo urldecode(Url::urlFormat("#css/common.css"));?>" />
	<link type="text/css" rel="stylesheet" href="<?php echo urldecode(Url::urlFormat("#css/ucenter.css"));?>" />
	<?php echo JS::import('jquery');?>
	<script type='text/javascript' src="<?php echo urldecode(Url::urlFormat("#js/common.js"));?>"></script>
</head>
<body>
	<?php echo JS::import('form');?>
	<?php echo JS::import('dialog?skin=brief');?>
	<?php echo JS::import('dialogtools');?>
	<div class=" p10">
			<?php if(isset($msg)){?>
			<div class="message_<?php echo isset($msg[0])?$msg[0]:"";?> ie6png"><?php echo isset($msg[1])?$msg[1]:"";?></div>
			<?php }elseif(isset($validator)){?>
			<div class="message_warning ie6png"><?php echo isset($validator['msg'])?$validator['msg']:"";?></div>
			<?php }?>
			<form id="address-form" class="simple" action="<?php echo urldecode(Url::urlFormat("/simple/address_save"));?>" method="post">
				<?php if(isset($id)){?><input type="hidden" name="id" value="<?php echo isset($id)?$id:"";?>"><?php }?>
				<table class="form">
					<tr><td class="label">所在地区：</td><td id="areas"><select id="province"  name="province" >
			        <option value="0">==省份/直辖市==</option>
			        </select>
			        <select id="city" name="city"><option value="0">==市==</option></select>
			        <select id="county" name="county"><option value="0">==县/区==</option></select><input pattern="^\d+,\d+,\d+$" id="test" type="text" style="visibility:hidden;width:0;" value="<?php echo isset($province)?$province:"";?>,<?php echo isset($city)?$city:"";?>,<?php echo isset($county)?$county:"";?>" alt="请选择完整地区信息！"><label></label></td></tr>
			        <tr>
			        	<td class="label">邮政编码：</td><td><input  type="text" name="zip" pattern="zip" value="<?php echo isset($zip)?$zip:"";?>" alt="邮政编码错误"></td>
			        </tr>
			        <tr>
			        	<td class="label">街道地址：</td><td><textarea name="addr" pattern="required" minlen="5" maxlen="120" alt="不需要重复填写省市区，必须大于5个字符，小于120个字符"><?php echo isset($addr)?$addr:"";?></textarea> <label>&nbsp;</label></td>
			        </tr>
			        <tr>
			        	<td class="label">收货人姓名：</td><td><input type="text" pattern="required" name="accept_name" maxlen="10" value="<?php echo isset($accept_name)?$accept_name:"";?>" alt="不为空，且长度不得超过10个字"> <label></label></td>
			        </tr>
			        <tr>
			        	<td class="label">手机号码：</td><td><input type="text" pattern="mobi" name="mobile" value="<?php echo isset($mobile)?$mobile:"";?>" alt="手机号码格式错误"><label></label></td>
			        </tr>
			        <tr>
			        	<td class="label">电话号码：</td><td><input type="text" name="phone"  value="<?php echo isset($phone)?$phone:"";?>" empty pattern="phone" alt="电话号码格式错误"><label></label></td>
			        </tr>
			        <tr>
			        	<td class="label">设为默认地址：</td><td><input type="checkbox" name="is_default" value="1"><label>设置为默认收货地址</label></td>
			        </tr>
			        <tr>
			        	<td colspan="2" class="tc"><input type="submit" class="btn"></td>
			        </tr>
				</table>
			</form>
		</div>
		<script type="text/javascript">
		var form =  new Form('address-form');
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
</body>
</html>




<!--Powered by TinyRise-->