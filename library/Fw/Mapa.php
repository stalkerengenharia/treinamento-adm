<?php
/** seleciona mapa*/
/**
 * pagina do mapa
 * @author rafael
 *
 */
namespace stalker\library\Fw;

/**
 * mapa
 * @author rafael
 *
 */
class Mapa{
	
	/**
	 * finaliza busca
	 * 
	 * @name $end
	 * @access public
	 */
	public $end;
	
	/**
	 * atualiza
	 * 
	 * @name $status
	 * @access public
	 */
	public $status;
	
	/**
	 * busca informações
	 * 
	 * @name $infos
	 * @access public
	 */
	public $infos;
	
	/**
	 * separa por diaria
	 * 
	 * @name $diaria
	 * @access public
	 */
	public $diaria;
	
	/**
	 * busca no banco de dados 
	 * o id de cada site
	 * 
	 * @name id_sites
	 * @access public
	 */
	public $id_sites;
	
	/**
	 * 
	 * @name $latitude e longitude
	 * @access public
	 */
	public $latlon;
	
	/**
	 * id unidades
	 * @name $une
	 * @access public
	 */
	public $une;
	
	/**
	 * id das operacoes
	 * @name $operacoes
	 * @access public
	 */
	public $operacoes = false;
	
	/**
	 * tabela dos registros
	 * @name $unes
	 * @access public
	 */
	public $unes = array(
				1 => array('estados' => 'id_estado = 16 or id_estado = 24','latlon'  => '-25.4743521,-51.2134356','zoom'    => '8'),
				2 => array('estados' => 'id_estado = 21','latlon'  => '-30.4163414,-53.6704593','zoom'    => '7'),
				3 => array('estados' => 'id_estado = 13','latlon'  => '-18.5779703,-45.4514505','zoom'    => '7'),
				4 => array('estados' => 'id_estado = 5','latlon'  => '-13.4343799,-41.982751','zoom'    => '7'),
				5 => array('estados' => 'id_estado = 17','latlon'  => '-8.3779283,-38.0825865','zoom'    => '7'),
				6 => array('estados' => 'id_estado = 25','latlon'  => '-22.5455869,-48.6355227','zoom'    => '7'),
				7 => array('estados' => 'id_estado = 14','latlon'  => '-3.6250659,-52.4812983','zoom'    => '7'),
				8 => array('estados' => 'id_estado = 16 or id_estado = 24 or  id_estado = 14 or  id_estado = 25 or  id_estado = 17 or  id_estado = 5 or  id_estado = 13 or  id_estado = 21 ','latlon'  => '-14.2392976,-53.1805018','zoom'    => '4'));
	
	public $legenda_status = array(
				6  => array('icone' => "wifi.png",'titulo' => 'Em Execução'),
				4  => array('icone' => "wifi-red.png",'titulo' => 'Pendência'),
				9  => array('icone' => "wifi-yellow.png",'titulo' => 'Programada'),
				10 => array('icone' => "wifi-green.png",'titulo' => 'Liberada'),
				97 => array('icone' => "tools.png",'titulo' => 'Equipamento'),
				98 => array('icone' => "pedestriancrossing.png",'titulo' => 'Colaborador'),
				99 => array('icone' => "truck3-blue.png",'titulo' => 'Colaborador em Atividade'));
	
