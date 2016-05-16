<script>

$(function(){
	
	$("#grupo").change(function(){
	
		console.log("teste");
		$("#form-grupos").submit();
	
	});

	$("#grupo").val('<?php echo $_GET['grupo']; ?>');
	
});

    
</script>
  
<style>
    
.rel-draw{
    	
	height: 2400px;
	width: 100%;
    
}
    
</style>
<!--Load the AJAX API-->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">

// Load the Visualization API and the piechart package.
google.load('visualization', '1.0', {'packages':['corechart']});
      
</script>
   
<div data-role="header" data-theme="b" data-position="fixed" data-tap-toggle="false">

	<a href="<?php echo stalker\library\Fw\Vital::getUrl('Avaliacao','index'); ?>" data-transition="slide" data-direction="reverse" 
	class="ui-btn-left ui-btn ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-back">Voltar</a>

	<h1>Gráficos</h1>
		
</div>

<form id='form-grupos' method='GET' data-ajax="false">
	
	<select id='grupo' name="grupo" class="required">
			
		<option value=''>Total</option>
				
		<?php foreach($this->view->grupos as $g): ?>
				
		<option value="<?php echo $g['id']; ?>"><?php echo $g['nome']; ?></option>
		
		<?php endforeach; ?>
						
	</select>
	
	<input style="display: none;" data-role='none' type="submit" value="submit">
			
</form>

<div data-role='main' class="ui-content lista">

	<?php 
  
		$g = new stalker\library\Fw\Grafico();
  
		$g->getPerguntas();
  
	?>
  
</div>