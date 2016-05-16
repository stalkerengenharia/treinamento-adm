<?php 

namespace stalker\application\controllers;

use stalker\library\Fw as Fw;
use stalker\application\models as models;

/**
 * Da acesso página ADM
 * 
 * @author Rafael Henrique <rsilva.ext@stalkerengenharia.com.br>
 * @package APP
 * @subpackage Controller
 */
class Adm extends Fw\Controller{

    /**
     * Pagina inicial.
     */
    function indexAction(){
        
        /**
         * Busca da sessao geral
         * se o usuario está acesso liberado.
         */
        Fw\Vital::getUser(); 

    }

    /**
     * Envia curso "avulso".
     */
    function enviarCursoAction(){
        
        /**
         * Mensagem em HTML que vai
         * para o colaborador.
         * 
         * @var String Email HTML
         */
        $mensagem = models\Cliente::getEmailMsg($_GET['id_topico'], $_GET['id_usuario']);

        /**
         * Envia o email para o colaborador.
         */
        Fw\Vital::enviarEmail($_GET['email'], "Novo treinamento de Stalker Engenharia", $mensagem);

    }

    /**
     * Retorna todos os usuarios
     * que receberam o email do curso
     * mas nao abriram o link.
     */
    function verificarUsuariosCursoAction(){

        /**
         * Conecta ao BD.
         * 
         * @var 
         */
        $db       = new Fw\DB;

        /**
         * Lista dos usuarios que nao
         * fizeram o curso.
         * 
         * @var Array
         */
        $usuarios = $db->
                    select()->
                    from("get_falta_curso")->
                    where("id={$_GET['id']}")->
                    fetchAll();

        /**
         * Conversa com a view.
         * 
         * @var Array
         */
        $this->view->usuarios = $usuarios;

    }

}
?>