	/**
	 * mapa
	 * @access public
	 * @var Fw_Mapa
	 */
	public function Fw_Mapa(){
		
		$db             = new Fw_DB();
		
		$usu            = Fw\Vital::getUser();
		$todos_status   = '10,9,6,4';
		
		$this->une = $this->unes[$usu['id_une']];
		
		if($_POST){
		
			foreach($_POST['status'] as $k => $v){
		
				$st .= "$v,";
		
			}
		
			$todos_status = rtrim($st,',');
		
			if($_POST['mostrar']){
		
				$this->une['responsavel'] = " AND id_usuarios={$usu['id']}";
		
			}
		
		}
		
		if($_POST['mostrar']){
		
			$coord        = " AND id_usuarios = {$usu['id']} ";
			$coord_diaria = " AND id_coords = {$usu['id']} ";
		
		}
		
		$link           = BASE."index.php/#!/Form/index/tabela/obras/id/";
		$link_diarias   = BASE."index.php/MapaDiario/index/?nome=";
		
		$obras          = $db->
							select("gss.*,concat('<table><tr><td>',group_concat(concat('ID</td><td>:</td><td><a target=\"_blank\" href=\"$link',gss.id_obras,'\">',gss.id_obras,'</a> - ',gss.status) separator '</td></tr><tr><td>'),'</td></tr></table>') as info")->
							from("get_sites_obras gss")->
							where("nome_cidade IS NOT NULL AND id_status_obras IN (".$todos_status.") and (".$this->une['estados'].") {$this->une['responsavel']} $coord")->
							group("nome_cidade")->fetchAll();
		
		$diarias        = $db->select("count(id) as total_diarias,id_sites,id_usuarios,lat,lon,id_obras,nome_usuario,group_concat(concat('ID : ','<a target=\"_blank\" href=\"$link',id_obras,'\">',if(id_obras=1174 OR id_obras=4656,'Folga',if(id_obras=4622 OR id_obras = 4614 OR id_obras = 4630,'Ficticia',id_obras)),'</a>',' - <a target=\"_blank\" href=\"$link_diarias',nome_usuario,'\">',nome_usuario,'</a>') separator '<br />') as colab,busca_cidade")->
							from("get_diarias_relatorio")->
							where("data = curdate() and busca_cidade IS NOT NULL $coord_diaria")->
							group("busca_cidade")->fetchAll();
		
		$equipamentos   = $db->select("eu.id_usuarios,ae.modelo,eu.nome")->
							from("almox_equipamentos ae JOIN get_almox_equipamentos_usuarios eu ON (SELECT MAX(aai.id) FROM almox_equipamentos_usuarios aai WHERE aai.id_almox_equipamentos = ae.id AND aai.id_usuarios IS NOT NULL) = eu.id")->
							group("ae.id")->fetchAll();
		
		$search[0] = false;
		$colab[0]  = false;
		$us[0]     = false;
		
		foreach($equipamentos as $d){
		
			$eq[$d['id_usuarios']] = $d;
		
		}
		
		foreach($diarias as $d){
		
			$search[] = $d['busca_cidade'];
			$colab[]  = $d['colab'];
			$us[]     = $d;
		
		}
		
		foreach ($obras as $ob){
		
			// Quando existe obra e colaborador na mesma cidade
			if($arr = array_search("{$ob['nome_cidade']}, {$ob['nome_estado']}, Brasil", $search)){
		
				$ob['id_status_obras'] = 99;
				$ob['info']           .= "<hr />{$colab[$arr]}";
		
				if($e = $eq[$us[$arr]['id_usuarios']]){
		
					$ob['info']           .= "<hr />{$e['modelo']} com {$e['nome']}";
		
				}
		
				unset($search[$arr]);
				unset($colab[$arr]);
				unset($us[$arr]);
		
			}
		
			$ob['nome_cidade'] = ($ob['nome_cidade']);
		
			$end      .= "'{$ob['nome_cidade']}, {$ob['nome_estado']}, Brasil',";
			$latlon   .= "'{$ob['lat']},{$ob['lon']}',";
			$id_sites .= "'{$ob['id_sites']}',";
			$infos    .= "'{$ob['nome_cidade']}<hr />{$ob['info']}',";
			$status   .= "'{$ob['id_status_obras']}',";
		
		}
		
		foreach($search as $k => $s){
		
			if(!$colab[$k]){
				
				continue;
				
			}
		
			$nome_cidade = explode(",", $s);
			$nome_cidade = $nome_cidade[0];
		
			$end       .= "'{$s}',";
			$latlon    .= "'{$us[$k]['lat']},{$us[$k]['lon']}',";
			$id_sites  .= "'{$us[$k]['id_sites']}',";
			$html_info  = "$nome_cidade<hr />{$colab[$k]}";
			$status    .= "'98',";
		
			$infos    .= "'$html_info',";
		
		}

		$this->end = rtrim($end,','); $this->status = rtrim($status,','); $this->infos = rtrim($infos,','); $this->diaria = rtrim($diaria,','); $this->id_sites = rtrim($id_sites,','); $this->latlon = rtrim($latlon,',');
		
	}
}

?>
