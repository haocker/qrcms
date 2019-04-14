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
    </a><h1 class="h5ui-bar_title"><?php echo ($title); ?></h1></header><div class="content-member"><form action="<?php echo U('Member/checkLogin');?>" method="post"><div class="h5ui-group"><h5 class="h5ui-group_title">            加群网账号登录
        </h5><div class="h5ui-form"><label  class="h5ui-form-label">用户名</label><input type="text"  name="account" class="h5ui-form-input" placeholder="请输入用户名"></div><div class="h5ui-form"><label  class="h5ui-form-label">密码</label><input type="password" name="password" class="h5ui-form-input" placeholder="请输入密码"></div><div class="h5ui-form"><label class="h5ui-form-label">验证码</label><input type="text" name="verify" class="h5ui-form-input" placeholder="请输入验证码"><span class="h5ui-form-input_tip"><img id="verifyImg" src="<?php echo U('Member/verify');?>" onClick="fleshVerify()" border="0" alt="点击刷新验证码" style="cursor:pointer;height:30px;" align="absmiddle"></span></div></div><p style="    padding: 15px;"><button class="h5ui-btn" style="background: #ff3265;color: #ffffff;">登录</button></p></form><p style="color: #ff3265;text-align: center"><a href="<?php echo U('Member/register');?>" style="color: #ff3265;">注册加群网账号</a></p></div><script>    function fleshVerify(){
        //重载验证码
        $('#verifyImg').attr('src',"<?php echo U('Member/verify',array('t'=>time()));?>");
    }
</script><div data-role="footer" data-position="fixed"><h6>Powered by QRCMS © 2018 </h6></div>