<script type="text/javascript">

    $("#address_other").on("click",function(){
        art.dialog.open('<?php echo urldecode(Url::urlFormat("/simple/address_other"));?>',{width:960,height:462,lock:true});
        return false;
    })

    $(".address-list .modify").each(function(){

        $(this).on("click",function(){
            var id = $(this).attr("data-value");
            art.dialog.open('<?php echo urldecode(Url::urlFormat("/simple/address_other/id/"));?>'+id,{width:960,height:462,lock:true});
        });
    });
</script>