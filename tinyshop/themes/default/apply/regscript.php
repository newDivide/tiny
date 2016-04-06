<script type="text/javascript">

    var dlg;
	$("#user-license").on("click",function(){
		dlg = dialog({id:'license-dialog',opacity:0.3,padding:'20px 10px 10px 20px',width:900,title:'用户注册协议',content:document.getElementById('license-content'),lock:true});
        dlg.showModal();
	});

	function closeLicense(){
		$('#readme').attr("checked",'true');
		autoValidate.showMsg({id:document.getElementById('readme'),error:false,msg:''});
		dlg.close().remove();
	}

	$("#sendSMS").click(function(){
		var data = 'mobile=' + $("#mobile").val()+'&r=' + Math.random();
		if(autoValidate.validate(document.getElementById('mobile'))===false)return;

		$.ajax({
			type: "get",
			url: "<?php echo urldecode(Url::urlFormat("/ajax/send_sms"));?>",
            data: data,
            dataType:'json',
            success:function(result){
            	if(result['status']=='success'){
            		$('#mobile').attr("readonly","readonly");
            		var send_sms = $("#sendSMS");
            		send_sms.attr("disabled",true);
            		send_sms.addClass("btn-disable");
            		var i = 120;
                    send_sms.val(i + '秒后重新获取');
                    var timer = setInterval(function () {
                        i--;
                        send_sms.val(i + '秒后重新获取');
                        if (i <= 0) {
                            clearInterval(timer);
                            send_sms.val('获取短信验证码');
                            $('#mobile').removeAttr("readonly");
                            send_sms.removeClass("btn-disable");
                            send_sms.attr("disabled",false);
                        }
                    }, 1000);
            	}else{
            		art.dialog.tips("<p class='fail'>"+result['msg']+"</p>");
            	}
            }
        });
	});

	$("input[name='email']").on("change",function(event){
		if(autoValidate.validate(event)){
			$.post("<?php echo urldecode(Url::urlFormat("/ajax/email/email/"));?>"+$(this).val(),function(data){
			autoValidate.showMsg({id:document.getElementById('email'),error:!data['status'],msg:data['msg']});
		},'json');
		}
	});

    $("input[name='mobile']").on("change",function(event){
        if(autoValidate.validate(event)){
            $.post("<?php echo urldecode(Url::urlFormat("/ajax/mobile/mobile/"));?>"+$(this).val(),function(data){
            autoValidate.showMsg({id:document.getElementById('mobile'),error:!data['status'],msg:data['msg']});
        },'json');
        }
    });

	$("input[name='verifyCode']").on("change",function(){
		$.post("<?php echo urldecode(Url::urlFormat("/ajax/verifyCode/verifyCode/"));?>"+$(this).val(),function(data){
			autoValidate.showMsg({id:document.getElementById('verifyCode'),error:!data['status'],msg:data['msg']});
		},'json');
	})
	$("#readme").on("change",function(){
		if($("#readme:checked").length>0)autoValidate.showMsg({id:document.getElementById('readme'),error:false,msg:''});
		else autoValidate.showMsg({id:document.getElementById('readme'),error:true,msg:'同意后才可注册'});
	});
	function checkReadme(e){
		if(e) return false;
		else{
			if($("#readme:checked").length>0)return true;
			{
				autoValidate.showMsg({id:document.getElementById('readme'),error:true,msg:'同意后才可注册'});
				return false;
			}
		}
	}
	<?php if(isset($invalid)){?>
		var form = new Form();
		form.setValue('email', '<?php echo isset($email)?$email:"";?>');
		autoValidate.showMsg({id:$("input[name='<?php echo isset($invalid['field'])?$invalid['field']:"";?>']").get(0),error:true,msg:"<?php echo isset($invalid['msg'])?$invalid['msg']:"";?>"});
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
                if(current_input.attr('id')=='email'){
                    $.post("<?php echo urldecode(Url::urlFormat("/ajax/email/email/"));?>"+$(this).val(),function(data){
                        var msg = '合法用户';
                        if(!data['status']){
                            msg = '用户已存在';
                            current_input.next().show();
                            current_input.parent().removeClass('valid').addClass('invalid');
                        }else{
                            current_input.parent().removeClass('invalid').addClass('valid');
                        }
                        autoValidate.showMsg({id:document.getElementById('email'),error:!data['status'],msg:msg});
                    },'json');
                }if(current_input.attr('id')=='mobile'){
                    $.post("<?php echo urldecode(Url::urlFormat("/ajax/mobile/mobile/"));?>"+$(this).val(),function(data){
                        var msg = '合法用户';
                        if(!data['status']){
                            msg = '用户已存在';
                            current_input.next().show();
                            current_input.parent().removeClass('valid').addClass('invalid');
                        }else{
                            current_input.parent().removeClass('invalid').addClass('valid');
                        }
                        autoValidate.showMsg({id:document.getElementById('mobile'),error:!data['status'],msg:msg});
                    },'json');
                }else if(current_input.attr('id')=='verifyCode'){
                    $.post("<?php echo urldecode(Url::urlFormat("/ajax/verifyCode/verifyCode/"));?>"+$(this).val(),function(data){
                        autoValidate.showMsg({id:document.getElementById('verifyCode'),error:!data['status'],msg:data['msg']});
                        if(!data['status']) current_input.next().show();
                    },'json');
                }
                $(".invalid-msg").show();
            }else{
                current_input.next().show();
            }
        });
</script>