<?php
class XmlParse{
	
	public static function XML2Array($xml , $recursive = false){
		if (!$recursive ){
			$array = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
		}else{
			$array = $xml;
		}
	   
		$newArray = array();
		$array = (array) $array;
		foreach ( $array as $key => $value ){
			$value = (array) $value;
			if (isset ($value[0])){
				$newArray[$key] = trim($value[0]);
			}else{
				$newArray[$key] = XmlParse::XML2Array($value,true);
			}
		}
		return $newArray;
	}
	
	public static function Array2XML($data_array){

        $xml='';
        foreach($data_array as $key=>$val){
			if(is_array($val) && is_numeric($key)){
				$key = key($val);
				$val = array_shift($val);
			}
			
			$xml.="<$key>";
			$xml.= is_array($val) ? XmlParse::Array2XML($val):$val;
			list($key,)=explode(' ',$key);
			$xml.="</$key>";
        }
        return $xml;
	}	
}