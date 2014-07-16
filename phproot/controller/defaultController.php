<?php
class defaultController extends WeixinController
{
    public $group = 'wgc_group'; 

    public function actionIndex($obj){}  
    
    // public function actionImage($obj)
    // {
    //     $system_setting = Config::getConfig('system');
    //     //////保存的face照片
    //     $pic_url = $system_setting['host_url'].'/'.$system_setting['attach_url'].'/'.$this->savePic($obj->PicUrl);

    //     $result = faceTools::model()->recognition_identify($pic_url,'wgc_group');
    //     $is_identified = 0;
    //     $confidence = 0;
    //     $person_name = '';

    //     if (empty($result->face)){
    //        $this->respond_text("您的头像不是真人头像，无法建立头像信息");
    //     }
    //     if (count($result->face) > 1){
    //          $this->respond_text("\r\n 您的头像照片带有多个人物头像，无法建立头像信息");
    //     }
           
    //     $confidence =$result->face[0]->candidate[0]->confidence;
    //     $person_name  =$result->face[0]->candidate[0]->person_name;
    //     $is_identified = 1; 
                        
    //     if(round($confidence) >0)
    //     {
    //         $description = "";
    //         /////之前的人物头像
    //         $info =  userFaceWx::model()->getInfo(array('open_id' =>$person_name));
    //         $head_url = $system_setting['host_url'].'/'.$system_setting['attach_url'].'/'.$info['headimgurl'];

    //         $data = array(
    //             'user_open_id' =>$obj->FromUserName,
    //             'pic_url' =>$pic_url,
    //             'confidence' => $confidence,
    //             'person_name'  => $person_name,
    //             'is_identified' =>$is_identified,
    //             'createtime' =>time(),
    //             );
    //         ////相似度过低，图片地址计入缓存，再确认是此人以后，进行后续操作，进行图片与人物的绑定，然后进行人物图片的训练
    //         if(round($confidence) <50)
    //         {
    //             $description = "相似度只有".$confidence."，感觉不是此人哦，认为是回复Y，不是回复N";
    //             $cache = new CacheFile('pic');
    //             $cache->write($obj->FromUserName,$pic_url,'pic_');                
    //             $data['is_identified'] = 0;               
    //         }else{
                
    //         }

    //         $news[] =  array(
    //             'title' => "相似度：$confidence",
    //             'picurl'=> $head_url,
    //             'url'   => $head_url,
    //             'description' =>$description,
    //         );
    //         userPic::model()->addUserPic($data);
                
    //         $this->respond_news($news);                          
    //     }else{
    //         $this->respond_text('没有找到相似度人呢');
    //     }
    // }
    private function killPeopleGame($arr){
        //分成两部分，第一部分是游戏代号是否正确
        //第二部分，确认游戏玩家人数    
        //根据人数，正确查找出对应的人物数量和角色分配
        if($arr[0] != 'sryx'){
            return false;
        }
        if($arr[1] <7){
            return "人数太少";  
        }
        $f = fopen("../../wwwroot/data/files/sryx_roles.txt");
        while(!feof($f) && $arr[1]--){
            $line = fgets($f);
            if($arr[1]<=6){
                return $line;
            }
        }
        return false;                    
    }   
    public function actionText($obj){

        $keyword = strtolower($obj->Content);

        if($keyword == 'h' || $keyword == 'help')
        {
            $this->respond_text($this->getWelcome());
        }

        $arr = explode('/', $keyword);

        $res = 'welcome';
        if($arrs[0] == 'sryx'){
            $res = $res + " 进入杀人游戏";
            $res = $this->killPeopleGame($arr);
        }
        $this->respond_text($res);



        // $system_setting = Config::getConfig('system');
        // $cache = new CacheFile('pic');

        // switch ($keyword) {
        //     case 'y':

        //         $pic_url = $cache->get($obj->FromUserName,'pic_');

        //         $info = userPic::model()->getInfo(array('pic_url'=>$pic_url,'is_identified' =>0));
        //         if (empty($info)) 
        //         {
        //             $this->respond_text('something is wrong can not find the userPic by pic_url');
        //         }
        //         /////确认了之前的验证，是之前找到的那个人 ,先进行face分析，再添加到person中，再进行一次训练

        //         $result = faceTools::model()->face_detect($pic_url);

        //         faceTools::model()->person_add_face($result->face[0]->face_id, $info['user_open_id']);

        //         faceTools::model()->train_identify('wgc_group'); 

        //         if($this->addFace($result,$info['user_open_id'],$pic_url))
        //         {
        //             userPic::model()->updateUserPic(array('is_identified'=>1),array('pic_url'=>$pic_url));   
        //         }     

        //         $news[] =  array(
        //             'title' => "",
        //             'picurl'=> $pic_url,
        //             'url'   => $pic_url,
        //             'description' =>'已顺利将此头像添加到到目标用户上',
        //         );

        //         $cache->clean();
        //         $this->respond_news($news);                    
        //         break;
        //     case 'n':
        //         $pic_url = $cache->get($obj->FromUserName,'pic_');

        //         $this->respond_text('是否打算创建新的人物信息');
        //         break;            
        //     default:
        //         break;
        // }
        // $this->respond_text($obj->Content);
    }

