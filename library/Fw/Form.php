<?php 

namespace stalker\library\Fw;

/**
 * Monta os elementos do 
 * formularios em HTML a um
 * array public $elementos.
 * 
 * @author Fernando Dias <rodox17@gmail.com>
 * @package API
 * @subpackage Form
 */
class Form{
	
	/**
	 * Array com os elementos 
	 * do formulario html
	 * 
	 * @access public
	 * @name $elementos
	 * @var array
	 */
	public $elementos;
	
	/**
	 * Array com os elementos
	 * do formulario html obrigatorios
	 *
	 * @access public
	 * @name $required
	 * @var array
	 */
	public $required;
	
	/**
	 * Nome da tabela
	 * que utilizara os forms
	 *
	 * @access public
	 * @name $tabela
	 * @var string
	 */
	public $tabela;
    
	/**
	 * Cria o html do elemento text
	 *
	 * @access public
	 * @param string $nome_elemento Nome do elemento
	 * @return void
	 */
	public function setTexto($dados){
		
		$required = (strstr($dados['class'], "required"))?"required":null;
		$r        = (strstr($dados['class'], "required"))?"<span class='req'>*</span>":"";
		
		if($dados['readonly']){
			
			if(!$dados['valor']){
				
				$dados['valor'] = '-';
				
			}else{
				
				$dados['valor'] = Fw_Mask::get($dados['valor'],$dados['class']);
				
			}
			
			$dados['class'] = $dados['class']=='data'?'':$dados['class'];
			
			$elm = "<div class='{$dados['class']}' style='display:inline;'><strong id='label_{$dados['nome']}' style='font-size: 18px;'>".$dados['valor']."</strong></div>";
			
		}else{
			
			if($dados['mais_info']){
					
				$mais_info    = "<label id='detalhes_{$dados['nome']}' style='display: none;'></label>";
				$tab_detalhes = $ttab;
					
			}
			
			if(strstr($dados['class'], "data")){
				//die($dados['valor']);
				$dados['valor'] = Fw_Data::getDataBR($dados['valor']);
				//$tam_data = "width: 125px;";
				
			}
			
			if(strstr($dados['class'], "telefone")){
				
				//$tam_data = "width: 110px;";
				
			}
			
			if(strstr($dados['class'], "cep")){
				
				$tam_data = "width: 70px;";
				
			}
			
			if(strstr($dados['class'], "cpf")){
				
				//$tam_data = "width: 110px;";
				
			}
			
			if(strstr($dados['class'], "tags")){
				
				$tabela = str_replace("get_", "", $dados['tabela']);$tabela = str_replace("_lista", "", $tabela);
				
				if($dados['privilegio']=='R'){
					
					$disabled = "disabled";
					
				}
				
				$elm_tag = "<input $disabled $opt class='$required $disabled text-input tags-aux' type='text' 
							style='margin-left: 0px;width: 65px;'
							value='{$dados['valor']}' name='{$dados['nome']}' 
							id='{$dados['nome']}' />";
		
				$elm     = "<input $disabled $opt class='$disabled text-input tags' type='text' id='tags_{$dados['nome']}'
						    tabela='{$dados['tabela']}' where='{$dados['where']}' campos_mais_info='{$dados['campos_mais_info']}' 
						    id_elm='{$dados['nome']}' style='padding-left: 32px;width: 272px;'
						    campo='{$dados['campo_tabela']}' name='auto' /> <span class='id-help'>ID</span> $elm_tag 
						    
							<img src='public/images/search.png' 
							title='Pesquisar'
							style='width: 30px;margin-left: 5px;position: absolute;margin-left: 50px;
							font-size: 13px;margin-top: 0px;display: none;' 
							class='tip' />
						    ";
				
				if(!$dados['relatorio']){
					
					$elm .= "
								<img src='public/images/icones/square181.png' title='Adicionar Novo {$dados['titulo']}' 
								style='width: 32px;margin-left: 10px;font-size: 13px;position: absolute;margin-left: -5px;' 
								class='tip' onclick='criarSubForm(".'"'.$_POST["base"]."php/#!/form/tabela/{$tabela}".'"'.",\"$tabela\");' />";
					
				}
				
				
			}else{
				
				if($dados['privilegio']=='R'){
				
					$disabled = "disabled";
				
				}
				
				$dados['valor'] = str_replace("'", "&#39;", $dados['valor']);
		
				$elm = "<input autocomplete='off' $opt $disabled class='{$dados['class']} $required $disabled text-input' type='text' 
						style='$tam_data'
						value='{$dados['valor']}' name='{$dados['nome']}' id='{$dados['nome']}' />";
				
			}
			
		}
		
		if($dados['nome']=='enderecos_cep[]'){
			
			$elm .= "<input type='button' style='width: 60px;margin-left: 5px;font-size: 13px;' class='ignore-validate btn busca-cep' value='Buscar' />";
			
		}
		
		if(strstr($dados['class'], "tituloLeft")){
		
			$style = "style='display: inline;'";
		
		}
		
		$this->elementos[] = array(
			"nome"       => $dados['nome'],
			"elemento"   => "<label class='titulo-elm' $style >{$dados['titulo']} $r</label>$elm $mais_info",
			"class"      => $dados['class'],
			"left"       => $dados['left'],
			'floatRight' => $dados['floatRight']
		);
		
	}
    
