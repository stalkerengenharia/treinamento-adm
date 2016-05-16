<?php 

namespace stalker\library\Fw;

/**
 * Classes que auxilia
 * em processos basicos
 * do sistema.
 *
 * @author Fernando Dias <rodox17@gmail.com>
 * @package Fw
 * @category Vital
 */
class Vital{
	
	public static function searchForId($id, $array) {
	
		foreach ($array as $key => $val) {
		  
			if($val == $id){
				 
				return $val;
	
			}
	
		}
	
		return null;
	
	}
	
	/**
	 * Cria o SQL para filtrar
	 * os registros pela UNE
	 * que cada usuario pertence.
	 *
	 * @static
	 * @access public
	 * @return string SQL com id_une do usuario
	 */
	public static function getQueryUsuarioUne(){
	
		$us = Fw\Vital::getUser();
	
		/**
		 * Se usuario pertence a UNE Holding,
		 * mostra todos registro.
		 */
		if($us['id_une'] == 8){
				
			return "id_une > 0";
				
		}
	
		if($us['une_auxiliar']){
	
			return "id_une IN({$us['id_une']},{$us['une_auxiliar']})";
	
		}else{
	
			return "id_une = '{$us['id_une']}'";
	
		}
	
	}
	
	public static function sendEmail($fields){
		
		$email = $fields['destinatario'];
		$mail   = new PHPMailer; // call the class
		$mail->CharSet = 'utf-8';
		$mail->IsSMTP();
		$mail->Host = 'mail.loretelecom.com.br'; //Hostname of the mail server
		$mail->Port = '587'; //Port of the SMTP like to be 25, 80, 465 or 587
		$mail->SMTPAuth = true; //Whether to use SMTP authentication
		$mail->Username = 'notificacao@loretelecom.com.br'; //Username for SMTP authentication any valid email created in your domain
		$mail->Password = 'colombo1'; //Password for SMTP authentication
	
		if($rep = $fields['replyto']){
				
			$rep_n = $fields['replyto'];
			$rep_n = explode(',',$rep_n);
				
			foreach ($rep_n as $ad) {
					
				$mail->AddReplyTo(trim($ad)); //reply-to address
					
			}
				
		}else{
				
			$rep   = "notificacao@loretelecom.com.br";
			$rep_n = "Stalker Sistemas";
				
			$mail->AddReplyTo($rep, $rep_n); //reply-to address
				
		}
	
		$mail->SetFrom("notificacao@loretelecom.com.br", PROJETO." Sistemas"); //From address of the mail
		// put your while loop here like below,
		$mail->Subject = $fields['assunto']; //Subject od your mail
	
		$addr = explode(',',$email);
	
		foreach ($addr as $ad) {
				
			$mail->AddAddress( trim($ad) );
				
		}
	
		$mail->MsgHTML($fields['mensagem']); //Put your body of the message you can place html code here
		//$mail->AddAttachment("images/asif18-logo.png"); //Attach a file here if any or comment this line,
		$send = $mail->Send(); //Send the mails
	
		if($send){
			//echo '<center><h3 style="color:#009933;">Mail sent successfully</h3></center>';
		}
		else{
			//echo '<center><h3 style="color:#FF3300;">Mail error: </h3></center>'.$mail->ErrorInfo;
		}
	
		$mail->ClearAddresses();
	
	}
	
