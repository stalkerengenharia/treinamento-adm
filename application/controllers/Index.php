<?php

namespace stalker\application\controllers;

use stalker\library\Fw as Fw;

/**
 * 
 * Redireciona usuario apos confirmação de login e senha correto.
 * 
 * @author Rafael Henrique <rsilva.ext@stalkerengenharia.com.br>
 * @access controller
 * @package APP
 * @subpackage Controllers
 */
class Index extends Fw\Controller{
	
	/**
	 * Pagina inicial após verificação de login.
	 * 
	 * @method !$_SESSION['geral']
	 * @access public
	 */
	public function indexAction(){
		
		/**
		 * Se variavel $_SESSION['geral'] for falsa/não existe
		 * entao, redireciona para pagina de login.
		 */
		if(!$_SESSION['geral']){
		
			/**
			 * Ao ser confirmado login com sucesso
			 * do usuario, sera direcionado para
			 * a aba 'Login'.
			 */
			header("Location: ".Fw\Vital::getUrl('Login'));
		
		}
		
	}
	
}