         <div class="topbar">
            <div class="layout-2 container">
                <div class="sub-2">
                    <ul class="nav-x">
                        <li class="item down">
                            <a href="<?php echo urldecode(Url::urlFormat("/ucenter"));?>"><?php if(isset($user['name'])){?><?php echo isset($user['name'])?$user['name']:"";?>  <?php }?></a>
                        </li>
                        <li class="item split"></li>
                        <?php if($user){?>
                        <li class="item"><a href="<?php echo urldecode(Url::urlFormat("/simple/logout"));?>">安全退出</a></li>
                        <?php }else{?>
                        <li class="item"><a class="normal" href="<?php echo urldecode(Url::urlFormat("/simple/login"));?>">登录</a>/<a class="normal" href="<?php echo urldecode(Url::urlFormat("/simple/reg"));?>">注册</a></li>
                        <?php }?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container head-main">
            <div class="sub-1 logo"></div>
            <div class="sub-2">
                <form id="search-form" class="search-form" action="<?php echo urldecode(Url::urlFormat("/"));?>" method="get">
                    <input type="hidden" name="con" value="index">
                    <input type="hidden" name="act" value="search">
                    <input type='hidden' name='tiny_token_' value='<?php echo Tiny::app()->getToken("");?>'/>
                    <input  class="search-keyword" id="search-keyword" class="txt-keyword" name="keyword" value="<?php echo isset($keyword)?$keyword:"";?>" type="text">
                    <button class="btn-search ">搜索</button>
                </form>
            </div>
            <div class="sub-3">
                <div class="shopping" id="shopping-cart"><i class="icon-cart-32"></i>购物车
                    <div class="dropdown">
                        <ul class="cart-box " id="cart-list">
                            <?php $total=0.00;?><?php if($cart){?><?php foreach($cart as $key => $item){?> <?php $total += $item['amount'];?>
                            <li class="cart-item" id="<?php echo isset($item['id'])?$item['id']:"";?>">
                                <div class="pic">
                                    <a class="card-pic" href="<?php echo urldecode(Url::urlFormat("/index/product/id/$item[goods_id]"));?>" target="_blank" title="<?php echo isset($item['name'])?$item['name']:"";?>"><img src="<?php echo urldecode(Url::urlFormat("@$item[img]"));?>" width="50" height="50"></a>
                                </div>
                                <div class="spec">
                                    <?php foreach($item['spec'] as $key => $spec){?>
                                    <p title="<?php echo isset($spec['name'])?$spec['name']:"";?>:<?php echo isset($spec['value'][2])?$spec['value'][2]:"";?>"><?php echo isset($spec['value'][2])?$spec['value'][2]:"";?></p>
                                    <?php }?>
                                </div>
                                <div class="num"><?php echo isset($item['num'])?$item['num']:"";?></div>
                                <div class="price" title="<?php echo isset($item['amount'])?$item['amount']:"";?>"><?php echo isset($item['amount'])?$item['amount']:"";?></div>
                                <a class="icon-close-16 ie6png" productid="<?php echo isset($item['id'])?$item['id']:"";?>"></a>
                            </li>
                            <?php }?>
                            <?php }else{?>
                            <li><div>购物车中还没有商品，赶紧选购吧！</div></li>
                            <?php }?>

                        </ul>
                        <div class="cart-count">
                            <span>合计：</span><span class="cart-total"><?php echo isset($total)?$total:"";?></span>
                            <a href="<?php echo urldecode(Url::urlFormat("/simple/cart"));?>" class="btn btn-main">去购物车结算</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- S 导航栏 -->
        <div class="collapse navbar-collapse nav" id="bs-example-navbar-collapse-1">
            <ul class="navbar-nav container"> 
                <li class="dropdown category-box">
                    <div class="link">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">全部商品分类<span class="caret"></span></a>
                    </div>
                    <ul class="dropdown-menu category">
                        <?php $current_category_ids='';$parent_category='';?>
                        <?php foreach($category as $key => $categ){?>
                        <li><a href="<?php echo urldecode(Url::urlFormat("/index/category/cid/$categ[id]"));?>">
                            <?php if(isset($categ['id'])){?>
                            <?php $current_category_ids=$categ['id'].',';$parent_category=$categ['id'];?>
                            <?php }?> <?php echo isset($categ['title'])?$categ['title']:"";?><i class="fa">&#xf105;</i></a>
                            <div class="category-sub">
                                <ul class="sub">
                                    <?php foreach($categ['child'] as $key => $child){?>
                                    <li>
                                        <h5><a href="<?php echo urldecode(Url::urlFormat("/index/category/cid/$child[id]"));?>">
                                            <?php if(isset($child['id'])){?>
                                            <?php $current_category_ids.=$child['id'].',';?>
                                            <?php }?>
                                            <?php echo isset($child['title'])?$child['title']:"";?></a></h5>
                                            <p>
                                                <?php if(isset($child['child'])){?>
                                                <?php foreach($child['child'] as $key => $grandson){?>
                                                <a href="<?php echo urldecode(Url::urlFormat("/index/category/cid/$grandson[id]"));?>">
                                                    <?php if(isset($grandson['id'])){?>
                                                    <?php $current_category_ids.=$grandson['id'].',';?><?php }?>
                                                    <?php echo isset($grandson['title'])?$grandson['title']:"";?></a>
                                                    <?php }?>
                                                    <?php }?>
                                                </p>
                                            </li>
                                            <?php }?>
                                        </ul>
                                    </div>
                                </li>
                                <?php }?>
                            </ul>
                        </li>
                        <li class="link"><a href="<?php echo urldecode(Url::urlFormat("/index/index"));?>">首页</a></li>
                        <?php $item=null; $query = new Query("nav");$query->where = "type = 'main' and enable = 1";$query->order = "`sort` desc";$items = $query->find(); foreach($items as $key => $item){?>
                        <li class="link"><a href="<?php if(strstr($item['link'],'http://')===false){?><?php echo urldecode(Url::urlFormat("$item[link]"));?><?php }else{?><?php echo isset($item['link'])?$item['link']:"";?><?php }?>" target="<?php if($item['open_type']==1){?>_blank<?php }else{?>_self<?php }?>"><?php echo isset($item['name'])?$item['name']:"";?></a></li>
                        <?php }?>
                    </ul>
        </div><!-- /.navbar-collapse -->        