	/**
	 * Cria o html do elemento button.
	 *
	 * @access public
	 * @param string $nome_elemento Nome do elemento
	 * @return void
	 */
	public function setBotao($dados){
		
		($required)?$this->required[$nome_elemento]=$titulo:null;
		$r=($required)?"*":null;
		
		$this->elementos[] = array(
			"nome"=>$dados['nome'],
			"elemento"=>"<label><input $opt class='{$dados['class']}' style='border:1px solid #cccccc;padding: 5px;margin-top: 15px;' 
			type='button' value='{$dados['titulo']}' name='{$dados['nome']}' id='{$dados['nome']}' /></label>",
			"class"=>$class,
			"left"=>$left
		);
		
		if($tipo){
			//$this->criaTabela($nome_elemento,$tipo);
		}
	}
    
	/**
	 * Cria o html do elemento password
	 *
	 * @access public
	 * @param string $nome_elemento Nome do elemento
	 * @return void
	 */
	public function setSenha($nome_elemento,$titulo,$valor=null,$required=null){
		//$this->valor[$nome_elemento]=$valor;
		$this->elementos[] = array(
			"nome"=>$nome_elemento,
			"elemento"=>"<label><div>$titulo</div><input class='$required' style='width:368px;border:1px solid #cccccc;' type='password' value='$valor' name='$nome_elemento' /></label>"
		);
	}
    
	/**
	 * Cria o html do elemento checkbox
	 *
	 * @access public
	 * @param string $nome_elemento Nome do elemento
	 * @return void
	 */
	public function setCheckbox($dados){
		
		$checked=(!$dados['valor'])?null:"checked";
		$valor=(!$dados['valor'])?1:$dados['valor'];
		
		if($dados['privilegio'] == "R"){
			
			$disabled = "disabled";
			
		}
		
		$this->elementos[] = array(
			"nome"=>$dados['nome'],
			"elemento"=>"<label>{$dados['titulo']}</label>
			<input $disabled class='$required $class $disabled' $checked type='checkbox' 
			value='1' name='{$dados['nome']}' id='{$dados['nome']}' />"
		);
		
		if($dados['campo']){
			$this->criaTabela($nome_elemento,$campo);
		}
	}
	
	/**
	 * Faz uma busca num array multidimensional
	 *
	 * @access public
	 * @param array $array Array a ser varrido
	 * @return array $results
	 */
	public function search($array, $key, $value){
		
		$results = array();
	
		if (is_array($array))
		{
			if (isset($array[$key]) && $array[$key] == $value)
				$results[] = $array;
	
			foreach ($array as $subarray)
				$results = array_merge($results, $this->search($subarray, $key, $value));
		}
	
		return $results;
		
	}
	
