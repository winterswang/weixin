<?php

class fileUpload
{

    private $returnCode = 0;
    private $attachPath = '';
    private $mode = null;
    private $file = null;
    public $attach = array();
	
	private $forcible_upload = false;

    public function __construct($savepath = '')
    {
        if (!$savepath || !is_dir($savepath)) {
             throw new Exception("'{$savepath}' Is not a valid directory");
        }
		
		$this->setAttachPath($savepath);
    }

    public function init($fieldname,$isUrl = false)
    {
		if($isUrl == true){
			$save_path = $this->getAttachPath().'/tmp';
			$this->file = $this->getInstanceByUrl($fieldname,$save_path);
		}else{
			$this->file = $this->getInstanceByName($fieldname);
		}

        if ($this->file == null) {
            $this->returnCode = -1;
            return false;
        }
// || $this->file['size'] > $this->getAllowMaxUpload()
        if ($this->file['error'] == UPLOAD_ERR_INI_SIZE ) {
            $this->returnCode = -2;
            return false;
        }

        $attach['size'] = $this->file['size'];
        $attach['type'] = $this->file['type'];
        $attach['ext'] = $this->getExtensionName($this->file['name']);
        $attach['isimage'] = $this->isImage($attach['ext']);
        $attach['name'] = $this->file['name'];
        if (strlen($attach['name']) > 90) {
            $attach['name'] = cutstr($attach['name'], 80, '') . '.' . $attach['ext'];
        }

        $this->attach = & $attach;

        return true;
    }
	
    function getInstanceByUrl($url,$save_path = '/tmp') {
		$this->forcible_upload = true;
		
  //       $responseHeaders = array();
  //       $originalfilename = $ext = $response = '';
		
		// $url_info = parse_url($url);
		// $host = $url_info['host'];
		// $header = array(
		// 	'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
		// 	'Accept-Charset: UTF-8,*',
		// 	'Accept-Encoding: gzip, deflate',
		// 	'Accept-Language: en-us,en;q=0.5',
		// 	'Connection: keep-alive',
		// 	"Host: {$host}",
		// 	"User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31;",
		// );

       $ch = curl_init($url);
		// curl_setopt($ch, CURLOPT_HTTPHEADER, $header);	
  //       curl_setopt($ch, CURLOPT_HEADER, 1);
  //       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);       
  //       curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  //       curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
		// curl_setopt($ch, CURLOPT_TIMEOUT,240);
		  
		// $response = curl_exec($ch);
  //       $httpinfo = curl_getinfo($ch);
  //       curl_close($ch);
    	curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);

        // execute and return string (this should be an empty string '')
        $response = curl_exec($ch);

        curl_close($ch);

