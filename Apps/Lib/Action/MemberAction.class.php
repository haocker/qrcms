<?php
// 后台用户模块
class MemberAction extends CommonAction {

    /* *
    * 配置文件
    * 版本：3.3
    * 日期：2012-07-19
    */
    
    public function alipay_config() {

       //↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
//        $typeid=I('WIDtype');
//        if(!isset($typeid)){
//            $this->error('操作错误，如需帮助请联系管理员。');
//        }
        $map['id']=array('eq',1);
        $map['status']=array('eq',1);

        $paytypelist=D('Paytype')->where($map)->find();

        if(empty($paytypelist)){
            $this->error('本站暂未开启在线支付功能，如需帮助请联系管理员。');
        }
       $alipay_config['pay_account']		= $paytypelist['pay_account'];
       
        //合作身份者id，以2088开头的16位纯数字
       $alipay_config['partner']		= $paytypelist['pay_parter'];

       //安全检验码，以数字和字母组成的32位字符
       $alipay_config['key']			= $paytypelist['pay_key'];

       $alipay_config['payid']		= $paytypelist['id'];
       $alipay_config['payname']		= $paytypelist['payname'];
       
   
       //↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑


       //签名方式 不需修改
       $alipay_config['sign_type']    = strtoupper('MD5');

       //字符编码格式 目前支持 gbk 或 utf-8
       $alipay_config['input_charset']= strtolower('utf-8');

       //ca证书路径地址，用于curl中ssl校验
       //请保证cacert.pem文件在当前文件夹目录中
       $alipay_config['cacert']    = getcwd().'\\Data\\cacert.pem';

       //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
       $alipay_config['transport']    = 'http';
       
       return $alipay_config;
    }
    
