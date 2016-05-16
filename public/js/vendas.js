var cont = 0;

function salvarVenda(){
	
	if(confirm("Confirmar venda.")){
		
		$("#vendas").attr("onsubmit","");
		$("#vendas").submit();
		
	}
	
}

function salvarProduto(){

	valor_produto = $("#novo_produto").find('option:selected').attr('rel');
	
	var html = "<div style='border-top: 1px dashed gray;padding-top: 10px;margin-top: 10px;' class='aupro'>" + "<strong>Total: R$ " + (parseFloat(valor_produto)*parseInt($("#novo_qtd").val())) + "</strong> ";
	html = html + "Qtd: " + $("#novo_qtd").val() + " <input class='prod_"+cont+" prqtd' type='hidden' name='id_qtd[]' value='"+$("#novo_qtd").val()+"' /><br />";
	html = html + $("#novo_produto").find('option:selected').html() + " <input class='prod_"+cont+" produto_select' type='hidden' alt='"+valor_produto+"' name='id_produtos[]' value='"+$("#novo_produto").val()+"' />";
	html = html + " - " + $("#novo_tamanho").find('option:selected').html() + " <input class='prod_"+cont+"' type='hidden' name='id_tamanhos[]' value='"+$("#novo_tamanho").val()+"' />";
	html = html + "</div>";

	$("#clone").append(html);
	
	$(".aupro").click(function(){

		$(this).remove();
		calcVenda();
		
	});
	
	calcVenda();

}

function salvarPagamento(){
	
	//valor_produto = $("#novo_produto").find('option:selected').attr('rel');
	
	$("#pagamento_vista").fadeOut();
	$("#clone_pagamento").fadeIn();
	
	var html = "<div style='border-top: 1px dashed gray;padding-top: 10px;margin-top: 10px;' class='aupro'>" + "Valor: R$ " + $("#novo_valor").val() + " <input class='pagamento_"+cont+" prval' type='hidden' name='id_valor[]' value='"+$("#novo_valor").val()+"' /> - ";
	html = html + $("#novo_pagamento").find('option:selected').html() + " <input class='pagamento_"+cont+" prpaga' type='hidden' name='id_pagamento[]' value='"+$("#novo_pagamento").val()+"' /> - ";
	html = html + "Parcela: " + $("#novo_parcela").find('option:selected').html() + " <input class='parcela_"+cont+" prparc' type='hidden' name='id_parcela[]' value='"+$("#novo_parcela").val()+"' />";
	//html = html + $("#novo_produto").find('option:selected').html() + " <input class='prod_"+cont+" produto_select' type='hidden' alt='"+valor_produto+"' name='id_produtos[]' value='"+$("#novo_produto").val()+"' />";
	//html = html + " - " + $("#novo_tamanho").find('option:selected').html() + " <input class='prod_"+cont+"' type='hidden' name='id_tamanhos[]' value='"+$("#novo_tamanho").val()+"' />";
	html = html + "</div>";
	
	$("#clone_pagamento").append(html);
	
	/*$(".aupro").click(function(){
		
		$(this).remove();
		calcVenda();
		
	});
	
	calcVenda();*/
	
}

/*

function calcVenda(){

	$("#valor").html(0);	
	
	var valor_produto = 0;
	var qtd           = 0;
	var desconto      = parseInt($("#desconto").val())?parseInt($("#desconto").val()):0;
	
	$("#valor").html(parseFloat($("#valor").html())-desconto);

	$(".produto_select").each(function(){

		if($(this).find('option:selected').attr('rel')){

			qtd = $(this).parent().parent().parent().find('.prqtd').find('option:selected').val();
			valor_produto=parseFloat($(this).find('option:selected').attr('rel'))*parseFloat(qtd);
			
		}else{

			qtd = $(this).parent().find('.prqtd').val();
			valor_produto=parseFloat($(this).attr('alt'))*parseFloat(qtd);
			
		}

		if(valor_produto){

			$("#valor").html(parseFloat($("#valor").html())+parseFloat(valor_produto));
			$("#valor_hid").val($("#valor").html());

		}
			
	});
	
}

*/

var valor_total;

function calcVenda(){
	
	var desconto = parseFloat($("#desconto").val());
	
	$("#valor").html(valor_total-desconto);
	
}

function selecionarCod(cod_barras){
	
	$.post('index.php/get-cod-barras',{cod: cod_barras},function(html){
		
		var desconto = parseFloat($("#desconto").val());
		
		item = html.split("|");
		
		valor_compra = parseFloat($("#valor").html())+desconto;
		valor_item   = parseFloat(item[1]);
		
		if(!valor_item){
			
			alert("Produto não encontrado");
			
			return false;
			
		}
		
		valor_total  = valor_compra+valor_item;
		
		$("#valor").html(valor_total-desconto);
		$("#valor_hid").val(valor_total-desconto);
		$("#clone").prepend("<div class='aupro' rel='"+item[1]+"'>"+item[0]+"<input type='hidden' name='id_produtos[]' value='"+item[2]+"' /><hr /></div>");
		$("#cod_barras").val('');
		
		
		//calcVenda();
		
		$(".aupro").click(function(){
			
			/*var desconto = parseFloat($("#desconto").val());
			
			valor_excluir = parseFloat($(this).attr("rel"));
			
			$("#valor").html((valor_total-valor_excluir)-desconto);
			
			valor_total = valor_total-valor_excluir;
			
			$(this).remove();*/
			
		});
		//alert(item[1]);
		
	});
	
}

$(function(){
	
	jwerty.key('enter',function(){
		
		selecionarCod($('#cod_barras').val());
		
		return false;
		
	});
	
	/*jwerty.key('s',function(){
		
		$('#vendas').submit();
		
		return false;
		
	});*/
	
	jwerty.key('esc',function(){
		
		$('#search,#painel-vendas').fadeOut();
		
		return false;
		
	});

	$("#prod").change(function(){
		
		calcVenda();
		
	});

	$("#qtd").change(function(){
		
		calcVenda();
		
	});

	$("#expandable-menu").click(function(){
		
		if($("#painel-vendas").css('display')=="block"){
		
			$("#painel-vendas").hide();
			
		}else{
			
			$("#painel-vendas").show();
		}
		
	});
	
	$("#lista-menu li").click(function(){
		
		$("#painel-vendas").hide();
		
	});
	
	$("#desconto").change(function(){
		
		calcVenda();
		
	});
	
	$("#cod_barras").select();
	
});