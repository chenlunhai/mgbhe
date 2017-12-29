<?php
namespace Common\Service;
use OSS\Core\OssException;
class AliyunService {
	static $accessid 	= 'LTAILzgKCEj3MKn7';
    static $accesskey 	= '0wlp1IjnkFHh4lpdXvjHXszSppvOL9';
    static $host 		= 'http://sjb-img.oss-cn-shenzhen.aliyuncs.com';

	/*
		true 
		上传文件至阿里云对象存储 OSS
		@param $file string,$name string
		file:远程路径，name：本地路径
	 */
	public function upload_aliyun($file,$name)
	{
		require_once $_SERVER['DOCUMENT_ROOT'].'/App/Common/Vendors/aliyunoss/samples/Object.php';
		 
		foreach ($file as $key => $value) {
			try {
				$ossClient->uploadFile($bucket, $value, $name[$key]);
			} catch (Exception $e) {
				return 0;
			}
		}
		return 1;
		 
	}
	/*
		生成远程文件地址-true
		@param $dir stirng,$file string
		return string
	 */
	public function create_file($dir,$file)
	{
		$exp  = array_pop(explode('.',$file));
		return $dir.'/'.date('Y-m-d').'/'.md5(NOW_TIME.rand(1000,9999)).'.'.$exp;
	}

	/*
		生成多个远程文件地址-true
		@param $dir stirng,$file string
		return array
	 */
	public function create_files($dir,$file)
	{
		if(empty($dir)) return ['status'=>0,'msg'=>'参数异常，请传入存放根目录'];
		if(empty($file)) return ['status'=>0,'msg'=>'异常请传入图片所存放的数组'];

		$re = [];
		foreach ($file as $key => $value) {
			$exp  = array_pop(explode('.',$value));
			$re[$key] = $dir.'/'.date('Y-m-d').'/'.md5(NOW_TIME.rand(1000,9999)).'.'.$exp;
		}
		return $re;
	}
	/**
	 * 对象存储oss-表单上传，返回配置信息-true
	 * @return array
	 */
	public function get_config($dir = 'user_dir/'){
		$id= self::$accessid;
	    $key= self::$accesskey;
	    $host = self::$host;
	    $callbackUrl =  'http://'.$_SERVER['HTTP_HOST'].'/App/Alioss/callback.php';

	    $callback_param = array('callbackUrl'=>$callbackUrl, 
	                 'callbackBody'=>'filename=${object}', 
	                 'callbackBodyType'=>"application/x-www-form-urlencoded");
	    $callback_string = json_encode($callback_param);

	    $base64_callback_body = base64_encode($callback_string);
	    $now = time();
	    $expire = 30; //设置该policy超时时间是10s. 即这个policy过了这个有效时间，将不能访问
	    $end = $now + $expire;
	    $expiration = $this->gmt_iso8601($end);

	    $dir .= date('Y-m-d').'/'.md5(NOW_TIME.rand(10000,99999));

	    //最大文件大小.用户可以自己设置
	    $condition = array(0=>'content-length-range', 1=>0, 2=>1048576000);
	    $conditions[] = $condition; 

	    //表示用户上传的数据,必须是以$dir开始, 不然上传会失败,这一步不是必须项,只是为了安全起见,防止用户通过policy上传到别人的目录
	    $start = array(0=>'starts-with', 1=>'$key', 2=>$dir);
	    $conditions[] = $start; 


	    $arr = array('expiration'=>$expiration,'conditions'=>$conditions);
	    //echo json_encode($arr);
	    //return;
	    $policy = json_encode($arr);
	    $base64_policy = base64_encode($policy);
	    $string_to_sign = $base64_policy;
	    $signature = base64_encode(hash_hmac('sha1', $string_to_sign, $key, true));

	    $response = array();
	    $response['accessid'] = $id;
	    $response['host'] = $host;
	    $response['policy'] = $base64_policy;
	    $response['signature'] = $signature;
	    $response['expire'] = $end;
	    $response['callback'] = $base64_callback_body;
	    //这个参数是设置用户上传指定的前缀
	    $response['dir'] = $dir;
	    echo json_encode($response);
	}




	 function gmt_iso8601($time) {
        $dtStr = date("c", $time);
        $mydatetime = new \DateTime($dtStr);

        $expiration = $mydatetime->format(\DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration."Z";
    }
}