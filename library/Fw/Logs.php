<?php 

namespace stalker\library\Fw;

class Logs{
	
	static function getRelatorio($dados){
		
		$db    = new Fw_DB();
		$cache = new Fw_Cache();
			
		$usuarios = $db->
						select()->
						from('usuarios')->
						fetchAll();
			
		foreach($usuarios as $us){
		
			$key = "logs_".$us['id'];
		
			$log = $cache->read($key);
			
			foreach($log as $l){
				
				if(!$l['dados'])continue;
				
				$data = strtotime(date("Y-m-d",strtotime($l['data_ultima_acao'])));
				$data_inicial = strtotime(Data::getDataEN($_POST['data_inicial']));
				$data_final = strtotime(Data::getDataEN($_POST['data_final']));
				
				$l['nome_usuario'] = $us['nome'];
					
				if(
				(($l['id_usuarios'] == $_POST['usuario'] || !$_POST['usuario']) &&
				($l['tabela'] == $_POST['tabelas'] || !$_POST['tabelas']) &&
				($l['id_registro'] == $_POST['id'] || !$_POST['id']) &&
				(($data_inicial <= $data && $data_final >= $data) || (!$data_inicial && !$data_final))					
				)
						&& $l['id_registro']
						){
		
					$fi[] = $l;
		
				}
				
				if(!$_POST['usuario']&&!$_POST['tabelas']&&!$_POST['id']&&!$_POST['data_inicial']&&!$_POST['data_final']){
		
					$fi[] = $l;
		
				}
					
			}
		
		}
		
		usort($fi, function($a1, $a2) {
		
			$v1 = strtotime($a1['data_ultima_acao']);
			$v2 = strtotime($a2['data_ultima_acao']);
		
			return ($v1 < $v2) ? -1 : 1;
		
		});
		
		foreach($fi as $n){

			$n['dados']['id'] = $n['dados']['id']?$n['dados']['id']:$n['id_registro'];
			
			$dada = $n['dados'];
				
			if($dados_antigo[$n['id_registro']][$n['tabela']]){
				
				$arr1 = $dados_antigo[$n['id_registro']][$n['tabela']];
				$arr2 = $n['dados'];
				
			    $arr_final = array_diff_assoc($arr2, $arr1);
				
				$n['dados'] = $arr_final;
				
			}
							
			$dados_antigo[$n['id_registro']][$n['tabela']] = (array)$dada;
			
			if($n['dados']){
			
				$n['dados'] = print_r($n['dados'],true);
				$n['dados'] = str_replace('Array','',$n['dados']);
			
				$final[] = $n;
			
			}
					
		}
		
		usort($final, function($a1, $a2) {
		
			$v1 = strtotime($a1['data_ultima_acao']);
			$v2 = strtotime($a2['data_ultima_acao']);
		
			return ($v1 > $v2) ? -1 : 1;
		
		});
		
		return $final;
		
	}
	
	static function form($dados,$acao){
		
		$cache     = new Cache('../cache/logs');
		$key       = "form_{$dados['tabela']}";
		$formAtual = $cache->read($key);
		
		if($acao=='abrir'){
			
			if(!$dados['id']){
				return false;
			}
			
			
			$formAtual[] = array('id_usuarios'=>$dados['id_usuarios'],'nome_usuarios'=>$dados['nome_usuarios'],'data'=>date('Y-m-d H:i:00'));
						
			$cache->save($key, $formAtual);
			
		}elseif($acao=="fechar"){
			
			foreach($formAtual as $frm){
				
				$hora       = strtotime($frm['data']);
				$hora_atual = strtotime(date('Y-m-d H:i:00'));
				
				$minutos = round(abs($hora_atual-$hora) / 60,2);
				
				
				if($minutos>20){
					
					continue;
					
				}
				
				if($frm['id_usuarios']==$dados['id_usuarios']){
					
					continue;
					
				}
				
				$form[] = $frm;
				
			}
			
			$cache->save($key, $form);
			
		}elseif("get"){
			
			foreach($formAtual as $frm){
				
				if($frm['id_usuarios']==$dados['id_usuarios']){
					
					continue;
				
				}
				
				echo "<div class='user_form' title='{$frm['nome_usuarios']}' rel='{$frm['id_usuarios']}'>{$frm['nome_usuarios']}</div>";
				
			}
			
		}
		
	}
	
	static function save($dados){
		
		$cache   = new Fw_Cache('../logs');
		
		$usuario = Fw\Vital::getUser();
		$key     = "logs_".$usuario['id'];
		
		unset($_POST['auto']);
		
		if($_POST['id']){
			
			if(!$dados['acao'])
				$dados['acao'] = "editar";
			
		}else{
			
			$dados['acao'] = "adicionar";
			
		}
		
		$dados['data_ultima_acao'] = date("Y-m-d H:i:s");

		$dd = array('acao'             => $dados['acao'],
					'tabela'           => $dados['tabela'],
					'id_usuarios'      => $usuario['id'],
					'id_registro'      => $dados['id'],
					'data_ultima_acao' => $dados['data_ultima_acao'],
					'dados'            => $_POST);

		$logs2  = $cache->read($key);
		$logs2 = !$logs2?array():$logs2;
		$logs[sizeof($logs2)] = $dd;
		
		$arr = $logs+$logs2;
		
		if($dados['acao']){
		
			$cache->save($key, $arr);
		
		}
		
	}
}

?>
