jQuery(function(){

	"use strict"; // jshint ;_;




	console.log('star ack...');





	//////////////////////////////////////////////////////////////////////////////////////////
	//////////                               VARIAVEIS                              //////////
	//////////////////////////////////////////////////////////////////////////////////////////

	var dataAck = $('input#dataACK').data();

	// - HTML, overlay base para bloquear qualquer pagina
	var overlay = $('<div id="overlay" />').css({ float:'left', width:'100%', height:'100%', position:'fixed', left:0, top:0 });

	//////////////////////////////////////////////////////////////////////////////////////////
	//////////                               FUNCOES                                //////////
	//////////////////////////////////////////////////////////////////////////////////////////

	/* Retorna o numero de itens em um objeto */
	Object.size = function(obj) {
		var size = 0, key;
		for (key in obj) { if (obj.hasOwnProperty(key)) size++; }
		return size;
	};




	// ----- [function]
	var form = {
		check: function( settings, callback ){
			var info    = $.extend({
					'container': $('.modulo'),
					'wrapper'  : 'fieldset',
					'apendice' : '',
					'senhaMin' : 2
				}, settings),
				senha1  = '', // guardo do valor do campo senha aqui para verificar com o valor do campo de confirmar senha
				retorno = {}, // variavel que comporta todos os campo verificados, ela tambem Ã© 'adulterada' quando algum campo nao esta correto
				senha   = Array('senha', 'password', 'senhaConf', 'rec_senha', 'rec-senha', 'senha_conf', 'senha-conf'), // possiveis nomes para os campos 'senha e confirma senha'
				email   = Array('email', 'mail', 'e-mail', 'EMAIL'); // possiveis nomes para o campo email

			//if (main.objPage.acao == '' || main.objPage.acao == null) { console.log('KEY, "acao" no input:hidden.infoPagina não foi definido!'); };

			$('#alerta').remove();


			// Percorre todas as DIV.modulo | e cria a KEY principal do objeto enviado por json
			$.each(info.container, function(i, parent){
				var parentForm = $(parent),
					keyGrupo   = parentForm.attr('class').split(' ')[1];

				if ( parentForm.attr('chave') != null ) {
					keyGrupo = parentForm.attr('chave');
				};

				// ---------- Cria o grupo principal do bloco encontrado, este nome Ã© definido apartir da segunda classe do bloco
				retorno[keyGrupo] = {};

				// Inclui a key ID no retorno quando o tipo da ação for EDITAR
				if (dataAck.acao == 'editar' || dataAck.id != 0) {
					if (retorno[dataAck.arquivoRetorno] != null) {
						retorno[dataAck.arquivoRetorno]['id'] = dataAck.id;
					}
				};

				// ---------- Percorre todo o INPUT:HIDDEN solto na estrutura principal
				$.each($(parent).children('input'), function(m, hidden){
					retorno[keyGrupo][$(hidden).attr('name')] = $(hidden).val();
				});

				if ( $(parent).find(info.wrapper).hasClass('checkGrup') ) {
					var nome       = $(parent).find(info.wrapper).find('input[type="checkbox"]').attr('name'),
						arrChecked = Array();

					$.each($(parent).find(info.wrapper).find('input:checked'), function(j2, checked){
						arrChecked.push( $(checked).val() );
					});

					retorno[keyGrupo][nome] = arrChecked;
				}
				else {
					// ---------- Percorre todo o DIV.slide atraz de fieldset`s e .fieldset`s pegando o name dos campos como KEY e o preenchendo com o valor do VALUE
					$.each($(parent).find(info.wrapper), function(j, child){
						var campo    = $(child).find('input, textarea, select, .radioGrup'),
							required = campo.attr('required') == 'required';


						// -------------- Estruturas internas que serao ignoradas
						if ( $(child).hasClass('menuIdiomas') || $(child).hasClass('tags') ) {
							//console.log( 'ignorar bloco ['+$(child).attr('class')+']' )
							return;
						}
						// -------------- Grupo de radiobuton, retorna o valor do unico item marcado
						else if ( $(child).hasClass('radioGrup') ) {
							var nome  = $(child).find('input:checked').attr('name'),
								valor = $(child).find('input:checked').val();

							retorno[keyGrupo][nome] = valor;
						}

						// -------------- Qualquer outro campo
						else {
							var nome  = campo.attr('name'),
								valor = campo.val();

							// --------------- Verifica os campos que nao devem ser registrados
							if (campo.attr('ignore') == 'ignore') {
								//console.log( 'Campo ['+nome+'] foi ignorado!' );
								return;
							}
							// --------------- Editor de texto
							if ( $(child).hasClass('editorTexto') ) {
								valor = $(child).find('iframe').contents().find("body").html();

								retorno[keyGrupo][nome] = valor;
							}
							// --------------- Verifica os campos do tipo email
							else if (required && $.inArray(nome, email) != -1) {
								// ----------- Se o campo email nao for preenchido
								if (valor == '') {
									_alerta({ field:campo });
									//_alerta(campo);
									retorno = false;
									return false;
								}
								// ----------- Se a sintaxe do email estiver errado
								else if (!/[A-Za-z0-9_.-]+@([A-Za-z0-9_]+\.)+[A-Za-z]{2,4}/.test(valor)) {
									_alerta({ field:campo, mensagem:'E-mail inválido' });
									//_alerta(campo, 'E-mail invÃ¡lido');
									retorno = false;
									return false;
								}
								else {
									retorno[keyGrupo][nome] = valor;
								}
							}
							// --------------- Verifica os campos do tipo senha, especialmente quando o tipo da acao for 'incluir'
							else if ($.inArray(nome, senha) != -1) {
								// ----------- Verifica se o primeiro campo foi preenchido
								if ((info.tipo_acao == 'incluir' || required) && valor == '') {
									_alerta({ field:campo });
									//_alerta(campo);
									retorno = false;
									return false;
								}
								// ----------- Verifica se o numero minimo de caracteres foi atingido
								else if (info.tipo_acao == 'incluir' && valor.length < info.senhaMin) {
									_alerta({ field:campo, mensagem:'Minimo de '+info.senhaMin+' caracteres' });
									//_alerta(campo, 'Minimo de '+info.senhaMin+' caracteres');
									retorno = false;
									return false;
								}
								// ----------- Verifica se o segundo campo coresponde ao primeiro campo
								else if (senha1 != '' && valor != senha1) {
									_alerta({ field:campo, mensagem:'Senhas incompativeis.' });
									//_alerta(campo, 'Senhas incompativeis.');
									retorno = false;
									return false;
								}
								else {
									retorno[keyGrupo][nome] = valor;
								}
							}
							// --------------- Verifica campos com a propriedade 'required'
							// else if (required &&  valor == '' || valor == null) {

							// 	_alerta({ field:campo });
							// 	//_alerta(campo);
							// 	retorno = false;
							// 	return false;
							// }
							// --------------- Inclui os dados no objeto retorno
							else {
								retorno[keyGrupo][nome] = valor;
							};
							if ($.inArray(nome, senha) != -1) {senha1 = valor};
						};

						if (!retorno) { retorno = false; return false; };
					});// END
				};

				if (!retorno) { retorno = false; return false; };
			});// END


			if (!retorno) { retorno = false; return false; };

			// Percorre o conteudo de qualquer DIV indicada nas configuraÃ§Ãµes da funcao
			if (info.apendice.length > 0) {
				retorno['apendice'] = {};

				$.each(info.apendice.children('input'), function(l, hide){
					var nome  = $(hide).attr('name'),
						value = $(hide).val();
					retorno['apendice'][nome] = value;
				});
			};

			return retorno;
		} // end return
	};














	//////////////////////////////////////////////////////////////////////////////////////////
	//////////                               PLUGINS                                //////////
	//////////////////////////////////////////////////////////////////////////////////////////


	// - Ativa o editor de texto em textarea`s com o parent fieldset.editorTexto
	if( $('.editorTexto').length > 0 ){
		tinymce.init({
			selector: ".editorTexto textarea",
			language: 'pt_BR',
			element_format : "html"
		});
	};






	var anima = {
		overlay: function( remove ){
			var div = $('<div id="ack-overlay" style="display:none; float:left; width:100%; height:100%; position:fixed; left:0; top:0; z-index:999999; background:rgba(255,255,255,0.4);" />');

			if ( remove == true || remove == null )  {
				$('body').append( div );
				$('#ack-overlay').delay(200).fadeIn('fast');
			}
			else if ( remove == false ) {
				if ( $('#ack-overlay').length > 0 ) {
					$('#ack-overlay').fadeOut('fast', function(){ $(this).remove() });
				};
			}
		}
	};

	//anima.overlay();


	// - Autocomplete FINDER, para pesquisar e incluir categorias -----------------------------------NOVO-------------------------
	if ( $('*[data-finder]').length > 0 ) {
		var dataACK = $('#dataACK').data();

		var setting = {
			appendTo: '',
			minLength: 3, // - caracteres até executar a pesquisa

			select:     function( event, ui ){
				$(this).removeClass("ui-corner-top").addClass("ui-corner-all");
				$(this).parents('fieldset').find('.autoComplete_return ul li').remove();
			},
			open:       function() {
				$(this).removeClass("ui-corner-all").addClass("ui-corner-top");
			},
			focus:      function(){},
			close:      function() {
				$(this).removeClass("ui-corner-top").addClass("ui-corner-all");
				$(this).parents('fieldset').find('.autoComplete_return ul li').remove();

				if ( $(this).attr('name') == 'termo' || $(this).attr('name') == 'fotografos' ) {
					$(this).val('');
				};
			},
			messages: {
				noResults: '',
				results: function() {}
			}
		};

		$.each($('*[data-finder]'), function(){
			var finder    = $(this),
				input     = finder.find('input[type="text"]'),
				show      = $(finder.data('finder-show')),
				container = $(finder.data('finder-container'));


			if ( show.length == 0 ) {
				finder.append( $('<div id="'+ show.attr('id') +'" class="'+ show.attr('class') +'" style="border:2px solid red; height:10px;" />') )
			};

			if ( container.length == 0 ) {
				finder.append( $('<div id="'+ container.attr('id') +'" class="'+ container.attr('class') +'" style="border:2px solid red; height:10px;" />') )
			};


			setting['source'] = function( request, response ){
				var name  = this.element.attr('name'),
					dados = JSON.stringify({ 'termo':name, 'contexto':finder.data('finder'), 'acao':'pesquisa', 'modulo':dataACK.modulo, 'id':dataACK.id });

				$.ajax({
					url:  siteURL+'/ack/'+ dataAck.arquivoretorno +'/routerAjax',
					type: 'POST',
					data: {ajaxData:dados},
					dataType: 'json',

					success:    function( data ){
						response(
							$.map(data.resultados, function(item){
								return {value:item.termo, tipo:item.id, url:item.token}
							})
						)
					}
				});
			};

			finder.autocomplete(setting);


			// -- excluir itens da lista
			container.on('click', '.finder-remove', function(){
				var clicado = $(this);

				$.ajax({
					url:  siteURL+'/ack/'+ dataAck.arquivoretorno +'/routerAjax',
					type: 'POST',
					data: {ajaxData: JSON.stringify({ 'acao':'removercontexto', 'modulo':dataACK.modulo, 'id':clicado.id })},
					dataType: 'json',

					beforeSend: function() {
						anima.overlay();
						$('.finder-remove').attr('disabled', 'disabled');
					},
					success:    function( data ) {
						if ( data.status == 1 ) {
							$('.finder-remove').attr('disabled', 'disabled');
						};
					},
					complete:   function( result ) {
						var data = $.parseJSON(result.responseText);

						container.find('#'+data).fadeOut('false', function(){
							$(this).remove();

							anima.overlay(false);
						});
					}
				});
			});
		});
	};





	//////////////////////////////////////////////////////////////////////////////////////////
	//////////                               EVENTOS                                //////////
	//////////////////////////////////////////////////////////////////////////////////////////

	$('body').on('click', '.botao.salvar', function(){
		console.log( form.check() );
	});

});













































































