<form action='<?php echo stalker\library\Fw\Vital::getUrl("Form","salvar"); ?>' method='post' data-ajax="false">

	<div data-role="header" data-theme="b">
	
		<a href="<?php echo stalker\library\Fw\Vital::getUrl('Lista','index',"tabela={$_GET['tabela']}"); ?>" 
		data-direction="reverse" data-transition="slide" 
		class="ui-btn-left ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-back">Voltar</a>
		
		<a href="<?php echo stalker\library\Fw\Vital::getUrl($voltar?$voltar:"Adm"); ?>" 
		data-transition="slide" data-direction="reverse" 
		style='margin-left: 85px;'
		class="ui-btn-left ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-home">Home</a>
	
		<h1>Enviar Curso</h1>
		
		<button type='submit' value='Salvar' style='background-color: #8cc63f;'
		class="ui-btn-right ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-check">Enviar</button>
		
	</div>
	
	<div class="ui-header" id='salvo' style='background: #8cc63f;border-bottom: 1px solid #4d6c22;display:none;'>
	
		<h1 class='ui-title'>Salvo!</h1>
		
	</div>

	<div class="ui-content">
			
		<input type='hidden' name='tabela' value='<?php echo $_GET['tabela']; ?>' />
		<input type='hidden' name='id' value='<?php echo $this->view->data['id']; ?>' />

                <label for="select-native-6">Selecione o Curso:</label>
		<select name="id_topico" id="select-native-6">
				
                    <?php foreach($this->view->topico as $e): ?>	

                    <option <?php echo $e["id"]==$this->view->data['id_topicos']?"selected='selected'":null; ?> 
                    value="<?php echo $e['id']; ?>">

                            <?php echo $e['nome']; ?>

                    </option>

                    <?php endforeach;?>
		
		</select>
                
                <br />
                
                <?php foreach($this->view->grupos as $g): ?>
                
                <a  class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-btn-b ui-mini" onclick='selecionar(<?php echo $g['id']; ?>)' href='#'><?php echo $g['nome']; ?></a> 
                
                <?php endforeach; ?>
                
                <br />
                <br />
                
                <table data-role="table" id="table-column-toggle"  data-filter="true" data-filter-placeholder="Pesquisar..."
                data-mode="none" class="ui-responsive table-stroke">
<thead>
<tr>
<th data-priority="2">Participa?</th>
<th>Nome</th>
<th data-priority="3">Email</th>
</tr>
</thead>
<tbody>

    <?php foreach($this->view->usuarios as $u): ?>

    <tr>
        <th><input class='<?php echo $u['id_grupos']; ?>' value='<?php echo $u['id']; ?>' name='participa[<?php echo $u['email']; ?>]' type='checkbox' /></th>
        <td><?php echo $u['nome']; ?></td>
        <td><?php echo $u['email']; ?></td>
    </tr>

    <?php endforeach; ?>

</tbody>
</table>
		
	
	</div>
	
</form>

<script>
    
    function selecionar(id_grupo){
        
        $("."+id_grupo).prop('checked', true);
        
    }

<?php 

if($_GET['salvo']){
	
	echo "$('#salvo').show();setTimeout(\"$('#salvo').hide();\",5000);";
	
}

?>

setMasks();

</script>