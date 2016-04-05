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
    //代金券啦 砍掉了
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