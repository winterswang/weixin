<?php
class authController extends AppController
{

	public function actionGetCode(){
		
		$req = WinBase::app()->getRequest();
		$redirect = $req->getParam('redirect','');
		$code = $req->getParam('code','');

		$conf = Config::getConfig('system');
		$appid = $conf['test']['appid'];
		$appsecret = $conf['test']['secret'];

		$res = WxApiTools::model()->getOAuthUserInfo($appid, $appsecret, $code);
		if (isset($res->errcode)) {
			var_dump($res);
			die;
		}
		$data = (array)$res;
		$data['open_id'] = $data['openid'];

        if(!userFaceWx::model()->isExist($obj->FromUserName)){
            userFaceWx::model()->addUser($data);            
        }

		$this->openId = $data['openid'];
		setcookie('openId', $this->openId, time() + 864000, '/');
		echo "<script>window.location ='".$redirect."';</script>";
	}

	public function actionOAuth(){
		$conf = Config::getConfig('system');
		$appid = $conf['test']['appid'];
		$host = $conf['host_url'];
		$req = WinBase::app()->getRequest();
		$redirect = $req->getParam('redirect','');

		$redirect_uri = $host."/auth/getCode?redirect=".urlencode($redirect);		
		$redirect_uri = urlencode($redirect_uri);
		$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";
		echo "<script>window.location ='".$url."';</script>";
		die;
	}
 
}