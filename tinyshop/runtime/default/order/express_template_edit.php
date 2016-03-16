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
<script type="text/javascript" src="<?php echo urldecode(Url::urlFormat("@static/js/jquery.event.drag.js"));?>"></script>
<style type="text/css">

#container ,.container {
  width: <?php echo isset($width)?$width:840;?>px;
  height: <?php echo isset($height)?$height:480;?>px;
  text-align: left;
  margin: 0;
  position: relative;
  overflow: hidden;
  border: 1px solid #d2d2d2;
  background: url(<?php echo urldecode(Url::urlFormat("@"));?><?php echo isset($background)?$background:"";?>) 0px 0px no-repeat;
}

.container .item {
  line-height: 20px;
  float: left;
  position: absolute;
  top: 0px;
  left: 0px;
  color: #666666;
  overflow: hidden;
  word-wrap: break-word;
  filter: alpha(opacity = 80);
  -moz-opacity: 0.8;
  opacity: 0.8;
  border: 1px dotted #999999;
  background: #ffffff;
  padding-left:4px;
  color: #000;
}

.container .selected {
  filter: alpha(opacity = 100);
  -moz-opacity: 1;
  opacity: 1;
  border: 1px solid #ff6600;
}

.container pre {
  height: 100%;
  float: left;
  cursor: move;
}

.container textarea {
  padding-left: 0px;
  margin: 0px;
  font-size: 12px;
  resize: none;
  outline: none;
  overflow: hidden;
  border: none;
}

.container .resize {
  height: 6px;
  width: 6px;
  position: absolute;
  bottom: 0px;
  right: 0px;
  overflow: hidden;
  cursor: nw-resize;
  background-color: #aaaaaa;
}
</style>
<script type="text/javascript">
$().ready(function() {

  var $inputForm = $("#inputForm");
  var $addTag = $("#addTag");
  var $tagOption = $("#tagOption a");
  var $deleteTag = $("#deleteTag");
  var $container = $("#container");
  var $browserButton = $("#browserButton");
  var $background = $("#background_input");
  var $width = $("#width");
  var $height = $("#height");
  var zIndex = 1;


  bind($container.find("div.item"));



  // 标签选项
  $tagOption.click(function() {
    var value = $(this).attr("val");
    if (value != "") {
      bind($('<div class="item"><pre>' + value + '<\/pre><div class="resize"><\/div><\/div>').appendTo($container));
    }
    return false;
  });

  // 绑定
  function bind($item) {
    $item.drag("start", function(ev, dd) {
      var $this = $(this);
      dd.width = $this.width();
      dd.height = $this.height();
      dd.limit = {
        right: $container.innerWidth() - $this.outerWidth(),
        bottom: $container.innerHeight() - $this.outerHeight()
      };
      dd.isResize = $(ev.target).hasClass("resize");
    }).drag(function(ev, dd) {
      var $this = $(this);
      if (dd.isResize) {
        $this.css({
          width: Math.max(20, Math.min(dd.width + dd.deltaX, $container.innerWidth() - $this.position().left) - 2),
          height: Math.max(20, Math.min(dd.height + dd.deltaY, $container.innerHeight() - $this.position().top) - 2)
        }).find("textarea").blur();
      } else {
        $this.css({
          top: Math.min(dd.limit.bottom, Math.max(0, dd.offsetY)),
          left: Math.min(dd.limit.right, Math.max(0, dd.offsetX))
        });
      }
    }, {relative: true}).mousedown(function() {
      $(this).css("z-index", zIndex++);
    }).click(function() {
      var $this = $(this);
      $container.find("div.item").not($this).removeClass("selected");
      $this.toggleClass("selected");
    }).dblclick(function() {
      var $this = $(this);
      if ($this.find("textarea").size() == 0) {
        var $pre = $this.find("pre");
        var value = $pre.hide().text($pre.html()).html();
        $('<textarea>' + value + '<\/textarea>').replaceAll($pre).width($this.innerWidth() - 6).height($this.innerHeight() - 6).blur(function() {
          var $this = $(this);
          $this.replaceWith('<pre>' + $this.val() + '<\/pre>');
        }).focus();
      }
    });
  }

  // 删除标签
  $deleteTag.click(function() {
    $container.find("div.selected").remove();
    return false;
  });

  // 单据背景图
  // $browserButton.browser({
  //   callback: function(url) {
  //     $container.css({
  //       background: "url(" + url + ") 0px 0px no-repeat"
  //     });
  //   }
  // });

  $background.bind("input propertychange change", function() {
    $container.css({
      background: "url(<?php echo urldecode(Url::urlFormat("@"));?>" + $background.val() + ") 0px 0px no-repeat"
    });
  });

  // 宽度
  $width.bind("input propertychange change", function() {
    $container.width($width.val());
  });

  // 高度
  $height.bind("input propertychange change", function() {
    $container.height($height.val());
  });


});

function checkForm(e){
  if(e==null){

    if ($.trim($("#container").html()) == "") {
      alert('模板内容不能为空！')
          return false;
    }
    $("#content_map").val($("#container").html());
  }

}
</script>

