<?php
/**
 * 
 * conexão com o BD
 * inserido informações
 * para conexão
 * local do BD
 * 
 */


session_start();

/**
 * Range
 * 
 * @name RANGE
 * @package APP
 * @subpackage configs
 */
define("RANGE", "3");

/**
 * nome do projeto 
 * a ser utilizado
 * 
 * @name PROJETO MIB
 * @package APP
 * @subpackage configs
 */
define("PROJETO", "Treinamento Stalker");

/**
 * link para acesso a pasta
 * que gerará o servidor
 *
 * @name BASE
 * @package APP
 * @subpackage configs
 */
define("BASE", "http://127.0.0.1/treinamento-adm/");

/**
 * Gerar servidor da pasta inserida
 *
 * @name PATH
 * @package APP
 * @subpackage configs
 */
define("PATH", $_SERVER['DOCUMENT_ROOT']."/treinamento-adm/");

/**
 * nomenclatura do site gerado
 *
 * @name APP_API
 * @var mib-app-adm
 * @package APP
 * @subpackage configs
 */
define("APP_API", "mib-app-adm");
?>
