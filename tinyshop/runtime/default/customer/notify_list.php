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
<?php echo JS::import('date');?>
<form action="" method="post">
<div class="tools_bar clearfix">
    <a class="icon-checkbox-checked icon-checkbox-unchecked" href="javascript:;" onclick="tools_select('id[]',this)" title="全选" data="true"> 全选 </a>
    <a  class="icon-remove-2" href="javascript:;"  onclick="tools_submit({action:'<?php echo urldecode(Url::urlFormat("/customer/notify_del"));?>',msg:'删除后无法恢复，你真的删除吗？'})" title="删除"> 删除</a>
    <a class="icon-file-excel" href="javascript:;"
 onclick="export_excel_dialog()"> 导出Excel</a>    <a  class="icon-envelop" href="javascript:;" onclick="send_notify_dialog()" title="发送邮件"> 发送邮件</a><a href="javascript:;" class="icon-loop-2"
onclick="tools_reload()"> 刷新</a></div>
<table class="default" >
    <tr>
        <th style="width:30px">选择</th>
        <th style="width:70px">操作</th>
        <th >商品名称</th>
        <th style="width:60px">库存</th>
        <th style="width:100px">邮箱</th>
        <th style="width:120px">电话</th>
        <th style="width:120px">是否通知</th>

    </tr>
    <?php $item=null; $obj = new Query("notify as n");$obj->join = "left join goods as go on n.goods_id = go.id";$obj->order = "notify_status";$obj->fields = "name,n.id,email,mobile,store_nums,notify_status";$obj->page = "1 desc";$items = $obj->find(); foreach($items as $key => $item){?>
        <tr><td style="width:30px"><input type="checkbox" name="id[]" value="<?php echo isset($item['id'])?$item['id']:"";?>"></td>
        <td style="width:70px" class="btn_min"><div class="operat hidden"><a  class="icon-cog action" href="javascript:;"> 处理</a><div class="menu_select"><ul>
                <li><a class="icon-remove-2" href="<?php echo urldecode(Url::urlFormat("/customer/notify_del/id/$item[id]"));?>"> 删除</a></li>
            </ul></div></div> </td>
        <td ><?php echo TString::msubstr($item['name'],0,15);?></td><td style="width:60px;"><?php echo isset($item['store_nums'])?$item['store_nums']:"";?></td><td style="width:100px"><?php echo isset($item['email'])?$item['email']:"";?></td><td style="width:120px"><?php echo isset($item['mobile'])?$item['mobile']:"";?></td><td style="width:120px"><?php echo isset($item['notify_status']) && $item['notify_status']?'<b class="green">已通知</b>':'<b class="red">未通知</b>';?></td></tr>
    <?php }?>
</table>
</form>
<div class="page_nav">
<?php echo $obj->pageBar();?>
</div>
<div id="condition_box" style="display: none">
    <?php $query = new Query("msg_template");$query->where = "id = 1";$items = $query->find();?>
    <h1 class="page_title">到货通知发送</h1>
    <div id="obj_form" class="form2">
        <form  method="post" onsubmit="return false;" >
        <dl class="lineD">
          <dt>标题：</dt>
          <dd>
            <label><?php echo isset($items[0]['title'])?$items[0]['title']:"";?></label>
          </dd>
          </dl>
          <dl class="lineD">
          <dt>发送对象：</dt>
          <dd>
            <input type="hidden"  id="condition_input" name="condition" value="<?php echo isset($condition)?$condition:"";?>"><label></label> <label><a href="javascript:;" onclick="Condition('#condition_input')"  class="button" > 高级筛选</a></label>
          </dd>
          </dl>
          <dl class="lineD">
          <dt>内容：</dt>
          <dd>
            <?php echo isset($items[0]['content'])?$items[0]['content']:"";?>
          </dd>
          </dl>
          <dl class="lineD">
          <dt>注：</dt>
          <dd>
            <label>如果发送的数据量过大，建议您导出Excel格式，用专业的邮件发送工具！</label>
          </dd>
          </dl>
        <div class="tc mt10"><a href="javascript:;" onclick="send_notify()" class="button">发送</a></div>
        </form>
    </div>
</div>
<div id="excel_box" style="display: none;width:600px;">
    <h1 class="page_title">Excel导出</h1>
    <div class="form2">
        <form  id="export_form" action="<?php echo urldecode(Url::urlFormat("/customer/export_excel"));?>" method="post" >
           <dl class="lineD">
          <dt>筛选条件：</dt>
          <dd><input type="hidden"  id="condition_input_excel" name="condition" value="<?php echo isset($condition)?$condition:"";?>"><label></label> <label><a href="javascript:;" onclick="Condition('#condition_input_excel')"  class="button" > 高级筛选</a></label>
          </dd>
          </dl>
        <dl class="lineD">
          <dt>导出字段：</dt>
          <dd>
            <label><input type="checkbox" name="fields[]" value="email" checked="checked"> 邮箱</label>
            <label><input type="checkbox" name="fields[]" value="mobile"> 电话</label>
            <label><input type="checkbox" name="fields[]" value="user_name"> 用户名</label>
            <label><input type="checkbox" name="fields[]" value="goods_name"> 商品名</label>
            <label><input type="checkbox" name="fields[]" value="register_time"> 登记时间</label>
            <label><input type="checkbox" name="fields[]" value="notify_status"> 是否通知</label>
          </dd>
          </dl>
        <div class="tc mt10"><a href="javascript:;" onclick="export_excel()" class="button">导出</a></div>
        </form>
    </div>
</div>

<script type="text/javascript">
    function send_notify_dialog(){
        art.dialog({id:'send_notify_dialog',lock:true,opacity:0.1,title:'发送通知',width:600,height:300,content:document.getElementById("condition_box")});
    }
    function export_excel_dialog(){
        art.dialog({id:'export_excel_dialog',title:'Excel导出',lock:true,opacity:0.1,width:600,height:200,content:document.getElementById("excel_box")});
    }
    function export_excel() {
      $("#export_form").submit();
    }
    function send_notify(){
      var condition =  $("#condition_input").val();
      if(condition!=''){
        $.post("<?php echo urldecode(Url::urlFormat("/customer/send_notify"));?>",{condition:$("#condition_input").val()},function(data){
          if(!data['isError']){
            art.dialog.tips("<p class='success'>共发送["+data['count']+"]条通知，成功["+data['success']+"]条，失败["+data['fail']+"]条!</p>");
            art.dialog({id:"send_notify_dialog"}).close();
          }else{
            art.dialog.tips("<p class='fail'>"+data['msg']+"</p>");
          }
        },"json")
      }else{
        art.dialog.tips("<p class='warning'>请选择筛选条件，再发送！</p>");
      }
      return false;
    }
    function Condition(id){
        $("body").Condition({input:id,data:{store_nums:{name:'库存'},goods_id:{name:'商品ID'},'n.email':{name:'邮箱'},mobile:{name:'电话'},'notify_status':{name:'发送状态',values:{0:'未发送',1:'已发送'}}}});
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