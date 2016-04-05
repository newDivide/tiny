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
		<?php echo JS::import('form');?>
<?php echo JS::import('dialog?skin=brief');?>
<?php echo JS::import('dialogtools');?>
<h1 class="page_title">分类编辑</h1>
<form action="<?php echo urldecode(Url::urlFormat("/goods/goods_category_save"));?>" method="post" callback="check_tab_location" >
  <div id="obj_form" class="form2 tab">
  <?php if(isset($id)){?><input type="hidden" name="id" value="<?php echo isset($id)?$id:"";?>"><?php }?>
  <!-- tab 头 start -->
    <ul class="tab-head">
      <li>基本信息</li>
    </ul>
    <!-- tab 头 end -->
    <!-- tab body start -->
    <div class="tab-body">
    <!-- S 基本信息-->
    <div>
      <dl class="lineD">
        <dt>名称：</dt>
        <dd>
          <input name="name" type="text" pattern="required" value="<?php echo isset($name)?$name:"";?>" alt="名称不能为空">
          <label>分类名称</label>
        </dd>
        </dl><dl class="lineD">
        <dt>别名：</dt>
        <dd>
          <input name="alias" type="text" pattern="[a-zA-Z]\w*" value="<?php echo isset($alias)?$alias:"";?>" alt="必需为字母与数字组合，且以字母开头">
          <label>方便url识别美化</label>
        </dd>
        </dl><dl class="lineD">
        <dt>上级分类：</dt>
        <dd>
          <select id="parent_id"  name="parent_id"   pattern="int">
          <option value="0">==无上级分类==</option>
          <?php $id=isset($id)?$id:0;?>
          <?php $query = new Query("goods_category");$query->order = "path";$items = $query->find();?>
          <?php $goods_category=Common::treeArray($items);?>
          <?php foreach($goods_category as $key => $item){?>
          <?php if(!isset($path) || strpos($item['path'],$path)===false){?>
          <?php $num = count(explode(',',$item['path']))-3;?>
          <option value="<?php echo isset($item['id'])?$item['id']:"";?>"><?php if($num>0){?>├<?php }?><?php echo str_repeat('──',$num);?><?php echo isset($item['name'])?$item['name']:"";?></option><?php }?>
          <?php }?>
          </select>

          <label></label>
        </dd>
        </dl>
        <dl class="lineD">
        <dt>产品类型：</dt>
        <dd>
          <select id="type_id"  name="type_id"   pattern="int">
          <option value="0">请选择...</option>
          <?php $id=isset($id)?$id:0;?>
          <?php $item=null; $query = new Query("goods_type");$items = $query->find(); foreach($items as $key => $item){?>
          <option value="<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></option>
          <?php }?>
          </select>
          <label></label>
        </dd>
        </dl><dl class="lineD">
          <dt>排序：</dt>
          <dd>
            <input name="sort" type="text" pattern="int" value="<?php echo isset($sort)?$sort:"";?>" style="width:40px;" alt="必需为数字">
            <label>数字越大越靠前</label>
          </dd>
          </dl>
        <dl class="lineD clearfix">
          <dt>分类图片：</dt>
          <dd class="min_inputs ">

            <button class="button  select_button" type="button" >
              <b class="icon-plus green"></b>
              添加图片
            </button> <b class="red"></b>

          </dd>
        </dl>
        <dl>
          <dt></dt>
          <dd>
            <ul class="piclist" id="pic_list">
              <?php if(isset($imgs) && $imgs =  unserialize($imgs)){?>
            <?php foreach($imgs as $key => $item){?>
              <li <?php if($item == $img){?> class="current" <?php }?>>
                <div class="bord">
                  <input type="hidden" name="imgs[]" value="<?php echo isset($item)?$item:"";?>">
                  <img src="<?php echo urldecode(Url::urlFormat("@$item"));?>" data-src=<?php echo isset($item)?$item:"";?> onclick="selectImg(this)" width="80" height="80" alt=""></div>
                <div class="opera">
                  <a class="icon-arrow-left-2" href="javascript:;"></a>&nbsp;&nbsp;<a class="icon-arrow-right-2" href="javascript:;"></a>&nbsp;&nbsp;<a class="icon-link" href="javascript:;" onclick="linkImg(this)"></a>&nbsp;&nbsp;<a class="icon-close" href="javascript:;" onclick="delImg(this)"></a>
                </div>
              </li>
              <?php }?>
            <?php }?>
            </ul>
              <input name="img" type="text" style="visibility: hidden;width:0;" value="<?php echo isset($img)?$img:"";?>" id="img_index" alt="添加商品图片"/>
              <label></label>
          </dd>
        </dl>
        </div>
        <!-- E 基本信息-->
        
      </div>
    <div style="text-align:center"><input type="submit" value="提交" class="button">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="重置" class="button"></div>
    </form>
