<?php
class weixinResponse
{
	private $_xmlData = array();
	private $error_msg;
	
	public function listening(){
		$postStr = isset($GLOBALS["HTTP_RAW_POST_DATA"]) ? $GLOBALS["HTTP_RAW_POST_DATA"] : null;

		file_put_contents("/data/wwwlogs/wx_ligthbro.log", $postStr."\n", FILE_APPEND);
		
        //$postStr = "<xml><ToUserName><![CDATA[gh_7444d0ebe116]]></ToUserName><FromUserName><![CDATA[o3fzJjobA01l46K2KKmOA4t4S9MA]]></FromUserName><CreateTime>1368595481</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[a]]></Content><MsgId>5878072832348391016</MsgId></xml>";
		//event
        //$postStr = "<xml><ToUserName><![CDATA[gh_8d57caa49852]]></ToUserName><FromUserName><![CDATA[otSWhjiPFSbsI2WMFbt4tcyf8MkI]]></FromUserName><CreateTime>1368697503</CreateTime><MsgType><![CDATA[event]]></MsgType><Event><![CDATA[LOCATION]]></Event><Location_X>31.218288</Latitude><Longitude>121.432915</Longitude><Precision>65.000000</Precision></xml>";
        //location
        //$postStr = "<xml><ToUserName><![CDATA[gh_7444d0ebe116]]></ToUserName> <FromUserName><![CDATA[o3fzJjobA01l46K2KKmOA4t4S9MA]]></FromUserName> <CreateTime>1368615244</CreateTime> <MsgType><![CDATA[location]]></MsgType> <Location_X>31.216516</Location_X> <Location_Y>121.437729</Location_Y> <Scale>15</Scale> <Label><![CDATA[中国上海市长宁区镇宁路91号 邮政编码: 200050]]></Label> <MsgId>5878157713787061882</MsgId> </xml>";

		if(empty($postStr)){
			$error = isset($_GET['echostr']) ? $_GET['echostr'] : 'error';
			echo $error;exit();
			$this->setError($error);
			return false;
		}

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