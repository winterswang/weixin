<?php
class AppController extends BaseController{

	public $uuid;
	public $meta = array('title' => '');
	
	public function init(){
		$req = WinBase::app()->getRequest();
		$uuid = $req->getParam("uuid",'');
		if(!$uuid){
			die('Invalid Visit');
		}
		
		$this->uuid = $uuid;
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