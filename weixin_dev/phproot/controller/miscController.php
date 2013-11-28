<?php
class miscController extends AppController
{
    
    public function actionSearchHouse(){
 
        $req = WinBase::app()->getRequest();
        $searchby = $req->getParam("searchby",'keyword');
        $keyword = $req->getParam("keyword",'');
        $lat = $req->getParam("lat",0);
        $lng = $req->getParam("lng",0);
        $room = $req->getParam("room",0);
        $min_price = $req->getParam("min_price",0);
        $max_price = $req->getParam("max_price",0);
        $page = $req->getParam("page",0);
        $page_size = $req->getParam("page_size",0);
        $orderby = $req->getParam("orderby",'createtime_desc');
        
        $data = array(
            'searchby' => $searchby,
            'keyword' => $keyword,
            'lat' => $lat,
            'lng' => $lng,
            'room' => $room,
            'min_price' => $min_price,
            'max_price' => $max_price,
            'orderby' => $orderby
        );
        
        $res = $this->api('search_house',$data,$page,$page_size);
        //print_r($res);
        if(isset($res['error'])){
            echo json_encode(array('error' => 1,'msg' => '未找到房源，请重新搜索。'));
            exit;
        }
        
        foreach($res['data'] as $k=>$house){
            $res['data'][$k]['dateline'] = Util::dgmdate($house['dateline']);
        }        
        echo json_encode($res);
        exit();      
    }

}
?>