<script>
    var attr_extra = '';
    $(".attr").each(function(i){
        var self = $(this);
        if(i>3){
            //self.css("display","none");
           // attr_extra += self.find(".attr-key:eq(0)").text()+"、";
       }
       if(self.find(".attr-value").get(0).scrollHeight>self.height()){
        var span = $("<div class='o-more'>更多<b></b></div>");
        self.append(span);
        if(self.find('.select').size()>0){
            span.html('收起<b></b>');
            span.parent().addClass("unflod");
        }
        span.on("click",function(){
            if($(this).text()=='更多'){
                $(this).html('收起<b></b>');
                $(this).parent().addClass("unflod");
            }
            else {
                $(this).html('更多<b></b>');
                $(this).parent().removeClass("unflod");
            }
        });
    }
});

    attr_extra = $(".attr:gt(3) .attr-key").text();
    attr_extra = attr_extra.replace(/：/gi,'、');
    attr_extra = attr_extra.replace(/、$/gi,'');
    if($(".attr:gt(3)").size()>0){

        if($(".attr:gt(3)").find(".select").size()>0){
            $(".attr:gt(3)").css("display","block");
            $(".attr-extra div:eq(0)").html('收起<b></b>');
            $(".attr-extra").addClass("unflod");
        }else{
            $(".attr:gt(3)").css("display","none");
            $(".attr-extra div:eq(0)").html('更多选项（'+attr_extra+'）<b></b>');
            $(".attr-extra").removeClass("unflod");
        }
    }else{
        $("#select-more").css("display","none");
    }
    $(".attr-extra:eq(0)").on("click",function(){
        if($(".attr:hidden").size()>0){
            $(".attr:gt(3)").css("display","block");
            $(".attr-extra div:eq(0)").html('收起<b></b>');
            $(".attr-extra").addClass("unflod");
        }else{
            $(".attr:gt(3)").css("display","none");
            $(".attr-extra div:eq(0)").html('更多选项（'+attr_extra+'）<b></b>');
            $(".attr-extra").removeClass("unflod");
        }

    })
    $(".attention").on("click",function(){
        var id = $(this).attr("val");
        $.post("<?php echo urldecode(Url::urlFormat("/index/attention"));?>",{goods_id:id},function(data){
            if(data['status']==2) art.dialog.tips("<p class='warning'>已关注过了该商品！</p>");
            else if(data['status']==1) art.dialog.tips("<p class='success'>成功关注了该商品!</p>");
            else art.dialog.tips("<p class='warning'>你还没有登录！</p>");
        },'json')
    })

</script>