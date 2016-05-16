<?php

namespace stalker\library\Fw;

class Mask 
{
	static function get($val, $class = null){
		
		if(!$class){
			
			return $val;
			
		}
		
		if($class=="moeda-item"){
			
			return "R$ ".number_format($val,2);
			
		}
		
		if($class=="moeda"){

			return "R$ ".number_format($val,2,",",".");
				
		}
		
	}

	static function limpar($val, $class){
		
		str_replace("'", '"', $val);
		
		if($val == "__/__/____" || $val == "" || $val == "00/00/0000" || $val == "0000-00-00"){
			
			return "";
			
		}
			
		if(strstr($class, "data")){
		
			$val = Fw_Data::getDataEN($val);
		
		}elseif(strstr($class, "moeda")){
			
			if($val == "R$ 0,00"||$val==""){
				
				return '';
				
			}
		
			$val = str_replace(".", "", $val);
			$val = str_replace(",", ".", $val);
			$val = substr($val, 3);
		
		}elseif(strstr($class, "decimal")){
		
			$val = str_replace(".", "", $val);
			$val = str_replace(",", ".", $val);
			//$val = substr($val, 3);
		
		}elseif(strstr($class, "telefone") || strstr($class, "cep") || strstr($class, "cnpj")){
		
			$val = str_replace("(", "", $val);
			$val = str_replace(")", "", $val);
			$val = str_replace("/", "", $val);
			$val = str_replace("-", "", $val);
			$val = str_replace(".", "", $val);
		
		}
		
		
		return ($val)?$val:null;
	}
	
}

?>
