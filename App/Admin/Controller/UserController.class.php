<?php

namespace Admin\Controller;

use Think\Controller;

class UserController extends RunController {

	public function search(){

		$assign = [];

		$where['_string'] = ' 1=1 ';

		

		#注册 开始时间

		$assign['stime'] = $stime = $_POST['stime'] ? I('post.stime') : I('get.stime');

		if(!empty($stime)){

			$where['_string'] .= ' and UNIX_TIMESTAMP(addtime)>'.strtotime($stime);

		}

		#注册 结束时间

		$assign['dtime'] = $dtime = $_POST['dtime'] ? I('post.dtime') : I('get.dtime');

		if(!empty($dtime)){

			$where['_string'] .= ' and UNIX_TIMESTAMP(addtime)<'.(strtotime($dtime)+3600*24);

		}



		#申请姓名

		$assign['realname'] = $realname = $_POST['realname'] ? I('post.realname') : I('get.realname');

		if(!empty($realname)){

			$where['_string'] .= " and realname like '%".$realname."%'";

		}



		#手机号码

		$assign['mobile'] = $mobile = $_POST['mobile'] ? I('post.mobile') : I('get.mobile');

		if(!empty($mobile)){

			$where['_string'] .= " and mobile like '%".$mobile."%'";

		}

		

		$this->assign('assign',$assign);

		$assign['where'] = $where;

		return $assign;

	}

 

	/*用户列表*/

	public function index(){

		$pageSize = 25;    
		$limit = getLimit($pageSize);

		$status = I('post.state'); #To determine whether the data is exported
		if($state) $limit = ''; #Export all data under current conditions

		#搜索条件
		$search = $this->search();
		$where = $search['where'];
		#查询数据
		$Model = D('user_account');
		$join = "".C("DB_PREFIX")."user_estate as b on b.id = o.id";
		$field = "o.id,o.mobile,o.addtime,o.logintime,o.realname,o.province,o.city,o.region,b.grade,b.supply_grade, b.agent_grade,b.balance,b.integral";
		$data  = $Model->alias('o')->join($join)->where($where)->field($field)->order('id desc')->limit($limit)->select();
 
		$this->assign('data',$data);
		/*#导出数据
		if($state) exit($this->ExportUserList($data,$search['time'],$shop['name']));*/
		#分页
		$count = $Model->alias('o')->where($where)->count();
		$this->assign('count',$count);
		unset($search['_string'],$search['where']);
		$Page  = new \Think\Page($count,$pageSize,$search); 
		$show  = $Page->show(); 
		$this->assign('page',$show);
		$this->display(); 

	}



	/**

	 * 更改用户个人资料

	 */

	public function up_user_detail(){

		$User = M('user_account');

		if(!IS_POST){

			$id = I('get.id',0);

			$user = $User->find($id);

			$this->assign('user',$user);

			exit($this->display());

		}

		$post = I('post.');

		$id   = $post['uid']; unset($post['uid']);

		$res  = $User->where(['id'=>$id])->save($post);

		$this->msg(1,'操作成功');

	}



	/**

	 * 身份转换记录

	 * @param  2017/10/11

	 */

	public function turn_grade_record()

	{

		$User = M('grade_chage_record');

		$pageSize = 20;

		$limit = getLimit($pageSize);

		

		$user  = $User->where($where)->join('u left join __USER__ e on u.uid=e.id')->field('u.*,e.mobile,e.push_sn,e.realname')->order('u.id desc')->limit($limit)->select();

		$this->assign('user',$user);

		

 

		#分页

		$count = $User->alias('u')->where($where)->count();

		$this->assign('count',$count);

		$Page  = new \Think\Page($count,$pageSize); 

		unset($search['_string']);

		foreach ($search as $key => $value) {

			$Page->parameter[$key] = ($value);

		}

		$show  = $Page->show(); 

		$this->assign('page',$show);

		$this->display();

	}

	

	#代激活商家的VIP会员

	public function shop_list()

	{

		$search = I();

		$this->assign('assign',$search);

		$where  = [];

		if(!empty($search['account'])){

		   $where['u.mobile'] = $search['account'];

		}

		 

		$User = M('user');

		$pageSize = 20;

		$limit = getLimit($pageSize);

		$where['u.grade'] = 3;

		$where['u.shop_status'] = 0;

		$user  = $User->where($where)->join('u left join __USER_ESTATE__ e on u.id=e.id')->field('e.*,u.realname,u.pid,u.province,u.city,u.region,u.mobile,u.grade,u.agent_grade,u.addtime')->order('u.id desc')->limit($limit)->select();

		$this->assign('user',$user);

		

 

		#分页

		$count = $User->alias('u')->where($where)->count();

		$this->assign('count',$count);

		$Page  = new \Think\Page($count,$pageSize); 

		unset($search['_string']);

		foreach ($search as $key => $value) {

			$Page->parameter[$key] = ($value);

		}

		$show  = $Page->show(); 

		$this->assign('page',$show);

		$this->display();

	}

