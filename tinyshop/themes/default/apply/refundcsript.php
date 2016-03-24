<script type="text/javascript">
    $("input[name='refund_type']").on("click",function(){
    	var val = $(this).val();
    	switch(val){
    		case '0':
         $(".refund_0").addClass("hidden");
         $(".refund_1").addClass("hidden");
         $(".refund_2").addClass("hidden");
         break;
         case '2':
         $(".refund_0").removeClass("hidden");
         $(".refund_1").addClass("hidden");
         $(".refund_2").removeClass("hidden");
         break;
         case '1':
         $(".refund_0").removeClass("hidden");
         $(".refund_1").removeClass("hidden");
         $(".refund_2").removeClass("hidden");
         break;
     }
     $(".refund_radio input").css('display','');
     $(".hidden input").css('display','none');
 })
    $(".hidden input").css('display','none');
</script>