    /* *
    * 功能：标准双接口接入页
    * 版本：3.3
    * 修改日期：2012-07-23
    */
    public function alipayapi(){
        $this->checkUser();
        //验证码
        if(isset($_POST['verify'])){
           if($_SESSION['verify'] != md5($_POST['verify'])) {
                $this->error('验证码错误！');
            } 
        }
        $alipay_config=$this->alipay_config();
        /**************************请求参数**************************/

        //支付类型
        $payment_type = "1";
        //必填，不能修改
        //服务器异步通知页面路径
        //$notify_url = U('Member/notify_url','','','',true);
        $notify_url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Member/notify_url';//U('Member/notify_url','','','',true);
        //需http://格式的完整路径，不能加?id=123这类自定义参数

        //页面跳转同步通知页面路径
        $return_url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Member/return_url';//U('Member/return_url','','','',true);
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

        //卖家支付宝帐户
//        $seller_email = $_POST['WIDseller_email'];
        $seller_email =$alipay_config['pay_account'];
        //必填

        //商户订单号
//        $out_trade_no = $_POST['WIDout_trade_no'];
        $out_trade_no =create_sn(); //date('YmdHis').rand(0,9999);
        //商户网站订单系统中唯一订单号，必填

        //订单名称
//        $subject = $_POST['WIDsubject'];
        $subject="在线充值";
        //必填

        //付款金额
        $price = $_POST['WIDprice'];
        if(!preg_match('/^(([1-9]{1}\\d*)|([0]{1}))(\\.(\\d){1,2})?$/i',$price)) {
            $this->error( '充值金额必须为整数或小数(保留两位小数)');
        }
        //必填

        //商品数量
        $quantity = "1";
        //必填，建议默认为1，不改变值，把一次交易看成是一次下订单而非购买一件商品
        //物流费用
        $logistics_fee = "0.00";
        //必填，即运费
        //物流类型
        $logistics_type = "EXPRESS";
        //必填，三个值可选：EXPRESS（快递）、POST（平邮）、EMS（EMS）
        //物流支付方式
        $logistics_payment = "SELLER_PAY";
        //必填，两个值可选：SELLER_PAY（卖家承担运费）、BUYER_PAY（买家承担运费）
        //订单描述
        $body = $_POST['WIDbody'];
        //商品展示地址
        $show_url = $_POST['WIDshow_url'];
        //需以http://开头的完整路径，如：http://www.xxx.com/myorder.html

        //收货人姓名
        $receive_name = $_POST['WIDreceive_name'];
        //如：张三

        //收货人地址
        $receive_address = $_POST['WIDreceive_address'];
        //如：XX省XXX市XXX区XXX路XXX小区XXX栋XXX单元XXX号

        //收货人邮编
        $receive_zip = $_POST['WIDreceive_zip'];
        //如：123456

        //收货人电话号码
        $receive_phone = $_POST['WIDreceive_phone'];
        //如：0571-88158090

        //收货人手机号码
        $receive_mobile = $_POST['WIDreceive_mobile'];
        //如：13312341234


        /************************************************************/

        //构造要请求的参数数组，无需改动
        $parameter = array(
                        "service" => "create_direct_pay_by_user",
                        "partner" => trim($alipay_config['partner']),
                        "payment_type"	=> $payment_type,
                        "notify_url"	=> $notify_url,
                        "return_url"	=> $return_url,
                        "seller_email"	=> $seller_email,
                        "out_trade_no"	=> $out_trade_no,
                        "subject"	=> $subject,
                        "price"	=> $price,
                        "quantity"	=> $quantity,
                        "logistics_fee"	=> $logistics_fee,
                        "logistics_type"	=> $logistics_type,
                        "logistics_payment"	=> $logistics_payment,
                        "body"	=> $body,
                        "show_url"	=> $show_url,
                        "receive_name"	=> $receive_name,
                        "receive_address"	=> $receive_address,
                        "receive_zip"	=> $receive_zip,
                        "receive_phone"	=> $receive_phone,
                        "receive_mobile"	=> $receive_mobile,
                        "_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
        );

        //建立请求
        $alipaySubmit = new AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认并支付");
//        echo $html_text;
        
        $model=M('Payment');
        $data['memberid']=session('id');
        $data['membername']=session('account');
        $data['payno']=$out_trade_no;
        $data['businesstype']=$subject;
        $data['paytypeid']=$alipay_config['payid'];
        $data['paytypename']=$alipay_config['payname'];
        $data['paymoney']=$price;
        $data['type']=1;//1是金钱，2是积分
        $data['payip']=get_client_ip();
        $data['paybody']=$body;
        $data['status']=3;
        $data['create_time']=time();
        if(false===$model->add($data)){
            $this->error('操作失败');
        }
		$User=D("Member");
        $data=$User->where($map)->find();
        $this->data=$data;
        $this->assign('paymoney',$price);
        $this->assign('paytypename',$alipay_config['payname']);
        $this->assign('html_text',$html_text);
        $this->seo('支付确认', '', '', 'pay');
        C('TOKEN_ON',false);//关闭表单令牌
        $this->display();
        
        
    }
    /* *
    * 功能：支付宝服务器异步通知页面
    * 版本：3.3
    * 日期：2012-07-23
    */
    public function notify_url() {
       
//        $this->checkUser();
        $alipay_config=$this->alipay_config();
        
        //计算得出通知验证结果
        $alipayNotify = new AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();
        
        if($verify_result) {//验证成功

                //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表

                //商户订单号
                $out_trade_no = $_POST['out_trade_no'];

                //支付宝交易号
                $trade_no = $_POST['trade_no'];

                //交易状态
                $trade_status = $_POST['trade_status'];
                
                //交易金额
                $total_fee = $_POST['total_fee'];

                if($trade_status == 'WAIT_BUYER_PAY') {

                //该判断表示买家已在支付宝交易管理中产生了交易记录，但没有付款 status=2
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
                
                $model=M('Payment');
                $map['payno']=array('eq',$out_trade_no);
                $paydata=$model->where($map)->find();
                if($paydata['status']!=2&&$paydata['status']!=1&&$paydata['status']!=0){
                    $model->where($map)->setField('status', 2);
                }
                   
                echo "success";		//请不要修改或删除

                //调试用，写文本函数记录程序运行情况是否正常
//                logResult("这里写入想要调试的代码变量值，或其他运行的结果记录1");
            }
                else if($trade_status == 'WAIT_SELLER_SEND_GOODS') {
                //该判断表示买家已在支付宝交易管理中产生了交易记录且付款成功，但卖家没有发货
                
                $model=M('Payment');
                $map['payno']=array('eq',$out_trade_no);
                $paydata=$model->where($map)->find();
                if($paydata['status']!=4&&$paydata['status']!=1&&$paydata['status']!=0){
                    $model->where($map)->setField('status', 4);
                }
                    
                echo "success";		//请不要修改或删除

                //调试用，写文本函数记录程序运行情况是否正常
//                logResult("这里写入想要调试的代码变量值，或其他运行的结果记录2");
            }
                else if($trade_status == 'WAIT_BUYER_CONFIRM_GOODS') {
                //该判断表示卖家已经发了货，但买家还没有做确认收货的操作
                        
                $model=M('Payment');
                $map['payno']=array('eq',$out_trade_no);
                $paydata=$model->where($map)->find();
                if($paydata['status']!=4&&$paydata['status']!=1&&$paydata['status']!=0){
                    $model->where($map)->setField('status', 4);
                }
                    
                echo "success";		//请不要修改或删除

                //调试用，写文本函数记录程序运行情况是否正常
//                logResult("这里写入想要调试的代码变量值，或其他运行的结果记录3");
            }
                else if($trade_status == 'TRADE_FINISHED'||$trade_status == 'TRADE_SUCCESS') {
                //该判断表示买家已经确认收货，这笔交易完成
                       
                    $model=M('Payment');
                    $map['payno']=array('eq',$out_trade_no);
                    $paydata=$model->where($map)->find();
                    if($paydata['status']!=1&&$paydata['status']!=0){
                        $model->where($map)->setField('status', 1);
                        $member=M('Member');
                        $mapmember['id']=array('eq',$paydata['memberid']);
                        $mapmember['account']=array('eq',$paydata['membername']);
                        if($total_fee>200){
                            $total_fee = $total_fee*1.1;
                        }
                        $member->where($mapmember)->setInc('amount',$total_fee); 
                    }
                
                echo "success";		//请不要修改或删除

                //调试用，写文本函数记录程序运行情况是否正常
//                logResult("这里写入想要调试的代码变量值，或其他运行的结果记录4");
            }
            else {
                
                //其他状态判断
                echo "success";

                //调试用，写文本函数记录程序运行情况是否正常
//                logResult ("这里写入想要调试的代码变量值，或其他运行的结果记录5");
            }

                
        }
        else {
            
            //验证失败
            echo "fail";

            //调试用，写文本函数记录程序运行情况是否正常
//            logResult("这里写入想要调试的代码变量值，或其他运行的结果记录6");
        }
        
    }
    /* * 
    * 功能：支付宝页面跳转同步通知页面
    * 版本：3.3
    * 日期：2012-07-23
    */
    public function return_url() {
//        $this->checkUser();
        $alipay_config=$this->alipay_config();
        //计算得出通知验证结果
        $alipayNotify = new AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyReturn();
        if($verify_result) {//验证成功
               
            //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

            //商户订单号
            $out_trade_no = $_GET['out_trade_no'];

            //支付宝交易号
            $trade_no = $_GET['trade_no'];

            //交易状态
            $trade_status = $_GET['trade_status'];


            if($trade_status == 'TRADE_SUCCESS') {
                        //判断该笔订单是否在商户网站中已经做过处理
                   $this->success('交易成功，订单号：'.$out_trade_no,U('Member/paylist'));   
            }
            else if($trade_status == 'TRADE_FINISHED') {
                        //判断该笔订单是否在商户网站中已经做过处理
                     $this->success('交易成功，订单号：'.$out_trade_no,U('Member/paylist'));          
            }
            else {
                echo "trade_status=".$_GET['trade_status'];
            } 

               
        }
        else {
            //验证失败
            //如要调试，请看alipay_notify.php页面的verifyReturn函数
            echo "验证失败";
        }
        
        
    }
    //充值
    public function pay() {
        
        $this->checkUser();
		 $User=D("Member");
        $data=$User->where($map)->find();
        $this->data=$data;
        $map['status']=array('eq',1);
        $paytypelist=D('Paytype')->where($map)->select();
        $this->assign(paytypelist,$paytypelist);
        $this->seo('在线充值', '', '', 'pay');
        $this->display();
    }
    //充值记录
    public function paylist() {

        $this->checkUser();
		 $User=D("Member");
        $data=$User->where($map)->find();
        $this->data=$data;

        if(isset($_POST['name'])){
            $map['payno'] = array('like',"%".I('post.name')."%");
        }
        //状态
        if(isset($_POST['zt'])&&$_POST['zt']!=-2){
            $map['status'] = array('eq',I('zt'));
            $this->zt=I('zt');
        }
        $map['memberid']=array('eq',  session('id'));
        $map['membername']=array('eq',  session('account'));
        
        //获取分页设置
        $Model=M('Model');
        $mapmodel['table']=array('eq','Weixin');
        $pageinfo=$Model->where($mapmodel)->find();

        $Form   =   M('Payment');
        import("@.ORG.Page");       //导入分页类
        $count  = $Form->where($map)->count();    //计算总数
        $Page = new Page($count, $pageinfo['listrows']);
        $list   = $Form->where($map)->limit($Page->firstRow. ',' . $Page->listRows)->order('create_time desc')->select();
    
        
        $alipay_config=$this->alipay_config();
        /**************************请求参数**************************/
        if(!empty($alipay_config)){

            //支付类型
            $payment_type = "1";
            //必填，不能修改
            //服务器异步通知页面路径
            //$notify_url = U('Member/notify_url','','','',true);
            $notify_url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Member/notify_url';//U('Member/notify_url','','','',true);
            //需http://格式的完整路径，不能加?id=123这类自定义参数

            //页面跳转同步通知页面路径
            $return_url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Member/return_url';//U('Member/return_url','','','',true);
            //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

            //卖家支付宝帐户
    //        $seller_email = $_POST['WIDseller_email'];
            $seller_email =$alipay_config['pay_account'];
            //必填

            //商户订单号
    //        $out_trade_no = $_POST['WIDout_trade_no'];
            //$out_trade_no = $this->data->payno; //date('YmdHis').rand(0,9999);
            //商户网站订单系统中唯一订单号，必填

            foreach ($list as $key => $value) {

                //订单名称
                $subject=$value['businesstype'];

                //付款金额
                $price = $value['paymoney']+$value['discount'];
				//支付单号
				$out_trade_no = $value['payno'];
                //商品数量
                $quantity = "1";
                //必填，建议默认为1，不改变值，把一次交易看成是一次下订单而非购买一件商品
                //物流费用
                $logistics_fee = "0.00";
                //必填，即运费
                //物流类型
                $logistics_type = "EXPRESS";
                //必填，三个值可选：EXPRESS（快递）、POST（平邮）、EMS（EMS）
                //物流支付方式
                $logistics_payment = "SELLER_PAY";
                //必填，两个值可选：SELLER_PAY（卖家承担运费）、BUYER_PAY（买家承担运费）
                //订单描述
                $body = $value['paybody'];


                //构造要请求的参数数组，无需改动
                $parameter = array(
                    "service" => "create_direct_pay_by_user",
                    "partner" => trim($alipay_config['partner']),
                    "payment_type"	=> $payment_type,
                    "notify_url"	=> $notify_url,
                    "return_url"	=> $return_url,
                    "seller_email"	=> $seller_email,
                    "out_trade_no"	=> $out_trade_no,
                    "subject"	=> $subject,
                    "price"	=> $price,
                    "quantity"	=> $quantity,
                    "logistics_fee"	=> $logistics_fee,
                    "logistics_type"	=> $logistics_type,
                    "logistics_payment"	=> $logistics_payment,
                    "body"	=> $body,
                    "show_url"	=> $show_url,
                    "receive_name"	=> $receive_name,
                    "receive_address"	=> $receive_address,
                    "receive_zip"	=> $receive_zip,
                    "receive_phone"	=> $receive_phone,
                    "receive_mobile"	=> $receive_mobile,
                    "_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
                );

                //建立请求
                $alipaySubmit = new AlipaySubmit($alipay_config);
                $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "付款");
                $list[$key]['pay_btn']=$html_text;

            }
        }
        
        
        
