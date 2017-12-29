<?php
namespace Admin\Model;
use Think\Model;
use Think\Exception;
class AdminModel extends Model{

	/**
	 * 管理员登陆
	 * @param  2017/11/6
	 * @param $data array,key:adminame,password
	 * @return array
	 */
	public function admin_login($data){
		try {
			$check_res = check_data($data,['adminname','password']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg']);

			$data['password'] = make_password($data['password']);
			$admin = $this->where(['adminname'=>$data['adminname'],'password'=>$data['password']])->field('id,adminname')->find();
			if(empty($admin)) throw new Exception('账号或密码不正确');

			$Log = new \Think\Log();
			$res = $Log->write($data['adminname'].'登陆','INFO');
			
			$this->where(['id'=>$admin['id']])->setField('logintime',date('Y-m-d H:i:s'));

			session('admin_info',$admin);
			return ['status'=>1,'msg'=>'登陆成功'];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage()];
		}
	}

}