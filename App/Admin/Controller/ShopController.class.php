<?php
namespace Admin\Controller;
use Think\Controller;
class ShopController extends SeachController {
    /** 店主列表 */
    public function shoplist(){
        $pageSize = 25;
        $limit = getLimit($pageSize);

        $status = I('post.status'); #To determine whether the data is exported
        if($status) $limit = ''; #Export all data under current conditions

        #搜索条件
        $search = $this->search_record_list();
        $where = $search['where'];
        //dump($search);

        #查询数据
        $Model = D('shop_record');
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

    /** 店主申请列表 */
    public function shop_register_list(){
        $pageSize = 25;
        $limit = getLimit($pageSize);

        $status = I('post.status'); #To determine whether the data is exported
        if($status) $limit = ''; #Export all data under current conditions

        #搜索条件
        $search = $this->search_register_list();
        $where = $search['where'];
        //dump($search);

        #查询数据
        $Model = D('shop_register_record');
        $join = "".C("DB_PREFIX")."user_estate as b on b.id = o.uid";
        $field = "o.*, b.grade";
        $data  = $Model->alias('o')->join($join)
            ->where($where)->field($field)
            ->order('id desc')->limit($limit)->select();
        $this->assign('data',$data);

        /*#导出数据
        if($status) exit($this->ExportShopRegisterList($data,$search['time'],$shop['name']));*/

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

    /** 查看店主申请用户信息 */
    public function shop_register_show(){
        $id = I('get.id',0);
        if($id < 1) $this->redirect('Shop/shop_register_list');

        $Model = D('user_account');
        $user  = $Model->where(['id'=>$id])->find();
        $this->assign('user',$user);
        $this->display();
    }
}