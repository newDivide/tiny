<script type="text/javascript">
    $("#voucher-btn").on("click",function(){
        $("#payment-list").toggle();
        if($("i",this).hasClass("icon-plus-1-16")){
            $("i",this).removeClass("icon-plus-1-16");
            $("i",this).addClass("icon-minus-1-16");
        }
        else{
            $("i",this).removeClass("icon-minus-1-16");
            $("i",this).addClass("icon-plus-1-16");
        }
    });
    $("#payment-list input[type='radio']").each(function(){
        if(!!$(this).attr("checked")) $("#pay_name").text($(this).attr("data-name"));
        $(this).on("click",function(){
            $("#pay_name").text($(this).attr("data-name"));

        })
    });

    $(".payment-list li").each(function(){
        $(this).has("input[name='payment_id']:checked").addClass("selected");
        $(this).on("click",function(){
            $(".payment-list li").removeClass("selected");
            $("input[name='payment_id']").removeProp("checked");
            var current_input = $("input[name='payment_id']",this);
            current_input.prop("checked","checked");
            current_input.trigger('change');
            $("#pay_name").text(current_input.attr("data-name"));
            $(this).addClass("selected");
        });
    });

    $(".payment-note").on("mouseenter",function(){
        if($(this).attr('note')!='')art.dialog({id:'payment-note',cancel:false,follow:this,content:$(this).attr('note')});
    })
    $(".payment-note").on("mouseleave ",function(){
        art.dialog({id:'payment-note'}).close();
    })
</script>