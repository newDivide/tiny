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
	<div style="width:100%;" class="tab">
		<ul class="tab-head"><li>本地图片</li><li>图库图片</li><li>网络图片</li></ul>
		<?php $type=Req::args('type')==null?0:intval(Req::args('type'));?>
		<div class="tab-body form2">
			<div>
			<form id="image_form" action="<?php echo urldecode(Url::urlFormat("/admin/photoshop_upload"));?>" method="post" enctype="multipart/form-data" >
				<dl class="lineD">
			      <dt>本地图片：</dt>
			      <dd>
			      	<input name="type" type="hidden" value="<?php echo isset($type)?$type:"";?>">
			        <input name="upfile" type="file" pattern="required" >
			        <label></label>
			      </dd>
			    </dl>
			    </form>
			</div>
			<div>
				<ul class="gallery clearfix">
				<?php $item=null; $obj = new Query("gallery");$obj->page = "1";$obj->where = "type = $type";$items = $obj->find(); foreach($items as $key => $item){?>
					<li><img height="100" width="100" src="<?php echo urldecode(Url::urlFormat("@$item[img]"));?>" data-src="<?php echo isset($item['img'])?$item['img']:"";?>"></li>
				<?php }?>
				</ul>
				<div class="page_nav">
				<?php echo $obj->pageBar();?>
				</div>
			</div>
			<div>
				<form id="form_netimg" callback="setNetImg">
				<dl class="lineD">
			      <dt>网络图片：</dt>
			      <dd>
			        <input id="netimg" name="netimg" type="text" pattern="http:\/\/(\w+(-\w+)*)(\.(\w+(-\w+)*))+(\/\S*)+\.(jpg|png|bmp|gif)" value="<?php echo isset($name)?$name:"";?>">
			        <label>图片地址必须以http开头,以jpg,png,bmp,gif结束</label>
			      </dd>
			    </dl>
			    </form>
			</div>
		</div>
		
	</div>
	<div class="alone_footer tc"><button class="button" onclick="saveImage()">保存</button></div>
	<script type="text/javascript">
	function saveImage (){
		var status = $(".tab > .tab-head > li[class='current']").index();
		switch(status){
			case 0:
				$("form:first").submit();
				break;
			case 1:
				var img = $(".gallery > .current >img").attr('data-src');
				if(img)art.dialog.opener.setImg(img);
				else art.dialog.tips("<p class='fail'>未选择任何图片，无法添加！</p>");
				break;
			case 2:
				$("#form_netimg").submit();
				break;
			}
		}
		<?php if(isset($msg)){?>
			art.dialog.tips("<p class='<?php echo isset($msg[0])?$msg[0]:"";?>'><?php echo isset($msg[1])?$msg[1]:"";?></p>");
		<?php }elseif(Req::args('msg')){?>
			<?php $msg = Req::args('msg');?>
			art.dialog.tips("<p class='<?php echo isset($msg[0])?$msg[0]:"";?>'><?php echo isset($msg[1])?$msg[1]:"";?></p>");
		<?php }?>
		function setNetImg(e){
			if(e==null)art.dialog.opener.setImg($('#netimg').val());
			return false;
		}
		$(".gallery >li").each(function(){
			$(this).on("click",function(){
				$(".gallery >li").removeClass('current');
				$(this).addClass("current");
			})
		})
　　			<?php if(Req::args('p')!=null){?>
				$(document).ready(function(){ 
				　　tabs_select(0,1);
				});
			<?php }?>
	</script>
</body>
</html>
<!--Powered by TinyRise-->