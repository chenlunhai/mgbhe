<?php
/**
 * 日志写入类
 * @param 2017/11/2
 */
namespace Common\Service;
use Think\Exception;
class LogService{

	/**
	 * 写入操作日志
	 * @param 2017/11/6
	 * @param $content string
	 * @return boolean
	 */
	public function write($content)
	{
		$file = C('LOG_FILE').date('y-m-d').'.log';
	 	file_put_contents($file,$content.PHP_EOL,FILE_APPEND);
	}

}