	public static function enviarEmail($destinatario,$assunto,$mensagem,$replyto = null){
		
		$email          = $destinatario;
		$mail           = new PHPMailer(); // call the class
		$mail->CharSet  = 'utf-8';
		$mail->IsSMTP();
		$mail->Host     = 'mail.loretelecom.com.br'; //Hostname of the mail server
		$mail->Port     = '587'; //Port of the SMTP like to be 25, 80, 465 or 587
		$mail->SMTPAuth = true; //Whether to use SMTP authentication
		$mail->Username = 'notificacao@loretelecom.com.br'; //Username for SMTP authentication any valid email created in your domain
		$mail->Password = 'colombo1'; //Password for SMTP authentication
	
		if($rep = $replyto){
				
			$rep_n = $replyto;
			$rep_n = explode(',',$rep_n);
				
			foreach ($rep_n as $ad) {
					
				$mail->AddReplyTo(trim($ad)); //reply-to address

			}
				
		}else{
				
			$rep   = "notificacao@loretelecom.com.br";
			$rep_n = "Stalker Sistemas";
				
			$mail->AddReplyTo($rep, $rep_n); //reply-to address
				
		}
	
		$mail->SetFrom("notificacao@loretelecom.com.br", PROJETO." Sistemas"); //From address of the mail
		// put your while loop here like below,
		$mail->Subject = $assunto; //Subject od your mail
	
		$addr = explode(',',$email);
	
		foreach ($addr as $ad) {
				
			$mail->AddAddress( trim($ad) );
				
		}
	
		$mail->MsgHTML($mensagem); //Put your body of the message you can place html code here
		$send = $mail->Send(); //Send the mails
	
		$mail->ClearAddresses();
	
	}
	
	public static function getSelectPermissao($name,$valor){
	
		$valores = array(1=>"RW",2=>"R");
		$options = "<option value=''>NA</option>";
	
		foreach ($valores as $key=>$val){
	
			$select = ($key==$valor)?"selected='selected'":null;
	
			$options .= "<option $select value='$key'>$val</option>";
	
		}
	
		return "<select name='acesso[$name]'>$options</select>";
	
	}
	
	/**
	 * Faz uma busca num array multidimensional
	 *
	 * @access public
	 * @param array $array Array a ser varrido
	 * @return array $results
	 */
	public static function search($array, $key, $value){
	
		$results = array();
	
		if (is_array($array))
		{
			if (isset($array[$key]) && $array[$key] == $value)
				$results[] = $array;
	
			foreach ($array as $subarray)
				$results = array_merge($results, Fw\Vital::search($subarray, $key, $value));
		}
	
		return $results;
	
	}
	
	/**
	 * Monta a URL de
	 * acesso do modo MVC
	 *
	 * @access public
	 * @param string $controller
	 * @param string $action
	 * @return string
	 */
	public static function getUrl($controller,$action = 'index', $param = null){
		
		$url = BASE."index.php/$controller/$action/";
		
		if($param){
			
			$url = $url."?$param";
			
		}
		
		return $url;
		
	}
	