    // public function actionLink($obj){}
    
    // public function actionLocation($obj){
 
    //     $arrParams = array(
    //         'searchby' => 'xy',
    //         'lat' => (float)$obj->Location_X,
    //         'lng' => (float)$obj->Location_Y,
    //         'radius' => 1000
    //     );
    // }
    // public function actionNavigation($obj){

    //     $eventKey = $obj->EventKey;        
    //     $system_setting = Config::getConfig('system');
    //     $navShow = array();
    //     switch($eventKey){
    //         case 'MYCARD':

    //             $data = userFaceWx::model()->getInfo(array('open_id'=>$obj->FromUserName));
    //             if($data['headimgurl'])
    //             {
    //                 $pic_url = 'http://wxtest.ikuaizu.com/'.$system_setting['attach_url'].'/'.$data['headimgurl'];            
    //                 $this->checkFace($pic_url,$data);                   
    //             }
    //             else{
    //                  $this->respond_text('miss headimgurl');        
    //             }
    //             break;
    //         case 'MYPIC':
    //             $this->respond_text("<a href ='http://wxtest.ikuaizu.com/upload/uploadPic?openId=".$obj->FromUserName."'>点击此链接，上传照片</a>"); 
    //             break;  
    //         default:
    //             break;
    //     }
    // }

    public function actionSubscribe($obj){
        // $token = WxApiTools::model()->getAccessToken();
        // if(empty($token)){
        //     $this->respond_text('get token failed');
        // }
        // $res = WxApiTools::model()->getUserInfo($obj->FromUserName,$token);
        // if(isset($res->errcode)){
        //     $this->respond_text($res->errmsg);
        // }
        // $data = array(
        //     'open_id'   =>$obj->FromUserName,
        //     'nickname'  =>$res->nickname,
        //     'sex'       =>$res->sex,
        //     'province'  =>$res->province,
        //     'city'      =>$res->city,
        //     'headimgurl'=>$this->savePic($res->headimgurl),
        //     'createtime'=>time(),
        //     );
        // if(!userFaceWx::model()->isExist($obj->FromUserName)){
        //     userFaceWx::model()->addUser($data);            
        // }
        $this->respond_text($this->getWelcome());
    }    
    
    public function actionUnsubscribe($obj){
    }

