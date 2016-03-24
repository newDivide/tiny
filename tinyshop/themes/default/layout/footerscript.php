 <script src="<?php echo urldecode(Url::urlFormat("#bootstrap/js/bootstrap.min.js"));?>"></script>
                    <script>
                       $(".slider").Slider();
                          $(".category li").mouseenter(function() {
                            $(this).addClass("hover");
                        }).mouseleave(function() {
                            $(this).removeClass("hover");
                        });                 

                        $(".category-box").mouseenter(function(){
                            $(this).addClass("on");
                        }).mouseleave(function(){
                            $(this).removeClass("on");
                        });
                        function updateCart(data){
                            var card_items = '';
                            for(var i in data){
                                var spec = data[i]['spec'];
                                var spec_str = '';
                                for(var k in spec){
                                    spec_str +="<p>"+spec[k]['value'][2]+"</p>";
                                }
                                card_items += '<div class="cart-item" id="'+i+'"><div class="pic"><img src="<?php echo urldecode(Url::urlFormat("@"));?>'+data[i]['img']+'" width="50" height="50"></div><div class="spec">'+spec_str+'</div><div class="num">'+data[i]['num']+'</div><div class="price">'+(data[i]['amount'])+'</div><a class="icon-close-16 ie6png" productid="'+data[i]['id']+'"></a></div>';
                            }
                            $("#cart-list").empty().append(card_items);
                            changeCartInfo();
                            bindDelEvent();
                        }
                        bindDelEvent();
                        function bindDelEvent(){
                            $("#shopping-cart .icon-close-16").on("click",function(){
                                var btn_close = $(this);
                                $.post("<?php echo urldecode(Url::urlFormat("/index/cart_del"));?>",{id:btn_close.attr("productid")},function(){
                                    btn_close.parent().remove();
                                    changeCartInfo();
                                    $("#card-wrap").css({top:1-$("#card-wrap").outerHeight()},"fast");
                                },"json");
                            });
                        }

                        function changeCartInfo(){
                            $(".cart-product-num").text($(".cart-item").size());
                            var total = 0.00;
                            $(".cart-item .price").each(function(){
                                total += parseFloat($(this).text());
                            });
                            $(".cart-total").text(total.toFixed(2));
                            if($(".cart-item").size()==0){
                                $("#cart-list").empty().append('<li><div>购物车中还没有商品，赶紧选购吧！</div></li>');
                            }
                        }
                    </script>