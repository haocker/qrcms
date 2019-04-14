<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui"><meta name="apple-mobile-web-app-capable" content="yes"><meta name="apple-mobile-web-app-status-bar-style" content="black"><meta name="keywords" content="<?php echo ($keywords); ?>"><meta name="description" content="<?php echo ($description); ?>"><title><?php echo ($title); ?></title><!-- H5UI CSS --><script src="../Public/js/jquery-1.7.1.min.js"></script><script src="../Public/js/device.min.js"></script><link rel="stylesheet" href="../Public/css/h5ui.min.css"><!-- Example CSS --><link rel="stylesheet" href="../Public/css/example.min.css"><script>        if(!device.mobile()){
            location.href='/'
        }
    </script><style>        .content-index{
            position: fixed;
            top:50px;
            bottom:50px;
            left: 0px;
            right: 0px;
            overflow: auto;
        }
        .content-member{
            position: fixed;
            top:50px;
            bottom:0px;
            left: 0px;
            right: 0px;
            overflow: auto;
        }
        .content-show{
            position: fixed;
            top:50px;
            bottom:0px;
            left: 0px;
            right: 0px;
            overflow-y: auto;
            overflow-x: hidden;
            background: #ffffff;
            padding:0px 24px ;
        }
        .content-show img{
            max-width: 90%;
        }
    </style></head><body ontouchstart><div class="h5ui-msg h5ui-msg_error" id="msgpage-error" style=""><div class="h5ui-msg_content"><i class="h5ui-msg_icon"></i><h4><?php echo ($error); ?></h4><?php if(isset($jumpUrl)): ?><p>系统将在<span style="color:#424242;font-weight:bold"><?php echo ($waitSecond); ?></span>秒后自动跳转，如果不想等待，直接点击<a href="<?php echo ($jumpUrl); ?>">这里</a></p><script language="javascript">                setTimeout("location.href='<?php echo ($jumpUrl); ?>';",<?php echo ($waitSecond); ?>*1000);
            </script><?php endif; ?></div></div></body></html>