</div>
<script type="text/javascript">
var form =  new Form();
form.setValue('parent_id','<?php echo isset($parent_id)?$parent_id:"";?>');
form.setValue('type_id','<?php echo isset($type_id)?$type_id:"";?>');

$(".select_button").on("click",function(){
      uploadFile();
      return false;
    });
    function uploadFile(){
  art.dialog.open('<?php echo urldecode(Url::urlFormat("/admin/photoshop"));?>',{id:'upimg_dialog',lock:true,opacity:0.1,title:'选择图片',width:613,height:380});
}
function selectImg(id){
  var img = $(id).attr('data-src');
  $("#pic_list li").removeClass("current");
  $(id).parent().parent().addClass("current");
  $("#img_index").val(img);
}
//回写选择图片
function setImg(value){
  var show_src = "<?php echo urldecode(Url::urlFormat("@"));?>"+value;
  if(value.indexOf("http://")!=-1) show_src = value;

  if($("#pic_list img[src='"+show_src+"']").get(0)){
    art.dialog.alert("图片已经添加，请不要重复添加！");
  }else{
    $("#pic_list").append('<li> <div class="bord"><input type="hidden" name="imgs[]" value="'+value+'" /> <img src="'+show_src+'" data-src="'+value+'" onclick="selectImg(this)" width="80" height="80" alt=""></div> <div class="opera"><a class="icon-arrow-left-2" href="javascript:;" ></a>&nbsp;&nbsp;<a class="icon-arrow-right-2" href="javascript:;"></a>&nbsp;&nbsp;<a class="icon-link" href="javascript:;" onclick="linkImg(this)"></a>&nbsp;&nbsp;<a class="icon-close" href="javascript:;" onclick="delImg(this)"></a> </div> </li>');
      bindEvent();
      if($("#pic_list li.current").length <=0 ){
        $("#pic_list li:eq(0)").addClass("current");
        $("#img_index").val(value);
      }
      FireEvent(document.getElementById('img_index'),'change');
      art.dialog({id:'upimg_dialog'}).close();
  }

}
//删除添加的图片
function delImg(id){
  $(id).parent().parent().remove();
  if($("#pic_list li:eq(0)").length <= 0)$("#img_index").val('');
}
function linkImg(id){
  var src = $(id).parent().parent().find('img').attr('src');
  art.dialog({id:'linkDialog',title:'图片地址',content:'<div>图片地址：<input type="text" value='+src+' style="width:300px;"/></div>',width:420});
}
//操作左右按钮事件绑定
function bindEvent(){
  $(".icon-arrow-right-2").off();
  $(".icon-arrow-left-2").off();
  $(".icon-arrow-right-2").on("click",function(){
    var current_tr = $(this).parent().parent();
    current_tr.insertAfter(current_tr.next());
  });
    $(".icon-arrow-left-2").on("click",function(){
    var current_tr = $(this).parent().parent();
    if(current_tr.prev().html()!=null)current_tr.insertBefore(current_tr.prev());
  });

}
bindEvent();
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