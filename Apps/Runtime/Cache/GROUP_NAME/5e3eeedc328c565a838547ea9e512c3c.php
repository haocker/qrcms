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
                </script><div class="scrollNotice" id="scrollDiv"><ul><?php $_result=M('Announce')->where('status=1 and endtime >= "2018-11-13"')->field('id,title')->order('create_time desc')->limit(5)->select();foreach($_result as $key=>$announce):?><li><a href="<?php echo U('Announce/show',array('id'=>$announce['id']));?>" target=_blank><?php echo (msubstr($announce["title"],0,18)); ?></a></li><?php endforeach;?></ul></div><script type="text/javascript">                    function AutoScroll(obj){
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


                    </a></li><?php if(is_array($nav_list)): $i = 0; $__LIST__ = $nav_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(empty($vo["sub_nav"])): ?><li><i></i><a href="<?php echo ($vo["url"]); ?>" id="nav_<?php echo ($vo["id"]); ?>"><?php echo ($vo["catname"]); ?></a></li><?php else: ?><li><i></i><a href="<?php echo ($vo["url"]); ?>" class=><?php echo ($vo["catname"]); ?><i class="icon-down"></i></a><div style="z-index: 999; display: none;"><?php if(is_array($vo["sub_nav"])): $i = 0; $__LIST__ = array_slice($vo["sub_nav"],1,5,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($i % 2 );++$i; if(($key) == "1"): ?><a href="<?php echo ($vo["url"]); ?>" class="catalog">所有分类</a><?php endif; ?><a href="<?php echo ($sub["url"]); ?>"  class="catalog"><?php echo ($sub["catname"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?></div></li><?php endif; endforeach; endif; else: echo "" ;endif; ?><li class="Release" style="float:right;"><span class="fl weixinqunICON wxICON_4"></span><a href="<?php echo U('Member/add');?>" id="add_group">发布微信群</a><!-- <a href="/user_center/group" class="diag" id="add_group">发布微信群</a> --><span class="fr weixinqunICON wxICON_5"></span></li></ul></div></div></div><div class="w1200 clearfix pt20"><div class="w1200"><p class=" breadNav"><b>                我的位置：
            </b><a href="__APP__">首页</a> &gt;
            <?php if(is_array($position)): $i = 0; $__LIST__ = $position;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Weixin/index',array('id'=>$vo['id']));?>"><?php echo ($vo["catname"]); ?></a> &gt;<?php endforeach; endif; else: echo "" ;endif; ?></p><div class="cateNav"><div class="subj cateNav_ny clearfix"><div class="clearfix" style="padding:30px; overflow:hidden;"><div class="iframe"><!--<div style="text-align: center;margin-bottom: 5px;"><img src="images/warn1.png" style="border: 0;" alt="warn" /></div>--><!--<span class="expired" style="display: none;"></span>--><p class="checkCode"><span class="active">封面</span><span>二维码</span></p><span class="shiftcode"><img width="227" height="227" src="<?php if(empty($data["logo"])): if(empty($data["weblogo"])): ?>../Public/images/nopic.gif<?php else: echo ($data["weblogo"]); endif; else: ?>__ROOT__/Uploads<?php echo ($data["logo"]); endif; ?>"></span><span class="shiftcode" style="display: none;"><img width="227" height="227" src="<?php if(empty($data["qrcode"])): if(empty($data["webqrcode"])): ?>../Public/images/nopic.gif<?php else: echo ($data["webqrcode"]); endif; else: ?>__ROOT__/Uploads<?php echo ($data["qrcode"]); endif; ?>" alt="二维码"></span><script>                            $(".checkCode span").hover(function () {
                                $(".checkCode span").removeClass("active");
                                $(this).addClass("active");
                                var _idx = $(this).index();
                                $(".shiftcode").hide();
                                $(".shiftcode").eq(_idx).show();
                            });
                        </script><!--<div class="tool"><div class="toolbg"><a class="des" href="#">                                    我要美化
                                </a><a href="#"><img src="/images/codeicon.jpg" class="imglist_li" alt="二维码图标"></a></div></div>--><p class="mt10 mb10" style="text-align: center;"><a href="<?php echo U('Member/addtj');?>" style="padding: 3px 8px;background: #8ec31f;color: #fff;">我要上热门&gt;&gt;</a></p><div class="page_ma clearfix"><a href="<?php if(empty($prevdata["id"])): ?>#<?php else: ?>/index.php?m=weixin&a=show&id=<?php echo ($prevdata["id"]); endif; ?>" class="btn_orange">                                &lt;上一页
                            </a><a href="<?php if(empty($nextdata["id"])): ?>#<?php else: ?>/index.php?m=weixin&a=show&id=<?php echo ($nextdata["id"]); endif; ?>" class="btn_orange">                                下一页&gt;
                            </a></div><!--<p class="mt10 mb10" style="margin-top: 20px;text-align: center;">--><!--<a href="/ad_group?t=82" style="padding: 5px 10px;margin: 0 1px;background: #dfe5f9;color: #000;font-family:'宋体'">微信红包群</a>--><!--<a href="/ad_group" style="padding: 5px 10px;margin: 0 1px;background: #dfe5f9;color: #000;font-family:'宋体'">红包群</a>--><!--</p>--></div><div class="des_info" style="width:447px;"><div class="clearfix"><ul><li style="border-bottom:1px dashed #ededed; text-align:center;line-height:34px;"><span class="des_info_text" style=" font-size:20px;"><b><?php echo ($data["title"]); ?></b></span></li><li><span class="title" style=" width:43px;">                                        简介：
                                    </span></li><li style="min-height:80px;"><span class="des_info_text2" style="width:380px; margin-left:48px;"><?php echo ($data["content"]); ?></span></li><ul class="other-info"><li style="width:230px;height: 40px"><i class="wxqicon_1 weixinqunICON"></i>                                        分类：
                                        <?php if(is_array($position)): $i = 0; $__LIST__ = $position;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Weixin/index',array('id'=>$vo['id']));?>" class="btnCity"><?php echo ($vo["catname"]); ?></a>&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?></li><li style="width:190px;height: 40px"><i class="wxqicon_2 weixinqunICON"></i>                                        地区：
                                        <?php if(($data["city"] != '-1') and ($data["city"] != '')): ?><a href="/index.php?m=weixin&a=index&city=<?php echo ($data["city"]); ?>" class="btnCity"><?php echo (getareasname($data["city"])); ?></a><?php endif; ?></li><li style="width:230px;height: 40px"><i class="wxqicon_3 weixinqunICON"></i>                                        时间：
                                        <?php echo (todate($data["create_time"],'Y-m-d')); ?></li><li style="width:190px;height: 40px" class="tag ellips"><i class="wxqicon_4 weixinqunICON"></i>                                        热度：
                                        <?php echo ($data["hits"]); ?></li></ul><li><span class="title" style=" width:60px;">                                        微信号：
                                    </span><span class="des_info_text2" style="width:140px;color:#8ec31f;"><?php echo ($data["wxaccount"]); ?></span><span class="ml15">                                        QQ：
                                        <span class="Pink"><?php echo ($data["qq"]); ?></span></span></li><li></li></ul></div><div class="p_c"><ul><li style="width: 20%;" onclick="xh(this,<?php echo ($data['id']); ?>,'xh')"><span class="con_zan weixinqunICON prise"></span><p class="data"><strong><?php echo ($data["xh"]); ?></strong>个赞
                                    </p></li><li style="width: 20%;" onclick="xh(this,<?php echo ($data['id']); ?>,'nxh')"><span class="con_cai weixinqunICON dislike"></span><p class="data"><strong><?php echo ($data["nxh"]); ?></strong>次踩
                                    </p></li><li style="width: 20%;"><span class="fenx weixinqunICON"></span><p>                                        分享
                                    </p><div class="tip" style="top: -176px; left: 33.5px; display: none;"><div class="bdsharebuttonbox bdshare-button-style0-32" style="width:32px;text-align: center;" data-bd-bind="1437446036079"><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间" style="margin:5px 0 5px 0;"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博" style="margin:5px 0 5px 0;"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博" style="margin:5px 0 5px 0;"></a></div><script>                                            window._bd_share_config = {
                                                "common": {
                                                    "bdSnsKey": {},
                                                    "bdText": "",
                                                    "bdMini": "2",
                                                    "bdMiniList": false,
                                                    "bdPic": "",
                                                    "bdStyle": "0",
                                                    "bdSize": "32"
                                                },
                                                "share": {}
                                            };
                                            with (document) 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(- new Date() / 36e5)];
                                        </script></div></li><li style="width: 20%;"><a href=""><span class="zhuanf weixinqunICON"></span></a><p>                                        手机端
                                    </p><div class="tip"><a href="<?php $other=$_result=M('Other')->where('status=1 and settag="qrcode"')->find(); echo $other['setvalue'];?>" download target="_blank"><p class="wxcode"><i></i><img src="<?php $other=$_result=M('Other')->where('status=1 and settag="qrcode"')->find(); echo $other['setvalue'];?>" alt="微信转发"></p></a><p><b class="Pink">请保存图片，</b>可随时访问微信群手机端！</p></div></li></ul></div><div class="tags"><?php echo (changea($data["tag"],$position[0]['id'])); ?></div></div></div><div class="clearfix"></div></div><div style="margin-top: 10px;"></div><div class="subj"><div class="title_r"><div class="subs ml20"><h2 class="active"><span class="weixinqunICON wxICON_6"></span>                            品牌推荐
                        </h2></div><a href="<?php echo U('Member/tjlist');?>" target="_blank"><span style="display: block;" class="more"></span></a></div><ul class="gjqun clearfix"><?php $_result=M('tuijian')->join('yufu_wx_weixin ON yufu_wx_weixin.id=yufu_wx_tuijian.wxid')->where('yufu_wx_weixin.status=1 and ((starttime<=1542072253 and endtime>=1541985853) or timelimit=0) and yufu_wx_tuijian.status=1 and recommendid=3')->field('yufu_wx_weixin.*')->order('timelimit desc,yufu_wx_tuijian.create_time desc')->limit(18)->select();foreach($_result as $key=>$tuijian):?><li><a href="<?php echo U('Weixin/show',array('id'=>$tuijian['id']));?>"><img src="<?php if(empty($tuijian["logo"])): if(empty($tuijian["weblogo"])): ?>../Public/images/nopic.gif<?php else: echo ($tuijian["weblogo"]); endif; else: ?>__ROOT__/Uploads<?php echo ($tuijian["logo"]); endif; ?>" alt="<?php echo (msubstr($tuijian["title"],0,6)); ?>"></a><span class="ellips"><a href="<?php echo U('Weixin/show',array('id'=>$tuijian['id']));?>"><?php echo (msubstr($tuijian["title"],0,6)); ?></a></span></li><?php endforeach;?></ul></div><div class="subj"><div class="title_r"><div class="subs ml20"><h2 class="active"><span class="weixinqunICON wxICON_6"></span>                            相关二维码
                        </h2></div></div><ul class="gjqun clearfix"><?php $_result=M('Weixin')->where('status=1 and catid in ('.$data['catid'].')')->order('rand()')->limit(18)->select();foreach($_result as $key=>$weixin):?><li><a href="<?php echo U('Weixin/show',array('id'=>$weixin['id']));?>"><img src="<?php if(empty($weixin["logo"])): if(empty($weixin["weblogo"])): ?>../Public/images/nopic.gif<?php else: echo ($weixin["weblogo"]); endif; else: ?>__ROOT__/Uploads<?php echo ($weixin["logo"]); endif; ?>" alt="<?php echo (msubstr($weixin["title"],0,6)); ?>"></a><span class="ellips"><a href="<?php echo U('Weixin/show',array('id'=>$weixin['id']));?>"><?php echo (msubstr($weixin["title"],0,6)); ?></a></span></li><?php endforeach;?></ul></div></div><div class="side side_ny"><!--<div style="margin-bottom: 10px;"><a href="http://www.jianzhiwang.com/" target="_blank"><img src="http://weixinqun.com/images/jianzhiwang.jpg" alt="兼职网" /></a></div>--><div style="text-align:center;"><a style="background-color: rgb(223, 228, 249); padding:5px; width:80px;display: inline-block;" href="https://www.weixinqun.net/" target="_blank">微信群发布</a><a style="background-color: rgb(223, 228, 249); padding:5px;width:80px;display: inline-block;" href="http://www.weixinqun.org/" target="_blank">微信群推广</a><a style="background-color: rgb(223, 228, 249); padding:5px;width:80px;display: inline-block;" href="https://www.jianzhiwang.com/" target="_blank">在家兼职</a><a style="background-color: rgb(223, 228, 249); padding:5px;width:80px;display: inline-block;" href="http://www.weixin.org/" target="_blank">微信号推广</a></div><div style="text-align:center;"><a style="background-color: rgb(223, 228, 249); padding:5px; width:80px;margin-top: 8px;display: inline-block;" href="http://www.9877788.com/" target="_blank">微信群导航</a><a style="background-color: rgb(223, 228, 249); padding:5px;width:80px;margin-top: 8px;display: inline-block;" href="http://www.weixingongzhonghao.com/" target="_blank">微信公众号</a><a style="background-color: rgb(223, 228, 249); padding:5px;width:80px;margin-top: 8px;display: inline-block;" href="http://www.longxia.com/" target="_blank">小龙虾价格</a><a style="background-color: rgb(223, 228, 249); padding:5px;width:80px;margin-top: 8px;display: inline-block;" href="http://www.chongwugou.com/" target="_blank">宠物狗领养</a></div><div style="text-align:center;"><a style="background-color: rgb(223, 228, 249); padding:5px; width:80px;margin-top: 8px;display: inline-block;" href="http://www.jianzhi.net/" target="_blank">兼职</a><a style="background-color: rgb(223, 228, 249); padding:5px;width:80px;margin-top: 8px;display: inline-block;" href="http://www.jianzhiwang.com/" target="_blank">兼职网</a><a style="background-color: rgb(223, 228, 249); padding:5px;width:80px;margin-top: 8px;display: inline-block;" href="http://www.jianzhiwang.com/Task/index.html" target="_blank">兼职赚钱</a><a style="background-color: rgb(223, 228, 249); padding:5px;width:80px;margin-top: 8px;display: inline-block;" href="http://www.jianzhi.net" target="_blank">网络兼职</a></div><div style="text-align: center;"><a style="background-color: rgb(223, 228, 249); padding:5px; width:80px;margin-top: 8px;display: inline-block;" href="http://www.zhenrenmajiang.com/" target="_blank">真人麻将</a><a style="background-color: rgb(223, 228, 249); padding:5px;width:80px;margin-top: 8px;display: inline-block;" href="http://www.jianzhi.net/Index/task.html" target="_blank">正规兼职</a><a style="background-color: rgb(223, 228, 249); padding:5px;width:80px;margin-top: 8px;display: inline-block;" href="https://www.jianzhiwang.com/" target="_blank">网上赚钱</a><a style="background: url('http://cpro.baidustatic.com/cpro/ui/noexpire/img/4.0.0/pc_ads.1x.png') no-repeat right bottom; background-color:rgb(223, 228, 249); padding:5px; width:80px; display: inline-block;margin-top: 8px;" href="http://www.weixin3.com/" target="_blank">小程序</a><!--<a style="background-color: rgb(223, 228, 249); padding:5px;width:80px;margin-top: 8px;display: inline-block;" href="http://www.hongbaowang.com/" target="_blank">红包网</a>--></div><!--<div style="text-align: center;"><a style="background-color: rgb(223, 228, 249); padding:5px; width:80px;margin-top: 8px;display: inline-block;" href="http://www.sohongbao.com/" target="_blank">搜红包 </a><a style="background-color: rgb(223, 228, 249); padding:5px;width:80px;margin-top: 8px;display: inline-block;" href="http://www.hongbaoqun.com/" target="_blank">红包群</a><a style="background-color: rgb(223, 228, 249); padding:5px;width:110px;margin-top: 8px;display: inline-block;" href="http://www.weixinhongbao.com/" target="_blank">微信红包群</a><a style="background: url('http://cpro.baidustatic.com/cpro/ui/noexpire/img/4.0.0/pc_ads.1x.png') no-repeat right bottom; background-color:rgb(223, 228, 249); padding:5px; width:80px; display: inline-block;margin-top: 8px;" href="http://www.weixin3.com/" target="_blank">小程序</a></div>--><!-- 轮播 --><div class="title mt20"><div class="subs"><h4>                        微信文章
                    </h4></div><a href="<?php echo U('Article/index',array('id'=>55));?>" target="_blank"><span style="display: block;" class="more"></span></a></div><div class="info_fr ml20"><ul><?php $_result=M('Article')->where('status=1')->order('id desc')->limit(12)->select();foreach($_result as $key=>$article):?><li class="ellips weixinqunICON"><a href="<?php echo U('Article/show',array('id'=>$article['id']));?>" target="_blank" title="<?php echo ($article["title"]); ?>"><?php echo (msubstr($article["title"],0,20)); ?></a></li><?php endforeach;?></ul></div></div></div></div><script type="text/javascript">    $(function(){
        $('#pubaccount').click(function(){
            alert('a');
            copyToClipBoard("aaaaaaaaaaaaaaa");
        })
        
    })
    function xh(cur,id,type){
        $.get("<?php echo U('Weixin/xh');?>",{id:id,type:type},function(data){
            if(data.status==1){
                $(cur).children('.data').children('strong').html(data.info);
            }else{
                alert(data.info);
            }
            
       });
    }
