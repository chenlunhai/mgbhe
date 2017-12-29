<?php
define('BASE_ROOT',$_SERVER['DOCUMENT_ROOT']);
 
return array(
	'OBJECT_NAME' 	=> '麦光宝盒',
	'LOG_FILE' => BASE_ROOT.'/Data/Log/',
	'CDS_URL'  => 'http://sjb.wlylai.com/',
	'AREA_URL' => 'http://'.$_SERVER['HTTP_HOST'].'/Data/Json/area.json',
	'IMG_URL'  => 'http://'.$_SERVER['HTTP_HOST'],
	'ALI_IMG_URL' => 'http://sjb-img.oss-cn-shenzhen.aliyuncs.com/',		#图片路径-阿里云对象存储oss
);  








?>