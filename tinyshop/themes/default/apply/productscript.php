<script type="text/javascript">
    $("#goods-consult").Paging({
        url:'<?php echo urldecode(Url::urlFormat("/index/get_ask"));?>',
        params:{id:<?php echo isset($goods['id'])?$goods['id']:"";?>}
    });
    $("#comment-all").Paging({
        url:'<?php echo urldecode(Url::urlFormat("/index/get_review"));?>',
        params:{id:<?php echo isset($goods['id'])?$goods['id']:"";?>}
    });
    $("#comment-a").Paging({
        url:'<?php echo urldecode(Url::urlFormat("/index/get_review"));?>',
        params:{id:<?php echo isset($goods['id'])?$goods['id']:"";?>,score:'a'}
    });
    $("#comment-b").Paging({
        url:'<?php echo urldecode(Url::urlFormat("/index/get_review"));?>',
        params:{id:<?php echo isset($goods['id'])?$goods['id']:"";?>,score:'b'}
    });
    $("#comment-c").Paging({
        url:'<?php echo urldecode(Url::urlFormat("/index/get_review"));?>',
        params:{id:<?php echo isset($goods['id'])?$goods['id']:"";?>,score:'c'}
    });

    $("#consult").on("click",function(){

        var content = $("#consult-content").val();
        var verifyCode = $("#verifyCode").val();
        if(!Tiny.user.online)art.dialog.alert('登录后确认才能咨询！');
        else if(content=='')art.dialog.alert("内容不能为空！");
        else if(verifyCode=='')art.dialog.alert("验证码不能为空！");
        else{
            $.post("<?php echo urldecode(Url::urlFormat("/index/goods_consult"));?>",{id:'<?php echo isset($goods['id'])?$goods['id']:"";?>',content:content,verifyCode:verifyCode},function(data){
                if(data['status']=='success'){
                    $("#goods-consult").Paging({
                        url:'<?php echo urldecode(Url::urlFormat("/index/get_ask"));?>',
                        params:{id:<?php echo isset($goods['id'])?$goods['id']:"";?>}
                    });
                    $("#consult-content").val('');
                    $("#verifyCode").val('');
                    FireEvent(document.getElementById('change-img'),"click");
                    art.dialog.tips("<p class='success'>发布成功!</p>");
                }else{
                    art.dialog.alert("<p class='fail'>"+data['msg']+"</p>");
                }
            },'json')
        }

        return false;
    })

    $("#imgmini").enlarge({
        // 鼠标遮罩层样式
        shadecolor: "#FFF",
        shadeborder: "#FF8000",
        shadeopacity: 0.5,
        cursor: "move",

        // 大图外层样式
        layerwidth: 420,
        layerheight: 420,
        layerborder: "#FFF",
        fade: true});
    var skuMap = <?php echo JSON::encode($skumap);?>;
    //更新库存信息

    var store_nums = 0;
    for(i in skuMap){
        store_nums += parseInt(skuMap[i]['store_nums']);
    }
    $("#store_nums").text(store_nums);
    $("#goods_nums").text(store_nums);

    $("#gallery  .small-img").each(function(i){
        if(i==0)$(this).addClass("current");
        $(this).on("mouseenter",function(){
            $(this).parent().find("a").removeClass("current");
            $(this).addClass("current");
            $("#imgmini img").attr("src",$(this).find("img").attr("src"));
            $("#imgmini img").attr("source",$(this).find("img").attr("source"));
        })
    });
    $(".spec-values li").each(function(){
        $(this).on("click",function(){
            var disabled = $(this).hasClass('disabled');
            if(disabled) return;
            var flage = $(this).hasClass('selected');

            $(this).parent().find("li").removeClass("selected");
            if(!flage){
                $(this).addClass("selected");
            }
            changeStatus();
            if($(".spec-values").length == $(".spec-values .selected").length){
                var sku = new Array();
                $(".spec-values .selected").each(function(i){
                    sku[i]= $(this).attr("data-value");
                })
                var sku_key = ";"+sku.join(";")+";";
                if(skuMap[sku_key]!=undefined){
                    var sku = skuMap[sku_key];
                    $("#sell_price").text(sku['sell_price']+"<?php echo isset($currency_unit)?$currency_unit:"";?>");
                    $("#store_nums").text(sku['store_nums']);
                    $("#goods_nums").text(sku['store_nums']);
                    if($("#prom_price").size()>0){
                        var formula = $("#prom_price").attr('formula');
                        var prom_price = eval(sku['sell_price']+formula);
                        if(prom_price<=0)prom_price = 0;
                        $("#prom_price").text(prom_price.toFixed(2)+" <?php echo isset($currency_unit)?$currency_unit:"";?>");
                    }

                    $("#market-price").text(sku['market_price']);
                    $("#pro-no").text(sku['pro_no']);
                }
                $("#spec-msg").css("display","none");
                specClose();
            }else{
                $("#store_nums").text("<?php echo isset($goods['store_nums'])?$goods['store_nums']:"";?>");
            }
        })
    })
    //重新计算库存计算是否库存不够
    function changeStatus(){
        var specs_array = new Array();
        $(".spec-values").each(function(i){
            var selected = $(this).find(".selected");
            if(selected.length>0)specs_array[i]=selected.attr("data-value");
            else specs_array[i] = "\\\d+:\\\d+";
        });
        $(".spec-values").each(function(i){
            var selected = $(this).find(".selected");
            $(this).find("li").removeClass("disabled");
            var k = i;
            $(this).find("li").each(function(){

                var temp = specs_array.slice();
                temp[k] = $(this).attr('data-value');
                var flage = false;
                for(sku in skuMap){
                    var reg = new RegExp(';'+temp.join(";")+';');
                    if(reg.test(sku) && skuMap[sku]['store_nums']>0) flage = true;
                }
                if(!flage)$(this).addClass("disabled");
            })

        });
    }
    $("#buy-num-bar a:eq(0)").on("click",function(){
        var num = $("#buy-num-bar input").val();
        if(num>1) num--;
        else num=1;
        $("#buy-num-bar input").val(num);
        btnNumStatus(num);
    });
    $("#buy-num-bar a:eq(1)").on("click",function(){
        var num = $("#buy-num-bar input").val();
        var max = parseInt($("#store_nums").text());
        if(num<max) num++;
        else num=max;
        $("#buy-num-bar input").val(num);
        btnNumStatus(num);
    });
    $("#buy-num-bar input").on("change",function(){
        var value = $(this).val();
        var max = parseInt($("#store_nums").text());
        if((/^\d+$/i).test(value)){
            value = Math.abs(parseInt(value));
            if(value<1) value = 1;
            if(value>max) value = max;
        }else{
            value = 1;
        }
        $(this).val(value);
        btnNumStatus(value);
    })
    function btnNumStatus(value){
        var max = parseInt($("#store_nums").text());
        if(value <= 1){
            $("#buy-num-bar a:eq(0)").addClass('disable');
        }else{
            $("#buy-num-bar a:eq(0)").removeClass('disable');
        }
        if(value >= max){
            $("#buy-num-bar a:eq(1)").addClass('disable');
        }else{
            $("#buy-num-bar a:eq(1)").removeClass('disable');
        }
    }
