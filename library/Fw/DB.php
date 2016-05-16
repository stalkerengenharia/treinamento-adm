<?php
/** Banco Dados */ 
/**
 * caminho para o banco de dados
 * @author rafael
 *
 */
namespace stalker\library\Fw;
/**
 * solicita PDO
 */
use \PDO;

/**
 * Versao Classe DB 2.0
 * 
 * @author Fernando Dias <rodox17@gmail.com>
 * @package Fw
 * @category DB
 */
class DB { 
	
	/**
	 * Array com os valores
	 * do Where para evitar
	 * sql injection
	 *
	 * @access public
	 * @name $bind
	 * @var array
	 */
	public $bind;
	
	/**
	 * Guarda a conexao com
	 * o servidor de dados
	 *
	 * @access public
	 * @name $link
	 * @var PDO_Mysql
	 */
	public static $instance;
	
	/**
	 * Pertence a SELECT *(ou varivel)
	 *
	 * @access private
	 * @name $select
	 * @var string
	 */
	private $select;
	
	/**
	 * Pertence a FROM $varivel
	 *
	 * @access private
	 * @name $from
	 * @var string
	 */
	private $from;
	
	/**
	 * Pertence a ORDER BY $variavel
	 *
	 * @access private
	 * @name $order
	 * @var string
	 */
	private $order;
	
	/**
	 * Pertence a WHERE $variavel
	 *
	 * @access private
	 * @name $where
	 * @var string
	 */
	private $where;
	
	/**
	 * Pertence a GROUP BY $variavel
	 *
	 * @access private
	 * @name $group
	 * @var string
	 */
	private $group;
	
	/**
	 * Pertence a LIMIT $variavel
	 *
	 * @access private
	 * @name $limit
	 * @var string
	 */
	private $limit;
	
	/**
	 * Pertence a CALL $variavel
	 *
	 * @access private
	 * @name $procedure
	 * @var string
	 */
	private $procedure;
	
	/**
	 * salva toda sql
	 * 
	 * @name $parse
	 * @access private
	 */
	private $parse;
	
	/**
	 * Guarda a query SQL completa.
	 * Ex: SELECT $select FROM $from WHERE $where ORDER BY $order LIMIT $limit
	 * ou
	 * Ex: CALL $procedure
	 *
	 * @access private
	 * @name $query
	 * @var string
	 */
	private $query;
	
	/**
	 * Total de registros retornado
	 * de uma query SQL.
	 *
	 * @access private
	 * @name $total
	 * @var int
	 */
	private $total;
	
	/**
	 * apagar regustro BD
	 * @access public
	 */
	public function __construct(){
		
		/**
		 * solicita BD
		 */
		self::getInstance();
		
	}
	
	/**
	 * Apaga um registro no BD
	 * de acordo com um parametro string $where
	 * e uma string com o nome da tabela.
	 *
	 * @access public
	 * @param string $tabela Nome da tabela onde sera inserido os dados.
	 * @param string $where Qual registro alterar.
	 * @return void
	 */
	public function apagar($tabela,$where){
		
		$db = self::getInstance();
		
		$where = is_numeric($where)?"id=$where":$where;
		
		/*
		 * Se os dois parametros forem true
		*/
		if($where&&$tabela){
	
			$sql        = "DELETE FROM $tabela WHERE $where";
			$p_sql      = $db->prepare($sql);
			
			$p_sql->execute($bind);
		
		}
	
	}
	/**
	 * limpa as propriedades 
	 * 
	 * @param $query
	 * @access public
	 * @return fetchall
	 */
	public function parseSql($query){
	
		/**
		 * informa parse - var $query
		 * @name $query
		 */
		$this->parse = $query;
	
		return $this->fetchAll();
	
	}
	
	/**
	 * Limpa as propriedades
	 * para que nao haja erro
	 * quando for executar
	 * outra query com o
	 * mesmo link com o banco
	 * 
	 * @access private
	 * @return void
	 */
	private function cleanQuery(){
		
		$this->select    = '';
		$this->from      = '';
		$this->limit     = '';
		$this->parse     = '';
		$this->procedure = '';
		$this->where     = '';
		$this->group     = '';
		$this->order     = '';
		$this->total     = '';
		
	}
	
