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
    var editor;
    KindEditor.ready(function(K) {
      editor = K.create('textarea[name="content"],textarea[name="sale_protection"]', {
        uploadJson : '<?php echo urldecode(Url::urlFormat("/admin/upload_image"));?>'
      });
    });
</script>
<h1 class="page_title">商品编辑</h1>
<form action="<?php echo urldecode(Url::urlFormat("/goods/goods_save"));?>" class=" " method="post" callback="check_tab_location" >
  <?php if(isset($id)){?>
  <input type="hidden" name="id" value="<?php echo isset($id)?$id:"";?>">
  <?php }?>
  <div id="obj_form" class="form2 tab">
    <!-- tab 头 start -->
    <ul class="tab-head">
      <li>基本信息</li>
      <li>描述信息</li>
    </ul>
    <!-- tab 头 end -->
    <!-- tab body start -->
    <div class="tab-body">
      <!-- 基本信息 start -->
      <div>
        <dl class="lineD">
          <dt> <b class="red">*</b>
            分类：
          </dt>
          <dd>
            <select name="category_id" id="category_id" pattern="[1-9]\d*" alt="选择分类，若无分类请先创建。">
              <option value="0">选择分类</option>
              <?php $id=isset($id)?$id:0;?>
              <?php $query = new Query("goods_category");$query->order = "path";$items = $query->find();?>
              <?php $goods_category = Common::treeArray($items);?>
              <?php foreach($goods_category as $key => $item){?>
              <?php if(!isset($path) || strpos($item['path'],$path)===false){?>
              <?php $num = count(explode(',',$item['path']))-3;?>
                    <option value="<?php echo isset($item['id'])?$item['id']:"";?>"><?php if($num>0){?>├<?php }?><?php echo str_repeat('──',$num);?><?php echo isset($item['name'])?$item['name']:"";?></option>
                    <?php }?>
              <?php }?>
            </select>
            <label></label>
          </dd>
        </dl>
        <dl class="lineD">
          <dt>
            类型：
          </dt>
          <dd>
            <select name="type_id" id="type_id">
              <option value="0">请选择类型...</option>
              <?php $id=isset($id)?$id:0;?>
              <?php $item=null; $query = new Query("goods_type");$items = $query->find(); foreach($items as $key => $item){?>
              <option value="<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></option>
              <?php }?>
            </select>
            <label></label>
          </dd>
        </dl>
        <dl class="lineD">
          <dt>
            <b class="red">*</b>
            商品名称：
          </dt>
          <dd>
            <input name="name" type="text" pattern="required" value="<?php echo isset($name)?$name:"";?>" style="width:400px;" alt="不能为空">
            <label></label>
          </dd>
        </dl>
        <dl class="lineD">
          <dt>
            <b class="red">*</b>
            商品编号：
          </dt>
          <dd>
            <input name="goods_no" id="goods_no" type="text" pattern="\w{3,}" alt="请输入3个以上的字符(不能为中文)" value="<?php echo isset($goods_no)?$goods_no:"";?>" >
            <label></label>
          </dd>
        </dl>
        <dl class="lineD">
          <dt></dt>
          <dd >
            <table class="default border" style="width:auto;">
              <thead>
                <tr>
                 <!--  <th >积分</th> -->
                  <th >排序</th>
                  <th >计量单位</th>
                  <th style="width:100px;">是否上架</th>
                </tr>
                <tr class="min_inputs">
                  <!-- <td>
                    <input class="small" name="point" id="point" type="text" empty="" pattern="int" value="<?php echo isset($point)?$point:0;?>"></td> -->
                  <td>
                    <input class="small" name="sort" id="sort" type="text" pattern="int" empty="" value="<?php echo isset($sort)?$sort:1;?>"></td>
                  <td>
                    <input class="small" name="unit" pattern="required" type="text" value="<?php echo isset($unit)?$unit:'件';?>"></td>

                  <td class="tc">
                    <input type="checkbox" checked="checked" value="1" name=""/>
                  </td>
                </tr>
              </thead>
            </table>
          </dd>
        </dl>
        <dl class="lineD clearfix">
          <dt>产品相册：</dt>
          <dd class="min_inputs ">

            <button class="button  select_button" type="button" >
              <b class="icon-plus green"></b>
              添加图片
            </button> <b class="red">(注：点选图片，使其成为默认图片)</b>

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
                 <a class="icon-close" href="javascript:;" onclick="delImg(this)"></a>
                </div>
              </li>
              <?php }?>
            <?php }?>
            </ul>
              <input name="img" type="text" style="visibility: hidden;width:0;" value="<?php echo isset($img)?$img:"";?>" pattern="required" id="img_index" alt="添加商品图片"/>
              <label></label>
          </dd>
        </dl>

        <h3 class="mt">产品规格</h3>
        <div id="goods_list" >
          <table class="default border">
            <colgroup>
            <col width="160"/>
            <col/>
          </colgroup>
          <tr>
            <td class="tr">
              <b class="red">*</b>
              货号：
            </td>
            <td>
              <input  type="text" pattern="\w{3,}" name="pro_no" alt="请输入3个以上的字符(不能为中文)" value="<?php echo isset($goods_no)?$goods_no:"";?>"/>
              <label></label>
            </td>
          </tr>
          <tr>
            <td class="tr">
              <b class="red">*</b>
              库存：
            </td>
            <td>
              <input class="small" pattern="int" type="text" name="store_nums" value="<?php echo isset($store_nums)?$store_nums:"";?>" alt="必需为整数" />
              <label></label>
            </td>
          </tr>
          <tr>
            <td class="tr">
              <b class="red">*</b>
              预警线：
            </td>
            <td>
              <input class="small" type="text" pattern="int" name="warning_line" value="<?php echo isset($warning_line)?$warning_line:2;?>" alt="必需为整数"/>
              <label></label>
            </td>
          </tr>
          <tr>
            <td class="tr">
              <b class="red">*</b>
              重量(g)：
            </td>
            <td>
              <input class="small" type="text" pattern="int" name="weight" value="<?php echo isset($weight)?$weight:0;?>" alt="必需为整数"/>
              <label></label>
            </td>
          </tr>
          <tr>
            <td class="tr">
              <b class="red">*</b>
              零售价：
            </td>
            <td>
              <input class="small" type="text" pattern="float" name="sell_price" value="<?php echo isset($sell_price)?$sell_price:"";?>" alt="整数或保留小数点后两位精确度的数" />
              <label></label>
            </td>
          </tr>
          <tr>
            <td class="tr">
              <b class="red">*</b>
              市场价：
            </td>
            <td>
              <input class="small" pattern="float" type="text" name="market_price" value="<?php echo isset($market_price)?$market_price:"";?>" alt="整数或保留小数点后两位精确度的数"/>
              <label></label>
            </td>
          </tr>
          <tr>
            <td class="tr">
              <b class="red">*</b>
              成本价：
            </td>
            <td>
              <input class="small" pattern="float" type="text" name="cost_price" value="<?php echo isset($cost_price)?$cost_price:0;?>" alt="整数或保留小数点后两位精确度的数"/>
              <label></label>
            </td>
          </tr>
          <tr>
            <td class="tr">
              <b class="red">*</b>
              规格：
            </td>
            <td>
              <button class="button " type="button" id="open_spec">
                <b class="icon-plus green"></b>
                开启规格
              </button>
            </td>
          </tr>
        </table>
      </div>
      <div style="overflow: auto;" id="spec_list">

        <?php if(isset($specs) && strlen($specs)>6){?>
        <!--隐藏goods规格信息-->
        <script type="text/javascript">
          $("#goods_list").css({display:'none'});
          $("#goods_list input").attr("disabled","disabled");
        </script>
        <?php  $specs = unserialize($specs); $spec_ids='';?>
        <div style="margin:10px 0;"><button onclick="edit_spec()" type="button" class="button"><b class=" icon-pencil-2 green"></b> 编辑规格</button> <button id="close_spec_button" type="button" onclick="close_spec()" class="button"><b class="icon-close red"></b> 关闭规格</button></div><table class="default" style="width:auto"><tbody><tr><th>商品货号</th><?php foreach($specs as $key => $item){?><th><?php echo isset($item['name'])?$item['name']:"";?><?php $spec_ids .= $item['id'].',';?></th><?php }?><th><input name="spec_items" type="hidden" value="<?php echo rtrim($spec_ids,",");?>">库存</th><th>预警线</th><th>零售价</th><th>市场价</th><th>成本价</th><th>重量(g)</th><th>操作</th></tr>
        <?php $products_info=array();?>
        <?php $item=null; $query = new Query("products");$query->where = "goods_id = $id";$query->order = "id";$items = $query->find(); foreach($items as $key => $item){?>
        <?php $spec = unserialize($item['spec']);$spec_str = '';?>
        <tr class="min_inputs"><td><input type="text" pattern="required" name="pro_no[]" value="<?php echo isset($item['pro_no'])?$item['pro_no']:"";?>" style="width:160px"></td><?php foreach($spec as $key => $spc){?><td><?php echo isset($spc['value'][2])?$spc['value'][2]:"";?><?php $spec_str .= implode(":",$spc['value']).",";?></td><?php }?><td><?php $spec_item_key = trim($spec_str,',');$products_info[$spec_item_key]=array('store_nums'=>$item['store_nums'],'warning_line'=>$item['warning_line'],'sell_price'=>$item['sell_price'],'market_price'=>$item['market_price'],'cost_price'=>$item['cost_price'],'weight'=>$item['weight']);?><input name="spec_item[]" type="hidden" value="<?php echo trim($spec_str,',');?>"><input type="text" pattern="int" class="small" name="store_nums[]" value="<?php echo isset($item['store_nums'])?$item['store_nums']:"";?>"></td><td><input pattern="int" class="small" type="text" name="warning_line[]" value="<?php echo isset($item['warning_line'])?$item['warning_line']:"";?>"></td><td><input class="small" pattern="float" type="text" name="sell_price[]" value="<?php echo isset($item['sell_price'])?$item['sell_price']:"";?>"></td><td><input class="small" pattern="float" type="text" name="market_price[]" value="<?php echo isset($item['market_price'])?$item['market_price']:"";?>"></td><td><input pattern="float" class="small" type="text" name="cost_price[]" value="<?php echo isset($item['cost_price'])?$item['cost_price']:"";?>"></td><td><input class="small" pattern="int" type="text" name="weight[]" value="<?php echo isset($item['weight'])?$item['weight']:"";?>"></td><td><a href="javascript:;" class="icon-close" onclick="spec_del(this)"></a></td></tr>
        <?php }?>
        </tbody></table>
        <?php }?>
      </div>

      <div id="goods_attr" style="display:<?php if(isset($attrs) && strlen($attrs) > 6 ){?><?php }else{?>none<?php }?>" >
        <h3 class="mt mt10">产品属性</h3>
        <div id="attr_list">
          <table class="default">
            <colgroup>
            <col width="160" />
            <col />
          </colgroup>
          <?php if(isset($type_id) && $type_id){?>
            <?php $query = new Query("goods_type");$query->where = "id = $type_id";$items = $query->find();?>
            <?php $_attrs = unserialize($items[0]['attr']); $attrs = unserialize($attrs);?>
            <?php if($_attrs){?>
              <?php foreach($_attrs as $key => $item){?>
          <tr>
            <td class='tr'><?php echo isset($item['name'])?$item['name']:"";?></td>
            <td>
              <?php if($item['show_type']<= 2){?>
                <select name="attr[<?php echo isset($item['id'])?$item['id']:"";?>]">
                <?php foreach($item['values'] as $key => $value){?>
                <option value="<?php echo isset($value['id'])?$value['id']:"";?>" <?php if(isset($attrs[$item['id']]) && $attrs[$item['id']]==$value['id']){?> selected="selected" <?php }?> ><?php echo isset($value['name'])?$value['name']:"";?></option>
                <?php }?>
              </select>
              <?php }else{?>
              <input name="attr[<?php echo isset($item['id'])?$item['id']:"";?>]" type="text" value="<?php echo isset($attrs[$item['id']])?$attrs[$item['id']]:"";?>" />
              <?php }?>
            </td>
          </tr>
          <?php }?>
          <?php }?>
        <?php }?>
        </table>
      </div>
    </div>
  </div>
  <!-- 描述信息 start -->
  <div>
    <h2>详细介绍：</h2>
    <div>
      <textarea id="content" pattern="required" name="content" style="width:700px;height:360px;visibility:hidden;"><?php echo isset($content)?$content:"";?></textarea>
      <label></label>
    </div>
  </div>
  <!-- 描述信息 end -->
  <!-- 基本信息 end -->
  
