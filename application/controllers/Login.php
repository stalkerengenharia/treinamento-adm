<?php

namespace stalker\application\controllers;

use stalker\library\Fw as Fw;
use stalker\application\models as models;

/**
 * Pagina de login do usuario onde confirmara se tem ou não seu cadastro no BD.
 * 
 * @author Rafael Henrique <rsilva.ext@stalkerengenharia.com.br>
 * @package APP
 * @subpackage Controllers
 */
class Login extends Fw\Controller{
	
    /**
     * Ao selecionar o botão logoff
     * irá redirecionar a pagina inicial.
     */
    function logoffAction(){

        /**
         * Tira acesso ao usuario
         * quando deslogar necessario
         * informar registros novamente.
         */
        $this->setNoRender();

        /**
         * Caso sessão adm ou geral seja encerrada
         * o usuario é direcionado para página login.
         */
        $_SESSION['Adm']   = null;
        $_SESSION['geral'] = null;

        /**
         * Direciona para login.
         */
        header("Location: " . Fw\Vital::getUrl("Login"));

    }

    /**
     * Irá inserir o e-mail e senha caso 
     * inseridos corretamente seŕa redirecionado
     * para pagina ADM.
     */
    function indexAction(){

        /**
         * Conecta a tabela Administradores.
         * 
         * @var models\Administradores
         */
        $Usuarios   = new models\Administradores();

        /**
         * Informações de email.
         * 
         * @var String
         */
        $email      = $_POST["email"];

        /**
         * Informações de email.
         *
         * @var String
         */
        $senha      = $_POST["senha"];

        /**
         * Verifica se o usuario
         * existe.
         * 
         * @var Array
         */
        $usuario_db = $Usuarios->validar($email, $senha);

        /**
         * Se usuario existir,
         * cria variavel de sessao com
         * as informacoes do usuario logado.
         * SENAO, joga o usuario para a
         * tela de login novamente.
         */
        if($usuario_db){
            
            /**
             * Direciona usuario para
             * aba 'geral'.
             * 
             * @var Array $usuario_db
             */
            $_SESSION['geral'] = $usuario_db;

            /**
             * Direciona para página ADM.
             */
            header("Location: " . Fw\Vital::getUrl("Adm"));

            exit;

        /**
         * Caso senha invalida , retorna a página inicial.
         */
        }elseif($_POST){

            /**
             * Informa erro de login para a view.
             * 
             * @var Bool
             */
            $this->view->erro = 1;

        }

    }
	
}

?>