<?php

/**
 * Caminho para a aba controller grafico.
 */
namespace stalker\application\controllers;

/**
 * Solicita a liberação do acesso
 * da pasta Fw.
 */
use stalker\library\Fw as Fw;

/**
 * Solicita a liberação do acesso
 * da pasta models.
 */
use stalker\application\models as models;

/**
 * Busca resultados da avaliacao para
 * a geracao dos graficos separando
 * por grupos correspondentes.
 * 
 * @author Rafael Henrique <rsilva.ext@stalkerengenharia.com.br>
 * @access controller
 * @package APP
 * @subpackage Controllers
 */
class Grafico extends Fw\Controller{

	/**
	 * Metodo default para todos controllers.
	 * @method getUser()
	 * @access public
	 */
	public function init(){
		
		/**
		 * Seleciona todas informações do gráfico.
		 */
		Fw\Vital::getUser();
	
	}	 
	/**
	 * Insere lista do BD da tabelo grupos no gráfico.
	 * @method Fw\DB()
	 * @access public
	 */
	public function indexAction(){
	
		/**
		 * Solicitação do banco de dados.
		 *
		 * @name $db
		 * @var Fw\DB
		 */
		$db = new Fw\DB();
	
		/**
		 * Busca todas os registros da tabela grupos.
		 */
		$this->view->grupos = $db->select()->from("grupos")->fetchAll();
	
	}
	
	}
