jQuery(function(){
	/// -----------------------------------------------------------------------------------------------------------------------------------
	/// ---------------------------------------------------------------------------------------------------------------------|NOVO|--------
	/// -----------------------------------------------------------------------------------------------------------------------------------
	var main = {
		parent: {
			principal: '.parnetFull',
			listas: '.lista'
		},
		botao: {
			salvar: '.salvar',
			excluir: '.excluir',
			carregarM: '.carregarMais'
		},
		mensagem: {
			salvar: 'Salvando dados...',
			editar: 'Salvando dados alterados...'
		},
		url: siteURL,
		objPage: $('input#infoPagina').data('info')
	}
	//console.log( main );

	/* HTML, overlay base para bloquear qualquer pagina */
	var overlay = $('<div id="overlay" />').css({ float:'left', width:'100%', height:'100%', position:'fixed', left:0, top:0 });





	// ----------| Cria um cookie |-------------------------------------------
	function setCookie( c_name, value, exdays ){
		var exdate = new Date();
		exdate.setDate(exdate.getDate()+exdays);
		var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
		document.cookie = c_name + "=" + c_value;
	};
	// ----------| Le um cookie |---------------------------------------------
	function getCookie( c_name ){
		var i,x,y,ARRcookies=document.cookie.split(";");
		for (i=0;i<ARRcookies.length;i++){
			x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
			y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
			x=x.replace(/^\s+|\s+$/g,"");

			if (x==c_name){ return unescape(y); }
		}
	};

	/* Remove um elemento do array */
	Array.prototype.remove = function() {
		var what, a = arguments, L = a.length, ax;
		while (L && this.length) {
		    what = a[--L];
		    while ((ax = this.indexOf(what)) !== -1) { this.splice(ax, 1); }
		}
		return this;
	};

	/* Ativa o editor de texto em textarea`s com o parent fieldset.editorTexto */
	if( $('.editorTexto').length > 0 ){
		/*var settingsTxt = {
			// Location of TinyMCE script
			script_url : siteURL+'/plugins/ack/tiny_mce/tiny_mce.js',
			// General options
			theme : "advanced",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,|,cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,code,|,preview,|,formatselect,fullscreen",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,
			theme_advanced_resize_horizontal : false,
			height: '320',
			// Example content CSS (should be your site CSS)
			content_css : "css/content.css",
			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			media_external_list_url : "lists/media_list.js",
			// Replace values for the template plugin
			template_replace_values : {
				username: "Some User",
				staffid: "991234"
			}
		};

		$.each($('.editorTexto'), function(idxT, elmT){
			$(elmT).find('textarea').attr('id', 'editor_'+idxT);

			$('textarea#editor_'+idxT).tinymce(settingsTxt);
		});*/

		tinymce.init({
			selector: ".editorTexto textarea",
			language: 'pt_BR',
			element_format : "html"
		});
	};

	/* Desabilita as setas do topo e fundo da listagem. */
	function disableArrow(){
		$('ol li').find('.btnOrdem').removeAttr('disabled');

		$.each($('ol').children('li'), function(li_idx, li_emt) {
			if( $(li_emt).is(':last-child') && $(li_emt).children('ol:visible') ){
				$(li_emt).find('button.btn_goFundo').attr('disabled', 'disabled');
				$(li_emt).children('ol').find('button.btn_goFundo').removeAttr('disabled');
			}
			if( $(li_emt).is(':first-child') && $(li_emt).children('ol:visible') ){
				$(li_emt).find('button.btn_goTopo').attr('disabled', 'disabled')
				$(li_emt).children('ol').find('button.btn_goTopo').removeAttr('disabled');
			}
		});
	};





	/// ---------------------------------|||||---------------------------------|||||---------------------------------|||||
	$('.wrapper-box').on('click', '.head-btn', function(){
		var clicado = $(this),
			slider = clicado.parents('.box').find('.box-body').children('.collapse');

		console.log( clicado )

		if ( !slider.is(':visible') ) {
			clicado.removeClass('fechado');
			slider.slideDown('fast');
		}
		else {
			clicado.addClass('fechado');
			slider.slideUp('fast');
		};
	});
	/// ---------------------------------|||||---------------------------------|||||---------------------------------|||||






	/* //////// EVENT, modulo com abas, executa a função detrocar das Abas ///////////////////////////////////// */
	$('.menuAbas button').bind('click', function(){
		var segClass  = $(this).parents('.modulo').attr('class').split(' ')[1],
			abrirAba  = $(this).val(),
			uploadVar = abrirAba.replace('aba', '').toLowerCase();

		if( !$(this).hasClass('abaView') ){
			$(this).addClass('abaView').siblings('button').removeClass('abaView');
			$('.contAba:visible').slideUp('fast').promise().done(function(){
				$('#'+abrirAba).slideDown('fast');
			})
		}
		// para blocos com upload de arquivos ele executa a função que carregar arquivos ja cadastrados.
		if( segClass == 'upMidias' ){
			CarregaArquivos(uploadVar);
		}
	});
	// -------- Executa o plugin quando a DIV.modulo com a segunda classe .upMidias detectada na pagina
	if( $('.upMidias').length > 0 && main.objPage.acao == 'editar' ){
		var abaShow  = $('.upMidias').find('.contAba:first').attr('id'),
			autoLoad = abaShow.replace('aba', '').toLowerCase();

		CarregaArquivos(autoLoad)
	};

	/* //////// EVENT, Abre e fecha modulos ///////////////////////////////////// */
	$('.modulo .head > button').click(function(comando){
		if( !$(this).parent('.head').next('.slide').is(':visible') ){
			$(this).removeClass('fechado').parent('.head').next('.slide').slideDown('fast');
		} else {
			$(this).addClass('fechado').parent('.head').next('.slide').slideUp('fast')
		}
	});

	/* //////// EVENT, Mascara para peencher campo do tipo data ///////////////////////////////////// */
	$('input[type="date"], .noticias input[name="data"]').bind('keyup', function(){ _checkData(this) });
	$('.filter-results-item.pagamentoData input, .filter-results-item.dataImgS input, .filter-results-item.dataUser input, .filter-results-item.contatoData input').bind('keyup', function(){ _checkData(this) });

	$('input[name="price_total"], .filter-results-item.pagamentoValor input').setMask({ mask:'99,999.999.999.999', type:'reverse', defaultValue:'00', textAlign:false });


	infoPage = infoPrime( $('.parentFull') );

	////////// EVENTO, carrega lista de acordo com a categoria selecionada no menu ///////////////////////////////////////
	if( $('.filtroCategorias').is(':visible') ){
		catGeral    = $('.filtroCategorias').find('button[value="0"]');
		parentLista = $('.collumA').children(main.parent.listas);

		filtroProdutos({
			botao: catGeral,
			parent_lista: parentLista,
			modulo: $('input[type="hidden"].dadosPagina').attr('id')
		})
	}
	// -------------------------------------
	$('.filtroCategorias ul li button').bind('click', function(){
		var clicado     = $(this),
			marcado     = $('.filtroCategorias').find('button.checked'),
			parentLista = $('.collumA').children(main.parent.listas);

		if( clicado.val() == '0' ){
			$('.lista_daCategoria').find('ol').slideUp('slow', function(){
				$(this).parent('.lista_daCategoria').slideUp('fast', function(){
					$(this).remove()
					marcado.removeClass('checked')
				})
			})
			$('.lista_daCategoria').promise().done(
				filtroProdutos({
					botao: clicado,
					parent_lista: parentLista,
					modulo: $('input[type="hidden"].dadosPagina').attr('id')
				})
			)

		} else if( clicado.val() != '0' ){
			if( $('.list_produtos, .list_noticias, .list_imprensa, .list_servicos').find('.lista_daCategoria').attr('id') == '0' ){
				$('.lista_daCategoria').remove()
				marcado.removeClass('checked')
			}
			filtroProdutos({
				botao: clicado,
				parent_lista: parentLista,
				modulo: $('input[type="hidden"].dadosPagina').attr('id')
			})
		}
	});


	////////// PAGINA, usuarios aÃ§Ãµes baiscas ///////////////////////////////////////
	$('#salvarUsuario').bind('click', function(){
		var botao       = $(this),
			tipo_acao   = botao.attr('name'),
			dadoUsuario = _getCampos({
				modulo: $('.formCadastro .collumA'),
				importante: {'nomeC':'Deve preencher seu nome completo'},
				tipoAcao: tipo_acao
			})

		// ----- | Cria um objeto com as seÃ§Ãµes do site e a permissao concedida co usuario | -----
		if( $('.list_permissoes').is(':visible') == true ){
			var lista_permissoes = {};

			$('.listaPermissoes').find('li').each(function(i, per){
				chave = $(per).find('input:checked').attr('name');
				valor = $(per).find('input:checked').val();
				lista_permissoes[chave] = valor;
			})
		}

		if( dadoUsuario != false ){
			var pacote = {};

			if( tipo_acao == 'incluir' ){
				pacote = JSON.stringify({
					'acao': tipo_acao,
					'nome': dadoUsuario.formCadastro.nomeC,
					'nome_tratamento': dadoUsuario.formCadastro.nomeT,
					'email': dadoUsuario.formCadastro.email,
					'senha': dadoUsuario.formCadastro.senha,
					'acessoACK': $('.checkAcesso').find('input[type="radio"]:checked').val()
				});
			}
			else if(tipo_acao == 'editar' ){
				if( $('input[name="senhaNovaConf"]').val() != '' ){
					pacote = JSON.stringify({
						'acao': tipo_acao,
						'id': $('#id_usuario').val(),
						'nome': dadoUsuario.formCadastro.nomeC,
						'nome_tratamento': dadoUsuario.formCadastro.nomeT,
						'email': dadoUsuario.formCadastro.email,
						'senha': $('input[name="senhaNovaConf"]').val(),
						'permissoes': lista_permissoes,
						'acessoACK': $('.checkAcesso').find('input[type="radio"]:checked').val()
					});
				}
				else {
					pacote = JSON.stringify({
						'acao': tipo_acao,
						'id': $('#id_usuario').val(),
						'nome': dadoUsuario.formCadastro.nomeC,
						'nome_tratamento': dadoUsuario.formCadastro.nomeT,
						'email': dadoUsuario.formCadastro.email,
						'permissoes': lista_permissoes,
						'acessoACK': $('.checkAcesso').find('input[type="radio"]:checked').val()
					});
				}
			}

			$.ajax({
				url:  siteURL+'/ack/usuarios/salvar',
				type: 'POST',
				data: 'ajaxACK='+pacote,
				dataType: 'json',

				beforeSend: function(){
					if( tipo_acao == 'incluir' ){
						_abaLOAD({ mensagem: 'Criando usuÃ¡rio...' });
					} else if(tipo_acao == 'editar' ){
						if( $('input[name="senhaNovaConf"]').val() != '' ){
							_abaLOAD({ mensagem: 'Alterando senha!' });
						} else {
							_abaLOAD({ mensagem: 'Alterando dados do usuÃ¡rio...' });
						}
					}
				},
				success: function(data){
					dados = data;
					if( tipo_acao == 'incluir' ){
						dados['mensagem'] = 'UsuÃ¡rio criado com sucesso.';

					} else if(tipo_acao == 'editar' ){
						if( $('input[name="senhaNovaConf"]').val() != '' ){
							dados['mensagem'] = 'Senha alterada.';
							$('.field_editUser').find('button.editSenha').show();
							$('.field_editUser').find('div.fieldset').show();
						} else {
							dados['mensagem'] = 'Dados salvos com sucesso.';
						}
					}

					if( data != null || data == '0' || data == '' ){
						if ( tipo_acao != 'editar' ){
							$('input.dadosPagina').val(data.id);
							$('input#id_usuario').attr('value', data.id);

							$('.field_editUser').fadeIn('slow');
							$('.permissoes').fadeIn('slow', function(){
								$(this).children('.slide').slideDown();
								echoPermissoes(data.id);
							})
						}
					}
				},
				complete: function(){
					_abaLOAD({ mensagem:dados.mensagem, status:String(dados.status), remover:String(dados.status) });

					// oculta o campo alterar senha
					if( $('.field_editUser.editar').children('.fieldset').is(':visible') ){
						$('.field_editUser.editar').children('.fieldset').slideUp('fast');
						$('.field_editUser.editar').children('button.botao').removeClass('cancelEdid').addClass('editar').find('span > em').html('Alterar senha');
					}

					// Remove o alerta do lado do botao
					if( $('.save').is(':visible') ){
						$('.save').remove()
					}

					$('<div class="save '+ (( dados.status == '1' ) ? 'ok' : 'erro')  +'" style="display:none;"><em>'+ dados.mensagem +'</em></div>').appendTo('#footerPage').fadeIn(579, function(){
						temp_alerta = $(this);
						timer_save = setTimeout(function() {
							temp_alerta.delay(555).animate({ width:24, opacity:0 }, 'slow', function() { temp_alerta.remove() });
						}, 4500);
					})

					if ( tipo_acao != 'editar' ){
						window.location.replace( 'editar/'+$('input#id_usuario').val() );
						botao.attr('name', 'editar')
						return false;
					}
					$('#abaLoad').remove();
				}
			})
		}
	});
	// -------------------------------------
	if( $('#usuarios .field_editUser').hasClass('editar') ){
		$('.permissoes, .field_editUser').show()
		echoPermissoes( $('#id_usuario').val() )
	}
	// ------------------------------------- Exibe campos para editar senha
	$('#editarSenha').bind('click', function(){
		if( $(this).hasClass('editar') ){
			$(this).removeClass('editar').addClass('cancelEdid').find('span > em').html('Cancelar');
			$(this).next('.fieldset').slideDown('fast');
		} else {
			$(this).removeClass('cancelEdid').addClass('editar').find('span > em').html('Alterar senha');
			$(this).next('.fieldset').slideUp('fast');
		}
	});

	// ------------------------------------- Auto save permissoes
	$('.listaPermissoes').find('input[type="radio"]').bind('click', function(){
		var id_user = $('#id_usuario').val(),
			permissao_user = {};

		permissao_user[$(this).attr('name')] = $(this).val();

		var pacote = JSON.stringify({ acao:'save_permissoes', id:id_user, permissao:permissao_user });
		$.ajax({
			url:  siteURL+'/ack/usuarios/salvarPermissoes',
			type: 'POST',
			data: 'ajaxACK='+pacote,
			dataType: 'json',

			success: function(data){
				$('#loadAba').slideUp('fast', function(){ $(this).remove() });
			}
		});
	});





	/// -----------------------------------------------------------------------------------------------------------------------------------
	/// ---------------------------------------------------------------------------------------------------------------------|NOVO|--------
	/// -----------------------------------------------------------------------------------------------------------------------------------
	/* Função _alerta(field[Objeto jquery], mensagem[String]); */
	var _alerta = function( settings ){
		var info = $.extend({
					field: '',
					mensagem: '',
					status: 1
				}, settings);

		$('#alerta').remove();

		var icone = ( info.status == 0 ) ? 'ERRO' : 'OK';

		if ( info.field != '' ) {
			var posParent = info.field.parents('fieldset').offset().top;
			$('html, body').animate({ scrollTop:posParent }, 890);
		};

		// - verifica se o campo field "input, textarea, select..." nao foi indicado ------
		if ( info.field == '' ) {
			var parentAlert = $('button.salvar').parent('div'),
				mensagem    = $('<div id="alerta" class="'+icone+'"/>').html( info.mensagem );
		}
		else {
			// - verifica se o parent do field é um fieldset ou uma DIV .fieldset ---------
			if ( info.field.parents('fieldset, .fieldset').hasClass('fieldset') ) {
				var parentAlert = info.field.parents('.fieldset');
			}
			else {
				var parentAlert = info.field.parents('fieldset').children('legend, .legend');
			};

			var mensagem = (info.mensagem == '' || info.mensagem == null) ? '<samll id="alerta">O campo [ '+parentAlert.children('span, em').html()+' ] é obrigatorio.</small>' : '<samll id="alerta">'+info.mensagem+'</small>';
		};

		// - joga o alerta no parent indicado ---------------------------------------------
		parentAlert.append( mensagem );
		$('#alerta').fadeIn('fast');

		setTimeout(function(){
			$('#alerta').fadeOut('fast').promise().done(function(){
				$(this).remove();
			});
		}, 3200);
	};

	var _scamPage = function( settings ){
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

			//console.log( parentForm );

			if ( parentForm.attr('chave') != null ) {
				keyGrupo = parentForm.attr('chave');
			};

			// ---------- Cria o grupo principal do bloco encontrado, este nome Ã© definido apartir da segunda classe do bloco
			retorno[keyGrupo] = {};

			// Inclui a key ID no retorno quando o tipo da ação for EDITAR
			if (main.objPage.acao == 'editar' || main.objPage.id != 0) {
				if (retorno[main.objPage.arquivoRetorno] == null) {
					//console.log('A segunda classe da DIV.modulo não corresponde a key [arquivoRetorno] no input:hidden.infoPagina;');
				} else {
					retorno[main.objPage.arquivoRetorno]['id'] = main.objPage.id;
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

					//console.log( campo );

					// -- para IMGstcok ---- nao usar isso no ack default -- -- -- -- -- -- --
					if ( $(child).hasClass('imagens-fotografo') ) {
						var arrImagens = {};

						$.each($('.imagens-fotografo').find('li.linha'), function(idx, linha){
							var idCampo = $(linha),
								valor 	= idCampo.find('input[name="valor"]');

							if ( idCampo.find('input[name="checkLinha"]').is(':checked') ) {
								if ( valor.val() != '' ) {
									arrImagens[idCampo.attr('id')] = {};

									arrImagens[idCampo.attr('id')]['value'] = idCampo.find('input[name="valor"]').val();
									arrImagens[idCampo.attr('id')]['image_id'] = idCampo.attr('idImg');
									arrImagens[idCampo.attr('id')]['purchase_id'] = idCampo.attr('idVenda');
								}
								else { retorno = false; return false; };
							};
						});

						retorno[keyGrupo]['imagens'] = arrImagens;
					} else
					// -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- --


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

					// -- para IMGstcok ---- nao usar isso no ack default -- -- -- -- -- -- --
					else if ( $(child).hasClass('checkboxGruop') ) {
						$.each(campo, function(){
							var inputCheck = $(this),
								inputCname = inputCheck.attr('name');

							retorno[keyGrupo][inputCname] = (inputCheck.is(':checked')) ? true : false;
						});
					}
					// -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- --

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
						else if (required &&  valor == '' || valor == null) {
							_alerta({ field:campo });
							//_alerta(campo);
							retorno = false;
							return false;
						}
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

		// Percorre o conteudo de qualquer DIV indicada nas configuraÃ§Ãµes da funÃ§Ã£o
		if (info.apendice.length > 0) {
			retorno['apendice'] = {};

			$.each(info.apendice.children('input'), function(l, hide){
				var nome  = $(hide).attr('name'),
					value = $(hide).val();
				retorno['apendice'][nome] = value;
			});
		};

		return retorno;
	};

	var __save__ = function( settings ){
		var info    = $.extend({
				botao    : $('button.botao.salvar'),
				callback : '',
				refresh  : false
			}, settings),
			clicado = $(this);

		if( info.botao.attr('id') == 'salvartags' || info.botao.attr('id') == 'salvarimagens' ){
			var dados = _scamPage({ apendice:$('.ocultos'), wrapper:'fieldset, .scrollLista' });
		} else {
			var dados = _scamPage({ apendice:$('.ocultos') });
		}

		delete dados.upMidias;
		dados['acao'] = main.objPage.acao;

		if (dados == false) {
			//console.log('AJAX INTERROMPIDO.');
		} else {
			var charURL = '';

			if (main.objPage.tipo == 'categoria') {
				charURL = main.objPage.arquivoRetorno+'/categorias';
			} else {
				charURL = main.objPage.arquivoRetorno+'';
			};

			var pacote = JSON.stringify(dados);
			$.ajax({
				url : main.url+'/ack/'+charURL+'/salvar',
				type: 'POST',
				data: {ajaxACK:pacote},
				dataType: 'json',

				beforeSend: function(){
					overlay.css({ zIndex:999999, background:'url('+main.url+'/img/site/filtro_b6.png) left top' }).appendTo('body');
					$('.alerta-status').remove();
				},
				success:    function( data ){
					if ( typeof(data) != 'object' || data == null ) {
						alert( 'Retorno inesperado do JSON' );
						$('#overlay').remove();
					}
					else if ( data.status != 0 ) {
						if ( main.objPage.acao != 'editar' ){
							if ( main.browser == 'explorer' || info.refresh || dados.acao == 'incluir' ) {
								window.location.href = main.url+'/ack/'+charURL+'/editar/'+data.id;
							}
							else {
								window.history.replaceState("string", 'ACK', main.url+'/ack/'+charURL+'/editar/'+data.id );
								$('input#infoPagina').data('info')['id'] = data.id;
								$('.modulo:hidden').fadeIn('fast');
								return false;
							}
						};

						if ( $('textarea[name="comentario_licenca"]').val() != '' ) {
							$('textarea[name="comentario_licenca"]').attr('disabled', 'disabled').val('').parents('fieldset').hide();
							testValue = $('select[name="status_id"]').val();
						};
					};

					if ( data.status != 0 ) {
						_alerta({ mensagem:data.mensagem, status:data.status });
						//_alerta( data.mensagem, data.status );
					}
					else {
						$('#footerPage').append('<div class="alerta-status ERRO"><span>'+ data.mensagem +'</span></div>');
					};

					// ---- troca o status do menu de idiomas quando alguma informação for salva
					if( Object.size(data.conteudoIdioma) > 0 && $('.menuIdiomas').length == 0 ){
						//console.log('Menu idioma não encontrado.');
					}
					else if( $('.menuIdiomas').length > 0 && Object.size(data.conteudoIdioma) > 0 ){
						$.each(data.conteudoIdioma, function(id_cont, id_ok){
							if (id_ok == 1) { $('.menuIdiomas-innner > div').children('button[name="'+id_cont+'"]').addClass('completo'); }
							else			{ $('.menuIdiomas-innner > div').children('button[name="'+id_cont+'"]').removeClass('completo'); };
						});
					}

					setTimeout(function(){
						$('.alerta-status').fadeOut('fast', function(){ $(this).remove(); });
					}, 3000);
				},
				complete:   function( data ){
					if (main.objPage.acao == 'incluir' || main.objPage.acao == 'salvar') {
						main.objPage.acao = 'editar';
					};
					// ---- Quando o parametro 'callback' for de finido e com uma função a mesma será executada.
					if ( typeof(info.callback) == 'function' ) {
						info.callback();
					} else {
						$('#overlay').remove();
					};
				}
			});
		};
	};

	/* ----- Recebe como retorno do JSON um 'array' onde as KEYs sao a propriedade 'name' dos campos. Somente as KEYs com a sintaxe '[name]_[abreviatura do idioma]' serao afetados. ----- */
	var __load__ = function( settings ){
		var info    = $.extend({
				idioma: 'en',
				anterior: 'pt',
				id: 00
			}, settings),
			dados   = {'idioma':info.idioma, 'id':info.id},
			clicado = $('.menuIdiomas-innner > div').children('button[name="'+info.idioma+'"]');

		if (main.objPage.tipo == 'categoria') {
			dados['categoria'] = 1;
			var charURL = main.objPage.arquivoRetorno+'/categorias';
		} else {
			var charURL = main.objPage.arquivoRetorno+'';
		};

		var pacote = JSON.stringify(dados);
		$.ajax({
			url:   main.url+'/ack/'+charURL+'/trocaIdioma',
			type: 'POST',
			data: {ajaxACK:pacote},
			dataType: 'json',

			beforeSend: function(){},
			success:    function( data ){
				if ( data == null ) {
					console.log('Erro no retorno do JSON!');
					return false;
				}
				else {
					if ( info.idioma == 'pt' ) {
						$('.legend > strong, legend > strong').html('[Português - PT]');
					} else if ( info.idioma == 'en' ) {
						$('.legend > strong, legend > strong').html('[Inglês - EN]');
					};




					if (data.status == 1) {
						$.each(data.dados, function(nameC, valC){
							var newName  = nameC.split('_')[0]+'_'+info.idioma,
								oldName  = nameC.split('_')[0]+'_'+info.anterior;

							if ( nameC == newName ) {
								$('*[name="'+oldName+'"]').attr('name', newName);
							};

							if ( data.dados[newName] == null ) { var novoValor = ''; }
							else							   { var novoValor = data.dados[newName]; };

							$('*[name="'+newName+'"]').val(novoValor);
						});

						clicado.addClass('onView').siblings('button').removeClass('onView');
					};
				};
			},
			complete:   function( data ){
				$('#overlay').remove();
			}
		});
	};


	// ----- função _scamPage() é executada quando o botao .salvar for clicado
	$('.botao.salvar').on('click', function(){
		if ( $(this).attr('id') == 'salvarimgusuarios' ) {
			__save__({ botao:$(this), refresh: true });
		}
		else {
			__save__({ botao:$(this) });
		};
	});




	/// ---------------------------------|||||---------------------------------|||||---------------------------------|||||
	var _carregarMais = function( settings ){
		var info = $.extend({
				'botao'   : '', // importante
				'to_json' : '', // Dados extra que devem ser mandados para o php
				'tipo'    : 'normal',
				'url_view': 'editar', // Tipo de visualização "editar"/padrao ou "visualizar"
				'markup_ordenador': '<div class="ordenadores">\
										<button title="Mover para cima" class="btnOrdem btn_goTopo" posicao="{ORDEM}"><img width="13" height="7" alt="▲" src="'+main.url+'/ack-core/images/icon_setaToTopo.png" /></button>\
										<button title="Mover para baixo" class="btnOrdem btn_goFundo" posicao="{ORDEM}"><img width="13" height="7" alt="▼" src="'+main.url+'/ack-core/images/icon_setaToFundo.png" /></button>\
									</div>'
			}, settings);

		// --- desabilita temporariamente o botao clicado -----
		info.botao.attr('disable');

		// --- Se o botao carregar mais nao foi indicado toda a função para porque sem esta informação outros dados nao serão encontrados -----
		if (info.botao == '' || info.botao == null) {
			//console.log('parametro "botao" nao foi definido na chamada da função!');
			return false;
		};

		var wrapper    = info.botao.parents(main.parent.listas),
			cabecalho  = wrapper.children('.header').children('div').children(),
			container  = wrapper.children('ol'),
			header_key = {'indexCol':Array(), 'normal':Array(), 'ordem':Array(), 'texto':Array(), 'ignore':Array(), 'width':Array()},
			dados      = {'modulo':main.objPage.modulo, 'action':'carregarMais'},
			myURL      = (main.objPage.tipo == 'categoria') ? main.url+'/ack/'+main.objPage.arquivoRetorno+'/categorias/' : main.url+'/ack/'+main.objPage.arquivoRetorno;
			myURL2     = (main.objPage.tipo == 'categoria') ? main.url+'/ack/'+main.objPage.arquivoRetorno+'/categorias/' : main.url+'/ack/'+main.objPage.arquivoRetorno;

		// --- Reorganiza o objeto passado em 'obj', na mesma ordem do array passado em 'arr' -----
		var _sort_by_arr = function(obj, arr){
			var newObj = {}, objSize = Object.size(arr);
			for(var j=0; j<objSize; j++){
				newObj[arr[j]] = obj[arr[j]];
			};
			return newObj;
		};

		// --- Função que cria o HTML das listas -----
		var _magikLine  = function (arrReturn){
			var grupo   = arrReturn.grupo,
				retorno = {};

			// ----- Cria um Array() temporario no objeto MAIN, para listas os dados das linhas -----
			if (main.lista == null) { main['lista'] = {}; };

			$.each(grupo, function(i, linha){
				// ---------- loop por cada item do array ----------
				var colunas   = $('<li />').addClass('linha').attr('id', linha.id).css({ 'float':'left', 'width':'100%' }).html($('<div />')),
					newURL    = myURL2+'editar/'+linha.id,
					visivelOK = (linha.visivel == null) ? linha.visible : linha.visivel,
					sortLinha = _sort_by_arr(linha, header_key.indexCol),
					idLINHA   = "'"+linha.id+"'",
					showCell  = ( linha.status != null ) ? linha.status : 1; // Define se o checkbox para a exclusao vai ser mostrado


				// - para imgstock, nao usar no ack default
				if ( linha.acessoack != null ) {
					visivelOK = (linha.acessoack == null) ? linha.acessoack : linha.acessoack,
					showCell  = ( linha.acessoack != null ) ? 0 : 1;
				};

				if ( linha.resolvido != null && linha.resolvido == '' || linha.resolvido == 0 ) {
					colunas.addClass('destacado');
				};

				// ---- inclui os dados da linha no array, usando o ID como key
				if (main.lista != null) { main['lista'][idLINHA] = linha[header_key.indexCol[1]]; };

				$.each(sortLinha, function(j, coluna){
					// ---------- loop por cada elemento do item, clasificando o elementos por KEY ----------
					var celula   = $('<div class="'+j+'">').css({ 'float':'left', 'width':header_key.width[j] }),
						conteudo = (j != 'id' && coluna == '') ? '<i style="color:#ccc;font-size:11px;">Dado não cadastrado</i>' : coluna;

					if ( conteudo != null && conteudo.length > (Number(header_key.width[j]) /6) ) {
						var total = Math.floor( Number(header_key.width[j]) /6 );
						conteudo  = conteudo.substr(0, total)+"...";
					};

					if ( linha.url_linha != null || linha.url_linha != '' ) {
						newURL = linha.url_linha;
					};

					// --------------- Linhas com uma ancora para a pagina de edição do conteudo
					if ($.inArray(j, header_key.ignore) != -1) {
						return;
					}
					// --------------- Checkbox usado para excluir um ou mais itens da lista quando marcado ---------------------------------------------------------------------------
					else if (j == 'id' && $.inArray('checkGrupo', header_key.ignore) == -1) {
						if (showCell != 'false') {
							colunas.children().append( celula.html('<span class="checkLinha"><input type="checkbox" value="'+conteudo+'" name="checkLinha"></span>') );
						} else {
							//console.log( 'Checkbox removido desta da linha ['+ linha[header_key.indexCol[1]] +']' );
							colunas.children().append( celula.html('<span class="checkLinha-fake"><span>[-]</span></span>') );
						};
					}
					// --------------- Visivel personalizado ACK, para edição rapida direto na listagem
					else if (j == 'visivel' || j == 'visible' && $.inArray(j, header_key.ignore) == -1) {
						if (showCell != 'false') {
							var checked      = (visivelOK == 0) ? '' : ' ok',
								checkedClass = (visivelOK == 0) ? '' : 'checked="checked"',
								visivelDIV   = '<div class="checkboxACK"><i class="'+j+' '+checked+'"><input type="checkbox" value="'+linha.id+'" '+checkedClass+' name="'+main.objPage.modulo+'" /></i></div>';
							colunas.children().append( celula.html(visivelDIV) );
						}
						else {
							//console.log( 'Campo visivel removido da linha ['+ linha[header_key.indexCol[1]] +']' );
							colunas.children().append('<div class="checkboxACK-fake"><span>[-]</span></div>');
						};
					}

					// ---------------== Para IMGSTOCK, nao usar no ACK-default ==---------------------------------------
					else if (j == 'acessoack_str' && $.inArray(j, header_key.ignore) == -1) {
						if ( showCell != 'false' ) {
							var checked      = (visivelOK == 0) ? '' : ' ok',
								checkedClass = (visivelOK == 0) ? '' : 'checked="checked"',
								visivelDIV   = '<div class="checkboxACK"><i class="'+j+' '+checked+'"><input type="checkbox" value="'+linha.id+'" '+checkedClass+' name="'+main.objPage.modulo+'" /></i></div>';
							colunas.children().append( celula.html(visivelDIV) );
						}
						else {
							//console.log( 'Campo visivel removido da linha ['+ linha[header_key.indexCol[1]] +']' );
							colunas.children().append('<div class="checkboxACK-fake"><span>[-]</span></div>');
						};
					}
					// ---------------== Para IMGSTOCK, nao usar no ACK-default ==---------------------------------------

					// --------------- Linhas com uma ancora para a pagina de edição do conteudo
					else if ($.inArray(j, header_key.normal) != -1) {
						colunas.children().append( celula.html($('<a />').attr('href', newURL).html(conteudo)) );
					}
					// --------------- Linhas com as setas de ordenação
					else if ($.inArray(j, header_key.ordem) != -1) {
						var posicao = (linha.ordem == null || linha.ordem == '') ? (i +1) : linha.ordem;
						colunas.children().append( celula.append( $('<a />').attr('href', newURL).html(conteudo), info.markup_ordenador.replace(/{ORDEM}/g, posicao) ) );
					}
					// --------------- Linhas com somente texto, sem ancora
					else if ($.inArray(j, header_key.texto) != -1) {
						colunas.children().append( celula.html($('<span />').html(conteudo)) );
					}
					else {
						return;
					}
				});// END
				container.append(colunas);
			});// END

			if (arrReturn.exibir_botao == 0) {
				info.botao.hide();
			} else {
				info.botao.show();
			};
		};

		/*
		• Organiza cada classe/coluna em um grupo diferente, cada grupo define como as linhas serao
		• montadas com ancora ou somente texto ou com as setas de ordenação, isso é definido pela terceira classe das colunas do cabeçalho da lista;
		• aqui tambem é definido pela segunda classe a largura FIXA das colunas
		*/
		$.each(cabecalho, function(i, coluna){
			var arrClass = $(coluna).attr('class').split(' ');

			if (arrClass[0] == 'checkGrupo') {
				header_key.width['id'] = arrClass[1]; // Largura da coluna, segunda classe
				header_key.indexCol.push('id'); // Ordem da coluna, mesma ordem que estive no cabeçalho da listagem
			} else {
				header_key.width[arrClass[0]] = arrClass[1];
				header_key.indexCol.push(arrClass[0]);
			};

			if (/[^\d,]+/g.test(arrClass[1])) {
				console.log( 'A segunda classe do item ['+arrClass[0]+'] não é NUMERICA, por tanto nao terá sua largura definida;' );
			} else {
				$(coluna).css({ 'width':arrClass[1] });
			};

			if (arrClass[2] == 'txt')      { header_key.texto.push(arrClass[0]); }
			else if (arrClass[2] == 'ord') { header_key.ordem.push(arrClass[0]); }
			else if (arrClass[2] == 'non') { header_key.ignore.push(arrClass[0]); }
			else                           { header_key.normal.push(arrClass[0]); };
		});

		// inclui a informação extra passada pelo parametro 'to_json'
		//if (info.to_json != '') { dados['apendice'] = info.to_json; };
		if (info.to_json != '') { $.extend(dados, info.to_json); };

		// Completando 'dados' com os dados exigidos pelo php para retornar a lista de itens cadastrados
		dados['qtd_itens'] = container.children('li').length;

		if (dados.modulo == '' || dados.modulo == null) {
			//console.log( '[ERRO]; "modulo" não esta definido' );
			return false;
		};

		if ( info.tipo == 'filtro' ) {
			dados['qtd_itens'] = 0;
		};

		var pacote = JSON.stringify(dados);
		$.ajax({
			/*url: siteURL+'/ack/ajax',*/
			url: myURL+'/routerAjax',
			type: 'POST',
			data: {'ajaxACK':pacote},
			dataType: 'json',

			beforeSend: function(){
				if ( info.tipo == 'filtro' ) {
					$('.lista ol').css({ background:'url('+siteURL+'/ack-core/images/gif-load-list.gif) no-repeat center center' }).children('li').stop(true).animate({ opacity:0.4 }, 'fast');
				};
			},
			success:    function(data){
				if (typeof(data) != 'object') {
					console.log( "Retorno extranho do JSON!" );

				} else {
					if (data.status == '0' || data.status == 0) {
						console.log( 'Sem item para mostrar!');

					} else {
						if ( info.tipo == 'filtro' ) {
							$('.lista ol').css({ background:'' }).children('li').remove();
							$('input, button, select').removeAttr('disabled');
						};

						_magikLine(data);
						info.botao.removeAttr('disable', 'disable');
					};
				}
			},
			complete:   function(){
				disableArrow();
			}
		});
	};

	// ----- Executa a função carregarMais quando um botao .carregarMais for encontrado na pagina
	if ($(main.botao.carregarM).length > 0) {
		_carregarMais({ botao:$(main.botao.carregarM) });
	};



	// ----- A mesma função é chamado quando o botao .carregarMais é clicado - alterado -
	$('body').on('click', main.botao.carregarM, function(){
		var clicado = $(this);

		if ( clicado.hasClass('clicado') ) {
			var dadosLog   = {},
				quantidade = $('.cadastrosSite ol').find('li').size();

				dadosLog['filtro'] = {};

			$('.collumB').find('select').each(function(sel_idx, sel_val){
				nameSelc = $(sel_val).attr('id');
				valSelc  = $(sel_val).val();

				if(valSelc != '' ){
					dadosLog['filtro'][nameSelc] = valSelc;
				};
			});

			_carregarMais({
				botao: clicado,
				to_json: dadosLog,
				tipo: 'filtro'
			});
		}
		else if ( $('*[chave="filtros"]').length > 0 ) {
			var clicado = $('button.botao.filtro'),
				filtros = _scamPage({ container: $('.filter-results-options.filter-form .field-block') });

			if ( filtros != false ) {
				_carregarMais({
					botao: $('.carregarMais'),
					to_json: filtros
				});
			};
		}
		else {
			_carregarMais({ botao:clicado });
		};
	});


	/* ---------- Função para reordenar item em uma lista ---------- */
	$.fn.reOrdene = function( setting ){
		var $this = $(this),
			pos   = Number($this.attr('posicao')),
			linha = $this.parents('li.linha'),

			parent = linha.parent(),
			prevLI = parent.children('li').eq(linha.index() - 1),
			proxLI = parent.children('li').eq(linha.index() + 1);


		if( $this.hasClass('btn_goTopo') ){
			var newPos = Number(prevLI.find('.btnOrdem').attr('posicao')),
				dados  = {'acao':'trocaOrdem', 'id':linha.attr('id'), 'id_antigo':prevLI.attr('id'), 'valorAntigo':pos, 'valorNovo':newPos};
		}
		else if( $this.hasClass('btn_goFundo') ){
			var newPos = Number(proxLI.find('.btnOrdem').attr('posicao')),
				dados  = {'acao':'trocaOrdem', 'id':linha.attr('id'), 'id_antigo':proxLI.attr('id'), 'valorAntigo':pos, 'valorNovo':newPos};
		};


		if ( main.objPage.tipo != '' || main.objPage.tipo != null ) {
			dados['categoria'] = 1;
			var charURL = '/'+main.objPage.arquivoRetorno;
		} else {
			var charURL = '/';
		};


		var pacote = JSON.stringify(dados);
		$.ajax({
			url: main.url+'/ack'+charURL+'/trocaOrdem',
			//url: main.url+'/ack'+charURL+'/routerAjax',
			type: 'POST',
			data: {ajaxACK:pacote},
			dataType: 'json',

			beforeSend: function(){
				$('.btnOrdem').attr('disabled', 'disabled');
			},
			success:    function( data ){
				if ( data.status == 1 ) {
					if( $this.hasClass('btn_goTopo') ){
						linha.find('.btnOrdem').attr('posicao', newPos);
						prevLI.find('.btnOrdem').attr('posicao', pos);

						parent.children('li').eq(linha.index()).after(prevLI);
					}
					else if( $this.hasClass('btn_goFundo') ){
						linha.find('.btnOrdem').attr('posicao', newPos);
						proxLI.find('.btnOrdem').attr('posicao', pos);

						parent.children('li').eq(linha.index()).before(proxLI);
					};

					disableArrow();
				};
			}
		});
	};

	$('.lista').on('mouseup', '.btnOrdem', function(){
		$(this).reOrdene();
	});
	/// ---------------------------------|||||---------------------------------|||||---------------------------------|||||




	$(main.parent.listas).children('ol').on('change', 'input[name="checkLinha"]', function(){
		var idLINHA = "'"+$(this).val()+"'";

		if (main['excluir'] == null) { main['excluir'] = Array(); };

		if ($(this).is(':checked')) {
			main['excluir'].push( $(this).val() );
		} else {
			main.excluir.remove( $(this).val() );
		};
	});
	// ----- Selecionar todos os item da linhas
	$('input[name="checkAll"]').bind('click', function(){
		delete main.excluir;
		if (main['excluir'] == null) { main['excluir'] = Array(); };

		if( $(this).is(':checked') ){
			$(this).closest(main.parent.listas).find('ol').find('li').each(function(){
				$(this).find('input[name="checkLinha"]').attr('checked', 'checked');
				main['excluir'].push( $(this).find('input[name="checkLinha"]').val() );
			});
		}
		else {
			$(this).closest(main.parent.listas).find('ol').find('li').each(function(){
				$(this).find('input[name="checkLinha"]').removeAttr('checked');
				delete main.excluir;
			});
		}
	});

	// ----- Clique no botao excluir
	$(main.botao.excluir).bind('click', function(){
		var lista 		= $('.lista'),
			itemChecked = $('.lista').find('input[name="checkLinha"]:checked').length,
			nomeItens   = Array();

		$.each($('.lista').find('input[name="checkLinha"]:checked'), function(idx, elm){
			var contentNome = $('li#'+$(elm).val()).children('div').children()[1];

			if ( $(contentNome).children().html() == '' || $(contentNome).children().html() == null ) {
				var thisNome = $(contentNome).attr('class');
			} else {
				var thisNome = $(contentNome).children().html();
			};
			nomeItens.push( thisNome );
		});

		if (main.excluir == null) {
			alert( 'Não há item para excluir' );
		} else {
			if( nomeItens.length >= 1 && nomeItens.length <= 4 ){
				var msg = 'Deseja realmente excluir <b>'+nomeItens.toString()+'</b>?';
			} else if( main.excluir.length >= 5 ){
				var msg = '<b>'+ nomeItens.length +'</b> itens foram selecionados, deseja realmente excluilos?';
			}

			if( $('.filtroCategorias').is(':visible') && nomeItens.length > 1 ){
				msg += '<br />Estes itens serao excluidos de todas as categorias vinculadas a eles.';

			} else if( $('.filtroCategorias').is(':visible') && nomeItens.length == 1 ){
				msg += '<br />Este item serÃ¡ excluido de todas as categorias vinculadas a ele.';
			}

			montaMODAL({
				titulo: 'Excluir iten(s) da lista, '+$('#descricaoPagina h2').html(),
				texto : msg,
				input : 'itensChecked'
			});
		};
	});

	// ----- Confirma a exclusao
	$('body').on('click', '.confirma', function(){
		if (main.objPage.tipo == 'categoria') {
			var myURL = main.url+'/ack/'+main.objPage.arquivoRetorno+'/categorias/excluir';
		} else {
			var myURL = main.url+'/ack/'+main.objPage.arquivoRetorno+'/excluir';
		};

		var pacote = JSON.stringify({ 'selecionados':main.excluir });
		$.ajax({
			url : myURL,
			type: 'POST',
			data: 'ajaxACK='+pacote,
			dataType: 'json',

			success:  function(data){
				if (data == null || typeof(data) != 'object') {
					console.log( 'Retorno inesperado do JSON' );
				}
				else if(data.status == '0' || data.status == 0) {
					console.log( 'Erro: nao foi possivel excluir os itens selecionados.' )
					$('#ack_modal .content').fadeOut('fast', function(){ $(this).parents('#ack_modal').fadeOut('fast', function(){ $(this).remove() }) });
				}
				else if(data.status == '1' || data.status == 1) {
					for(var i=0; i<main.excluir.length; i++){
						$('li#'+main.excluir[i]).fadeOut('fast').promise().done(function(){ $(this).remove(); });
					}
					$('#ack_modal .content').fadeOut('fast', function(){ $(this).parents('#ack_modal').fadeOut('fast', function(){ $(this).remove() }) });
				};
			}
		});
	});

	// ----- Ignora a exclusao
	$('body').on('click', '.ignora', function(){
		$('#ack_modal .content').fadeOut('fast', function(){ $(this).parents('#ack_modal').fadeOut('fast', function(){ $(this).remove() }) });
	});


	/* ----- Trocar o status de visivel das listagens ----------- */
	$('.lista').on('click', '.visivel input, .visible input', function(){
		var clicado = $(this),
			idLinha = clicado.val(),
			status  = (clicado.is(':checked')) ? 1 : 0,
			catPage = (main.objPage.tipo == 'categoria') ? true : false,
			myURL   = (main.objPage.tipo == 'categoria') ? main.url+'/ack/'+main.objPage.arquivoRetorno+'/categorias/' : main.url+'/ack/'+main.objPage.arquivoRetorno+'/';

		if (main.objPage.tipo == 'categoria') {
			var dados = {'id':idLinha, 'status':status, 'categoria':catPage};
		} else {
			var dados = {'id':idLinha, 'status':status};
		}

		var pacote = JSON.stringify(dados);
		$.ajax({
			url: myURL+'visivel',
			type: 'POST',
			data: {ajaxACK:pacote},
			dataType: 'json',

			beforeSend: function(){},
			success:    function(data){
				if (data.status == 1) {
					if (status == 1) {
						clicado.attr('checked', 'checked');
						clicado.parent('.visivel, .visible').addClass('ok');
					}
					else if (status == 0) {
						clicado.removeAttr('checked');
						clicado.parent('.visivel, .visible').removeClass('ok');
					}
				}
				else if (data.status == 0) {
					//console.log( 'Erro, visibilidade nao alterada!' );
				};
			},
			complete:   function(){}
		});
	});

	/* ----- Trocar o status de visivel das listagens ----------- */
	$('.checkVisivel').on('click', 'label input', function(){
		var clicado = $(this),
			status  = clicado.val(),
			dados   = {'id':main.objPage.id, 'status':Number(status)},
			myURL   = (main.objPage.tipo == 'categoria') ? main.url+'/ack/'+main.objPage.arquivoRetorno+'/categorias/visivel' : main.url+'/ack/'+main.objPage.arquivoRetorno+'/visivel',

			pacote  = JSON.stringify(dados);
		$.ajax({
			url: myURL,
			type: 'POST',
			data: {ajaxACK:pacote},
			dataType: 'json',

			beforeSend: function(){},
			success:    function(data){},
			complete:   function(){}
		});
	});


	/* ----- Troca de idiomas ----------- */
	$('.menuIdiomas-innner').on('click', 'button', function(){
		var clicado   = $(this),
			anterior  = clicado.siblings('button').attr('name')
			idiomaSel = clicado.attr('name');

		__save__({
			botao:    $(this),
			callback: function(){
				__load__({ 'idioma':idiomaSel, 'id':main.objPage.id, 'anterior':anterior });
			}
		});
	});


	/* ----- Filtro para as listas ----------- */
	$('.botao.filtro').on('click', function(){
		var clicado = $(this),
			filtros = _scamPage({
				container: $('.filter-results-options.filter-form .field-block')
			});

		if ( filtros != false ) {
			$('input, button, select').attr('disabled', 'disabled');

			_carregarMais({
				botao: $('.carregarMais'),
				to_json: filtros,
				tipo:'filtro'
			});
		};
	});
	/// -----------------------------------------------------------------------------------------------------------------------------------
	/// ---------------------------------------------------------------------------------------------------------------------|NOVO|--------
	/// -----------------------------------------------------------------------------------------------------------------------------------









	////////// Exclui item(s) marcados na lista atravez do ID indicado //////////////////////////////////////
	// ------------------------------------- Excluir interno
	$('#excluirContato').bind('click', function(){
		var itensChecked = Array($('input#nome').val()),
			nomeChecked  = Array($('input#nome').attr('class'));

		montaMODAL({
			titulo: 'Deseja excluir o contato de "'+ $('input#nome').attr('class') +'"?',
			texto: '',
			input: itensChecked
		});
	});


	////////// Filtro para a listagem de cadastro no site Santa Clara ///////////////////////////////////////
	$('.cadastrosSite select').bind('change', function(){
		returnGrup = {};
		listados   = $('.cadastrosSite ol').find('li').size();

		$('.cadastrosSite .collumB').find('fieldset').each(function(idx, val){
			nameSel = $(val).find('select').attr('name')
			valSel  = $(val).find('select').val()

			if(valSel != '' ){ returnGrup[nameSel] = valSel;}
		})

		$(main.parent.listas).find('ol').slideUp('fast', function(){
			$(this).html('');

			$(this).promise().done(
				CarregarMais({
					botao: $('.carregarMais'),
					modulo: 'cadastros',
					emLista: 0,
					apendice: returnGrup,
					chaveApe: 'categorias'
				})
			)
		}).slideDown('slow');
	});
	// -------------------------------------
	$('.btnAlterar, .alterarSenha').bind('click', function(){
		modulo  = $('input[type="hidden"].dadosPagina').attr('id');
		idLinha = ( $('.cadastrosSite').length > 0 ) ? $(this).parents('li').attr('id') : $('input[type="hidden"].dadosPagina').val();

		pacote  = JSON.stringify({ 'acao':'novaSenha', 'modulo':modulo, 'id':idLinha });
		$.ajax({
			url: siteURL+'/ack/ajax',
			type: 'POST',
			data: {ajaxACK:pacote},
			dataType: 'json',

			beforeSend: function(){
				//LoaderBar({ mensagem:'Carregando lista...' });
			},
			success:    function(data){
				$('<div class="save ok" style="display:none;"><em>Nova senha enviada para o e-mail cadastrado.</em></div>').appendTo('#footerPage').fadeIn(579, function(){
					temp_alerta = $(this);
					temp_alerta.animate({ width:250 }, 'slow', function(){
						timer_save = setTimeout(function() {
							temp_alerta.animate({ width:24, opacity:0 }, 'slow', function() { temp_alerta.remove() });
						}, 1900);
					})
				});
			},
			complete:   function(){
				$('#abaLoad').remove();
			}
		});
	});

	////////// FEXA JANELA DE AJUDA ///////////////////////////////////////
	$('body').on('click', '.janelaAjuda .excluir', function(){
		var clicado = $(this),
			parentBox = clicado.parents('.janelaAjuda');

		parentBox.fadeOut('fast', function(){ $(this).remove(); })
	})


	////////// LOG | trocar USUARIO/PERIODO ///////////////////////////////////////
	$('.collumB').on('change', 'select', function(){
		var dadosLog   = {},
			quantidade = $('.cadastrosSite ol').find('li').size();

			dadosLog['filtro'] = {};

		$('.collumB').find('select').each(function(sel_idx, sel_val){
			nameSelc = $(sel_val).attr('id');
			valSelc  = $(sel_val).val();

			if(valSelc != '' ){
				dadosLog['filtro'][nameSelc] = valSelc;
			};
		});

		_carregarMais({
			botao: $('.carregarMais'),
			to_json: dadosLog,
			tipo: 'filtro'
		});
	});


	////////// Abre modal para digitar uma data de referencia para exportar lista de newsletter ////////////
	$('#exportarLista').bind('click', function(){
		montaMODAL({
			largura: 300,
			altura: 90,
			new_markup: '<fieldset class="form"><div class="legend"><span>Digite uma data inicial.</span></div><input type="date" name="dataInicio" maxlength="10" /></fieldset>',
			markup_xcluir: '<button class="botao exportar" id="exportarNews" title="Exportar lista"><span><var></var><em>Exportar lista</em></span><var class="borda"></var></button>'
		})
	});
	/* ------------------------------------- EVENTO para download */
	$('button[name="exportar"], #exportarNews').bind('click', function(e){
		var modulo     = $('input[type="hidden"].dadosPagina').attr('id'),
			returnGrup = {};

		if( $('input[name="dataInicio"]').val() != '' ){
			pacote = {'categorias':$('input[name="dataInicio"]').val()};

		} else {
			_focusField({ campo:$('input[name="dataInicio"]'), mensagem:'ObrigatÃ³rio!' })
			return false;
		}

		$.download = function(url, data, method){
			if( url && data ){
				data = typeof(data) == 'string' ? data : jQuery.param(data);
				var inputs = '';

				jQuery.each(data.split('&'), function(){
					var pair = this.split('=');
					inputs+='<input type="hidden" name="'+ pair[0] +'" value="'+ pair[1] +'" />';
				})
				jQuery('<form action="'+ url +'" method="'+ (method||'post') +'">'+inputs+'</form>').appendTo('body').submit().remove();
			}
		}

		$.download(siteURL+'/ack/'+modulo+'/exportar', pacote, 'POST');
	});


	////////// Evento somente para IMGSTOCK - Não incluir no ack default ////////////
	// - se o campo estiver na pagina
	if ( $('select[name="status_id"]').length ) {
		var testValue = $('select[name="status_id"]').val();

		$('select[name="status_id"]').bind('change', function(){
			var novoValor = $(this).val();

			if ( testValue != novoValor && novoValor == 3 || novoValor == 2 ) {
				$('textarea[name="comentario_licenca"]').removeAttr('disabled').attr('required', 'required').parents('fieldset').show();
			} else {
				$('textarea[name="comentario_licenca"]').attr('disabled', 'disabled').removeAttr('required').parents('fieldset').hide();
			};
		});
	};

	// - checkbox de confirmacao de acesso ao ACK
	$('.lista').on('click', 'input[name="usuarios_ack"]', function(){
		var marcado = $(this),
			this_status = (marcado.is(':checked')) ? 1 : 0;

		var dados = JSON.stringify({ 'id':marcado.val(), 'status':this_status });
		$.ajax({
			url: siteURL+'/ack/usuarios/acessoAck',
			type: 'POST',
			data: {ajaxACK:dados},
			dataType: 'json',

			beforeSend: function(){
				overlay.css({ zIndex:999999, background:'url('+main.url+'/img/site/filtro_b6.png) left top' }).appendTo('body');
				$('.alerta-status').remove();
			},
			success:    function( data ){
				if (data.status == 1) {
					if ( this_status == true ) {
						marcado.attr('checked', 'checked');
						marcado.parent('.acessoack_str').addClass('ok');
					} else {
						marcado.removeAttr('checked');
						marcado.parent('.acessoack_str').removeClass('ok');
					}
				};

				$('#overlay').remove();
			},
			complete:   function(){}
		});
	});

	// Capo de data de agendamento
	$('input[name="data_agendamento"]').attr('disabled', 'disabled');

	$('select[name="venda_status"]').bind('change', function(){
		var agendamento = $(this);

		if ( agendamento.val() == 1 ) {
			$('input[name="data_agendamento"]').attr('disabled', 'disabled');
		} else if ( agendamento.val() == 0 ) {
			$('input[name="data_agendamento"]').removeAttr('disabled');
		};
	});


	// para imgstock, fotografos --------------------------------------------------
	$('.pagamentosdefotografos').on('change', 'select[name="user_id"]', function(){
		var selecionado = $(this);

		$('.lista.lista-imagens-fotografo').on('change', 'input[type="checkbox"]', function(){
			var checkbox = $(this),
				parentLi = $('#'+checkbox.val());
			if ( checkbox.is(':checked') ) {
				parentLi.find('input[name="valor"]').removeAttr('disabled');
			} else {
				parentLi.find('input[name="valor"]').attr('disabled', 'disabled').val('');
			};
		});

		if ( selecionado.val() != 0 ) {
			var pacote = JSON.stringify({ 'action':'infoFotografo', 'id':selecionado.val() });
			$.ajax({
				url: main.url+'/ack/pagamentosdefotografos/routerAjax',
				type: 'POST',
				data: {ajaxACK:pacote},
				dataType: 'json',

				beforeSend: function(){
					$('.lista-imagens-fotografo').find('ol').html('');
				},
				success:    function( data ){
					if ( data.status == 1 ) {
						$('select[name="moeda"]').removeAttr('disabled').val(data.moeda);

						var newLi = '';
						$.each(data.imagens, function(idx, elm){
							newLi += '<li class="linha" id="'+elm.id+'" idImg="'+elm.imagem_id+'" idVenda="'+elm.purchase_id+'">\
										<div>\
											<div class="id" style="width:20px;"> <span class="checkLinha"><input type="checkbox" name="checkLinha" value="'+elm.id+'"></span> </div>\
											<div class="titulo" style="width:260px;"> <span>'+elm.titulo+'</span> </div>\
											<div class="valor"  style="width:100px;"> <input type="text" disabled="disabled" name="valor" placeholder="valor da imagem" /> </div>\
											<div class="editar" style="width:60px;"> <a href="'+elm.url+'" target="_blank">Ver imagem</a> </div>\
											<div class="editar" style="width:80px;"> <a href="'+siteURL+'/ack/comprasdeimagens/editar/'+elm.purchase_id+'" target="_blank">Ver venda</a> </div>\
										</div>\
									</li>';
						});

						if ( data.imagens == '' ) {
							newLi = '<li class="linha"><div><div class="titulo"> <span>Sem imagens</span> </div></div></li>';
						};

						$('.lista-imagens-fotografo').find('ol').html(newLi);
					};
				}
			});
		};
	});









/*
	// ----- inclui nova tag ------------------------------------------------------------
	$('.botao.incluirTag').on('click', function(){
		var clicado = $(this),
			nomeTag = $('input[name="newTag"]').val();

		if ( nomeTag == '' ) {
			_alerta({ field:$('input[name="newTag"]'), mensagem:'Digite alguma coisa seu puto!' });

		} else {
			var pacote = JSON.stringify({ acao:'save_novaTag', termo:nomeTag, id:main.objPage.id });
			$.ajax({
				url : main.url+'/ack/'+main.objPage.arquivoRetorno+'/salvar',
				type: 'POST',
				data: 'ajaxACK='+pacote,
				dataType: 'json',

				success: function( data ){
					if ( data.status == 1 ) {
						var newTagHTML = '<li id="'+data.id+'" class="tag-lista-item"><button value="'+data.id+'" class="icone removerTag">X</button><a href="'+main.url+'/ack/editar/'+data.id+'">'+nomeTag+'</a></li>';

						$('ul.tag-lista').append( newTagHTML );
					};
				}
			});
		};
	});

	// ----- excluir nova tag ------------------------------------------------------------
	$('ul.tag-lista').on('click', '.icone.removerTag', function(){
		var clicado = $(this),
			pacote  = JSON.stringify({ acao:'remover_novaTag', id:clicado.val() });

		$.ajax({
			url : main.url+'/ack/'+main.objPage.arquivoRetorno+'/excluir',
			type: 'POST',
			data: 'ajaxACK='+pacote,
			dataType: 'json',

			success: function( data ){
				$('li#'+clicado.val()).fadeOut('fast').promise().done(function(){ $(this).remove(); });
			}
		});
	});

*/

	// ------------------------ ELEFRAM ------------------------
	$('.SkeletonMainSite-tags').on('click', '.botao', function(){
		var clicado = $(this),
			pacote  = {};


		if ( clicado.hasClass('editLinha') ) {
			var urlAJAX = main.url+'/ack/'+main.objPage.arquivoRetorno+'/routerAjax';

			pacote['acao']  = 'editar_novaTag';
			pacote['chave'] = clicado.parent('.parentTag').children('input[name="newTag"]').val();
			pacote['valor'] = clicado.parent('.parentTag').children('input[name="valTag"]').val();
			pacote['id']    = clicado.parent('.parentTag').attr('id');
		}
		else if ( clicado.hasClass('dellLinha') ) {
			var urlAJAX = main.url+'/ack/'+main.objPage.arquivoRetorno+'/excluir';

			pacote['acao'] = 'remover_novaTag';
			pacote['id']   = clicado.parent('.parentTag').attr('id');
		}
		else if ( clicado.hasClass('addLinha') ) {
			var urlAJAX = main.url+'/ack/'+main.objPage.arquivoRetorno+'/salvar';

			pacote['acao']  = 'save_novaTag';
			pacote['id']    = main.objPage.id;
			pacote['chave'] = clicado.parent('.parentTag').children('input[name="newTag"]').val();
			pacote['valor'] = clicado.parent('.parentTag').children('input[name="valTag"]').val();
		};


		var dados = JSON.stringify(pacote);
		$.ajax({
			url : urlAJAX,
			type: 'POST',
			data: 'ajaxACK='+dados,
			dataType: 'json',

			success: function( data ){
				if ( data.status == 1 ) {
					if ( clicado.hasClass('editLinha') ) {
						//console.log( 'editar' )
					}
					else if ( clicado.hasClass('dellLinha') ) {
						$('.form.SkeletonMainSite-tags').find('fieldset#'+pacote.id).fadeOut('fast').promise().done(function(){ $(this).remove(); });
					}
					else if ( clicado.hasClass('addLinha') ) {
						var newTagHTML = $('<fieldset data-url="/ack/tags/editar/'+data.id+'" id="'+data.id+'" class="parentTag">\
									          <input type="text" name="newTag" value="'+pacote.chave+'" />\
									          <input type="text" name="valTag" value="'+pacote.valor+'" />\
									          <button class="botao editLinha" title="Atualizar linha"><span><em>Atualizar linha</em></span><var class="borda"></var></button>\
									          <button class="botao dellLinha" title="Remover linha"><span><em>Remover linha</em></span><var class="borda"></var></button>\
									        </fieldset>');

						$('.form.SkeletonMainSite-tags').prepend( newTagHTML );

						clicado.parent('.parentTag').children('input[name="newTag"]').val('');
						clicado.parent('.parentTag').children('input[name="valTag"]').val('');
					};
				};
			}
		});
	});
});