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
        <?php echo JS::import("form");?>
<?php echo JS::import('dialog?skin=tinysimple');?>
<?php echo JS::import('dialogtools');?>
<link type="text/css" rel="stylesheet" href="<?php echo urldecode(Url::urlFormat("#css/simple.css"));?>" />
<?php $items=array("购物车","确认订单信息","选择支付","订购完成");?>
<div id='widget_sub_navs'><?php $widget = Widget::createWidget('sub_navs');$widget->action = "crumbs";$widget->items = $items;$widget->step = "4";$widget->current = "2";$widget->cache = "false";$widget->run();?></div>
<div class="container">
    <div class="order-info">
        <form action="<?php echo urldecode(Url::urlFormat("/simple/order_act"));?>" method="post">
            <div class="clearfix address">
                <h2><b class="fl">选择收货地址：</b><a class="btn btn-main btn-mini fr" href="<?php echo urldecode(Url::urlFormat("/ucenter/address"));?>" target="_blank">管理地址</a></h2>
                <ul class="address-list clearfix">
                    <?php $address_default=0;?>
                    <?php foreach($address as $key => $item){?>
                    <li>
                        <a href="javascript:;" data-value="<?php echo isset($item['id'])?$item['id']:"";?>" class="modify"> 修改地址 </a>
                        <div class="address-info " >
                            <input type="radio" name="address_id" value="<?php echo isset($item['id'])?$item['id']:"";?>" <?php if($item['is_default']==1){?><?php $address_default=$item['id'];?>checked="checked"<?php }?>><label><?php echo isset($parse_area[$item['province']])?$parse_area[$item['province']]:"";?> <strong><?php echo isset($parse_area[$item['city']])?$parse_area[$item['city']]:"";?></strong>（<?php echo isset($item['accept_name'])?$item['accept_name']:"";?> 收）</label>
                            <p>
                                <?php echo isset($parse_area[$item['county']])?$parse_area[$item['county']]:"";?> <?php echo isset($item['addr'])?$item['addr']:"";?> <?php echo isset($item['mobile'])?$item['mobile']:"";?>
                            </p>
                        </div>
                        <i class="icon-selected-32 ie6png"></i>
                    </li>
                    <?php }?>
                </ul>
                <div><a id="address_other" class="btn btn-main btn-mini" href="javascript:;">使用新地址</a></div>
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
             <table width="100%" class="simple">
              <tr>
               <th style="width:60px;">商品</th>
               <th>名称</th>
               <th style="width:120px;">规格</th>
               <th style="width:100px;">单价</th>
               <th style="width:120px;">数量</th>
               <th style="width:100px;">优惠</th>
               <th style="width:100px;">小计</th>
           </tr>
           <?php $total=0.00;$weight=0;$point=0;?>
           <?php foreach($cart as $key => $item){?>
           <?php $total+=$item['amount'];$weight += ($item['weight']*$item['num']);$point += ($item['point']*$item['num']);?>
           <tr id="<?php echo isset($item['id'])?$item['id']:"";?>"><td><a href="<?php echo urldecode(Url::urlFormat("/index/product/id/$item[goods_id]"));?>" target="_blank"><img src="<?php echo urldecode(Url::urlFormat("@$item[img]"));?>" width="50" height="50"></a></td><td><a href="<?php echo urldecode(Url::urlFormat("/index/product/id/$item[goods_id]"));?>" target="_blank"><?php echo isset($item['name'])?$item['name']:"";?></a></td> <td><?php foreach($item['spec'] as $key => $spec){?>
            <p title="<?php echo isset($spec['name'])?$spec['name']:"";?>:<?php echo isset($spec['value'][2])?$spec['value'][2]:"";?>"><?php echo isset($spec['name'])?$spec['name']:"";?>：<?php echo isset($spec['value'][2])?$spec['value'][2]:"";?></p>
            <?php }?></td> <td class="tr"><?php echo isset($item['price'])?$item['price']:"";?></td> <td class="tc"><div  class="buy-num-bar buy-num clearfix"><?php echo isset($item['num'])?$item['num']:"";?></div></td> <td class="prom tc"><?php echo isset($item['prom'])?$item['prom']:"";?></td> <td class="amount red tr"><?php echo isset($item['amount'])?$item['amount']:"";?></td> </tr>
            <?php }?>
        </table>
        <?php $prom = new Prom($total);$proms = $prom->meetProms();?>
        <?php $fare = new Fare($weight);?>
        <table class="mt10 simple noborder form">
            <tr><td> <p>订单备注信息：<input type="text" name="user_remark" style="width:346px;"></p> </td> <td width="260" class="tr">购物车商品合计：</td> <td width="140"><div class="mb10 mt10" style=" background: #f0f0f0;"><span class="fr"><span style=""><span class="currency-symbol f18"><?php echo isset($currency_symbol)?$currency_symbol:"";?></span><b class="cart-total red f18" id="total-amount" total="<?php echo isset($total)?$total:"";?>"><?php echo sprintf("%01.2f",$total);?> </b></span></span></div>
            </td></tr>
            <tr>
                <td >
                   <p >订单促销活动：<?php if(!empty($proms)){?><select name="prom_id" id="prom_order">
                    <?php foreach($proms as $key => $item){?>
                    <?php $parse_prom = $prom->parsePorm($item);?>
                    <option value="<?php echo isset($item['id'])?$item['id']:"";?>" data-type="<?php echo isset($item['type'])?$item['type']:"";?>" data-value="<?php echo isset($parse_prom['value'])?$parse_prom['value']:"";?>">&nbsp;&nbsp;<?php echo isset($parse_prom['note'])?$parse_prom['note']:"";?>&nbsp;&nbsp;</option>
                    <?php }?>
                </select><?php }?></p>
            </td>
            <td class="tr">

                <p class="fr">订单优惠：</p>
            </td>
            <td class="tr">- <b id="prom_order_text">0</b></td>

        </tr>
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
    <tr>
        <td >
        </td>
        <td class="tr orange">送积分：</td>
        <td>
            <p class="fr orange"><b id="point" data-point="<?php echo isset($point)?$point:"";?>"><?php echo isset($point)?$point:"";?></b></p>
        </td>
    </tr>
    <tr><td>
        <a href="javascript:;" id="voucher-btn" style="line-height: 25px;height:25px;"><i class="icon-plus "></i>使用代金券抵消部分总额：</a>
    </td><td class="tr">代金券：</td>
    <td class="tr">- <b id="voucher">0.00</b></td></tr>
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
    <div class=" clearfix mt10">
        <input name="cart_type" type="hidden" value="<?php echo isset($cart_type)?$cart_type:'';?>">
        <p class=""><input type="submit" class="btn btn-main fr" value="提交订单"></p>
    </div>
    <input type='hidden' name='tiny_token_order' value='<?php echo Tiny::app()->getToken("order");?>'/>
