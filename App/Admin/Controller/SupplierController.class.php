<?php
namespace Admin\Controller;
use Think\Controller;
class SupplierController extends SeachController {
    /** 供应商列表 */
    public function index(){
        $pageSize = 25;
        $limit = getLimit($pageSize);

        $status = I('post.status'); #To determine whether the data is exported
        if($status) $limit = ''; #Export all data under current conditions

        #搜索条件
        $search = $this->search_record_list();
        $where = $search['where'];
        $where2 = array(
            'b.supply_grade' => 1,
        );

        #查询数据
        $Model = M('shop_register_record');
        $join = "".C("DB_PREFIX")."user_estate as b on b.id = o.uid";
        $field = "o.*, b.supply_grade, b.supply_money, b.total_supply_money";
        $data  = $Model->alias('o')->join($join)
            ->where($where)->where($where2)->field($field)
            ->order('id desc')->limit($limit)->select();
        // var_export($Model->getLastSql());die();
        $this->assign('data',$data);

        /*#导出数据
        if($status) exit($this->ExportShopRecord($data,$search['time'],$shop['name']));*/

        #分页
        $count = $Model->alias('o')->join($join)
            ->where($where)->where($where2)->count();
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

    public function order_list(){
        $pageSize = 25;
        $limit = getLimit($pageSize);

        $status = I('post.status'); #To determine whether the data is exported
        if($status) $limit = ''; #Export all data under current conditions

        #搜索条件
        $search = $this->search_order_list();
        $where = $search['where'];

        #查询数据
        $Model = M('goods_open_group_order');
        $joinGroup = "".C("DB_PREFIX")."goods_open_group as g on g.id = o.grid";
        $joinShop = "".C("DB_PREFIX")."user_shop as s on s.id = o.did";
        $field = "o.*,g.gname,g.gimg,s.sname";
        $data  = $Model->alias('o')->join($joinGroup)->join($joinShop)
            ->where($where)->field($field)
            ->order('id desc')->limit($limit)->select();
        // var_export($Model->getLastSql());die();
        $this->assign('data',$data);

        /*#导出数据
        if($status) exit($this->ExportShopRecord($data,$search['time'],$shop['name']));*/

        #分页
        $count = $Model->alias('o')->join($joinGroup)->join($joinShop)
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

    public function revenues(){
        $pageSize = 25;
        $limit = getLimit($pageSize);

        $status = I('post.status'); #To determine whether the data is exported
        if($status) $limit = ''; #Export all data under current conditions

        #搜索条件
        $search = $this->search_revenues();
        $where = $search['where'];
        $where2 = array(
            'o.state' => 0,
        );

        #查询数据
        $Model = M('supply_money_record');
        $joinShop = "".C("DB_PREFIX")."user_shop as s on s.id = o.did";
        $field = "o.*,s.sname";
        $data  = $Model->alias('o')->join($joinShop)
            ->where($where)->where($where2)->field($field)
            ->order('id desc')->limit($limit)->select();
        $this->assign('data',$data);

        /*#导出数据
        if($status) exit($this->ExportShopRecord($data,$search['time'],$shop['name']));*/

        #分页
        $count = $Model->alias('o')->join($joinShop)
            ->where($where)->where($where2)->count();
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

    public function withdrawals(){
        $pageSize = 25;
        $limit = getLimit($pageSize);

        $status = I('post.status'); #To determine whether the data is exported
        if($status) $limit = ''; #Export all data under current conditions

        #搜索条件
        $search = $this->search_withdrawals();
        $where = $search['where'];
        $where2 = array(
            'b.supply_grade' => 1,
        );

        #查询数据
        $Model = M('supply_cash_record');
        $joinUser = "".C("DB_PREFIX")."user_estate as b on b.id = o.uid";
        $joinShop = " LEFT JOIN ".C("DB_PREFIX")."shop_register_record as s on s.uid = o.uid";
        $field = "o.*,s.shopname";
        $data  = $Model->alias('o')->join($joinUser)->join($joinShop)
            ->where($where)->where($where2)->field($field)
            ->order('id desc')->limit($limit)->select();
        $this->assign('data',$data);

        /*#导出数据
        if($status) exit($this->ExportShopRecord($data,$search['time'],$shop['name']));*/

        #分页
        $count = $Model->alias('o')->join($joinUser)
            ->where($where)->where($where2)->count();
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

    public function handle_withdrawal()
    {
        $id = I('post.id');

        $state = I('post.state') ? 2 : 1;

        $Model = new \Think\Model();
        $Model->startTrans();
        try {
            $check_res = check_data(['id'=>$id, 'state'=>$state], ['id','state']);
            if(isset($check_res['status'])) throw new \Exception($check_res['msg']);

            $handle_record = [
                'state' => $state,
            ];
            $cashModel = M('supply_cash_record');
            $handleRes = $cashModel->where(['id'=>$id])->limit(1)->save($handle_record);
            if(!$handleRes) throw new \Exception('更改状态失败，请稍后重试');

            $cashRes = $cashModel->where(['id'=>$id])->limit(1)
                ->field('uid,money')->find();

            $userModel = M('user_estate');
            $data['supply_money'] = array('exp','supply_money+' . $cashRes['money']);
            $moneyRes  = $userModel->where(['id'=>$cashRes['uid']])->save($data);
            if(!$moneyRes) throw new \Exception("更改状态失败，请稍后重试");

            $Model->commit();
            $res = ['status' => 1, 'msg'=>'处理成功'];
        } catch (\Exception $e) {
            $Model->rollback();
            $res = ['status' => 0, 'msg'=>$e->getMessage()];
        }

        $this->ajaxReturn($res);
    }
}