	#VIP会员激活为商家

	public function up_user_shop_status()

	{

		$id = I('post.id');

		$res = D('shop')->register_shop($id);

		$this->ajaxReturn($res);

	}

	#商家设置为供应商

	public function set_supplier()
	{

		$id = I('post.id');

		$state = I('post.state');

		$res = D('shop_record')->set_supplier(['id'=>$id, 'state'=>$state]);

		$this->ajaxReturn($res);

	}

	public function set_grade()
	{

		$id = I('post.id');

		$state = I('post.state');

		$res = D('shop_record')->set_grade(['id'=>$id, 'state'=>$state]);

		$this->ajaxReturn($res);

	}

	public function set_agent()
	{
		if(!IS_POST){

			$User = M('user_account');
			$join = "".C("DB_PREFIX")."user_estate as b on b.id = o.id";
			$field = "o.*, b.agent_grade, b.agent_fee";

			$id = I('get.id',0);

			$user = $User->alias('o')->join($join)->where(['o.id'=>$id])
				->field($field)->find();
			if ($user['agent_fee'] < 0.01) {
				$user['agent_fee'] = '';
			}

			$this->assign('user',$user);

			exit($this->display());

		}

		$post = I('post.');

		$id   = $post['uid'];
		unset($post['uid']);

		if ($post['agent_fee'] < 0.01) {
			$this->msg(0, '请输入代理费');
		}
		if (! in_array($post['agent_grade'], [1, 2])) {
			$this->msg(0, '请选择代理级别');
		}

		$Model = new \Think\Model();
		$Model->startTrans();
		try {
			$estateModel = M('user_estate');
			$res  = $estateModel->where(['id'=>$id])->save($post);
			if(!$res) throw new \Exception("更改状态失败，请稍后重试");

			$agentModel = M('agent_record');
			$post['state'] = $post['agent_grade'];
			$post['money'] = $post['agent_fee'];

			if ($agentModel->where(['uid'=>$id])->count()) {
				$res2  = $agentModel->where(['uid'=>$id])->save($post);
			} else {
				$post['uid'] = $id;
				$res2  = $agentModel->add($post);
			}

			if(!$res2) throw new \Exception("代理记录写入失败");

			$Model->commit();
			$this->msg(1,'操作成功');
		} catch (\Exception $e) {
			$Model->rollback();
			$this->msg(0, $e->getMessage());
		}
	}

	#积分明细

	public function integral_list(){

		$id = I('get.id',0);

		$state = I('get.state');

		$where = ['uid'=>$id,'state'=>$state];

		$Integral = M('integral_record');

		$pageSize = 20;

		$limit = getLimit($pageSize);

		$integral_list = $Integral->where($where)->limit($limit)->select();

		$this->pageLimit($where,$Integral,$pageSize,$search);

		$this->assign('integral_list',$integral_list);

		$this->display();

	}

	#财富积分兑换列表

	public function wealth_integral_list(){

		$User = M('wealth_integral_record');

		$where = [];

		$pageSize = 20;

		$limit = getLimit($pageSize);

		$user  = $User->where($where)->order('id desc')->limit($limit)->select();

		$this->pageLimit($where,$User,$pageSize,$search);

		$this->assign('user',$user);

		$this->display();

	}

	#财富积分兑换处理

	public function up_wealth_integral_record(){

		$post 	= I('post.');

		$res 	= D('user')->up_wealth_integral_record($post);

		$this->ajaxReturn($res);

	}

	#通过用户手机获取用户名称

	public function getPhone(){

		$mobile = I('mobile');

		if(empty($mobile)) $this->ajaxReturn(['status'=>0,'msg'=>'未找到该用户']);

		$user = M('user')->where(['_string'=>'mobile="'.$mobile.'" or push_sn ="'.$mobile.'"'])->field('realname')->find();

		if(empty($user['realname']))  $this->ajaxReturn(['status'=>0,'msg'=>'未找到该用户']);

		$this->ajaxReturn(['status'=>1,'msg'=>$user['realname']]);

	}

	public function edit(){

		$User = M('user');

		if(!IS_POST){

			$id = I('get.id');

			$user = $User->find($id);

			$this->assign('user',$user);

			$this->display();

			die;

		}

		$post = I('post.');

		$id = $post['id'];unset($post['id']);

 

		

		$res = $User->where(['id'=>$id])->save($post);

		echo $res ? $this->msg(1,'编辑成功') : $this->msg(0,'编辑失败');

	}

	#更改用户代理等级

	public function grade_edit()

	{

		$User = D('user');

		if(!IS_POST){

			$id = I('get.id');

			$user = $User->find($id);

			$this->assign('user',$user);



			$grade = M('grade')->select();

			$this->assign('grade',$grade);

			exit($this->display());

		}

		$post = I('post.');

		$res  = $User->add_user_agent_grade($post);

		$this->msg($res['status'],$res['msg']);

	}

