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


                    </a></li><?php if(is_array($nav_list)): $i = 0; $__LIST__ = $nav_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(empty($vo["sub_nav"])): ?><li><i></i><a href="<?php echo ($vo["url"]); ?>" id="nav_<?php echo ($vo["id"]); ?>"><?php echo ($vo["catname"]); ?></a></li><?php else: ?><li><i></i><a href="<?php echo ($vo["url"]); ?>" class=><?php echo ($vo["catname"]); ?><i class="icon-down"></i></a><div style="z-index: 999; display: none;"><?php if(is_array($vo["sub_nav"])): $i = 0; $__LIST__ = array_slice($vo["sub_nav"],1,5,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($i % 2 );++$i; if(($key) == "1"): ?><a href="<?php echo ($vo["url"]); ?>" class="catalog">所有分类</a><?php endif; ?><a href="<?php echo ($sub["url"]); ?>"  class="catalog"><?php echo ($sub["catname"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?></div></li><?php endif; endforeach; endif; else: echo "" ;endif; ?><li class="Release" style="float:right;"><span class="fl weixinqunICON wxICON_4"></span><a href="<?php echo U('Member/add');?>" id="add_group">发布微信群</a><!-- <a href="/user_center/group" class="diag" id="add_group">发布微信群</a> --><span class="fr weixinqunICON wxICON_5"></span></li></ul></div></div></div><div class="container" style=" background:#fff; border-bottom:1px solid #ccc;"><div class="w1200"><div class="city_nav_inp title"><span class="title_dqwx"><?php if(empty($data["catname"])): if(empty($cityname)): ?>全部分类
                        <?php else: echo ($cityname); endif; else: echo ($data["catname"]); endif; ?></span></div></div></div><!--筛选--><div class="container"><div class="w1200 clearfix pb10"><?php if(empty($catid)): $cat = $parentcatid; else: $cat = $catid; endif; ?><div class="assort-content bg clearfix mt20"><div class="d1"><span class="fl"><strong>地区:</strong></span><ul class="expend" id="citybox"><li <?php if(($province == '') and ($city == '')): ?>class="active"<?php else: ?>class=""<?php endif; ?>><a href="<?php echo U('Weixin/index',array('id'=>$id));?>">全部</a></li><?php if(is_array($provincelist)): $i = 0; $__LIST__ = $provincelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vp): $mod = ($i % 2 );++$i;?><li <?php if(($province == $vp['id'])): ?>class="active"<?php else: ?>class=""<?php endif; ?>><a href="<?php echo U('Weixin/index',array('catid'=>'87','province'=>$vp['id']));?>" title="<?php echo ($vp['area_name']); ?>" ><?php echo ($vp['area_name']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div><div class="d2"><span class="fl"><strong>类型:</strong></span><ul class="expend" id="citybox"><li <?php if(($parentcatid == '') and ($catid == '')): ?>class="active"<?php else: ?>class=""<?php endif; ?>><a href="<?php echo U('Weixin/index',array('id'=>$id,'keyword'=>$text,'province'=>$province,'city'=>$city));?>">全部</a></li><?php if(is_array($categorylist)): $i = 0; $__LIST__ = $categorylist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$category2): $mod = ($i % 2 );++$i; if(($category2['level']) == "2"): ?><li <?php if(($parentcatid == $category2['id'])): ?>class="active"<?php else: ?>class=""<?php endif; ?>><a  href="<?php echo U('Weixin/index',array('id'=>$category2['id'],'province'=>$province,'city'=>$city));?>" title="<?php echo ($category2['catname']); ?>" ><?php echo ($category2['catname']); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?></ul></div></div></div></div><!--搜索结果列表--><div class="w1200 "><div class=" clearfix bgfff

         mt20 bigimg_list

         "><?php if(!empty($list)): ?><div class="newslist"><ul id="tab_head"><?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><div class="border5"><span class="release weixinICON wxIcon_25"></span><a href="<?php echo U('Weixin/show',array('id'=>$vo['id']));?>" title="<?php echo ($vo["title"]); ?>" class=""><img src="<?php if(empty($vo["logo"])): if(empty($vo["weblogo"])): ?>../Public/images/nopic.gif<?php else: echo ($vo["weblogo"]); endif; else: ?>__ROOT__/Uploads<?php echo ($vo["logo"]); endif; ?>" alt="<?php echo ($vo["pubaccount"]); ?>"></a><p class="goods_name ellips"><a href="<?php echo U('Weixin/show',array('id'=>$vo['id']));?>" title="<?php echo ($vo["title"]); ?>"><?php echo (msubstr($vo["title"],0,6)); ?></a></p><p class="wxNum ellips"><span class="pink">                                        1
                                    </span><span class="caaa">                                        小时前更新
                                    </span><span class="Pink ml10"><?php if(($vo["city"] != '-1') and ($vo["city"] != '')): ?><a href="/index.php?m=weixin&a=index&catid=87&city=<?php echo ($vo["city"]); ?>" class="btnCity"><?php echo (msubstr(getareasname($vo["city"]),0,4)); ?></a><?php else: ?><a href="/index.php?m=weixin&a=index&catid=87&city=-1" class="btnCity"><?php echo (msubstr(getareasname(1,$vo["city"]),0,4)); ?></a><?php endif; ?></span></p><p><span class="weixinqunICON views"></span><span style="padding-left:10px"><?php echo ($vo["hits"]); ?></span><span class="weixinqunICON zhuanfa"></span><span style="padding-left:10px"><?php echo ($vo["xh"]); ?></span>次
                                </p></div></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div><?php endif; ?></div><div class="pageNo vm center"><?php echo ($page); ?></div></div><div class="container clearfix zoom tuijian"><div class="w1200 mt10 cont"></div></div><div class="footer mt20"><div class="w1200"><!--<span class="fl" style="line-height: 38px; margin-right:20px;"><b>合作伙伴：</b>（qq:1819088888）</span>--><ul class="footkey"><?php $other=$_result=M('Other')->where('status=1 and settag="hotcat"')->find(); echo $other['setvalue'];?></ul><div class="fl ewm mt20"><img src="<?php $other=$_result=M('Other')->where('status=1 and settag="qrcode"')->find(); echo $other['setvalue'];?>" alt="二维码"><div class="fl"></div></div><div class="fl mt20"><dl><dt>扫描二维码</dt><dd class="caaa">进微信群手机站</dd><dt>更多帮助信息</dt><!--<dd><a href="/about?id=24">帮助中心</a></dd>--><dd><a href="/article?id=823479">骗子投诉</a></dd></dl><dl><dt>关于</dt><?php $_result=M('Article')->where('status=1 and catid in (175)')->order('rand()')->limit(3)->select();foreach($_result as $key=>$article):?><dd><a href="<?php echo U('Article/show',array('id'=>$article['id']));?>" target="_blank" title="<?php echo ($article["title"]); ?>"><?php echo ($article["title"]); ?></a></dd><?php endforeach;?></dl><dl><dt>合作</dt><?php $_result=M('Article')->where('status=1 and catid in (176)')->order('rand()')->limit(3)->select();foreach($_result as $key=>$article):?><dd><a href="<?php echo U('Article/show',array('id'=>$article['id']));?>" target="_blank" title="<?php echo ($article["title"]); ?>"><?php echo ($article["title"]); ?></a></dd><?php endforeach;?></dl><dl><dt>声明</dt><?php $_result=M('Article')->where('status=1 and catid in (177)')->order('rand()')->limit(3)->select();foreach($_result as $key=>$article):?><dd><a href="<?php echo U('Article/show',array('id'=>$article['id']));?>" target="_blank" title="<?php echo ($article["title"]); ?>"><?php echo ($article["title"]); ?></a></dd><?php endforeach;?></dl><dl><dt>更多</dt><?php $_result=M('Article')->where('status=1 and catid in (178)')->order('rand()')->limit(3)->select();foreach($_result as $key=>$article):?><dd><a href="<?php echo U('Article/show',array('id'=>$article['id']));?>" target="_blank" title="<?php echo ($article["title"]); ?>"><?php echo ($article["title"]); ?></a></dd><?php endforeach;?></dl></div><div class="fr copy mt20">WWW.JIAQUN.VIP <br>Copyright © 2018 <!-- <br />琼ICP备17002835号-4 --></div></div></div></body></html>