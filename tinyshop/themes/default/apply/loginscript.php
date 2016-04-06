<script type="text/javascript">
    <?php if(isset($invalid)){?>
    var form = new Form();
    form.setValue('account', '<?php echo isset($account)?$account:"";?>');
    autoValidate.showMsg({id:$("input[name='<?php echo isset($invalid['field'])?$invalid['field']:"";?>']").get(0),error:true,msg:"<?php echo isset($invalid['msg'])?$invalid['msg']:"";?>"});
    $(".invalid-msg").show();
    <?php }?>
    $("input[pattern]").on("blur",function(event){
        $(".invalid-msg , .valid-msg").hide();
        var current_input = $(this);
        var result = autoValidate.validate(event);
        if(result){
            current_input.parent().removeClass('invalid').addClass('valid');
        }else{
            current_input.parent().removeClass('valid').addClass('invalid');
        }
        if(result){
            if(current_input.attr('id')=='account'){
                $.post("<?php echo urldecode(Url::urlFormat("/ajax/account/account/"));?>"+$(this).val(),function(data){
                    var msg = '合法用户';
                    if(data['status']){
                        msg = '用户不存在';
                        current_input.next().show();
                        current_input.parent().removeClass('valid').addClass('invalid');
                    }
                    autoValidate.showMsg({id:document.getElementById('account'),error:data['status'],msg:msg});
                },'json');
            }
            $(".invalid-msg").show();
        }else{
            current_input.next().show();
        }
    });
</script>