<?php
namespace Home\Model;
use Think\Exception;
use Think\Model;
class GoodsOpenGroupOrderModel extends Model{

    /**
     * 返回组团中的订单和商品
     * @param 2017-12-16 18:21:33
     * @param array $data:uid,page,state:0(组团中)1(组团成功)(组团失败)
     * @return array
     */
    public function get_group_order($data){
        try {
            $check_res = check_data($data,['uid','state']);
            if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

            $limit = D('goods_open_group')->getLimit($data['page']);
            $order = $this->where(['o.uid'=>$data['uid'],'o.pay_status'=>1,'o.group_trade'=>$data['state']])->join('o left join __GOODS_OPEN_GROUP__ g on o.grid=g.id')->field('o.osn,o.total_price,o.pay_num,o.grid,g.gname,g.gteam_price,g.gimg')->limit($limit)->order('o.id desc')->select();
            if(empty($order)) return ['status'=>1,'data'=>$order];

            foreach ($order as $key => $value) {
                $order[$key]['gimg'] = C('IMG_URL').$value['gimg'];
                $order[$key]['state'] = $data['state'];
            }

            return ['status'=>1,'data'=>$order];
        } catch (Exception $e) {
            return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
        }
    }
    /**
     * 返回我的订单
     * @param 2017-12-18 10:04:03
     * @param array $data:uid,page,state:0(待支付)1(已支付)2(已发货)3(已收货)4(退款中)5(完成退款)-1(全部)
     */
    public function get_user_order($data)
    {
        try {
            $check_res = check_data($data,['uid','state']);
            if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

            $limit = D('goods_open_group')->getLimit($data['page']);
            $where = ['o.uid'=>$data['uid'],'o.trade'=>$data['state']];
            if($data['state'] == '-1') unset($where['o.trade']);
            $order = $this->where($where)->join('o left join __GOODS_OPEN_GROUP__ g on o.grid=g.id')->field('o.id,o.osn,o.total_price,o.pay_num,o.grid,g.gname,g.gteam_price,g.gimg,o.trade')->limit($limit)->order('o.id desc')->select();
            if(empty($order)) return ['status'=>1,'data'=>$order];

            foreach ($order as $key => $value) {
                $order[$key]['gimg'] = C('IMG_URL').$value['gimg'];
            }
            return ['status'=>1,'data'=>$order];
        } catch (Exception $e) {
            return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
        }
    }
    /**
     * 支付订单
     * @param 2017-12-14 14:36:18
     * @param array $data:uid(用户id),osn(订单编号),out_trade_type:0(微信)1(支付宝)2(余额支付),pay_source:(APP)(WEB)
     * @return array
     */
    public function pay_order($data)
    {
        try {
            $check_res = check_data($data,['osn','out_trade_type','pay_source']);
            if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

            $order = $this->where(['osn'=>$data['osn'],'pay_status'=>0])->field('pay_price,id,grid,pay_num')->find();
            if(empty($order)) throw new Exception("该订单状态无法发起支付", 11010);


            $up_order = [
                'pay_source'=>$data['pay_source'],'out_trade_type'=>$data['out_trade_type']
            ];
            $this->where(['id'=>$order['id'],'pay_status'=>0])->limit(1)->save($up_order);



            if($data['out_trade_type'] == 2){	#余额支付
                $user = D('user_estate')->get_user_estate($data['uid'],'balance');
                if($user['balance'] < $order['pay_price']) throw new Exception("余额不足", 11008);

                $res = $this->complete_order(['order_sn'=>$data['osn'],'out_trade_no'=>'','total_fee'=>$order['pay_price']]);
                if($res['status'] != 1) throw new Exception($res['msg'], $res['code']);

                return $res;
            }

            $res = $this->check_buy_goods(['id'=>$order['grid'],'buy_num'=>$order['pay_num']]);	#判断购买数量是否超出本团最大数量
            if($res['status'] != 1) throw new Exception($res['msg'], $res['code']);

            if($data['pay_source'] == 'WEB'){
                $payurl = getPayUrl($data['osn'],$data['out_trade_type']);
                return ['status'=>1,'data'=>['payurl'=>$payurl,'code'=>1]];
            }
            if($data['pay_source'] == 'APP'){
                $gourl = 'http://'.$_SERVER['HTTP_HOST'].'/App/Alipay/app/AopSdk.php?money='.$order['pay_price'].'&order_sn='.$data['osn'];
                $res   = file_get_contents($gourl);
                return ['status'=>1,'data'=>$res];
            }
            throw new Exception("支付方式异常", 11005);
        } catch (Exception $e) {
            return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
        }
    }
    /**
     * 支付成功回调处理
     * @param 2017-12-14 15:24:40
     * @param array $data:order_sn,out_trade_no,total_fee
     */
    public function complete_order($data)
    {
        try {
            $check_res = check_data($data,['order_sn','out_trade_no','total_fee']);
            if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

            $order = $this->where(['osn'=>$data['order_sn'],'pay_price'=>$data['total_fee'],'pay_status'=>0])->field('osn,uid,out_trade_type,pay_price,id,pay_num,grid')->find();
            if(empty($order)) throw new Exception("订单不存在或已支付", 11010);

            #得到拼团商品信息
            $goods = M('goods_open_group')->where(['id'=>$order['grid']])->field('gpay_num,gnum,gpay_limit')->find();
            $num = $goods['gnum'] - $goods['gpay_num']; #当前可购买数量


            $up_order = [	#更改订单状态
                'pay_status'=>1,'paytime'=>date('Y-m-d H:i:s',NOW_TIME),'out_trade_no'=>$data['out_trade_no'],'trade'=>1
            ];

            $up_group = [	#更改已购数量
                'gpay_num' => ['exp','gpay_num+'.$order['pay_num']]
            ];
            if(($num-$order['pay_num']) < $goods['gpay_limit']){	#本次拼团完成
                $up_group['gstatus'] = 1;
                $this->where(['grid'=>$order['grid'],'group_trade'=>0])->setField('group_trade',1);
            }

            if($order['out_trade_type'] == 2){	#余额支付
                if($order['pay_num'] > $num) throw new Exception("本次最多购买".$num.'件', 11018);

                $user = D('user_estate')->get_user_estate($order['uid'],'balance');
                if($user['balance'] < $order['pay_price']) throw new Exception("余额不足", 11008);

                $in_balance = [	#写入余额变动明细
                    'uid'=>$order['uid'],'money'=>'-'.$order['pay_price'],'current_money'=>$user['balance'] - $order['pay_price'],'state'=>3,'oid'=>$order['id'],'remark'=>'拼采廉消费'
                ];

            }
        } catch (Exception $e) {
            return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
        }

        #事务处理
        $Model= new Model();
        $Model->startTrans();
        try {
            $upRes = $Model->table('__GOODS_OPEN_GROUP__')->where(['id'=>$order['grid'],'gstatus'=>0])->limit(1)->save($up_group);
            if(isset($in_balance)){
                if(!$upRes) throw new Exception("本次最多购买".$num.'件', 11018);

                $upRes = $Model->table('__USER_ESTATE__')->where(['id'=>$order['uid'],'balance'=>['egt',$order['pay_price']]])->setDec('balance',$order['pay_price']);
                if(!$upRes) throw new Exception("余额不足", 11008);
                $inRes = $Model->table('__BALANCE_RECORD__')->add($in_balance);
                if(!$inRes) throw new Exception('写入余额明细失败', 20000);
                $up_order['out_trade_no'] = $inRes;
            }else{
                if(!$upRes) $up_order['trade'] = 4;	#已超出该团最大数量，现金支付需把订单改为退款中
            }
            $upRes = $Model->table('__GOODS_OPEN_GROUP_ORDER__')->where(['id'=>$order['id'],'pay_status'=>0,'trade'=>0])->limit(1)->save($up_order);
            if(!$upRes) throw new Exception("订单不存在或已支付", 11010);

            $Model->commit();
            if($up_group['gstatus'] == 1){	#开启下一期
                D('goods_open_group')->up_open_next_group($order['grid']); #自动开启下一期
            }
            if($up_order['trade'] != 4){	#订单状态非退款即可计算奖金
                D('goods_reward_record')->add_reward(['id'=>$order['id'],'grid'=>$order['grid']]);
            }
            return ['status'=>1,'data'=>$order];
        } catch (Exception $e) {
            $Model->rollback();
            return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
        }
    }
    /**
     * 确定收货执行奖励
     * @param 2017-12-23 15:39:13
     * @param array:uid,id
     * @return array
     */

