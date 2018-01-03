<?php
namespace Admin\Model;
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
            $check_res = check_data($data,['id','state']);
            if(isset($check_res['status'])) throw new Exception($check_res['msg']);

            $up_record = [
                'supply_grade' => ($data['state'] ? true : false),
            ];
            $upRes = M('user_estate')->where(['id'=>$data['id']])->limit(1)->save($up_record);
            if(!$upRes) throw new Exception('更改状态失败，请稍后重试');
            return ['status'=>1,'msg'=>'处理成功'];
        } catch (Exception $e) {
            return ['status'=>0,'msg'=>$e->getMessage()];
        }
    }

    public function set_grade($data)
    {
        try {
            $check_res = check_data($data,['id','state']);
            if(isset($check_res['status'])) throw new Exception($check_res['msg']);

            $up_record = [
                'grade' => ($data['state'] ? true : false),
            ];
            $upRes = M('user_estate')->where(['id'=>$data['id']])->limit(1)->save($up_record);
            if(!$upRes) throw new Exception('更改状态失败，请稍后重试');
            return ['status'=>1,'msg'=>'处理成功'];
        } catch (Exception $e) {
            return ['status'=>0,'msg'=>$e->getMessage()];
        }
    }
}