	/**
	 * Cria a conexao
	 * com o banco de dados
	 * usando a ferramento PDO_Mysql.
	 *
	 * @access public
	 */
	public static function getInstance() { 
		
		if(!isset(self::$instance)){
			
			$config          = new Config_Ini(PATH."application/configs/application.php");
			self::$instance = new PDO("mysql:host=w2host.com.br;dbname=w2hostco_treinamento", 'w2hostco_treinam', "lOr#9I@KZ9NL", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			
			self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING); 
			self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			
		}
		
		return self::$instance;
			
	} 
	
	/**
	 * Calcula o total de
	 * registros de acordo
	 * com o sql pre-montado
	 *
	 * @access public
	 * @return int
	 */
	public function getTotal(){
		
		$db = self::getInstance();
	
		/**
		 * Guarda query SQL temporario
		 *
		 * @var string
		 */
		$query = "SELECT COUNT(id) as 'c' FROM {$this->from} ";
	
		if($this->where){
			
			$query .= "WHERE ".$this->where;
			
		}
		
		$p_sql = $db->prepare($query);
		$p_sql->execute();
		
		$q = $p_sql->fetch();
		
		return $q['c'];
	}
	
	/**
	 * Salva um registro no BD
	 * de acordo com um parametro array
	 * e uma string com o nome da tabela.
	 * retorna o id do registro inserido
	 *
	 * @access public
	 * @param array $dados Exemplo: array("nome" => "fernando", "sobrenome" => "dias");
	 * @param string $tabela Nome da tabla onde sera inserido os dados.
	 * @return int
	 */
	public function salvar($dados, $tabela){
		
		$db = self::getInstance();
			
		/*
		 * Exclui o id do array $dados
		* para ele nao inserir de volta
		* o id que ja existe.
		*/
		unset($dados["id"]);
	
		foreach ($dados as $d => $v) {
				
			if(is_array($v)){
				
				continue;
				
			}
				
			if($v == ""){
				
				$bind[":$d"] = null;
				
			}else{
				
				$bind[":$d"] = $v;
				
			}
				
			if(!is_numeric($d)){
				
				$str_tab    .= "$d,";
				$str_values .= ":$d,";
				
			}
				
		}
			
		$str_tab    = rtrim($str_tab,',');$str_values = rtrim($str_values,',');
		$sql        = "INSERT INTO $tabela($str_tab) VALUES($str_values)";
		$p_sql      = $db->prepare($sql);
		
		$p_sql->execute($bind);
	
		return $db->lastInsertId();
		
	}
	
	/**
	 * Atualiza um registro no BD
	 * de acordo com um parametro array
	 * uma string com o nome da tabela
	 * e o where.
	 *
	 * @access public
	 * @param array $dados Exemplo: array("nome" => "fernando", "sobrenome" => "dias");
	 * @param string $tabela Nome da tabela onde sera inserido os dados.
	 * @param string $where Qual registro alterar.
	 * @return void
	 */
	public function atualizar($dados,$tabela,$where){
	
		if(!$where){
				
			return false;
				
		}
	
		/*
		 * Exclui o id do array $dados
		* para ele nao inserir de volta
		* o id que ja existe.
		*/
		unset($dados["id"]);
	
		foreach ($dados as $d => $v){
			
			$str_values .= "$d = :$d,";
							
			if($v == ""){
				
				$bind[":$d"] = null;
				
			}elseif(!is_numeric($d)&&!is_array($v)){
				
				$bind[":$d"] = $v;
				
			}
				
		}
		
		
		if(is_array($where)){
			
			$where_aux = $where;
			$where     = '';
			
			foreach ($where_aux as $titulo => $val){
				
				//$campo_nome  = str_replace(":", "", $d);
				//$where       = "$campo_nome = :$campo_nome";
				
				//$dados[$titulo] = $val;
				
			}
			
		}
	
		$str_values = rtrim($str_values, ',');
		$where      = "WHERE $where";
		$sql        = "UPDATE $tabela SET $str_values $where";
		//die("UPDATE $tabela SET $str_values $where");
		$p_sql      = self::getInstance()->prepare($sql);
		
		$p_sql->execute($bind);
	
	}
	
	/**
	 * Executa o SQL montado
	 *
	 * @access public
	 * @return array|false Se nao a consulta nao encontrar resultado retorna false
	 */
	public function fetchAll(){
		
		//echo $this->getQuery();
		$p_sql = self::getInstance()->prepare($this->getQuery());
		$p_sql->execute($this->bind);
		
		$resultado = $p_sql->fetchAll();
		
		$this->cleanQuery();
		
		return $resultado?$resultado:array();
		
	}
	
