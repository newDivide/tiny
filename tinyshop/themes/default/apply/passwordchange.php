<script type="text/javascript">
    var form =  new Form('info-form');
    form.setValue('is_default','<?php echo isset($is_default)?$is_default:"";?>');
    $("#areas").Linkage({ url:"<?php echo urldecode(Url::urlFormat("/ajax/area_data"));?>",selected:[<?php echo isset($province)?$province:0;?>,<?php echo isset($city)?$city:0;?>,<?php echo isset($county)?$county:0;?>],callback:function(data){
        var text = new Array();
        var value = new Array();
        for(i in data[0]){
          if(data[0][i]!=0){
            text.push(data[1][i]);
            value.push(data[0][i]);
        }
    }
    $("#test").val(value.join(','));
    FireEvent(document.getElementById("test"),"change");
}});
    <?php if(isset($invalid)){?>
    autoValidate.showMsg({id:$("input[name='<?php echo isset($invalid['name'])?$invalid['name']:"";?>']").get(0),error:true,msg:'<?php echo isset($invalid['msg'])?$invalid['msg']:"";?>'});
    <?php }?>
</script>