         if ($response !== false) {
        //     $httpArr = explode("\r\n\r\n", $response, 2 + $httpinfo['redirect_count']);
        //     $header = $httpArr[count($httpArr) - 2];
        //     $body = $httpArr[count($httpArr) - 1];
        //     $header.="\r\n";

   //          preg_match_all('/([a-z0-9-_]+):\s*([^\r\n]+)\r\n/i', $header, $matches);
   //          if (!empty($matches) && count($matches) == 3 && !empty($matches[1]) && !empty($matches[1])) {
   //              for ($i = 0; $i < count($matches[1]); $i++) {
   //                  if (array_key_exists($i, $matches[2])) {
   //                      $responseHeaders[$matches[1][$i]] = $matches[2][$i];
   //                  }
   //              }
   //          }
            // if (0 < preg_match('{(?:[^\/\\\\]+)\.(jpg|jpeg|gif|png|bmp)$}i', $url, $matches)) {
            //     $originalfilename = $matches[0];
            //     $ext = $matches[1];
            // } else {
            //     if (array_key_exists('Content-Type', $responseHeaders)) {
            //         if (0 < preg_match('{image/(\w+)}i', $responseHeaders['Content-Type'], $extmatches)) {
            //             $ext = $extmatches[1];
            //         }
            //     }
            // }
			
			 $size = 1024000;
			// if(array_key_exists('Content-Length', $responseHeaders)) {
			// 	$size = intval($responseHeaders['Content-Length']);
			// }
			
			 $type = '';
			// if(array_key_exists('Content-Type', $responseHeaders)) {
			// 	$type = $responseHeaders['Content-Type'];
			// }

            $ext = 'jpg';//暂时是jpg格式
			$filename = $this->random(9).".".$ext;
			$file_path = $save_path .'/'.$filename;
			if(file_put_contents($file_path,$response) === false){
				return null;	
			}

			$file = array(
				'size' => $size,
				'type' => $type,
				'ext' => $ext,
				'name' => $filename,
				'tmp_name' => $file_path,
				'error' => UPLOAD_ERR_OK
			);
			return $file;
        }
        return null;
    }	
	
	function getInstanceByName($name){
		
		if(!isset($_FILES) || !is_array($_FILES))
			return null;
		
		/*
		$files = array();
		foreach($_FILES as $class=>$info)
			foreach($info as $key => $value)
				$files[$key][$class] = $value;
		*/
		return isset($_FILES[$name]) && $_FILES[$name]['error']!=UPLOAD_ERR_NO_FILE ? $_FILES[$name] : null;
	}
	
    public function saveFile($type = 'temp', $savetype = 0, $forcename = '')
    {
        $attachdir = $this->getTargetDir($type, $savetype);//附件地址
        $attachment = $attachdir . $this->getFilename($type, $forcename) . '.' . $this->attach['ext'];//照片名称
        $target = $this->getAttachPath() . '/' . $attachment;//目标地址+图片名称

        if (!$this->saveAs($target)) {
            $this->returnCode = -3;       
            return false;
        } else if ($this->attach['isimage'] && !$this->checkImage($target)) {  
            $this->returnCode = -4;
            return false;
        }

        $this->attach['attachdir'] = $attachdir;
        $this->attach['attachment'] = $attachment;
        $this->attach['target'] = $target;

        return true;
    }

    function isImage($ext)
    {
        $imgext = array('jpg', 'jpeg', 'gif', 'png', 'bmp');
        return in_array($ext, $imgext) ? 1 : 0;
    }

    function checkImage($target)
    {
        return true;
        // echo "checkImage size:".getimagesize($target)."\r\n";
        // if (!is_readable($target)) {
        //     echo "is not readable\r\n";
        //     return false;
        // } elseif ($imageinfo = @getimagesize($target)) {
        //     list($width, $height, $type) = !empty($imageinfo) ? $imageinfo : array('', '', '');
        //     $size = $width * $height;
        //     if ($size > 16777216 || $size < 16) {
        //         echo "size is too big\r\n";
        //         return false;
        //     } elseif (!in_array($type, array(1, 2, 3, 6,13))) {//9,11,12,

        //         return false;
        //     }
        //     return true;
        // } else {
        //     return false;
        // }
    }
	
	public function saveAs($file,$deleteTempFile=true)
	{

		if($this->file['error']==UPLOAD_ERR_OK)
		{
			if($this->forcible_upload == true)
				return rename($this->file['tmp_name'], $file);
			else if($deleteTempFile)
				return move_uploaded_file($this->file['tmp_name'],$file);
			else if(is_uploaded_file($this->file['tmp_name']))
				return copy($this->file['tmp_name'], $file);
			else
				return false;
		}
		else{
			return false;
		}
	}

	public function getExtensionName($name)
	{
		if(($pos=strrpos($name,'.'))!==false)
			return (string)substr($name,$pos+1);
		else
			return '';
	}	
	
    function setAttachPath($path)
    {
        $this->attachPath = $path;
    }

    function getAttachPath()
    {
        return $this->attachPath;
    }

    function getErrorCode()
    {
        return $this->returnCode;
    }

    function getErrorMsg()
    {
        $messages = array(
            -1 => 'No file uploaded',
            -2 => 'File exceeded upload_max_filesize',
            -3 => 'Upload failed',
            -4 => 'Is not a valid file'
        );

        return isset($messages[$this->returnCode]) ? $messages[$this->returnCode] : '';
    }

    function getFilename($type, $forcename = '')
    {
		
        $filename = date('His') . strtolower($this->random(16));

        if ($forcename != '') {
            $filename .= "_$forcename";
        }
        return $filename;
    }

    function getTargetDir($type, $savetype = 0, $check = true)
    {

        $subdir = $subdir1 = $subdir2 = '';

        switch ($savetype) {
            case 1:
                break;
            case 2:
                break;
            default:
                $subdir1 = date('Ym');
                $subdir2 = date('d');

                $subdir = $subdir1 . '/' . $subdir2 . '/';
                break;
        }

        $check && $this->checkDir($type, $subdir1, $subdir2);

        return $type . '/' . $subdir;
    }

    function checkDir($type, $sub1 = '', $sub2 = '')
    {

        $basedir = $this->getAttachPath();

        $typedir = $type ? ($basedir . '/' . $type) : '';
        $subdir1 = $type && $sub1 !== '' ? ($typedir . '/' . $sub1) : '';
        $subdir2 = $sub1 && $sub2 !== '' ? ($subdir1 . '/' . $sub2) : '';

        $res = $subdir2 ? is_dir($subdir2) : ($subdir1 ? is_dir($subdir1) : is_dir($typedir));
        if (!$res) {
            $res = $typedir && $this->makeDir($typedir);
            $res && $subdir1 && ($res = $this->makeDir($subdir1));
            $res && $subdir1 && $subdir2 && ($res = $this->makeDir($subdir2));
        }

        return $res;
    }

    function makeDir($dir, $index = true)
    {
        $res = true;
        if (!is_dir($dir)) {
            $res = @mkdir($dir, 0777);
            $index && @touch($dir . '/index.html');
        }
        return $res;
    }

    function getAllowMaxUpload()
    {
        $max = @ini_get('upload_max_filesize');
        $unit = strtolower(substr($max, -1, 1));
        if ($unit == 'k') {
            $max = intval($max) * 1024;
        } elseif ($unit == 'm') {
            $max = intval($max) * 1024 * 1024;
        } elseif ($unit == 'g') {
            $max = intval($max) * 1024 * 1024 * 1024;
        }
        return $max;
    }
	
	function random($length, $numeric = 0)
	{
		$seed = base_convert(md5(microtime() . $_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
		$seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed . 'zZ' . strtoupper($seed));
		$hash = '';
		$max = strlen($seed) - 1;
		for ($i = 0; $i < $length; $i++) {
			$hash .= $seed{mt_rand(0, $max)};
		}
		return $hash;
	}
	

}