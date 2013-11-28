<?php
class WeixinController extends BaseController{
	
	private $_wx = null;

	public function init(){

		if(!$this->checkSignature()){
			//die("Invalid signature");
		}

		if(!$this->wxRep()->listening()){
			throw new Exception($this->wxRep()->error());
		}
		
		$type = $this->wxRep()->MsgType;
		if(!$type){
			throw new Exception($this->wxRep()->error());
		}

		$this->routing($type);
	}
	
	public function wxRep(){
		if(!$this->_wx){
			$this->_wx = new weixinResponse();
		}
		
		return $this->_wx;
	}
	
    private function checkSignature()
    {
		
        $req = WinBase::app()->getRequest();
        $signature = $req->getParam("signature");
        $timestamp = $req->getParam("timestamp");
        $nonce = $req->getParam("nonce");    
        
        $token = WinBase::app()->getSetting('weixin.token');
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
	
	function routing($msgtype){

		$action = '';
		if($msgtype == 'event'){
			$event = $this->wxRep()->Event;
			if($event == "CLICK"){
				$action = 'navigation';
			}else{
				if($event == "LOCATION")
				{
  					$action = 'event';
				}else{
					$action = $event;
				}				
			}
		}else{
			$action = $msgtype;
		}
		
		$classname = 'action'.ucfirst($action);
		if(!method_exists($this,$classname)){
			die('no method found');
		}

		$obj = $this->wxRep();
		$this->$classname($obj);
	}
	
	public function getHelp(){
		return Config::getConfig('weixin','help');
	}	
	public function getWelcome(){
		return Config::getConfig('weixin','welcome');
	}
	public function respond_text($content,$to = '',$FuncFlag = 0){
	
		$data = array(
			'ToUserName' => '<![CDATA['.$this->wxRep()->FromUserName.']]>',
			'FromUserName' => '<![CDATA['.$this->wxRep()->ToUserName.']]>',
			'CreateTime' => TIMESTAMP,
			'MsgType' => '<![CDATA[text]]>',
			'Content' => '<![CDATA['.$content.']]>',
			'FuncFlag' => $FuncFlag
		);

		$this->_output($data);
	}
	
	public function respond_news($news=array(),$FuncFlag = 0){
		
		$articles = array();
		
		foreach($news as $v){
			$item = array();
			$item['Title'] = '<![CDATA['.$v['title'].']]>';
			$item['Description'] = isset($v['description']) ? '<![CDATA['.$v['description'].']]>' : '<![CDATA[]]>';
			$item['PicUrl'] = isset($v['picurl']) ? '<![CDATA['.$v['picurl'].']]>' : '<![CDATA[]]>';
			$item['Url'] = isset($v['url']) ? '<![CDATA['.$v['url'].']]>' : '<![CDATA[]]>';
			$articles[] = array('item' => $item);
		}
		
		$data = array(
			'ToUserName' => '<![CDATA['.$this->wxRep()->FromUserName.']]>',
			'FromUserName' => '<![CDATA['.$this->wxRep()->ToUserName.']]>',
			'CreateTime' => TIMESTAMP,
			'MsgType' => '<![CDATA[news]]>',
			'ArticleCount' => count($articles), 
			'Articles' => $articles,
			'FuncFlag' => $FuncFlag
		);

		$this->_output($data);
	}
	
	private function _output($data){
		ob_start();
		ob_implicit_flush(false);
		$xml = XmlParse::Array2XML(array('xml'=>$data));
		ob_get_clean();
		
		echo $xml;
		file_put_contents("/data/wwwlogs/wx.log", $xml."\n", FILE_APPEND);
		exit();		
	}
	
	function api($api){ 
		$args = array_slice(func_get_args(), 1);
		
		$uuid = $this->wxRep()->FromUserName;
        $server = new serverExt( $uuid );
        return call_user_func_array(array($server->api(),$api), $args);
	}
}
