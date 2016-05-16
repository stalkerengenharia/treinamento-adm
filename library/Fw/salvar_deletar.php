<?php 

namespace stalker\library\Fw;

/**
 * Pagina para salvar informações
 * 
 */
?>

<?php 

/**
 * Conexão com o BD
 *
 */
require_once '../config.php';

$db     = new Fw\DB();
$dados  = $_POST;
$tabela = $dados['tabela'];


/**
 * Inserir dados salvos no BD
 *
 */
if($dados['data']){
	
	$dados['data'] = Data::getDataEN($dados['data']);
	
}

/**
 * Excluir dados antigos após atualização dos mesmos.
 *
 */
unset($dados['tabela']);

$id     = $db->salvar($dados, $tabela);

echo $id;

?>
