<?php 

namespace stalker\library\Fw;

/**
 * Classe responsavel
 * por tratar dos controllers
 *
 * @author Fernando Dias <rodox17@gmail.com>
 * @package Fw
 */
class Controller{
	
	/**
	 * Interacao do controller
	 * com a view
	 * 
	 * @var mixed
	 * @name $view
	 * @access public
	 */
	public $view;
	
	/**
	 * Interacao do controller
	 * 
	 * @var mixed
	 * @name $view
	 * @access public
	 */
	public $app_path;
	
	/**
	 * Verifica se chama
	 * a view ou nao.
	 * Caso $render == false
	 * nao chama o script da view.
	 *
	 * @var bool
	 * @name $view
	 * @access public
	 */
	public $render = true;
	
	/**
	 * Verifica se chama
	 * o cabecalho e rodape.
	 *
	 * @var bool
	 * @name $layout
	 * @access public
	 */
	public $layout = true;
	
	/**
	 * Setter para o $render
	 *
	 * @access public
	 */
	public function setNoRender(){
		
		$this->render = false;
		
	}
	
	/**
	 * Setter para o $layout
	 *
	 * @access public
	 */
	public function setNoLayout(){
		
		$this->layout = false;
		
	}
	
	/**
	 * Setter para o $layout
	 * funcao para chamar view $path
	 * @access public
	 * @param string $path
	 */
	public function setAppPath($path){
		
		$this->app_path = $path;
		
	}
	
	/**
	 * Chama o script da view
	 * depois do controller
	 * terminar.
	 *
	 * @access public
	 */
	public function __destruct(){
		
		$url_params      = Vital::getUrlParams();
		
		if($this->render == true){
		
			if($this->layout){
				
				include_once PATH."application/layouts/cabecalho.php";
				
			}
			
			if($this->app_path){
				
				include_once PATH."application/{$this->app_path}.php";
				
			}else{
			
				include_once PATH."application/views/{$url_params['controller_name']}/{$url_params['action_name']}.php";
				
			}
			
			
			if($this->layout){
			
				include_once PATH."application/layouts/rodape.php";
			
			}
			
		}
		
	}
	
}

?>