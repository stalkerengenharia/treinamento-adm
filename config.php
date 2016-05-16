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
 * IP do banco de dados
 * 
 * @name Servidor
 * @package APP
 * @subpackage mib-app-adm
 */
define("host", "127.0.0.1");

/**
 * Login do usuario da maquina
 * que fará o root.
 * 
 * @name usuario
 * @package APP
 * @subpackage mib-app-adm
 */
define("usuario", "root");

/**
 * Senha para acessa ao
 * banco de dados
 * @name senha
 * @package APP
 * @subpackage mib-app-adm
 */
define("senha", "12rafael34");

/**
 * Nome do banco de dados
 * que irá acessar esse
 * projeto.
 * 
 * @name DB
 * @package APP
 * @subpackage mib-app-adm
 */
define("db", "survey");

/**
 * Alcance de acesso
 * @package APP
 * @subpackage mib-app-adm
 */
define("RANGE", "3");

/**
 * Nome do Projeto
 * 
 * @name PROJETO
 * @package APP
 * @subpackage mib-app-adm
 */
define("PROJETO", "Engeclick");

/**
 * Link da pasta que gerará o servidor
 * necessário
 * 
 * @name mib-app-adm
 * @package APP
 * @subpackage mib-app-adm
 */
define("BASE", "http://127.0.0.1/mib-app-adm/");

/**
 * Pasta que gerará o servidor
 * necessário
 * 
 * @name PATH
 * @package APP
 * @subpackage mib-app-adm
 */
define("PATH", $_SERVER['DOCUMENT_ROOT']."/mib-app-adm/");

?>
