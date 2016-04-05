  <script type="text/javascript">
   $(".btn-dec").on("click",function(){
    var parent = $(this).parent().parent();
    var id = parent.parent().attr("id");
    var num = parent.find("input").val();
    if(num>1) num--;
    else num=1;
    if($("#"+id).find("input").val()!=num) changeInfo(id,num);
    parent.find("input").val(num);
  });
   $(".btn-add").on("click",function(){
     var parent = $(this).parent().parent();
     var id = parent.parent().attr("id");
     var num = parent.find("input").val();
     num++;
     if($("#"+id).find("input").val()!=num) changeInfo(id,num);
     parent.find("input").val(num);
   });

   $(".buy-num-bar input").on("change",function(){
    var num = parseInt($(this).val());
    var parent = $(this).parent().parent();
    var id = parent.parent().attr("id");
    changeInfo(id,num);
  })
   $(".icon-close-16").on("click",function(){
     var parent = $(this).parent();
     var id = $(this).parent().parent().attr("id");
     $.post("<?php echo urldecode(Url::urlFormat("/index/cart_del/cart_type/$cart_type"));?>",{id:id},function(data){
      if(data['status']=='success')location.reload();
    },'json');
   })

   function changeInfo(id,num){
     $.post("<?php echo urldecode(Url::urlFormat("/index/cart_num/cart_type/$cart_type"));?>",{id:id,num:num},function(data){
      var total = 0.00;
      for(var i in data) total += parseFloat(data[i]['amount']);
        $("#"+id).find(".amount").text(data[id]['amount']);
      $("#"+id).find(".prom").text(data[id]['prom']);
      if(parseInt($("#"+id).find("input").val())>data[id]['store_nums']){
        $("#"+id).find("input").val(data[id]['store_nums']);
        var parent = $("#"+id).find("input").parent().parent();
        if(parent.find(".msg-simple-error").size()==0)parent.append("<div class='msg-simple-error'>最多购买"+data[id]['store_nums']+"件</div>");
      }else{
        $("#"+id).find("input").val(data[id]['num']);
        $("#"+id).find("input").parent().parent().find(".msg-simple-error").remove();
      }
      $(".cart-total").text(total.toFixed(2));
    },"json");
   }
 </script>