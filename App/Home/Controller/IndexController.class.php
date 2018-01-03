<?php
namespace Home\Controller;
class IndexController extends MainController {
    /**
     * 拼采廉首页
     * @param 2017-12-12 11:23:22
     */
    public function index(){
        if(!$_POST){
            $cate = D('goods_supply_cate')->get_goods_supply_cate(0);
            $this->assign('cate',$cate);               

            $banner = D('banner')->get_banner_info();  
            $this->assign('banner',$banner); 

            #未登陆
            if(parent::$uid <1)
                $gourl = U('Login/index',['reurl'=>urlencode(getFullUrl())]);
            else{
                #判断是否店家用户  grade==1 店长  grade==0 普通 
                $grade = M('user_estate')->where(['id'=>parent::$uid])->getField('grade');
                $this->assign('grade',$grade); 

                if(!$grade){
                    $res = D('shop_register_record')->get_shop_register(parent::$uid); 
          
                    if($res['status']){
                        if(empty($res['data']))  $gourl = U('Group/authentication'); 
                        else{
                            if($res['data']['state']==2){  
                                #认证失败
                                $gourl = U('Group/authentication_fail');
                            }else if($res['data']['state']<2){
                                #认证成功
                                $gourl = U('Group/authentication_list');
                            }
                        }
                    }else{
                        $this->error($res['msg']);
                    }
                }
            }
            
            $this->assign('authentication',$gourl);
            exit($this->display('Index/index'));
        }


        #商品
        $page = I('post.page',1);
        $goods = D('goods_open_group')->get_index_goods($page,I('post.guser_limit'));
        $this->ajaxReturn($goods);
    }

    /**
     * 抢红包展示页面
     * @param 2017/12/25
     */
    public function envelopes(){
        if(!$_POST){
            $token = I('get.token',0);
            $this->assign('token',$token);

            $res = D('red_packet')->get_red_packet_info($token);
            if($res['status']) $this->assign('data',$res['msg']);
            else $this->error($res['msg']);

            //p($res);
            exit($this->display('Order/envelopes'));
        }
    }

    
    /**
     * 团详情
     * @param 2017-12-19
     */
    public function regiment_details(){
         
        #判断是否本人打开  or  分享给他人打开
        $user['uid'] = parent::$uid;
        $this->assign('user',$user);


        $grid = I('get.grid',0);
        $res = D('goods_open_group')->get_group_detail($grid);

        if(!$res["status"]){

            $this->error($res['msg']);
        }
        $this->assign('data',$res['data']);   //dump($res['data']);
        $this->display('Index/regiment_details');
    }

    /**
     * 分享出去的团详情
     * @param 2017-12-29 15:33:10
     */
    public function share_regiment_details()
    {

        $grid = I('get.grid',0);
        $res = D('goods_open_group')->get_group_detail($grid);

        if(!$res["status"]){

            $this->error($res['msg']);
        }
        $this->assign('share',1);
        $this->assign('data',$res['data']);   //dump($res['data']);
        $this->display('Index/regiment_details');
    }

    /**
     * 立即拼团 -  商品详情
     * @param 2017-12-15 11:08:45
     */
    public function group(){
        if(!$_POST){
            // #判断是否本人打开  or  分享给他人打开
            $user['uid'] = parent::$uid; 
            $user['pid'] = I('get.pid'); 
            $this->assign('user',$user);


            $post = I('get.gid');  //商品开团记录 id
            $res  = D('goods_open_group')->get_goods_detail($post);  //dump($res['data']);
            
            if(!$res["status"]){
                $this->error($res['msg']);
            }
            $this->assign('data',$res['data']);  
            $this->assign('id',$post);   //商品开团记录 id
            $this->assign('gourl',U('Login/index',['reurl'=>urlencode(getFullUrl())]));
            exit($this->display('Index/group'));
        }

        
        #未登陆
        if(empty(parent::$uid)) $this->ajaxReturn(['status'=>-1,'msg'=>"您还未登录，请登录"]);
        $post = I('post.');
        $res = D('goods_open_group_order')->check_buy_goods($post);

        if($res["status"]) session('orderInfo',$res["data"]);
        $this->ajaxReturn($res);
    }


    /**
     * 消费团   店家团
     * 进入店铺-店铺开团列表
     * @param 2017-12-15 17:30:25
     */
    public function shop(){
        if(!$_POST){
            $id = I('get.id');
            $data = [];
            if(!empty($id)){
                $data['sid'] = $id; //店铺id

                $sname = M('user_shop')->where(['id'=>$id])->getField('sname');
                $this->assign('sname',$sname);
            }

            $guser_limit = I('get.guser_limit',0);
            if(strlen($guser_limit)>0){
                $data['guser_limit'] = $guser_limit;
                if($guser_limit==1){ $this->assign('sname','店家进'); }
                else if($guser_limit==0){ $this->assign('sname','消费进'); }
            }
            
            $this->assign('data',json_encode($data));  
            exit($this->display('Index/shop'));
        }

        //$sid(店铺id),page
        $post = I('post.');
        $res  = D('goods_open_group')->get_goods_list($post);
        $this->ajaxReturn($res);
    }
    
    /**
     * 显示分享图片
     * @param 2017-12-29 15:15:18
     */
    public function show_group_img()
    {
        $imgdata = base64_decode(I('get.imgdata')); 
        $this->assign('imgdata',$imgdata);
        $this->display();
    }
}