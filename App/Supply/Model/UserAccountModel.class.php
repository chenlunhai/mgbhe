<?php
namespace Supply\Model;
use Think\Model;
use Think\Exception;

class UserAccountModel extends Model{

	/**
	 * 供货商登陆
	 * @param  2017/11/6
	 * @param $data array,key:mobile
	 * @return array
	 */
	public function exe_supply_login($data){
		try {
			$check_res = check_data($data,['mobile','verify']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg']);

			$user = $this->where(['a.mobile'=>$data['mobile'],'e.supply_grade'=>1])->join('a left join __USER_ESTATE__ e on a.id=e.id')->field('a.id')->find();
			if(empty($user)) throw new Exception("该手机号码不存在");
			
			

			session('Supply_info',['id'=>$user['id'],'adminname'=>$data['mobile']]);
			return ['status'=>1,'msg'=>'登陆成功'];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage()];
		}
	}
	/**
     * 验证手机号码是否可以登录供货商后台
     * @param 2017-12-9 11:01:06
     * @param array $data:mobile
     */
    public function check_mobile($data)
    {
      try {
      		$check_res = check_data($data,['mobile']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg']);

			$user = $this->where(['a.mobile'=>$data['mobile'],'e.supply_grade'=>1])->join('a left join  __USER_ESTATE__ e on a.id=e.id')->count();
			if($user < 1) throw new Exception("该手机号码不存在");
			
			return ['status'=>1];
      } catch (Exception $e) {
      		return ['status'=>0,'msg'=>$e->getMessage()];
      }
    }
}