<?php

class WeixinAction extends CommonAction{
    public function index() {
      
        if(isset($_GET['id'])){
            
            //分类id
            $id =I('get.id','','int');
            if(empty($id)){
                $this->error('操作错误');
            }
            
            //当前分类
            $catdata = D('Category')->where('status=1')->find($id);	

            //获取下级子分类
            $childCatMap['pid']=array('eq',$id);
            $childCatMap['status']=array('eq',1);
            $childCatList=D('Category')->where($childCatMap)->order('listorder')->select();
           
            //获取所有子类id
            $catlist = D('Category')->where('status=1')->select();	
            $idlist = $id.','.  getChildId($catlist,$id);  
            $idlist= substr($idlist, 0, strlen($idlist)-1);
            $map['w.catid'] = array('in',$idlist);

            
            //分类导航
            $position=D('Common')->getPosition($id);
            foreach ($position as $value) {
                $title=$value['catname']."_".$title;
            }
            $title=  substr($title, 0, strlen($title)-1);
            $this->assign('childCatList', $childCatList);
            
        }else if(isset ($_GET['province'])){
            
            //分类id
            $id =I('get.catid','','int');
            if(empty($id)){
                $this->error('操作错误');
            }
            
            //分类名
            $catname=  getCategoryName($id);
            
            //省份
            $province =I('get.province','','int');
            if(empty($province)){
                $this->error('操作错误');
            }
            //省份名
            $cityname=getAreasName($province);
            
            //获取下级子地区
            $childAreaMap['parent_id']=array('eq',$province);
            $childAreaList=D('Areas')->where($childAreaMap)->select();

            $where['province'] = array('eq',$province);
            $where['address']=array('like','%'.$cityname.'%');
            $where['_logic'] = 'or';
            $map['_complex'] = $where;
            
            $position[] = array('id'=>$id,'catname'=>$catname);
            $positionarea[] = array('id'=>$id,'province'=>$province,'areaname'=>$cityname);
            foreach ($position as $value) {
                $title=$value['catname']."_".$title;
            }
            $title=  $cityname."_".$title;
            $title=  substr($title, 0, strlen($title)-1);
            
            $this->assign('positionarea',$positionarea);
            $this->assign('childAreaList', $childAreaList);
            
        }else if(isset ($_GET['city'])){
            //分类id
            $id =I('get.catid','','int');
            if(empty($id)){
                $this->error('操作错误');
            }
            
            //分类名
            $catname=  getCategoryName($id);
            
            //城市id
            $city=I('get.city','','int');
            if(empty($city)){
                $this->error('操作错误');
            }
            //城市名称
            $cityname=getAreasName($city);
            
            $where['city'] = array('eq',$city);
            $where['address']=array('like','%'.$cityname.'%');
            $where['_logic'] = 'or';
            $map['_complex'] = $where;
            
            
            $position[] = array('id'=>$id,'catname'=>$catname);
            $positionarea=D('Common')->getAreaPosition($city);
            
            foreach ($positionarea as $value) {
                
                if('0'!==$value['level']){
                    $title=$value['areaname']."_".$title;
                }
                
            }
            $title=  substr($title, 0, strlen($title)-1);
            
            $this->assign('positionarea',$positionarea);
            $this->assign('childAreaList', $childAreaList);
            
        }
        
        if(isset($_GET['tag'])){
            $tag=I('get.tag');
            if(!empty($tag)){
                $map['tag']=array('like','%'.$tag.'%');
            }
        }
        
        $name = $this->getActionName();
       
        //获取分页设置
        $Model=M('Model');
        $mapModel['table']=array('eq',$name);
        $mapModel['status']=array('eq',1);
        
        $pageinfo=$Model->where($mapModel)->find();

        $map['w.status']=array('eq',1);
        $prefix=C('DB_PREFIX');//表前缀
        
        $Form   =   M($name);
        import("@.ORG.Page");       //导入分页类
        $count  = $Form->Table($prefix.'weixin w')->join('(select * from '.$prefix.'tuijian WHERE recommendid=3 AND (timelimit=0 OR endtime>=unix_timestamp(CURDATE())) AND status=1) t ON w.id=t.wxid')->where($map)->count();    //计算总数

        $Page = new Page($count, $pageinfo['listrows']);
        $list   = $Form->Table($prefix.'weixin w')->join('(select * from '.$prefix.'tuijian WHERE recommendid=3 AND (timelimit=0 OR endtime>=unix_timestamp(CURDATE())) AND status=1) t ON w.id=t.wxid')->where($map)->field('w.id,w.pubaccount,w.logo,w.weblogo,w.qrcode,w.webqrcode,w.content,w.tag,w.xingji,w.hits,w.status,t.recommendid,IFNULL(t.create_time,9369311152) as tjtime')->limit($Page->firstRow. ',' . $Page->listRows)->order('tjtime ASC')->select();
  
        
        // 设置分页显示
        $Page->setConfig('header', $pageinfo['header']);
        $Page->setConfig('first', $pageinfo['first']);
        $Page->setConfig('last', $pageinfo['last']);
        $Page->setConfig('prev', $pageinfo['prev']);
        $Page->setConfig('next', $pageinfo['next']);
        $Page->setConfig('theme',$pageinfo['theme']);
        
        $page = $Page->show();

        $this->seo(($catdata['title'])?$catdata['title']:$title, ($catdata['keywords'])?$catdata['keywords']:C(SITE_KEYWORDS), ($catdata['description'])?$catdata['description']:C(SITE_DESCRIPTION), $position);
        
        $Page->setConfig('next', '查看更多');
        $Page->setConfig('theme','%downPage%');
        $downPage= $Page->show();
        $this->assign("downPage", $downPage);
        $this->assign("data", $catdata);
        $this->assign("page", $page);
        $this->assign("list", $list);
        $this->display(); 
    }


