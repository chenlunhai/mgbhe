<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/28
 * Time: 15:22
 */

namespace Supply\Controller;

use Supply\Model\SupplyCashRecord;
use Home\Model\GoodsSupplyCateModel;
use Supply\Model\UserAccountModel;
use Think\Controller;
use Home\Model\UserEstateModel;

use Common\Service\LogService;
use Think\Exception;
use Think\Model;

class MoneyController extends SeachController
{
    /**
     * 货款记录
     * @param  2017-12-28 15:25
     */

    public function money_list()
    {
        $post = I('post.');


        $seach = $this->seach();
        $where = $seach['where'];
        $did = parent::$adminid;
        $where['did'] = $did;
        $pageSize = 25;
        $limit = getLimit($pageSize);
        #查询数据
        $Model = M('supply_money_record');
        if (empty($post)) {
            $data = $Model->where(['state' => 0])->field('id,did,osn,state,money,cmoney,fee,addtime')->order('id desc')->limit($limit)->select();
        } else {
            $condition['state'] = 0;
            if (!empty($post['order_sn'])) {
                $condition['order_sn'] = $post['order_sn'];
            }
            if (!empty($post['stime']) && !empty($post['dtime'])) {

                $time = $post['stime'] . ',' . $post['dtime'];
                $condition['addtime'] = array('between', $time);
            }


            $data = $Model->where($condition)->field('id,did,osn,state,money,cmoney,fee,addtime')->order('id desc')->limit($limit)->select();
        }

        $this->assign('data', $data);
        #分页

        $count = $Model->alias('o')->count();

        $this->assign('count', $count);

        $Page = new \Think\Page($count, $pageSize, '');

        $show = $Page->show();
        $this->assign('page', $show);

        $this->display();

    }

    public function gtcash()
    {
        $Model = new UserEstateModel();
        $supply_money = $Model->where(['id' => parent::$adminid])->field('supply_money,total_supply_money')->find();
        $user_model = new UserAccountModel();
        $useraccount = $user_model->where(['id' => parent::$adminid])->field('realname,mobile,bank_address,bank_card')->find();
        $carNumber = $useraccount['bank_card'];
        $userinfo = $useraccount['bank_address'] . ',' . $useraccount['realname'] . ',' . $useraccount['mobile'];
        $this->assign('money', $supply_money);
        $this->assign('card', $carNumber);
        $this->assign('userinfo', $userinfo);
        $this->display();

    }

    /**
     *ajax 提交提现写入记录表
     * post.cash 提现金额，后期在扩展支付宝选项
     * time：2017-12-2911:04
     */
    public function cash()
    {
        $post = I('post.');
        $add_para = [];
        $add_para['money'] = $post['cash'];
        $uid = parent::$adminid;
        $add_para['uid'] = $uid;
        $user_model = new UserAccountModel();
        $useraccount = $user_model->where(['id' => $uid])->field('realname,mobile,bank_address,bank_card')->find();
        $add_para['fee'] = 0;
        $add_para['cash_type'] = 0;
        $add_para['account'] = $useraccount['bank_address'] . ',' . $useraccount['bank_card'] . ',' . $useraccount['realname'] . ',' . $useraccount['mobile'];
        $add_para['addtime'] = date('Y-m-d H:i:s', time());
        $addModel = M('supply_cash_record');
        $Model_UserEstate = new UserEstateModel();
        $supply_money = $Model_UserEstate->where(['id' => parent::$adminid])->field('supply_money,total_supply_money')->find();
        $surplus_money['supply_money'] = $supply_money['supply_money'] - $post['cash'];
        $surplus_money['total_supply_money'] = $supply_money['total_supply_money'] - $post['cash'];
        try {
            $Model = new Model();
            $Model->startTrans();
            //更新用户余额
            $surplus_result = $Model->table('__USER_ESTATE__')->where(['id' => $uid])->save($surplus_money);
            //加入提现记录cash_record
            $cashid = $addModel->add($add_para);
            //保存记录money_record osn为cash_id
            $did = parent::$adminid;
            $osn = $cashid;
            $state = 1;
            $money = $post['cash'];
            $fee = 0;
            $cmoney = $surplus_money['total_supply_money'];
            $in = [    #写入记录
                'did' => $did, 'osn' => $osn, 'state' => $state, 'money' => $money, 'cmoney' => $cmoney, 'fee' => $fee];
            $supply = $Model->table('__SUPPLY_MONEY_RECORD__')->add($in);
            if (!$supply) throw new Exception("error #paramer", 11000);
            if (!$surplus_result) throw new Exception("error #paramer", 11000);
            if (!$cashid) throw new Exception("error #paramer", 11000);
            $Model->commit();
            return $this->ajaxReturn(['status' => 1, 'data' => '', 'msg' => '提交成功！请等待审核']);
        } catch (Exception $ex) {
            $Model->rollback();
            return $this->ajaxReturn(['status' => 0, 'msg' => $ex->getMessage(), 'code' => $ex->getCode()]);

        }

    }

    public function cash_list()
    {


        $post = I('post.');

        $seach = $this->seach();
        $where = $seach['where'];
        $did = parent::$adminid;
        $where['did'] = $did;
        $pageSize = 25;
        $limit = getLimit($pageSize);
        #查询数据

        $Model = M('supply_cash_record');
        if (empty($post)) {
            $data = $Model->where()->field('id,money,fee,account,cash_type,state,fee,addtime')->order('id desc')->limit($limit)->select();
        } else {
            $condition['state'] = $post['state'];
            $time = $post['stime'] . ',' . $post['dtime'];
            $condition['addtime'] = array('between', $time);
            $data = $Model->where($condition)->field('id,money,fee,account,cash_type,state,fee,addtime')->order('id desc')->limit($limit)->select();

        }

        $this->assign('data', $data);
        #分页

        $count = $Model->alias('o')->count();

        $this->assign('count', $count);

        $Page = new \Think\Page($count, $pageSize, '');

        $show = $Page->show();
        $this->assign('page', $show);

        $this->display();
    }
}