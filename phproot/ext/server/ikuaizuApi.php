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
    
    function system_preload(){
        return $this->api('system/preload',array());
    }
	
	function system_validcode($mobile,$force=false){
		return $this->api('system/validcode',array('mobile'=>$mobile,'force' => $force));
	}
	
	function system_report($data){
		return $this->api('system/report',$data,'post');
	}

	function system_feedback($data){
		return $this->api('system/feedback',$data,'post');
	}
    
    function district_publish($data){
        return $this->api('district/publish',$data,'post');
    }
    
    function house_pubilsh($data){
        return $this->api('house/publish',$data,'post');
    }
    
    function photo_upload($uid,$pic,$position = 0,$description = ''){
		$data  = array(
			'uid' => $uid,
			'filename' => '@'.$pic,
			'position' => $position,
			'description' => $description
		);
        return $this->api('photo/upload',$data,'post',true);
    }

    function house_getList($data){
    	return $this->api('house/list',$data,'post',true);
    }

    function photo_getList($data){
    	return $this->api('photo/list',$data,'post',true);
    }
    function photo_getCount($data){
    	return $this->api('photo/count',$data,'post',true);
    }   
	function photo_upload_url($uid,$pic,$position = 0,$description = ''){
		$data  = array(
			'uid' => $uid,
			'url' => $pic,
			'position' => $position,
			'description' => $description
		);
		return $this->api('photo/upload', $data,'post');
	}
	function facePic_upload_url($uid,$pic,$position = 0,$description = ''){
		$data  = array(
			'openId' => $uid,
			'url' => $pic,
		);
		return $this->api('facePic/upload', $data,'post');
	}   
    function house_renthouse($data = array()){
        return $this->api('house/renthouse',$data,'get');
    }
 
    function house_publish($data = array()){
        return $this->api('house/publish',$data,'post');
    }
	
    function house_delete($house_guid){
        return $this->api('house/delete',array('house_guid'=>$house_guid),'post');
    }
    
    function house_info($data){
        return $this->api('house/infoTest',$data,'get');
    }
	
    function search_district($data = array(),$page =1,$pageSize = 20){
        $data = array_merge($data, array('page_no' => $page,'page_size'=>$pageSize));
        return $this->api('search/district',$data,'get');
    }
	
    function search_house($data = array(),$page =1,$pageSize = 20){
        $data = array_merge($data, array('page_no' => $page,'page_size'=>$pageSize));
        return $this->api('search/house',$data,'get');
    }
	
	function favorite_create($house_guid){
        $data = array('house_guid' => $house_guid);
        return $this->api('favorite/create',$data,'post');
	}
	
	function favorite_list($page=1,$pageSize=10){
        return $this->api('favorite/list',array('page_no' => $page,'page_size'=>$pageSize),'get');
	}
	
	function favorite_delete($house_guid){
        $data = array('house_guid' => $house_guid);
        return $this->api('favorite/delete',$data,'post');
	}
	
	function reserve_create($house_guid){
        $data = array('house_guid' => $house_guid);
        return $this->api('reserve/create',$data,'post');
	}

	function reserve_info($reserve_code){
        return $this->api('reserve/info',array('reserve_code' => $reserve_code),'get');
	}
	
	function reserve_list($data = array()){
        return $this->api('reserve/list',$data,'get');
	}
	
	function reserve_subscribe($house_guid){
        return $this->api('reserve/subscribe',array('house_guid' => $house_guid),'get');
	}
	
	function reserve_delete($reserve_code){
		return $this->api('reserve/delete',array('reserve_code' => $reserve_code),'post');
	}
	
	function my_rent(){
		return $this->api('my/rent',array(),'get');
	}
	
	function my_house($house_guid){
		return $this->api('my/house',array('house_guid'=>$house_guid),'get');
	}
	
	function user_info(){
        return $this->api('user/info',array(),'get');
	}
	
	function user_update($data){
        return $this->api('user/update',$data,'post');
	}
}