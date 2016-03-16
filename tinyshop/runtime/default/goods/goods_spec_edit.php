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
		<?php echo JS::import('validator');?>
<?php echo JS::import('form');?>
<?php echo JS::import('dialog?skin=brief');?>
<?php echo JS::import('dialogtools');?>
<h1 class="page_title">规格编辑</h1>
<div id="obj_form" class="form2">
  <form action="<?php echo urldecode(Url::urlFormat("/goods/goods_spec_save"));?>" method="post" >
    <?php if(isset($id)){?>
    <input type="hidden" name="id" value="<?php echo isset($id)?$id:"";?>">
    <?php }?>
    <dl class="lineD">
      <dt>名称：</dt>
      <dd>
        <input name="name" type="text" pattern="required" value="<?php echo isset($name)?$name:"";?>" alt="名称不能为空">
        <label>规格名称(如：颜色)</label>
      </dd>
    </dl>
    <dl class="lineD">
      <dt>类型：</dt>
      <dd>
        <input name="type" type="radio" checked="checked" value="1">
        <label>文字</label>
        <input name="type" type="radio" value="2">
        <label>图片</label>

      </dd>
    </dl>
    <dl class="lineD">
      <dt>备注：</dt>
      <dd>
        <input name="note" type="text" pattern="required" value="<?php echo isset($note)?$note:"";?>" alt="不能为空，用于标注">
        <label>备注（一般说明是关于什么的，如：服装）</label>
      </dd>
    </dl>
    <dl class="lineD">
      <dt></dt>
      <dd>
        <button class="button" id="addSpecButton" >添加规格值</button>
      </dd>
    </dl>
    <div>
      <table class="default" id="spec">
        <tr>
          <th>规格值名称</th>
          <th>规格图片</th>
          <th>操作</th>
        </tr>
        <?php if(isset($id)){?>
        <?php $item=null; $query = new Query("spec_value");$query->where = "spec_id = $id";$query->order = "sort";$items = $query->find(); foreach($items as $key => $item){?>
        <tr>
          <td>
            <input type="hidden" name="value_id[]" value="<?php echo isset($item['id'])?$item['id']:"";?>">
            <input type="text" name="value[]" value="<?php echo isset($item['name'])?$item['name']:"";?>" pattern="required" />
          </td>
          <td>
            <input type="text" name="img[]" readonly="readonly" value="<?php echo isset($item['img'])?$item['img']:"";?>" >
            <button class="button select_button" value="选择">选择</button>
          </td>
          <td class="btn_min">
            <a href="javascript:;" class="icon-arrow-up-2">上升</a>
            <a href="javascript:;" class="icon-arrow-down-2">下降</a>
            <a href="javascript:;" class="icon-remove-2" >删除</a>
          </td>
        </tr>
        <?php }?>
        <?php }else{?>
        <tr>
          <td>
            <input type="hidden" name="value_id[]" value="0">
            <input type="text" name="value[]" pattern="required" />
          </td>
          <td>
            <input type="text" name="img[]" readonly="readonly" >
            <button class="button select_button" value="选择">选择</button>
          </td>
          <td class="btn_min">
            <a href="javascript:;" class="icon-arrow-up-2">上升</a>
            <a href="javascript:;" class="icon-arrow-down-2">下降</a>
            <a href="javascript:;" class="icon-remove-2" >删除</a>
          </td>
        </tr>
        <?php }?>
      </table>
    </div>
    <div style="text-align:center">
      <input type="submit" value="提交" class="button">
      &nbsp;&nbsp;&nbsp;&nbsp;
      <input type="reset" value="重置" class="button"></div>
  </form>
</div>
<script type="text/javascript">
var form =  new Form();
form.setValue('parent_id','<?php echo isset($parent_id)?$parent_id:"";?>');
form.setValue('type','<?php echo isset($type)?$type:"";?>');

$("#addSpecButton").on("click",function(){
  if(2==$("input[name='type']:checked").val()){
    $("#spec").append('<tr> <td><input type="hidden" name="value_id[]" value="0"><input type="text" name="value[]" pattern="required" /></td> <td><input type="text" name="img[]" readonly="readonly" > <button class="button select_button">选择</button></td> <td class="btn_min"><a href="javascript:;" class="icon-arrow-up-2">上升</a><a href="javascript:;" class="icon-arrow-down-2">下降</a><a href="javascript:;"  class="icon-remove-2">删除</a></td></tr>');
  }else{
    $("#spec").append('<tr> <td><input type="hidden" name="value_id[]" value="0"><input type="text" name="value[]" pattern="required" /></td> <td><input type="text" name="img[]" readonly="readonly"  disabled="disabled"> <button class="button select_button" disabled="disabled">选择</button></td> <td class="btn_min"><a href="javascript:;" class="icon-arrow-up-2">上升</a><a href="javascript:;" class="icon-arrow-down-2">下降</a><a href="javascript:;"  class="icon-remove-2">删除</a></td></tr>');
  }
  bindEvent();
  return false;
})

// 绑定规格类型点击事件
$("input[name='type']").on("click",changeType);
//改变规格的类型
function changeType(){
  var select_type = $("input[name='type']:checked");
  if(select_type.val()==1){
    $("input[name='img[]']").prop("disabled", true);
    $(".select_button").prop("disabled", true);
  }
  else{
    $("input[name='img[]']").prop("disabled", false);
    $(".select_button").prop("disabled", false);
  }
}
changeType();
bindEvent();
//操作按钮事件绑定
function bindEvent(){
  $(".icon-arrow-down-2").off();
  $(".icon-arrow-up-2").off();
  $(".icon-remove-2").off();
  $(".select_button").off();
  $(".icon-arrow-down-2").on("click",function(){
    var current_tr = $(this).parent().parent();
    current_tr.insertAfter(current_tr.next());
  });
    $(".icon-arrow-up-2").on("click",function(){
    var current_tr = $(this).parent().parent();
    if(current_tr.prev().prev().html()!=null)current_tr.insertBefore(current_tr.prev());
  });
    $(".icon-remove-2").on("click",function(){
      if($("input[name='value[]']").length>1)$(this).parent().parent().remove();
      else alert('必须至少保留一个规格值');
    });
    $(".select_button").each(function(i){
      var num = i;
      $(this).on("click",function(){
      uploadFile(num);
      return false;
    });
    });
}
function uploadFile(num){
  art.dialog.data('num', num);
  art.dialog.open('<?php echo urldecode(Url::urlFormat("/admin/photoshop?type=1"));?>',{id:'upimg_dialog',title:'选择图片',width:613,height:380});
}
function setImg(value){
  var num = art.dialog.data('num');
  $("input[name='img[]']:eq("+num+")").val(value);
  art.dialog({id:'upimg_dialog'}).close();
}
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