    public function search() {

        $id =I('get.id','','int');
        if(empty($id)){
            $this->error('操作错误');
        }

        if(isset($_GET['keyword'])){
            $keyword =I('get.keyword','','urldecode,strip_tags,htmlspecialchars');
            if(empty($keyword)){
                $this->error('操作错误');
            }
        }
       
        if(isset($_POST['search'])){
    
            $keyword =I('post.search','','strip_tags,htmlspecialchars');
            if(empty($keyword)){
                $this->error('操作错误');
            }
        }

        
        $where['pubaccount'] =array('like','%'.$keyword.'%');
        $where['wxaccount'] = array('like','%'.$keyword.'%');
        $where['_logic'] = 'OR';
       
        if(isset($_GET['catid'])){
            $catid =I('get.catid');
             //获取所有子类id
            $catlist = D('Category')->where('status=1')->select();	
            $idlist = $catid.','.  getChildId($catlist,$catid);  
            $idlist= substr($idlist, 0, strlen($idlist)-1);
            $map['catid'] = array('in',$idlist);
        }
        $map['_complex'] = $where;
        
        //当前栏目分类
        $catdata = D('Category')->where('status=1')->find($id);	
        
        //搜索词处理
        $mapsearch["search"]=array('eq',$keyword);
        $Search=M('Search');
        $searchInfo=$Search->where($mapsearch)->find();
        
        if($searchInfo){
            D('Search')->where($mapsearch)->setInc('hits',1);//浏览次数
        }else{
            $_POST['search']=$keyword;
            $searchvo=$Search->create();
            if (false === $searchvo) {
                $this->error($Search->getError());
            }

            $Search->hits=1;
            $Search->status=1;
            $Search->create_time=time();
            //保存当前数据对象
            $searchList = $Search->add();
        }
        
        $name = $this->getActionName();
        
        //获取分页设置
        $Model=M('Model');
        $mapmodel['table']=array('eq',$name);
        $pageinfo=$Model->where($mapmodel)->find();
       
        $Form   =   M($name);

        import("@.ORG.Page");       //导入分页类
        $count  = $Form->where($map)->count();    //计算总数

        $Page = new Page($count, $pageinfo['listrows']);
        $list   = $Form->where($map)->limit($Page->firstRow. ',' . $Page->listRows)->order('zhiding desc,id desc')->select();

        //分页跳转的时候保证查询条件
        $Page -> parameter .= "id=".$id."&";
        if(isset($catid)){
            $Page -> parameter .= "catid=".$catid."&";
        }
        $Page -> parameter .= "keyword=".urlencode($keyword)."&";

        // 设置分页显示
        $Page->setConfig('header', $pageinfo['header']);
        $Page->setConfig('first', $pageinfo['first']);
        $Page->setConfig('last', $pageinfo['last']);
        $Page->setConfig('prev', $pageinfo['prev']);
        $Page->setConfig('next', $pageinfo['next']);
        $Page->setConfig('theme',$pageinfo['theme']);
        $page = $Page->show();
        
        $position=D('Common')->getPosition($id);
        foreach ($position as $value) {
            $title=$value['catname']."_".$title;
        }
        $title=  substr($title, 0, strlen($title)-1);
        $this->seo(($catdata['title'])?$catdata['title']:$keyword.'_'.$title, ($catdata['keywords'])?$catdata['keywords']:C(SITE_KEYWORDS), ($catdata['description'])?$catdata['description']:C(SITE_DESCRIPTION), $position);
        
        $this->assign("keyword", $keyword);
        $this->assign("data", $catdata);
        $this->assign("page", $page);
        $this->assign("list", $list);
        $this->display(); 
        
    }
    