	/**
	 * Monta o FORM pela tabela.
	 *
	 * @access public
	 * @param string $tabela Arquivo XML/tabela a ser formatada
	 * @return void
	 */
	public function getForm($tabela, $dados, $form_src, $par, $ronly){
		
		foreach($form_src as $f){
			
			$f     = ($f["@attributes"])?$f["@attributes"]:$f;
			$valor = (string)$dados[(string)$f["nome"]];
			
			$readonly = ($perm[0]["privilegio"]=="R")?true:false;
			$readonly = ($ronly)?true:$readonly;
			
			if(strstr($f["nome"],"enderecos_")){

				$cc = 0;
				
				if($tabela=="id_enderecos2"){
					
					$cc = 1;
					
				}
				
				$nome_aux = str_replace('[]', '', (string)$f["nome"]);
				$valor    = $par['anexo'][$nome_aux][$cc];
				
			}
			
			if($f["par"]=="anexar"){
				
				if(!$anexo){
				
					/*$id_anex = (string)$f["id"];
					$dados_anex = $db->select()->from($f["nome"])->find($dados[$id_anex]);
					
					$this->campo("separador", "{'titulo':'{$f["titulo"]}'}");
					$this->campo("hidden", "{'nome':'{$id_anex}','valor':'{$dados[$id_anex]}'}");
					
					$this->getForm($f["nome"], $dados_anex, $permissoes, $f["readonly"], true);*/
					
				}
				
			}else{
				
				if($f["multiple"]){
					
					//$db    = new DB();
					//$valor = $db->select()->from($f["tabela_ligacao"])->where("id_$tabela={$dados["id"]}")->fetchAll();
						
				}
				
				$f["user"]       = $dados["user"];
				$f["id"]         = $dados["id"];
				$f["tabela_aux"] = $tabela;
				$f["readonly"]   = $f['readonly']?$f['readonly']:$readonly;
				$f['relatorio']  = $dados['relatorio'];
				
				if($f['default']&&!$valor){
					
					$valor = $f['default'];
					
				}

				$this->campo($f["tipo"], $f, $valor);
				
			}
			
		}
		
	}
	
