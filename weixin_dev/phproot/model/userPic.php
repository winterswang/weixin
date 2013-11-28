<?php
class userPic extends BaseDb{
	public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

	public function buildWhere($where = array()){

		$whereArr = array();
		
		if(isset($where['id']) && $where['id']){
			$whereArr[] = " id = '".$where['id']."'";
		}
 		if(isset($where['user_open_id']) && !empty($where['user_open_id'])){
			$whereArr[] = " user_open_id = '".$where['user_open_id']."'";
		}   
		if(isset($where['pic_url']) && !empty($where['pic_url'])){
			$whereArr[] = " pic_url	 = '".$where['pic_url']."'";
		}		
		if(isset($where['is_identified']) && !empty($where['is_identified'])){
			$whereArr[] = " is_identified = '".$where['is_identified']."' ";
		}				
		if(isset($where['person_name']) && !empty($where['person_name'])){
			$whereArr[] = " person_name = '".$where['person_name']."' ";
		}
		if(isset($where['confidence']) && !empty($where['confidence'])){
			$whereArr[] = " confidence = '".$where['confidence']."' ";
		}
		if(isset($where['createtime']) && !empty($where['agent_tel'])){
			$whereArr[] = " agent_tel = '".$where['agent_tel']."' ";
		}
		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';
	}
	public function isExist($user_open_id){
		$count = $this->getCount(array('user_open_id' =>$user_open_id));
		if($count>0){
			return true;
		}else{
			return false;
		}
	}
	public function getCount($where = array()){
		$sql = "SELECT count(id) as count FROM user_pic ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count'];
	}
	public function getInfoByid($id)
	{	
		$sql = "SELECT * FROM user_pic ".$this->buildWhere(array('id' =>$id ));
		return $this->fetch($sql);
	}
	
	public function getInfo($where)
	{	
		$sql = "SELECT * FROM user_pic ".$this->buildWhere($where);
		return $this->fetch($sql);
	}
    
	public function getList($where = array(),$page_no = 1, $page_size = 10)
	{
        $sql = "select * from user_pic". $this->buildWhere($where) .$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
    
	public function getAll($where = array(),$limit = 0)
	{
		$limit_str = '';
		if($limit > 0){
			$limit_str = ' LIMIT '.$limit;
		}
        $sql = "select * from user_pic". $this->buildWhere($where) .$limit_str;
		return $this->fetch_all($sql);
	}    
    
    public function getHashCode($arr){
    	return  md5($arr);
    }

    public function addUserPic($arr){
        
		$this->getDb()->beginTransaction();	

		if(!$this->insert('user_pic',$arr)){
			$this->getDb()->rollBack();
		}
        
        return $this->getDb()->commit();
    }

	public function updateUserPic($arr,$where)
	{
        return $this->update('user_pic',$arr, $where);
	}
}