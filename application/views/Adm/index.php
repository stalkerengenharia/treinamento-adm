<div data-role="header" data-theme="b" data-position="fixed">

    <h1>Treinamentos</h1>

    <a href="<?php echo stalker\library\Fw\Vital::getUrl('Login','logoff'); ?>" data-transition="pop" data-ajax='false'
    class="ui-btn-right ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-delete">Sair</a>
	
</div>

<div class='ui-content'>

    <div data-filter="true" data-input="#filterControlgroup-input">

        <div class="ui-grid-a">

            <div class="ui-block-a">

                <a href="<?php echo stalker\library\Fw\Vital::getUrl('Lista','index',"tabela=topico"); ?>"
                data-transition="slide" data-ajax='false'
                class="ui-btn ui-shadow ui-corner-all ui-icon-bars ui-btn-icon-top ui-btn-a buto">	

                    Cursos   

                </a>

            </div>

            <div class="ui-block-b">  

                <a href="<?php echo stalker\library\Fw\Vital::getUrl("Lista",'index',"tabela=perguntas"); ?>"
                data-transition="slide" data-ajax='false'
                class="ui-btn ui-shadow ui-corner-all ui-icon-bars ui-btn-icon-top ui-btn-a buto">

                    Apresentações

                </a>

            </div>

            <div class="ui-block-b">

                <a href="<?php echo stalker\library\Fw\Vital::getUrl("Lista",'index',"tabela=cursos_enviados"); ?>"
                data-transition="slide" data-ajax='false'
                class="ui-btn ui-shadow ui-corner-all ui-icon-gear ui-btn-icon-top ui-btn-a buto">

                    Cursos Enviados

                </a>

            </div>

            <div class="ui-block-b">

                <a href="<?php echo stalker\library\Fw\Vital::getUrl("Lista",'index',"tabela=cliente"); ?>"
                data-transition="slide" data-ajax='false'
                class="ui-btn ui-shadow ui-corner-all ui-icon-grid ui-btn-icon-top ui-btn-a buto">

                    Quem Fez

                </a>

            </div>

        </div>

    </div>
	
</div>