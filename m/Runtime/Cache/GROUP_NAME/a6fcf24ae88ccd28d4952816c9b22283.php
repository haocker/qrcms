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
    </style></head><body ontouchstart><header class="h5ui-bar"><a class="h5ui-bar_item pull-right" href="<?php echo U('Member/index');?>"><img src="../Public/images/user.png" height="24" style="margin-top: 12px;float: inherit;"></a><h1 class="h5ui-bar_title"><?php echo ($title); ?></h1></header><div class="content-index"><div class="h5ui-group"><?php $_result=M('tuijian')->join('yufu_wx_weixin ON yufu_wx_weixin.id=yufu_wx_tuijian.wxid')->where('yufu_wx_weixin.status=1 and ((starttime<=1538378218 and endtime>=1538291818) or timelimit=0) and yufu_wx_tuijian.status=1 and yufu_wx_weixin.catid in (140,163,162,172,171,170,169,168,167,166,165,164)')->field('yufu_wx_weixin.*')->order('timelimit desc,yufu_wx_tuijian.create_time desc')->select();foreach($_result as $key=>$tuijian):?><a class="h5ui-list" href="<?php echo U('Weixin/show',array('id'=>$tuijian['id']));?>"><div class="h5ui-list_hd"><img src="<?php if(empty($tuijian["logo"])): if(empty($tuijian["weblogo"])): ?>../Public/images/nopic.gif<?php else: echo ($tuijian["weblogo"]); endif; else: ?>__ROOT__/Uploads<?php echo ($tuijian["logo"]); endif; ?>" width="100%" height="100%" align="h5ui"></div><div class="h5ui-list_bd"><?php echo ($tuijian["title"]); ?><div class="h5ui-list_bd fb"><?php echo ($tuijian["content"]); ?></div></div><div class="h5ui-list_ft"><span>加群</span></div><span class="topicon"></span></a><?php endforeach;?><!--<h5 class="h5ui-group_title">--><!--带图标列表项--><!--</h5>--><?php if(!empty($list)): if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><a class="h5ui-list" href="<?php echo U('Weixin/show',array('id'=>$item['id']));?>"><div class="h5ui-list_hd"><img src="<?php if(empty($item["logo"])): if(empty($item["weblogo"])): ?>../Public/images/nopic.gif<?php else: echo ($item["weblogo"]); endif; else: ?>__ROOT__/Uploads<?php echo ($item["logo"]); endif; ?>" width="100%" height="100%" align="h5ui"></div><div class="h5ui-list_bd"><?php echo ($item["title"]); ?><div class="h5ui-list_bd fb"><?php echo ($item["content"]); ?></div></div><div class="h5ui-list_ft"><span>加群</span></div></a><?php endforeach; endif; else: echo "" ;endif; endif; ?></div></div><footer class="h5ui-bar bar-fixed"><a href="<?php echo U('Index/index');?>" class="h5ui-bar_item <?php if(($position) == "index"): ?>active<?php endif; ?>"><i class="h5ui-bar_icon"><img src="../Public/images/<?php if(($position) == "index"): ?>q1<?php else: ?>q0<?php endif; ?>.png" width="100%"></i><span>微信群</span></a><a href="<?php echo U('Index/geren');?>" class="h5ui-bar_item <?php if(($position) == "geren"): ?>active<?php endif; ?>"><i class="h5ui-bar_icon"><img src="../Public/images/<?php if(($position) == "geren"): ?>m1<?php else: ?>m0<?php endif; ?>.png" width="100%"></i><span>个人</span></a><a href="<?php echo U('Member/add');?>" class="h5ui-bar_item create "><i class="h5ui-bar_icon"><img src="../Public/images/f1.png" width="100%"></i></a><a href="<?php echo U('Index/zixun');?>" class="h5ui-bar_item <?php if(($position) == "zixun"): ?>active<?php endif; ?>"><i class="h5ui-bar_icon"><img src="../Public/images/<?php if(($position) == "zixun"): ?>w1<?php else: ?>w0<?php endif; ?>.png" width="100%"></i><span>资讯</span></a><a href="<?php echo U('Index/gongzhong');?>" class="h5ui-bar_item <?php if(($position) == "gongzhong"): ?>active<?php endif; ?>"><i class="h5ui-bar_icon"><img src="../Public/images/<?php if(($position) == "gongzhong"): ?>g1<?php else: ?>g0<?php endif; ?>.png" width="100%"></i><span>公众号</span></a></footer></body></html>