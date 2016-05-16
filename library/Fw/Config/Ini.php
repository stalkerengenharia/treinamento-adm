<?php 

namespace stalker\library\Fw;

use \stdClass;

/**
 * Trata o arquivo de
 * inicializacao com os parametros
 * de conexao com o banco de dados.
 *
 * @author Fernando Dias <rodox17@gmail.com>
 * @package Fw
 * @subpackage Config
 * @category Ini
 */
class Config_Ini { 
	
	/**
	 * Guarda os parametros
	 * de conexao com o banco.
	 *
	 * @access public
	 * @var stdClass
	 * @name $database
	 */
	public $database;
	
	/**
	 * Pega o arquivo do ini
	 * por parametro e cria o objeto
	 * de inicializacao dos parametros.
	 *
	 * @access public
	 * @param string $ini_files
	 */
	public function __construct($ini_file){

		$ini_a = parse_ini_file($ini_file);
		$ini   = new stdclass;
		
		foreach ($ini_a as $key=>$value) {
			
			$c = $ini;
			
			foreach (explode(".", $key) as $key) {
				
				if (!isset($c->$key)) {
					
					$c->$key = new stdclass;
					
				}
				
				$prev = $c;
				$c    = $c->$key;
				
			}
			
			$prev->$key = $value;
			
		}
		
		$this->database = $ini->database;
		
	}
	
}