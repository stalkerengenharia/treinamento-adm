/**
 * BEGIN: VENDA
 */

var valor_pago         = 0;
var valorTotal         = 0;
var valor_vistaTotal   = 0;
var valorDesconto      = 0;
var valorFalta         = 0;
var valor_troca        = 0;
var parcelaSel         = false;
var parcelado_desconto = false;

var abrirCompraParcelada = function(){
	
	$("#novoPagamento").popup('open');
	
};

var salvarPagamento = function(){

	if($("#validacao-div").css("display") == "table-row" || $("#falta-div").css("display") == "table-row"){
		
		if(confirm('O pagamento parcelado não é válido. A venda não será salva como pagamento parcelado.')){
			
			$("#id_parcela_pagamentos-1").val("");
			$('#novoPagamento').popup('close');
			
		}
		
	}else{
		
		$('#novoPagamento').popup('close');
		
	}
	
};

var salvarVenda = function(){
	
	var tipo_venda = $("input[name='id_pagamento']:checked").val();
	var desconto   = getMoedaEN($("#desconto").val());
	
	if(!valorTotal){
		
		alert("Carrinho vazio.");
		
		return false;
		
	}
	
	if($("#validacao-div").css("display") == "table-row"){
	
		alert('Esta Venda não pode ser salva. Erro no pagamento parcelado.');
		
		return false;
		
	}
	
	if(tipo_venda < 4){
		
		/**
		 * Se o vale for para Jessica,
		 * Coloca valor de custo
		 */
		
		if($("#id_usuarios_vales").val()){
			
			valor_vistaTotal = valorDesconto;
			
		}
		
		if(vfinal = prompt("Confirmar recebimento do valor(a vista) e finalizar a venda?",getMoedaBR(valor_vistaTotal-desconto,true))){
			
			vfinal = getMoedaEN(vfinal,true);
			
			$("#valor_hid").val(vfinal);
			$("#frm-vendas").submit();
			
		}
		
	}else{
		
		if($("#slider-flip-m").val() == '1'){
			
			if(vfinal = prompt("Confirmar recebimento do valor(parcelado) e finalizar a venda?",getMoedaBR(valor_vistaTotal-desconto,true))){
				
				vfinal = getMoedaEN(vfinal,true);
				
				$("#valor_hid").val(vfinal);
				
				$("#frm-vendas").submit();
				
			}
			
		}else{
			
			if(vfinal = prompt("Confirmar o recebimento do valor(parcelado) e finalizar a venda?",getMoedaBR(valorTotal-desconto,true))){
				
				vfinal = getMoedaEN(vfinal,true);
				
				$("#valor_hid").val(vfinal);
				
				$("#frm-vendas").submit();
				
			}
			
		}
		
	}
	
};

var atualizarParcela = function(){
	
	var valor_pago    = 0;
	var valor_parcsel = 0;
	var valor_entrada = 0;
	var pgto          = 0;

	$(".pagamento-vista").each(function(){
		
		pgto          = getMoedaEN($(this).val());
		valor_pago    = valor_pago + pgto;
		valor_entrada = valor_pago;

	});
	
	/**
	 * Se entrada maior que R$ 50,00 e parcela menor que 3x
	 * entao o pagamento sai a vista ou
	 * entrada maior ou igual R$ 80,00, libera todos
	 */
	
	if($("#slider-flip-m").val() == '1'){
		
		valorFalta = valor_vistaTotal - valor_pago;
		
		$("#total-divd").html(getMoedaBR(valor_vistaTotal));
		
	}else{
		
		valorFalta = valorTotal - valor_pago;
		
		$("#validacao-div").hide();
		
		$("#total-divd").html(getMoedaBR(valorTotal));
		
	}
	
	for(var i=0;i<=6;i++){
		
		var valor_parcela = valorFalta/i;
		
		if((valorFalta/i <= 50) || (i >= 4 && valorFalta/i <= 80)){
			
			$(".parc-"+i).parent().parent().hide();
			
		}else{
		
			$(".parc-"+i).html(getMoedaBR(valor_parcela));
			$(".parc-"+i).parent().parent().show();
			
		}
		
		$(".parc-"+i).html(getMoedaBR(valor_parcela));
		
		if(parcelaSel == i){
			
			valor_pago = valor_pago + valor_parcela * i;
			
			valor_parcsel = valor_parcela * i;
			
			if(valor_parcsel){
			
				$("#valor_parc button").html(getMoedaBR(valor_parcsel));
			
			}
			
		}
		
	}
	
	/*if(valor_entrada < 50 && $("#slider-flip-m").val() == '1'){
		
		$("#validacao-div").show();
		
	}else if(parcelaSel >= 4 && valor_entrada < 80 && $("#slider-flip-m").val() == '1'){
		
		$("#validacao-div").show();
		
	//}else if(valor_entrada == valor_parcsel && $("#slider-flip-m").val() == '1'){
		
		//$("#validacao-div").show();
		
	}else{
		
		$("#validacao-div").hide();
		
	}*/
	
	if(parcelaSel){
		
		valorFalta = 0;
		
	}
	
	$("#parcela-falta").html(getMoedaBR(valorFalta));
	
	if(valorFalta == 0){
		
		$("#falta-div").hide();
		
	}else{
		
		$("#falta-div").show();
		
	}
	
};

