<?php
class userController extends AppController
{
    public function actionSetting()
    {
        $req = WinBase::app()->getRequest();
		$referer = $req->getParam('referer','');
		
        $res = $this->api('user_info');
        if(isset($res['error'])){
            $this->showMessage($res['msg']);
        }
		
		$user = array(
			'username' => isset($res['userName']) ? $res['userName']: '',
			'gender' => isset($res['gender']) ? $res['gender']: 1,
			'mobile' => isset($res['mobile']) && $res['mobile']  ? $res['mobile']: ''
		);		
		
		if($req->isPostRequest()){
			$username = $req->getParam("username");
			$gender = $req->getParam("gender");
			$mobile = $req->getParam("mobile");
			$validcode = $req->getParam('validcode',0);
			
			if(!$username){
				$links[] = array(
					'title' => '返回上一页',
					'href' => 'javascript:history.go(-1)',
				);
				$this->showMessage('姓名不能为空',0,$links);
			}
			
			if(!$mobile){
				$links[] = array(
					'title' => '返回上一页',
					'href' => 'javascript:history.go(-1)',
				);
				$this->showMessage('手机号不能为空',0,$links);
			}
			
			if(!$validcode){
				$links[] = array(
					'title' => '返回上一页',
					'href' => 'javascript:history.go(-1)',
				);
				$this->showMessage('请输入验证码',0,$links);
			}
			
			$user = array(
				'user_name' => $username,
				'gender' => $gender,
				'mobile' => $mobile,
				'validcode' => $validcode
			);
			
			$res = $this->api('user_update',$user);
			if(isset($res['error'])){
				$links[] = array(
					'title' => '返回上一页',
					'href' => 'javascript:history.go(-1)',
				);
				$this->showMessage($res['msg'],0,$links);
			}
			
			if($referer){
				$this->redirect($referer);
			}
			
		}
		
		$data = array(
			'referer' => $this->getReferer(),
			'user' => $user
		);
		
        $this->setMeta('title','设置个人信息');
        $this->render("user_setting", $data);
    }
}
?>