</script><script type="text/javascript" language="javascript">        //复制到剪切板js代码
        function copyToClipBoard(s) {
            
            //alert(s);
            if (window.clipboardData) {
                window.clipboardData.setData("Text", s);
                alert("已经复制到剪切板！"+ "\n" + s);
            } else if (navigator.userAgent.indexOf("Opera") != -1) {
                window.location = s;
            } else if (window.netscape) {

                try {
                    netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
                } catch (e) {
                    alert("被浏览器拒绝！\n请在浏览器地址栏输入'about:config'并回车\n然后将'signed.applets.codebase_principal_support'设置为'true'");
                }
                var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
                if (!clip)
                    return;
                var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
                if (!trans)
                    return;
                trans.addDataFlavor('text/unicode');
                var str = new Object();
                var len = new Object();
                var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
                var copytext = s;
                str.data = copytext;
                trans.setTransferData("text/unicode", str, copytext.length * 2);
                var clipid = Components.interfaces.nsIClipboard;
                if (!clip)
                    return false;
                clip.setData(trans, null, clipid.kGlobalClipboard);
                alert("已经复制到剪切板！" + "\n" + s)
            }else{

            }
        }
    </script><div class="footer mt20"><div class="w1200"><!--<span class="fl" style="line-height: 38px; margin-right:20px;"><b>合作伙伴：</b>（qq:1819088888）</span>--><ul class="footkey"><?php $other=$_result=M('Other')->where('status=1 and settag="hotcat"')->find(); echo $other['setvalue'];?></ul><div class="fl ewm mt20"><img src="<?php $other=$_result=M('Other')->where('status=1 and settag="qrcode"')->find(); echo $other['setvalue'];?>" alt="二维码"><div class="fl"></div></div><div class="fl mt20"><dl><dt>扫描二维码</dt><dd class="caaa">进微信群手机站</dd><dt>更多帮助信息</dt><!--<dd><a href="/about?id=24">帮助中心</a></dd>--><dd><a href="/article?id=823479">骗子投诉</a></dd></dl><dl><dt>关于</dt><?php $_result=M('Article')->where('status=1 and catid in (175)')->order('rand()')->limit(3)->select();foreach($_result as $key=>$article):?><dd><a href="<?php echo U('Article/show',array('id'=>$article['id']));?>" target="_blank" title="<?php echo ($article["title"]); ?>"><?php echo ($article["title"]); ?></a></dd><?php endforeach;?></dl><dl><dt>合作</dt><?php $_result=M('Article')->where('status=1 and catid in (176)')->order('rand()')->limit(3)->select();foreach($_result as $key=>$article):?><dd><a href="<?php echo U('Article/show',array('id'=>$article['id']));?>" target="_blank" title="<?php echo ($article["title"]); ?>"><?php echo ($article["title"]); ?></a></dd><?php endforeach;?></dl><dl><dt>声明</dt><?php $_result=M('Article')->where('status=1 and catid in (177)')->order('rand()')->limit(3)->select();foreach($_result as $key=>$article):?><dd><a href="<?php echo U('Article/show',array('id'=>$article['id']));?>" target="_blank" title="<?php echo ($article["title"]); ?>"><?php echo ($article["title"]); ?></a></dd><?php endforeach;?></dl><dl><dt>更多</dt><?php $_result=M('Article')->where('status=1 and catid in (178)')->order('rand()')->limit(3)->select();foreach($_result as $key=>$article):?><dd><a href="<?php echo U('Article/show',array('id'=>$article['id']));?>" target="_blank" title="<?php echo ($article["title"]); ?>"><?php echo ($article["title"]); ?></a></dd><?php endforeach;?></dl></div><div class="fr copy mt20">WWW.JIAQUN.VIP <br>Copyright © 2018 <!-- <br />琼ICP备17002835号-4 --></div></div></div></body></html>