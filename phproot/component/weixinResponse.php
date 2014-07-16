<?php
class weixinResponse
{
	private $_xmlData = array();
	private $error_msg;

	public function listening(){
		
		$postStr = isset($GLOBALS["HTTP_RAW_POST_DATA"]) ? $GLOBALS["HTTP_RAW_POST_DATA"] : null;
		if(empty($postStr)){
			$echostr = isset($_GET['echostr']) ? $_GET['echostr'] : 'error';;
			echo $echostr;exit;
                        $this->setError($echostr);
			return false;
		}
                file_put_contents("/home/wgc/project/php/apps/weixin_dev/logs/wx_ligthbro.log", $postStr."\n", FILE_APPEND);
		$this->_xmlData = XmlParse::XML2Array($postStr);
		return true;
	}
		
	public function __get($name){
		if(isset($this->_xmlData[$name])){
			return $this->_xmlData[$name];
		}

		return null;
	}
	
	public function __set($name,$value){
		$this->_xmlData[$name] = $value;
	}
	
	function setError($msg){
		$this->error_msg = $msg;
	}
	
	function error(){
		return $this->error_msg;
	}
}
