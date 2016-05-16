<?php

namespace stalker\application\controllers;

use stalker\library\Fw as Fw;
use stalker\application\models as models;

/**
 * Local onde será inserios as 
 * formulas para o sistema CRUD.
 * 
 * @author Rafael Henrique <rsilva.ext@stalkerengenharia.com.br>
 * @package APP
 * @subpackage Controllers
 */
class Form extends Fw\Controller{
	
    /**
     * Salva no BD.
     */
    function salvarAction(){

        /**
         * Render é um script baseado na especificações de variaveis.
         */
        $this->setNoRender();

        /**
         * Conecta ao BD.
         * 
         * @var Fw\DB
         */
        $db            = new Fw\DB();

        /**
         * ID do registro a ser salvo.
         * 
         * @var Integer
         */
        $id            = $_POST['id'];

        /**
         * Usuario logado.
         * 
         * @var Array
         */
        $usuario_atual = Fw\Vital::getUser();

        /**
         * Tabela a ser salva.
         * 
         * @var String
         */
        $tabela        = $_POST['tabela'];

        /**
         * Se for cursos_enviados.
         */
        if($tabela == "cursos_enviados"){

            /**
             * Salva os participantes.
             * 
             * @var String
             */
            $participa = $_POST['participa'];

            /**
             * Tira do post para nao forcar
             * que salve na tabela.
             */
            unset($_POST['participa']);

            /**
             * Data atual.
             * 
             * @var DateTime
             */
            $_POST['data']        = date("Y-m-d H:i:00");
            
            /**
             * ID do usuario logado.
             * 
             * @var Integer
             */
            $_POST['id_usuarios'] = $usuario_atual['id'];

        }

        /**
         * Deleta antigas informações da 'tabela' para salvar novas.
         */
        unset($_POST['tabela']);

        /**
         * Deleta antigas informações do 'id' para salvar novas.
         */
        unset($_POST['id']);

        /**
         * Atualiza registro.
         */
        if($id){

            /**
             * Salva as alteracoes no BD.
             */
            $db->atualizar($_POST, $tabela, "id=$id");

        /**
         * Salva novo registro.
         */
        }else{

            /**
             * Persiste no BD.
             */
            $id = $db->salvar($_POST, $tabela);		

        }

        /**
         * Depois de salvo e gerado um ID.
         */
        if($tabela == 'cursos_enviados'){

            /**
             * Pega o curso para selecionar
             * o nome.
             * 
             * @var Array
             */
            $curso = $db->
                        select("nome")->
                        from("topico")->
                        find($_POST['id_topico']);

            /**
             * Varre a lista de participantes
             * do curso.
             */
            foreach($participa as $email => $id_usuario){

                /**
                 * Salva os usuarios aos quais
                 * o email do curso foi enviado.
                 */
                $db->salvar(array("id_usuarios" => $id_usuario, "id_cursos_enviados" => $id), 'cursos_enviados_usuarios');

                /**
                 * Mensagem em HTML que vai para
                 * os colaboradores avisando
                 * sobre o curso.
                 * 
                 * @var String HTML
                 */
                $mensagem = models\Cliente::getEmailMsg($_POST['id_topico'], $id_usuario);

                /**
                 * Envia o email de fato.
                 */
                Fw\Vital::enviarEmail($email, "Curso de {$curso['nome']}", $mensagem);

            }

        }

        /**
         * Após o click no botão 'salvar' é salvo no banco de dados
         * informando sucesso após a conclusão.
         */
        Fw\Vital::loc("Form","index","tabela=$tabela&id=$id&salvo=1");
    }

    /**
     * Cria os dados para o formulario.
     */
    function indexAction(){

        /**
         * Conecta ao BD.
         * 
         * @var Fw\DB
         */
        $db      = new Fw\DB();

        /**
         * Seleciona dados do BD
         * para inserir dados ou atualizar.
         * 
         * @var String
         */
        $tabela  = $_GET['tabela'];

        /**
         * ID do registro no banco de dados.
         * 
         * @var Integer
         */
        $id      = $_GET['id'];

        /**
         * Dados do usuario logado.
         * 
         * @var Array
         */
        $usuario = Fw\Vital::getUser();

        /**
         * Caso selecionado id
         * buscar informações do banco de dados.
         */
        if($id){

            /**
             * SELECT banco de dados.
             * 
             * @var Array
             */
            $this->view->data = $db->
                                select()->
                                from($tabela)->
                                find("id=$id");
        }

        /**
         * Caso selecionado pagina perguntas 
         * buscar informações do banco de dados.
         */
        if($tabela == "perguntas"){

            /**
             * SELECT banco de dados "Perguntas".
             */
            $this->view->topico = $db->
                                    select()->
                                    from("topico")->
                                    fetchAll();

        }

        if($tabela == "cursos_enviados"){

            /**
             * Se UNE for CTA, junta tbm os usuarios da HOLDING.
             * 
             * @var Integer|String
             */
            $usuario['id_une']    = $usuario['id_une'] == 1 ? "1 OR id_une = 8" : $usuario['id_une'];

            /**
             * SELECT banco de dados "Perguntas".
             * 
             * @var Array
             */
            $this->view->topico   = $db->
                                    select()->
                                    from("topico")->
                                    fetchAll();

            /**
             * Lista de usuarios.
             * 
             * @var Array
             */
            $this->view->usuarios = $db->
                                    select()->
                                    from("usuarios")->
                                    where("id_une = {$usuario['id_une']} AND data_demissao IS NULL")->
                                    fetchAll();

            /**
             * Lista de grupos.
             * 
             * @var Array
             */
            $this->view->grupos   = $db->
                                    select()->
                                    from("grupos")->
                                    order("nome")->
                                    fetchAll();

        }
        /**
         * Caso selecionado pagina cliente
         * buscar informações do banco de dados.
         */
        if($tabela == "cliente"){

            /**
             * SELECT banco de dados "Cliente".
             */
           /* $this->view->grupos = $db->
                                    select()->
                                    from("grupos")->
                                    fetchAll();*/

        }

        /**
         * Caso selecionado pagina topico
         * buscar informações do banco de dados.
         */
        /*if($tabela == "topico"){

                $this->view->topico    = $db->
                                                        select()->
                                                        from("topico")->
                                                        fetchAll();

                $this->view->perguntas = $db->
                                                        select()->
                                                        from("perguntas")->
                                                        fetchAll();

        }*/

        /**
         * Direciona informações para a página
         * de cada link.
         */
        $this->setAppPath("forms/" . $tabela);

    }

    /**
     * Comando para deletar dados do BD.
     */
    function deleteAction(){

        /**
         * Solicitação banco de dados.
         * 
         * @var Fw\DB
         */
        $db     = new Fw\DB();

        /**
         * identifica id a ser deletado.
         * 
         * @var Integer
         */
        $id     = $_POST['id'];

        /**
         * Identifica tabela a ser deletado.
         * 
         * @var String
         */
        $tabela = $_GET['tabela'];

        /**
         * Apaga registros do banco de dados.
         */
        $db->apagar($tabela, "id=$id");

    }
	
}