<?php
function p($arr){
    echo '<pre>';
    is_array($arr) ? print_r($arr) : var_dump($arr);
    echo '</pre>';
}
/* 获得分页limit */
function getLimit($size=6){
    if(isset($_GET['p'])) $p = I('get.p');
    else $p = I('post.p');
    $p = $p ? $p : 1;
    $start    = ($p-1)*$size;
    return $start.','.$size;
}
/**
 * 返回用户类型
 */
function getGrade($i)
{
    $arr = ['消费者','店家'];
    return $arr[$i];
}
/* 转换实体 */
function turnStr($str){
    $arr  = array('&amp;','&lt;','&gt;','&quot;');
    $rarr = array('&','<','>','"');
    return str_replace($arr,$rarr,$str);
}
function getPayType($i)
{
    $arr = ['微信支付','支付宝支付','余额支付'];
    return $arr[$i];
}
function getTradeStatus($i)
{
    $arr = ['待付款','待发货','已发货','已收货','退款中','退款成功'];
    return $arr[$i];
}
function turnDecimal($str){
    return sprintf('%.2f',$str);
}

/**
 * 登陆密码不可逆加密
 * @param string
 * @return string
 */
function make_password($str)
{
    return md5(md5($str).',auth:281140052@qq.com');
}
    /**
 * 创建目录（如果该目录的上级目录不存在，会先创建上级目录）
 * 依赖于 ROOT_PATH 常量，且只能创建 ROOT_PATH 目录下的目录
 * 目录分隔符必须是 / 不能是 \
 *
 * @param   string  $absolute_path  绝对路径
 * @param   int     $mode           目录权限
 * @return  bool
 */
function zt_mkdir($absolute_path, $mode = 0777)
{
    if (is_dir($absolute_path))
    {
        return true;
    }

    $root_path      = $_SERVER['DOCUMENT_ROOT'];
    $relative_path  = str_replace($root_path, '', $absolute_path);
    $each_path      = explode('/', $relative_path);
    $cur_path       = $root_path; // 当前循环处理的路径
    foreach ($each_path as $path)
    {
        if ($path)
        {
            $cur_path = $cur_path . '/' . $path;
            if (!is_dir($cur_path))
            {
                if (@mkdir($cur_path, $mode))
                {
                    fclose(fopen($cur_path . '/index.htm', 'w'));
                }
                else
                {
                    return false;
                }
            }
        }
    }
    return true;
}
/**
 * 验证数据是否为空
 * @param $data array, $continue string
 * @return array
 */
function check_data($data,$check = []){
	foreach ($check as $key => $value) {
		if(!array_key_exists($value, $data)) return ['status'=>0,'msg'=>$value.',异常'];
		if(!isset($data[$value])) return ['status'=>0,'msg'=>$value.',不能为空'];
	}
	return $data;
}
/* curl请求*/
function https_request($url,$data){
    $curl = curl_init();
    curl_setopt($curl,CURLOPT_SAFE_UPLOAD,false);  
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
  
    return $output;
}
/**
 * xml转json，返回数组
 * @param 2017/11/2
 * @param $xml xml
 * @return array
 */
function xml_to_array($xml){
	return  json_decode(json_encode(simplexml_load_string($xml)),true);
}

/* 获得当前完成地址  */
function getFullUrl() {
    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
    return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
}
function getBankInfo($str,$i){
    $new = explode(',',$str);
    if($i=='-1') return $new;
    return $new[$i];
}