    public function get_sure_goods($data){
        try {
            $check_res = check_data($data,['uid','id']);
            if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);
            $order = $this->where(['id'=>$data['id'],'uid'=>$data['uid'],'trade'=>2])->field('id')->find();
            $this->add_seller_money($data);
            if(empty($order)) throw new Exception("订单状态无法确认收货");

            $up_order = ['trade'=>3,'get_goods_time'=>date('Y-m-d H:i:s',NOW_TIME)];
            $User = M('user_estate');

            $in_integral = [];
            #订单奖励发放
            $reward = M('goods_reward_record')->where(['r.oid'=>$data['id'],'r.gid'=>$data['uid'],'r.status'=>0])->join('r left join __GOODS_OPEN_GROUP_ORDER__ g on r.oid=g.id')->field('g.osn,r.money,r.id,r.state,r.uid')->select();

            $tmp_user = [];
            $reward_ids = '';
            foreach ($reward as $key => $value) {
                $reward_ids .= ','.$value['id'];
                $integral = $User->where(['id'=>$value['uid']])->getField('integral');
                $tmp_user[$value['uid']] += $value['money']+$integral;
                $in_integral[] = ['uid'=>$value['uid'],'money'=>$value['money'],'remark'=>'通过订单'.$value['osn'],'oid'=>$data['id'],'state'=>$value['state'],'current_money'=>$tmp_user[$value['uid']]];

            }
            $reward_ids = substr($reward_ids,1);

        } catch (Exception $e) {
            return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
        }
        #事务处理
        $Model = new Model();
        $Model->startTrans();
        try {
            $upRes = $Model->table('__GOODS_OPEN_GROUP_ORDER__')->where(['id'=>$data['id'],'trade'=>2])->limit(1)->save($up_order);
            if(!$upRes) throw new Exception("订单状态无法确认收货", 20001);
            if(!empty($in_integral)){
                $upRes = $Model->table('__GOODS_REWARD_RECORD__')->where(['id'=>['in',$reward_ids],'status'=>0])->setField('status',1);
                if(!$upRes) throw new Exception("该奖金已领取", 20001);
                $inRes = $Model->table('__INTEGRAL_RECORD__')->addAll($in_integral);
                if(!$inRes) throw new Execption("积分奖励写入失败", 20000);
                foreach ($in_integral as $key => $value) {
                    $up_estate = ['integral'=>['exp','integral+'.$value['money']],'total_integral'=>['exp','total_integral+'.$value['money']]];
                    $upRes = $Model->table('__USER_ESTATE__')->where(['id'=>$value['uid']])->limit(1)->save($up_estate);
                    if(!$upRes) throw new Exception("更改用户财产失败", 20001);
                }
            }

            $Model->commit();
            return ['status'=>1,'msg'=>'操作成功'];
        } catch (Exception $e) {
            $Model->rollback();
            return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
        }
    }
    /**
     * 订单货款的写入，货款记录，货款提现
     * @param 2017/12/27
     * @param uid,id
     * @return  array
     */
    public  function add_seller_money($data){
        try {

            $check_res = check_data($data,['uid','id']);
            if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

            $order= $this->where(['id'=>$data['id'],'uid'=>$data['uid'],'trade'=>2])->field('osn,did,pay_price')->find();
            $supply_money=M('user_estate')->where(['id'=>$order['did']])->field('supply_money')->find();
            $did=$order['did'];
            $osn=$order['osn'];
            $state=0;
            $money=$order['pay_price']-$order['pay_price']*0.05;
            $fee=$order['pay_price']*0.05;
            $cmoney=$supply_money['supply_money']+$money;
            $in = [	#写入记录
                'did'=>$did,'osn'=> $osn,'state'=>$state,'money'=>$money,'cmoney'=>$cmoney,'fee'=>$fee];
            $Model = new Model();
            $Model->startTrans();
            $supply=$Model->table('__SUPPLY_MONEY_RECORD__')->add($in);
            $updae_user_estate=M('user_estate')->where(['id'=>$did])->save(['supply_money'=>$money,'total_supply_money'=>$cmoney]);
            if(!$updae_user_estate) throw new Exception("更新商家信息失败", 20000);
            if(!$supply) throw new Exception("写入订单失败", 20000);
            $Model->commit();
            return ['status'=>1,'msg'=>'操作成功'];
        } catch (Exception $e) {
            $Model->rollback();
            return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];

        }
    }


    /**
     * 确认订单处理动作，生成订单
     * @param 2017-12-14 11:37:49
     * @param array $data:uid(用户id),id(拼团id),buy_num(购买数量),aid(收货地址id)
     * @return  array
     */
    public function create_order($data)
    {
        try {
            $check_res = check_data($data,['uid','id','buy_num','aid']);
            if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);
            if(!intval($data['uid']) || !intval($data['id']) || !intval($data['aid'])) throw new Exception("error #paramer", 11000);

            $address = M('address')->where(['uid'=>$data['uid'],'id'=>$data['aid']])->field('mobile,realname,province,city,country,detail')->find();
            if(empty($address)) throw new Exception("收货地址不存在", 11019);

            $goods = M('goods_open_group')->where(['id'=>$data['id'],'gstatus'=>0])->field('gname,gteam_price,gimg,gpay_num,gnum,did')->find();
            if(empty($goods)) throw new Exception("该商品已满团", 11017);
            $num = $goods['gnum'] - $goods['gpay_num']; //剩余可购买数量
            if($data['buy_num'] > $num) throw new Exception("本次最多购买".$num.'件', 11018);

            $user = M('user_account')->where(['id'=>$data['uid']])->field('province,city')->find();
            if(empty($user['province']) || empty($user['city'])) throw new Exception("所在省或市异常", 11021);

            $total_price = $goods['gteam_price'] * $data['buy_num'];

            $in = [	#写入订单
                'uid'=>$data['uid'],'total_price'=> $total_price,'pay_num'=>$data['buy_num'],'pay_price'=>$total_price,'out_trade_type'=>0,'province'=>$address['province'],'city'=>$address['city'],'country'=>$address['country'],'address'=>$address['detail'],'mobile'=>$address['mobile'],'realname'=>$address['realname'],'osn'=>self::create_order_sn(),'pay_status'=>0,'grid'=>$data['id'],'uprovince'=>$user['province'],'ucity'=>$user['city'],'did'=>$goods['did']
            ]; //好像也没有什么需要在写入了
            $inRes = $this->add($in);
            if(!$inRes) throw new Exception("写入订单失败", 20000);

            return ['status'=>1,'data'=>$in];
        } catch (Exception $e) {
            return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
        }
    }
    /**
     * 判断本次购买商品能否正常购买
     * @param 2017-12-14 10:34:00
     * @param array $data:id(拼团id),buy_num(购买数量)
     */
    public function check_buy_goods($data)
    {
        try {
            $check_res = check_data($data,['id','buy_num']);
            if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

            if(!intval($data['id'])) throw new Exception("error #paramer", 11000);

            $goods = M('goods_open_group')->where(['id'=>$data['id'],'gstatus'=>0])->field('gname,gteam_price,gimg,gpay_num,gnum,gpay_limit,id')->find();
            if(empty($goods)) throw new Exception("该商品已满图", 11017);

            $goods['gimg'] = C('IMG_URL').$goods['gimg'];
            if($goods['gpay_limit'] > $data['buy_num']) throw new Exception("购买数量低于单次起订量",0);
            $num = $goods['gnum'] - $goods['gpay_num']; //剩余可购买数量
            if($data['buy_num'] > $num) throw new Exception("本次最多购买".$num.'件', 11018);

            $goods['buy_num'] = $data['buy_num'];
            $goods['total_price'] = $goods['buy_num'] * $goods['gteam_price'];

            return ['status'=>1,'data'=>$goods];
        } catch (Exception $e) {
            return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
        }
    }
    /**
     * 返回订单详情
     * @param 2017-12-18 18:08:31
     * @param array:uid,osn
     * @return array
     */
    public function get_order_detail($data)
    {
        try {
            $check_res = check_data($data,['uid','osn']);
            if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

            $order = $this->where(['o.uid'=>$data['uid'],'o.osn'=>$data['osn']])->join('o left join __GOODS_OPEN_GROUP__ g on o.grid=g.id')->field('o.osn,o.trade,o.paytime,o.pay_price,o.pay_num,o.province,o.city,o.country,o.realname,o.mobile,o.addtime,g.gname,g.gimg,g.gteam_price,o.address')->find();
            if(empty($order)) throw new Exception("订单不存在", 11010);

            $order['gimg'] = C('IMG_URL').$order['gimg'];
            return ['status'=>1,'data'=>$order];
        } catch (Exception $e) {
            return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
        }
    }
    /**
     * 返回支付成功信息
     * @param 2017-12-18 16:24:22
     * @param array:uid,osn
     * @return array
     */
    public function  get_order_success($data)
    {
        try {
            $check_res = check_data($data,['uid','osn']);
            if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

            $order = $this->where(['uid'=>$data['uid'],'osn'=>$data['osn'],'pay_status'=>1])->field('out_trade_type,paytime,pay_price')->find();
            if(empty($order)) throw new Exception("订单不存在", 11010);

            $order['osn'] = $data['osn'];
            $order['out_trade_type'] = getPayType($order['out_trade_type']);
            return ['status'=>1,'data'=>$order];
        } catch (Exception $e) {
            return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
        }
    }
    /**
     * 生成购物券充值订单号
     * @param 2017/11/9
     * @return string
     */
    private function create_order_sn()
    {
        return '6'.date('YmdHis').rand(10000,99999);
    }
}