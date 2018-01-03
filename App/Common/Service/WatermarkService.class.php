<?php
namespace Common\Service;
class WatermarkService 
{
	var $src ;//待处理图片
	var $mark_src; //水印图片
	var $default_mark_text=''; //默认水印文字 我是
	var $default_mark_text1='';
	var $default_mark_text2='';
	var $store_mark_text; //客户名称水印文字
	var $user_mark_text;//用户姓名水印文字
	var $mark_text_size = 18; //水印文字大小
	var $mark_text_font ='/Data/ttf/msyhbd.ttf'; //水印文字字体
	var $mark_text_color='#131415'; //水印文字颜色
	var $mark_text_color1='#131415'; //水印文字颜色
	var $mark_text_angel = 0; //水印文字角度
	var $position = 'rb'; //水印位置 lt左上  rt右上  rb右下  lb左下 其余取值为中间
	var $quality = 85; //jpg图片质量，仅对jpg有效 默认85 取值 0-100之间整数
	var $pct = 80; //水印图片融合度(透明度)
	var $logo = true;
	var $p_x = 0;
	var $p_y = 0;
	function create($mark_text_color = '',$mark_text_size = ''){
		if(!empty($mark_text_color)){
			$this->mark_text_color1 = $mark_text_color;
		}
		if(!empty($mark_text_size)){
			$this->mark_text_size = $mark_text_size;	
		}
		if(function_exists('imagecopy') && function_exists('imagecopymerge')) {
        $data = getimagesize(BASE_ROOT.'/'.$this->src);
        if ($data[2] > 3)
        {
            return false;
        }

        $src_width = $data[0];
        $src_height = $data[1];
        $src_type = $data[2];
		switch ($src_type)
        {
            case 1:
                $src_im = imagecreatefromgif(BASE_ROOT.'/'.$this->src);
                $imagefunc = function_exists('imagejpeg') ? 'imagejpeg' : '';
                break;
            case 2:
                $src_im = imagecreatefromjpeg(BASE_ROOT.'/'.$this->src);
                $imagefunc = function_exists('imagegif') ? 'imagejpeg' : '';
                break;
            case 3:
                $src_im = imagecreatefrompng(BASE_ROOT.'/'.$this->src);
                $imagefunc = function_exists('imagepng') ? 'imagejpeg' : '';
                break;
        }
		if(!$this->logo){
			$text_font = BASE_ROOT.'/Data/ttf/msyh.ttf';
			//水印文字(默认)我是
			$defaul_lineCount = explode("\r\n",$this->default_mark_text);
			$defaul_fontSize = imagettfbbox($this->mark_text_size,$this->mark_text_angle,$text_font,$this->default_mark_text);
			$defaul_insertfile_width = $defaul_fontSize[2] - $defaul_fontSize[0];
		
			$defaul_insertfile_height = count($defaul_lineCount)*($defaul_fontSize[1] - $defaul_fontSize[3]);
		
			//我为
			$defaul_lineCount = explode("\r\n",$this->default_mark_text1);
			$defaul_fontSize = imagettfbbox($this->mark_text_size,$this->mark_text_angle,$text_font,$this->default_mark_text1);
			$defaul_insertfile_width1 = $defaul_fontSize[2] - $defaul_fontSize[0];
		
			$defaul_insertfile_height1 = count($defaul_lineCount)*($defaul_fontSize[1] - $defaul_fontSize[3]);

			//代言
			$defaul_lineCount = explode("\r\n",$this->default_mark_text2);
			$defaul_fontSize = imagettfbbox($this->mark_text_size,$this->mark_text_angle,$text_font,$this->default_mark_text2);
			$defaul_insertfile_width2 = $defaul_fontSize[2] - $defaul_fontSize[0];
		
			$defaul_insertfile_height2 = count($defaul_lineCount)*($defaul_fontSize[1] - $defaul_fontSize[3]);
		
			//(store)
			$lineCount = explode("\r\n",$this->store_mark_text);
			$fontSize = imagettfbbox($this->mark_text_size,$this->mark_text_angle,$text_font,$this->store_mark_text);
			$insertfile_width = $fontSize[2] - $fontSize[0];
			$insertfile_height = count($lineCount)*($fontSize[1] - $fontSize[3]);

			//user
			$lineCount = explode("\r\n",$this->user_mark_text);
			$fontSize = imagettfbbox($this->mark_text_size,$this->mark_text_angle,$text_font,$this->user_mark_text);
			$insertfile_width1 = $fontSize[2] - $fontSize[0];
			$insertfile_height1 = count($lineCount)*($fontSize[1] - $fontSize[3]);

		}else{
			//水印图片
			$data = getimagesize(BASE_ROOT.'/'.$this->mark_src);
			$mark_width = $data[0];
			$mark_height = $data[1];
			$mark_type = $data[2];
			 
			switch ($mark_type)
			{
				case 1:
					$mark_im = imagecreatefromgif(BASE_ROOT.'/'.$this->mark_src);
					break;
				case 2:
					$mark_im = imagecreatefromjpeg(BASE_ROOT.'/'.$this->mark_src);
				 break;
				case 3:
					$mark_im = imagecreatefrompng(BASE_ROOT.'/'.$this->mark_src);
				 break;
			}	
		}
        
        
	}
	
	//合成
	if(!$this->logo){
		$position = $this->text_position($defaul_insertfile_width,$defaul_insertfile_height,$defaul_insertfile_width1,$defaul_insertfile_height1,$defaul_insertfile_width2,$defaul_insertfile_height2,$insertfile_width,$insertfile_height,$insertfile_width1,$insertfile_height1);
		 
 
		if(preg_match("/([a-f0-9][a-f0-9])([a-f0-9][a-f0-9])([a-f0-9][a-f0-9])/i", $this->mark_text_color, $color))
		{
			$red = hexdec($color[1]);
			$green = hexdec($color[2]);
			$blue = hexdec($color[3]);
			$mark_text_color = imagecolorallocate($src_im, $red,$green,$blue);
		}else{
			$mark_text_color = imagecolorallocate($src_im, 255,255,255);
		}
 
		if(preg_match("/([a-f0-9][a-f0-9])([a-f0-9][a-f0-9])([a-f0-9][a-f0-9])/i", $this->mark_text_color1, $color))
		{
			$red = hexdec($color[1]);
			$green = hexdec($color[2]);
			$blue = hexdec($color[3]);
			$mark_text_color1 = imagecolorallocate($src_im, $red,$green,$blue);
		}else{
			$mark_text_color1 = imagecolorallocate($src_im, 255,255,255);
		}
	
		//用TrueType字体向图像写入文本
		//我是
		imagettftext($src_im,$this->mark_text_size,$this->mark_text_angle,$position[0],$position[1],$mark_text_color,$text_font,$this->default_mark_text);
		//我为
		imagettftext($src_im,$this->mark_text_size,$this->mark_text_angle,$position[2],$position[3],$mark_text_color,$text_font,$this->default_mark_text1);
		//代言
		imagettftext($src_im,$this->mark_text_size,$this->mark_text_angle,$position[4],$position[5],$mark_text_color,$text_font,$this->default_mark_text2);
		

		//客户名
		imagettftext($src_im,$this->mark_text_size,$this->mark_text_angle,$position[6],$position[7],$mark_text_color1,$text_font,$this->store_mark_text);

		//用户名
		imagettftext($src_im,$this->mark_text_size,$this->mark_text_angle,$position[8],$position[9],$mark_text_color1,$text_font,$this->user_mark_text);
	}else{
		$position = $this->position_logo();
		if($mark_type==3){
			if (function_exists('imagealphablending')) imageAlphaBlending($src_im, true);
				imagecopy($src_im, $mark_im, $position[0], $position[1], 0, 0, $mark_width, $mark_height); 
			}else{
				imageCopyMerge($src_im, $mark_im, $position[0], $position[1], 0, 0, $mark_width, $mark_height, $this->pct);
			}
	
	}
 
     if ($src_type == 2)
     {
         $imagefunc($src_im, BASE_ROOT.'/'.$this->src, $this->quality);
     }
     else
     {

         $imagefunc($src_im, BASE_ROOT.'/'.$this->src);
     }
	 //释放内存
	 if($this->logo){
		imagedestroy($mark_im);
	 }

	 imagedestroy($src_im);
}

