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
		<?php echo JS::import('dialog?skin=brief');?>
<?php echo JS::import('dialogtools');?>
<?php echo JS::import('form');?>
<form action="" method="post">
    <div class="tools_bar clearfix">
        <a class="icon-checkbox-checked icon-checkbox-unchecked" href="javascript:;" onclick="tools_select('id[]',this)" title="全选" data="true"> 全选 </a>
        <a  class="icon-remove-2" href="javascript:;" onclick="tools_submit({action:'<?php echo urldecode(Url::urlFormat("/content/tags_del"));?>',msg:'删除后无法恢复，你真的删除吗？'})" title="删除"> 删除</a>
        <a class="icon-delicious" href="<?php echo urldecode(Url::urlFormat("/content/tags_list"));?>"> 全部记录</a>
        <span class="fr"><a href='javascript:;' id="condition" class="icon-search" style="" > 筛选条件</a><input id="condition_input" type="hidden" name="condition" value="<?php echo isset($condition)?$condition:"";?>"></span>
    </div>
    <table class="default" >
        <tr>
            <th style="width:30px">选择</th>
            <th style="width:70px">操作</th>
            <th >标签</th>
            <th style="width:80px">搜索数</th>
            <th style="width:100px">排序</th>
            <th style="width:60px">类型</th>    
        </tr>
            <?php $item=null; $obj = new Query("tags");$obj->order = "is_hot desc,sort desc,num desc";$obj->where = "$where";$obj->page = "1 desc";$items = $obj->find(); foreach($items as $key => $item){?>
            <tr><td style="width:30px"><input type="checkbox" name="id[]" value="<?php echo isset($item['id'])?$item['id']:"";?>"></td>
                <td style="width:70px" class="btn_min"><div class="operat hidden"><a  class="icon-cog action" href="javascript:;"> 处理</a><div class="menu_select"><ul>
                    <?php if($item['is_hot']==0){?>
                    <li><a class="icon-thumbs-up" href="javascript:tags_top(<?php echo isset($item['id'])?$item['id']:"";?>,1);"> 置顶</a></li>
                    <?php }else{?>
                    <li><a class="icon-thumbs-up-2" href="javascript:tags_top(<?php echo isset($item['id'])?$item['id']:"";?>,0);"> 取消置顶</a></li>
                    <?php }?>
                    <li><a class="icon-list-2" href="javascript:tage_sort(<?php echo isset($item['id'])?$item['id']:"";?>);"> 排序</a></li>
                    <li> <a class="icon-remove-2" href="javascript:confirm_action('<?php echo urldecode(Url::urlFormat("/content/tags_del/id/$item[id]"));?>')"> 删除</a></li>
                </ul></div></div> </td>
                <td ><?php echo isset($item['name'])?$item['name']:"";?></td><td style="width:80px"><?php echo isset($item['num'])?$item['num']:"";?></td><td style="width:100px"><?php echo isset($item['sort'])?$item['sort']:"";?></td><td style="width:60px"><?php if($item['is_hot']==1){?><span class='red'><b>热门</b></span><?php }else{?><span class='gray'>普通</span><?php }?></td>
            </tr>
            <?php }?>
        </table>
</form>
<div class="page_nav">
    <?php echo $obj->pageBar();?>
</div>
<div id="sort-dialog" class="default" style="display:none;width:360px;">
   <form action="" method="post" class="form2" callback="tags_update">
      <input type="hidden" id="template_id" name="id" value="">
      <dl class="lineD">
          <dt>排序：</dt>
          <dd id="voucher_name"><input name="sort" pattern="int" class="small" id="tags-sort"> <label>必需为数字</label></dd>
      </dl>
      <dl>
          <dt></dt>
          <dd><button class="btn">设定</button></dd>
      </dl>
  </form>
</div>
<script type="text/javascript">
    var form =  new Form();
    $("#condition").on("click",function(){
        $("body").Condition({input:"#condition_input",okVal:'高级搜索',callback:function(data){tools_submit({action:'<?php echo urldecode(Url::urlFormat("/content/tags_list"));?>',method:'get'});},data:{'name':{name:'标签'},'num':{name:'搜索数'},'sort':{name:'排序'},'is_hot':{name:'是否置顶',values:{0:'否',1:'是'}}
    }});
    });
    function tags_top(id,status)
    {
        var url = "<?php echo urldecode(Url::urlFormat("/content/tags_update"));?>";
        $.get(url,{id:id,status:status},function(data){
            if(data['status']=='success'){
                art.dialog.tips("<p class='success'>修改成功。</p>");
                setTimeout("tools_reload()",2);
            }
            else art.dialog.tips("<p class='"+data['status']+"'>"+data['msg']+"</p>");
        },'json');
    }
    function tage_sort(id)
    {
        $("#tags-sort").data("id",id);
        $("#tags-sort").val('');
        art.dialog({id:'tags-dialog',title:'排序',content:document.getElementById('sort-dialog'),width:400});
    }
    function tags_update(e)
    {
        var id =  $("#tags-sort").data("id");
        var sort = $("#tags-sort").val();
        var url = "<?php echo urldecode(Url::urlFormat("/content/tags_update"));?>";
        if(!e){
            $.get(url,{id:id,sort:sort},function(data){
                if(data['status']=='success'){
                    art.dialog.tips("<p class='success'>排序成功。</p>");
                    setTimeout("tools_reload()",2);
                }else{
                    art.dialog.tips("<p class='"+data['status']+"'>"+data['msg']+"</p>");
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