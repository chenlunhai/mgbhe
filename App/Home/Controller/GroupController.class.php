<?php
namespace Home\Controller;
use Think\Controller;

class GroupController extends RunController{

    /**
     * 不是店家，去认证
     * @param 2017-12-26
     */
    public function authentication(){
        if(!IS_POST){
            $res = D('shop_register_record')->get_shop_register(parent::$uid);  
    //p($res); 
            $this->assign('data',$res['data']);
            exit($this->display());
        }
        $post = I('post.');
        $post['uid'] = parent::$uid;
        $res = D('shop_register_record')->add_shop_register($post);
        $this->ajaxReturn($res);
    }

    /**
     * 认证失败
     * @param 2017-12-26
     */
    public function authentication_fail(){
        if(!$_POST){
            exit($this->display());
        }
    }

    /**
     * 认证成功
     * @param 2017-12-26
     */
    public function authentication_list(){
        if(!$_POST){ 
            $res = D('shop_register_record')->get_shop_register(parent::$uid);  
            if($res['status']){
                $this->assign('data',$res['data']);  //p($res);
            }else{
                $this->error($res['msg']);
            }
    
            exit($this->display());
        }
    }
   

    public function test(){
        $page = I('post.page',1);
        $goods = D('goods_open_group')->get_index_goods($page);
        $this->ajaxReturn($goods);
    }


    /**
	 * 拼采廉商品列表
	 * @param 2017-12-14 18:07:22
	 */
    public function classification(){
    	if(!$_POST){
            #当前分类id
            $gcid = I('get.gcid',0);
            $this->assign('gcid',$gcid);  //p($gcid);

            /*#1级分类
            $cate = D('goods_supply_cate')->get_goods_supply_cate(0);
            $this->assign('cate',$cate);  //dump($cate);

            #2级分类 key为一级分类id
            $subCate = [];
            foreach ($cate as $key => $value) {
                $subCate[$value['id']] = D('goods_supply_cate')->get_goods_supply_cate($value['id']);
            }
            $this->assign('subCate',$subCate);  */

            exit($this->display());
    	}
    	
        $post = I('post.');   //gcid,gname,page字段
        
        $res  = D('goods_open_group')->get_goods_list($post);
        $this->ajaxReturn($res);
    }

    /**
     * 拼采廉商品列表
     * @param 2017-12-27 18:07:22
     */
    public function search(){
        if(!$_POST){

            #所有分类
            $cate = D('goods_supply_cate')->get_goods_supply_cates();

        //p($cate);

            if($cate['status']){
                $this->assign('data',$cate['data']);  
            }else  $this->error($cate['msg']);

            exit($this->display());
        }

    }

    /**
     * 我的团
     * @param 2017-12-19
     */
    public function regiment(){

        if(!$_POST){
            $state = I('get.state',0);
            $this->assign('state',$state);

            exit($this->display());
        }

        $post = I('post.');
        $post['uid'] = parent::$uid;   
        $res = D('goods_open_group_order')->get_group_order($post);
        $this->ajaxReturn($res);
    }


    /**
     * 订单列表
     * @param 2017-12-19
     */
    public function order_list(){
        if(!$_POST){
            $state = I('get.state',-1);
            $this->assign('state',$state); 
            exit($this->display());
        }

        $post = I('post.');  
        $post['uid'] = parent::$uid;
        
        $res = D("goods_open_group_order")->get_user_order($post);
        $this->ajaxReturn($res);
    }

    /**
     * 订单列表
     * @param 2017-12-19
     */
    public function order_details(){
    
        $post = [];
        $post['osn'] = I('get.osn',0);
        $post['uid'] = parent::$uid;
        $res = D('goods_open_group_order')->get_order_detail($post);
        if(!$res["status"]){
            $this->error($res['msg']);
        }
        $this->assign('data',$res['data']);   //dump($res['data']);
        $this->display();
      
    }

    /**
     * 返回团详情分享所需图片
     * @param 2017-12-29 14:38:35
     */
    public function get_group_sahre()
    {
        $post = I('post.');
        $post['uid'] = parent::$uid;
        $res = D('goods_open_group')->merge_img_share_group($post);

        if($res['status'] != 1) $this->ajaxReturn($res);

        $res['url'] = U("Index/show_group_img",['imgdata'=>base64_encode($res['msg'])]);
        $this->ajaxReturn($res);
    }
}