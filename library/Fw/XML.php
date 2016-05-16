<?php 

namespace stalker\library\Fw;

class XML{
	
	public $xml;
	public $elementos;
	public $arquivo;
	
	function XML($arquivo){
		
		$this->xml = simplexml_load_file($arquivo);
		
	}
	
	public function xmlToArray($xml=null, $root = true) {
		
		if (!$xml->children()) {
			die("erro xml");
			return (string)$xml;
		}
	
		$array = array();
		foreach ($xml->children() as $element => $node) {
			$totalElement = count($xml->{$element});
	
			if (!isset($array[$element])) {
				$array[$element] = "";
			}
	
			// Has attributes
			if ($attributes = $node->attributes()) {
				$data = array(
						'attributes' => array(),
						'value' => (count($node) > 0) ? $this->xmlToArray($node, false) : (string)$node
						// 'value' => (string)$node (old code)
				);
	
				foreach ($attributes as $attr => $value) {
					$data['attributes'][$attr] = (string)$value;
				}
	
				if ($totalElement > 1) {
					$array[$element][] = $data;
				} else {
					$array[$element] = $data;
				}
	
				// Just a value
			} else {
				if ($totalElement > 1) {
					$array[$element][] = xmlToArray($node, false);
				} else {
					$array[$element] = xmlToArray($node, false);
				}
			}
		}
	
		if ($root) {
			return array($xml->getName() => $array);
		} else {
			return $array;
		}
		
	}

}

?>