<?php
namespace Home\Model;
use Think\Model;
use Common\Service\SmsService;
use Common\Service\CookieService;
use Common\Service\SjbService;
use Common\Service\WatermarkService;
use Think\Exception;
class UserAccountModel extends Model{

	/**
	 * 返回用户信息
	 * @param 2017-12-18 14:14:45
	 * @param string $uid
	 * @return array
	 */
	public function get_user_info($uid)
	{
		try {
			if(intval($uid) < 1) throw new Exception('error #id', 11000);
			
			$user = $this->where(['a.id'=>$uid])->join('a left join __USER_ESTATE__ e on a.id=e.id')->field('a.province,e.balance,e.grade,a.realname,e.total_red_packet')->find();
			if(empty($user)) throw new Exception("用户不存在", 11020);
			
			return ['status'=>1,'data'=>$user];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 返回用户推荐人信息
	 * @param 2017/11/11
	 * @param $code 
	 * @return array
	 */
	public function get_puser_name($code)
	{
		try {
			if(empty($code)) throw new Exception('error #code', 11000);
			
			#推荐人是否在无人店存在
			$realname = $this->where(['code'=>$code])->getField('realname');
			if(!empty($realname)) return ['status'=>1,'msg'=>$realname];
			
			#如果推荐人在无人店系统不存从数钜宝获取
			$SjbService = new SjbService();
			$info = $SjbService->get_user_info($code);
			$realname = $info['msg']['realname'] ? $info['msg']['realname'] : $info['msg']['mobile'];
			return ['status'=>1,'msg'=>$realname];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 用户注册，手机号+验证码，若手机号码存在则直接登陆
	 * @param 2017/11/2
	 * @param $data array,key:mobile
	 */
	public function  user_login($data)
	{
		try {
			$check_res = check_data($data,['mobile']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);
			
			$uid = $this->where(['mobile'=>$data['mobile']])->getField('id');
			if($uid <  1){	#注册新用户
				#是否已经在系统中存在
				$check_exists = M('user_sjb')->where(['mobile'=>$data['mobile']])->count();
				if($check_exists > 0) throw new Exception("验证姓名", 3);	#验证数钜宝姓名

				#验证手机号是否在数钜宝存在
				$SjbService = new SjbService();
				$sjb_res = $SjbService->check_mobile_exists($data['mobile']);
				if($sjb_res['status'] != 1) throw new Exception('新用户需要完善资料', 2);	#数钜宝不存在，下一步完善资料注册
				
				#写入临时记录表
				$in_tmp = [
					'mobile' => $data['mobile'],'realname'=> $sjb_res['msg']['realname'],'code'=>$sjb_res['msg']['code'],'pcode'=>$sjb_res['msg']['pcode'],
				];

				$inRes = M('user_sjb')->add($in_tmp);
				if(!$inRes) throw new Exception("写入用户临时记录失败", 20000);
				
				throw new Exception("验证姓名", 3);	#验证数钜宝姓名
			}else{	#存在用户直接登陆
				$this->where(['id'=>$uid])->setField('logintime',date('Y-m-d H:i:s',NOW_TIME));
			}
			
			$Cookie = new CookieService;
			$Cookie->setCookie(['wl_uid',$uid]);
			
			return ['status'=>1,'code'=>1,'msg'=>$uid];  #老用户，下一步会员中心
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}

	/**
	 * 手机号码+数钜宝姓名 注册
	 * @param 2017/11/9
	 * @param array $data,key:mobile,realname,mid
	 * @return array
	 */
	public function user_realname_register($data)
	{
		try {
			$check_res = check_data($data,['mobile','realname']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);
			if($data['mid'] < 1) $data['mid'] =0;
			$uid = $this->where(['mobile'=>$data['mobile']])->getField('id');
			if($uid <  1){	#注册新用户
				$user_sjb = M('user_sjb')->where(['mobile'=>$data['mobile'],'status'=>0])->field('code,realname,pcode')->find();
				if($user_sjb['realname'] != $data['realname']) throw new Exception('姓名输入有误', 11007);
				
				$SjbService = new SjbService();
				$sjb_res = $SjbService->get_user_info($user_sjb['code']);
			  	
			  	$pid_exists = $this->where(['id'=>$data['pid']])->count();	#推荐人是否存在
			  	if($pid_exists < 1) throw new Exception("推荐人不存在",11011);
			  	
				$in_user = [
					'code'=>$user_sjb['code'],'pcode'=>$user_sjb['pcode'],'mid'=>$data['mid'],'mobile'=>$data['mobile'],'realname'=>$data['realname'],'logintime'=>date('Y-m-d H:i:s',NOW_TIME),'province'=>$sjb_res['msg']['province'],'city'=>$sjb_res['msg']['city'],'region'=>$sjb_res['msg']['region'],'pid'=>$data['pid']
				];
				 
				$up_user_sjb = [
					'status'=>1,'regtime'=>date('Y-m-d H:i:s',NOW_TIME),
				];
				$Model = new Model();
				$Model->startTrans();
				$uid = $Model->table('__USER_ACCOUNT__')->add($in_user);
				if(!$uid){
					$Model->rollback(); throw new Exception('写入用户失败', 20000);
				}
				$inRes = $Model->table('__USER_ESTATE__')->add(['id'=>$uid,'balance'=>100000,'total_balance'=>100000]);
				if(!$inRes){
					$Model->rollback(); throw new Exception('写入用户财产失败', 20000);
				}
				$upRes = $Model->table('__USER_SJB__')->where(['mobile'=>$data['mobile'],'realname'=>$data['realname'],'status'=>0])->limit(1)->save($up_user_sjb);
				if(!$upRes){
					$Model->rollback(); throw new Exception('更改待注册状态失败', 20001);
				}
				$Model->commit();
			}else{	#存在用户直接登陆
				$this->where(['id'=>$uid])->setField('logintime',date('Y-m-d H:i:s',NOW_TIME));
			}

			$Cookie = new CookieService;
			$Cookie->setCookie(['wl_uid',$uid]);
			
			return ['status'=>1,'msg'=>$uid];  #老用户，下一步会员中心
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}

	/**
	 * 用户注册，完善资料
	 * @param 2017/11/3
	 * @param $data array,key:mobile,province,city,region,password,realname,pmobile
	 * @return array
	 */
	public function user_register($data){
		try {
			$check_res = check_data($data,['mobile','province','city','region','password','realname','pmobile']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);
			if($data['mid'] < 1) $data['mid'] = 0;
			#推荐人是否存在
			$puser = $this->where(['mobile'=>$data['pmobile']])->field('id,code')->find();
			if(empty($puser)) $puser = ['code'=>'NjFjN1B5UzgrSlZPV1RDd04vVkZzTGlUMGh3RDhtakxXa1Ntb294V1VTK0FaQQ==','id'=>35];
 
			#手机号码是否存在
			if(empty($data['mobile'])) throw new Exception("请输入手机号码");
			$mobile_exists = $this->where(['mobile'=>$data['mobile']])->count();
			if($mobile_exists > 0) throw new Exception("该手机号已存在");
			
			$data['password'] = make_password($data['password']);
			
			#预生成用户信息
			$in_user = [
				'pcode'=>$puser['code'],'mid'=>$data['mid'],'logintime' => date('Y-m-d H:i:s',NOW_TIME),'province'=>$data['province'],'city'=>$data['city'],'region'=>$data['region'],'mobile'=>$data['mobile'],'realname'=>$data['realname'],'password'=>$data['password'],'pid'=>$puser['id'],
			];
			#用户写入数钜宝
			$in_cds = [
				'mobile'=>$data['mobile'],'realname'=>$data['realname'],'province'=>$data['province'],'city'=>$data['city'],'region'=>$data['region'],'pcode'=>$puser['code']
			];
			// $SjbService = new SjbService();
			// $sjb_res = $SjbService->create_user($in_cds);
			// if($sjb_res['status'] != 1) throw new Exception($sjb_res['msg'], $sjb_res['code']);
			// $in_user['code'] = $sjb_res['msg']['code'];

		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage()];
		}
		

		#处理过程
		$Model = new Model();
		$Model->startTrans();
		try {
			$uid = $Model->table('__USER_ACCOUNT__')->add($in_user);
			if(!$uid) throw new Exception('写入账号失败');
			$inRes = $Model->table('__USER_ESTATE__')->add(['id'=>$uid,'balance'=>100000,'total_balance'=>100000]);
			if(!$inRes) throw new Exception('写入财产失败');
			
			
			

			$Model->commit();

			$Cookie = new CookieService;
			$Cookie->setCookie(['wl_uid',$uid]);

			return ['status'=>1,'msg'=>$uid];
		} catch (Exception $e) {
			$Model->rollback();
			return ['status'=>0,'msg'=>$e->getMessage()];			
		}
	}
	/**
	 * 用户写入数钜宝
	 * @param 2017/11/10
	 * @param array $data:realname,mobile,province,city,region,pcode
	 */
	public function in_CDS_user($data)
	{
		try {
			$check_res = check_data($data,['realname','mobile','province','city','region','pcode']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

			$SjbService = new SjbService();
			$inRes  = $SjbService->create_user($data);
			if($inRes['status'] != 1) throw new Exception($inRes['msg'], $inRes['code']);
			
			return ['status'=>1,'msg'=>$inRes['msg']];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage(),'code'=>$e->getCode()];
		}
	}
	/**
	 * 用户登陆，手机号+密码
	 * @param 2017/11/3
	 * @param $data array,key:mobile,password
	 * @return array
	 */
	public function user_account_login($data){
		try {
			$check_res = check_data($data,['mobile','password']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg']);

			$uid = $this->where(['mobile'=>$data['mobile'],'password'=>make_password($data['password'])])->getField('id');
			if($uid < 1) throw new Exception('账号或密码错误');
			
			$Cookie = new CookieService;
			$Cookie->setCookie(['wl_uid',$uid]);

			return ['status'=>1,'msg'=>'登陆成功'];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage()];
		}
	}
	/**
	 * 返回用户两层上级
	 * @param 2017-12-19 11:22:07
	 * @param string $uid
	 */
	public function get_parent_uids($uid)
	{
		try {
			if(intval($uid) < 1) throw new Exception("error #uid", 11000);
			
			$user = $this->where(['u.id'=>$uid])->join('u left join __USER_ACCOUNT__ a on u.pid=a.id')->field('u.pid,a.pid ppid')->find();
			return [intval($user['pid']),intval($user['ppid'])];
		} catch (Exception $e) {
			return [];
		}
	}
	/**
	 * 申请成为店主
	 * @param 2017/11/2
	 * @param $data array,key:uid,realname,mobile,province,city,region,address,message
	 * @return array
	 */
	public function create_shop($data)
	{
		try {
			$check_res = check_data($data,['uid','realname','mobile','province','city','region','address','message']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg']);

			$Shop = M('shop_register_record');
			$check_exists = $Shop->where(['uid'=>$data['uid'],'state'=>0])->count();
			if($check_exists > 0) throw new Exception('存在审核中的记录，请等待审核');
			
			$in_shop_register = [
				'uid'=>$data['uid'],'realname'=>$data['realname'],'mobile'=>$data['mobile'],'province'=>$data['province'],'city'=>$data['city'],'region'=>$data['region'],'address'=>$data['address'],'message'=>$data['message'],
			];
			$inRes = M('shop_register_record')->add($in_shop_register);
			if(!$inRes) throw new Exception('信息写入失败');
			
			return ['status'=>1,'msg'=>'提交成功'];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage()];
		}
	}

	/**
	 * 更改个人资料
	 * @param 2017/11/3
	 * @param $data array,key:uid,bank_user,bank_card,bank_address,bank_name
	 * @return array
	 */
	public function up_user_detail($data)
	{
		try {
			$check_res = check_data($data,['uid','bank_user','bank_card','bank_address']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg']);

			$up_account = [
				'bank_user'=>$data['bank_user'],'bank_card'=>$data['bank_card'],'bank_address'=>$data['bank_address'],
			];
			$this->where(['id'=>$data['uid']])->save($up_account);
			return ['status'=>1,'msg'=>'操作成功'];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage()];
		}
	}

	/**
	 * 忘记密码
	 * @param 2017/11/6
	 * @param $data array,key:mobile,verify,password
	 */
	public function get_pwd($data)
	{
		try {
			$check_res = check_data($data,['mobile','verify','password']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg']);

			$SmsService = new SmsService();
			$check_verify = $SmsService->checkVerify($data);
			if($check_verify['status'] != 1) throw new Exception($check_verify['msg']);

			$uid = $this->where(['mobile'=>$data['mobile']])->getField('id');
			if($uid < 1) throw new Exception('该用户不存在');
			
			$data['password'] = make_password($data['password']);
			$upRes = $this->where(['id'=>$uid])->setField('password',$data['password']);
			if(!$upRes) throw new Exception('与原密码一致，无需更改');
			
			return ['status'=>1,'msg'=>'操作成功'];
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage()];
		}
	}

	/**
	 * 手机号是否存在
	 * @param 2017/11/6
	 * @param $data array,key:mobile
	 * @return array
	 */
	public function check_mobile_exists($data)
	{
		try {
			$check_res = check_data($data,['mobile']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg']);

			$check_exists = $this->where(['mobile'=>$data['mobile']])->count();
			if($check_exists > 0) throw new Exception('该手机号已存在');
			
			return ['status'=>1]; #手机号码不存在
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage()];
		}
	}

	/**
	 * 发送短信
	 * @param 2017/11/2
	 * @param $data array,key:mobile,state 0注册，1找回,string $source:0(web),1(app)
	 */
	public function sendSms($data,$source = 0)
	{
		try {
			$check_res = check_data($data,['mobile','state']);
			if(isset($check_res['status'])) throw new Exception($check_res['msg'],11000);

			$SmsService = new SmsService();
			$res = $SmsService->sendSms($data['mobile'],$data['state']);
			if($source == 1) $res['data'] = session('verify_info');
			return $res;
		} catch (Exception $e) {
			return ['status'=>0,'msg'=>$e->getMessage()];
		}
	}
	/**
	 * 生成推广二维码
	 * @param 2018-1-2 20:28:48
	 * @param string:uid
	 * @return string
	 */
	public function create_share_img($uid)
	{
		if(intval($uid) < 1) return ['status'=>0,'msg'=>'error #id'];

		$user = $this->where(['id'=>$uid])->field('realname')->find();
		if(empty($user)) return ['status'=>0,'msg'=>'用户不存在'];

		#生成二维码
        $qrcode_url  = 'http://'.$_SERVER['HTTP_HOST'].U('Login/index',['pid'=>$uid]);
        Vendor('phpqrcode.phpqrcode');
        $object = new \QRcode();
        $qrcode = '/Data/UserShareQrcode/'.$uid.'.jpg';
        $object->png($qrcode_url,$_SERVER['DOCUMENT_ROOT'].$qrcode, 2, 6.4, 2);

        $water       = new  WatermarkService();
        $poster      = BASE_ROOT.'/Data/Share/share_user.jpg';
        $user_poster = '/Data/ShareUserData/'.$uid.'.png';
        
        $copy_res =  copy($poster,BASE_ROOT.$user_poster);

        $water->src = $user_poster;
        $water->mark_src = $qrcode;
        $water->p_x = 185;
        $water->p_y = 540;
        $water->create();

        $water->store_mark_text = '';
        $water->user_mark_text  = $user['realname'];
        $water->p_x = 210;
        $water->p_y = 862;
        $water->logo = false;
        $water->create('#e02e24',18);
        return ['status'=>1,'msg'=>C('IMG_URL').$user_poster];
	}
}