</div>
<!-- tab 头 end -->
<div style="text-align:center;margin-top:20px;">
  <input type="submit" class="focus_button" value="提交" >
  &nbsp;&nbsp;&nbsp;&nbsp;
  <input type="reset" value="重置" class="button"></div>
</div>
</form>
<script type="text/javascript">
var form =  new Form();
form.setValue('category_id','<?php echo isset($category_id)?$category_id:"";?>');
form.setValue('type_id','<?php echo isset($type_id)?$type_id:"";?>');
form.setValue('brand_id','<?php echo isset($brand_id)?$brand_id:"";?>');
$("#type_id").change();

<?php if(isset($products_info)){?>
var products_info = <?php echo JSON::encode($products_info);?>;
<?php }else{?>
var products_info = new Array();
<?php }?>

$(".select_button").on("click",function(){
      uploadFile();
      return false;
    });
$("#goods_no").on("change",function(){
  var that = $(this);
  if(that.val()){
    var old_val = $("input[name='pro_no']").val();
    $("input[name='pro_no']").val(that.val());
    $("input[name='pro_no[]']").each(function(i){
      var current_value = $(this).val();
      var temp = old_val+'_'+(i+1);
      if(current_value=='' || current_value==temp) $(this).val(that.val()+'_'+(i+1));
    });
  }

})
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
    $("#pic_list").append('<li> <div class="bord"><input type="hidden" name="imgs[]" value="'+value+'" /> <img src="'+show_src+'" data-src="'+value+'" onclick="selectImg(this)" width="80" height="80" alt=""></div> <div class="opera"><a class="icon-close" href="javascript:;" onclick="delImg(this)"></a> </div> </li>');
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