	/**
	 * Metodo principal da criacao dos forms.
	 *
	 * @access public
	 * @param string $tipo_campo Ex: text, select, checkbox
	 * @return void
	 */
	public function campo($tipo_campo,$dados,$valor,$valor_array=null){
		
		$dados['valor'] = $valor;
		
		//$this->criaTabela($tabela, $nome, $dados->campo);
		
		switch ($tipo_campo){
			
			case 'proc':{
				
				if($dados['valor']){
				
					$this->elementos[] = array(
							"nome"     => $dados['nome'],
							"tipo"     => $tipo_campo,
							"titulo"   => $dados['titulo'],
							"elemento" => "<div class='elementos' style='background:url(public/images/postit.png) no-repeat;
							height: 250px;width: 260px;padding: 20px;float:right;font-size: 17px;'>
												<h4 style='border-bottom: 1px dashed gray;width: 230px;padding-bottom: 10px;'>{$dados['titulo']}</h4>{$dados['valor']}</div>"
					);
					
				}
				
				
				break;
			
			}
			
			case 'anexo_multiplo':{
				
				$this->elementos[] = array(
						"nome"     => $dados['nome'],
						"singular" => $dados['singular'],
						"class"    => $class,
						"tipo"     => $tipo_campo,
						"titulo"   => $dados['titulo'],
						"elemento" => "<div class='elementos' rel='anexo_{$dados['tabela']}'
						ondblclick=\"getSubLista('{$dados['nome']}','{$dados['id']}','{$dados['tabela']}','{$dados['readonly']}','{$dados['titulo']}','{$dados["tabela_aux"]}','{$dados['limit']}');\"
						id='sublista_{$dados['nome']}'>
						
						<div style='text-align: center'>
							<img style='margin-top: 20px;' src='public/images/360.GIF' />
						</div>
						</div>
						<script>$('#sublista_{$dados['nome']}').dblclick();</script>"
						);
					
				break;
			
			}
			
			case 'botao':{
				
				$this->setBotao($dados);
				
				break;
			}
			
			case 'arquivo':{
				
				$this->setArquivo($dados);
				
				break;
			}
			
			case 'arquivo_unico':{
				
				$this->setArquivoUnico($dados);
				
				break;
			}
			case 'checkbox':{
				
				$this->setCheckbox($dados);
				
				break;
			}
			case 'hidden':{
				
				$this->elementos[] = array(
						"type"=>'hidden',
						"nome"=>$dados['nome'],
						"elemento"=>"<input type='hidden' class='ignore-validate'
						value='{$dados['valor']}' name='{$dados['nome']}' 
						id='{$dados['nome']}' />"
				);
				
				break;
			}
			case "separador":{
				
				$this->elementos[] = array(
						"type"     => "separador",
						"elemento" => "<h2>{$dados['titulo']}</h2><hr />"
				);
				
				break;
			}
			case "link":{
				
				$id_link=DB::escape($_POST['id']);
				
				$link = "{$dados['link']}/id/$id_link";
				
				if($_POST['id']){
				
					$link = "{$_POST["base"]}php/#!/$link";
					
				}else{
				$link = "javascript:salvarForm(\"$link\");";
				}
				
				$this->elementos[] = array(
						"elemento" => "<div style='margin-top: 40px;'><a class='link' target='blank' href='$link'>&raquo; {$dados['titulo']}</a></div>"
				);
				
				break;
			}
			case "areatexto":{
				
				$this->setAreaTexto($dados);
				
				break;
				
			}
			case "texto":{
				
				$this->setTexto($dados);
				
				break;
			}
			case "select":{
				
				$r     = (strstr($dados["class"], "required"))?"<span class='req'>*</span>":null;
				$clone = (strstr($dados["class"], "clone"))?"<img onclick='clone(this);' src='public/images/novo.png' />":null;
				$multiple_name = ($clone)?"[]":null;
				
				foreach($dados["lista"] as $op){
					
					$opcao_selecionada = '';
					
					if(is_array($valor)){
					
						/*if($this->search($valor, "id_subcontratados", $op["id"])){
							$opcao_selecionada = "selected='selected'";
						}*/
						
					}else{
						
						if($valor==$op["id"]){
							
							$opcao_selecionada = "selected='selected'";
							
						}
						
					}
					
					$vals = explode(",",$dados["campo_tabela"]);
					$vals_html = '';
					
					foreach($vals as $vv){
						
						$vals_html .= $op[$vv]. " - ";
						
					}
					
					$vals_html = rtrim($vals_html,' - ');
					
					$inativo = strstr($vals_html, 'INATIVO')?'alert("Esse usuario encontra-se INATIVO.");$(this).parent().val("");':null;
					$options .= "<option onclick='$inativo' $opcao_selecionada value='{$op["id"]}'>$vals_html</option>";
					
				}
				
				if($valor_array){
					
					foreach($valor_array as $k => $va){
						
						if((int)$valor==$va){

							$opcao_selecionada = "selected='selected'";
							
						}
						
						$options .= "<option $opcao_selecionada value='{$k}'>{$va}</option>";
					}
					
				}
					
				if($dados['mais_info']){
					
					$mais_info       = "<label id='detalhes_{$dados['nome']}' style='margin-bottom: 10px;display: none;'></label>";
					$dados['class'] .= " detalhes";
					$tab_detalhes    = $dados['tabela'];
				
				}
				
				$ttab = str_replace("get_", "", $dados["tabela"]);
				
				//$href="javascript:abrirSubForm(\"{$_POST["base"]}php/form.php?tabela=$ttab&campo_auxiliar={$dados["nome"]}&label_auxiliar={$dados['novo_auxiliar']}&fechar=1\",this);";
				$adicionar_novo=($dados['novo_form'])?"<a target='_blank' title='Cria um novo {$dados['titulo']}.' class='novo' style='margin: 3px;margin-left: 5px;'
				href='$href'>&nbsp;
				</a>":null;
				
				$options = "<option value=''>Selecione</option>".$options;
				
				if($dados['readonly'] || $dados['privilegio'] == 'R'){
				
					$disabled = "disabled";
				
				}
				
				$elemento_select = "<select campos_mais_info='{$dados['campos_mais_info']}' tabela='$tab_detalhes' $disabled $multiple class='$disabled {$dados['class']}' 
					name='{$dados['nome']}$multiple_name' id='{$dados['nome']}' >".$options."</select> $adicionar_novo $mais_info $clone";
				
				$this->elementos[] = array(
						"nome"     => $dados['nome'],
						"elemento" => "<label>{$dados['titulo']} $r</label>
						$elemento_select",
						"class"    => $class,
						"left"     => $dados['left']
				);
			
				return "<select $multiple class='$class' name='$nome$multiple_name' id='$nome' >".$options."</select>";
					
				break;
				
			}
		}
	}
    