//立即购买
$("#buy-now").on("click",function(){
    var product = currentProduct();
    if(product){
        var id = product["id"];
        var num = parseInt($("#buy-num").val());
        var max = parseInt($("#store_nums").text());
        if(num > max){
            $("#spec-msg").css("display","");
            showMsgBar('stop',"购买商品数量，超出了允许购买的最大量！");
            return false;
        }else if(max<=0){
            $("#spec-msg").css("display","");
            showMsgBar('stop',"库存不足！");
            return false;
        }
        else{
            $("#spec-msg").css("display","none");
        }
        var url = "<?php echo urldecode(Url::urlFormat("/index/goods_add/id/__id__/num/__num__"));?>";
        url = url.replace("__id__",id);
        url = url.replace("__num__",num);
        window.location.href = url;
    }else{
        $("#spec-msg").css("display","");
        showMsgBar('alert',"请选择您要购买的商品规格！");
    }
});
    //添加到购物车
    $("#add-cart").on("click",function(){
        var product = currentProduct();
        if(product){
            var id = product["id"];
            var num = parseInt($("#buy-num").val());
            var max = parseInt($("#store_nums").text());
            var cart_num = parseInt($("#"+id).find(".num").text());
            if((num+cart_num)>max){
                $("#spec-msg").css("display","");
                showMsgBar('stop',"连同购物车里的商品数量，超出了允许购买的最大量！");
                return false;
            }else if(max<=0){
                $("#spec-msg").css("display","");
                showMsgBar('stop',"库存不足！");
                return false;
            }
            else{
                $("#spec-msg").css("display","none");
            }
            $.post("<?php echo urldecode(Url::urlFormat("/index/cart_add"));?>",{id:id,num:num},function(data){
                updateCart(data);

                var tmp=$($("#imgmini img").get(0).cloneNode(true));
                tmp.css({position: 'absolute','z-index':'9998', border:'solid 1px #ccc', background:'#aaf','overflow':'hidden' ,background:'#fff'});
                var imgView=$("#imgmini").offset();
                tmp.css(imgView);
                tmp.appendTo($('body'));
                var end = $(".shopping").offset();
                step1 = {top:end.top+160,left:end.left+30,width:100,height:100,opacity:0.8};
                step2 = {top:end.top,left:end.left+30,width:100,height:100,opacity:0};

                $(tmp).animate(step1,"slow").animate(step2, "slow",function(){
                    tmp.remove();
                });
            },"json");
        }else{
            $("#spec-msg").css("display","");
            showMsgBar('alert',"请选择您要购买的商品规格！");
        }
    });
    //关闭信息提示
    $(".spec-close").on("click",function(){
        specClose();
    });
    function specClose()
    {
        $(".spec-info").removeClass("noselected");
    }
    //取得当前商品
    function currentProduct(){
        if($(".spec-values").length==0){
            return skuMap[''];
        }
        if($(".spec-values").length == $(".spec-values .selected").not(".disabled").length){
            var sku = new Array();
            $(".spec-values .selected").each(function(i){
                sku[i]= $(this).attr("data-value");
            })
            var sku_key = ";"+sku.join(";")+";";
            if(skuMap[sku_key]!=undefined){
                return skuMap[sku_key];
            }else return null;
        }
        else return null;
    }
    //展示信息
    function showMsgBar(type,text){
        $(".spec-info").addClass("noselected");
        $(".msg").find("span").text(text);
        $(".msg").find("i").attr("class","icon icon-"+type+"-16");
    }
    //切换画廊图片
    $(".turn-right,.turn-left").on("click",function(){
        var canvas = $(".show-list >div");
        var num = canvas.find("a").size();
        var flage = -1;
        var current = 0;
        var width = 66;
        var show_num = 5;
        var left = 0;
        current = Math.round((Math.abs(canvas.position().left)/width));
        if($(this).hasClass("turn-left")){
            current--;
        }else{
            current++;
        }
        if(num-current>=show_num && current>=0){
            left = current*flage*width;
            canvas.animate({left:left},200);
        }
    })

    $("#attention").on("click",function(){
        $.post("<?php echo urldecode(Url::urlFormat("/index/attention"));?>",{goods_id:<?php echo isset($id)?$id:"";?>},function(data){
            if(data['status']==2) art.dialog.tips("<p class='warning'>已关注过了该商品！</p>");
            else if(data['status']==1) art.dialog.tips("<p class='success'>成功关注了该商品!</p>");
            else art.dialog.tips("<p class='warning'>你还没有登录！</p>");
        },'json')
    })
    //到货通知
    $("#goods-notify").on("click",function(){
        if(Tiny['user']['online']){
            art.dialog({id:'notify-dialog',content:document.getElementById('notify-dialog')});
        }else{
            art.dialog.tips("<p class='warning'>你还没有登录！</p>");
        }

    })
    function submit_notify(e)
    {
     if(e==null){
        var email = $("#n_email").val();
        var mobile = $("#n_mobile").val();
        $.post("<?php echo urldecode(Url::urlFormat("/index/notify"));?>",{goods_id:<?php echo isset($goods['id'])?$goods['id']:"";?>,email:email,mobile:mobile},function(data){
            if(data['status']!= undefined){
                art.dialog({id:'notify-dialog'}).close();
                art.dialog.tips('<p class="'+data['status']+'">'+data['msg']+'</p>');
            }
        },'json');
        return false;
    }
    return false;
}
</script>