<?php if (!defined('THINK_PATH')) exit();?><header class="h5ui-bar"><a class="h5ui-bar_item pull-left" href="javascript:history.go(-1)"><i class="h5ui-bar_arrow_left"></i>        返回
    </a><a class="h5ui-bar_item pull-right" href="__APP__">        首页
    </a><h1 class="h5ui-bar_title"><?php echo ($position[0]['catname']); ?></h1></header><!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui"><meta name="apple-mobile-web-app-capable" content="yes"><meta name="apple-mobile-web-app-status-bar-style" content="black"><meta name="keywords" content="<?php echo ($keywords); ?>"><meta name="description" content="<?php echo ($description); ?>"><title><?php echo ($title); ?></title><!-- H5UI CSS --><script src="../Public/js/jquery-1.7.1.min.js"></script><script src="../Public/js/device.min.js"></script><link rel="stylesheet" href="../Public/css/h5ui.min.css"><!-- Example CSS --><link rel="stylesheet" href="../Public/css/example.min.css"><script>        if(!device.mobile()){
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
    </style></head><body ontouchstart><div class="content-show"><h3><?php echo ($data["title"]); ?></h3><span style="font-size: 12px;">发布时间：<?php echo (todate($data["create_time"],'Y-m-d')); ?></span><br><?php if(!empty($data["thumb"])): ?><img src="__ROOT__/Uploads<?php echo ($data['thumb'][0]); ?>" style="max-width: 90%"/><br><?php endif; echo ($data["content"]); ?></div><div data-role="footer" data-position="fixed"><h6>Powered by QRCMS © 2018 </h6></div>