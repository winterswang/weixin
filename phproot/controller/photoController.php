<?php
class photoController extends ApiController
{
	
	public function validate(){
		return array(
			'post' => array('publish'),
			//'auth' => array('publish'),
			'publish' => array()
		);
	}
	
	//上传房源图片
	public function actionUpload(){
		$req = WinBase::app()->getRequest();
		$house_guid = (int)$req->getParam('house_guid',0);
		$position = (int)$req->getParam('position',0);
		$description = $req->getParam('description','');
		$url = $req->getParam('url','filename');
		$uid = $req->getParam('uid','');
		$setting = WinBase::app()->getSetting('setting');
		$fileUpload = new fileUpload($setting['attach_path']);
		
		$isurl = $url != 'filename' ? true : false;
		if(!$fileUpload->init($url,$isurl)){
			$this->showError($fileUpload->getErrorCode(),$fileUpload->getErrorMsg());
		}

        if (!$fileUpload->saveFile('test')) {
            $this->showError($fileUpload->getErrorCode(),$fileUpload->getErrorMsg());
        }
		
		$image = new imageExt();
		
		$photoArr = array(
			'house_guid' => $house_guid,
			'position' => $position,
			'description' => $description,
			'attachment' => $fileUpload->attach['attachment'],
			'status' => 0,
			'is_delete' => 0,
			'uid' => $uid,
			'dataline' => TIMESTAMP
		);
		$arr = pathinfo($photoArr['attachment']);
		$new_file = $arr['dirname'].'/'.$arr['filename'].'_small.'.$arr['extension'];
		commonTools::model()->imageCut($photoArr['attachment'],$new_file,60,60);
		file_put_contents('/data/wwwlogs/imageCut.log', $new_file);	

		if(!($pid = housePhotoOld::model()->addPhoto($photoArr))){
			$this->showError('9999','SQL ERROR');
		}

		$this->response(array('pid' => $pid,'url'=> urlAssign::getUrl($photoArr['attachment'])));
	}
	
	public function actionOrder(){
		$req = WinBase::app()->getRequest();
		$photos = $req->getParam('photos','');
		$house_guid = $req->getParam('house_guid',0);

		$photolist = housePhotoOld::model()->getAll(array('house_guid'=>$house_guid));
		if(empty($photolist)){
			$this->showError('9016','No Photo Found');
		}		
		
		$update_photos = json_decode($photos,true);
		if(json_last_error() != JSON_ERROR_NONE){
			$this->showError('9016','photos json vaild');
		}

		$old_photos = $new_photos = array();
		foreach($photolist as $photo){
			$old_photos[] = $photo['pid'];
		}
		
		foreach($update_photos as $photo){
			$new_photos[] = $photo['pid'];
		}
	
		$intersect = $uploadArr = $removeArr = array();
		$intersect = array_intersect($old_photos, $new_photos);
		$removeArr = array_diff($old_photos, $intersect);
		
		if (!empty($removeArr)) {
			foreach($removeArr as $pid){
				housePhoto::model()->updatePhoto(array('is_delete' => 1),array('pid'=>$pid));
			}
		}

		foreach ($update_photos as $data) {
			$set = array();
			if(isset($data['postion'])){
				$set['postion'] = $data['postion'];
			}
			if(isset($data['desc'])){
				$set['description'] = $data['desc'];
			}
			if(isset($data['index'])){
				$set['sort_order'] = $data['index'];
			}
			
			if(!empty($set)){
				housePhoto::model()->updatePhoto($set, array('pid' => $data['pid']));
			}
		}
		
		$this->response();
	}
	
	public function actionDelete(){
		$req = WinBase::app()->getRequest();
		$pid = (int)$req->getParam('pid',0);
		
		$res = housePhoto::model()->getInfoByPid($pid);
		if(empty($res)){
			$this->showError('9016','No Photo Found');	
		}
		
		if(!housePhoto::model()->updatePhoto(array('is_delete'=>1) ,array('pid'=>$pid))){
			$this->showError('9999','SQL ERROR');	
		}
		
		$this->response();
	}
	
	public function actionlist(){
		$req = WinBase::app()->getRequest();
		$uid = $req->getParam('position','');
		$page_no = $req->getParam('page_no',1);
		$page_size = $req->getParam('page_size',3);		
	
		$data = array(
			'length' => 0,
			'data' => array()
		);	
		
		$count = housePhotoOld::model()->getCount(array('uid'=>$uid));
		if(!$count){
			$this->response($data);
		}
		
		$photo_list = array();
		$photoList = housePhotoOld::model()->getList(array('uid'=>$uid),$page_no = 1, $page_size = 3);
		foreach($photoList as $k=>$photo){
			$attach = array();
			$attach['pid'] = $photo['pid'];
			$attach['uid'] = $photo['uid'];
			$attach['position'] = $photo['position'];
			$attach['house_guid'] = $photo['house_guid'];
			$attach['description'] = $photo['description'];
			$attach['url'] = urlAssign::getUrl($photo['attachment']);
			$photo_list[] = $attach;
		}
		
		$data = array(
			'length' => $count,
			'data' => $photo_list
		);
		$this->response($data);
	}
	
}
?>