   //文字水印位置
   function text_position($defaul_insertfile_width,$defaul_insertfile_height,$defaul_insertfile_width1,$defaul_insertfile_height1,$defaul_insertfile_width2,$defaul_insertfile_height2,$insertfile_width,$insertfile_height,$insertfile_width1,$insertfile_height1){
	  
		return array($this->p_x,$this->p_y,$this->p_x,$this->p_y+$defaul_insertfile_height+35,$this->p_x+$defaul_insertfile_width1+$insertfile_width,$this->p_y+$defaul_insertfile_height+35,$this->p_x+$defaul_insertfile_width1,$this->p_y+$defaul_insertfile_height+35,$this->p_x+3+$defaul_insertfile_width,$this->p_y);
   }

	//图片水印位置
	function position_logo(){
	
		return array($this->p_x,$this->p_y);
	} 
		

	function bigWater(){
		if(function_exists('imagecopy') && function_exists('imagecopymerge')) {
        $data = getimagesize(BASE_ROOT.'/'.$this->src);
        if ($data[2] > 3)
        {
            return false;
        }
        $src_width = $data[0];
        $src_height = $data[1];
        $src_type = $data[2];
		//水印图片
        $data = getimagesize(BASE_ROOT.'/'.$this->mark_src);
        $mark_width = $data[0];
        $mark_height = $data[1];
        $mark_type = $data[2];
		switch ($src_type)
        {
            case 1:
                $src_im = imagecreatefromgif(BASE_ROOT.'/'.$this->src);
                $imagefunc = function_exists('imagejpeg') ? 'imagejpeg' : '';
                break;
            case 2:
                $src_im = imagecreatefromjpeg(BASE_ROOT.'/'.$this->src);
                $imagefunc = function_exists('imagegif') ? 'imagejpeg' : '';
                break;
            case 3:
                $src_im = imagecreatefrompng(BASE_ROOT.'/'.$this->src);
                $imagefunc = function_exists('imagepng') ? 'imagejpeg' : '';
                break;
        }
        switch ($mark_type)
        {
            case 1:
                $mark_im = imagecreatefromgif(BASE_ROOT.'/'.$this->mark_src);
                break;
            case 2:
                $mark_im = imagecreatefromjpeg(BASE_ROOT.'/'.$this->mark_src);
                break;
            case 3:
                $mark_im = imagecreatefrompng(BASE_ROOT.'/'.$this->mark_src);
                break;
        }

		
		if($mark_type==3){
			if (function_exists('imagealphablending')) imageAlphaBlending($src_im, true);
				imagecopy($src_im, $mark_im, 0, 0, 0, 0, $mark_width, $mark_height); 
			}else{
				imageCopyMerge($src_im, $mark_im, 0, 0, 0, 0, $mark_width, $mark_height, $this->pct);
			}
	
	}
     if ($src_type == 2)
     {
         $imagefunc($src_im, BASE_ROOT.'/'.$this->src, $this->quality);
     }
     else
     {
         $imagefunc($src_im, BASE_ROOT.'/'.$this->src);
     }
	
	 //释放内存
	 imagedestroy($src_im);imagedestroy($mark_im);
	}

}


?>