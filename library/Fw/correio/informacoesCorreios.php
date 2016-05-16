<?php

/**
 * Classe setter getter
 * dos correios.
 *
 * @author Fernando Dias <rodox17@gmail.com>
 * @package Fw
 * @category Correio
 */
class informacoesCorreios{
	
	/**
	 * Logradouro.
	 * 
	 * @name $logradouro
	 * @access private
	 */
	private $logradouro;
	
	/**
	 * Bairro para cadastro de e-mail.
	 *
	 * @name $bairro
 	 * @access private

	 */
	private $bairro;
	
	/**
	 * Localização do usuario.
	 *
	 * @name $localidade
	 * @access private
	 */
	private $localidade;
	
	/**
	 * uf
	 *
	 * @name $uf
	 * @access private
	 */
	private $uf;
	
	/**
	 * Cep do usuario.
	 *
	 * @name $cep
	 * @access private
	 */
	private $cep;

	/**
	 * Puxa logradouro do 
	 * banco de dados do
	 * cliente.
	 * @name getLogradouro
	 * @access public
	 */
	public function getLogradouro()
	{	
		/**
		 * retorna logradouro
		 * @return logradouro
		 */
		return $this->logradouro;
	}
	/**
	 * Inserir logradouro
	 * @param insere logradouro no BD $logradouro
	 * @access public
	 */
	public function setLogradouro( $logradouro )
	{	
		/**
		 * Armazena logradouro.
		 * @var $logradouro
		 */
		$this->logradouro = $logradouro;
	}
	/**
	 * Puxa bairro do cliente.
	 * @access public
	 */
	public function getBairro()
	{
		/**
		 * retorna bairro.
		 * @return bairro
		 */		
		return $this->bairro;
	}
	/**
	 * Armazena bairro.
	 * @var $logradouro
	 * @param string $bairro
	 * @access public
	 */
	public function setBairro( $bairro )
	{
		$this->bairro = $bairro;
	}
/**
 * Puxa Localidade do cliente
 * @access public
 */
	public function getLocalidade()
	{
		/**
		 * retorna localidade
		 * @return localidade
		 */
		return $this->localidade;
	}
/**
 * Insere Localidade
 * @param insere localidade do cliente $localidade
 * @access public
 */
	public function setLocalidade( $localidade )
	{
		/**
		 * Armazena localidade.
		 * @name localidade
		 */
		$this->localidade = $localidade;
	}
	/**
	 *Puxa Uf do cliente. 
	 *@access public
	 */
	public function getUf()
	{
		/**
		 * retorna uf cliente.
		 */
		return $this->uf;
	}
	/**
	 * Insere Uf cliente.
	 * @param Insere Uf no banco 
	 * de dados $uf
	 * @access public
	 */
	public function setUf( $uf )
	{
		/**
		 *Armazena Uf na @var $uf
		 */
		$this->uf = $uf;
	}
	/**
	 * Puxa Cep do cliente.
	 */
	public function getCep()
	{	
		/**
		 * retorno Cep cliente
		 * @return Cep
		 */
		return $this->cep;
	}
	/**
	 * Insere Cep do Cliente
	 * @param Insere Cep do cliente $cep
	 * @access public
	 */
	public function setCep( $cep )
	{	
		/**
		 * Armazena Cep do cliente
		 * @name $cep
		 */
		$this->cep = $cep;
	}
}

?>