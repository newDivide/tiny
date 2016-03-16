<div class="helps clearfix container">
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
                                <span>Powered by<b style="color: #e74503">Tiny</b><b style="color: #999">Shop</b></span> © 2015保留所有权利 。 </div>
                            </div>
                            <!--S 济南泰创软件科技有限公司保留所有版权，非授权用户严禁删除版权信息；擅自删除，后果自负。-->
                        </div>