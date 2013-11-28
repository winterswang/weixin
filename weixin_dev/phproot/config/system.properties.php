<?php
return array(
    'host_url' => 'http://wxtest.ikuaizu.com',
    'attach_url' => 'data/attachment',
    'static_url' => 'http://wxtest.ikuaizu.com',
    'default_photo' => 'http://wxtest.ikuaizu.com/data/images/default.jpg',
    'push_server' => array(
        'push_house_num' => 3, 
        
    ),
    'test' =>array(
    'appid' =>'wx5f0a6ad584a0bad8',
    'secret' =>'b42615e53bcb257dec47f8b49bac24d6',
    'menuButton' =>array(
        'button'=>array(
            0=>array(
                'type' =>"view",
                'name' =>"我的信息",
                'url'  =>'http://wxtest.ikuaizu.com/agent/myagent',
                ),
            1=>array(
                'type' =>'click',
                'name' =>"我的名片",
                'key'  =>'MYCARD',
                ),
            ),      
        ),
    )
);