<?php

namespace stalker\application\models;

use stalker\library\Fw as Fw;

/**
 * Models Cliente
 * Salva Ip do cliente
 * 
 * @author rafael
 * @package APP
 * @subpackage models
 */
class Cliente{
    
    /**
     * Cria o HTML do email
     * sobre o curso.
     * 
     * @param Integer $topico
     * @param Integer $id_usuario
     * @return String
     */
    static function getEmailMsg($topico, $id_usuario){
        
        /**
         * HTML do email.
         */
        return "<h2>Novo Curso de Stalker Engenharia</h2>Você recebeu um novo curso para participar. Clique no link a seguir para fazer o curso.<br /> "
                . "<a href='http://www.w2host.com.br/dev/treinamento/index.php/Perguntas/index/?id_topicos={$topico}&id_usuarios={$id_usuario}'>Abrir Curso</a>";
        
    }
	
    /**
     *  salvar IP
     *  
     * @param String $id_usuario
     */
    function salvarIP($id_usuario){

        /**
         * Solicita acesso DB.
         * 
         * @var Fw\DB
         */
        $db = new Fw\DB();

        /**
         * Salva ip do usuario.
         */
        $db->atualizar(array("ip" => getenv('REMOTE_ADDR')), 'cliente', "id=$id_usuario");

    }
	
}