        // 设置分页显示
        $Page->setConfig('header', $pageinfo['header']);
        $Page->setConfig('first', $pageinfo['first']);
        $Page->setConfig('last', $pageinfo['last']);
        $Page->setConfig('prev', $pageinfo['prev']);
        $Page->setConfig('next', $pageinfo['next']);
        $Page->setConfig('theme',$pageinfo['theme']);
        $page = $Page->show();
        
        $this->assign("page", $page);
        $this->assign("list", $list);

        $this->seo('充值记录', '', '', 'paylist');
        C('TOKEN_ON',false);//关闭表单令牌
        $this->display(); 
        
    }
     //积分兑换
    public function change() {
        
        $this->checkUser();
		 $User=D("Member");
        $data=$User->where($map)->find();
        $this->data=$data;
        $rmb_change_intergral=C('RMB_CHANGE_INTERGRAL');
        $map['id']=array('eq',session('id'));
        $map['account']=array('eq',session('account'));
        $memberdata=D('member')->where($map)->find();
        
        $this->assign(rmb_change_intergral,$rmb_change_intergral);
        $this->assign(memberdata,$memberdata);
        $this->seo('积分兑换', '', '', 'change'); 
        $this->display();
    }
    //金钱兑换积分
    public function payspend() {
        $this->checkUser();
        $value=I('post.value');
        if(intval($value)<=0){
            $this->error('请输入兑换金额!');
        }
        //兑换金额不能大于账户余额
        $map['id']=session('id');
        $map['account']=session('account');
        $amount=D('Member')->where($map)->getField('amount');
        if(intval($value)>$amount){
            $this->error('您的账户余额不足!');
        }
        
        $model=M('Payspend');
        $data['memberid']=session('id');
        $data['membername']=session('account');
        $data['type']=1;
        $data['value']=$value;
        $data['msg']="购买金币";
        $data['create_time']=time();
        if(false!==$model->add($data)){
            $rmb_change_intergral=C('RMB_CHANGE_INTERGRAL');
            $member=M('Member')->where($map)->setDec('amount', $data['value']);//帐户余额减少
            $member=M('Member')->where($map)->setInc('intergral', $data['value']*$rmb_change_intergral);//积分点数增加
            $this->success('操作成功');
        }else{
             $this->error('操作失败');
        }
    }
    
    //消费记录
    public function spendlist() {

        $this->checkUser();
         $User=D("Member");
        $data=$User->where($map)->find();
        $this->data=$data;
        $map['memberid']=array('eq',  session('id'));
        $map['membername']=array('eq',  session('account'));
        
        //获取分页设置
        $Model=M('Model');
        $mapmodel['table']=array('eq','Weixin');
        $pageinfo=$Model->where($mapmodel)->find();

        $Form   =   M('Payspend');
        import("@.ORG.Page");       //导入分页类
        $count  = $Form->where($map)->count();    //计算总数
        $Page = new Page($count, $pageinfo['listrows']);
        $list   = $Form->where($map)->limit($Page->firstRow. ',' . $Page->listRows)->order('create_time desc')->select();

        // 设置分页显示
        $Page->setConfig('header', $pageinfo['header']);
        $Page->setConfig('first', $pageinfo['first']);
        $Page->setConfig('last', $pageinfo['last']);
        $Page->setConfig('prev', $pageinfo['prev']);
        $Page->setConfig('next', $pageinfo['next']);
        $Page->setConfig('theme',$pageinfo['theme']);
        $page = $Page->show();
        
        $this->assign("page", $page);
        $this->assign("list", $list);

        $this->seo('消费记录', '', '', 'spendlist');
        
        $this->display(); 
        
    }
    // 会员登录
    public function login() {
        if(session('?account')) {
            $this->redirect('Member/index');
        }else{

            $this->seo('会员登录', '', '', 'login');
            $this->display();
        }
    }
     //登录验证
    public function checkLogin() {
        
        $account=I('post.account');
        $password=I('post.password');
        if(empty($account)) $this->error('帐号错误!');
        if(empty($password)) $this->error('密码错误!');
        
        //验证码
        if(isset($_POST['verify'])){
           if($_SESSION['verify'] != md5($_POST['verify'])) {
                $this->error('验证码错误！');
            } 
        }else{
            //印象码
            $YinXiangMa_response=  $this->YinXiangMa_ValidResult(@$_POST['YinXiangMa_challenge'],@$_POST['YXM_level'][0],@$_POST['YXM_input_result']);
            if($YinXiangMa_response !== "true") {
                $this->ajaxReturn('验证码错误','验证码错误',0);
            }
        }
        
        
        //生成认证条件
        $map=array();
        // 支持使用绑定帐号登录
        $map['account']= $account;
        $map["status"]=array('eq',1);
        
        
        $Member=M('Member');
        $authInfo=$Member->where($map)->find();
        
        //使用用户名、密码和状态的方式进行认证
        if(false == $authInfo) {
            $this->error('用户名或密码错误！');
        }else {
            if($authInfo['password'] != md5($password)) {
                $this->error('用户名或密码错误！');
            }

            session('id', $authInfo['id']);
            session('account', $authInfo['account']);
            session('nickname', $authInfo['nickname']);
            session('email', $authInfo['email']);
            session('lastLoginTime', $authInfo['last_login_time']);
            session('login_count', $authInfo['login_count']);

            //保存登录信息
           
            $ip=get_client_ip();
            $time=time();
            $data = array();
            $data['id']=$authInfo['id'];
            $data['last_login_time']=$time;
            $data['login_count']=array('exp','login_count+1');
            $data['last_login_ip']=$ip;
            $Member->save($data);
            
            if(session('?_curUrl_')){
                $this->success('登录成功！', session('_curUrl_'));
            }else{
                $this->success('登录成功！', Cookie::get('_curUrl_'));
            }
            

        }
    }
    //会员退出
    public function logout() {
        if(session('?account')) {
            session(null); 
            $this->success('登出成功！',U('Member/login'));
        }else {
            $this->error('已经登出！',U('Member/login'));
        }
    }
     //会员注册
    public function register() {
        if(session('?account')) {
            $this->redirect('Member/index');
        }else{
            $this->seo('会员注册', '', '', 'register');
            $this->display();
        }
    }
    //注册验证
    public function checkRegister() {

        //验证码
        if(isset($_POST['verify'])){
           if($_SESSION['verify'] != md5($_POST['verify'])) {
                $this->error('验证码错误！');
            } 
        }else{
            //印象码
            $YinXiangMa_response=  $this->YinXiangMa_ValidResult(@$_POST['YinXiangMa_challenge'],@$_POST['YXM_level'][0],@$_POST['YXM_input_result']);
            if($YinXiangMa_response !== "true") {
                $this->ajaxReturn('验证码错误','验证码错误',0);
            }
        }
        $_POST['account']=I('post.account');
        $_POST['password']=I('post.password');
        $_POST['nickname']=I('post.nickname');
        
        if(!preg_match('/^[a-zA-Z0-9_]{3,30}$/i',$_POST['account'])) {
            $this->error( '用户名必须是字母、下划线、数字组成，且3位以上！');
        }
        $_POST['password'] = md5(trim($_POST['password']));
        // 创建数据对象
        $User=D("Member");
        if(!$User->create()) {
            $this->error($User->getError());
        }else{
            //写入帐号数据
            if($result =$User->add()) {
                $this->success('注册成功！');
            }else{
                $this->error('注册失败！');
            }
        }

    }
    //帐号验证
    public function checkAccount() {

        $account=I('post.account');
        
        //检测用户名是否冲突
        
        if(!preg_match('/^[a-zA-Z0-9_]{3,30}$/i',$account)) {
            $this->error( '用户名必须是字母、下划线、数字组成，且3位以上！');
        }
        
        $User = M("Member");
        $result  =  $User->getByAccount($account);
        if($result) {
            $this->error('很抱歉，用户名已经存在！');
        }else {
            $this->success('恭喜您，用户名可以使用！');
        }
    }
    //验证登录状态
    protected function checkUser() {
        if(!session('?account')) {
            $this->error('没有登录',U('Member/login'));
        }
    }
     //会员中心
    public function index() {
        $this->checkUser();
        $map['id']=array('eq',session('id'));
		$wxmap['memberid']=array('eq',session('id'));
        $Member=M('Member');
        $data=$Member->where($map)->find();
        $this->data=$data;
		//分类数据条数
		$Form = M('Weixin');
		$Category = D('Category')->where('status=1')->select();	
		//公众号
		$clist =  "53,".getChildId($Category,53);
		$clist = substr($clist, 0, strlen($clist)-1);
		$wxmap['catid'] = array('in',$clist);
		$cids['gz'] = $Form->where($wxmap)->count();
		//个人
		$clist =  "139,".getChildId($Category,139);
		$clist = substr($clist, 0, strlen($clist)-1);
		$wxmap['catid'] = array('in',$clist);
		$cids['gr'] = $Form->where($wxmap)->count();
		//群主
		$clist =  "140,".getChildId($Category,140);
		$clist = substr($clist, 0, strlen($clist)-1);
		$wxmap['catid'] = array('in',$clist);
		$cids['qz'] = $Form->where($wxmap)->count();
		$this->assign('catids',$cids);
        $this->seo('个人中心', '', '', 'index');
        $this->display();
        
    }
    //会员资料显示
    public function information() {
        $this->checkUser();
        $User=M("Member");
        $udata=$User->getById(session('id'));
        $this->assign('udata',$udata);
		$data=$User->where($map)->find();
        $this->data=$data;
        $this->seo('修改资料', '', '', 'information');
        $this->display();
    }
    //修改资料
    public function checkInformation() {
        $this->checkUser();
        $this->_upload();
        
        $id=I('id',0,'intval');
        $thumb=I('thumb');
        $nickname=I('nickname');
        $email=I('email');
        
        $User=D("Member");
        $data=array(
            'thumb'=>$thumb,
            'nickname'=>$nickname,
            'email'=>$email,
        );
        $result	=$User->where(array('id'=>$id))->save($data);
        if(false !== $result) {
            $this->success('资料修改成功！');
        }else{
            $this->error('资料修改失败!');
        }
    }
    //修改密码
    public function password() {
        $this->checkUser();
		$User=D("Member");
        $data=$User->where($map)->find();
        $this->data=$data;
        $this->seo('修改密码', '', '', 'password');
        $this->display();
    }
    //更换密码
    public function checkPassword() {
	$this->checkUser();
    
        //验证码
        if(isset($_POST['verify'])){
           if($_SESSION['verify'] != md5($_POST['verify'])) {
                $this->error('验证码错误！');
            } 
        }else{
            //印象码
            $YinXiangMa_response=  $this->YinXiangMa_ValidResult(@$_POST['YinXiangMa_challenge'],@$_POST['YXM_level'][0],@$_POST['YXM_input_result']);
            if($YinXiangMa_response !== "true") {
                $this->ajaxReturn('验证码错误','验证码错误',0);
            }
        }
        $id=  session('id');
        if(empty($id)){
            $this->error('没有登录',U('Member/login'));
        }
        
        $password=I('password','');
        if(''===$password){
            $this->error('新密码不能为空！');
        }
        
        $oldpassword=I('oldpassword','');
        if(''===$oldpassword){
            $this->error('旧密码不能为空！');
        }
        
        //检查用户
        $User=M("Member");
        if(!$User->where(array('id'=>$id,'password'=>  pwdHash($oldpassword)))->find()) {
            $this->error('旧密码输入错误！');
        }else {
            $data=array(
                'password'=>  pwdHash($password),
            );
            if(false!==$User->where(array('id'=>$id))->save($data)){
                $this->success('密码修改成功！');
            }else{
                $this->success('密码修改失败！');
            }
            
         }
    }

    
    
    //公众账号管理
    public function manage() {
        $this->checkUser();
        $User=D("Member");
        $data=$User->where($map)->find();
        $this->data=$data;
        if(isset($_POST['name'])){
            $map['pubaccount'] = array('like',"%".I('post.name')."%");
        }
        //状态
        if(isset($_POST['zt'])&&$_POST['zt']!=-2){
            $map['status'] = array('eq',I('zt'));
            $this->zt=I('zt');
        }
		//类别
        if(isset($_GET['catid'])&&($_GET['catid']==53||$_GET['catid']==139||$_GET['catid']==140)){
            $clist = D('Category')->where('status=1')->select();	
			$clist =  $_GET['catid'].",".getChildId($clist,$_GET['catid']);
			$clist= substr($clist, 0, strlen($clist)-1);
			$map['catid'] = array('in',$clist);
        }


        $map['memberid']=array('eq',  session('id'));
        $map['membername']=array('eq',  session('account'));
        
        //获取分页设置
        $Model=M('Model');
        $mapmodel['table']=array('eq','Weixin');
        $pageinfo=$Model->where($mapmodel)->find();

        $Form   =   M('Weixin');
        import("@.ORG.Page");       //导入分页类
        $count  = $Form->where($map)->count();    //计算总数
        $Page = new Page($count, $pageinfo['listrows']);
        $list   = $Form->where($map)->limit($Page->firstRow. ',' . $Page->listRows)->order('id desc')->select();

        // 设置分页显示
        $Page->setConfig('header', $pageinfo['header']);
        $Page->setConfig('first', $pageinfo['first']);
        $Page->setConfig('last', $pageinfo['last']);
        $Page->setConfig('prev', $pageinfo['prev']);
        $Page->setConfig('next', $pageinfo['next']);
        $Page->setConfig('theme',$pageinfo['theme']);
        $page = $Page->show();
        
        $this->assign("page", $page);
        $this->assign("list", $list);

        $this->seo('微信公众账号管理', '', '', 'manage');
        $this->display(); 
        
    }
    //公众账号添加
    public function add() {
        $this->checkUser();
        if(IS_POST){
            $model = D('Weixin');
            $intergral=C('XFINTERGRAL');
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
            $_POST['tbshopurl']=I('post.tbshopurl');
            $_POST['ppshopurl']=I('post.ppshopurl');
            $_POST['tag']=I('post.tag');
            $_POST['content']=I('post.content');
            $_POST['realname']=I('post.realname');
            $_POST['phone']=I('post.phone');
            $_POST['qq']=I('post.qq','','int');
            
            //鱼福标示
            $yufumark=I('post.yufumark');
            
            //如果标题为空，默认填写公众帐号
            $_POST['title']=  I('post.pubaccount');

            
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
                    $_POST['tbshopurl']=preg_replace('/'.$value['badword'].'/i',$value['tbshopurl'], $_POST['tbshopurl']);
                    $_POST['ppshopurl']=preg_replace('/'.$value['badword'].'/i',$value['ppshopurl'], $_POST['ppshopurl']);
                    $_POST['tag']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['tag']);
                    $_POST['content']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['content']);
                    $_POST['realname']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['realname']);
                    $_POST['phone']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['phone']);
                    $_POST['qq']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['qq']);
                }else{
                    $_POST['pubaccount']=preg_replace('/'.$value['badword'].'/i','', $_POST['pubaccount']);
                    $_POST['wxaccount']=preg_replace('/'.$value['badword'].'/i','', $_POST['wxaccount']);
                    $_POST['ghweixin']=preg_replace('/'.$value['badword'].'/i','', $_POST['ghweixin']);
                    $_POST['website']=preg_replace('/'.$value['badword'].'/i','', $_POST['website']);
                    $_POST['sinaweibo']=preg_replace('/'.$value['badword'].'/i','', $_POST['sinaweibo']);
                    $_POST['tencentweibo']=preg_replace('/'.$value['badword'].'/i','', $_POST['tencentweibo']);
                    $_POST['title']=preg_replace('/'.$value['badword'].'/i','', $_POST['title']);
                    $_POST['keywords']=preg_replace('/'.$value['badword'].'/i','', $_POST['keywords']);
                    $_POST['description']=preg_replace('/'.$value['badword'].'/i','', $_POST['description']);
                    $_POST['weblogo']=preg_replace('/'.$value['badword'].'/i','', $_POST['weblogo']);
                    $_POST['webqrcode']=preg_replace('/'.$value['badword'].'/i','', $_POST['webqrcode']);
                    $_POST['tbshopurl']=preg_replace('/'.$value['badword'].'/i','', $_POST['tbshopurl']);
                    $_POST['ppshopurl']=preg_replace('/'.$value['badword'].'/i','', $_POST['ppshopurl']);
                    $_POST['tag']=preg_replace('/'.$value['badword'].'/i','', $_POST['tag']);
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
            if(C('ISAUTOVERIFY')=="1"){
                if(trim(C('YUFUMARK'))==trim($yufumark)){
                    $model->status=1; 
                }else{
                    $model->status=2; 
                }
                
            }else{
               $model->status=2; 
            }
            $model->typeid=1;
            $model->memberid=  session('id');
            $model->membername=  session('account');
            //保存当前数据对象
            $list = $model->add();
            if ($list !== false) { //保存成功
                    //添加消费记录
                $Payspend=M('Payspend');
                $data['memberid']=session('id');
                $data['membername']=session('account');
                $data['type']=2;
                $data['value']=$intergral;
                $data['msg']="发布二维码";
                $data['create_time']=time();
                $Payspend->add($data);

                //扣除用户积分
                $mapmember['id']=session('id');
                $mapmember['account']=  session('account');
                D("Member")->where($mapmember)->setDec('intergral',$intergral); // 用户的积分减
                $this->success('提交成功!',U('Member/manage'));
            } else {
                //失败提示
                $this->error('提交失败!');
            }
        }  else {
            
			$User=D("Member");
			$data=$User->where($map)->find();
			$this->data=$data;
            $cate=new WeixinModel();
            $menu =$cate->getModelCategory('Weixin'); //加载栏目
            $this->categorylist=arrToMenu($menu,0);  
            
            //获取省级地区
            $province=D('areas')->where(array('parent_id'=>1))->select();
            $this->assign('province',$province);
            
            $this->seo('提交微信公众账号', '', '', 'add');
            $this->display();
        }
        
    }
    //公众账号修改
    public function edit() {
        $this->checkUser();
        if(IS_POST){
            
            $model = D('Weixin');
            $intergral=C('XFINTERGRAL');
            $_POST['pubaccount']=I('post.pubaccount');
            $_POST['wxaccount']=I('post.wxaccount');
            $_POST['ghweixin']=I('post.ghweixin');
            $_POST['website']=I('post.website');
            $_POST['sinaweibo']=I('post.sinaweibo');
            $_POST['tencentweibo']=I('post.tencentweibo');
            $_POST['title']=I('post.title');
            $_POST['realname']=I('post.realname');
            $_POST['phone']=I('post.phone');
            $_POST['qq']=I('post.qq','','int');
            $_POST['keywords']=I('post.keywords');
            $_POST['description']=I('post.description');
            $_POST['weblogo']=I('post.weblogo');
            $_POST['webqrcode']=I('post.webqrcode');
            $_POST['tbshopurl']=I('post.tbshopurl');
            $_POST['ppshopurl']=I('post.ppshopurl');
            $_POST['tag']=I('post.tag');
            $_POST['content']=I('post.content');
            
            //如果标题为空，默认填写公众帐号
            $_POST['title']=  I('post.pubaccount');
            
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
                    $_POST['realname']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['realname']);
                    $_POST['phone']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['phone']);
                    $_POST['qq']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['qq']);
                    $_POST['keywords']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['keywords']);
                    $_POST['description']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['description']);
                    $_POST['weblogo']=preg_replace('/'.$value['badword'].'/i',$value['weblogo'], $_POST['weblogo']);
                    $_POST['webqrcode']=preg_replace('/'.$value['badword'].'/i',$value['webqrcode'], $_POST['webqrcode']);
                    $_POST['tbshopurl']=preg_replace('/'.$value['badword'].'/i',$value['tbshopurl'], $_POST['tbshopurl']);
                    $_POST['ppshopurl']=preg_replace('/'.$value['badword'].'/i',$value['ppshopurl'], $_POST['ppshopurl']);
                    $_POST['tag']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['tag']);
                    $_POST['content']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['content']);
                }else{
                    $_POST['pubaccount']=preg_replace('/'.$value['badword'].'/i','', $_POST['pubaccount']);
                    $_POST['wxaccount']=preg_replace('/'.$value['badword'].'/i','', $_POST['wxaccount']);
                    $_POST['ghweixin']=preg_replace('/'.$value['badword'].'/i','', $_POST['ghweixin']);
                    $_POST['website']=preg_replace('/'.$value['badword'].'/i','', $_POST['website']);
                    $_POST['sinaweibo']=preg_replace('/'.$value['badword'].'/i','', $_POST['sinaweibo']);
                    $_POST['tencentweibo']=preg_replace('/'.$value['badword'].'/i','', $_POST['tencentweibo']);
                    $_POST['realname']=preg_replace('/'.$value['badword'].'/i','', $_POST['realname']);
                    $_POST['phone']=preg_replace('/'.$value['badword'].'/i','', $_POST['phone']);
                    $_POST['qq']=preg_replace('/'.$value['badword'].'/i','', $_POST['qq']);
                    $_POST['title']=preg_replace('/'.$value['badword'].'/i','', $_POST['title']);
                    $_POST['keywords']=preg_replace('/'.$value['badword'].'/i','', $_POST['keywords']);
                    $_POST['description']=preg_replace('/'.$value['badword'].'/i','', $_POST['description']);
                    $_POST['weblogo']=preg_replace('/'.$value['badword'].'/i','', $_POST['weblogo']);
                    $_POST['webqrcode']=preg_replace('/'.$value['badword'].'/i','', $_POST['webqrcode']);
                    $_POST['tbshopurl']=preg_replace('/'.$value['badword'].'/i','', $_POST['tbshopurl']);
                    $_POST['ppshopurl']=preg_replace('/'.$value['badword'].'/i','', $_POST['ppshopurl']);
                    $_POST['tag']=preg_replace('/'.$value['badword'].'/i','', $_POST['tag']);
                    $_POST['content']=preg_replace('/'.$value['badword'].'/i','', $_POST['content']);
                }
                
            }
            
            //上传附件
            $this->_upload();
            
            if (false === $model->create()) {
                $this->error($model->getError());
            }
            
            $model->typeid=1;
            $model->status=  2;
            $model->memberid=  session('id');
            $model->membername=  session('account');
            //保存当前数据对象
            $list = $model->save();
            
            if ($list !== false) {
                //添加消费记录
                $Payspend=M('Payspend');
                $data['memberid']=session('id');
                $data['membername']=session('account');
                $data['type']=2;
                $data['value']=$intergral;
                $data['msg']="修改二维码";
                $data['create_time']=time();
                $Payspend->add($data);

                //扣除用户积分
                $mapmember['id']=session('id');
                $mapmember['account']=  session('account');
                D("Member")->where($mapmember)->setDec('intergral',$intergral); // 用户的积分减
                $this->success('保存成功!',U('Member/manage'));
            } else {
                $this->error('保存失败!');
            }
            
            
        }else{
			$User=D("Member");
			$data=$User->where($map)->find();
			$this->data=$data;
            $cate=new WeixinModel();
            $menu1 =$cate->getModelCategory('Weixin'); //加载栏目
            $menu = arrToMenu($menu1,0);  
            $this->categorylist=$menu;
            
            //获取最大等级
            $Category=M('Category');
            $maxLevel = $Category->max('level');
            $this->assign('maxLevel',$maxLevel);
            
            //获取省级地区
            $province=D('areas')->where(array('parent_id'=>1))->select();
            $this->assign('province',$province);
            
            $model = M('Weixin');
            $id = $_REQUEST [$model->getPk()];
            $vo = $model->getById($id);
            $this->assign('vodata', $vo);
            
            $this->seo('修改微信公众账号', '', '', 'edit');
            $this->display();
        }
    }
    //公众账号删除
    public function delete() {
        $this->checkUser();
        //删除指定记录
        $model = M('Weixin');
        if (!empty($model)) {
            $pk = $model->getPk();
            $id = $_REQUEST [$pk];
            if (isset($id)) {
                $condition = array($pk => array('in', explode(',', $id)));
                $condition['memberid']=  session('id');
                $condition['membername']=  session('account');
                $list = $model->where($condition)->setField('status', - 1);
                if ($list !== false) {
                    $this->success('操作成功！');
                } else {
                    $this->error('操作失败！');
                }
            } else {
                $this->error('非法操作');
            }
        }
    }
    //公众账号删除
    public function delfile() {
        $this->checkUser();
        
        if(isset($_GET['id'])&&isset($_GET['file'])){
            $id = $_GET['id'];	
            $file=$_GET['file'];

            
            $model = D('Weixin');
            $map['id']=$id;
            $map['memberid']=  session('id');
            $map['membername']=  session('account');
            $src = '__ROOT__Uploads/'.$model->where($map)->getField($file);

            $model->where('id='.$id)->setField($file,'');
            if(is_file($src))unlink($src);
            $this->success('操作成功');
        }
        
        
    }
    //删除图片
    public function delthumb(){
        $this->checkUser();
        
        if(isset($_GET['id'])&&isset($_GET['file'])){
            $id = I('get.id');
            $file=I('get.file');
            
            $name = $this->getActionName();
            $model = D($name);
            
            $src = './Uploads'.$model->where('id='.$id)->getField($file);
            $model->where('id='.$id)->setField($file,'');

            if(is_file($src)) unlink($src);


            $this->success('操作成功');
        }
    }
    //推荐管理
    public function tuijian() {
        $this->checkUser();
        $User=D("Member");
        $data=$User->where($map)->find();
        $this->data=$data;
        
        if(isset($_POST['name'])){
            $map['pubaccount'] = array('like',"%".I('post.name')."%");
        }
        //状态
        if(isset($_POST['zt'])&&$_POST['zt']!=-2){
            $map['status'] = array('eq',I('zt'));
            $this->zt=I('zt');
        }
        $map['memberid']=array('eq',  session('id'));
        $map['membername']=array('eq',  session('account'));
        
        //获取分页设置
        $Model=M('Model');
        $mapmodel['table']=array('eq','Weixin');
        $pageinfo=$Model->where($mapmodel)->find();

        $Form   =   M('Weixin');
        import("@.ORG.Page");       //导入分页类
        $count  = $Form->where($map)->count();    //计算总数
        $Page = new Page($count, $pageinfo['listrows']);
        $list   = $Form->where($map)->limit($Page->firstRow. ',' . $Page->listRows)->order('id desc')->select();

        // 设置分页显示
        $Page->setConfig('header', $pageinfo['header']);
        $Page->setConfig('first', $pageinfo['first']);
        $Page->setConfig('last', $pageinfo['last']);
        $Page->setConfig('prev', $pageinfo['prev']);
        $Page->setConfig('next', $pageinfo['next']);
        $Page->setConfig('theme',$pageinfo['theme']);
        $page = $Page->show();
        
        $this->assign("page", $page);
        $this->assign("list", $list);

        $this->seo('微信公众账号管理', '', '', 'tuijian');
        $this->display(); 
        
    }
    //公众账号推荐
    public function addtj() {
        $this->checkUser();

        if(IS_POST){
            
            $model = D('Tuijian');
            
            $wxid=I('post.wxid');
            if(isset($wxid)){
                $map['id']=array('eq',$wxid);
                $status=D('Weixin')->where($map)->getField('status');
                if($status!=1){
                    $this->error('操作错误');
                }
            }else{
                $this->error('操作错误');
            }
            
           
            
            $_POST['wxid']=$wxid;
            $_POST['pubaccount']=  getWeixinName($wxid);
            $recommendid=I('post.recommendid');
            $_POST['recommendid']=$recommendid;
            $starttime=strtotime(I('post.starttime'));
            $_POST['starttime']=$starttime;
            $_POST['endtime']=strtotime(I('post.endtime'));
            $intergralnum=  getIntergral($_POST['recommendid']);
            
             //推荐天数
            $time1 = $_POST['starttime'];
            $time2 = $_POST['endtime'];
            if($time1>$time2){
                $this->error('开始日期大于结束日期');
            }
            
            $time = ($time2-$time1)/(24*3600)+1;
            
            //扣除积分
            $intergral=$time*$intergralnum;
            
            //查询用户当前积分
            $mapmember['id']=array('eq',  session('id'));
            $mapmember['account']=array('eq',  session('account'));
            $curintergral=D('Member')->where($mapmember)->getField('intergral');
            if($intergral>$curintergral){
                $this->error('当前用户积分不够！');
            }
            
            //判断是否已经推荐
            $maptj['wxid']=array('eq',$wxid);
            $maptj['endtime']=array('gt',$starttime);
            $maptj['recommendid']=array('eq',$recommendid);
            
            $istj=D('tuijian')->where($maptj)->find();
            if(!empty($istj)){
                $this->error('已推荐过了');
            }
            
            
            if (false === $model->create()) {
                $this->error($model->getError());
            }
            $model->timelimit=1;
            $model->intergral=$intergral;
            $model->intergralnum=$intergralnum;
            $model->memberid=  session('id');
            $model->membername=  session('account');
           
            //保存当前数据对象
            $list = $model->add();
            if ($list !== false) { //保存成功
            
                if($intergral>0){
                    //添加消费记录
                    $Payspend=M('Payspend');
                    $data['memberid']=session('id');
                    $data['membername']=session('account');
                    $data['type']=2;
                    $data['value']=$intergral;
                    $data['msg']="自助推荐";
                    $data['create_time']=time();
                    $Payspend->add($data);

                    //扣除用户积分
                    D("Member")->where($mapmember)->setDec('intergral',$intergral); // 用户的积分减5
                }
                
                $this->success('提交成功!',U('Member/tjlist'));
                
            } else {
                //失败提示
                $this->error('提交失败!');
            }
        }  else {

			$User=D("Member");
			$data=$User->where($map)->find();
			$this->data=$data;
            $Model=M('Weixin');
            $map['memberid']=  session('id');
            $map['membername']=  session('account');
            $map['status']=array('eq',1);
            $pubaccountlist=$Model->where($map)->select();
            
             //推荐方式
            $maprecommend['status']=array('eq',1);
            $recommendlist=D('Recommend')->where($maprecommend)->order('listorder')->select();
            
            
            $this->assign('pubaccountlist',$pubaccountlist);
            $this->assign('recommendlist',$recommendlist);
            $this->seo('自助推荐', '', '', 'tjlist');
            $this->display();
        }
        
    }
    
    //公众账号管理
    public function tjlist() {
        $this->checkUser();
        $User=D("Member");
        $data=$User->where($map)->find();
        $this->data=$data;
        if(isset($_POST['name'])){
            $map['pubaccount'] = array('like',"%".I('post.name')."%");
        }
        //状态
        if(isset($_POST['zt'])&&$_POST['zt']!=-2){
            $map['status'] = array('eq',I('zt'));
            $this->zt=I('zt');
        }
        $map['memberid']=array('eq',  session('id'));
        $map['membername']=array('eq',  session('account'));
        
        //获取分页设置
        $Model=M('Model');
        $mapmodel['table']=array('eq','Weixin');
        $pageinfo=$Model->where($mapmodel)->find();

        $Form   =   M('Tuijian');
        import("@.ORG.Page");       //导入分页类
        $count  = $Form->where($map)->count();    //计算总数
        $Page = new Page($count, $pageinfo['listrows']);
        $list   = $Form->where($map)->limit($Page->firstRow. ',' . $Page->listRows)->order('create_time desc')->select();

        // 设置分页显示
        $Page->setConfig('header', $pageinfo['header']);
        $Page->setConfig('first', $pageinfo['first']);
        $Page->setConfig('last', $pageinfo['last']);
        $Page->setConfig('prev', $pageinfo['prev']);
        $Page->setConfig('next', $pageinfo['next']);
        $Page->setConfig('theme',$pageinfo['theme']);
        $page = $Page->show();
        
        $this->assign("page", $page);
        $this->assign("list", $list);

        $this->seo('自助推荐', '', '', 'tjlist');
        $this->display(); 
        
    }
    //促销活动管理
    public function promotionlist() {
        $this->checkUser();
        $User=D("Member");
        $data=$User->where($map)->find();
        $this->data=$data;
        if(isset($_POST['name'])){
            $map['title'] = array('like',"%".I('post.name')."%");
        }
        //状态
        if(isset($_POST['zt'])&&$_POST['zt']!=-2){
            $map['status'] = array('eq',I('zt'));
            $this->zt=I('zt');
        }
        $map['memberid']=array('eq',  session('id'));
        $map['membername']=array('eq',  session('account'));
        
        //获取分页设置
        $Model=M('Model');
        $mapmodel['table']=array('eq','Promotion');
        $pageinfo=$Model->where($mapmodel)->find();

        $Form   =   M('Promotion');
        import("@.ORG.Page");       //导入分页类
        $count  = $Form->where($map)->count();    //计算总数
        $Page = new Page($count, $pageinfo['listrows']);
        $list   = $Form->where($map)->limit($Page->firstRow. ',' . $Page->listRows)->order('create_time desc')->select();

        // 设置分页显示
        $Page->setConfig('header', $pageinfo['header']);
        $Page->setConfig('first', $pageinfo['first']);
        $Page->setConfig('last', $pageinfo['last']);
        $Page->setConfig('prev', $pageinfo['prev']);
        $Page->setConfig('next', $pageinfo['next']);
        $Page->setConfig('theme',$pageinfo['theme']);
        $page = $Page->show();
        
        $this->assign("page", $page);
        $this->assign("list", $list);

        $this->seo('促销活动', '', '', 'promotionlist');
        $this->display(); 
        
    }

    //促销活动添加
    public function promotionadd() {
        $this->checkUser();
        if(IS_POST){
            $intergral=C('XFINTERGRAL');
            
            $model = D('Promotion');
            $_POST['title']=I('post.title');
            $_POST['content']=I('post.content');
            $_POST['sitetitle']=I('post.sitetitle');
            $_POST['keywords']=I('post.keywords');
            $_POST['description']=I('post.description');
            
            //如果标题为空，默认填写公众帐号
            if(empty($_POST['sitetitle'])){
                $_POST['sitetitle']=  I('post.title');
            }
            
            //敏感词过滤
            $Badword=D('Badword');
            $Badwordlist=$Badword->select();
            foreach ($Badwordlist as $key => $value) {
                if($value['level']==1){
                    $_POST['title']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['title']);
                    $_POST['content']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['content']);
                    $_POST['sitetitle']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['sitetitle']);
                    $_POST['keywords']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['keywords']);
                    $_POST['description']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['description']);
                   
                }else{
                    $_POST['title']=preg_replace('/'.$value['badword'].'/i','', $_POST['title']);
                    $_POST['content']=preg_replace('/'.$value['badword'].'/i','', $_POST['content']);
                    $_POST['sitetitle']=preg_replace('/'.$value['badword'].'/i','', $_POST['sitetitle']);
                    $_POST['keywords']=preg_replace('/'.$value['badword'].'/i','', $_POST['keywords']);
                    $_POST['description']=preg_replace('/'.$value['badword'].'/i','', $_POST['description']);
                  
                }
                
            }
            
            //上传图片
            $this->_upload();
            
            if (false === $model->create()) {
                $this->error($model->getError());
            }
            $model->intergral=$intergral;
            $model->memberid=  session('id');
            $model->membername=  session('account');
            //保存当前数据对象
            $list = $model->add();
            if ($list !== false) { //保存成功
                if($intergral>0){
                    //添加消费记录
                    $Payspend=M('Payspend');
                    $data['memberid']=session('id');
                    $data['membername']=session('account');
                    $data['type']=2;
                    $data['value']=$intergral;
                    $data['msg']="促销活动";
                    $data['create_time']=time();
                    $Payspend->add($data);
                
                    //扣除用户积分
                    $mapmember['id']=session('id');
                    $mapmember['account']=  session('account');
                    D("Member")->where($mapmember)->setDec('intergral',$intergral); // 用户的积分减5
                }
                
                $this->success('提交成功!',U('Member/promotionlist'));
                
            } else {
                //失败提示
                $this->error('提交失败!');
            }
        }  else {
			$User=D("Member");
			$data=$User->where($map)->find();
			$this->data=$data;
            $Model=M('Weixin');
            $map['memberid']=  session('id');
            $map['membername']=  session('account');
            $map['status']=array('eq',1);
            $pubaccountlist=$Model->where($map)->select();
            
            $catid=I('get.catid',0,int);
            if($catid==0){
                $this->error('操作错误');  
            }
            $this->assign('catid',$catid);
            $this->assign('pubaccountlist',$pubaccountlist);
            $this->seo('添加促销活动', '', '', 'promotionlist');
            $this->display();
        }
        
    }
    //促销活动修改
    public function promotionedit() {
        $this->checkUser();
        if(IS_POST){
            
            $model = D('Promotion');
            
            $_POST['title']=I('post.title');
            $_POST['content']=I('post.content');
            $_POST['sitetitle']=I('post.sitetitle');
            $_POST['keywords']=I('post.keywords');
            $_POST['description']=I('post.description');
            
            //如果标题为空，默认填写公众帐号
            if(empty($_POST['sitetitle'])){
                $_POST['sitetitle']=  I('post.title');
            }
            
            //敏感词过滤
            $Badword=D('Badword');
            $Badwordlist=$Badword->select();
            foreach ($Badwordlist as $key => $value) {
                if($value['level']==1){
                    $_POST['title']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['title']);
                    $_POST['content']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['content']);
                    $_POST['sitetitle']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['sitetitle']);
                    $_POST['keywords']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['keywords']);
                    $_POST['description']=preg_replace('/'.$value['badword'].'/i',$value['replaceword'], $_POST['description']);
                   
                }else{
                    $_POST['title']=preg_replace('/'.$value['badword'].'/i','', $_POST['title']);
                    $_POST['content']=preg_replace('/'.$value['badword'].'/i','', $_POST['content']);
                    $_POST['sitetitle']=preg_replace('/'.$value['badword'].'/i','', $_POST['sitetitle']);
                    $_POST['keywords']=preg_replace('/'.$value['badword'].'/i','', $_POST['keywords']);
                    $_POST['description']=preg_replace('/'.$value['badword'].'/i','', $_POST['description']);
                  
                }
                
            }
            //上传图片
            $this->_upload();
            
            if (false === $model->create()) {
                $this->error($model->getError());
            }
            
            $model->memberid=  session('id');
            $model->membername=  session('account');
            //保存当前数据对象
            $list = $model->save();
            
            if ($list !== false) {
                $this->success('保存成功!',U('Member/promotionlist'));
            } else {
                $this->error('保存失败!');
            }
            
        }else{
			$User=D("Member");
			$data=$User->where($map)->find();
			$this->data=$data;
            $Model=M('Weixin');
            $map['memberid']=  session('id');
            $map['membername']=  session('account');
            $map['status']=array('eq',1);
            $pubaccountlist=$Model->where($map)->select();
            
            $model = M('Promotion');
            $id = $_REQUEST [$model->getPk()];
            $vo = $model->getById($id);
            
            $this->assign('pubaccountlist', $pubaccountlist);
            $this->assign('vo', $vo);

            $this->seo('修改促销活动', '', '', 'promotionlist');
            $this->display();
        }
    }
    
    

}
?>