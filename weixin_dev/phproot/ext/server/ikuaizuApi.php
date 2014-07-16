<?php

include(dirname(__FILE__).DIRECTORY_SEPARATOR.'httpClient.php');

class ikuaizuApi
{
    private $_http;
    
    public $version = '1.0';
    
    public $format = 'json';

    function __construct($client_key,$client_secret,$header = array()){
        
        
        $_header = array();
        $_header[] = 'version: '.$this->version;
        $_header[] = 'clientId: '.$client_key;
        $_header[] = 'timeStamp: '.TIMESTAMP;
        $_header[] = 'platform: '. (isset($header['platform']) ? $header['platform'] : 'weixin');
        $_header[] = 'model: '. (isset($header['model']) ? $header['model'] : 'xxx');
        $_header[] = 'osVersion: '. (isset($header['osVersion']) ? $header['osVersion'] : '1.0');
        $_header[] = 'uuid: '. (isset($header['uuid']) ? $header['uuid'] : '');
        $_header[] = 'latlng: 0,0';

        $this->_http = new httpClient($client_key,$client_secret,$_header);   
    }
    
    function api($script,$data=array(),$mothed = 'get',$multi = false){
		$response = $this->_http->$mothed($script,$data,$multi);
		//file_put_contents("/data/wwwlogs/wx.log", $response."\n", FILE_APPEND);
        if ($this->format === 'json') {
			$res = json_decode($response, true);
			if(json_last_error() != JSON_ERROR_NONE) {
				
				return array('error' => 9999,'msg'=>'server error');
			}
		}

		if(!isset($res['status']) || $res['status'] != '0000'){
			return array('error' => $res['status'],'msg'=>$res['info']);
		}
		
		return $res['data'];
    }	
    
    function index(){
        return $this->api('',array());
    }
    
	function facePic_upload_url($uid,$pic,$position = 0,$description = ''){
		$data  = array(
			'openId' => $uid,
			'url' => $pic,
		);
		return $this->api('facePic/upload', $data,'post');
	}
	function face_save_user($data = array()){
		return $this->api('faceUser/saveUser', $data,'post');
	}   

}