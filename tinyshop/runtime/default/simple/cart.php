<!doctype html>
<html lang="zh-CN">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta charset="UTF-8">
    <meta name="HandheldFriendly" content="True">
    <link rel="shortcut icon" href="<?php echo urldecode(Url::urlFormat("@favicon.ico"));?>"/>
    <link rel="bookmark" href="<?php echo urldecode(Url::urlFormat("@favicon.ico"));?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo urldecode(Url::urlFormat("#css/common.css"));?>">
    <link rel="stylesheet" type="text/css" href="<?php echo urldecode(Url::urlFormat("#css/simple.css"));?>">
    <link rel="stylesheet" type="text/css" href="<?php echo urldecode(Url::urlFormat("#css/font-awesome.min.css"));?>">
    <link rel="stylesheet" type="text/css" href="<?php echo urldecode(Url::urlFormat("#js/artdialog/tiny-dialog.css"));?>">

    <script src="<?php echo urldecode(Url::urlFormat("#js/jquery.min.js"));?>"></script>
    <script src="<?php echo urldecode(Url::urlFormat("#js/artdialog/dialog-plus-min.js"));?>"></script>
    <script src="<?php echo urldecode(Url::urlFormat("#js/common.js"));?>"></script>
    <?php echo JS::import('form');?>
    <title><?php if(isset($seo_title) && isset($site_title) && ($seo_title == $site_title)){?><?php echo isset($seo_title)?$seo_title:"";?><?php }else{?><?php echo isset($seo_title)?$seo_title:"";?>-<?php echo isset($site_title)?$site_title:"";?><?php }?></title>
</head>
<body>
    <!-- S 头部区域 -->
    <div id="header">
        <div class="container head-main">
            <a href="<?php echo urldecode(Url::urlFormat("/index/index"));?>" class="sub-1 logo"></a>
        </div>
    </div>
    <!-- E 头部区域 -->

    <!-- S 主控区域 -->
    <div id="main" class="simple-main">
        <link type="text/css" rel="stylesheet" href="<?php echo urldecode(Url::urlFormat("#css/simple.css"));?>" />
