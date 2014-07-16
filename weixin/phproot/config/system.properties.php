<?php
return array(
    'host_url' => 'http://wxtest.ikuaizu.com',
    'attach_url' => 'data/attachment',
    'static_url' => 'http://wxtest.ikuaizu.com',
    'local_attach_path' =>'/home/stephen/vsfoufang/kz_www/apps/weixin_dev/wwwroot/data/attachment',
    'default_photo' => 'http://wxtest.ikuaizu.com/data/images/default.jpg',

    'test' =>array(
        'appid' =>'wx5f0a6ad584a0bad8',
        'secret' =>'b42615e53bcb257dec47f8b49bac24d6',
        'menuButton' =>array(
            'button'=>array(
                // 0=>array(
                //     'type' =>"view",
                //     'name' =>"我的照片",
                //     'url'  =>'http://wxtest.ikuaizu.com/upload/image',
                //     ),
                0=>array(
                    'type' =>"view",
                    'name' =>"我的照片",
                    'url'  =>'http://wxtest.ikuaizu.com/upload/uploadPic',
                    ),                
                1=>array(
                    'type' =>'click',
                    'name' =>"我的信息",
                    'key'  =>'MYCARD',
                    ),
                2=>array(
                    'type' =>'view',
                    'name' =>"TEST",
                    'url'  =>'http://wxtest.ikuaizu.com/agent/myagent',
                    ),
                ),      
            ),
    ),
);