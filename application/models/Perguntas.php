<?php

namespace stalker\application\models;

/**
 * Solicita a liberação do acesso
 * da pasta Fw.
 */
use stalker\library\Fw as Fw;

/**
 * Lista todas as perguntas e seus respectivos
 * topicos
 *
 * @author rafael
 * @package APP
 * @subpackage models
 */
class Perguntas{
	
    /**
     * Busca do banco de dados todas as perguntas
     * Listar pergunas.
     * 
     * @param String $id_pagina
     */
    function ListarPerguntas($id_pagina){

        /**
         * Para a lista id_paginas será inseridas as 
         * informacoes nome da pergunta eo nome do topico.
         *
         * @var Fw\DB
         */
        $db = new Fw\DB();

        /**
         * Cria lista com as informações
         * do banco de dados com as devidas
         * informações inseridas na tabela perguntas.
         */
        if($id_pagina == 'perguntas'){

            /**
             * Apresenta o nome da pergunta.
             * 
             * @var Array
             */
            $nome[] = array("Nome"=>'nome');

            /**
             * Apresenta o nome do topico.
             *
             * @var Array
             */
            $nome[] = array("Topico"=>'nome_topico');

            /**
             * Ordena a lista nome perguntas e nome topicos
             * de acordo com ordem alfabetica do nome_topico.
             *
             * @var String
             */
            $order  = "nome_topico";

            /**
             * Insere informacoes do banco de dados
             * na lista $id_pagina.
             *
             * @var String
             */
            $from   = "get_$id_pagina";

        }
    }
}