	/**
	 * Executa o SQL montado
	 *
	 * @access public
	 * @return array|false Se nao a consulta nao encontrar resultado retorna false
	 * @$sql
	 */
	public function parseNoReturn($sql){
		
		$p_sql = self::getInstance()->prepare($sql);
		$p_sql->execute();
		
	}
	
	/**
	 * Trata a comando
	 * SQL - SELECT
	 *
	 * @access public
	 * @param string|null $select
	 * @return Fw_DB
	 */
	public function select($select = null){
		
		/*
		 * Se nao vier parametro $select
		 * retorna * para todos
		 */
		if(!$select){
			
			$select="*";
			
		}
		
		$this->select = $select;
		
		return $this;
	}
	
	/**
	 * Setter do
	 * SQL - FROM
	 *
	 * @access public
	 * @param string $from
	 * @return Fw_DB
	 */
	public function from($from){
		
		$this->from = (string)$from;
		
		return $this;
	}
	
	/**
	 * Setter do
	 * array Bind do PDO
	 *
	 * @access public
	 * @param string $bind
	 * @return Fw_DB
	 */
	public function bind($bind){
		
		$this->bind = $bind;
		
		return $this;
	}
	
	/**
	 * Setter do
	 * SQL - ORDER
	 *
	 * @access public
	 * @param string $order
	 * @return Fw_DB
	 */
	public function order($order){
		
		$this->order = $order;
		
		return $this;
	}
	
	/**
	 * Setter do
	 * SQL - WHERE
	 *
	 * @access public
	 * @param string $where
	 * @param array $bind
	 * @return Fw_DB
	 */
	public function where($where, $bind = null){
		
		$this->where = $where;
		$this->bind  = $bind;
		
		return $this;
	}
	
	/**
	 * Setter do
	 * SQL - GROUP
	 *
	 * @access public
	 * @param string $group
	 * @return Fw_DB
	 */
	public function group($group){
		
		$this->group = $group;
		
		return $this;
	}
	
	/**
	 * Setter do
	 * SQL - LIMIT
	 *
	 * @access public
	 * @param string $limit
	 * @return Fw_DB
	 */
	public function limit($limit){
		
		$this->limit = $limit;
		
		return $this;
	}
	
	/**
	 * Chama a procedure
	 * e ja invoca/retorna o metodo fetchAll
	 * 
	 * @access public
	 * @param string $procedure Nome da procedure
	 * @return self::fetchAll()
	 */
	public function procedure($procedure){
		
		$this->procedure = $procedure;
		
		return $this->fetchAll();
		
	}
	
	/**
	 * Procura pelo registro
	 * baseado no id dele
	 * retorna UM array com o resultado
	 *
	 * @param int $id
	 * @param array $bind
	 * @return array
	 */
	public function find($idwhere,array $bind = array()){
		
		$db = self::getInstance();
	
		if(!$idwhere){
	
			return array();
	
		}
	
		if(is_numeric($idwhere)){
				
			$where = "id=:id";
			
			$bind = array(":id" => $idwhere);
				
		}else{
				
			$where = $idwhere;
				
		}
	
		$this->where($where);
		
		$p_sql = $db->prepare($this->getQuery());
		
		$p_sql->execute($bind);
		
		$this->cleanQuery();
	
		return $p_sql->fetch();
	
	}
	
	/**
	 * Monta a query SQL
	 * que sera executada no self::fetchAll()
	 *
	 * @access public
	 * @return string self::query
	 */
	public function getQuery(){
	
		/*
		 * Se a propriedade procedure
		* recebeu string, entao
		* self::query recebe a procedure
		* senao monta o SQL normal
		*/
		if($this->procedure){
				
			$this->query = "CALL $this->procedure";
				
		}elseif($this->parse){
				
			$this->query = $this->parse;
				
		}else{
				
			$this->select = ($this->select)?$this->select:"*";
				
			$this->query = "SELECT ".$this->select;
	
			if($this->from){
				
				$this->query .= " FROM ".$this->from;
				
			}
	
			if($this->where){
				
				$this->query .= " WHERE ".$this->where;
				
			}
				
			if($this->group){
				
				$this->query .= " GROUP BY ".$this->group;
				
			}
				
			if($this->order){
				
				$this->query .= " ORDER BY ".$this->order;
				
			}
				
			if($this->limit){
				
				$this->query .= " LIMIT ".$this->limit;
				
			}
			
		}
	
		/*
		 * Como a query ja esta salva
		* na propriedade self::query
		* limpa as propriedades
		*/
		//$this->cleanQuery();
	
		return $this->query;
	}
	
}

