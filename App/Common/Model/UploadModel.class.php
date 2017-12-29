<?php
namespace Common\Model;
use Think\Model;
class UploadModel extends Model{
	protected $autoCheckFields = false;
	// protected $tableName='user';
	#多个上传图片
	public function uploads($name,$url){
		$file  = $_FILES[$name];
		$is_dir = $url.date('Y-m-d').'/';
		$res = zt_mkdir($is_dir);
		$check = [
			'size' => 102400,
			'exts' => ['jpg','gif','jpeg','png'],
			'rootPath' => $_SERVER['DOCUMENT_ROOT'].'/'.$is_dir,
		];  
		 
		$re = [];
		 
		foreach ($file['size'] as $key => $value) {

			if(!$value) continue;
			$exp = array_pop(explode('/',$file['type'][$key]));
		 	if(!in_array($exp,$check['exts'])) return ['status'=>0,'msg'=>'图片格式有误'];
		 	
			if($value>$check['size']) return ['status'=>0,'msg'=>'图片大小超过限制'];
			
		 	$newname = substr(md5(NOW_TIME),8,16).rand(1000,9999).'.'.$exp;
		 	rename($file['tmp_name'][$key], $check['rootPath'].$newname);
			$re[$key] = $is_dir.$newname;
		}

		return ['status'=>1,'msg'=>$re];
	}
	#单个图片上传
	public function upload($name,$url){
		$file  = $_FILES[$name];
		$is_dir = $url.date('Y-m-d').'/';
		$res = zt_mkdir($is_dir);
		$check = [
			'size' => 102400,
			'exts' => ['jpg','gif','jpeg','png'],
			'rootPath' => $_SERVER['DOCUMENT_ROOT'].'/'.$is_dir,
		];  
 		 
		$re = [];
		$exp = array_pop(explode('/',$file['type']));
		if(!in_array($exp,$check['exts'])) return ['status'=>0,'msg'=>'图片格式有误'];
		if($file['size']>$check['size']) return ['status'=>0,'msg'=>'图片大小超过限制'];
		$newname = substr(md5(NOW_TIME),8,16).rand(1000,9999).'.'.$exp;
		rename($file['tmp_name'], $check['rootPath'].$newname);
		$re = [$is_dir.$newname];
		return ['status'=>1,'msg'=>$re];
	}
}