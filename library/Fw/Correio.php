<?php

namespace stalker\library\Fw;

require_once "correio/informacoesCorreios.php";

/**
 * Responsavel pela
 * comunicacao com o webservice
 * dos correios para buscar dados
 * do endereco baseado no numero do CEP.
 *
 * @author Fernando Dias <rodox17@gmail.com>
 * @package Fw
 * @category Correio
 */
class Correio{
	
	/**
	 * Propriedade responsavel
	 * por armazenar as informacoes
	 * do objeto do correio.
	 * 
	 * @name $informacoesCorreios
	 * @var informacoesCorreios
	 * @access public
	 */
	public $informacoesCorreios;

	/**
	 * Busca o cep no webservice
	 * dos correios.
	 * 
	 * @param string $cep 83403-250
	 * @access public
	 * @return array
	 */
	public function buscarCep($cep){
		
		$ch = curl_init();

			curl_setopt_array($ch, array
			(
				CURLOPT_URL 			=> "http://www.buscacep.correios.com.br/servicos/dnec/consultaEnderecoAction.do",
				CURLOPT_POST			=> TRUE,
				CURLOPT_POSTFIELDS		=> "relaxation={$cep}&TipoCep=ALL&semelhante=N&Metodo=listaLogradouro&TipoConsulta=relaxation&StartRow=1&EndRow=10&cfm=1",
				CURLOPT_RETURNTRANSFER	=> TRUE
			));

			$response = curl_exec($ch);
			curl_close($ch);

			preg_match_all("/>(.*?)<\/td>/", $response, $matches);

			return $matches[1];
	}

	/**
	 * Popula o objeto dos correios.
	 * 
	 * @param string $cep 83403-250
	 * @access public
	 */
	public function retornaInformacoesCep($cep){
		
	 	$informacoesCorreios = $this->buscarCep($cep);

		$this->informacoesCorreios = new informacoesCorreios();
		$this->informacoesCorreios->setLogradouro($informacoesCorreios[0]);
		$this->informacoesCorreios->setBairro($informacoesCorreios[1]);
		$this->informacoesCorreios->setLocalidade($informacoesCorreios[2]);
		$this->informacoesCorreios->setUf($informacoesCorreios[3]);
		$this->informacoesCorreios->setCep($informacoesCorreios[4]);

	}
}

?>