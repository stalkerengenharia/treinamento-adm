<form action="<?php echo stalker\library\Fw\Vital::getUrl("Form","salvar","tabela={$_GET['tabela']}"); ?>" 
method="post" data-ajax='false'>

	<div data-role="header" data-theme="b">	
	
		<a href="<?php echo stalker\library\Fw\Vital::getUrl('Lista','index',"tabela=perguntas"); ?>" 
		data-direction="reverse" data-transition="slide" 
		class="ui-btn-left ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-back">Voltar</a>
		
		<a href="<?php echo stalker\library\Fw\Vital::getUrl($voltar?$voltar:"Adm"); ?>" 
		data-transition="slide" data-direction="reverse" 
		style='margin-left: 85px;'
		class="ui-btn-left ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-home">Home</a>
			
		<h1>Perguntas</h1>
		
		<button type='submit' value='Salvar' style='background-color: #8cc63f;'
		class="ui-btn-right ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-check">Salvar</button>
			
	</div>
	
	<div class="ui-header" id='salvo' style='background: #8cc63f;border-bottom: 1px solid #4d6c22;display:none;'>
		
		<h1 class='ui-title'>Salvo!</h1>
	
	</div>
	
	<input type='hidden' name='tabela' value='<?php echo $_GET['tabela']; ?>' />
	<input type='hidden' name='id' value='<?php echo $this->view->data['id']; ?>' />	
	
	<div class='ui-content'>

		<label for="select-native-6">Selecione o Tópico:</label>
		<select name="id_topicos" id="select-native-6">
				
			<?php foreach($this->view->topico as $e): ?>	
			
			<option <?php echo $e["id"]==$this->view->data['id_topicos']?"selected='selected'":null; ?> 
			value="<?php echo $e['id']; ?>">
			
				<?php echo $e['nome']; ?>
				
			</option>
								
			<?php endforeach;?>
		
		</select>

		<label for="textarea-1">Nome Apresentação:</label>
	
		<input type='text' name="nome" id="textarea-1" value='<?php echo $this->view->data['nome']; ?>' />

		<label for="textarea-1">Código do Google Docs(Power Point):</label>
	
		<input type='text' name="apresentacao" id="textarea-1" value='<?php echo $this->view->data['apresentacao']; ?>' />

		<label for="textarea-1">Código do Google Docs(Comprovação da conclusão do curso):</label>
	
		<input type='text' name="conclusao" id="textarea-1" value='<?php echo $this->view->data['conclusao']; ?>' />
	
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