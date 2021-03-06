<style type="text/css">
    .ABC, .BJBANK, .BJRCB, .BOC, .CCB, .CDCB, .CEB, .CIB, .CITIC, .CMB, .CMBC, .COMM, .CSRCB, .FDB, .GDB, .HZCB, .ICBC, .NBBANK, .NJCB, .PSBC, .SHBANK, .SHRCB, .SPABANK, .SPDB, .WZCB, .ZJNX{text-indent: -9999px; background-image: url(<?php echo urldecode(Url::urlFormat("@protected/widgets/pay_bank/combo.png"));?>); }
    .ICBC {background-position: 0px -576px; }
    .CCB {background-position: 0px -144px; }
    .ABC {background-position: 0px -0px; }
    .PSBC {background-position: 0px -684px; }
    .COMM {background-position: 0px -396px; }
    .CMB {background-position: 0px -324px; }
    .BOC {background-position: 0px -108px; }
    .CEB {background-position: 0px -216px; }
    .CITIC {background-position: 0px -288px; }
    .SPDB {background-position: 0px -828px; }
    .CMBC {background-position: 0px -360px; }
    .CIB {background-position: 0px -252px; }
    .SPABANK {background-position: 0px -792px; }
    .GDB {background-position: 0px -504px; }
    .SHRCB {background-position: 0px -756px; }
    .SHBANK {background-position: 0px -720px; }
    .NBBANK {background-position: 0px -612px; }
    .HZCB {background-position: 0px -540px; }
    .BJBANK {background-position: 0px -36px; }
    .BJRCB {background-position: 0px -72px; }
    .FDB {background-position: 0px -468px; }
    .WZCB {background-position: 0px -864px; }
    .ZJNX {background-position: 0px -900px; }
    .CDCB {background-position: 0px -180px; }
    .CSRCB {background-position: 0px -432px; }
    .NJCB {background-position: 0px -648px; }

    .banks{display: block;clear: both;list-style: none;}
    .banks li{display: inline; width: 218px; float: left; height: 38px;line-height: 38px; position: relative; margin-bottom: 25px;margin-right: 15px;}
    .bank-item input{width: 20px;vertical-align: middle;}
    .bank-item input[checked='checked']:after{border:#ff0 1px solid;}
    .bank-item label{display: block;position: relative;left: 30px;top:-36px;border:#ccc 1px solid;width: 178px;}
    .bank-item label:hover,.banks .current label {border-color: #fa3!important; }
    .bank-item label span{ display: block; text-indent: -9999px;}
    .bank-icon {width: 126px;height: 36px;vertical-align: middle;}
    #widget_pay_bank{margin:20px auto;padding:28px;background: #FFF; border: #ddd 1px solid; position: relative; overflow: hidden; word-break: break-all;display: none;}
</style>
<div id="banks-list">
    <ul class="banks">
    <?php $banks = array('ICBC','CCB','ABC','PSBC','COMM','CMB','BOC','CEB','SPDB','CMBC','CIB','SPABANK','GDB','SHRCB','SHBANK','NBBANK','HZCB','BJBANK','BJRCB','FDB','WZCB');?>
    <?php foreach($banks as $key => $item){?>
        <li class="bank-item">
            <input type="radio"  id="bank-<?php echo isset($item)?$item:"";?>" value="<?php echo isset($item)?$item:"";?>" <?php if($key==0){?>checked="checked"<?php }?> name="channelBank">
            <label for="bank-<?php echo isset($item)?$item:"";?>">
                <span class="bank-icon <?php echo isset($item)?$item:"";?>"></span>
            </label>
        </li>
    <?php }?>
    </ul>
    <div >小提示：网站银行直连接口是与支付宝合作的，故具体银行的的页面上显示的商城名称为"支付宝公司"，请大家放心使用！</div>
</div>
<script>
$("input[name=payment_id]").change(function(){
    var payment_class = $(this).attr('id');
    if(payment_class == 'alipaygateway') $("#widget_pay_bank").show();
    else $("#widget_pay_bank").hide();
});
$("input[name=channelBank]").change(function(){
    $(".bank-item").removeClass('current');
    $(this).parent().addClass('current');
});
if($("input[name=payment_id]:checked").attr('id')=='alipaygateway')$("#widget_pay_bank").show();
</script>