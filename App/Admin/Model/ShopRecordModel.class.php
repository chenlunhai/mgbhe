<?php
namespace Admin\Model;
use Exception;
class ShopRecordModel extends RunModel{

    /**
     * 处理用户申请为店主的记录
     * @date  2017/11/6
     * @param $data array,key:id,state:1(通过)、2(不通过)
     */
    public function up_register_record($data)
    {
        try {
            $check_res = check_data($data,['id','state']);
            if(isset($check_res['status'])) throw new Exception($check_res['msg']);

            $up_record = [
                'suretime'=> date('Y-m-d H:i:s',NOW_TIME),'state'=>$data['state']
            ];
            $upRes = M('shop_register_record')->where(['id'=>$data['id'],'state'=>0])->limit(1)->save($up_record);
            if(!$upRes) throw new Exception('更改状态失败，请稍后重试');
            return ['status'=>1,'msg'=>'处理成功'];
        } catch (Exception $e) {
            return ['status'=>0,'msg'=>$e->getMessage()];
        }
    }

    public function set_supplier($data)
    {
        try {
            $check_res = check_data($data, ['id', 'state']);
            if (isset($check_res['status'])) throw new Exception($check_res['msg']);

            $registerModel = M('shop_register_record');
            $supplierModel = M('user_supply');

            if (1 == $data['state']) {
                $registerData = $registerModel->where(['uid'=>$data['id']])->find();
                $supplierData = array(
                    'uid' => $registerData['uid'],
                    'sname' => $registerData['shopname'],
                    'srealname' => $registerData['realname'],
                    'ssn' => $registerData['shopsn'],
                    'stel' => $registerData['mobile'],
                    'province' => $registerData['province'],
                    'city' => $registerData['city'],
                    'region' => $registerData['region'],
                    'address' => $registerData['address'],
                    'imgurl' => $registerData['imgurl'],
                    'addtime' => date('Y-m-d H:i:s',NOW_TIME),
                );

                $supplier = $supplierModel->where(['uid' => $data['id']])->find();
                if ($supplier) {
                    $res  = $supplierModel->where(['uid'=>$data['id']])->save($supplierData);
                } else {
                    $res  = $supplierModel->add($supplierData);
                }
                if(! $res) throw new Exception('操作失败，请稍后重试');
            }

            $record1 = [
                'supply_grade' => ($data['state'] == 1 ? 1 : 0),
            ];
            $record2 = [
                'suretime' => date('Y-m-d H:i:s',NOW_TIME),
                'state' => ($data['state'] == 1 ? 1 : 2),
            ];
            $res1 = M('user_estate')->where(['id'=>$data['id']])->limit(1)->save($record1);
            if(false === $res1) throw new Exception('更改状态失败，请稍后重试');
            $res2 = $registerModel->where(['uid'=>$data['id']])->limit(1)->save($record2);
            if(!$res2) throw new Exception('更改状态失败，请稍后重试');
            return ['status' => 1, 'msg' => '处理成功'];
        } catch (Exception $e) {
            return ['status'=>0,'msg'=>$e->getMessage()];
        }
    }

    public function set_grade($data)
    {
        try {
            $check_res = check_data($data, ['id', 'state']);
            if (isset($check_res['status'])) throw new Exception($check_res['msg']);

            $record1 = [
                'grade' => ($data['state'] == 1 ? 1 : 0),
            ];
            $record2 = [
                'suretime' => date('Y-m-d H:i:s'),
                'state' => ($data['state'] == 1 ? 1 : 2),
            ];

            $res1 = M('user_estate')->where(['id' => $data['id']])->limit(1)->save($record1);
            if (false === $res1) throw new Exception('更改状态失败，请稍后重试');
            $res2 = M('shop_register_record')->where(['uid' => $data['id']])->limit(1)->save($record2);
            if (!$res2) throw new Exception('更改状态失败，请稍后重试');
            return ['status' => 1, 'msg' => '处理成功'];
        } catch (Exception $e) {
            return ['status' => 0, 'msg' => $e->getMessage()];
        }
    }
}
