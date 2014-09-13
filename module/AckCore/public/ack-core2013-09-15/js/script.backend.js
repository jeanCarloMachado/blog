//################# Funções de biblioteca #####################
$(window).load(function() 
{
      bootstrap();
});

function bootstrap() 
{
	//clicando no elemento dispatcher há de 
	//se garimpar os blocos com a classe igual
	//à proxima classe devilBlockDispatcher e enviar seus dados
	$(".devilBlockDispatcher").click(function(){
		 classes = ($(this).attr("class"));
		 classes = classes.split(" ");
		 blockClass = null;

		for(i = 0; i < classes.length; i++) {
			if(classes[i] == "devilBlockDispatcher") {
				blockClass = classes[i+1];
				blockClass = blockClass.replace("devilBlockName:","");
				break;
			}
		}

		
		elements = $("." + blockClass).find("input,textarea,select");

		if(!elements)
			console.log("Não encontrou nenhum elemento filho do tipo desejado");
		
		var data ={};
		elements.each(function() {
			data[$(this).attr("name")] = $(this).attr("value");
		});

		if(!data.action) {
			for(i = 0; i < classes.length; i++) {
				if(classes[i] == "devilAjaxAction") {
					data.action = classes[i+1];
					break;
				}
			}
		}
		//efetua o ajax
		response = sendData(data);

	});
// pacote = JSON.stringify({
// 'acao': tipo_acao,
// });	
}

function sendData(data) {
	result = null;
	$.ajax({
		url:  siteURL+'/ack/'+$('input#infoPagina').data('info').arquivoRetorno+'/routerAjax',
		type: 'POST',
		data: 'ajaxACK='+ JSON.stringify(data),
		dataType: 'json',
		success: function(data){
			result = data;
		}
	})

	return result;
}
//################# Fim Funções de biblioteca #####################


