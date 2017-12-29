<?php
namespace Home\Model;
use Think\Exception;
use Think\Model;
class AddressModel extends Model{

	/**
	 * 返回用户收货地址
	 * @param 2017-12-14 09:54:38
	 * @param string $uid
	 * @return array
	 */
	public function get_address($uid)
	{
		try {
			if(intval($uid) < 1) throw new Exception("error #uid", 11000);
			
			$address = $this->where(['uid'=>$uid])->order('id desc')->select();

			return ['status'=>1,'data'=>['address'=>$address]];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 添加收货地址
	 * @param 2017-12-14 09:46:54
	 * @param array $data:uid,mobile,realname,province,city,country,detail
	 * @return array
	 */
	public function add_address($data)
	{
		try {
			$check_res = check_data($data,['uid','mobile','realname','province','city','country','detail']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

			$in = [
				'uid'=>$data['uid'],'mobile'=>$data['mobile'],'realname'=>$data['realname'],'province'=>$data['province'],'city'=>$data['city'],'country'=>$data['country'],'detail'=>$data['detail']
			];
			$inRes = $this->add($in);
			if(!$inRes) throw new Exception("收货地址写入失败", 20000);
			
			return ['status'=>1,'data'=>['id'=>$inRes]];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 删除收货地址-物理删除
	 * @param 2017-12-14 09:52:21
	 * @param array $data:id,uid
	 * @return array
	 */
	public function del_address($data)
	{
		try {
			$check_res = check_data($data,['uid','id']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

			$delRes = $this->where(['uid'=>$data['uid'],'id'=>$data['id']])->limit(1)->delete();
			if(!$delRes) throw new Exception("收货地址删除失败",20002);
			
			return ['status'=>1,'data'=>[]];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
}