<h1 class="page_title">快递单模板编辑 【 <a href="<?php echo urldecode(Url::urlFormat("$nav_link"));?>" class="icon-arrow-left-2 "> 返回</a> 】</h1>
   <form id="inputForm"  method="post" action="<?php echo urldecode(Url::urlFormat("/order/express_template_save"));?>" callback="checkForm">
    <?php if(isset($id)){?>
    <input type="hidden" name="id" value="<?php echo isset($id)?$id:"";?>" />
    <?php }?>
    <input type="hidden" id="content_map" name="content" value=""/>
    <div class="lineD">名称：<input type="text" class="small"  name="name" pattern="required"  value="<?php echo isset($name)?$name:"";?>" /> <label></label> 宽度：<input type="text" class="tiny"  id="width" name="width" value="<?php echo isset($width)?$width:840;?>" /> 高度：<input type="text" class="tiny"  id="height" name="height"  value="<?php echo isset($height)?$height:480;?>" /> 偏移量 X：<input type="text" class="tiny" name="offset_x"  value="<?php echo isset($offset_x)?$offset_x:0;?>" /> 偏移量 Y：<input type="text" class="tiny" name="offset_y"  value="<?php echo isset($offset_y)?$offset_y:0;?>" /> 是否默认：<input type="checkbox" name="is_default" checked="checked" value="1" />默认
     <input  id="background_input" name="background" type="hidden"  value="<?php echo isset($background)?$background:"";?>" />
            <input type="button" id="background_img" class="button" value="背景图片" />
          </div>
          <div style="padding-left: 415px; margin-bottom: 20px;" class="lineD">
        <div class="operat hidden btn_min">
          <a  class="icon-cog action" href="javascript:;"> 添加标签</a> &nbsp;&nbsp;<a href="javascript:;" id="deleteTag" class="button">删除标签</a> &nbsp;&nbsp;
          <button href="javascript:;" id="deleteTag" class="button">保存模板</button>
          <div class="menu_select" style="width:160px">
            <ul id="tagOption">
                <li>
                  <a href="javascript:;" val="发货点-名称">发货点 - 名称</a>
                </li>
                <li>
                  <a href="javascript:;" val="发货点-联系人">发货点 - 联系人</a>
                </li>
                <li>
                  <a href="javascript:;" val="发货点-地区1级">发货点 - 地区1级</a>
                </li>
                <li>
                  <a href="javascript:;" val="发货点-地区2级">发货点 - 地区2级</a>
                </li>
                <li>
                  <a href="javascript:;" val="发货点-地区3级">发货点 - 地区3级</a>
                </li>
                <li>
                  <a href="javascript:;" val="发货点-地址">发货点 - 地址</a>
                </li>
                <li>
                  <a href="javascript:;" val="发货点-电话">发货点 - 电话</a>
                </li>
                <li>
                  <a href="javascript:;" val="发货点-手机">发货点 - 手机</a>
                </li>
                <li>
                  <a href="javascript:;" val="收货人-姓名">收货人 - 姓名</a>
                </li>
                <li>
                  <a href="javascript:;" val="收货人-地区1级">收货人 - 地区1级</a>
                </li>
                <li>
                  <a href="javascript:;" val="收货人-地区2级">收货人 - 地区2级</a>
                </li>
                <li>
                  <a href="javascript:;" val="收货人-地区3级">收货人 - 地区3级</a>
                </li>
                <li>
                  <a href="javascript:;" val="收货人-地址">收货人 - 地址</a>
                </li>
                <li>
                  <a href="javascript:;" val="收货人-电话">收货人 - 电话</a>
                </li>
                <li>
                  <a href="javascript:;" val="收货人-手机">收货人 - 手机</a>
                </li>
                <li>
                  <a href="javascript:;" val="订单-订单编号">订单 - 订单编号</a>
                </li>
                <li>
                  <a href="javascript:;" val="订单-配送费用">订单 - 配送费用</a>
                </li>
                <li>
                  <a href="javascript:;" val="订单-手续费">订单 - 手续费</a>
                </li>
                <li>
                  <a href="javascript:;" val="订单-总商品重量">订单 - 总商品重量</a>
                </li>
                <li>
                  <a href="javascript:;" val="订单-总商品数量">订单 - 总商品数量</a>
                </li>
                <li>
                  <a href="javascript:;" val="订单-订单总额">订单 - 订单总额</a>
                </li>
                <li>
                  <a href="javascript:;" val="订单-附言">订单 - 附言</a>
                </li>
                <li>
                  <a href="javascript:;" val="网站-名称">网站 - 名称</a>
                </li>
                <li>
                  <a href="javascript:;" val="网站-网址">网站 - 网址</a>
                </li>
                <li>
                  <a href="javascript:;" val="网站-联系地址">网站 - 联系地址</a>
                </li>
                <li>
                  <a href="javascript:;" val="网站-电话">网站 - 电话</a>
                </li>
                <li>
                  <a href="javascript:;" val="网站-邮箱">网站 - 邮箱</a>
                </li>
                <li>
                  <a href="javascript:;" val="时间-年">时间 - 当前年</a>
                </li>
                <li>
                  <a href="javascript:;" val="时间-月">时间 - 当前月</a>
                </li>
                <li>
                  <a href="javascript:;" val="时间-日">时间 - 当前日</a>
                </li>
                <li>
                  <a href="javascript:;" val="时间-当前日期">时间 - 当前日期</a>
                </li>
                <li>
                  <a href="javascript:;" val="√">选中 - √</a>
                </li>
              </ul>
          </div>
        </div>
          </div>

        <div id="container" class="container">
          <?php echo isset($content)?$content:"";?>
        </div>

    </form>
    <script type="text/javascript">
    var form =  new Form();
form.setValue('is_default','<?php echo isset($is_default)?$is_default:"";?>');

$("#background_img").on("click",function(){
      uploadFile();
      return false;
    });
function uploadFile(){
  art.dialog.open('<?php echo urldecode(Url::urlFormat("/admin/photoshop/type/3"));?>',{id:'upimg_dialog',lock:true,opacity:0.1,title:'选择图片',width:613,height:380});
}
function setImg(value){
  $("#background_input").val(value);
  $("#container").css({
       background: "url(<?php echo urldecode(Url::urlFormat("@"));?>" + value + ") 0px 0px no-repeat"
      });
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