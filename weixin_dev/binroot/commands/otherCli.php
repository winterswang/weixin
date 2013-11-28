<?php
class otherCli extends BaseCli{

	function actionIndex($method){
		if(method_exists($this,$method)){
			$this->$method();
		}
	}
	function testIdentify()
	{
		$system_setting = Config::getConfig('system');
		faceTools::model()->train_identify('wgc_group');
		$pic_url = 'http://wxtest.ikuaizu.com/data/attachment/face/201311/26/210124d4syybyyzsldiu7b.jpg';		
        $result = faceTools::model()->recognition_identify($pic_url,'wgc_group');
        $is_identified = 0;
        $confidence = '';
        $person_name = '';
        if (empty($result->face)){
           print_r("您的头像不是真人头像，无法建立头像信息");exit();
        }
        if (count($result->face) > 1){
            print_r("\r\n 您的头像照片带有多个人物头像，无法建立头像信息");exit();
        }
        // $this->respond_text($pic_url);exit();            
        $confidence =$result->face[0]->candidate[0]->confidence;
        $person_name  =$result->face[0]->candidate[0]->person_name;
        $is_identified = 1; 
                        
        if(round($confidence) >=50)
        {
            $data = array(
                'user_open_id' =>'osodat4UMvW7xcnB7S7UZydunnOw',
                'pic_url' =>$pic_url,
                'confidence' => $confidence,
                'person_name'  => $person_name,
                'is_identified' =>$is_identified,
                'createtime' =>time(),
                );
            //userPic::model()->addUserPic($data);

            $info =  userFaceWx::model()->getInfo(array('open_id' =>$person_name));
            print_r($info);
            $news =  array(
                'title' => "相似度：$confidence",
                'picurl'=> 'http://wxtest.ikuaizu.com/'.$system_setting['attach_url'].'/'.$info['headimgurl'],
                'url'=> 'http://wxtest.ikuaizu.com/'.$system_setting['attach_url'].'/'.$info['headimgurl'],
                'description' =>'点击阅读全文',
            );                
            print_r($news);                          
        }else{
            print_r('暂未找到相似的脸谱，需要我帮你创建一个吗？');
        }
	}
	function testAddFace(){
		$data = array(
			'open_id' =>'osodat4UMvW7xcnB7S7UZydunnOw',
			);
		$pic_url = 'http://wxtest.ikuaizu.com/data/attachment/face/201311/26/210124d4syybyyzsldiu7b.jpg';
		$result = faceTools::model()->face_detect($pic_url);
		print_r($result);exit();
        // skip errors
        if (empty($result->face)){
           $this->respond_text($this->getWelcome()."\r\n 您的头像不是真人头像，无法建立头像信息");
        }
        if (count($result->face) > 1){
             $this->respond_text($this->getWelcome()."\r\n 您的头像照片带有多个人物头像，无法建立头像信息");
        }
        $person = array(
            'age' =>$result->face[0]->attribute->age->value,
            'gender' =>$result->face[0]->attribute->gender->value,
            'race'  =>$result->face[0]->attribute->race->value,
            'person_id' => $data['open_id'],
            'person_name' =>'',
            'createtime' =>time(),    
            );
        $face = array(
            'age' =>$result->face[0]->attribute->age->value,
            'gender' =>$result->face[0]->attribute->gender->value,
            'race'  =>$result->face[0]->attribute->race->value,
            'face_id' => $result->face[0]->face_id,
            'person_id' =>$data['open_id'],
            'pic_url' =>$pic_url,
            'createtime' =>time(),    
            );         
        ///if() 判断在wgc_group表已经有了该person，没有就创建，有了就返回
        if(!facePerson::model()->isExist($data['open_id'])){
            faceTools::model()->person_create($data['open_id']);
            faceTools::model()->person_add_face($result->face[0]->face_id, $data['open_id']);
            faceTools::model()->group_add_person($data['open_id'],"wgc_group");
            facePerson::model()->addPerson($person);
            faceFace::model()->addFace($face);
            print_r($person);
        	print_r($face);
        }

	}
	function testAddFaceByPerson(){

	}
	function faceTrain(){
		faceTools::model()->train_identify('wgc_group');
	}
}