<?php
namespace Home\Model;
use Think\Exception;
use Think\Model;
class AccessTokenModel extends Model{

	/**
	 * 生成access_token值
	 * @param 2017-12-12 16:32:53
	 * @param array $uid
	 */
	public function get_access_token($uid)
	{
		try {
			if(empty($uid)) throw new Exception("error #uid", 11000);
			
			$check = $this->where(['uid'=>$uid,'endtime'=>['gt',NOW_TIME]])->getField('access_token');
			if(!empty($check)) return $check;

			$str = md5($uid . NOW_TIME);
			$in = [
				'uid'=>$uid,'access_token'=>$str,'endtime'=>NOW_TIME+3600*24*30,'addtime'=>NOW_TIME
			];
			$inRes = $this->add($in);
			return $str;
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 验证access_token
	 * @param 2017-12-12 17:40:28
	 * @param string access_token
	 * @return array
	 */
	public function check_access_token($access_token)
	{
		try {
			if(empty($access_token)) throw new Exception("error #access_token", 11000);
			
			$uid = $this->where(['access_token'=>$access_token,'endtime'=>['gt',NOW_TIME]])->getField('uid');
			if(empty($uid)) throw new Exception("access_token不存在或已过期", 11015);
			
			return ['status'=>1,'msg'=>$uid];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
}