var carrinhoAddProduto = function(id){
	
	var id = id?id:$("#cod_barras").val();

	$.getJSON("templates/get-produto.php",{id: id},function(json){
		
		if(json.nome_completo){

			var desconto_br               = json.valor_desconto?'<span style="text-decoration: line-through;font-size: 10px;color: gray;">de ' +
											json.valor_br +
											'</span> por: ' +
											json.valor_desconto_br:json.valor_br;
			
			var desconto                  = json.valor_desconto?'<span style="text-decoration: line-through;font-size: 10px;color: gray;">de ' +
											json.valor_br +
											'</span> por: ' +
											json.valor_desconto_br:json.valor_venda;
			
			if($("#id_usuarios_vales").val()){
			
				/**
				 * Se o vale for para Jessica,
				 * Coloca valor de custo
				 */
				
				if($("#id_usuarios_vales").val() == '1'){
					
					$(".vale-vend").html("<span style='color:red'>VALE A PREÇO DE CUSTO</span>");
					
					desconto    = json.valor_custo;
					desconto_br = (json.valor_custo_br);
					
				}else{
					
					$(".vale-vend").html("<span style='color:red'>VALE PARA VENDEDOR DE 30%</span>");
					
					desconto    = json.valor_vista-(json.valor_vista*30/100);
					desconto_br = getMoedaBR(json.valor_vista-(json.valor_vista*30/100));
					
				}
			
			}
	
			var valor_produto          = json.valor_desconto?json.valor_desconto:json.valor;
			var valor_produto_vista    = json.valor_desconto?json.valor_desconto_vista:json.valor_vista;
	
			var valor_produto_br       = json.valor_desconto?json.valor_desconto_br:json.valor_br;
			var valor_produto_vista_br = json.valor_desconto?json.valor_desconto_vista_br:json.valor_vista_br;
	
			var linhaProduto  = '<tr><td><input type="hidden" name="produto[]" value="' + json.id + '" />' +
								json.nome_completo + 
								'</td><td>'
								+ desconto_br +
								'</td><td><input name="qtd[]" class="qtdprod" onkeyup="calculaTotal(this);" onchange="calculaTotal(this);" valorDescontovista="'+desconto+'" valorUNvista="'+valor_produto_vista+'" valorUN="'+valor_produto+'" data-role="none" value="1" type="number" /></td><td class="valor">'+
								valor_produto_br +
								'</td><td class="valor_vista">'+
								valor_produto_vista_br +
								'</td><td width="1%"><a onclick="$(this).parent().parent().remove();calculaTotal(this);" class="ui-btn ui-mini ui-corner-all ui-icon-delete ui-btn-icon-notext buta">Excluir</a></td></tr>';
			
			$("#tabela-carrinho tbody").append(linhaProduto);
	
			valor_pago = 0;
			calculaTotal();
	
			$("#cod_barras").val('');
			
		}
		
	});

};