	/*用户提现*/

	public function cashList(){

		$assign = I();

		$this->assign('assign',$assign);

		 

		$where = [];

		if(!empty($assign['mobile'])){

			$where['c.uid'] = M('user')->where(['mobile'=>$assign['mobile']])->getField('id');



		}

		if($assign['status'] > -1){

			$where['c.state'] = $assign['status'];

		}

		 



		$User = M('cash_record');

		$pageSize = 20;

		

		$limit = getLimit($pageSize);

		if($assign['state'] == 1) $limit = '';

		$user  = $User->where($where)->join('c left join __USER__ as u on c.uid = u.id')->field('c.*,u.bank_user,u.mobile,u.push_sn')->order('id desc')->limit($limit)->select();

		if($assign['state'] == 1) exit(D('Exprot')->exprot_cash_list($user));



		$this->assign('data',$user);



		$count = $User->alias('c')->where($where)->count();

		$this->assign('count',$count);

		$Page  = new \Think\Page($count,$pageSize); 

		foreach ($assign as $key => $value) {

			$Page->parameter[$key] = ($value);

		}

		$show  = $Page->show(); 

		$this->assign('page',$show);



		

		$this->display();

	}

	public function withdrawals(){
		$pageSize = 25;
		$limit = getLimit($pageSize);

		$status = I('post.status'); #To determine whether the data is exported
		if($status) $limit = ''; #Export all data under current conditions

		#搜索条件
		$search = $this->search_withdrawals();
		$where = $search['where'];

		#查询数据
		$Model = M('user_cash_record');
		$joinAccount = " LEFT JOIN ".C("DB_PREFIX")."user_account as a on a.id = o.uid";
		$field = "o.*,a.realname";
		$data  = $Model->alias('o')->join($joinAccount)
			->where($where)->field($field)
			->order('id desc')->limit($limit)->select();
		$this->assign('data',$data);

		/*#导出数据
		if($status) exit($this->ExportShopRecord($data,$search['time'],$shop['name']));*/

		#分页
		$count = $Model->alias('o')->where($where)->count();
		$this->assign('count',$count);
		unset($search['_string'],$search['where']);
		$Page  = new \Think\Page($count,$pageSize,$search);
		/*foreach ($search as $key => $value) {
			$Page->parameter[$key] = ($value);
		}*/
		$show  = $Page->show();
		$this->assign('page',$show);
		$this->display();
	}

	private function search_withdrawals(){
		$assign = [];
		$where['_string'] = ' 1=1 ';

		#开始时间
		$assign['stime'] = $stime = $_POST['stime'] ? I('post.stime') : I('get.stime');
		if(!empty($stime)){
			$where['_string'] .= ' and UNIX_TIMESTAMP(o.addtime)>'.strtotime($stime);
		}
		#结束时间
		$assign['dtime'] = $dtime = $_POST['dtime'] ? I('post.dtime') : I('get.dtime');
		if(!empty($dtime)){
			$where['_string'] .= ' and UNIX_TIMESTAMP(o.addtime)<'.(strtotime($dtime)+3600*24);
		}

		#状态
		$assign['state'] = $state = isset($_POST['state']) ? I('post.state') : I('get.state');
		if(strlen(trim($state))>0){
			$where['_string'] .= " and o.state = '{$state}'";
		}

		$this->assign('assign',$assign);
		$assign['where'] = $where;

		return $assign;
	}

	public function handle_withdrawal()
	{
		$id = I('post.id');

		$state = I('post.state') ? 2 : 1;

		$Model = new \Think\Model();
		$Model->startTrans();
		try {
			$check_res = check_data(['id'=>$id, 'state'=>$state], ['id','state']);
			if(isset($check_res['status'])) throw new \Exception($check_res['msg']);

			$handle_record = [
				'state' => $state,
			];
			$cashModel = M('user_cash_record');
			$handleRes = $cashModel->where(['id'=>$id])->limit(1)->save($handle_record);
			if(!$handleRes) throw new \Exception('更改状态失败，请稍后重试');

			$cashRes = $cashModel->where(['id'=>$id])->limit(1)
				->field('uid,money')->find();

			$userModel = M('user_estate');
			$data['balance'] = array('exp','balance+' . $cashRes['money']);
			$moneyRes  = $userModel->where(['id'=>$cashRes['uid']])->save($data);
			if(!$moneyRes) throw new \Exception("更改状态失败，请稍后重试");

			$Model->commit();
			$res = ['status' => 1, 'msg'=>'处理成功'];
		} catch (\Exception $e) {
			$Model->rollback();
			$res = ['status' => 0, 'msg'=>$e->getMessage()];
		}

		$this->ajaxReturn($res);
	}

}