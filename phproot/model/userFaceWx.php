<?php
class userFaceWx extends BaseDb{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    public function buildWhere($where = array()){

    	$whereArr = array();

		if(isset($where['id']) && $where['id']){
			$whereArr[] = " id = '".$where['id']."'";
		}
		if(isset($where['open_id']) && $where['open_id']){
			$whereArr[] = " open_id = '".$where['open_id']."'";
		}
		if(isset($where['nickname']) && $where['nickname']){
			$whereArr[] = " nickname = '".$where['nickname']."'";
		}
		if(isset($where['sex']) && $where['sex']){
			$whereArr[] = " sex = '".$where['sex']."'";
		}
		if(isset($where['province']) && $where['province']){
			$whereArr[] = " province = '".$where['province']."'";
		}
		if(isset($where['city']) && $where['city']){
			$whereArr[] = " city = '".$where['city']."'";
		}
		if(isset($where['headimgurl']) && $where['headimgurl']){
			$whereArr[] = " headimgurl = '".$where['headimgurl']."'";
		}	
		if(isset($where['createtime']) && $where['createtime']){
			$whereArr[] = " createtime = '".$where['createtime']."'";
		}
		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';									
    }

	public function isExist($open_id){
		$count = $this->getCount(array('open_id' =>$open_id));
		if($count>0){
			return true;
		}else{
			return false;
		}
	}
	public function getCount($where = array()){
		$sql = "SELECT count(open_id) as count FROM user_face_wx ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count'];
	}
	public function getInfoByOpenId($openId)
	{	
		$sql = "SELECT * FROM user_face_wx ".$this->buildWhere(array('open_id' =>$openId ));
		return $this->fetch($sql);
	}
	public function getInfo($where = array()){
		$sql = "SELECT * FROM user_face_wx ".$this->buildWhere($where);
		return $this->fetch($sql);		
	}
	public function getList($where = array(),$page_no = 1, $page_size = 10,$orderby = 'createtime_desc')
	{
        $sql = "select * from user_face_wx". $this->buildWhere($where) . $this->order($orderby) .$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
	public function getAll($where = array(),$limit = 0,$orderby = 'createtime_desc')
	{
		$limit_str = '';
		if($limit > 0){
			$limit_str = ' LIMIT '.$limit;
		}
        $sql = "select * from user_face_wx". $this->buildWhere($where) . $this->order($orderby).$limit_str;
		return $this->fetch_all($sql);
	}
    public function addUser($arr){
        
		$this->getDb()->beginTransaction();

		if(!$this->insert('user_face_wx',$arr)){
			$this->getDb()->rollBack();
		}        
        $this->getDb()->commit();
    }

	public function updateUser($arr,$where)
	{
        return $this->update('user_face_wx',$arr, $where);
	}	   
}