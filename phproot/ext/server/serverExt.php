<?php

include(dirname(__FILE__).DIRECTORY_SEPARATOR.'ikuaizuApi.php');

define( "IKUAIZU_AKEY" , '1002' );
define( "IKUAIZU_SKEY" , 'f9436a7ffec39ddd32f85fcf177274a9' );

class serverExt
{
    private $_api;
    
    public $version = '1.0';

    function __construct($uuid){
        
        $header = array(
			'osVersion' => $this->version,
			'uuid' => $uuid
		);
        
		$this->_api = new ikuaizuApi(IKUAIZU_AKEY,IKUAIZU_SKEY,$header);
    }
    
    public function api(){
        return $this->_api;
    }
}