	/**
	 * Monta a URL de
	 * acesso do modo MVC
	 *
	 * @access public
	 * @param string $controller
	 * @param string $action
	 * @return string
	 */
	public static function sair(){
		
		unset($_SESSION[APP_API]);
		
		die("<script>
					
				var base = '".BASE."';
					
				window.location = base+'index.php/Login/index/'+location.hash;
					
				</script>");
		
	}
	
	static function getSemanaBR($data){
	
		$dias =  array(
				'Sun' => 'Domingo',
				'Mon' => 'Segunda-Feira',
				'Tue' => 'Terca-Feira',
				'Wed' => 'Quarta-Feira',
				'Thu' => 'Quinta-Feira',
				'Fri' => 'Sexta-Feira',
				'Sat' => 'S&aacute;bado'
		);
	
		return $dias[$data];
	
	}
	
	
	public static function upload($dados){
	
		$upload_path = "data/uploads";
	
		$name = $dados["name"];
	
		if($name){
	
			$tmp_name = $dados["tmp_name"];
	
			$type = $dados['type'];
	
			$allowed_types=array(
					'image/gif',
					'image/jpeg',
					'image/jpg',
					'image/png',
					'audio/mp3',
					'application/pdf',
					'application/vnd.ms-excel',
					'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
			);
				
			$dphp = strstr($name, ".php");
	
			if(!$dphp){
	
				if (in_array($type, $allowed_types)){
	
					$path  = $upload_path."/".urlencode($name);
					$path2 = $upload_path."/".$name;
	
					unserialize($path);
					move_uploaded_file($tmp_name, $path);
						
					return true;
	
				}
	
			}
	
		}
	
		return false;
	
	}
	
	static function getMesBR($data){
	
		$meses =  array(
				'Jan' => 'Janeiro',
				'Feb' => 'Fevereiro',
				'Mar' => 'Marco',
				'Apr' => 'Abril',
				'May' => 'Maio',
				'Jun' => 'Junho',
				'Jul' => 'Julho',
				'Aug' => 'Agosto',
				'Nov' => 'Novembro',
				'Sep' => 'Setembro',
				'Oct' => 'Outubro',
				'Dec' => 'Dezembro'
		);
	
		return $meses[$data];
	
	}
	
	public static function getPermissoes($db,$usuario,$cache){
	
		/**
		 * Permissões
		 */
	
		$key_permissoes = "permissao_form_{$usuario["id_grupos"]}";
	
		$permissoes = $cache->read($key_permissoes);
	
		if(!$permissoes){
	
			$permissoes = $db->
			select()->
			from("get_permissoes")->
			where("id_usuario={$usuario["id"]}")->
			fetchAll();
	
			$cache->save($key_permissoes, $permissoes);
	
		}
	
		return $permissoes;
	
	}
	
	public static function getElementos($campos,$db,$usuario,$tabela,$cache,$lista=null,$anexo=null,$subform_anexo=null,$id_master=null){
	
		$permissoes      = Fw\Vital::getPermissoes($db, $usuario, $cache);
		$total_elementos = sizeof($campos['elemento']);$total_elementos = ($total_elementos==0)?1:$total_elementos;
	
		for($i=0;$i<$total_elementos;$i++){
	
			$elemento = (array)$campos['elemento'][$i];
				
			$niveis = Fw\Vital::array_procurar($permissoes, "id_formulario", "{$tabela}.{$elemento['@attributes']["nome"]}");
				
			if(!$niveis)continue;
				
			$elemento['@attributes']['privilegio'] = $niveis[0]['privilegio'];
	
			if($elemento['@attributes']["tipo"]=="select"){
	
				$tabela_form  = $elemento['@attributes']["tabela"];
				$campo_tabela = $elemento['@attributes']["campo_tabela"];

				$elemento['@attributes']["lista"] = Fw\Vital::getElementoSelect($tabela_form,$campo_tabela,$db,$cache,$elemento['@attributes']["order"],$elemento['@attributes']["where"],$id_master,$usuario,$lista);
	
			}
				
			if($elemento['@attributes']["tipo"]=="anexo_multiplo"){

				$xml     = new Fw\XML("application/forms/{$elemento['@attributes']["tabela"]}.xml");
	
				$xml_sub = (array)$xml->xml;
	
				foreach($xml_sub['elemento'] as $sub){
						
					$sub = (array)$sub;
						
					$subniveis = Fw\Vital::array_procurar($permissoes, "id_formulario", "{$elemento['@attributes']["tabela"]}.{$sub['@attributes']["nome"]}");
						
					if($sub["@attributes"]["sublista"]!="true")continue;
					if(!$subniveis)continue;
						
					$sub['@attributes']['privilegio'] = $subniveis[0]['privilegio'];
						
					$tabela_form  = $sub['@attributes']["tabela"];
					$campo_tabela = $sub['@attributes']["campo_tabela"];
	
					if($sub['@attributes']["tipo"]=="select"){
	
						$where = null;
	
						if($sub['@attributes']["nome"]=="id_cidades"){
								
							// XAXO!!!!
							$subform_anexo = 'enderecos';
								
							$elemento['@attributes']['rel'] = $elemento['@attributes']['rel']?$elemento['@attributes']['rel']:0;
							
							$id_estado = $anexo[$subform_anexo.'_id_estados'][$elemento['@attributes']['rel']];
							$where     = $id_estado?"id_estados=$id_estado":null;
								
						}
						
						$sub['@attributes']["lista"] = Fw\Vital::getElementoSelect($tabela_form,$campo_tabela,$db,$cache,null,$where,$usuario,$lista);
					}
						
					if($elemento['@attributes']["par"]=="anexo"){
							
						$sub["@attributes"]["nome"] = $elemento['@attributes']["tabela"]."_".$sub["@attributes"]["nome"]."[]";
	
					}
						
					$elementos["sublista"][$elemento['@attributes']["nome"]][] = $sub;
						
				}
	
			}
	
			if($elemento["@attributes"]["sublista"]=="true")continue;
				
			$elementos['principal'][] = $elemento;
	
		}
	
		return $elementos;
	
	}
	
	public static function getElementoSelect($tabela_form,$campo_tabela,$db,$cache,$order=null,$where=null,$id_master=null,$usuario=null,$lista=null){
	
		$key          = "select_{$tabela_form}";
		//$cache_lista  = $cache->read($key);
	
		if($cache_lista){
	
			$lista = $cache_lista;
	
		}else{
				
			if($tabela_form=='get_operacoes_contratos'){
	
				$x = $db->select("id_operacoes")->from("orcamentos")->find("id=$id_master");
	
				$where = "id_operacoes={$x['id_operacoes']}";
	
			}
			
			if($tabela_form=='status_obras' && $lista['id_orcamentos']){
				
				$x = $db->
						select("id_operacoes")->
						from("orcamentos")->
						find("id={$lista['id_orcamentos']}");
	
				$where_or = "id_operacoes={$x['id_operacoes']} OR id_operacoes IS NULL";
					
			}
	
			if($tabela_form=='tabelas'){
	
				$schema  = db;
				$tabelas = $db->parseSql("SHOW TABLES");
	
				foreach($tabelas as $t){
						
					if(strstr($t["Tables_in_$schema"],'get_'))continue;
						
					$lista[] = array('id'=>$t["Tables_in_$schema"],"nome"=>$t["Tables_in_$schema"]);
						
				}
	
			}else{
	
				if($usuario['id_une'] != "8" && $tabela_form == 'get_operacoes'){
						
					if($where){
	
						$where .= " AND ";
	
					}
						
					if($usuario['une_auxiliar']){
							
						$where .= "id_une IN({$usuario['id_une']},{$usuario['une_auxiliar']})";
							
					}else{
							
						$where .= "id_une='{$usuario['id_une']}'";
							
					}
						
				}
				
				$where = $where_or&&$where?$where." AND $where_or":$where;
				$where = $where_or&&!$where?$where_or:null;
				
				$lista = $db->
							select("id,$campo_tabela")->
							from($tabela_form)->
							order($order)->
							where($where)->
							fetchAll();
	
			}
	
		}
	
		return $lista;
	
	}
	
	/**
	 * Quebra a URL
	 * em array para separar
	 * o Controller do Action
	 *
	 * @access public
	 * @return array|false
	 */
	public static function getUrlParams(){
		
		$get_url = explode('/', $_SERVER['REQUEST_URI']);
		
		if(!$get_url[RANGE]){
			
			return array(
					"controller"      => "stalker\application\controllers\Login",
					"controller_name" => 'Login',
					"action"          => 'indexAction',
					"action_name"     => 'index');
			
		}
		
		$get_url[RANGE+1] = str_replace("?", "", $get_url[RANGE+1]);
		$action           = $get_url[RANGE+1]?$get_url[RANGE+1]."Action":"indexAction";
		
		return array(
					"controller"      => 'stalker\application\controllers\\'.$get_url[RANGE],
					"controller_name" => $get_url[RANGE],
					"action"          => $action,
					"action_name"     => str_replace("Action", "", $action)
		);
	
	}
	
	/**
	 * Retorna a sessao
	 * do usuario logado em
	 * um array.
	 *
	 * @access public
	 * @param bool $pass
	 * @return array|void
	 */
	public static function getUser($pass = false, $controller = false){
		
		$ses = $_SESSION['geral'];
		
		if($pass&&!$ses){
			
			return 0;
			
		}
		
		if(!$ses){
			
			if($controller){
				
				$controller->setNoRender();
				
			}
			
			die("<script>window.location = '".BASE."index.php/Login/index/'+location.hash;</script>");
			
		}
		
		return $ses;
		
	}
	
	public static function array_procurar($array, $key, $value){
	
		$results = array();
	
		if (is_array($array)){
	
			if (isset($array[$key]) && $array[$key] == $value)
				$results[] = $array;
	
			foreach ($array as $subarray)
				$results = array_merge($results, Fw\Vital::array_procurar($subarray, $key, $value));
		}
	
		return $results;
	}
	
	static function loc($controller,$action = 'index',$var = null){
		
		$var = $var?"?$var":null;
		
		$url = Vital::getUrl($controller,$action).$var;
	
		header("Location: $url");
	
		die;
	
	}
	
}

?>