//开启规格
$("#open_spec").on("click",function(){
      //art.dialog.open('<?php echo urldecode(Url::urlFormat("/goods/show_spec_select"));?>',{id:'spec_list',title:'选择图片',width:800,height:460});
      //art.dialog({id:'spec_list'}).show();
      edit_spec();
      return false;
    });

//添加规格


function addSpec(specs){
  specs = specs.split(";");
  var str_ths ='<tr><th>商品货号</th>';
  var spec_array = new Array();
  var spec_items = '';
  var num = 0;
  for(i in specs){
    var spec_str = specs[i].split("=");
    var spec = spec_str[0].split(":");
    var values = spec_str[1].split(",");
    var values_array = new Array();
    var index = 0;
    for(v in values){
      var value = values[v].split(':');
      //values_array[index++] = value[0]+":"+(value[2]==''?value[1]:value[2]);
      values_array[index++] = values[v];
    }
    spec_array[num++] = values_array;
    spec_items += spec[0]+',';
    str_ths += '<th>'+spec[1]+'</th>';
  }
  spec_items = spec_items.slice(0,-1);

  str_ths += '<th><input name="spec_items" type="hidden" value="'+spec_items+'"/>库存</th><th>预警线</th><th>零售价</th><th>市场价</th><th>成本价</th><th>重量(g)</th><th>操作</th></tr>';
 var str_tds = '';
 specs = descartes(spec_array);
 var pro_no_per = $("#goods_no").val();
 var store_nums = $("input[name='store_nums']").val();
 var warning_line = $("input[name='warning_line']").val();
 var sell_price = $("input[name='sell_price']").val();
 var market_price = $("input[name='market_price']").val();
 var cost_price = $("input[name='cost_price']").val();
 var weight = $("input[name='weight']").val();
  for(i in specs){
    var spec_item = '';
    str_tds += '<tr class="min_inputs"><td><input type="text" pattern="required" name="pro_no[]"  value="'+(pro_no_per==''?'':pro_no_per+'_'+(parseInt(i)+1))+'" style="width:160px"></td>';

    if(typeof specs[i] == "object"){
        for(j in specs[i]){
          spec_item += specs[i][j]+',';
          var value = specs[i][j].split(":");
        str_tds +='<td>'+(value[2]==''?value[1]:value[2])+'</td>';
      }
    }
    else{
      spec_item = specs[i]+',';
      var value = specs[i].split(":");
      str_tds +='<td>'+(value[2]==''?value[1]:value[2])+'</td>';
    }
    spec_item = spec_item.slice(0,-1);
    if(products_info!=undefined && products_info[spec_item]!=undefined){
      var s_item = products_info[spec_item];
      store_nums = s_item['store_nums']!=undefined?s_item['store_nums']:'';
      warning_line = s_item['warning_line']!=undefined?s_item['warning_line']:'';
      sell_price = s_item['sell_price']!=undefined?s_item['sell_price']:'';
      market_price = s_item['market_price']!=undefined?s_item['market_price']:'';
      cost_price = s_item['cost_price']!=undefined?s_item['cost_price']:'';
      weight = s_item['weight']!=undefined?s_item['weight']:'';

    }
    str_tds += '<td><input name="spec_item[]" type="hidden" value="'+spec_item+'"/><input type="text" pattern="int" class="small" name="store_nums[]" value="'+store_nums+'"></td><td><input  pattern="int" class="small" type="text" name="warning_line[]" value="'+warning_line+'"></td><td><input class="small" pattern="float" type="text" name="sell_price[]" value="'+sell_price+'"></td><td><input class="small" pattern="float" type="text" name="market_price[]" value="'+market_price+'"></td><td><input pattern="float" class="small" type="text" name="cost_price[]" value="'+cost_price+'"></td><td><input class="small" pattern="int" type="text" name="weight[]" value="'+weight+'"></td><td><a href="javascript:;" class="icon-close" onclick="spec_del(this)" ></a></td></tr>';
  }
  $("#spec_list").css({display:''});

  $("#spec_list").html('<div style="margin:10px 0;"><button onclick="edit_spec()" type="button" class="button"><b class=" icon-pencil-2 green"></b> 编辑规格</button> <button id="close_spec_button" onclick="close_spec()" class="button" type="button"><b class="icon-close red"></b> 关闭规格</button></div><table class="default" style="width:auto">'+str_ths+str_tds+'</table>');
  $("#goods_list").css({display:'none'});
  $("#goods_list input").attr("disabled","disabled");
  art.dialog({id:'spec_list'}).hide();
  $("#spec_list input").on("change",function(){
    changeProductsInfo($(this));
    // var parent = $(this).parent().parent();
    // var spec_item = $("input[name='spec_item[]']",parent).val();
    // var name = $(this).attr("name");
    // var value = $(this).val();
    // name = name.replace("[]",'');
    // if(products_info[spec_item]==undefined) products_info[spec_item] = new Array();
    // products_info[spec_item][name] = value;
  });
}
$("#spec_list input").on("change",function(){
  changeProductsInfo($(this));
});

