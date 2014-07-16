<?php
class uploadController extends AppController {
    public function actionImage() {
        $req = WinBase::app()->getRequest();
        $openId = $req -> getParam("openId", "");
        if(!empty($openId)){
           setcookie('openId',$openId);
        }
        $this->setMeta('title','上传图片');
        $this->render("upload_image");
    }

    public function actionSavePic(){

        // foreach ($_FILES["upfile"]["error"] as $key => $error) {
        //     if ($error == UPLOAD_ERR_OK) {
        //         $name = $_FILES["upfile"]["name"][$key];
        //         move_uploaded_file( $_FILES["upfile"]["tmp_name"][$key], "tmp/" . $_FILES['upfile']['name'][$key]);
        //     }
        // }
    }

    public function actionUploadPic(){
        $this->setMeta('title','上传照片');
        $this->render("house_publish");
    }
    
    public function actionTest(){
        $req = WinBase::app()->getRequest();
        $share =  $req -> getParam("share", "");
        if(!empty($share))
            file_put_contents('/tmp/test.txt', $share);
        else{
            file_put_contents('/tmp/test.txt', 'failed');
        }       
    }
}
?>
