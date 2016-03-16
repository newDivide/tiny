 <div class="topbar">
            <div class="layout-2 container">
                <div class="sub-1"><?php if(isset($user['name'])){?>你好:<?php echo isset($user['name'])?$user['name']:"";?> - <?php }?><?php echo isset($site_name)?$site_name:"";?>！
                </div>
                <div class="sub-2">
                    <ul class="nav-x">
                        <li class="item down">
                            <a href="">会员中心<i class="fa">&#xf107;</i></a>
                             <div class="dropdown user-box">
                                <?php $sidebar_nav = array('我的订单'=>'order', '我的关注'=>'attention',  '商品评价'=>'review',  '收货地址'=>'address');?>
                                <ul class="user-center">
                                    <?php foreach($sidebar_nav as $key => $item){?>
                                    <li class="link"><a href="<?php echo urldecode(Url::urlFormat("/ucenter/$item"));?>"><?php echo isset($key)?$key:"";?></a></li>
                                    <?php }?>
                                </ul>
                            </div>
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