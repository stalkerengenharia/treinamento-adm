<form action='<?php echo stalker\library\Fw\Vital::getUrl("Form","salvar"); ?>' method='post' data-ajax="false">

	<div data-role="header" data-theme="b">
	
		<a href="<?php echo stalker\library\Fw\Vital::getUrl('Lista','index',"tabela={$_GET['tabela']}"); ?>" 
		data-direction="reverse" data-transition="slide" 
		class="ui-btn-left ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-back">Voltar</a>
			
		<a href="<?php echo stalker\library\Fw\Vital::getUrl($voltar?$voltar:"Adm"); ?>" 
		data-transition="slide" data-direction="reverse" 
		style='margin-left: 85px;'
		class="ui-btn-left ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-home">Home</a>
			
		<h1>Empresas</h1>
		
		<button type='submit' value='Salvar' style='background-color: #8cc63f;'
		class="ui-btn-right ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-check">Salvar</button>
		
	</div>
	
	<div class="ui-header" id='salvo' style='background: #8cc63f;
	border-bottom: 1px solid #4d6c22;display:none;'>
	
		<h1 class='ui-title'>Salvo!</h1>
		
	</div>

	<div class="ui-content">
	
		<input type='hidden' name='tabela' value='<?php echo $_GET['tabela']; ?>' />
		<input type='hidden' name='id' value='<?php echo $this->view->data['id']; ?>' />
		
		<label for="nome"><strong><em>*</em> Nome</strong>:</label>
		<input type="text" class='required' name="nome" id="nome" value="<?php echo $this->view->data['nome']; ?>">
	
	</div>
	
</form>

<script>

<?php 

if($_GET['salvo']){
	
	echo "$('#salvo').show();setTimeout(\"$('#salvo').hide();\",5000);";
	
}

?>

setMasks();

</script>