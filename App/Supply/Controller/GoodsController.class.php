<?php
namespace Supply\Controller;
use Think\Controller;
use Common\Model\AreaModel;
class GoodsController extends SeachController {
    /** 店主列表 */
    public function goods_list(){
    	$pageSize = 25;    
        $limit = getLimit($pageSize);

        $status = I('post.status'); #To determine whether the data is exported
        if($status) $limit = ''; #Export all data under current conditions

        
        
        #查询数据
        $Model = M('goods_supply');
        $data  = $Model->where($where)->order('id desc')->limit($limit)->select();
        $this->assign('data',$data);

        /*#导出数据
        if($status) exit($this->ExportShopRecord($data,$search['time'],$shop['name']));*/

        #分页
        $count = $Model->alias('o')->where($where)->count();
        $this->assign('count',$count);
        unset($search['_string'],$search['where']);
        $Page  = new \Think\Page($count,$pageSize,$search); 
        /*foreach ($search as $key => $value) {
            $Page->parameter[$key] = ($value);
        }*/
        $show  = $Page->show(); 
        $this->assign('page',$show);
        $this->display();
    }
    /**
     * 添加或编辑拼团商品
     * @param 2017-12-9 17:01:13
     */
    public function goods_add()
    {
        if(!IS_POST){
            $id = I('get.id');
            $goods = M('goods_supply')->find($id);
            $this->assign('data',$goods);

            $AreaModel = new AreaModel;
            $area = $AreaModel->get_open_area();
            $this->assign('area',$area['msg']);

            $cate = D('goods_supply')->get_goods_supply_cate();
            $this->assign('cate',$cate);
            
            exit($this->display());
        }
        $post = I('post.');
        $post['did'] = parent::$adminid; 
        if($post['id'] > 0){    #编辑操作
            $res = D('goods_supply')->up_goods_supply($post);
        }else{  #添加操作
            $res = D('goods_supply')->add_goods_supply($post);
        }
        $this->msg($res['status'],$res['msg']);
    }
    /**
     * 删除商品
     * @param 2017-12-11 17:30:13
     */
    public function del_goods_supply()
    {
        $post = I('post.');
        $post['did'] = parent::$adminid;
        $res = D('goods_supply')->del_goods_supply($post);
        $this->ajaxReturn($res);
    }
    /**
     * 删除商品规格
     * @param 2017-12-11 17:31:14
     */
    public function del_goods_supply_attr()
    {
        $post = I('post.');
        $res = D('goods_supply')->del_goods_supply_attr($post);
        $this->ajaxReturn($res);
    }
    /**
     * 商品提交审核
     * @param 2017-12-25 10:11:13
     */
    public function up_gstatus()
    {
        $post = I('post.id');
        $res = D('goods_supply')->up_gstatus($post);
        $this->ajaxReturn($res);
    }
}