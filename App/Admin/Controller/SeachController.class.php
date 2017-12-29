<?php
namespace Admin\Controller;
use Think\Controller;
class SeachController extends RunController {
	#筛选 店主申请列表 数据
	public function search_register_list(){
		$assign = [];
		$where['_string'] = ' 1=1 ';
		
		#申请 开始时间
		$assign['stime'] = $stime = $_POST['stime'] ? I('post.stime') : I('get.stime');
		if(!empty($stime)){
			$where['_string'] .= ' and UNIX_TIMESTAMP(addtime)>'.strtotime($stime);
		}
		#申请 结束时间
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

		#申请状态
        $assign['state'] = $state = $_POST['state'] ? I('post.state') : I('get.state');
        if(strlen(trim($state))>0){
			$where['_string'] .= ' and state ='.$state;
		}
        
		$this->assign('assign',$assign);
		$assign['where'] = $where;
		return $assign;
	}

	#筛选 店主列表 数据
	public function search_record_list(){
		$assign = [];
		$where['_string'] = ' 1=1 ';

		#用户ID
        $assign['uid'] = $uid = $_POST['uid'] ? I('post.uid') : I('get.uid');
        if(!empty($uid)){
			$where['_string'] .= " and uid =".$uid;
		}
		
		#加入 开始时间
		$assign['stime'] = $stime = $_POST['stime'] ? I('post.stime') : I('get.stime');
		if(!empty($stime)){
			$where['_string'] .= ' and UNIX_TIMESTAMP(addtime)>'.strtotime($stime);
		}
		#加入 结束时间
		$assign['dtime'] = $dtime = $_POST['dtime'] ? I('post.dtime') : I('get.dtime');
		if(!empty($dtime)){
			$where['_string'] .= ' and UNIX_TIMESTAMP(addtime)<'.(strtotime($dtime)+3600*24);
		}

		#开业 开始时间
		$assign['open_stime'] = $open_stime = $_POST['open_stime'] ? I('post.open_stime') : I('get.open_stime');
		if(!empty($open_stime)){
			$where['_string'] .= ' and UNIX_TIMESTAMP(opentime)>'.strtotime($open_stime);
		}
		#开业 结束时间
		$assign['open_dtime'] = $open_dtime = $_POST['open_dtime'] ? I('post.open_dtime') : I('get.open_dtime');
		if(!empty($open_dtime)){
			$where['_string'] .= ' and UNIX_TIMESTAMP(opentime)<'.(strtotime($open_dtime)+3600*24);
		}

		#状态
        $assign['state'] = $state = $_POST['state'] ? I('post.state') : I('get.state');
        if(strlen(trim($state))>0){
			$where['_string'] .= ' and state ='.$state;
		}
        
		$this->assign('assign',$assign);
		$assign['where'] = $where;
		return $assign;
	}
}