var calculaTotal = function(obj){

	valorTotal       = 0;
	valor_vistaTotal = 0;
	valorDesconto    = 0;
	
	var qtdTotal     = 0;
	var qtd          = parseInt($(obj).val());
	var valor_un     = $(obj).attr("valorUN");


	if(qtd){
		
		var valor = valor_un*qtd;
	
		$(obj).parent().parent().find(".valor").html(getMoedaBR(valor));
	
	}

	$(".qtdprod").each(function(){

		var val            = parseInt($(this).val());
		var valor_un       = $(this).attr("valorUN");
		var valor_un_vista = $(this).attr("valorUNvista");
		var valor_desconto = $(this).attr("valorDescontovista");
		
		qtdTotal         = qtdTotal + val;
		valorTotal       = valorTotal + val * valor_un; 
		valorDesconto    = valorDesconto + val * valor_desconto; 
		valor_vistaTotal = valor_vistaTotal + val * valor_un_vista;

		$(".totalvalor_custo").html(getMoedaBR(valorDesconto));
		$(".totalqtd").html(qtdTotal);
		$(".totalvalor").html(getMoedaBR(valorTotal));
		$(".totalvalor_desconto").html(getMoedaBR(valor_vistaTotal));
		
		$(this).parent().parent().find(".valor").html(getMoedaBR(val*valor_un));
		$(this).parent().parent().find(".valor_vista").html(getMoedaBR(val*valor_un_vista));
		
		
	});
	
	if(qtdTotal){

		$("#totais").show();
		
	}else{

		$("#totais").hide();

	}
	
	atualizarParcela();
	
	/**
	 * TROCA
	 */
	
	if(valor_troca){
	
		salvarTroca();
		
	}
	
};

function salvarTroca(){
	
	var valor = valor_troca - valor_vistaTotal;
	
	$(".tot-troca").slideDown();
	
	$("#credito_gerado_troca").html(getMoedaBR(valor_troca));
	$("#credito_gerado_saldo").html(getMoedaBR(valor));
	
}

/**
 * END: VENDA
 */

var total_vale = 0;

var pagarValor = function(){
	
	$("#popupValorPagar").popup("close");
	
	$("#valor").val(getMoedaEN($("#valor_pagar").val()));
	
	$.get('php/salvar-vales.php?'+$("#fake-form").serialize(),{},function(){
		
		alert("Pagamento Realizado.");
		
		location.reload();
		
		$.mobile.changePage( base + "lista/vales", { 

			 allowSamePageTransition : true,
		      transition              : 'none',
		      showLoadMsg             : false,
		      reloadPage              : true

			
		});
		
	});
	
};

var calcularTotalDesconto = function(id_pagina){

	$('#tabela-promocao-'+id_pagina + " .todos").each(function(){
		
		var valor = $(this).attr("valor");
		var pai   = $(this).parent().parent().parent().parent().parent();
		
		if($(this).is(":checked")){
			
			valor = valor - ((valor / 100) * $("#desconto-"+id_pagina).val());
			
			$(pai).find(".totales").html(getMoedaBR(valor));
			
		}else{
			
			$(pai).find(".totales").html('');
			
		}
		
	});
	
};

var selecionarProdutoLinha = function(obj){
	
	if(typeof obj === 'object'){
		
		var o     = $(obj).parent().parent().parent().parent().parent();
		var valor = parseFloat($(obj).attr('valor'));
		
		if($(obj).is(":checked")){
			
			$(o).css("background",'#FFFF99 ');
			
			total_vale = total_vale + valor;
			
		}else{
			
			$(o).css("background",'none');
			
			total_vale = total_vale - valor;
			
		}
		
		$(".vale-total-pagar").html(getMoedaBR(total_vale));
		
	}else{
		
		total_vale = 0;
		
		$(obj).find('.lista-vales').each(function(){
			
			var checked = $(this).is(":checked");
			var valor   = parseFloat($(this).attr("valor"));
			
			if(checked){
				
				total_vale = total_vale + valor;
				
			}
			
		});
		
		$(".vale-total-pagar").html(getMoedaBR(total_vale));
		
		return;
		
	}
	
};

var setMasks = function(){
	
	$(".cnpj").mask("000.000.000/0000-00", {clearIfNotMatch: true});
	$(".data").mask("00/00/0000", {clearIfNotMatch: true});
	$(".telefone").mask("(00) 00000-0000", {clearIfNotMatch: true});
	
	$(".moeda").maskMoney({symbol:'R$ ', thousands:'.', decimal:',', symbolStay: true});
	$(".moeda").maskMoney("mask");
	
	$( ".data" ).datepicker({
	    dateFormat: 'dd/mm/yy',
	    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
	    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
	    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
	    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
	    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
	    nextText: 'Próximo',
	    prevText: 'Anterior'
	});
	
	$("form").submit(function(){

		if(!validar(this)){

			return false;

		}
		
	});
	
	if($(".tabs").length){
		
		$(".content").find("div:first").show();
		
	}
	
};

