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
<style type="text/css">
  span.areas {
    display: inline-block;
}
</style>
<form action="" method="post">
<div class="tools_bar clearfix">
<a href="javascript:;" onclick="area_op(0,'add')" class="icon-plus"> 添加顶级节点</a>
<a href="javascript:;" class="icon-loop-2"
onclick="tools_reload()"> 刷新</a>
</div>
<div class="clearfix">
    <ul id="areas" >
    </ul>
</div>
</form>
<div id="area_dialog" style="display: none;width:400px;padding: 5px;" class="box">
    <div class="form2">
        <form  id="export_form" action="" method="post" callback="area_action">
          <dl class="lineD">
          <dt>地区名称：</dt>
          <dd><input id="area-name" pattern="required" name="name" value=""> <label>不能为空！</label></dd>
          </dl>
        <div class="tc mt10"><button class="button" id="balance-btn">保存</button></div>
        </form>
    </div>
</div>
<script type="text/javascript">
  $.post('<?php echo urldecode(Url::urlFormat("/ajax/area_data"));?>',function(data){
    var str = '';
    for(i in data){
      data[i]['id'] = i.substr(2);
      str += ("<li  id='area_"+data[i]['id']+"' ><div class='c1'><a class='icon-plus'></a> <span>"+data[i]['t']+"</span></div><div class='c2'><a class='icon-plus' onclick='area_op("+data[i]['id']+",\"add\")'> 添加子节点</a> <a class='icon-pencil' onclick='area_op("+data[i]['id']+",\"edit\")'> 编辑</a> <a class='icon-close' onclick='area_op("+data[i]['id']+",\"del\")'> 删除</a></div> <div class='c3'><a href='javascript:;' class='icon-arrow-up-2' onclick='area_op("+data[i]['id']+",\"up\")'>上升</a><a href='javascript:;' class='icon-arrow-down-2' onclick='area_op("+data[i]['id']+",\"down\")'>下降</a></div></li>");
      var second = data[i]['c'];
      str += "<li class='sub-1' id='sub_"+data[i]['id']+"' style='display:none;'><ul>";
      for(j in second)
      {
        second[j]['id'] = j.substr(2);
        str += ("<li id='area_"+second[j]['id']+"' ><div class='c1'><a class='icon-plus'></a> <span>"+second[j]['t']+"<span></div><div class='c2'><a class='icon-plus' onclick='area_op("+second[j]['id']+",\"add\")'> 添加子节点</a> <a class='icon-pencil' onclick='area_op("+second[j]['id']+",\"edit\")'> 编辑</a> <a class='icon-close' onclick='area_op("+second[j]['id']+",\"del\")'> 删除</a></div> <div class='c3'><a href='javascript:;' class='icon-arrow-up-2' onclick='area_op("+second[j]['id']+",\"up\")'>上升</a><a href='javascript:;' class='icon-arrow-down-2' onclick='area_op("+second[j]['id']+",\"down\")'>下降</a></div></li>");
        str += "<li class='sub-2' id='sub_"+second[j]['id']+"' style='display:none;'><ul>";
        var third = second[j]['c'];
       for(k in third){
          third[k]['id'] = k.substr(2);
          str += ("<li id='area_"+third[k]['id']+"' ><div class='c1'><span>"+third[k]['t']+"</span></div><div class='c2'><a class='icon-pencil' onclick='area_op("+third[k]['id']+",\"edit\")'> 编辑</a> <a class='icon-close' onclick='area_op("+third[k]['id']+",\"del\")'> 删除</a></div> <div class='c3'><a href='javascript:;' class='icon-arrow-up-2' onclick='area_op("+third[k]['id']+",\"up\")'>上升</a><a href='javascript:;' class='icon-arrow-down-2' onclick='area_op("+third[k]['id']+",\"down\")'>下降</a></div></li>");
       }
        str += '</ul></li>';
      }
      str += '</ul></li>';
    }
    $("#areas").append(str);
    $("#areas .c1").on("click",function(){
      if($(this).find("a").hasClass('icon-plus')) $(this).find("a").removeClass("icon-plus").addClass('icon-minus');
      else $(this).find("a").removeClass("icon-minus").addClass('icon-plus');
      var id = $(this).parent().attr('id');
      var ids = id.split('_');
      $("#sub_"+ids[1]).slideToggle('fast');
      return false;
    });
    
  },"json");
function area_op(id,op){
  switch(op){
    case 'add':
    case 'edit':{
      if(op=='add') $('#area-name').val('');
      else{
        var name = $("#area_"+id+" .c1").text();
        $('#area-name').val($.trim(name));
      }
      $("#areas").data("id",id);
      $("#areas").data("op",op);
      art.dialog({id:'area_dialog',title:'编辑地区',content:document.getElementById('area_dialog')});
      break;
    }
    default:{
      $.post('<?php echo urldecode(Url::urlFormat("/admin/area_op"));?>',{id:id,op:op},function(data){
        if(data['status']=='success'){
          if(op=='del') $("#area_"+id).remove();
          else{
            var area_curr = $("#area_"+id);
            var sub_curr = $("#sub_"+id);
            var area_prev = $("#area_"+id).prev();
            var area_next = $("#area_"+id).next();
            if(op=='up' && area_prev.size()>0){
              area_curr.insertBefore(area_prev);
              sub_curr.insertAfter(area_curr);
            }
            if(op=='down' && area_next.size()>0){
              area_curr.insertAfter(area_next);
              sub_curr.insertAfter(area_curr);
            }
          }
        }
        else{
          art.dialog.tips("<p class='"+data['status']+"'>"+data['msg']+"</p>");
        }
      },'json');
    }
  }
}



function area_action(e){
  if(e==null){
    var id = $("#areas").data("id");
    var op = $("#areas").data("op");
    var name = $("#area-name").val();
    $.post('<?php echo urldecode(Url::urlFormat("/admin/area_op"));?>',{id:id,op:op,name:name},function(data){
      if(data['status']=='success'){
        if(op=='edit'){
          art.dialog({id:'area_dialog'}).close();
          $("#area_"+id).find(".c1 span").text(name);
        }
        if(op=='add'){
            art.dialog({id:'area_dialog'}).close();
            art.dialog.tips('<p class="success">'+data['msg']+'</p>',1.5);
            setTimeout("tools_reload()",1400);
          } 
        }
        else{
          art.dialog.tips('<p class="'+data['status']+'">'+data['msg']+'</p>',1.5);
        }
      },'json');
  }
  return false;
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