    // private function checkFace($pic_url,$data){
    //     $result = faceTools::model()->face_detect($pic_url);
    //     // skip errors
    //     if (empty($result->face)){
    //        $this->respond_text($this->getWelcome()."\r\n 您的头像不是真人头像，无法建立头像信息");
    //     }
    //     if (count($result->face) > 1){
    //          $this->respond_text($this->getWelcome()."\r\n 您的头像照片带有多个人物头像，无法建立头像信息");
    //     }
    //     $person = array(
    //         'age' =>$result->face[0]->attribute->age->value,
    //         'gender' =>$result->face[0]->attribute->gender->value,
    //         'race'  =>$result->face[0]->attribute->race->value,
    //         'person_id' => $data['open_id'],
    //         'person_name' =>$data['nickname'],
    //         'createtime' =>time(),    
    //         );
    //     $face = array(
    //         'age' =>$result->face[0]->attribute->age->value,
    //         'gender' =>$result->face[0]->attribute->gender->value,
    //         'race'  =>$result->face[0]->attribute->race->value,
    //         'face_id' => $result->face[0]->face_id,
    //         'person_id' =>$data['open_id'],
    //         'pic_url' =>$pic_url,
    //         'createtime' =>time(),    
    //         );         
    //     ///if() 判断在wgc_group表已经有了该person，没有就创建，有了就返回
    //     if(!facePerson::model()->isExist($data['person_id'])){
    //         faceTools::model()->person_create($data['open_id']);
    //         faceTools::model()->person_add_face($result->face[0]->face_id, $data['open_id']);
    //         faceTools::model()->group_add_person($data['open_id'],$this->group);
    //         facePerson::model()->addPerson($person);
    //         faceFace::model()->addFace($face);
    //     }
    //     //创建person(根据nickname) 

    //     $news[] =  array(
    //         'title' => "年龄: ".$person['age']." 性别: ".$person['gender']." 种族: ".$person['race'],
    //         'picurl'=> $pic_url,
    //         'url'=> $pic_url,
    //         'description' =>'头像信息创建完成，可以再上传自己的其他头像照片进行测试'
    //         );                
    //     $this->respond_news($news);      
    // }
    // private function savePic($url){

    //     $setting =  Config::getConfig('system');
    //     $fileUpload = new fileUpload($setting['attach_url']);
        
    //     $isurl = $url != 'filename' ? true : false;
    //     if(!$fileUpload->init($url,$isurl)){
    //         $this->showError($fileUpload->getErrorCode(),$fileUpload->getErrorMsg());
    //     }

    //     if (!$fileUpload->saveFile('face')) {
    //         $this->showError($fileUpload->getErrorCode(),$fileUpload->getErrorMsg());
    //     }
    //     return $fileUpload->attach['attachment'];
    // }
    // private function addPerson($result,$person_name,$group_name){
    //     $person = array(
    //         'age' =>$result->face[0]->attribute->age->value,
    //         'gender' =>$result->face[0]->attribute->gender->value,
    //         'race'  =>$result->face[0]->attribute->race->value,
    //         'person_id' => $data['open_id'],
    //         'person_name' =>$data['nickname'],
    //         'createtime' =>time(),    
    //         );
    //     faceTools::model()->person_create($person_name);
    //     faceTools::model()->group_add_person($person_name,$group_name); 
    //     facePerson::model()->addPerson($person);
    //     return true;       
    // }
    // private function addFace($result,$person_id,$pic_url){
    //     $face = array(
    //         'age' =>$result->face[0]->attribute->age->value,
    //         'gender' =>$result->face[0]->attribute->gender->value,
    //         'race'  =>$result->face[0]->attribute->race->value,
    //         'face_id' => $result->face[0]->face_id,
    //         'person_id' =>$person_id,
    //         'pic_url' =>$pic_url,
    //         'createtime' =>time(),    
    //         ); 
    //     faceFace::model()->addFace($face);
    //     return true;       
    // }
    private function getTrainResult($from_station,$to_station,$datetime){

        $url = "https://kyfw.12306.cn/otn/leftTicket/query?leftTicketDTO.train_date=$datetime&leftTicketDTO.from_station=$from_station&leftTicketDTO.to_station=$to_station&purpose_codes=0X00";
        // WxApiTools::model()->get($url);
        // return $from_station.$to_station.$datetime;
        return json_decode(WxApiTools::model()->get($url));       
    } 

}
