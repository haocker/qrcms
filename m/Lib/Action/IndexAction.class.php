<?php

class IndexAction extends CommonAction {

    public function index(){
        $this->sitename=C(SITE_NAME);
        //获取所有子类id
        $catlist = D('Category')->where('status=1')->select();
        $idlist = '140,'.getChildId($catlist,140);
        $idlist= substr($idlist, 0, strlen($idlist)-1);

        $map['catid'] = array('in',$idlist);
        $map['status'] = array('eq',1);
        $Form   =   M("Weixin");
        $list   = $Form->where($map)->limit('0,50')->order('id desc')->select();
        //var_dump($list);
        $this->seo('微信群','','','index');

        $this->assign('list',$list);
        $this->display();
    }
    public function geren(){
        $this->sitename=C(SITE_NAME);
        //获取所有子类id
        $catlist = D('Category')->where('status=1')->select();
        $idlist = '139,'.getChildId($catlist,139);
        $idlist= substr($idlist, 0, strlen($idlist)-1);

        $map['catid'] = array('in',$idlist);
        $map['status'] = array('eq',1);
        $Form   =   M("Weixin");
        $list   = $Form->where($map)->limit('0,50')->order('id desc')->select();
        $this->assign('list',$list);
        $this->seo('个人号','','','geren');
        $this->display();
    }
    public function zixun(){
        $this->sitename=C(SITE_NAME);
        //获取所有子类id
        $catlist = D('Category')->where('status=1')->select();
        $idlist = '55,'.getChildId($catlist,55);
        $idlist= substr($idlist, 0, strlen($idlist)-1);

        $map['catid'] = array('in',$idlist);
        $map['status'] = array('eq',1);
        $Form   =   M("Article");
        $list   = $Form->where($map)->limit('0,50')->order('id desc')->select();
        $this->assign('list',$list);
        $this->seo('微信资讯','','','zixun');
        $this->display();
    }
    public function gongzhong(){
        $this->sitename=C(SITE_NAME);
        //获取所有子类id
        $catlist = D('Category')->where('status=1')->select();
        $idlist = '53,'.getChildId($catlist,53);
        $idlist= substr($idlist, 0, strlen($idlist)-1);

        $map['catid'] = array('in',$idlist);
        $map['status'] = array('eq',1);
        $Form   =   M("Weixin");
        $list   = $Form->where($map)->limit('0,50')->order('id desc')->select();
        $this->assign('list',$list);
        $this->seo('公众号','','','gongzhong');
        $this->display();
    }
    public function exception(){
        $this->display();
    }
}