<?php $items=array("购物车","确认订单信息","选择支付","订购完成");?>
<div id='widget_sub_navs'><?php $widget = Widget::createWidget('sub_navs');$widget->action = "crumbs";$widget->items = $items;$widget->step = "4";$widget->current = "1";$widget->cache = "false";$widget->run();?></div>
<div class="mt20  container">
  <?php if($cart){?>
  <table width="100%" class="simple">
    <tr>
     <th style="width:60px;">商品</th>
     <th style="width:200px;">名称</th>
     <th style="width:160px;">规格</th>
     <th style="width:100px;">单价</th>
     <th style="width:120px;">数量</th>
     <th style="width:100px;">优惠</th>
     <th style="width:80px;">小计</th>
     <th style="width:40px;">操作</th>
   </tr>
   <?php $total=0.00;$trNum=0;?>
   <?php foreach($cart as $key => $item){?>
   <?php $total+=$item['amount'];?>
   <tr class="<?php if($trNum%2==1){?>odd<?php }else{?>even<?php }?>" id="<?php echo isset($item['id'])?$item['id']:"";?>"><td><a href="<?php echo urldecode(Url::urlFormat("/index/product/id/$item[goods_id]"));?>" target="_blank"><img src="<?php echo Common::thumb($item['img'],100,100);?>" width="50" height="50"></a></td><td><a href="<?php echo urldecode(Url::urlFormat("/index/product/id/$item[goods_id]"));?>" target="_blank"><?php echo TString::msubstr($item['name'],0,36);?></a></td> <td><?php foreach($item['spec'] as $key => $spec){?>
     <p title="<?php echo isset($spec['name'])?$spec['name']:"";?>:<?php echo isset($spec['value'][2])?$spec['value'][2]:"";?>"><?php echo isset($spec['name'])?$spec['name']:"";?>：<?php echo isset($spec['value'][2])?$spec['value'][2]:"";?></p>
     <?php }?></td> <td><?php echo isset($item['price'])?$item['price']:"";?></td> <td><div  class="buy-num-bar buy-num clearfix"><a class="btn-dec" href="javascript:;"><i class="icon-minus-16"></i></a><input  name="buy_num" value="<?php echo isset($item['num'])?$item['num']:"";?>"  maxlength=5><a class="btn-add" href="javascript:;"><i class="icon-plus-16"></i></a></div></td> <td class="prom"><?php echo isset($item['prom'])?$item['prom']:"";?></td> <td class="amount red"><?php echo isset($item['amount'])?$item['amount']:"";?></td> <td class="tc"><a href="#" class="icon-close-16"></a></td></tr>
     <?php $trNum++;?>
     <?php }?>
   </table>
   <div class="mb10 clearfix" style="padding:10px; background: #f0f0f0;"><span class="fr">商品总价(不含运费)：<span style="font-size: 24px;font-family: tahoma"><span class="currency-symbol"><?php echo isset($currency_symbol)?$currency_symbol:"";?></span><b class="cart-total red" ><?php echo sprintf("%01.2f",$total);?></b></span></span></div>

   <div class="mt10 clearfix">
    <p class="fr"><a class="btn btn-gray" href="<?php echo urldecode(Url::urlFormat("/index/index"));?>">继续购物</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-main" href="<?php echo urldecode(Url::urlFormat("/simple/order/cart_type/$cart_type"));?>">立即结算</a></p></div>
  </div>
  <?php }else{?>
  <div class="mt20 mb20 p20 box">
    <p class="cart-empty ie6png">购物车内暂时没有商品，<a  href="<?php echo urldecode(Url::urlFormat("/index/index"));?>">去首页</a> 挑选喜欢的商品。</p>

  </div>
  <div class="mt10 clearfix">
    <p class="fr"><a class="btn btn-main" href="<?php echo urldecode(Url::urlFormat("/index/index"));?>"> < 继续购物</a></p>
  </div>
  <?php }?>
  <script type="text/javascript">
   $(".btn-dec").on("click",function(){
    var parent = $(this).parent().parent();
    var id = parent.parent().attr("id");
    var num = parent.find("input").val();
    if(num>1) num--;
    else num=1;
    if($("#"+id).find("input").val()!=num) changeInfo(id,num);
    parent.find("input").val(num);
  });
   $(".btn-add").on("click",function(){
     var parent = $(this).parent().parent();
     var id = parent.parent().attr("id");
     var num = parent.find("input").val();
     num++;
     if($("#"+id).find("input").val()!=num) changeInfo(id,num);
     parent.find("input").val(num);
   });

   $(".buy-num-bar input").on("change",function(){
    var num = parseInt($(this).val());
    var parent = $(this).parent().parent();
    var id = parent.parent().attr("id");
    changeInfo(id,num);
  })
   $(".icon-close-16").on("click",function(){
     var parent = $(this).parent();
     var id = $(this).parent().parent().attr("id");
     $.post("<?php echo urldecode(Url::urlFormat("/index/cart_del/cart_type/$cart_type"));?>",{id:id},function(data){
      if(data['status']=='success')location.reload();
    },'json');
   })

   function changeInfo(id,num){
     $.post("<?php echo urldecode(Url::urlFormat("/index/cart_num/cart_type/$cart_type"));?>",{id:id,num:num},function(data){
      var total = 0.00;
      for(var i in data) total += parseFloat(data[i]['amount']);
        $("#"+id).find(".amount").text(data[id]['amount']);
      $("#"+id).find(".prom").text(data[id]['prom']);
      if(parseInt($("#"+id).find("input").val())>data[id]['store_nums']){
        $("#"+id).find("input").val(data[id]['store_nums']);
        var parent = $("#"+id).find("input").parent().parent();
        if(parent.find(".msg-simple-error").size()==0)parent.append("<div class='msg-simple-error'>最多购买"+data[id]['store_nums']+"件</div>");
      }else{
        $("#"+id).find("input").val(data[id]['num']);
        $("#"+id).find("input").parent().parent().find(".msg-simple-error").remove();
      }
      $(".cart-total").text(total.toFixed(2));
    },"json");
   }
 </script>

    </div>
    <!-- E 主控区域 -->

    <!-- S 底部区域 -->
    <div id="footer">
       <?php include './themes/default/layout/footer.php';?>
    </div>
    <!-- E 底部区域 -->
</body>
</html>

<!--Powered by TinyRise-->