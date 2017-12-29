<?php
namespace Home\Model;
use Think\Model;
use Think\Exception;
class ShopRegisterRecordModel extends Model{


	/**
	 * 商家认证-待审核时返回商家输入资料
	 * @param 2017-12-26 17:29:37
	 * @param string:uid
	 */
	public function get_shop_register($id)
	{
		try {
			if(intval($id) < 1) throw new Exception("error #id", 11000);
			
			//,'state'=>['neq',2]
			$record = $this->where(['uid'=>$id])->order('state desc')->find();

			if(!empty($record['imgurl'])) {
				$record['imgurl'] = json_decode(turnStr(urldecode($record['imgurl'])),true); 
				foreach ($record['imgurl'] as $key => $value) {
					$record['imgurl'][$key] = C('ALI_IMG_URL').$value;
				}
			}
			
			return ['status'=>1,'data'=>$record];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 商家认证
	 * @param 2017-12-25 17:43:44
	 * @param array:uid,shopname,realname,shopsn,province,city,region,address,imgurl(提交图片地址，执照号先上传阿里云oss)
	 * @return array
	 */
	public function add_shop_register($data)
	{
		try {
			$check_res = check_data($data,['shopname','realname','shopsn','uid','province','city','region','address','imgurl']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

			$this->where(['uid'=>$data['uid']])->delete();
			
			$check_exists = $this->where(['uid'=>$data['uid'],'state'=>0])->count();
			if($check_exists > 0) throw new Exception("已存在申请记录", 0);
			
			$mobile = M('user_account')->where(['id'=>$data['uid']])->getField('mobile');
			$in = [
				'uid'=>$data['uid'],'province'=>$data['province'],'city'=>$data['city'],'region'=>$data['region'],'address'=>$data['address'],'imgurl'=>$data['imgurl'],'state'=>0,'shopsn'=>$data['shopsn'],'realname'=>$data['realname'],'shopname'=>$data['shopname'],'mobile'=>$mobile,'state'=>0
			];
			$inRes = $this->add($in);
			if(!$inRes) throw new Exception("写入记录失败", 20000);
			
			return ['status'=>1,'msg'=>"提交成功"];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}	

}