    //地区微信
    public function area() {
        
        
//        import('@.ORG.Net.IpLocation');// 导入IpLocation类
//        $IpL = new IpLocation(); // 实例化类
//        $location = $IpL->getlocation(); // 获取某个IP地址所在的位置
//        $country = iconv('gbk','utf-8',$location['country']);
//        $countryarea =iconv('gbk','utf-8',$location['area']);
//        $this->assign('country',$country);
//        $this->assign('countryarea',$countryarea);
        
        $id =I('get.id','','int');
        if(empty($id)){
            $this->error('操作错误');
        }
        $catdata = D('Category')->where('status=1')->find($id);	
        
        //热门城市
        $maprecommend['recommend']=array('eq',1);
        $recommendlist=D('Areas')->where($maprecommend)->select();
        $this->assign('recommendlist',$recommendlist);
        
        //选择省份
        $map['area_type']=array('eq',1);
        $map['recommend']=array('neq',1);
        
        $arealist = D('Areas')->where($map)->select();
        if(is_array($arealist)){
            foreach ($arealist as $key=>$val){
                $mapsub['parent_id']=array('eq',$val['id']);
                $mapsub['recommend']=array('neq',1);
                $arealist[$key]['subarealist'] = D('Areas')->where($mapsub)->select();//选择城市
            }
        }
        $this->assign('arealist',$arealist);
        
        //seo
        $position=D('Common')->getPosition($id);
        foreach ($position as $value) {
            $title=$value['catname']."_".$title;
        }
        $title=  substr($title, 0, strlen($title)-1);
        $this->seo(($catdata['title'])?$catdata['title']:$title, ($catdata['keywords'])?$catdata['keywords']:C(SITE_KEYWORDS), ($catdata['description'])?$catdata['description']:C(SITE_DESCRIPTION), $position);
        
        $this->assign("data", $catdata);
        $this->display();
    }
    //热门推荐
    public function hot() {
        $id =I('get.id','','int');
        if(empty($id)){
            $this->error('操作错误');
        }
        $catdata = D('Category')->where('status=1')->find($id);	
        
        $prefix=C('DB_PREFIX');
        //获取热门推荐的公号
        $time=time();
        
        $where['starttime']=array('elt',$time);
        $where['endtime']=array('egt',$time-(24*3600));
        $where['_logic'] = 'and';
        $mapa['_complex'] = $where;
        $mapa['timelimit']=array('eq',0);
        $mapa['_logic'] = 'or';
        $map['_complex'] = $mapa;

        $map[$prefix.'tuijian.status']=array('eq',1);
        $map['recommendid']=array('eq',1);

        //取所有热门推荐数据
        $name = $this->getActionName();

        $map[$prefix.'weixin.status']=array('eq',1);
        //获取分页设置
        $Model=M('Model');
        $modelmap['table']=array('eq',$name);
        $pageinfo=$Model->where($modelmap)->find();

        $tuijian=M('Tuijian');
        import("@.ORG.Page");       //导入分页类
        $count  = $tuijian->join($prefix.'weixin ON '.$prefix.'weixin.id='.$prefix.'tuijian.wxid')->where($map)->count();    //计算总数
//        $Page = new Page($count, $pageinfo['listrows']);
        $Page = new Page($count, 42);
        $list=$tuijian->join($prefix.'weixin ON '.$prefix.'weixin.id='.$prefix.'tuijian.wxid')->where($map)->limit($Page->firstRow. ',' . $Page->listRows)->field($prefix.'weixin.*')->order('timelimit desc,'.$prefix.'tuijian.create_time desc')->select();

        // 设置分页显示
        $Page->setConfig('header', $pageinfo['header']);
        $Page->setConfig('first', $pageinfo['first']);
        $Page->setConfig('last', $pageinfo['last']);
        $Page->setConfig('prev', $pageinfo['prev']);
        $Page->setConfig('next', $pageinfo['next']);
        $Page->setConfig('theme',$pageinfo['theme']);
        $page = $Page->show();
        
        $Page->setConfig('next', '查看更多');
        $Page->setConfig('theme','%downPage%');
        $downPage= $Page->show();
        $this->assign("downPage", $downPage);
        
        $this->assign("page", $page);
        $this->assign("list", $list);
        $this->assign("data", $catdata);
        
        //seo
        $position=D('Common')->getPosition($id);
        foreach ($position as $value) {
            $title=$value['catname']."_".$title;
        }
        $title=  substr($title, 0, strlen($title)-1);
        $this->seo(($catdata['title'])?$catdata['title']:$title, ($catdata['keywords'])?$catdata['keywords']:C(SITE_KEYWORDS), ($catdata['description'])?$catdata['description']:C(SITE_DESCRIPTION), $position);
        
        $this->display();
    }
    //关注排行榜
    public function order() {
    
        $id =I('get.id','','int');
        if(empty($id)){
            $this->error('操作错误');
        }
        $catdata = D('Category')->where('status=1')->find($id);	
        
        
        $name = $this->getActionName();
        $map['status']=array('eq',1);
        //获取分页设置
        $Model=M('Model');
        $map['table']=array('eq',$name);
        $pageinfo=$Model->where($map)->find();

        $Form   =   M($name);
        import("@.ORG.Page");       //导入分页类
        $count  = $Form->where($map)->count();    //计算总数
//        $Page = new Page($count, $pageinfo['listrows']);
        $Page = new Page($count, 42);
        $list   = $Form->where($map)->limit($Page->firstRow. ',' . $Page->listRows)->order('hits desc')->select();

        // 设置分页显示
        $Page->setConfig('header', $pageinfo['header']);
        $Page->setConfig('first', $pageinfo['first']);
        $Page->setConfig('last', $pageinfo['last']);
        $Page->setConfig('prev', $pageinfo['prev']);
        $Page->setConfig('next', $pageinfo['next']);
        $Page->setConfig('theme',$pageinfo['theme']);
        $page = $Page->show();
        
        $Page->setConfig('next', '查看更多');
        $Page->setConfig('theme','%downPage%');
        $downPage= $Page->show();
        $this->assign("downPage", $downPage);
        
        $this->assign("data", $catdata);
        $this->assign("page", $page);
        $this->assign("list", $list);
         //seo
        $position=D('Common')->getPosition($id);
        foreach ($position as $value) {
            $title=$value['catname']."_".$title;
        }
        $title=  substr($title, 0, strlen($title)-1);
        $this->seo(($catdata['title'])?$catdata['title']:$title, ($catdata['keywords'])?$catdata['keywords']:C(SITE_KEYWORDS), ($catdata['description'])?$catdata['description']:C(SITE_DESCRIPTION), $position);
        
        $this->display();
    }
    //最新收录
    public function news() {
    
        $id =I('get.id','','int');
        if(empty($id)){
            $this->error('操作错误');
        }
        $catdata = D('Category')->where('status=1')->find($id);	
        
        $name = $this->getActionName();
        $map['status']=array('eq',1);
        
        //获取分页设置
        $Model=M('Model');
        $map['table']=array('eq',$name);
        $pageinfo=$Model->where($map)->find();

        $Form   =   M($name);
        import("@.ORG.Page");       //导入分页类
        $count  = $Form->where($map)->count();    //计算总数
//        $Page = new Page($count, $pageinfo['listrows']);
        $Page = new Page($count, 42);
        $list   = $Form->where($map)->limit($Page->firstRow. ',' . $Page->listRows)->order('create_time desc')->select();

        // 设置分页显示
        $Page->setConfig('header', $pageinfo['header']);
        $Page->setConfig('first', $pageinfo['first']);
        $Page->setConfig('last', $pageinfo['last']);
        $Page->setConfig('prev', $pageinfo['prev']);
        $Page->setConfig('next', $pageinfo['next']);
        $Page->setConfig('theme',$pageinfo['theme']);
        $page = $Page->show();
        
        $Page->setConfig('next', '查看更多');
        $Page->setConfig('theme','%downPage%');
        $downPage= $Page->show();
        $this->assign("downPage", $downPage);
        
        $this->assign("data", $catdata);
        $this->assign("page", $page);
        $this->assign("list", $list);
        //seo
        $position=D('Common')->getPosition($id);
        foreach ($position as $value) {
            $title=$value['catname']."_".$title;
        }
        $title=  substr($title, 0, strlen($title)-1);
        $this->seo(($catdata['title'])?$catdata['title']:$title, ($catdata['keywords'])?$catdata['keywords']:C(SITE_KEYWORDS), ($catdata['description'])?$catdata['description']:C(SITE_DESCRIPTION), $position);
        
        $this->display();
    }
    
