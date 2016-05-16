<script>

var obj_excluir = null;

function atualizarValor(obj){

    var id    = $(obj).attr("data-id-bd");
    var valor = $(obj).val();

    $.post("php/atualizarvalor.php", {id: id, valor: valor}, function(){

        alert('Salvo.');

    });

}

function excluir(){

    var id = $(obj_excluir).attr("rel");

    $.post("<?php echo stalker\library\Fw\Vital::getUrl('Form',"delete","tabela={$_GET['tabela']}"); ?>", {id: id}, function(){

        $(obj_excluir).parent().parent().remove();

    });
	
}

</script>

<div data-role="header" data-theme="b" data-position="fixed" data-tap-toggle="false">

    <a href="<?php echo stalker\library\Fw\Vital::getUrl($voltar?$voltar:"Adm"); ?>"
    data-transition="slide" data-direction="reverse" data-ajax='false'
    class="ui-btn-left ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-back">Voltar</a>

    <h1>Lista de <?php echo ucwords($tabela = $_GET['tabela']); ?></h1>

    <?php if(!$nao_novo): ?>

    <a href="<?php echo stalker\library\Fw\Vital::getUrl('Form',"index","tabela={$_GET['tabela']}"); ?>"
    data-transition="slide" style='background-color: #8cc63f;'
    class="ui-btn-right ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-check">Novo</a>

    <?php endif; ?>
	
</div>

<div data-role='main' class="ui-content lista">

    <table data-filter="true" data-filter-placeholder="Pesquisar..." data-mode='none'
    data-role="table" class="table-stripe ui-responsive">

        <thead>

            <tr>

                <?php foreach($this->view->nome as $titulo => $val): ?>

                <th white-space="nowrap"><?php echo key($val); ?></th>

                <?php endforeach; ?>

                <th width='1%'></th>

            </tr>

        </thead>

        <tbody>

            <?php foreach($this->view->lista as $l): ?>

            <tr>

                <?php foreach($this->view->nome as $titulo => $val): ?>

                <td white-space="nowrap">

                    <?php if(key($val)=='Valor Venda'): ?>

                    <input data-role='none' class='moeda' data-id-bd='<?php echo $l['id']; ?>' 
                    style="margin:0;width: 100px;" onblur="atualizarValor(this);"
                    type='text'  value='<?php echo $l[$val[key($val)]]; ?>' />

                    <?php else: ?>

                    <?php if(!$this->view->nao_alterar): ?>

                    <a href="<?php 
                    echo stalker\library\Fw\Vital::getUrl('Form',"index","id={$l['id']}&tabela={$_GET['tabela']}"); ?>" 
                    class='open-navbar'	data-transition="slide" data-rel="external" data-ajax="false">

                    <?php endif; ?>

                    <?php echo $l[$val[key($val)]]; ?>

                    <?php if(!$this->view->nao_alterar): ?>

                    </a>

                    <?php endif; ?>

                    <?php endif; ?>

                </td>

                <?php endforeach; ?>

                <?php if($id_pagina=='vales'):?>

                <td width='1%' style="padding: 0;">

                    <a href='<?php echo stalker\library\Fw\Vital::getUrl("relatorio-vendas-produtos","id_usuarios/{$l['id']}"); ?>'>Ver Produtos</a>

                    <a href="#popupValorPagar-<?php echo $id_pagina; ?>"
                    data-transition="none" data-rel="popup" data-position-to="window" class="ui-btn ui-corner-all 
                    ui-shadow ui-mini ui-btn-inline ui-icon-shop ui-btn-icon-left ui-btn-a"
                    onclick="$('#id_usuarios').val('<?php echo $l['id']; ?>');" data-transition="pop">Pagar Parcela</a>

                </td>

                <?php endif; ?>

                <td width='1%'>

                    <?php if(!$this->view->nao_excluir): ?>

                    <a data-rel="popup" data-position-to="window" data-transition="pop" href="#popupDialog" 
                    rel='<?php echo $l['id']; ?>' onclick='obj_excluir=this;'
                    class="ui-btn ui-mini ui-corner-all ui-icon-delete ui-btn-icon-notext buta">Excluir</a>

                    <?php endif; ?>

                </td>

            </tr>

            <?php endforeach; ?>

            <div data-role="popup" id="popupDialog" data-overlay-theme="b" data-theme="b" data-dismissible="false">

                <div data-role="header" data-theme="a">

                    <h1>Excluir</h1>

                </div>

                <div class="ui-content">

                    <h3 class="ui-title">Deseja realmente excluir?</h3>

                    <p>Isso não pode ser desfeito.</p>

                    <a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b" data-rel="back">Cancelar</a>
                    <a href="#" onclick='excluir();' class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b" 
                    data-rel="back" data-transition="flow">Excluir</a>

                </div>

            </div>

        </tbody>

    </table>
		
</div>
	
<script>
						
$(".open-navbar").click(function(){

    $(".ui-btn-active").click();
	
});

setMasks();

</script>
