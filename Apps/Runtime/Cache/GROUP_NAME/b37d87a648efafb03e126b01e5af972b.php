<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title><?php echo ($title); ?>-<?php echo ($sitename); ?></title><meta name="keywords" content="<?php echo ($keywords); ?>" /><meta name="description" content="<?php echo ($description); ?>" /><script src="../Public/js/device.min.js" type="text/javascript"></script><script src="../Public/js/jquery.min.js" type="text/javascript"></script><script src="../Public/js/jquery.cookie.js" type="text/javascript"></script><script src="../Public/js/com.js" type="text/javascript"></script><script src="../Public/js/jquery.lazyload.min.js" type="text/javascript"></script><link rel="stylesheet" href="../Public/css/blue.css" /><link rel="stylesheet" type="text/css" href="../Public/css/style.css" /><link rel="stylesheet" href="../Public/css/swiper.min.css"><script type="text/javascript" src="../Public/js/swiper.min.js"></script><script>        if(device.mobile()){
            location.href='/m/'
        }
    </script><style type="text/css">        .b-hidden {
            display: none;
        }

        .b-shown {
            display: block;
        }
        #nav_88{
            position:relative;
        }
    </style></head><body><div class="header"><div class="top"><div class="msg clearfix"><div class="welcome"><h1 class="caaa"><?php $other=$_result=M('Other')->where('status=1 and settag="tophot"')->find(); echo $other['setvalue'];?></h1></div><div class="record"><!-- <a href="/about?id=24">帮助中心</a> --><a href="javascript:;" class="everyday_sign_in diag">8小时签到</a>                |<a href="<?php $other=$_result=M('Other')->where('status=1 and settag="qrcode"')->find(); echo $other['setvalue'];?>" target="_blank" class="follow_tip_link" style="width: 60px;color: #ff3265;">手机端入口
                <i class="weixinqunICON wxICON_1"></i><div class="follow_tip hide" data-content="▲"><img src="<?php $other=$_result=M('Other')->where('status=1 and settag="qrcode"')->find(); echo $other['setvalue'];?>" alt="二维码">                    保存图片后，随时访问手机端！
                </div></a></div><div class="sign_in_prompt" style="background-color: #ff3265;border-radius: 5px;color: white;display: none;font-weight: bold;left: 48%;padding: 0 5px;position: absolute;top: 35%;z-index:9999;">您已成功签到，并增加了15个金币！</div></div></div><div class="logo"><div class="w1200" style="position: relative;"><a class="wxq" href="/" title="<?php echo ($sitename); ?>"><?php echo ($sitename); ?></a><span style="position: absolute;top: 65px;left: 0;width: 126px;text-align: center;font-size: 16px;color: #f00;">创业者孵化平台</span><div class="fl" style="margin-left: 15px;"><img src="../Public/picture/slogan_03.png" width="160" alt="快速加粉，秒杀一切" /></div><div class="search"><div class="search-main clearfix"><div class="btn-classify"><span id="s_name">公众号</span><i class="index-list-icon"></i></div><div class="fl search-input"><div><input type="text" class="fl" placeholder="请输入关键字" /></div></div><a class="qt-btn btn-green-linear btn-search fr" href="javascript:;" id="s_btn"><i class="index-search-icon"></i></a></div><div class="search-hot"><a href="javascript:;">热门搜索：</a><?php $_result=M('Search')->where('status=1')->field('search')->order('hits desc')->limit(3)->select();foreach($_result as $key=>$search): $keyword=urlencode($search['search']);?><a href="<?php echo U('Weixin/search',array('keyword'=>$keyword,'id'=>126));?>" target="_blank"><?php echo ($search["search"]); ?></a>&nbsp;<?php endforeach;?></div><div class="search-classify"><div class="list-box"><dl id="sr_span"><dd data="53"><a href="javascript:;">公众号</a></dd><dd data="140"><a href="javascript:;">微信群</a></dd><dd data="139"><a href="javascript:;">个人号</a></dd></dl></div></div><script>                    $('.btn-classify').click(function(){
                        $('.search-classify').toggle();
                    });
                    $('.search-classify dd a').click(function(){
                        $('.search-classify').hide();
                        var str = $(this).html();
                        console.log(str);
                        $('#s_name').html(str);
                    });
                </script><div class="scrollNotice" id="scrollDiv"><ul><?php $_result=M('Announce')->where('status=1 and endtime >= "2018-10-01"')->field('id,title')->order('create_time desc')->limit(5)->select();foreach($_result as $key=>$announce):?><li><a href="<?php echo U('Announce/show',array('id'=>$announce['id']));?>" target=_blank><?php echo (msubstr($announce["title"],0,18)); ?></a></li><?php endforeach;?></ul></div><script type="text/javascript">                    function AutoScroll(obj){
                        $(obj).find("ul:first").animate({
                            marginTop:"-25px"
                        },1000,function(){
                            $(this).css({marginTop:"0px"}).find("li:first").appendTo(this);
                        });
                    }
                    $(document).ready(function(){
                        setInterval('AutoScroll("#scrollDiv")',5000)
                    });
                </script></div><a href="<?php echo U('Member/add');?>" class="xcxbtn" target="_blank"><i></i>小程序发布</a><a href="<?php echo U('Member/add');?>" class="xcxbtn qjy_icon diag" style="top: 30px;"><i></i>公众号发布</a><?php if($_SESSION['YFIndex_']['account']!= null): ?><div class="fr login" id="user_is_login" style="display:block;"><a href="<?php echo U('Member/index');?>" style="border-right:1px solid #d2d2d2;" class="login_01">个人中心</a><a href="<?php echo U('Member/logout');?>" class="login_02">退出</a></div><?php else: ?><div class="fr login" id="user_not_login" style="display:block;"><a href="<?php echo U('Member/login');?>" style="border-right:1px solid #d2d2d2" class="user-center top_login">登录</a><a href="<?php echo U('Member/register');?>" class="user-center top_reg">注册</a></div><?php endif; ?></div></div><script>        $(function(){
            searchtype = "53";
            var key = "";

            $("dl#sr_span > dd").click(function(){
                $("dl#sr_span > dd").removeClass("cur");
                $(this).addClass("cur");
            })

            $("dl#s_label>dd, dl#sr_span > dd").bind('click', function(){
                searchtype=$(this).attr('data');
            });

            function search() {
                var val = $('.search-input input').val();
                if (! val){
                    alert('请输入搜索内容');
                    return;
                }
                var key = encodeURI(val);
                location.href = "/index.php?m=weixin&a=search&id=126&catid=" + searchtype + "&keyword=" + key;
            }
            $('#s_btn').bind('click',search);

            $('.search-input input').keydown(function(e){
                if(e.keyCode==13){
                    search();
                }
            });
        });
        $(".follow_tip_link").hover(function() {
            $(".record i").toggleClass('wxICON_1_rotate');
        });


    </script><div class="nav"><div class="menu"><ul class="fl w1200"><li class="active"><i></i><a href="__APP__" class=>                        首页


                    </a></li><?php if(is_array($nav_list)): $i = 0; $__LIST__ = $nav_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(empty($vo["sub_nav"])): ?><li><i></i><a href="<?php echo ($vo["url"]); ?>" id="nav_<?php echo ($vo["id"]); ?>"><?php echo ($vo["catname"]); ?></a></li><?php else: ?><li><i></i><a href="<?php echo ($vo["url"]); ?>" class=><?php echo ($vo["catname"]); ?><i class="icon-down"></i></a><div style="z-index: 999; display: none;"><?php if(is_array($vo["sub_nav"])): $i = 0; $__LIST__ = array_slice($vo["sub_nav"],1,5,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($i % 2 );++$i; if(($key) == "1"): ?><a href="<?php echo ($vo["url"]); ?>" class="catalog">所有分类</a><?php endif; ?><a href="<?php echo ($sub["url"]); ?>"  class="catalog"><?php echo ($sub["catname"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?></div></li><?php endif; endforeach; endif; else: echo "" ;endif; ?><li class="Release" style="float:right;"><span class="fl weixinqunICON wxICON_4"></span><a href="<?php echo U('Member/add');?>" id="add_group">发布微信群</a><!-- <a href="/user_center/group" class="diag" id="add_group">发布微信群</a> --><span class="fr weixinqunICON wxICON_5"></span></li></ul></div></div></div><link href="../Public/css/center.css" rel="stylesheet" /><div class="w1200 clearfix pt20"><ul></ul><div class="centerNav"><div class="centerAvatar"><div class="row"><div class="avatar"><a href="#" title="头像"><img src="<?php if(empty($data["thumb"])): ?>../Public/images/nopic.gif<?php else: ?>__ROOT__/Uploads<?php echo ($data["thumb"]); endif; ?>" alt="头像"></a></div><div class="myInfo"><p class="name ellips mt20"><?php echo ($data["nickname"]); ?></p><p class="integral">会员组:<span class=" Pink"><?php echo (getgroupname($data["role_id"])); ?></span></p></div></div><div class="row pt10"><div class="rgstion" style=" text-align:center"><a href="<?php echo U('Member/index');?>" class="btn_orange" title="签到">返回个人中心</a></div></div></div><div class="centerMenu"><ul><li class="item <?php if(($position) == "add"): ?>active"<?php endif; ?>"><div class="menu_bg"><span class="centerICON icon_1"></span><a href="<?php echo U('Member/add');?>" class="link">发布二维码</a></div></li><li class="item <?php if(($position) == "manage"): ?>active"<?php endif; ?>"><div class="menu_bg"><span class="centerICON icon_1"></span><a href="<?php echo U('Member/manage');?>" class="link">管理二维码</a></div></li><li class="item <?php if(($position) == "tjlist"): ?>active"<?php endif; ?>"><div class="menu_bg"><span class="centerICON icon_1"></span><a href="<?php echo U('Member/tjlist');?>" class="link">自助推荐<i class="hot centerICON icon_5"></i></a></div></li><li class="item <?php if(($position) == "pay"): ?>active"<?php endif; ?>"><div class="menu_bg"><span class="centerICON icon_1"></span><a href="<?php echo U('Member/pay');?>" class="link">在线充值<i class="hot centerICON icon_5"></i></a></div></li><li class="item <?php if(($position) == "paylist"): ?>active"<?php endif; ?>"><div class="menu_bg"><span class="centerICON icon_1"></span><a href="<?php echo U('Member/paylist');?>" class="link">充值记录</a></div></li><li class="item <?php if(($position) == "change"): ?>active"<?php endif; ?>"><div class="menu_bg"><span class="centerICON icon_1"></span><a href="<?php echo U('Member/change');?>" class="link">积分兑换<i class="hot centerICON icon_5"></i></a></div></li><li class="item <?php if(($position) == "spendlist"): ?>active"<?php endif; ?>"><div class="menu_bg"><span class="centerICON icon_1"></span><a href="<?php echo U('Member/spendlist');?>" class="link">消费记录</a></div></li><li class="item <?php if(($position) == "information"): ?>active"<?php endif; ?>"><div class="menu_bg"><span class="centerICON icon_1"></span><a href="<?php echo U('Member/information');?>" class="link">修改资料</a></div></li><li class="item <?php if(($position) == "password"): ?>active"<?php endif; ?>"><div class="menu_bg"><span class="centerICON icon_1"></span><a href="<?php echo U('Member/password');?>" class="link">修改密码</a></div></li><li class="item"><div class="menu_bg"><span class="centerICON icon_1"></span><a href="<?php echo U('Member/logout');?>">退出</a></div></li></ul></div></div><div class="centerContent centerContent_index"><div class="centerExp" style=" width: 97%; border-bottom:1px solid #c2c2c2; font-size:18px;    box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.1);"><span class="ml20">欢迎您，<span class="Pink"><?php echo ($data["nickname"]); ?></span>！ 您上次登录时间是：<?php echo (todate($data["last_login_time"],'Y-m-d')); ?></span><span class="exp_tip">                    金币：<?php echo ($data["intergral"]); ?>个
                    <a href="<?php echo U('Member/change');?>" class=" btn_pink mr5">兑换</a>                    余额： <?php echo ($data["amount"]); ?>元
                    <a href="<?php echo U('Member/pay');?>" class=" btn_pink mr5">充值</a></span></div><!--<div class="centerExp mt20" style="padding-bottom:40px; padding-top:0px;"><div style="border-bottom:1px solid #ff3265; padding-left:10px; line-height:80px; height:80px;"><span class="f20" style="font-weight:200">用户ID：<?php echo ($data["id"]); ?>，您当前的等级值：</span><div class="exp_box"><span class="exp_num" style="width: 22px"></span><em class="exp_txt">等级值:20/200</em></div><span class="exp_tip"><a href="/user_center/task" class="Pink">»会员级别说明</a></span></div><div class="centerStep"><div class="st">做任务领金币</div><ul><span class="line"></span><li style="width:80px;" class="ml10"><p>签到15积分</p><p><span class="infoICON inIcon_1" style="background-position: -40px 0px;"></span></p><a href="javascript:;" class="task_btn" id="user_sign">领金币</a><p class="registration">您已成功签到，并增加了15个金币！</p></li><li><p>微信登录</p><p><span class="infoICON inIcon_2"></span></p><span>奖励20金币</span></li><li><p>关注公众号</p><p><span class="infoICON inIcon_3"></span></p><span></span></li><li><p><a href="/user_center/share">邀请注册</a></p><p><span class="infoICON inIcon_4"></span></p><span>奖励30金币</span></li><li><p>分享内容</p><p><span class="infoICON inIcon_1"></span></p><span>奖励16金币</span></li><li><p>点赞</p><p><span class="infoICON inIcon_1"></span></p><span>奖励不限</span></li></ul></div></div>--><div class="colNav"><ul><li><a href="<?php echo U('Member/manage',array('catid'=>'140'));?>"><span class="infoICON inIcon_13 Edit"></span></a><p class="colName">微信群管理</p><a href="<?php echo U('Member/manage',array('catid'=>'140'));?>"><p><span class="infoICON inIcon_5"></span></p></a><p class="hisNum">共<a href="<?php echo U('Member/manage',array('catid'=>'140'));?>"><em><?php echo ($catids["qz"]); ?></em></a>条</p></li><li><a href="<?php echo U('Member/manage',array('catid'=>'53'));?>"><span class="infoICON inIcon_13 Edit"></span></a><p class="colName">公众号管理</p><a href="<?php echo U('Member/manage',array('catid'=>'53'));?>"><p><span class="infoICON inIcon_7"></span></p></a><p class="hisNum">共<a href="<?php echo U('Member/manage',array('catid'=>'53'));?>"><em><?php echo ($catids["gz"]); ?></em></a>条</p></li><li><a href="<?php echo U('Member/manage',array('catid'=>'139'));?>"><span class="infoICON inIcon_13 Edit"></span></a><p class="colName">个人微信号管理</p><a href="<?php echo U('Member/manage',array('catid'=>'139'));?>"><p><span class="infoICON inIcon_8"></span></p></a><p class="hisNum">共<a href="<?php echo U('Member/manage',array('catid'=>'139'));?>"><em><?php echo ($catids["gr"]); ?></em></a>条</p></li></ul></div></div><div class="rel_box rel_box_login" style=" margin-top:20px;"><div class="inner"><h4>                    兑换
                    <span class="fr closeBox" style="cursor:pointer;"><img src="/images/close_02.png" alt="关闭"></span></h4><div class="code_box"><div class="mid_cen" style="text-align:left"><div> 账户余额：<span class="Pink">0.00</span>元</div><div class="pt10"><input value="1" class="input" type="text" style="width:80px;" id="exchange_rmb">                            元 = <span class="Pink" id="exchange_gold">5</span> 金币
                            <a href="javascript:;" class="ml20 btn_green" id="exchange_now">兑换</a></div></div><!-- <div class="sure"><p style="text-align:center"><a href="" class=" btn_orange">                            确定
                        </a><a href="" class=" btn_orange  ml10">                            取消
                        </a></p></div> --></div></div></div><div class="rel_box rel_box_login  trans-box" style=" margin-top:20px;"><div class="inner"><input type="hidden" name="_xsrf" value="2|4a1980a4|e34849d4cfb6ec594f5e91bd6aba4d8a|1537368437"><h4>                    用户余额转账
                    <span class="fr closeBox" style="cursor:pointer;"><img src="/images/close_02.png" alt="关闭"></span></h4><div class="code_box"><div class="mid_cen" style="text-align:left"><div><span class="pay_lable">当前余额：</span><span class="Pink">0.00</span>元 <a href="/user_center/trans?log=1" class="caaa ml20" style="font-size:12px;">交易记录</a></div><div class="pt10"><span class="pay_lable">转账用户ID：</span><input class="input" type="text" style="width:130px;" name="to_id"><span class="caaa" style="font-size:12px;">请准确核对转账用户ID,勿输错！</span></div><div class="pt10"><span class="pay_lable">转账金额：</span><input class="input" type="text" style="width:130px;" name="money"><span class="caaa" style="font-size:12px;">转账金额不低于10元</span></div></div><div class="sure"><p style="text-align:center"><a href="javascript:void(0);" class=" btn_orange trans-btn">                                确定
                            </a><a href="javascript:void(0);" class=" btn_orange  ml10">                                取消
                            </a></p></div></div></div></div><div class="blacklayout"></div><script type="text/javascript">            $(document).ready(function() {
                var _w = $(document).width();
                var _h = $(document).height();
                //				var s = '<p class="mt10"><input type="text" class="ipt"  /></p>//	';
                //			console.log(_w);
                var _w = $(document).width();
                var _h = $(document).height();
                //				var s = '<p class="mt10"><input type="text" class="ipt"  /></p>//	';
                //			console.log(_w);
                $('.duihuan').click(function() {
                    var i = $(this).index('.duihuan');
                    //				console.log(i);
                    black();
					if(i>1){i=1};
                    $('.rel_box').hide();
                    $('.rel_box').eq(i).show();
                    var wid = $('.rel_box').eq(i).width();
                    var hei = $('.rel_box').eq(i).height();
                    $('.rel_box').eq(i).css({
                        position: 'fixed',
                        top: ($(window).height() - hei) / 2,
                        left: (_w - wid) / 2
                    });
                    $('.closeBox').click(function() {
                        $('.rel_box').hide();
                        $('.blacklayout').hide();
                    });
                });
                function black() {
                    $('.blacklayout').show();
                    $('.blacklayout').css({
                        position: 'absolute',
                        width: _w,
                        height: _h,
                        'z-index': 50,
                        'background': '#000',
                        opacity: 0.5,
                        top: 0,
                        left: 0
                    });
                }

				$(".laqun a").click(function () {
                 $("#dv").slideToggle(50);
                 setTimeout(function () {
                     $("#dv").hide(200);
                 }, 1000);
             });

            })
        </script><script type="text/javascript">$('#user_sign').click(function(){
    if($(this).attr('class')=='task_btn'){
        $.ajax({
            url: '/ajax/sign',
            dataType: 'json',
            success: function(data){
                if(data==1){
                    setCookie('user_sign',1,12);
                    $('#user_sign').addClass('active');
                    $('#user_sign').html('已领');
                    $('#user_sign').prev().children().css('background-position','0 0');
                    $('#user_sign').next().fadeIn(1000).delay(2000).fadeOut(1000);
                }else{
                    $('#user_sign').addClass('active');
                    $('#user_sign').html('已领');
                    $('#user_sign').prev().children().css('background-position','0 0');
                    $('#user_sign').next().html('您在8小时内已经签到过！');
                    $('#user_sign').next().fadeIn(1000).delay(2000).fadeOut(1000);
                }
            }
        });
    };
    return false;
});

$(function($) {
    $.ajax({
        url: '/ajax/sign',
        data: "c=1",
        dataType: 'json',
        success: function(data){
            if(data==1){
                $('#user_sign').attr('class','task_btn');
                $('#user_sign').html('领金币');
                $('#user_sign').prev().children().css('background-position','-40px 0');
            }else{
                $('#user_sign').addClass('active');
                $('#user_sign').html('已领');
            }
        }
    });

    $('#exchange_rmb').keyup(function(){
        var r = /^\+?[1-9][0-9]*$/;
        if(!r.test($(this).val())){
            alert('请输入正整数！');
            $(this).val(1);
            $('#exchange_gold').html(5);
        }else{
            $('#exchange_gold').html($(this).val()*5);
        }
    });

    $('#exchange_now').click(function(){
        var r = /^\+?[1-9][0-9]*$/;
        var m = $('#exchange_rmb').val();
        if(!r.test(m)){
            alert('请输入正整数！');
        }else{
            $.ajax({
                url: '/ajax/exchange',
                data: "m="+m,
                dataType: 'json',
                success: function(data){
                    if(data==1){
                        alert('已成功兑换！');
                        location.reload();
                    }else{
                        alert('兑换失败！');
                        $('#exchange_rmb').val(1);
                        $('#exchange_gold').html(5);
                    }
                }
            });
        }
    });

    $('.trans-btn').click(function(){
        var r = /^\+?[1-9][0-9]*$/;
        var money = $('.trans-box input[name="money"]').val();
		var to_id = $('.trans-box input[name="to_id"]').val();
        if(!r.test(money) || !r.test(to_id)){
            alert('请输入正整数！');
        }else{
            $.ajax({
                url: '/user_center/trans?json=1&_xsrf='+getCookie('_xsrf'),
                data: {'money': money, 'to_id': to_id},
				type: 'POST',
                dataType: 'json',
                success: function(data){
                    if(data.error==200){
                        alert('转账成功！');
                        location.reload();

                    }else{
                        alert('转账失败:'+data.msg);
                    }
					$('.trans-btn').hide();
                }
            });
			console.log('over');
        }
    });
});

function setCookie(name,value,hours)
{
  var exp = new Date();
  exp.setTime(exp.getTime() + hours*60*60*1000);
  document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
};
/*function getCookie(name){
  var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
  if(arr=document.cookie.match(reg))
    return unescape(arr[2]);
  else
    return null;
};*/
        </script></div><div class="clear10"></div><div class="footer mt20"><div class="w1200"><!--<span class="fl" style="line-height: 38px; margin-right:20px;"><b>合作伙伴：</b>（qq:1819088888）</span>--><ul class="footkey"><?php $other=$_result=M('Other')->where('status=1 and settag="hotcat"')->find(); echo $other['setvalue'];?></ul><div class="fl ewm mt20"><img src="<?php $other=$_result=M('Other')->where('status=1 and settag="qrcode"')->find(); echo $other['setvalue'];?>" alt="二维码"><div class="fl"></div></div><div class="fl mt20"><dl><dt>扫描二维码</dt><dd class="caaa">进微信群手机站</dd><dt>更多帮助信息</dt><!--<dd><a href="/about?id=24">帮助中心</a></dd>--><dd><a href="/article?id=823479">骗子投诉</a></dd></dl><dl><dt>关于</dt><?php $_result=M('Article')->where('status=1 and catid in (175)')->order('rand()')->limit(3)->select();foreach($_result as $key=>$article):?><dd><a href="<?php echo U('Article/show',array('id'=>$article['id']));?>" target="_blank" title="<?php echo ($article["title"]); ?>"><?php echo ($article["title"]); ?></a></dd><?php endforeach;?></dl><dl><dt>合作</dt><?php $_result=M('Article')->where('status=1 and catid in (176)')->order('rand()')->limit(3)->select();foreach($_result as $key=>$article):?><dd><a href="<?php echo U('Article/show',array('id'=>$article['id']));?>" target="_blank" title="<?php echo ($article["title"]); ?>"><?php echo ($article["title"]); ?></a></dd><?php endforeach;?></dl><dl><dt>声明</dt><?php $_result=M('Article')->where('status=1 and catid in (177)')->order('rand()')->limit(3)->select();foreach($_result as $key=>$article):?><dd><a href="<?php echo U('Article/show',array('id'=>$article['id']));?>" target="_blank" title="<?php echo ($article["title"]); ?>"><?php echo ($article["title"]); ?></a></dd><?php endforeach;?></dl><dl><dt>更多</dt><?php $_result=M('Article')->where('status=1 and catid in (178)')->order('rand()')->limit(3)->select();foreach($_result as $key=>$article):?><dd><a href="<?php echo U('Article/show',array('id'=>$article['id']));?>" target="_blank" title="<?php echo ($article["title"]); ?>"><?php echo ($article["title"]); ?></a></dd><?php endforeach;?></dl></div><div class="fr copy mt20">WWW.JIAQUN.VIP <br>Copyright © 2018 <!-- <br />琼ICP备17002835号-4 --></div></div></div></body></html>