function changeProductsInfo(el)
{
    var parent = el.parent().parent();
    var spec_item = $("input[name='spec_item[]']",parent).val();
    var name = el.attr("name");
    var value = el.val();
    name = name.replace("[]",'');
    if(products_info[spec_item]==undefined) products_info[spec_item] = new Array();
    products_info[spec_item][name] = value;
}
//关闭规格
function close_spec(){
  $("#spec_list").css({display:'none'});
  $("#spec_list input").attr("disabled","disabled");
  $("#goods_list input").removeAttr("disabled");
  $("#goods_list").css({display:''});
  return false;
}

function edit_spec(){
  var spec_dcr_str = '';
  $("input[name='spec_item[]']").each(function(){
    spec_dcr_str += $(this).val()+",";
  })
  art.dialog.data("spec_init_data",spec_dcr_str.slice(0,-1));
  if($("iframe[name='Openspec_list']").length>0)art.dialog({id:'spec_list'}).show();
  else{
    art.dialog.open('<?php echo urldecode(Url::urlFormat("/goods/show_spec_select"));?>',{id:'spec_list',resize:false,title:'选择图片',width:800,height:460});
  }
  return false;
}

//删除规格
function spec_del(id){
  if($("#spec_list tr").length>2) $(id).parent().parent().remove();
  else {
    art.dialog.confirm('你确认删除操作？', function(){
      close_spec();
    });
  }
}
//选择分类
$("#category_id").on("change",function(){
  $.post("<?php echo urldecode(Url::urlFormat("/ajax/category_type"));?>", {id: $(this).val()},function(data){
    form.setValue('type_id',data.type_id);
    $("#type_id").change();
  },"json");
})

//改变类型处理操作
$("#type_id").on("change",function(){
  $("#goods_attr").css({display:'none'});
  $("#attr_list table tr").remove();

  $.post("<?php echo urldecode(Url::urlFormat("/ajax/type_attr"));?>", {id: $(this).val()},function(data){
    if(data){
      $("#goods_attr").css({display:''});
      var tr = "";

      for(var i in data){
        tr += "<tr><td class='tr'>"+data[i].name+"：</td><td>";
        var values = data[i].values;
        if(data[i].show_type<=2){
          tr += '<select name="attr['+data[i].id+']">';
          for(var j in values){
            tr += '<option value="'+values[j].id+'">'+values[j].name+'</option>';
          }
          tr += '</select>';
        }
        else{
          tr += '<input type="text" pattern="required" name="attr['+data[i].id+']" />';
        }

        tr += "</td></tr>";
      }
      $("#attr_list table").append(tr);
    }

  },"json");
})

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