<?php
namespace Admin\Controller;
use Think\Controller;
class GoodsSupplyController extends RunController {
    /**
     * 供货商拼团商品列表
     * @param 2017-12-11 18:17:22
     */
    public function goods_list()
    {
        $pageSize = 25;
        $limit = getLimit($pageSize);

        $status = I('post.status'); #To determine whether the data is exported
        if($status) $limit = ''; #Export all data under current conditions

        #搜索条件
        $search = $this->search_goods_list();
        $where = $search['where'];

        #查询数据
        $Model = M('goods_open_group');
        $field = "o.*";
        $data  = $Model->alias('o')
            ->where($where)->field($field)
            ->order('id desc')->limit($limit)->select();
        $this->assign('data',$data);

        #分页
        $count = $Model->alias('o')
            ->where($where)->count();
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

    private function search_goods_list()
    {
        $assign = [];
        $where['_string'] = ' 1=1 ';

        $assign['gname'] = $gname = $_POST['gname'] ? I('post.gname') : I('get.gname');
        if(!empty($gname)){
            $where['_string'] .= " and gname like '%".$gname."%'";
        }

        #开始时间
        $assign['stime'] = $stime = $_POST['stime'] ? I('post.stime') : I('get.stime');
        if(!empty($stime)){
            $where['_string'] .= ' and UNIX_TIMESTAMP(o.gaddtime)>'.strtotime($stime);
        }
        #结束时间
        $assign['dtime'] = $dtime = $_POST['dtime'] ? I('post.dtime') : I('get.dtime');
        if(!empty($dtime)){
            $where['_string'] .= ' and UNIX_TIMESTAMP(o.gaddtime)<'.(strtotime($dtime)+3600*24);
        }

        #状态
        $assign['state'] = $state = isset($_POST['state']) ? I('post.state') : I('get.state');
        if(strlen(trim($state))>0){
            $where['_string'] .= " and o.gstatus = '{$state}'";
        }

        $this->assign('assign',$assign);
        $assign['where'] = $where;

        return $assign;
    }

    /**
     * 供货商拼团商品审核
     * @param 2017-12-11 18:17:51
     */
    public function goods_status_list()
    {
        $where = ['gstatus'=>1];
        $Model = M('goods_supply');
        $pageSize = 25;
        $limit = getLimit($pageSize);

        $data = $Model->where($where)->order('id desc')->limit($limit)->select();
        $this->assign('data',$data);

        #分页
        $count = $Model->alias('o')->where($where)->count();
        $this->assign('count',$count);
     
        $Page  = new \Think\Page($count,$pageSize,$where); 
        $show  = $Page->show(); 
        $this->assign('page',$show);
        $this->display(); 
    }
    /**
     * 更改供货商商品审核状态
     * @param 2017-12-12 10:15:02
     */
    public function up_goods_supply_status()
    {
        $post = I('post.');
        $res = D('goods_supply')->up_goods_supply_status($post);
        $this->ajaxReturn($res);
    }
}