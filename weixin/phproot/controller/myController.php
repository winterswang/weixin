<?php
class myController extends AppController
{
    public function actionCollect()
    {
        $res = $this->api('favorite_list',1,10);
        if(isset($res['error'])){
            $res['data'] = array();
        }

        $res = array(
            'list' => $res['data']
        );
        $this->setMeta('title','我的收藏');
        $this->render("my_collect", $res);
    }

    public function actionReserve()
    {
        $res = $this->api('reserve_list',array('for_user' => 1));

        if(isset($res['error'])){
            $res['data'] = array();
        }

        $data = array(
            'list' => $res['data']           
        );

        $this->setMeta('title','我的预约');
        $this->render("my_reserve",$data);
    }

    public function actionRent()
    {
        $res = $this->api('my_rent');

        if(isset($res['error'])){
            $res['data'] = array();
        }
        
        if(empty($res['data'])){
            $links[] = array(
                'title' => '查看发房帮助',
                'href' => '/system/help?type=publish&uuid='.$this->uuid,
            );
            $this->showMessage('您还发布过房源',0,$links);
        }
        
        $data = array(
            'list' => $res['data']           
        );
        $this->setMeta('title','我的房源');
        $this->render("my_rent",$data);
    }
    
    public function actionHouse(){
        $req = WinBase::app()->getRequest();
        $house_guid = $req->getParam('house_guid',0);
        
        $res = $this->api('my_house',$house_guid);
        if(isset($res['error'])){
            $links[] = array(
                'title' => '返回上一页',
                'href' => 'javascript:history.go(-1)',
            );	
            $this->showMessage($res['msg'],1,$links);
        }
        
        $this->setMeta('title','我的房源');
        $this->render("my_house",$res);
    }
}
?>