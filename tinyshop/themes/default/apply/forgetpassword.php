<script type="text/javascript">

	$("input[pattern]").on("blur",function(event){
		var current_input = $(this);
		var result = autoValidate.validate(event);
		if(result){
			current_input.parent().removeClass('invalid').addClass('valid');
		}else{
			current_input.parent().removeClass('valid').addClass('invalid');
		}
	});
	$("input[name='account']").on("blur",function(event){
		var current_input = $(this);
		if(autoValidate.validate(event)){
			$.post("<?php echo urldecode(Url::urlFormat("/ajax/account/account/"));?>"+$(this).val(),function(data){
				var msg = '此账户不存在!';
				if(!data['status']){
					msg = '账户合法!';
					current_input.next().show();
					current_input.parent().removeClass('invalid').addClass('valid');
				}else{
					current_input.parent().removeClass('valid').addClass('invalid');
				}
				autoValidate.showMsg({id:document.getElementById('account'),error:data['status'],msg:msg});
			},'json');
		}
	});
	$("input[name='verifyCode']").on("blur",function(){
		var current_input = $(this);
		$.post("<?php echo urldecode(Url::urlFormat("/ajax/verifyCode/verifyCode/"));?>"+$(this).val(),function(data){
			if(data['status']){
				current_input.parent().removeClass('invalid').addClass('valid');
			}else{
				current_input.parent().removeClass('valid').addClass('invalid');
			}
			autoValidate.showMsg({id:document.getElementById('verifyCode'),error:!data['status'],msg:data['msg']});
		},'json');
	})
	<?php if(isset($invalid)){?>
	var form = new Form();
	form.setValue('account', '<?php echo isset($account)?$account:"";?>');
	autoValidate.showMsg({id:$("input[name='<?php echo isset($invalid['field'])?$invalid['field']:"";?>']").get(0),error:true,msg:"<?php echo isset($invalid['msg'])?$invalid['msg']:"";?>"});
	<?php }?>

</script>