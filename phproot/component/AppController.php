<?php
class AppController extends BaseController{

	public $uuid;
	public $is_imparted = false;
	public $openId = '';
	public $meta = array('title' => '');
	
	public function init(){
		// $this->openId = 'oMJ6NjnnUSjsLBOJDIbzgV1rnrgk';
	}
	public function beforeAction($action) {
		if ($this->getId() == 'auth'){
			return true;
		}
		if(isset($_COOKIE["openId"]) && $_COOKIE["openId"] !=''){
			$this->openId = $_COOKIE["openId"];
			return true;
		}
		// is empty and is not imparted 
		if(empty($this->openId)){
			$conf = Config::getConfig('system');
			$url = $conf['host_url'].'/auth/oAuth?redirect='.$this->getReferer();
			$this->redirect($url);
		}
	}	
	public function redirect($url){
		header('Location: '.$url);
		exit();
	}
		
    function getReferer($referer = '')
    {

        if (empty($referer)) {
            $referer = WinBase::app()->getRequest()->getParam('referer');
            $referer = !empty($referer) ? $referer : WinBase::app()->getUri()->getUri();
		}

        $referer = htmlspecialchars($referer);
        $referer = str_replace('&amp;', '&', $referer);
        $reurl = parse_url($referer);

        if (!isset($reurl['host'])) {
            $referer = '/'.ltrim($referer, '/');
        }
        return strip_tags($referer);
    }	

	function api($api){ 
		$args = array_slice(func_get_args(), 1);
		
        $server = new serverExt( $this->uuid );
        return call_user_func_array(array($server->api(),$api), $args);
	}
	
	public function setMeta($key,$value){
		$this->meta[$key]=$value;
	}
	
    public function showMessage($message, $msg_type = 0, $links = array())
    {
		$this->render('/common/message', array(
			'message'       => $message,
			'links'         => $links,
			'msg_type'      => $msg_type
		));
		exit();
    }	
}