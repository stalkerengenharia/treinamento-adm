<?php

namespace stalker\application\models;

use stalker\library\Fw as Fw;

/**
 * Validar e-mail e senha do Usuario.
 * 
 * @author rafael
 * @package APP
 * @subpackage models
 */
class Administradores{
	
    /** 
     * Validar dados do usuario.
     * 
     * @param String $email
     * @param String $senha
     * @return Array
     */
    static function validar($email, $senha){

        /**
         * Conecta ao BD.
         * 
         * @var Fw\DB
         */
        $db         = new Fw\DB();

        /**
         * Puxa informação
         * de email e senha
         * do banco de dados.
         *
         * @var Array Exemplo: array("nome" => "rafael", "sobrenome" => "henrique");
         */
        $usuario_db = $db->
                        select()->
                        from("administradores")->
                        find("email='$email' AND senha='$senha'");
        /**
         * retorna validacao do cliente.
         */
        return $usuario_db;

    }
	
}