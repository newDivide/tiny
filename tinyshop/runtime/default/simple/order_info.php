<!doctype html>
<html lang="zh-CN">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta charset="UTF-8">
    <meta name="HandheldFriendly" content="True">
    <?php include './themes/default/layout/import.php';?>
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
        <?php echo JS::import("form");?>
<?php echo JS::import('dialog?skin=simple');?>
<?php echo JS::import('dialogtools');?>
<link type="text/css" rel="stylesheet" href="<?php echo urldecode(Url::urlFormat("#css/simple.css"));?>" />
<?php $items=array("确认订单信息","选择支付","订购完成");?>
<div id='widget_sub_navs'><?php $widget = Widget::createWidget('sub_navs');$widget->action = "crumbs";$widget->items = $items;$widget->step = "3";$widget->current = "1";$widget->cache = "false";$widget->run();?></div>
<div class="container">
    <div class="order-info">
        <form action="<?php echo urldecode(Url::urlFormat("/simple/order_act"));?>" method="post">
            <input type="hidden" name="type" value="<?php echo isset($order_type)?$order_type:"";?>">
            <input type="hidden" name="id" value="<?php echo isset($id)?$id:"";?>">
            <div class="clearfix mt15 address">
                <h2>选择收货地址：<a class="fr" href="<?php echo urldecode(Url::urlFormat("/ucenter/address"));?>" target="_blank">管理地址</a></h2>
                <ul class="address-list clearfix">
                    <?php $address_default=0;?>
                    <?php foreach($address as $key => $item){?>
                    <li>
                        <i class="icon-selected-32"></i>
                        <a href="javascript:;" data-value="<?php echo isset($item['id'])?$item['id']:"";?>" class="modify"> 修改地址 </a>
                        <div class="address-info">
                            <input type="radio" name="address_id" value="<?php echo isset($item['id'])?$item['id']:"";?>" <?php if($item['is_default']==1){?>
                            <?php $address_default=$item['id'];?>
                            checked="checked"<?php }?>><label><?php echo isset($parse_area[$item['province']])?$parse_area[$item['province']]:"";?> <?php echo isset($parse_area[$item['city']])?$parse_area[$item['city']]:"";?> <?php echo isset($parse_area[$item['county']])?$parse_area[$item['county']]:"";?> <?php echo isset($item['addr'])?$item['addr']:"";?> （<?php echo isset($item['accept_name'])?$item['accept_name']:"";?> 收）<?php echo isset($item['mobile'])?$item['mobile']:"";?></label>
                        </div>
                    </li>
                    <?php }?>
                </ul>
                <div><a id="address_other" class="btn btn-mini" href="javascript:;">使用新地址</a></div>
            </div>
            <h2 class="f14 mt20">支付方式：</h2>
            <div class="clearfix">
                <ul class="payment-list">
                    <?php $payment_default = 1;?>
                    <?php $item=null; $query = new Query("payment as pa");$query->fields = "pa.*,pp.logo";$query->join = "left join pay_plugin as pp on pa.plugin_id = pp.id";$query->where = "pa.status = 0 and (pa.client_type = 0 or pa.client_type = 2)";$query->order = "pa.sort desc";$items = $query->find(); foreach($items as $key => $item){?>
                    <li ><input type="radio" name="payment_id" <?php if($key==0){?> <?php $payment_default = $item['id'];?> checked="checked"<?php }?> value="<?php echo isset($item['id'])?$item['id']:"";?>"><label><b><?php echo isset($item['pay_name'])?$item['pay_name']:"";?></b> <?php echo isset($item['pay_desc'])?$item['pay_desc']:"";?></label>
                    <div><img src="<?php echo urldecode(Url::urlFormat("@protected/classes/$item[logo]"));?>"></div>
                    </li>
                    <?php }?>
                </ul>
            </div>
            <h2 class="f14 mt20">商品清单：</h2>
            <div class="mt15  clearfix">
                <?php if($order_type!='bundbuy'){?>
                <table width="100%" class="simple">
                  <tr>
                     <th style="width:60px;">商品</th>
                     <th>名称</th>
                     <th style="width:200px;">规格</th>
                     <th style="width:100px;">活动单价</th>
                     <th style="width:120px;">数量</th>
                     <th style="width:100px;">小计</th>
                 </tr>
                 <?php $total=0.00;$weight=0;$point=0;?>
                 <?php foreach($product as $key => $item){?>
                 <?php $total+=$item['amount'];$weight += ($item['weight']*$item['num']);$point += ($item['point']*$item['num']);?>

                 <tr id="<?php echo isset($item['id'])?$item['id']:"";?>"><td><a href="<?php echo urldecode(Url::urlFormat("/index/product/id/$item[goods_id]"));?>" target="_blank"><img  src="<?php echo Common::thumb($item['img'],100,100);?>" width="50" height="50"></a></td><td><a href="<?php echo urldecode(Url::urlFormat("/index/product/id/$item[goods_id]"));?>" target="_blank"><?php echo isset($item['name'])?$item['name']:"";?> <input name="product_id[]" type="hidden" value="<?php echo isset($item['id'])?$item['id']:"";?>"></a></td> <td><?php foreach($item['spec'] as $key => $spec){?>
                    <p title="<?php echo isset($spec['name'])?$spec['name']:"";?>:<?php echo isset($spec['value'][2])?$spec['value'][2]:"";?>"><?php echo isset($spec['name'])?$spec['name']:"";?>：<?php echo isset($spec['value'][2])?$spec['value'][2]:"";?></p>
                    <?php }?></td> <td class="tr"><?php echo isset($item['price'])?$item['price']:"";?></td> <td class="tc"><div  class="buy-num-bar buy-num clearfix"><a class="btn-dec" href="javascript:;"><i class="icon-minus-16"></i></a><input  name="buy_num[]" value="<?php echo isset($item['num'])?$item['num']:"";?>"  maxlength=5><a class="btn-add" href="javascript:;"><i class="icon-plus-16"></i></a></div></td> <td class="amount red tr"><?php echo isset($item['amount'])?$item['amount']:"";?></td>
                </tr>
                <?php }?>
            </table>
            <?php }else{?>
            <table width="100%" class="simple">
                <tr>
                    <th style="width:60px;">商品</th>
                    <th>名称</th>
                    <th style="width:200px;">规格</th>
                    <th style="width:100px;">单价</th>
                </tr>
                <?php $total=0.00;$weight=0;$point=0;?>
                <?php foreach($product as $key => $item){?>
                <?php $total+=$item['amount'];$weight += ($item['weight']*$item['num']);$point += ($item['point']*$item['num']);?>
                <tr id="<?php echo isset($item['id'])?$item['id']:"";?>"><td><a href="<?php echo urldecode(Url::urlFormat("/index/product/id/$item[goods_id]"));?>" target="_blank"><img src="<?php echo urldecode(Url::urlFormat("@$item[img]"));?>" width="50" height="50"></a></td><td><a href="<?php echo urldecode(Url::urlFormat("/index/product/id/$item[goods_id]"));?>" target="_blank"><?php echo isset($item['name'])?$item['name']:"";?></a><input name="product_id[]" type="hidden" value="<?php echo isset($item['id'])?$item['id']:"";?>"></td> <td><?php foreach($item['spec'] as $key => $spec){?>
                    <p title="<?php echo isset($spec['name'])?$spec['name']:"";?>:<?php echo isset($spec['value'][2])?$spec['value'][2]:"";?>"><?php echo isset($spec['name'])?$spec['name']:"";?>：<?php echo isset($spec['value'][2])?$spec['value'][2]:"";?></p>
                    <?php }?></td> <td class="tr"><?php echo isset($item['price'])?$item['price']:"";?></td>
                </tr>

                <?php }?>
                <tr id="<?php echo isset($pid)?$pid:"";?>"><td></td><td><a href="<?php echo urldecode(Url::urlFormat("/index/bundbuy/id/$bund[id]"));?>" target="_blank"><?php echo isset($bund['title'])?$bund['title']:"";?></a></td> <td class="tl"><div  class="buy-num-bar buy-num clearfix"><a class="btn-dec" href="javascript:;"><i class="icon-minus-16"></i></a><input  name="buy_num[]" value="<?php echo isset($item['num'])?$item['num']:"";?>"  maxlength=5><a class="btn-add" href="javascript:;"><i class="icon-plus-16"></i></a><span class="p10"> 套</span></div></td> <td class="amount red tr"><?php echo isset($bund['price'])?$bund['price']:"";?></td>
                </tr>
            </table>
            <?php $total=$bund['price'];?>
            <?php }?>
            <?php $prom = new Prom($total);$proms = $prom->meetProms();?>
            <?php $fare = new Fare($weight);?>
            <table class="mt10 simple noborder form">
                <tr><td> <p>订单备注信息：<input type="text" name="user_remark" style="width:346px;"></p> </td> <td width="260" class="tr">购物车商品合计：</td> <td width="140"><div class="mb10 mt10" style=" background: #f0f0f0;"><span class="fr"><span style=""><span class="currency-symbol f18"><?php echo isset($currency_symbol)?$currency_symbol:"";?></span><b class="cart-total red f18" id="total-amount" total="<?php echo isset($total)?$total:"";?>"><?php echo sprintf("%01.2f",$total);?> </b></span></span></div>
                </td></tr>
                <?php if($open_invoice){?>
                <tr >
            <td>
             <p style="height:32px;line-height:32px;">索要发票(<?php echo isset($tax)?$tax:"";?>%)：<input type="checkbox" name="is_invoice" id="is_invoice" value="1" data-value="<?php echo isset($tax)?$tax:"";?>">&nbsp;&nbsp;<span id="invoice" <?php if(isset($is_invoice) && $is_invoice==1){?> <?php }else{?>style="display:none;"<?php }?>>发票抬头：<select name="invoice_type"><option value="0">个人</option><option value="1">单位</option></select>&nbsp;&nbsp;<input type="text" name="invoice_title" ></span></p>
         </td>
         <td class="tr">税：</td>
         <td>
            <p class="fr">+ <b id="taxes" data-value="<?php echo isset($tax)?$tax:"";?>">0</b></p>
        </td>
    </tr>
    <?php }?>
    <tr>
        <td >
        </td>
        <td class="tr">运费：</td>
        <td>
            <p class="fr">+ <b id="fare" data-weight="<?php echo isset($weight)?$weight:"";?>"><?php echo $fare->calculate(16);?></b></p>
        </td>
    </tr>
