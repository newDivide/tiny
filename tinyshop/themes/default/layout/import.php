    <link rel="shortcut icon" href="<?php echo urldecode(Url::urlFormat("@favicon.ico"));?>"/>
    <link rel="bookmark" href="<?php echo urldecode(Url::urlFormat("@favicon.ico"));?>" />
    <link href="<?php echo urldecode(Url::urlFormat("#bootstrap/css/bootstrap.min.css"));?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo urldecode(Url::urlFormat("#css/common.css"));?>">
    <link rel="stylesheet" type="text/css" href="<?php echo urldecode(Url::urlFormat("#css/font-awesome.min.css"));?>">
    <link rel="stylesheet" type="text/css" href="<?php echo urldecode(Url::urlFormat("#js/artdialog/tiny-dialog.css"));?>">
    <style type="text/css">
        .swiper-container {width: 100%;}
        .js-template{display:none !important;}
    </style>
    <script src="<?php echo urldecode(Url::urlFormat("#js/jquery.min.js"));?>"></script>
    <script src="<?php echo urldecode(Url::urlFormat("#js/artdialog/dialog-plus-min.js"));?>"></script>
    <script src="<?php echo urldecode(Url::urlFormat("#js/common.js"));?>"></script>
    <script src="<?php echo urldecode(Url::urlFormat("#js/tinyslider.js"));?>"></script>
    <script type="text/javascript">
        var server_url = '<?php echo urldecode(Url::urlFormat("@"));?>__con__/__act__';
        var Tiny = {user:{name:'<?php echo isset($user['name'])?$user['name']:'';?>',id:'<?php echo isset($user['id'])?$user['id']:0;?>',online:<?php echo isset($user['id']) && $user['id']?'true':'false';?>}};
    </script>
    <title><?php if(isset($seo_title) && isset($site_title) && ($seo_title == $site_title)){?><?php echo isset($seo_title)?$seo_title:"";?><?php }else{?><?php echo isset($seo_title)?$seo_title:"";?>-<?php echo isset($site_title)?$site_title:"";?><?php }?></title>