</form>
</div>
</div>
<script type="text/javascript">

    $("#address_other").on("click",function(){
        art.dialog.open('<?php echo urldecode(Url::urlFormat("/simple/address_other"));?>',{width:960,height:460,lock:true});
        return false;
    })
    $(".address-list .modify").each(function(){

        $(this).on("click",function(){
            var id = $(this).attr("data-value");
            art.dialog.open('<?php echo urldecode(Url::urlFormat("/simple/address_other/id/"));?>'+id,{width:960,height:460,lock:true});
            return false;
        });
    });
    $("#voucher-n").Paging({
        url:'<?php echo urldecode(Url::urlFormat("/simple/get_voucher"));?>',
        params:{amount:<?php echo isset($total)?$total:"";?>},
        callback:function(){

            calculate();
            $("#voucher-n input[name='voucher']").each(function(){
                $(this).on("click",function(){
                    calculate();
                });
            });
        }
    });
    $("#voucher-cancel").on("click",function(){
        if($("#voucher-n input[name='voucher']:checked").size()>0){
            $("#voucher-n input[name='voucher']:checked").prop("checked",false);
            calculate();
        }
    })
    $("#voucher-btn").on("click",function(){
        $("#voucher-n").toggle();
        if($("i",this).hasClass("icon-plus")){
            $("i",this).removeClass("icon-plus");
            $("i",this).addClass("icon-minus");
        }
        else{
            $("i",this).removeClass("icon-minus");
            $("i",this).addClass("icon-plus");
        }
    })

    $(".address-list li").each(function(){
        $(this).has("input[name='address_id']:checked").addClass("selected");
        $(this).on("click",function(){
            $(".address-list li").removeClass("selected");
            $("input[name='address_id']").removeProp("checked");
            $("input[name='address_id']",this).prop("checked","checked");
            $(this).addClass("selected");
            $("a.default").hide();
            $("a.default",this).show();
            var id = $("input[name='address_id']",this).val();
            var weight = $("#fare").attr("data-weight");
            $.post("<?php echo urldecode(Url::urlFormat("/ajax/calculate_fare"));?>",{weight:weight,id:id},function(data){
                if(data['status']=='success'){
                    $("#fare").text(data['fee']);
                    calculate();
                }
            },'json');
        });
    });
    FireEvent($(".address-list  input[name='address_id']:checked").get(0),"click");

    $(".payment-list li").each(function(){
        $(this).has("input[name='payment_id']:checked").addClass("selected");
        $(this).on("click",function(){
            $(".payment-list li").removeClass("selected");
            $("input[name='payment_id']").removeProp("checked");
            $("input[name='payment_id']",this).prop("checked","checked");
            $(this).addClass("selected");
        });
    });

    $("#prom_order").on("change",function(){
        calculate();
    });
    $("#is_invoice").on("click",function(){
        if(!!$(this).prop("checked")){
            $("#invoice").show();
        }
        else $("#invoice").hide();
        calculate();
    })

    //计算实付金额
    function calculate(){
        var total = parseFloat($("#total-amount").attr("total"));
        var voucher = 0;
        var fare = parseFloat($("#fare").text());
        if($("#voucher-n input[name='voucher']:checked").size()>0){
            voucher = parseFloat($("#voucher-n input[name='voucher']:checked").attr('data-value'));
            if(voucher==undefined) voucher =0;
        }
        total -= voucher;
        $("#voucher").text(voucher.toFixed(2));
        if(total<=0) total = 0;

        if($("#is_invoice").size()>0){
            if(!!$("#is_invoice").attr("checked")){
                var tax_fee = (total*<?php echo isset($tax)?$tax:"";?>/100);
                total += tax_fee;
                $("#taxes").text(tax_fee.toFixed(2));
            }
            else{
                $("#taxes").text("0.00");
            }
        }

        total += fare;
        if($("#prom_order").size()>0){
            var prom_order = $("#prom_order").find("option:selected");
            var type = prom_order.attr("data-type");
            var value = parseFloat(prom_order.attr("data-value"));
            var data_point =parseInt($("#point").attr("data-point"));

            $("#point").text(data_point);
            if(type!=4){

                if(type==2){
                    data_point = data_point*value;
                    $("#point").text(data_point);
                    $("#prom_order_text").text('0.00');
                }else{
                    total = (total-value);
                    $("#prom_order_text").text(value.toFixed(2));
                }

            }
            else {
                total = (total-value-fare);
                $("#prom_order_text").text(fare.toFixed(2));
            }
        }
        if(total<0)total = 0;
        $("#real-total").text(total.toFixed(2));
    }
    calculate();
    var form = new Form();
    form.setValue('address_id',"<?php echo isset($order_status['address_id'])?$order_status['address_id']:$address_default;?>");
    form.setValue('payment_id',"<?php echo isset($order_status['payment_id'])?$order_status['payment_id']:$payment_default;?>");
    form.setValue('user_remark',"<?php echo isset($order_status['user_remark'])?$order_status['user_remark']:"";?>");
    form.setValue('prom_id',"<?php echo isset($order_status['prom_id'])?$order_status['prom_id']:"";?>");
    <?php if(isset($is_invoice) && $is_invoice == 1){?>
    form.setValue('is_invoice',"<?php echo isset($is_invoice)?$is_invoice:"";?>");
    form.setValue('invoice_type',"<?php echo isset($invoice_type)?$invoice_type:"";?>");
    form.setValue('invoice_title',"<?php echo isset($invoice_title)?$invoice_title:"";?>");
        //FireEvent(document.getElementById('is_invoice'), 'click');
        <?php }?>
    </script>

    </div>
    <!-- E 主控区域 -->

    <!-- S 底部区域 -->
    <div id="footer">
        <div class="copyright">
            <!--S 济南泰创软件科技有限公司保留所有版权，非授权用户严禁删除版权信息；擅自删除，后果自负。-->
            <div class="container bootom">
            <div class="sub-1">
                <div class="logo"></div>
            </div>
            <div class="sub-2">
            <div><?php $item=null; $query = new Query("nav");$query->where = "type = 'bottom'";$query->order = "`sort` desc";$items = $query->find(); foreach($items as $key => $item){?>
                <a href="<?php if(strstr($item['link'],'http://')===false){?><?php echo urldecode(Url::urlFormat("$item[link]"));?><?php }else{?><?php echo isset($item['link'])?$item['link']:"";?><?php }?>" target="<?php if($item['open_type']==1){?>_blank<?php }else{?>_self<?php }?>"><?php echo isset($item['name'])?$item['name']:"";?></a>
                <?php }?></div>
            <span>Powered by <a href="http://www.tinyrise.com"><b style="color: #e74503">Tiny</b><b style="color: #999">Shop</b></a></span> © 2015 <a href="http://www.tinyrise.com">tinyrise.com</a> . 保留所有权利 。 </div>
            <div class="sub-3">
                <a target="_blank" href="#"><img src="<?php echo urldecode(Url::urlFormat("#images/v-logo-2.png"));?>" alt="诚信网站"></a>
                <a target="_blank" href="#"><img src="<?php echo urldecode(Url::urlFormat("#images/v-logo-1.png"));?>" alt="诚信网站"></a>
                <a target="_blank" href="#"><img src="<?php echo urldecode(Url::urlFormat("#images/v-logo-3.png"));?>" alt="网上交易保障中心"></a>
            </div>
            </div>
            <!--S 济南泰创软件科技有限公司保留所有版权，非授权用户严禁删除版权信息；擅自删除，后果自负。-->
        </div>
    </div>
    <!-- E 底部区域 -->
</body>
</html>

<!--Powered by TinyRise-->