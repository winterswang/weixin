<?php
class systemController extends AppController
{
    public function actionFeedback()
    {
        $req = WinBase::app()->getRequest();

        if($req->isPostRequest()){
            $email = $req->getParam('email','');
            $description = $req->getParam('description','');
      
            $this->api('system_feedback', array('email'=>$email,'content'=>$description) );
            
            $this->showMessage('您的意见已收集，我们会持续改善体验，请继续关注快租',0);
        }
        
        $data = array();
        $this->setMeta('title','建议反馈');
        $this->render("system_feedback", $data);
    }

    function actionHelp(){

        $req = WinBase::app()->getRequest();
        $type = $req->getParam("type");
        $system_setting = Config::getConfig('system');
        $helps_arr = array(
            'search' => array(
                'title' => '找房',
                'parts' =>  array(
                    array(
                        'title'=>'第一步：点击左下角键盘图标',
                        'pic_url'=>$system_setting['static_url'].'/img/search_step1.jpg'
                    ),
                    array(
                        'title'=>'第二步：输入你想找房的区域、路名、小区名等',
                        'pic_url'=>$system_setting['static_url'].'/img/search_step2.jpg'
                    ),
                    array(
                        'title'=>'第三步：点击“发送”',
                        'pic_url'=> ''
                    ),
                    array(
                        'title'=>'如果你想搜索“当前所在位置”的房源，可在第2步点击右下角的＋号',
                        'pic_url'=>$system_setting['static_url'].'/img/search_step5.jpg'
                    ),
                    array(
                        'title'=>'然后发送当前所在位置',
                        'pic_url'=>$system_setting['static_url'].'/img/search_step6.jpg'
                    ),
                )
            ),
            'publish' =>array(
                'title' => '发房',
                'parts' => array(
                    array(
                        'title'=>'第一步：上传房源照片，点击右下角的＋号',
                        'pic_url'=>$system_setting['static_url'].'/img/search_step5.jpg'
                    ),                    
                    array(
                        'title'=>'选择相册照片或拍摄照片，可以连续上传多张照片',
                        'pic_url'=>$system_setting['static_url'].'/img/publish_step1.jpg'
                    ),
                    array(
                        'title'=>'第二步：填写房源信息',
                        'content'=>'填写房源信息及房东个人联系方式之后,快租会对房源进行审核，审核通过后房源自动上架'
                    ),
                )
            ),
            'reserve' => array(
                'title' => '预约看房',
                'parts' => array(
                    array(
                        'content' => '找到了心仪的房源后，进入房源详情点击“立即预约”进行预约。快租简化了注册流程，只需在首次预约时填写姓名、性别、电话三项个人信息，之后的每次确认预约后，该信息方会公布给相应的房东，以便双方联系，其他任何时候不会公开用户信息。'  
                    )                   
                )
            ),
            'agent' => array(
                'title' => '快租是否收中介费 ?',
                'parts' => array(
                    array(
                        'content' => '快租作为向广大有租房需求的人们提供信息交流平台，不收任何费用。如在找房或招租过程中遇到中介，请点击“举报”反馈给我们。'  
                    )                   
                ) 
            ),
            'protect' => array(
                'title' => '隐私保护',
                'parts' => array(
                    array(
                        'content' => '快租不会向任何中介或第三方机构泄漏用户的联系方式，同时不断改进机制来避免中介行为和骚扰，为用户创造一个真实无中介的租房环境'  
                    )
                )
            ),
            'aboutus' =>array(
                'title' => '关于快组',
                'parts' => array(
                    array(
                        'content' => '快租追求高效、便捷的租房方式和生活理念，希望为有租房需求的房东房客打造一个的真实免费的租房交流平台。'  
                    ),
                    array(
                        'title' => '联系方式',
                        'content' => '如果您有好的意见或建议，欢迎与我们联系。<br />服务热线：400-889-7633<br />邮箱：support@ikuaizu.com'
                    )
                )
                
            )
        );
        

        $data = array(
            'helpcontent' => isset($helps_arr[$type]) ? array($type => $helps_arr[$type]) : $helps_arr
        );

        $this->setMeta('title','帮助中心');
        $this->render("system_help", $data);
    }
    
    function actionProtocol(){
        $this->setMeta('title','用户使用协议');
        $this->render("system_protocol", array());
    }
    
    function actionValidcode(){
        $req = WinBase::app()->getRequest();
        $mobile = $req->getParam("mobile",0);
        
        $data = array('error' => 0,'msg' => '');
        $res = $this->api('system_validcode',$mobile,'true');
        if(isset($res['error'])){
            $data = $res;
        }
        
        echo json_encode($data);
        exit();        
    }

    public function actionReport(){
		$req = WinBase::app()->getRequest();
		$house_guid = $req->getParam('house_guid',0);

        $report_arr = array(
            'type' => 'house',
			'target' => $house_guid,
            'report' => 'agent'
        );
        
        $this->api('system_report',$report_arr);
        
        echo json_encode(array('error' => 0,'msg' => ''));
        exit();
    }

}
?>