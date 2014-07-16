<?php
class WxApiTools {
	private static $_models = array();
	public static function model($className=__CLASS__)
	{
		if(isset(self::$_models[$className]))
			return self::$_models[$className];
		else
		{
			$model=self::$_models[$className]=new $className();
			return $model;
		}
	}
	function getAccessToken($appid = 'wx5f0a6ad584a0bad8',$secret='b42615e53bcb257dec47f8b49bac24d6') {
		$rss_content = '';//清空变量
		$rss_url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
		$result  = json_decode($this->get($rss_url));
		if(empty($result->access_token)){
			return null;
		}
		return  $result->access_token;
	}

	function postMsg($token,$to, $content){
		$rss_content = '';//清空变量
		$url='https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$token;
		if ($token == '') {
			return false;
		}
		$msg = array();
		$msg['touser'] = $to;
		$msg['msgtype'] = 'text';
		$msg['text'] = array('content'=>$content);
		$json = $this->post($url,json_encode($msg));
		return json_decode($json);	
	}
	function getMedia($token,$mediaId,$thumbMediaId){
		if(empty($mediaId) || empty($thumbMediaId) || empty($access_token)){
			return false;
		}
		$url= "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='".$token."'&media_id='".$mediaId."'";
		$res = $this->get($url);
		return $res;
	}

	function getTicket($token,$num){
		$post_data = array(
		    'action_name' => 'QR_LIMIT_SCENE',
		    'action_info' => array(
		    			'scene' =>array('scene_id'=>$num)
		    	),
		);
		$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$token;
		$result = json_decode($this->post($url,$post_data));
		return $result->ticket;	
	}

	function getQRImage($ticket,$fileName){
		$url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($ticket);

		$image = $this->get($url);
		$setting = WinBase::app()->getSetting('setting');		
		$image_url = $setting['attach_path'].'/test/201311/11/'.$fileName.'.jpg';		
		file_put_contents($image_url, $image);
		return $image_url;
	}
	function addMenuButton($data = array(),$token){
		$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$token;
		$res = json_decode($this->post($url,$data));
		if($res->errmsg == 'ok'){
			echo "add menuButton successful\r\n";
			return true;
		}
		else{
			echo $res->errmsg."\r\n";
			return false;
		}
	}
	function upLoadImage($data = array(),$token){
		$url = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=".$token."&type=image";
		$res = json_decode($this->post($url,$data,'raw'));
		return $res;
	}
	function getUserInfo($openId,$token){
		if(empty($openId) || empty($token)){
			return false;
		}
		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$token."&openid=".$openId;
		$res = $this->get($url);
		return json_decode($res);
	}
	function getOAuthUserInfo($openId,$token){
		if(empty($openId) || empty($token)){
			return false;
		}
		$url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$token."&openid=".$openId;
		$res = json_decode($this->get($url));
		return  $res;
	}
	function getOAuthAccessToken($appid,$secret,$code){
		$rss_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
		$result  = json_decode($this->get($rss_url));
		return  $result;		
	}
	private function post($url,$body,$type = 'json'){
		if($type == 'raw'){			
		}
		if($type == 'array'){
			$body = http_build_query($body);
		}
		if($type == 'json')
		{
			$body = json_encode($body,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:23.0) Gecko/20100101 Firefox/23.0');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		curl_setopt($ch, CURLOPT_POST, 1);		
		curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		$result = curl_exec($ch);//赋值内容
		if(curl_errno($ch)){ 
		  echo 'Curl error: ' . curl_error($ch)."curl error num".curl_errno($ch)."\r\n";return null; 
		}
		curl_close($ch);//关闭资源
		return $result;	
	}
	private function get($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt ($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:23.0) Gecko/20100101 Firefox/23.0');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		$result = curl_exec($ch);//赋值内容	
		if(curl_errno($ch)){ 
		  echo 'Curl error: ' . curl_error($ch)."curl error num".curl_errno($ch)."\r\n";return null; 
		}
		curl_close($ch);//关闭资源
		return $result;		
	}	
}

