<?php
class favoriteController extends AppController
{

    public function actionCreate()
    {   
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

	public function actionRemove(){
        $req = WinBase::app()->getRequest();
        $house_guid = $req->getParam('house_guid',0);
		
		$data = array('error' => 0,'msg' => '');
		
        $res = $this->api('favorite_delete', $house_guid );
        if(isset($res['error'])){
            $data = $res;
        }
        
        echo json_encode($data);
        exit();
	}
}