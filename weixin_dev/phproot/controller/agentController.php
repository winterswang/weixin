<?php
class agentController extends AppController
{
	public function actionMyagent(){

		if(isset($_COOKIE["openId"]) && $_COOKIE["openId"] !=''){
			$this->openId = $_COOKIE["openId"];
		}

		if(empty($this->openId)){
			$this->getOAuth();
		}
		else
		{
			$res = $this->api->get_user_vsfwx(array('openId'=>$this->openId));
			if($res['result'] != 'ok'){
				print_r($res['result']);
			}	
		}

	}
	public function actionGetCode(){
		$req = WinBase::app()->getRequest();
		$code = $req->getParam('code','');

		$res = $this->api->add_user_vsfwx(array('code'=>$code));

		if($res['result'] != 'ok'){
			print_r($res['result']);
		}else{
			$this->openId = $res['data']['open_id'];
			setcookie('openId',$this->openId);
			////转向真正要访问的网页
			print_r($res['data']);				
		}
	}
	private function getOAuth()
	{
		$appid = 'wx5f0a6ad584a0bad8';//微搜房
		$redirect_uri = urlencode("http://wxtest.ikuaizu.com/agent/getCode");
		$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";
		echo "<script>window.location ='".$url."';</script>";		
	}
 
}