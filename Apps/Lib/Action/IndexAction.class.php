<?php

class IndexAction extends CommonAction {

    public function index(){

        $wxModel=M('Weixin');
        $wxModelMap['status']=array('eq',1);
        //总共收录公众帐号数
        $allcount=$wxModel->where($wxModelMap)->count();

        //今日收录帐号数
        $daycount=$wxModel->where('status=1 and date(from_unixtime(create_time))=CURDATE() ')->count();
        
        //热门推荐
        $prefix=C('DB_PREFIX');
        //获取热门推荐的公号
        $time=time();
        
        $where['starttime']=array('elt',$time);
        $where['endtime']=array('egt',$time-(24*3600));
        $where['_logic'] = 'and';
        $mapa['_complex'] = $where;
        $mapa['timelimit']=array('eq',0);
        $mapa['_logic'] = 'or';


        $name = $this->getActionName();
		
        
        //获取分页设置
        $Model=M('Model');
        $modelmap['table']=array('eq','Weixin');
        $pageinfo=$Model->where($modelmap)->find();
		//获取推荐数据
		$map['_complex'] = $mapa;
        $map[$prefix.'tuijian.status']=array('eq',1);
        $map['recommendid']=array('eq',1);
		$map[$prefix.'weixin.status']=array('eq',1);
        $tuijian=M('Tuijian');
        import("@.ORG.Page");       //导入分页类
        $count  = $tuijian->join($prefix.'weixin ON '.$prefix.'weixin.id='.$prefix.'tuijian.wxid')->where($map)->count();    //计算总数
//        $Page = new Page($count, $pageinfo['listrows']);
        $Page = new Page($count, 36);
//        $list=$tuijian->join($prefix.'weixin ON '.$prefix.'weixin.id='.$prefix.'tuijian.wxid')->where($map)->limit($Page->firstRow. ',' . $Page->listRows)->field($prefix.'weixin.*')->order('timelimit desc,'.$prefix.'tuijian.create_time desc')->select();
        $tjlist=$tuijian->join($prefix.'weixin ON '.$prefix.'weixin.id='.$prefix.'tuijian.wxid')->where($map)->limit('36')->field($prefix.'weixin.*')->order('timelimit desc,'.$prefix.'tuijian.create_time desc')->select();
        // 设置分页显示
        $Page->setConfig('header', $pageinfo['header']);
        $Page->setConfig('first', $pageinfo['first']);
        $Page->setConfig('last', $pageinfo['last']);
        $Page->setConfig('prev', $pageinfo['prev']);
        $Page->setConfig('next', $pageinfo['next']);
        $Page->setConfig('theme',$pageinfo['theme']);
        $page = $Page->show();
        
//        $this->assign("tjpage", $page);
        $this->assign("tjlist", $tjlist);
        




        //友情链接
        $model=D('Link');
        $list=$model->order('listorder asc')->select();
        $this->list=$list;
        
        $this->assign('allcount', $allcount);
        $this->assign('daycount', $daycount);
        $position[]=array('id'=>0,'catname'=>'首页');
        $this->seo(C(SITE_TITLE), C(SITE_KEYWORDS), C(SITE_DESCRIPTION), $position);

        Cookie::set('_curUrl_', __SELF__);
        session('_curUrl_', __SELF__);
        $this->prefix=C('DB_PREFIX');//表前缀
        $this->display();
    }
   

}