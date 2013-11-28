<?php
class searchController extends AppController
{
    public function actionIndex(){
        $req = WinBase::app()->getRequest();
        
        $default = array(
            'keyword'=>'','min_price' => 0,'rent_type' => 1,'max_price' => 0,'lat' => 0,'lng' => 0,'room' => 0
        );
        $params = $req->getParams();
        if(isset($params['keyword'])){
            $params['keyword'] = urldecode($params['keyword']);
        }
        $data = array(
            'params'  => array_merge($default,$params),
            'min_price' => array('500','1000','1500'),
            'max_price' => array('2000','2500','3000','5000'),
        );
        $this->setMeta('title','快捷找房');
        $this->render("search_index",$data);  
    }
    
    public function actionDistrict(){
        $req = WinBase::app()->getRequest();
        
        if($req->isAjaxRequest()){
            $district_name = $req->getParam('district_name','');
            $page_no = $req->getParam('page_no',1);
            $page_size = $req->getParam('page_size',20);
            
            $search = array(
                'searchby'=>'keyword',
                'keyword'=>$district_name,
            );
            $res = $this->api('search_district',$search,$page_no,$page_size);
            if(isset($res['error']) || !$res['length']){
                echo json_encode(array('error'=>1,'msg'=>'没有找到符合"'.$district_name.'" 的小区'));
                exit;
            }
            
            echo json_encode(array('list'=>$res['data'],'length'=>$res['length']));
            exit;
        }
        
        $data = array();
        $this->setMeta('title','查找小区');
        $this->render("search_district",$data);
    }
    
    public function actionHouse(){
 
        $req = WinBase::app()->getRequest();
        $searchby = $req->getParam("searchby",'keyword');
        $keyword = $req->getParam("keyword",'');
        $lat = $req->getParam("lat",0);
        $lng = $req->getParam("lng",0);
        $room = $req->getParam("room",0);
        $min_price = $req->getParam("min_price",0);
        $max_price = $req->getParam("max_price",0);
        $rent_type = $req->getParam("rent_type",0);
        $orderby = $req->getParam("orderby",'createtime_desc');
        
        $page_size = 6;
        
        $search = array(
            'searchby' => $searchby,
            'keyword' => $keyword,
            'lat' => $lat,
            'lng' => $lng,
            'room' => $room,
            'rent_type' => $rent_type,
            'min_price' => $min_price,
            'max_price' => $max_price,
            'orderby' => $orderby
        );
        $res = $this->api('search_house',$search,1,$page_size);

        if(isset($res['error'])){
            $this->showMessage("未找到房源，请重新搜索");
        }

        $filter = array();
        if($keyword){
            $filter[] = $keyword;
        }
        
        if($lat && $lng){
            $filter[] = '范围1公里内';
        }
        
        if($min_price || $max_price ){
           $filter[] = $min_price .'-'. $max_price; 
        }
        
        if($room){
            $filter[] = $room.'房';
        }
        
        if($rent_type){
            $filter[] = $rent_type == 1 ? '整租' : $rent_type == 2 ? '单间' : '床位';
        }
        
        $list = array();
        foreach($res['data'] as $k=>$house){
            $house['dateline'] = Util::dgmdate($house['dateline']);
            $list[] = $house;
        }
        
        $data = array (
            'list' => $list,
            'uuid' => $this->uuid,
            'keyword'=>$keyword,
            'search' => $search,
            'page' => 1,
            'page_size' => $page_size,
            'orderby' => $orderby,
            'length' => $res['length'],
            'filter' => !empty($filter) ? join('<i>+</i>',$filter) : ""
        );
        $this->setMeta('title','搜索结果');
        $this->render("house_list",$data);        
    }

}