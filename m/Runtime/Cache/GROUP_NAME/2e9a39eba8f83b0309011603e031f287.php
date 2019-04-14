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
    </style></head><body ontouchstart><header class="h5ui-bar"><a class="h5ui-bar_item pull-left" href="javascript:history.go(-1)"><i class="h5ui-bar_arrow_left"></i>        返回
    </a><a class="h5ui-bar_item pull-right" href="__APP__">        首页
    </a><h1 class="h5ui-bar_title"><?php echo ($position[0]['catname']); ?></h1></header><div class="content-show"><div style="padding-top:5px;"><img src="<?php if(empty($data["qrcode"])): ?>../Public/images/nopic.gif<?php else: ?>__ROOT__/Uploads<?php echo ($data["qrcode"]); endif; ?>" width="200" height="200" /><p style="margin-top: 10px;color: #999999;">长按公众帐号选择框，全选复制公众帐号</p></div><div><ul  style="list-style: none;margin: 0;padding: 0"><li style="padding-bottom: 5px;"><div data-role="fieldcontain"><label for="name">公众账号:</label><input type="text" value="<?php echo ($data["pubaccount"]); ?>"></div></li><li style="padding-bottom: 5px;"><div data-role="fieldcontain"><label for="name">微信账号</label><input type="text" value="<?php echo ($data["wxaccount"]); ?>"></div></li><li><span>关注度：</span><?php echo ($data["hits"]); ?>人关注</li><li><span>评价度：</span><img src="../Public/images/xx<?php echo ($data["xingji"]); ?>.jpg" /></li><li><span>官方网站：</span><?php if(!empty($data["website"])): ?><a href='<?php echo ($data["website"]); ?>' target='_blank' rel="nofollow"><?php echo ($data["title"]); ?>官方网站</a><?php endif; ?></li><li><span>新浪微博：</span><?php if(!empty($data["sinaweibo"])): ?><a href='<?php echo ($data["sinaweibo"]); ?>' target='_blank' rel="nofollow"><?php echo ($data["title"]); ?>新浪微博</a><?php endif; ?></li><li><span>腾讯微博：</span><?php if(!empty($data["tencentweibo"])): ?><a href='<?php echo ($data["tencentweibo"]); ?>' target='_blank' rel="nofollow"><?php echo ($data["title"]); ?>腾讯微博</a><?php endif; ?></li><li><span>所在地区：</span>中国&nbsp;<?php echo (getareasname($data["province"])); ?>&nbsp;<?php echo (getareasname($data["city"])); ?></li><li><span>收录时间：</span><?php echo (todate($data["create_time"],'Y-m-d')); ?></li></ul></div></div>