function selecionarProduto(cod_barras){
	
	$("option[alt="+cod_barras+"]").attr("selected","selected");
	$("#id_produtos").selectmenu("refresh");
	
	$("#adicionar-carrinho").click();
	
}