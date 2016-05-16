<?php

namespace stalker\library\Fw;

/**
 * Auxilia na criação
 * dos graficos.
 * Retorna o javascript do
 * google Chart para criacao
 * dos graficos
 *
 * @author Fernando Dias <rodox17@gmail.com>
 * @package APP
 * @subpackage Grafico
 */
class Grafico{
	
	/**
	 * Registra a conexao com
	 * o banco de dados.
	 *
	 * @var Fw\DB
	 * @name $db
	 * @access public
	 */
	public $db;
	
	/**
	 * Contem os ids das
	 * operacoes para
	 * filtro SQL
	 *
	 * @example id_operacoes IN($in_op).
	 * @var Fw\DB
	 * @name $db
	 * @access public
	 */
	public $in_op;
	
	/**
	 * Ano selecionado
	 *
	 * @var integer
	 * @name $ano
	 * @access public
	 */
	public $ano;
	
	/**
	 * Titulo do grafico.
	 *
	 * @var string
	 * @name $titulo
	 * @access public
	 */
	public $titulo;
	
	/**
	 * Itens do grafico.
	 *
	 * @var string
	 * @name $itens
	 * @access public
	 */
	public $itens;
	
	/**
	 * Codigo javascript
	 * que retorna para view.
	 *
	 * @var string
	 * @name $js
	 * @access public
	 */
	public $js;
	
	/**
	 * ID da div que
	 * sera criada para
	 * auxiliar no grafico.
	 *
	 * @var string
	 * @name $div
	 * @access public
	 */
	public $div;
	
	/**
	 * Instancia algumas
	 * priopriedades necessaria
	 * para toda classe.
	 *
	 * @access public
	 * @param Fw\DB $db
	 * @param string $in_op
	 * @param integer $ano
	 */
	public function __construct(){
		
	}
	
	/**
	 * Monta o javascript
	 * do Google Chart para
	 * exibicao na view.
	 *
	 * @access public
	 * @param array $total
	 * @param string $titulo
	 * @param string $vtitulo
	 * @param string $htitulo
	 * @access private
	 */
	private function showLineChart($total,$titulo,$vtitulo,$htitulo){
		
		$perguntas .= "'Questão',";
		
		/**
		 * Cria a lista com as informações do nome da pergunta
		 * e a média dos votos de cada pergunta.
		 */
		foreach($total as $o){
			
			/**
			 * Aprimoramento para informações
			 * do gráfico gerada onde pode ser
			 * inserido caracteres especiais
			 */
			$o['total'] = $o['total']?$o['total']:'0';
			$o['nome'] = htmlspecialchars_decode($o['nome']);

			/**
			 * Posição do gráfico onde apresentará
			 * o texto informando Pergunta eo tópico
			 * e apresentando gráfico
			 */
			$html .= "['{$o['nome_geral']}'";
			$html .= ',{v:'.$o['total'].', f:"Pontuação Média '.number_format($o['total'],2).'"}';
			$html .= "],";
			
		}

		/**
		 * Apresenta no gráfico o significado da cor
		 * da barra de gráfico.
		 * 
		 * @var $perguntas
		 */
		$this->titulo = rtrim($perguntas,',');
		$this->itens  = rtrim($html,',');
			
		/**
		 * var options determina interface Horizontal
		 * e vertical do gráfico
		 */
		$this->js     = "

		/**
		 * chama tabela perguntas para o grafico
		 */
		google.setOnLoadCallback(function(){
		 
		var data = google.visualization.arrayToDataTable([
		['Perguntas',{$this->titulo}],
		{$this->itens}
		]);
		
		var options = {
			
			title: '$titulo',
			
			/**
 			* Caso variável = 0 gráfico dessa variavel fica invisível.
			* 
 			*/
	        sliceVisibilityThreshold:0,
	        
	        /**
			* espaço do gráfico entre o topo da página fica = 0.
 			* 
 			*/
	        chartArea:{top: 0},
	        

			'vAxis':{
			
			},
			
			'hAxis': {
			
			/**
			* total de colunas para visualização do resultado.
 			* 
 			*/
			ticks:[0,1,2,3,4,5]

			}
		 
		};
		
		/**
		 * insere o formato da apresentação do gráfico.
		 */	
		var chart = new google.visualization.BarChart(document.getElementById('{$this->div}'));
			
			/**
			* Aqui insere tamanho fixo do gráfico 
			*/
			chart.draw(data, options);
			
		});";
		
		/**
		 * apresenta gráfico
		 */
		echo "<div class='rel-draw' id='{$this->div}'></div><script type='text/javascript'>{$this->js}</script>";
		
	}
	
	/**
	 * 
	 * Busca do BD as perguntas
	 * para serem inseridas
	 * no gráfico
	 * 
	 * @access public
	 * @param string $db
	 */
	public function getPerguntas(){
		
		
		$db = new DB();
		
		$this->div = 'aas';
		/**
		 * insere filtro do grupo
		 */
		if($_GET['grupo']){
			
			$filtro_grupo = " AND cli.id_grupos={$_GET["grupo"]}";
			
		}
		
		/**
		 * Consulta no BD cada avaliacao de cada grupo para separar
		 * a pontuação de acordo com a area
		 */
		$consulta = "SELECT SUM(avaliacao)/COUNT(ava.id) 
						FROM avaliacoes ava 
						JOIN cliente cli ON cli.id = ava.id_cliente $filtro_grupo
						WHERE ava.id_perguntas=pe.id";
		
		/**
		 * Busca a pergunta seguido do topico
		 * para conhecimento de qual pergunta
		 * é direcionada para cada tópico.
		 */
	    $total = $db->
				select("($consulta) as 'total',pe.*,CONCAT(pe.nome,': ',pe.nome_topico) as 'nome_geral'")->
				from('get_perguntas pe')->
				where("($consulta) IS NOT NULL")->
				fetchAll();

		
	    /**
	     * Apresenta o numero da avaliação no gráfico.
	     *
	     */
	    $this->showLineChart($total, 'Avaliação', 'Perguntas', 'Pontos');
		
	    /**
	     * Busca informação do BD da tabelo grupos.
	     *
	     */
		$_GET["grupo"]=="";
		
		
	}
	
	
}

?>