	/**
	 * Cria o html do elemento checkbox
	 *
	 * @access public
	 * @param string $nome_elemento Nome do elemento
	 * @return void
	 */
	function setSelect(){
		
	}
	
	/**
	 * Cria o html do elemento textarea
	 * com formatacao fckeditor
	 *
	 * @access public
	 * @param string $nome_elemento Nome do elemento
	 * @return void
	 */
	public function setAreaTexto($dados){

		$required = (strstr($dados['class'], "required"))?"required":null;
		$r        = (strstr($dados['class'], "required"))?"<span class='req'>*</span>":"";
		
		if(strstr("simples",$dados['class'])){
			
			
		}else{
			
			$html = "<input type='hidden' name='{$dados['nome']}' rel='editor_{$dados['nome']}' class='input_editor' value='{$dados['valor']}' />
					<span id='editor_{$dados['nome']}' class='editor $required {$dados['class']}' style='width: 500px;height: 400px;' 
					id='{$dados['nome']}'>{$dados['valor']}</span>";
			
		}
		
		if($dados['privilegio']=='R'){
		
			$disabled = "disabled";
		
		}
		
		if($dados['valor']){
			
			//$editar = "display: none;";
			
			//$html = "<div id='{$dados['nome']}_html'>{$dados['valor']}</div><a onclick='editarTexto(\"#{$dados['nome']}\",this);'>Editar Texto</a><br />";
			
		}
		
		$html = "<textarea $disabled class='$required {$dados['class']} $disabled' style='$editar width: 500px;height: 100px;' 
				id='{$dados['nome']}' name='{$dados['nome']}'>{$dados['valor']}</textarea>";
		
		$mce = (!$layout)?"mceEditor":null;
		
		$this->elementos[] = array(
			"nome"=>$dados['nome'],
			"elemento"=>"
				<div>
					<label>{$dados['titulo']} $r</label>
					$html
				</div>",
			"class"=>$class,
			"left"=> $dados['left']
		);
		
		if($tipo){
			//$this->criaTabela($dados['nome'],$tipo);
		}
		
	}
	
	/**
	 * Cria o html do elemento hidden
	 *
	 * @access public
	 * @param string $nome_elemento Nome do elemento
	 * @return void
	 */
	public function setHidden($dados){
		
		$this->elementos[] = array(
			"type"=>'hidden',
			"nome"=>$dados['nome'],
			"elemento"=>"<input type='hidden' value='{$dados['valor']}' name='{$dados['nome']}' />"
		);
		
		if($campo){
			//$this->criaTabela($nome_elemento,$campo);
		}
		
	}
	
	/**
	 * Json convert
	 *
	 * @access static
	 * @param string $json String a ser convertida em json
	 * @return json
	 */
	static function jsonDecode($json){
		
		$json=str_replace("'",'"',$json);
		
		return json_decode($json);
	}
	
