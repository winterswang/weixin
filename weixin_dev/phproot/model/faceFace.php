<?php
class faceFace extends BaseDb{
	public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

	public function buildWhere($where = array()){

		$whereArr = array();
		
		if(isset($where['id']) && $where['id']){
			$whereArr[] = " id = '".$where['id']."'";
		}
 		if(isset($where['face_id']) && !empty($where['face_id'])){
			$whereArr[] = " face_id = '".$where['face_id']."'";
		}   
		if(isset($where['person_id']) && !empty($where['person_id'])){
			$whereArr[] = " person_id	 = '".$where['person_id']."'";
		}		
		if(isset($where['createtime']) && !empty($where['agent_tel'])){
			$whereArr[] = " agent_tel = '".$where['agent_tel']."' ";
		}		
		if(isset($where['age']) && !empty($where['age'])){
			$whereArr[] = " age = '".$where['age']."' ";
		}
		if(isset($where['gender']) && !empty($where['gender'])){
			$whereArr[] = " gender = '".$where['gender']."' ";
		}
		if(isset($where['race']) && !empty($where['race'])){
			$whereArr[] = " race = '".$where['race']."' ";
		}
		if(isset($where['pic_url']) && !empty($where['pic_url'])){
			$whereArr[] = " pic_url = '".$where['pic_url']."' ";
		}
		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';
	}
	public function isExist($face_id){
		$count = $this->getCount(array('face_id' =>$face_id));
		if($count>0){
			return true;
		}else{
			return false;
		}
	}
	public function getCount($where = array()){
		$sql = "SELECT count(id) as count FROM person_face ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count'];
	}
	public function getInfoByid($id)
	{	
		$sql = "SELECT * FROM person_face ".$this->buildWhere(array('id' =>$id ));
		return $this->fetch($sql);
	}
	
	public function getInfo($where)
	{	
		$sql = "SELECT * FROM person_face ".$this->buildWhere($where);
		return $this->fetch($sql);
	}
    
	public function getList($where = array(),$page_no = 1, $page_size = 10)
	{
        $sql = "select * from person_face". $this->buildWhere($where) .$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
    
	public function getAll($where = array(),$limit = 0)
	{
		$limit_str = '';
		if($limit > 0){
			$limit_str = ' LIMIT '.$limit;
		}
        $sql = "select * from person_face". $this->buildWhere($where) .$limit_str;
		return $this->fetch_all($sql);
	}    
    
    public function getHashCode($arr){
    	return  md5($arr);
    }

    public function addFace($arr){
        
		$this->getDb()->beginTransaction();	

		if(!$this->insert('person_face',$arr)){
			$this->getDb()->rollBack();
		}
        
        return $this->getDb()->commit();
    }

	public function updateFace($arr,$where)
	{
        return $this->update('person_face',$arr, $where);
	}
}