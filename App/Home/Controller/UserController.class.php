<?php
namespace Home\Controller;
use Think\Controller;
use Common\Service\WrcsService;
use Common\Service\SjbService;
class UserController extends RunController {

    /**
     * 查看我的收益
     * @param 2017/11/11
     */
    public function show_cds_profit()
    {
        if(!IS_POST){
            exit($this->display());
        }
    }
    /**
     * 返回进入数钜宝链接
     * @param 2017/11/11
     */
    public function go_cds()
    {
        $SjbService = new SjbService();
        $res = $SjbService->get_go_cds_url(parent::$uid);
        $this->ajaxReturn($res);
    }
    /**
     * 获取数钜宝今日新增米米
     * @param 2017-11-11 22:18:42
     */
    public function get_today_add_money()
    {
        $SjbService = new SjbService();
        $res = $SjbService->get_today_add_money(parent::$uid);
        $this->ajaxReturn($res);
    }
    /**
     * 麦光宝盒超市开门动作
     * @param 2017/11/10
     */
    public function opendoor()
    {
       if(!IS_POST){
        exit($this->display());
       }
       $mobile = M('user_account')->where(['id'=>parent::$uid])->getField('mobile');
       $WrcsService =  new WrcsService();
       $res = $WrcsService->opendoor($mobile);
       $this->ajaxReturn($res);
    }
    /**
     * 蚂蚁盒子开门动作
     * @param 2017-12-1 14:55:28
     */
    public function box_opendoor()
    {
       if(!IS_POST){
        $user = D('user_estate')->get_user_estate(parent::$uid,'balance');
        $this->assign('user',$user);
        exit($this->display());
       }
       $res = D('myhz_order')->get_box_open(['uid'=>parent::$uid,'bid'=>'73183069290']);    #盒子id暂时固定，只有一台
       $this->ajaxReturn($res);
    }
	/**
	 * 申请开店--成为店主 
	 * @param 2017/11/2
	 */
    public function apply(){
    	if(!IS_POST){
            #当前用户
            $id = parent::$uid;
            $shop_register_record = D('shop_register_record')->where(['uid'=>$id])->order('id desc')->limit('1')->find();
            $this->assign('user',$shop_register_record);
            exit($this->display());
        }
        $post = I('post.');
        $post['uid']=parent::$uid;
        $res  = D('user_account')->create_shop($post);
        $this->ajaxReturn($res);
    }

    /**
     * 我的店铺 
     * @param 2017/11/9
     */
    public function shop(){
       $this->display();
    }

    /**
     * 我的店铺-店铺详情 
     * @param 2017/11/9
     */
    public function details(){
        $this->display();
    }

    /**
     * 设置---个人设置
     * @param 2017/11/3
     */
    public function set_up(){
        $User = D('user_account');
        if(!IS_POST){
            $user = $User->where(['id'=>parent::$uid])->field('realname,mobile,pcode')->find();
            #获得用户推荐人名称
            $pname = $User->get_puser_name($user['pcode']);
            $user['prealname'] = $pname['msg'];
           
            $this->assign('data',$user);
            exit($this->display());
        }
        $post = I('post.');
        $post['uid']=parent::$uid;
        $res  = $User->up_user_detail($post);
        $this->ajaxReturn($res);
    }


    /**
     * 会员中心
     * @param 2017/11/3
     */
    public function personal(){
        $id = parent::$uid;
        $user = D('user_account')->where(['id'=>$id])->find();
        #判断 当前用户是否已经成功申请店铺
        $count = D('shop_register_record')->where(['uid'=>$id,'state'=>1])->order('id desc')->limit('1')->count();
        $user['is_shoper'] = $count?1:0;
        $user['estate_info'] = D('user_estate')->get_user_estate($id,'balance');
        
        $this->assign('user',$user);  //p($user);
        $this->display();
    }

    /**
     * 我的钱包
     * @param 2017/12/23
     */
    public function my_wallet(){

        if(!IS_POST){
            $user = D('user_estate')->get_user_estate(parent::$uid,'balance,integral,total_balance,total_consumption');
            $this->assign('user',$user);
            exit($this->display());
        }
    }

    /**
     * 充值
     * @param 2017/12/25
     */
    public function recharge(){
        if(!IS_POST){
            $data = D('user_account')->where(['id'=>parent::$uid])->field('id,realname,mobile')->find();
            $this->assign('data',$data);
            exit($this->display());
        }

        $post = I('post.');
        $post['uid'] = parent::$uid;
        $res  = D('order_balance')->pay_balance($post);
        $this->ajaxReturn($res);
    }

    /**
     * 提现
     * @param 2017/12/25
     */
    public function withdrawals(){
        if(!IS_POST){
            D('user_account')->where(['u.id'=>parent::$uid])->join('u left join __USER_ESTATE__ as e on u.id=e.id')->field('u.id,u.realname,e.balance')->find();
            exit($this->display());
        }
    }

    /**
     * 余额详情
     * @param 2017/12/25
     */
    public function balance_details(){
        if(!IS_POST){
            exit($this->display());
        }

        $page = I('post.page',1);
        $limit = D('goods_open_group')->getLimit($page);
        $data = M('balance_record')->where(['uid'=>parent::$uid])->field('id,money,remark,addtime')->limit($limit)->select();
        $this->ajaxReturn(['status'=>1,'data'=>$data]);
    }

    /**
     * 积分详情
     * @param 2017/12/25
     */
    public function integral_details(){
        if(!IS_POST){
            exit($this->display());
        }

        $page = I('post.page',1);
        $limit = D('goods_open_group')->getLimit($page);
        $data = M('integral_record')->where(['uid'=>parent::$uid])->field('id,money,remark,addtime')->limit($limit)->select();
        $this->ajaxReturn(['status'=>1,'data'=>$data]);
    }

    /**
     * 换余额
     * @param 2017/12/25
     */
    public function balance(){
        if(!IS_POST){
            $data = M('user_estate')->where(['id'=>parent::$uid])->field('integral')->find();
            $this->assign('data',$data);
            exit($this->display());
        }
    }

    /**
     * 积分详情
     * @param 2017/12/25
     */
    /*public function jifen(){
        if(!IS_POST){
            
            exit($this->display());
        }
    }*/



    /**
     * 我的钱包 version 1.0
     * @param 2017/11/11
     */
    public function my_wallet0()
    {
        if(!IS_POST){
            $user = D('user_estate')->get_user_estate(parent::$uid,'balance,total_balance,total_consumption');
            $this->assign('user',$user);
            exit($this->display());
        }
        $post = I('post.');
        $post['uid'] = parent::$uid;
        $post['out_trade_type'] = 1;
        $res  = D('order_balance')->pay_balance($post);
        $this->ajaxReturn($res);
    }

    /**
     * 我的钱包-查明细
     * @param 2017/11/9
     */
    public function detailed(){
        $this->display();
    }


    /**
     * 故障报修
     * @param 2017/11/9
     */
    public function repair(){
        $this->display();
    }


    /**
     * 查看营业额明细
     * @param 2017/11/9
     */
    public function turnover(){
        $this->display();
    }
    
}