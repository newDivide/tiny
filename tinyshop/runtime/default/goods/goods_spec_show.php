<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>图片管理</title>
	<link rel="stylesheet" href="<?php echo urldecode(Url::urlFormat("@static/css/base.css"));?>" />
	<link rel="stylesheet" href="<?php echo urldecode(Url::urlFormat("@static/css/admin.css"));?>" />

	<?php echo JS::import('jquery');?>
	<?php echo JS::import('form');?>
	<?php echo JS::import('dialog?skin=brief');?>
	<?php echo JS::import('dialogtools');?>
	<script src="<?php echo urldecode(Url::urlFormat("@static/js/common.js"));?>" charset="UTF-8" type="text/javascript"></script>
</head>
<body style="background:#fff;">
	<table class="default" >
		<colgroup>
			<col width="20%"></col>
			<col> </col>
		</colgroup>
		<tr style="height:24px;"><th>规格选择</th><th style="border-left:#f1f1f1 1px solid;">规格预览</th></tr>
		<tr style="height:300px;"><td valign="top">
			<ul class="spec_names">
			<?php $query = new Query("goods_spec");$spec = $query->find();?>
			<?php foreach($spec as $key => $item){?>
				<li><input type="radio" name="spec" value="<?php echo isset($item['id'])?$item['id']:"";?>"><label><?php echo isset($item['name'])?$item['name']:"";?>[<?php echo isset($item['note'])?$item['note']:"";?>]</label></li>
			<?php }?>
			</ul>
		</td><td valign="top" style="border-left:#f1f1f1 1px solid;">
			<div class="spec_values">
			<?php foreach($spec as $key => $item){?>
				<?php $values = unserialize($item['value']);?>
				<ul>
				<?php foreach($values as $key => $ite){?>
					<?php if($item['type']==2){?>
						<li><img src="<?php echo urldecode(Url::urlFormat("@$ite[img]"));?>" ></li>
					<?php }else{?>
						<li><?php echo isset($ite['name'])?$ite['name']:"";?></li>
					<?php }?>
				<?php }?>
				</ul>
			<?php }?>
			</div>
		</td></tr>
	</table>
	<div style="text-align: center; position: fixed; bottom: 0px; background: #F0F0F0; left: 0; right: 0; border-top: 1px solid #C4C4C4; height: 40px; line-height: 40px; "><button class="button" onclick="saveSpec()">保存</button></div>
	<script type="text/javascript">
	function saveSpec (){
		//alert();
			var id = $("input:checked").val();
			var name = $("input:checked+label").text();
			if(id)parent.addSpec(id,name);

		}
		$("input[name='spec']").each(function(i){
			var num = i;
			$(".spec_values >ul").css({display:'none'});
			$(this).on("click",function(){
				$(".spec_values >ul").css({display:'none'});
				$(".spec_values >ul:eq("+num+")").css({display:''});
			})
		})
	</script>
</body>
</html>
<!--Powered by TinyRise-->