</table>
</div>
<div class="box p15 mt5" id="voucher-n" style="display: none">
    <p class="clearfix">提示：一个订单最多能使用一张代金券（<b class="red">注：代金券仅能抵扣商品金额,多出商品的部分忽略不计</b>）。<a id="voucher-cancel" class="fr btn btn-mini ">取消优惠券</a></p>
    <table class="voucher-list mt10" >
        <tr style="background: #fff5cc;color: #000;height:20px;"><td>名称</td>
            <td>编号</td>
            <td>面值</td>
            <td>需满足金额</td>
            <td>有效期</td></tr>
            <tbody class="page-content">
                <tr>
                    <td><input name="voucher" type="radio" value="{id}" data-value="{value}"> <label>{name}</label></td>
                    <td>{account}</td>
                    <td>{value}</td>
                    <td>{money}</td>
                    <td>{end_time}</td>
                </tr>
            </tbody>
        </table>
        <div class="page-nav">ww</div>
    </div>
    <div class="mb10 mt10 clearfix" style="padding:10px; background: #f0f0f0;">
        <span class="fr f14">应付总额：<span style="font-size: 24px;font-family: tahoma"><span class="currency-symbol"><?php echo isset($currency_symbol)?$currency_symbol:"";?></span><b class="cart-total red" id="real-total"><?php echo sprintf("%01.2f",$total);?></b></span></span>
    </div>
    <div class="mt20 clearfix">
        <p class="fr"><input type="submit" class="btn btn-main fr" value="提交订单"></p>
    </div>
    <input type='hidden' name='tiny_token_order' value='<?php echo Tiny::app()->getToken("order");?>'/>
</form>
</div>
</div>

        <?php include './themes/default/apply/orderscript.php';?>
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