<?php
class reserveController extends AppController
{
    public function actionInfo()
    {
        $req = WinBase::app()->getRequest();
        $reserve_code = $req->getParam("reserve_code");
        
        $res = $this->api('reserve_info', $reserve_code );
        if(isset($res['error'])){
            $this->showMessage($res['msg']);
        }
		
		$res['report_agent'] = 0;
		foreach($res['reports'] as $report){
			if($report['report'] == 'agent'){
				$res['report_agent'] = 1;
			}
		}
		
        $this->setMeta('title','预约详情');
        $this->render("reserve_info", $res);
    }
	
	public function actionList(){
		
	}
	
	public function actionSubscribe(){
        $req = WinBase::app()->getRequest();
        $house_guid = $req->getParam('house_guid',0);
		
		$res = $this->api('reserve_subscribe',$house_guid);
        if(isset($res['error'])){
            $links[] = array(
                'title' => '返回上一页',
                'href' => 'javascript:history.go(-1)',
            );			
            $this->showMessage($res['msg'],1,$links);
        }
		
		$data['list'] = array();
		foreach($res['data'] as $v){
			$data['list'][] = $v;
		}

        $this->setMeta('title','房源预约');
        $this->render("reserve_subscribe",$data);
	}

    public function actionCreate()
    {   
        $req = WinBase::app()->getRequest();
        $house_guid = $req->getParam('house_guid',0);
        
		$user = $this->api('user_info');
        if(isset($user['error'])){
            $links[] = array(
                'title' => '返回上一页',
                'href' => 'javascript:history.go(-1)',
            );			
            $this->showMessage($user['msg'],1,$links);
        }

		if(!$user['verify']){
			$this->redirect("/user/setting?uuid=".$this->uuid."&referer=".urlencode('/house/info?uuid='.$this->uuid.'&house_guid='.$house_guid));
		}
		
        $house = $this->api('house_info', $house_guid );
        if(isset($house['error'])){
            $links[] = array(
                'title' => '返回上一页',
                'href' => 'javascript:history.go(-1)',
            );
            $this->showMessage($house['msg'],1,$links);
        }
		
        if($req->isPostRequest()){
			
			$res = $this->api('reserve_create', $house_guid );
			if(isset($res['error'])){
				$links[] = array(
					'title' => '返回上一页',
					'href' => 'javascript:history.go(-1)',
				);
				$this->showMessage($res['msg'],1,$links);
			}
			
			$reserve_code = $res['reserve_code'];
            $links[] = array(
                'title' => '去联系房东',
                'href' => Config::getConfig('system','host_url').'/reserve/info?uuid='.$this->uuid.'&reserve_code='.$reserve_code,
            );
			/*
            $links[] = array(
                'title' => '查看预约',
                'href' => Config::getConfig('system','host_url').'/reserve/info?uuid='.$this->uuid.'&reserve_code='.$res,
            );
			*/
            $this->showMessage('预约成功',0,$links);
        }

        $data = array(
			'house' => $house,
        );
        
        $this->setMeta('title','房源预约');
        $this->render("reserve_create",$data);
    }

	public function actionCancel(){
        $req = WinBase::app()->getRequest();
        $reserve_code = $req->getParam('reserve_code',0);

        $res = $this->api('reserve_delete', $reserve_code );
        if(isset($res['error'])){
            $links[] = array(
                'title' => '返回上一页',
                'href' => 'javascript:history.go(-1)',
            );			
            $this->showMessage($res['msg'],1,$links);
        }
		
		$links[] = array(
			'title' => '返回预约列表',
			'href' => Config::getConfig('system','host_url').'/my/reserve?uuid='.$this->uuid,
		);
		$this->showMessage('预约已取消',0,$links);
	}
}