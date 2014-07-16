<?php
class houseController extends AppController
{
    public function actionInfo()
    {
        $req = WinBase::app()->getRequest();
        $house_guid = $req->getParam("house_guid");
        
        $res = $this->api('house_info', $house_guid );
        if(isset($res['error'])){
            $this->showMessage($res['msg']);
        }
        
        $this->setMeta('title','房源详情');
        $this->render("house_info", $res);
    }
    public function actionHelp(){
        $error = "this is a test";
        $this->render("help",array('error'=>$error));
    }
    public function actionPublish()
    { 
        $req = WinBase::app()->getRequest();
        $uid = $req->getParam('uuid','');
        if(empty($uid)){
            $error = "uid is empty";
            $this->render("help",array('error'=>$error));
            exit();
        }
        $res = $this->api('photo_getList',array('uid'=>$uid,'house_guid'=>10000));
        //print_r($res);exit();
        if(empty($res['data'])){
            $error = "照片已经发布到之前的房源中\r\n请重新上传房源照片";
            $this->render("help",array('error'=>$error));
            exit();
        }
        $this->setMeta('title','发布房源');
        $this->render("upload_test",$res);
    }
    public function actionSaveHouse()
    {
        $req = WinBase::app()->getRequest();
         $uid = $req->getParam('uuid','');
         $content = $req->getParam('content','');
         if(empty($uid) || empty($content)){
            $error = "uid or content is empty";
            $this->render("help",array('error'=>$error));
            exit();
         }
         $res = $this->api('photo_getList',array('uid'=>$uid));
         if(count($res['data'])){
              $res = $this->api('house_publish',$data=array('uid'=>$uid,'content'=>$content));
             // $this->setMeta('title','房源信息');
             // $this->render("tpl",$res);


             $data = array('error' => 0,'msg' =>$res);
             echo json_encode($data);
             exit();
         }else{
             $this->setMeta('title','房源信息');
             $error = "photo is empty";
             $this->render("help",array('error'=>$error));            
         }         

    }
    public function actionHouseInfo()
    {
        $req = WinBase::app()->getRequest();
        $house_guid = $req->getParam('house_guid',0);
        if(empty($house_guid)){
            $error = "house_guid is empty";
            $this->render("help",array('error'=>$error));
        }
        $res = $this->api('house_info',$data=array('house_guid'=>$house_guid)); 
        //print_r($res);exit();
        $this->setMeta('title','房源信息');
        $this->render("tpl",$res);
    }

    public function actionPic() {
        $req = WinBase::app()->getRequest();
        $uid = $req->getParam('uuid','');
        $house_guid = $req->getParam('house_guid',10000);
        $start_index = $req->getParam('start_index', 0);
        if(empty($uid)){
            $error = "uid is empty";
            $this->render("help",array('error'=>$error));           
        }
        $res = $this->api('photo_getList',array('uid'=>$uid,'house_guid'=>$house_guid));
        //print_r($res);exit();
        if(empty($res['data'])){
            $error = "photo is empty";
            $this->render("help",array('error'=>$error));              
        }
        $res['start_index'] = $start_index;
        $this->setMeta('title','图片查看');
        $this->render("pic_show",$res);
    } 

    public function actionCollect(){
        $req = WinBase::app()->getRequest();
        $house_guid = $req->getParam('house_guid',0);
        
        $data = array('error' => 0,'msg' => '');

        $res = $this->api('favorite_create', $house_guid );
        if(isset($res['error'])){
            $data = $res;
        }
        
        echo json_encode($data);
        exit();
    }
    
    public function actionReserve(){
        $req = WinBase::app()->getRequest();
        $house_guid = $this->getParam('house_guid',0);
        
        $data = array('error' => 0,'msg' => '');
        
        $res = $this->api('reserve_create', $house_guid );
        if(isset($res['error'])){
            $data = $res;
        }
        
        echo json_encode($data);
        exit();
    }
    
    
    public function actionRemove(){
        $req = WinBase::app()->getRequest();
        $house_guid = $req->getParam('house_guid',0);
		
		$data = array('error' => 0,'msg' => '');
		
        $res = $this->api('house_delete', $house_guid );
        if(isset($res['error'])){
            $data = $res;
        }
        
        echo json_encode($data);
        exit();
    }
}
?>