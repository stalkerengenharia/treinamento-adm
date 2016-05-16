<?php

namespace stalker\application\controllers;

use stalker\library\Fw as Fw;

/**
 * Inserimento das novas informações ou alterações no BD.
 * 
 * @author Rafael Henrique <rsilva.ext@stalkerengenharia.com.br>
 * @package APP
 * @subpackage Controllers
 */
class Lista extends Fw\Controller{
	
    /**
     * Lista informações no BD de acordo com página 
     * selecionada.
     */
    function indexAction(){

        /**
         * Solicitação do banco de dados.
         * 
         * @var Fw\DB
         */
        $db = new Fw\DB();

        /**
         * Cria caminho para direcionar
         * usuario para as devidas paginas
         * que selecionar.
         * 
         * @var String
         */
        $id_pagina = $_GET['tabela'];

        /**
         * Para cada pagina agrupada
         * a pagina lista será inserido
         * e informado diferentes informacoes.
         * 
         * @var String
         */
        $from      = $id_pagina;

        /**
         * Para caso $id_pagina seje
         * igual as determinadas regras
         * será inserido dados na lista
         * da tabelo do mesmo.
         */
        if($id_pagina == 'empresas'){

            /**
             * Busca dado do BD e insere na lista.
             *  
             * @var Array
             */
            $nome[] = array("Nome"=>'nome');

            /**
             * Ordena a lista se baseando na lista
             * "nome".
             * 
             * @var String
             */
            $order  = "nome";

        }

        /**
         * Cria lista com as informações 
         * do banco de dados com as devidas 
         * informações inseridas na tabela usuarios.
         * 
         */
        /*if($id_pagina == 'usuarios'){

            $nome[] = array("E-mail"=>'email');
            $nome[] = array("Nome"=>'nome');

            $order  = "nome";
            $from   = $id_pagina;

        }*/
        if($id_pagina == 'cursos_enviados'){

            $nome[] = array("Quem enviou?"=>'nome_usuario');
            $nome[] = array("Curso"=>'nome');
            $nome[] = array("Data Enviado"=>'data_br');
            $nome[] = array("Falta fazer"=>'saldo');

            $order  = "id";
            $from   = 'get_cursos_enviados';

            $this->view->nao_alterar = true;
            $this->view->nao_excluir = true;

        }
        /**
         * cria lista com as informações
         * do banco de dados com as devidas
         * informações inseridas na tabela cliente
         *
         */		
        if($id_pagina == 'cliente'){

            $nome[] = array("Nome"=>'nome');
            $nome[] = array("Curso"=>'topico');
            $nome[] = array("Comprovante"=>'arquivo');
            $nome[] = array("Data"=>'data_br');

            $order  = "nome";
            $from   = "get_$id_pagina";

            $this->view->nao_alterar = true;
            $this->view->nao_excluir = true;
        }

        /**
         * cria lista com as informações
         * do banco de dados com as devidas
         * informações inseridas na tabela topico
         *
         */
        if($id_pagina == 'topico'){

            $nome[] = array("Curso"=>'nome');

            $order  = "nome";
            $from   = "get_$id_pagina";

            $this->view->nao_excluir = true;
            $this->view->nao_alterar = true;
            
        }

        /**
         * cria lista com as informações
         * do banco de dados com as devidas
         * informações inseridas na tabela perguntas
         *
         */
        if($id_pagina == 'perguntas'){

            $nome[] = array("Tópico"=>'nome_topico');
            $nome[] = array("Nome"=>'nome');

            $order  = "nome_topico";
            $from   = "get_$id_pagina";

            $this->view->nao_excluir = true;
            $this->view->nao_alterar = true;

        }

        /**
         * Paginacao
         * ordena dados buscados do BD
         * em ordem decrescente.
         * 
         * @var Integer
         */
        $itens_pagina      = 500;

        /**
         * Pagina_atual é igual ao $val_pagina caso
         * o valor de val_pagina seja 0.
         *  
         * @var Integer
         */
        $pagina_atual      = $val_pagina ? $val_pagina : 0;

        /**
         * pagina_atual é igual a pagina_atual * variável $itens_pagina;
         * 
         * @var Integer
         */
        $pagina_atual      = $pagina_atual ? $pagina_atual * $itens_pagina : 0;

        /**
         * $order ordena de forma decrescente.
         * 
         * @var String
         */
        $order             = $order ? $order : "id DESC";

        /**
         * Nome do registro.
         * 
         * @var Array
         */
        $this->view->nome  = $nome;

        /**
         * Busca informações do BD
         * sendo colocados em ordem 
         * Cada dado selecionado.
         * 
         * @var Array
         */
        $this->view->lista = $db->
                            select()->
                            from($from)->
                            where($where)->
                            order($order)->
                            limit("$pagina_atual , $itens_pagina")->
                            fetchAll();

        /**
         * Soma o total da pontuação 
         * da tabela avaliação.
         * 
         * @var Array
         */
        $total             = $db->
                            select('count(id) as "total"')->
                            from($from)->
                            fetchAll();

        /**
         * Informa o total da soma dos registros
         * na tabela avaliacao
         * 
         * @var Integer
         */
        $total        = $total[0]['total'];

        /**
         * Informa o total de paginas.
         * 
         * @var Integer
         * 
         */
        $total_paginas = ceil($total/$itens_pagina);

    }
	
}

?>