var atalhos = function(){
	
	/**
	 *
	 *  Salvar vendas
	 *
	 */

	jwerty.key('f2',function(){

		$.mobile.changePage( base + "estoque", { transition: "slide", changeHash: true });
		
	});
	
	/**
	 *
	 *  Relatorio de vendas
	 *
	 */
	
	jwerty.key('f4',function(){
		
		$.mobile.changePage( base + "resumo", { transition: "slide", changeHash: true });
		
	});

	/**
	 *
	 *  Relatorio de vendas
	 *
	 */

	jwerty.key('f8',function(){

		$.mobile.changePage( base + "estoque", { transition: "slide", changeHash: true });
		
	});

	/**
	 *
	 *  Relatorio de vendas
	 *
	 */

	jwerty.key('f9',function(){

		$.mobile.changePage(base + "adm-financeiro", { transition: "slide", changeHash: true });
		
	});
	
};

var login = function(url){

	$("#unlock").val("Validando...");

	$.post(url, {senha:$("#senha").val()},function(bool){

		if(bool==1){

			$("#layer").remove();
			$("#login").remove();
			
		}else{

			$("#unlock").val("Desbloquear");
			
		}

	});
	
};

var loginGeral = function(url){
	
	$("#unlock").val("Validando...");
	
	$.post(url, {senha:$("#senha").val()},function(bool){
		
		if(bool==1){
			
			$("#layer").remove();
			$("#login").remove();
			
		}else{
			
			$("#unlock").val("Desbloquear");
			
		}
		
	});
	
};

var getMoedaEN = function(val,sem_rs){
	
	if(!val || val=="R$ 0,00"){
		
		return 0;
		
	}
	
	var val;
	
	if(sem_rs){
		
	}else{
		
		val = val.substr(3, val.length);
		
	}
	
	val = val.replace(".", "");
	val = val.replace(",", ".");

	return parseFloat(val);
	
};

var getMoedaBR = function(valor,sem_rs){
	
	valor = parseFloat(valor);
	
	valor = valor.toFixed(2);
	
	valor += '';
	
    var x = valor.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? ',' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + '.' + '$2');
    }
    
    if(sem_rs){
    	
    	return x1 + x2;
    	
    }
    
    return "R$ " + x1 + x2;

};

var getProduto = function(id){

	$.getJSON("templates/get-produto.php",{id: id},function(json){
		
		valor_troca = json.valor;

		$(".produto-troca").html("<h2>Produto Troca</h2>"+json.id+" - "+json.nome_completo+" - "+json.valor_br+"<input type='hidden' name='troca' value='"+json.id+"' />");
		
		$(".prod-pesq").find("p").html(json.nome_completo + " - " + json.valor_br);
		
		$(".prod-pesq").slideDown();
		
	});
	
};

var ShowHide = function(e,obj){

	$(".tabs").hide();
	
	$(obj).parent().parent().parent().parent().find(e).show();
	
};

var validar= function(elm){

	var submit = true;

	$(".error").remove();
 
	$(elm).find(".required").each(function(){

		var name = $(this).attr('name');
		var val  = $(this).val();
		var type = $(this).attr('type');
		
		if(name){
			
			if(type == 'radio'){
				
				if(!$("input[name="+name+"]:checked").val()){
					
					val = false;
					
				}
				
			}

			if(val && val != 'R$ 0,00'){
	
			}else{
				
				var item_error = $(this).parent();
				submit         = false;
				
				if(type == 'radio'){
					
					item_error = $(this).parent().parent();
					
				}
	
				item_error.after("<label class='error'>Preenchimento Obrigatório.</label>");
	
			}
		
		}
		
	});

	if(submit){

		//$('#salvo').show();
		//setTimeout("$('#salvo').hide();",5000);
		
		return true;

	}
	
	return false;
	
};

var pesquisarCliente = function(val){
	
	$.get("templates/get-clientes.php",{q:val},function(html){
		
		$("#search").html(html).fadeIn();
		
	});
	
};

var salvarRegistro = function(options){
	
	var data = $("#"+options.form+" :input").serialize()+"&tabela="+options.tabela;
	
	$.post('php/salvar.php', data, function(id){
		
		$("#"+options.id).val(id);
		
		$("#pesq_cli").val($("#nome_cliente").val());
		
		$("#cliente-salvo").fadeIn("slow").fadeOut("slow");
		
	});
	
};

var selecionarTodos = function(){
	
	$(".todos").each(function(){
		
		var it = $(this).parent().parent().parent().parent().parent();
		
		if(!$(it).hasClass("ui-screen-hidden")){
			
			if($("#check-todos").is(':checked')){
			
				$(this).prop('checked', true).checkboxradio('refresh');
			
			}else{
				
				$(this).prop('checked', false).checkboxradio('refresh');
				
			}
			
		}
		
	});
	
	calcularTotalDesconto();
	
};