<?php
namespace Admin\Controller;
use Think\Controller;
class ShopController extends SeachController {
    /** 店主列表 */
    public function shoplist()
    {
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

    /** 消费者实名认证列表 */
    public function member_certification_list()
    {
        $pageSize = 25;
        $limit = getLimit($pageSize);

        $status = I('post.status'); #To determine whether the data is exported
        if ($status) $limit = ''; #Export all data under current conditions

        #搜索条件
        $search = $this->search_register_list();
        $where = $search['where'];
        $where['type'] = 0;

        #查询数据
        $Model = D('shop_register_record');
        $field = "o.*";
        $data  = $Model->alias('o')
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

    public function handle_certification()
    {
        $id = I('post.id');

        $state = I('post.state') ? 2 : 1;

        try {
            $data = ['id' => $id, 'state' => $state];
            $check_res = check_data($data, ['id','state']);
            if (isset($check_res['status'])) throw new \Exception($check_res['msg']);

            $registerModel = M('shop_register_record');
            $userModel = M('user_account');

            if ($state == 1) {
                $userData = $registerModel->where(['id'=>$id, 'type' => 0])->find();
                if (! $userData || ! $userData['id_card']) throw new \Exception('操作失败，请稍后重试');
                $res1 = $userModel->where(['id'=>$userData['uid']])
                    ->limit(1)->save([
                        'id_card' => $userData['id_card'],
                    ]);
                if (! $res1) throw new \Exception('操作失败，请稍后重试');
            }

            $res2 = $registerModel->where(['id'=>$id, 'type' => 0])
                ->limit(1)->save([
                    'state' => $state,
                    'suretime' => date('Y-m-d H:i:s'),
                ]);
            if (! $res2) throw new \Exception('更改状态失败，请稍后重试');
            $res = ['status' => 1, 'msg' => '处理成功'];
        } catch (\Exception $e) {
            $res = ['status' => 0, 'msg' => $e->getMessage()];
        }

        $this->ajaxReturn($res);
    }

    /** 无人店申请列表 */
    public function wrd_register_list()
    {
        $pageSize = 25;
        $limit = getLimit($pageSize);

        $status = I('post.status'); #To determine whether the data is exported
        if ($status) $limit = ''; #Export all data under current conditions

        #搜索条件
        $search = $this->search_register_list();
        $where = $search['where'];
        $where['type'] = 1;

        #查询数据
        $Model = D('shop_register_record');
        $field = "o.*";
        $data  = $Model->alias('o')
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

    public function handle_register()
    {
        $id = I('post.id');

        $state = I('post.state') ? 2 : 1;

        try {
            $data = ['id' => $id, 'state' => $state];
            $check_res = check_data($data, ['id','state']);
            if (isset($check_res['status'])) throw new \Exception($check_res['msg']);
            
            $upRes = M('shop_register_record')->where(['id'=>$id, 'type' => 1])
                ->limit(1)->save([
                    'state' => $state,
                    'suretime' => date('Y-m-d H:i:s'),
                ]);
            if(!$upRes) throw new \Exception('更改状态失败，请稍后重试');
            $res = ['status' => 1, 'msg' => '处理成功'];
        } catch (\Exception $e) {
            $res = ['status' => 0, 'msg' => $e->getMessage()];
        }

        $this->ajaxReturn($res);
    }

    /** 厂家(供应商)申请列表 */
    public function shop_register_list()
    {
        $pageSize = 25;
        $limit = getLimit($pageSize);

        $status = I('post.status'); #To determine whether the data is exported
        if ($status) $limit = ''; #Export all data under current conditions

        #搜索条件
        $search = $this->search_register_list();
        $where = $search['where'];
        $where['type'] = 2;

        #查询数据
        $Model = D('shop_register_record');
        $join = "".C("DB_PREFIX")."user_estate as b on b.id = o.uid";
        $field = "o.*, b.grade";
        $data  = $Model->alias('o')->join($join)
            ->where($where)->field($field)
            ->order('id desc')->limit($limit)->select();
        $this->assign('data', $data);

        /*#导出数据
        if($status) exit($this->ExportShopRegisterList($data,$search['time'],$shop['name']));*/

        #分页
        $count = $Model->alias('o')->where($where)->count();
        $this->assign('count', $count);
        unset($search['_string'], $search['where']);
        $Page  = new \Think\Page($count, $pageSize, $search); 
        /*foreach ($search as $key => $value) {
            $Page->parameter[$key] = ($value);
        }*/
        $show  = $Page->show();
        $this->assign('page', $show);
        $this->display();
    }

    /** 店家(采购商)申请列表 */
    public function supplier_register_list()
    {
        $pageSize = 25;
        $limit = getLimit($pageSize);

        $status = I('post.status'); #To determine whether the data is exported
        if($status) $limit = ''; #Export all data under current conditions

        #搜索条件
        $search = $this->search_register_list();
        $where = $search['where'];
        $where['type'] = 3;

        #查询数据
        $Model = D('shop_register_record');
        $join = "".C("DB_PREFIX")."user_estate as b on b.id = o.uid";
        $field = "o.*, b.supply_grade";
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
    public function shop_register_show()
    {
        $id = I('get.id',0);
        if($id < 1) $this->redirect('Shop/shop_register_list');

        $Model = D('user_account');
        $user  = $Model->where(['id'=>$id])->find();
        $this->assign('user',$user);
        $this->display();
    }

    public function supplier_register_show()
    {
        $id = I('get.id',0);
        if($id < 1) $this->redirect('Shop/supplier_register_list');

        $Model = D('user_account');
        $user  = $Model->where(['id'=>$id])->find();
        $this->assign('user',$user);

        $supplierModel = M('shop_register_record');
        $supplier  = $supplierModel->where(['uid'=>$id])->find();
        $this->assign('supplier',$supplier);

        $this->display();
    }
}