	public function setArquivo($dados){
		
		$html_upload = "
						<div style=''>
							<a href='javascript:abrirFormArquivo();'>Enviar Arquivos</a> |
							<a href='javascript:excluirArquivo();'>Excluir Arquivos Selecionados</a>
						</div>
						
						<div>

							<input type='text' id='pesquisa-arquivos' class='ignore-validate' style='width: 250px;margin: 10px 0;padding: 7px;padding-left: 32px;
							background: url(public/images/lupa.png) no-repeat 5px;color:gray;' 
							value='Pesquisar Arquivos' onclick='this.value=\"\"' >
							
						</div>
						";
		
		$this->elementos[]=array(
				'nome'     => $dados['nome'],
				'elemento' => "<div style='margin: 15px 0;margin-bottom:10px;'>
				Arquivos
				$html_upload 
				
					<div id='lista-arquivos'></div>
				</div>
				<script>atualizarImagens();</script>
				");
		
	}
	
	/**
	 * Cria o html do elemento file
	 *
	 * @access public
	 * @param array $dados Nome do elemento
	 * @return void
	 */
	public function setArquivoUnico($dados){

		if($dados['valor']){
		
			$file=explode(".", $dados['valor']);
			$file=$file[1];
			
			$src = "{$_POST["base"]}upload/{$dados['valor']}";
			
			if($file=="pdf"){
				$src = 'public/images/pdf.png';
			}elseif($file=="mp3"){
				$src = 'public/images/mp3.png';
			}
		
			$descricao="<a target='_blank' href='{$_POST["base"]}upload/{$dados['valor']}'>
						<img width='100' src='$src'/></a>";
				
			$imagem_excluir="$descricao<br /><span style='margin-right: -10px;margin-top :7px;'>Excluir&nbsp;<input type='checkbox' name='excluir_arquivo[{$dados['nome']}]' value='{$dados['nome']}' /></span><br />";
		}
			
		if($dados->return_elemento){
			return "<div>$imagem_excluir</div>";
		}
			
		$this->elementos[]=array(
				'nome'     => $dados['nome'],
				'tipo'     => 'arquivo',
				'elemento' => "<br /><label>{$dados['titulo']}</label><div>$imagem_excluir <input type='file' name='arquivo_unico[{$dados['nome']}]' /></div><br />"
				);
		
		
	}
	
	/**
	 * Cria tabela e as colunas
	 * se nao existirem
	 *
	 * @access public
	 * @param array $campo Nome do elemento
	 * @return void
	 */
	public function criaTabela($tabela,$campo,$tipo){
		
			//mysql_query("CREATE TABLE IF NOT EXISTS ".$tabela." ( id MEDIUMINT NOT NULL AUTO_INCREMENT, PRIMARY KEY (id) )");
			//mysql_query("ALTER TABLE ".$tabela." ADD COLUMN $campo $tipo;");
			//mysql_query("ALTER TABLE ".$tabela." ADD COLUMN ordem int;");
			//mysql_query("ALTER TABLE ".$tabela." ADD COLUMN ln varchar(2);");
		
	}
	
	public function getElemento($tipo, $json, $valor, $valor_array=null){
		
		$dados        = Form::jsonDecode($json);
		
		return $this->campo($tipo,$json,$valor, $valor_array);
		
		//return $this->search($this->elementos, "nome", $dados->nome);
	}
	
	static function upload($name,$upload_path){
		
		$allowed_types=array(
				'image/gif',
				'image/jpeg',
				'image/jpg',
				'image/png',
				'application/pdf',
		);
		
		$dphp = strstr($_FILES[$name]["name"], ".php");
		
		if(!$dphp){
				
			if (in_array($_FILES[$name]["type"], $allowed_types)){
					
				$path="../".$upload_path."/".$_FILES[$name]["name"];
				$path2=$upload_path."/".$_FILES[$name]["name"];
					
				unserialize($path);
				move_uploaded_file($_FILES[$name]["tmp_name"], $path);
		
				return ($name)?$path2:null;
		
			}
		
		}
		
		return null;
			
	}
	
}

?>