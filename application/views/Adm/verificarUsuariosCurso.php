<div data-role="header" data-theme="b" data-position="fixed" data-tap-toggle="false">

    <a href="<?php echo stalker\library\Fw\Vital::getUrl('Lista','index',"tabela=cursos_enviados"); ?>"
    data-transition="slide" data-direction="reverse" data-ajax='false'
    class="ui-btn-left ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-back">Voltar</a>

    <h1>Treinamento</h1>

</div>


<div class='ui-content'>

    <div data-filter="true" data-input="#filterControlgroup-input">

        <h2>Colaboradores que <u>não</u> visualizaram o Curso</h2>

        <table data-role="table" id="table-column-toggle"  data-filter="true" data-filter-placeholder="Pesquisar..."
        data-mode="none" class="ui-responsive table-stroke">
            
            <thead>
                
                <tr>

                    <th>Nome</th>
                    <th data-priority="1">Email</th>
                    <th data-priority="2"></th>

                </tr>
            
            </thead>
            
            <tbody>

                <?php foreach($this->view->usuarios as $u): ?>

                <tr>
                    
                    <td><?php echo $u['nome']; ?></td>
                    <td><?php echo $u['email']; ?></td>
                    <td style="padding: 0;vertical-align: middle">

                        <a href="<?php echo stalker\library\Fw\Vital::getUrl('Adm',"enviarCurso","id_usuario={$u['id_usuarios']}&id_topico={$u['id_topico']}&email={$u['email']}"); ?>"
                        data-transition="slide" style='background-color: #8cc63f;margin: 0;'
                        class="ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-mail">Reenviar</a>
                    
                    </td>
                
                </tr>

                <?php endforeach; ?>

            </tbody>
            
        </table>

    </div>
	
</div>