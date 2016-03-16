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
        <?php echo JS::import('dialog?skin=tinysimple');?>
<?php echo JS::import('dialogtools');?>
<?php $config = Config::getInstance(); $other = $config->get('other'); $reg_way = isset($other['other_reg_way'])?$other['other_reg_way']:0;$reg_way = explode(',',$reg_way);$reg_way = array_flip($reg_way);?>
<div class="magic-bg right" >
    <div class="simple-box "  style="width:480px;height:540px;left:100px">
        <div class="title">
        <div class="sub-1"><h1>用户注册</h1></div><div class="sub-2"><a href="<?php echo urldecode(Url::urlFormat("/simple/login"));?>">会员登录</a></div>
        </div>
        <form action="<?php echo urldecode(Url::urlFormat("/simple/reg_act"));?>" class="reg-box" method="post" callback="checkReadme">

            <input type="hidden" name="redirectURL" value="<?php echo isset($redirectURL)?$redirectURL:$this->perPage();?>">
            <ul class="form  ">
                <?php if(isset($reg_way[0])){?>
                <li><span class="perfix fa">&#xf007;</span><input name="email" id="email"  class="input" pattern="email" placeholder="邮箱(例如:demo@tinyx.com)" alt="邮箱格式不正确!"></li>
                <?php }?>
                <?php if(isset($reg_way[1])){?>
                <?php if(class_exists('SMS')){?>
                <li>
                    <span class="perfix fa">&#xf095;</span><input type="text" id="mobile" class="input" name="mobile" pattern="mobi" value="<?php echo isset($mobile)?$mobile:"";?>" alt="正确的手机号码">
                </li>
                <?php }else{?>
                <li>
                    非对应授权版本无法使用手机注册用户功能！
                </li>
                <?php }?>
                <?php }?>
                <li><span class="perfix fa">&#xf023;</span><input bind="repassword" minlen=6 maxlen=20 class="input" type="password" name="password" pattern="required" placeholder="密码" alt="6-20任意字符组合"></li>
                <li><span class="perfix fa">&#xf084;</span><input bind="password" minlen=6 maxlen=20 class="input" type="password"  name="repassword" pattern="required" placeholder="确认密码" alt="6-20任意字符组合"></li>

                <?php if(isset($reg_way[1]) && class_exists('SMS') && SMS::getInstance()->getStatus()){?>
                <li>
                    <span class="perfix fa">&#xf02a;</span><input type="text" class="input-sm" name="mobile_code" pattern="\d{6}" alt="6位短信验证码"><label></label><input id="sendSMS" type="button" class="btn btn-default" value="获取短信验证码"></dd>
                </li>
                <?php }else{?>
                <li>
                    <span class="perfix fa">&#xf02a;</span><input type="text" class="input-sm" name="verifyCode" id="verifyCode"  pattern="\w{4}" maxlength="4" style="width: 80px;" alt="验证码不正确"><img id="captcha_img"  src="<?php echo urldecode(Url::urlFormat("/simple/captcha/h/40/w/120/bc/f1f1f1"));?>"><label><a href="javascript:void(0)" class="red" onclick="document.getElementById('captcha_img').src='<?php echo urldecode(Url::urlFormat("/simple/captcha/h/40/w/120/bc/f1f1f1/random/"));?>'+Math.random()">换一张</a></label>
                </li>
                <?php }?>
                <li>
                <dt>&nbsp;</dt><dd><input id="readme" type="checkbox" alt="同意后才可注册"><label></label><label>我已阅读并同意《<a class="" id="user-license" href="javascript:;"><?php echo isset($site_title)?$site_title:"";?>用户注册协议</a>》</label></dd>
            </li>
            <li><button class="btn btn-main " style="padding:10px 40px; width:100%">同意协议，立即注册</button></li>
            <input type='hidden' name='tiny_token_reg' value='<?php echo Tiny::app()->getToken("reg");?>'/>
            </ul>

    </form>
</div>
</div>
<div id="license-content" style="display:none;">
    <div style="height:400px;overflow:auto">
    <?php $item=null; $query = new Query("help");$query->where = "id = 14";$items = $query->find(); foreach($items as $key => $item){?>
    <?php echo isset($item['content'])?$item['content']:"";?>
    <?php }?>
    </div>
    <div class="mt10 tc"><a href="javascript:closeLicense();" class="btn btn-main">同意用户注册协议</a></div>
</div>

<?php echo JS::import('form');?>
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