<?php
namespace Supply\Controller;
use Think\Controller;
class SeachController extends RunController {
	 
	 /**
	  * 筛选条件
	  * @param 2017-12-25 09:52:18
	  */
	 public function seach()
	 {
	 	$seach = I('');
	 	$this->assign('assign',$seach);

	 	$where = ['_string'=>'1=1 ','o.did'=>parent::$adminid];

	 	return ['where'=>$where,'seach'=>$seach];
	 }
}