    //提交微信
    public function add() {
        if(IS_POST){
            if(!C('ISADDACCOUNT')){
                $this->error('操作错误');
            }
            $ip=get_client_ip();
            $time=time();
            $map['ip']=array('eq',$ip);
            
            //提交间隔
            $model = D('Weixin');
            $comment=$model->where($map)->order('id desc')->find();
            if($time-$comment['create_time']<10){
                $this->error('每次提交需间隔10秒钟!');
            }

            $_POST['pubaccount']=I('post.pubaccount');
            $_POST['wxaccount']=I('post.wxaccount');
            $_POST['ghweixin']=I('post.ghweixin');
            $_POST['website']=I('post.website');
            $_POST['sinaweibo']=I('post.sinaweibo');
            $_POST['tencentweibo']=I('post.tencentweibo');
            $_POST['title']=I('post.title');
            $_POST['keywords']=I('post.keywords');
            $_POST['description']=I('post.description');
            $_POST['weblogo']=I('post.weblogo');
            $_POST['webqrcode']=I('post.webqrcode');
            $_POST['content']=I('post.content');
            $_POST['realname']=I('post.realname');
            $_POST['phone']=I('post.phone');
            $_POST['qq']=I('post.qq','','int');
            
            //鱼福标示
            $yufumark=I('post.yufumark');
            
            //如果标题为空，默认填写公众帐号
            if(empty($_POST['title'])){
                $_POST['title']=  I('post.pubaccount');
            }
            
            //敏感词过滤
            $Badword=D('Badword');
            $Badwordlist=$Badword->select();
            foreach ($Badwordlist as $key => $value) {
                if($value['level']==1){
                    $_POST['pubaccount']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['pubaccount']);
                    $_POST['wxaccount']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['wxaccount']);
                    $_POST['ghweixin']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['ghweixin']);
                    $_POST['website']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['website']);
                    $_POST['sinaweibo']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['sinaweibo']);
                    $_POST['tencentweibo']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['tencentweibo']);
                    $_POST['title']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['title']);
                    $_POST['keywords']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['keywords']);
                    $_POST['description']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['description']);
                    $_POST['weblogo']=preg_replace('/'.$value['badword'].'/i',$value['weblogo'], $_POST['weblogo']);
                    $_POST['webqrcode']=preg_replace('/'.$value['badword'].'/i',$value['webqrcode'], $_POST['webqrcode']);
                    $_POST['content']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['content']);
                    $_POST['realname']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['realname']);
                    $_POST['phone']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['phone']);
                    $_POST['qq']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['qq']);
                }else{
                    $_POST['pubaccount']=preg_replace('/'.$value['badword'].'/i','', $_POST['pubaccount']);
                    $_POST['wxaccount']=preg_replace('/'.$value['badword'].'/i','', $_POST['wxaccount']);
                    $_POST['website']=preg_replace('/'.$value['badword'].'/i','', $_POST['website']);
                    $_POST['sinaweibo']=preg_replace('/'.$value['badword'].'/i','', $_POST['sinaweibo']);
                    $_POST['tencentweibo']=preg_replace('/'.$value['badword'].'/i','', $_POST['tencentweibo']);
                    $_POST['title']=preg_replace('/'.$value['badword'].'/i','', $_POST['title']);
                    $_POST['keywords']=preg_replace('/'.$value['badword'].'/i','', $_POST['keywords']);
                    $_POST['description']=preg_replace('/'.$value['badword'].'/i','', $_POST['description']);
                    $_POST['weblogo']=preg_replace('/'.$value['badword'].'/i','', $_POST['weblogo']);
                    $_POST['webqrcode']=preg_replace('/'.$value['badword'].'/i','', $_POST['webqrcode']);
                    $_POST['content']=preg_replace('/'.$value['badword'].'/i','', $_POST['content']);
                    $_POST['realname']=preg_replace('/'.$value['badword'].'/i','', $_POST['realname']);
                    $_POST['phone']=preg_replace('/'.$value['badword'].'/i','', $_POST['phone']);
                    $_POST['qq']=preg_replace('/'.$value['badword'].'/i','', $_POST['qq']);
                }
                
            }
            
            //上传附件
            $this->_upload();
            
            if (false === $model->create()) {
                $this->error($model->getError());
            }
            if(C('ISYUFUMARK')=="1"){
                if(trim(C('YUFUMARK'))==trim($yufumark)){
                    $model->status=1; 
                }else{
                    $model->status=2; 
                }
                
            }else{
               $model->status=2; 
            }
            $model->typeid=1;
            $model->iscomment=1;
            //保存当前数据对象
            
            $list = $model->add();
            if ($list !== false) { //保存成功
                $this->success('提交成功!');
            } else {
                //失败提示
                $this->error('提交失败!');
            }
            
        }  else {
            
            if(!C('ISADDACCOUNT')){
                $this->error('操作错误','__APP__');
            }
            $id = I('get.id','','int');
            if(empty($id)){
                $this->error('操作错误');
            }
            $catdata = D('Category')->where('status=1')->find($id);	
            
            $cate=new WeixinModel();
            $menu =$cate->getModelCategory('Weixin'); //加载栏目
            $this->categorylist=arrToMenu($menu,0);  
            
            
            //获取省级地区
            $province=D('areas')->where(array('parent_id'=>1))->select();
            $this->assign('province',$province);
            
            //seo
            $position=D('Common')->getPosition($id);
            foreach ($position as $value) {
                $title=$value['catname']."_".$title;
            }
            $title=  substr($title, 0, strlen($title)-1);
            $this->seo(($catdata['title'])?$catdata['title']:$title, ($catdata['keywords'])?$catdata['keywords']:C(SITE_KEYWORDS), ($catdata['description'])?$catdata['description']:C(SITE_DESCRIPTION), $position);
            $this->assign("data", $catdata);
            $this->display();
        }
        
    }
    // 检查公众帐号
    public function checkPubAccount($id=NULL) {

        $User = M("Weixin");
        //检测用户名是否冲突
        $name  = I('get.pubaccount'); 
        if(isset($id)){
            $map['id']=array('neq',  intval($id));
        }

        $result  =  $User->where($map)->getFieldByPubaccount($name,'status');
        if($result==null){
            $data['status'] = 0;
            $this->ajaxReturn($data);
        }else{
            $data['status'] = 1;
            $data['info'] = $result;
            $this->ajaxReturn($data);
        }

    }
    // 检查关联微信号
    public function checkwxaccount($id=NULL) {

        $User = M("Weixin");
        //检测用户名是否冲突
        $name  =  I('get.wxaccount');
        if(isset($id)){
            $map['id']=array('neq',  intval($id));
        }
        
        $result  =  $User->where($map)->getFieldByWxaccount($name,'status');
        if($result==null){
            //不存在
            $data['status'] = 0;
            $this->ajaxReturn($data);
        }else{
            //存在
            $data['status'] = 1;
            $data['info'] = $result;
            $this->ajaxReturn($data);
        }
        
    }
    // 检查微信原始号
    public function checkghweixin($id=NULL) {

        $User = M("Weixin");
        //检测用户名是否冲突
        $name  =  I('get.ghweixin');
        if(isset($id)){
            $map['id']=array('neq',  intval($id));
        }
        
        $result  =  $User->where($map)->getFieldByGhweixin($name,'status');
        if($result==null){
            //不存在
            $data['status'] = 0;
            $this->ajaxReturn($data);
        }else{
            //存在
            $data['status'] = 1;
            $data['info'] = $result;
            $this->ajaxReturn($data);
        }
        
    }
    //喜欢
    public function xh() {
        
        if(isset($_GET['id'])){
            $id= I('get.id','','int');
            if(!empty($id)){
                $type=I('get.type');
                if(!empty($type)){
                    $map['id']=array('eq',$id);
                    $name=  $this->getActionName();
                    switch ($type) {
                        case 'xh':
                            if(Cookie::is_set('xh'.$id)){
                                $this->error('顶过了');
                            }
                            $result=D($name)->where($map)->setInc('xh',1);//更新喜欢人数
                            if($result){
                                $ip=get_client_ip();
                                Cookie::set('xh'.$id,$ip,24*3600);
                                $num=D($name)->where($map)->getField('xh');//喜欢人数
                                $this->success($num);
                            } 
                            break;
                        case 'nxh':
                            if(Cookie::is_set('nxh'.$id)){
                                $this->error('踩过了');
                            }
                            $result=D($name)->where($map)->setInc('nxh',1);//更新喜欢人数
                            if($result){
                                $ip=get_client_ip();
                                Cookie::set('nxh'.$id,$ip,24*3600);
                                $num=D($name)->where($map)->getField('nxh');//喜欢人数
                                $this->success($num);
                            } 
                            break;

                    }
                    
                }
                
            }
        }
    }
    
}

?>
