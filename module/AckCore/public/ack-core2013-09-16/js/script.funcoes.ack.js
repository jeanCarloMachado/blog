(function(D){var C=(window.orientation!=null);var A=((D.browser.opera||(D.browser.mozilla&&parseFloat(D.browser.version.substr(0,3))<1.9))?"input":"paste");var B=function(F){F=D.event.fix(F||window.event);F.type="paste";var E=F.target;setTimeout(function(){D.event.dispatch.call(E,F)},1)};D.event.special.paste={setup:function(){if(this.addEventListener){this.addEventListener(A,B,false)}else{if(this.attachEvent){this.attachEvent("on"+A,B)}}},teardown:function(){if(this.removeEventListener){this.removeEventListener(A,B,false)}else{if(this.detachEvent){this.detachEvent("on"+A,B)}}}};D.extend({mask:{rules:{"z":/[a-z]/,"Z":/[A-Z]/,"a":/[a-zA-Z]/,"*":/[0-9a-zA-Z]/,"@":/[0-9a-zA-ZçÇáàãâéèêíìóòôõúùü]/},keyRepresentation:{8:"backspace",9:"tab",13:"enter",16:"shift",17:"control",18:"alt",27:"esc",33:"page up",34:"page down",35:"end",36:"home",37:"left",38:"up",39:"right",40:"down",45:"insert",46:"delete",116:"f5",123:"f12",224:"command"},iphoneKeyRepresentation:{10:"go",127:"delete"},signals:{"+":"","-":"-"},options:{attr:"alt",mask:null,type:"fixed",maxLength:-1,defaultValue:"",signal:false,textAlign:true,selectCharsOnFocus:true,autoTab:true,setSize:false,fixedChars:"[(),.:/ -]",onInvalid:function(){},onValid:function(){},onOverflow:function(){}},masks:{"phone":{mask:"(99) 9999-9999"},"phone-us":{mask:"(999) 999-9999"},"cpf":{mask:"999.999.999-99"},"cnpj":{mask:"99.999.999/9999-99"},"date":{mask:"39/19/9999"},"date-us":{mask:"19/39/9999"},"cep":{mask:"99999-999"},"time":{mask:"29:59"},"cc":{mask:"9999 9999 9999 9999"},"integer":{mask:"999.999.999.999",type:"reverse"},"decimal":{mask:"99,999.999.999.999",type:"reverse",defaultValue:"000"},"decimal-us":{mask:"99.999,999,999,999",type:"reverse",defaultValue:"000"},"signed-decimal":{mask:"99,999.999.999.999",type:"reverse",defaultValue:"+000"},"signed-decimal-us":{mask:"99,999.999.999.999",type:"reverse",defaultValue:"+000"}},init:function(){if(!this.hasInit){var E=this,F,G=(C)?this.iphoneKeyRepresentation:this.keyRepresentation;this.ignore=false;for(F=0;F<=9;F++){this.rules[F]=new RegExp("[0-"+F+"]")}this.keyRep=G;this.ignoreKeys=[];D.each(G,function(H){E.ignoreKeys.push(parseInt(H,10))});this.hasInit=true}},set:function(I,F){var E=this,G=D(I),H="maxLength";F=F||{};this.init();return G.each(function(){if(F.attr){E.options.attr=F.attr}var O=D(this),Q=D.extend({},E.options),N=O.attr(Q.attr),J="";J=(typeof F=="string")?F:(N!=="")?N:null;if(J){Q.mask=J}if(E.masks[J]){Q=D.extend(Q,E.masks[J])}if(typeof F=="object"&&F.constructor!=Array){Q=D.extend(Q,F)}if(D.metadata){Q=D.extend(Q,O.metadata())}if(Q.mask!=null){Q.mask+="";if(O.data("mask")){E.unset(O)}var K=Q.defaultValue,L=(Q.type==="reverse"),M=new RegExp(Q.fixedChars,"g");if(Q.maxLength===-1){Q.maxLength=O.attr(H)}Q=D.extend({},Q,{fixedCharsReg:new RegExp(Q.fixedChars),fixedCharsRegG:M,maskArray:Q.mask.split(""),maskNonFixedCharsArray:Q.mask.replace(M,"").split("")});if((Q.type=="fixed"||L)&&Q.setSize&&!O.attr("size")){O.attr("size",Q.mask.length)}if(L&&Q.textAlign){O.css("text-align","right")}if(this.value!==""||K!==""){var P=E.string((this.value!=="")?this.value:K,Q);this.defaultValue=P;O.val(P)}if(Q.type=="infinite"){Q.type="repeat"}O.data("mask",Q);O.removeAttr(H);O.bind("keydown.mask",{func:E._onKeyDown,thisObj:E},E._onMask).bind("keypress.mask",{func:E._onKeyPress,thisObj:E},E._onMask).bind("keyup.mask",{func:E._onKeyUp,thisObj:E},E._onMask).bind("paste.mask",{func:E._onPaste,thisObj:E},E._onMask).bind("focus.mask",E._onFocus).bind("blur.mask",E._onBlur).bind("change.mask",E._onChange)}})},unset:function(F){var E=D(F);return E.each(function(){var H=D(this);if(H.data("mask")){var G=H.data("mask").maxLength;if(G!=-1){H.attr("maxLength",G)}H.unbind(".mask").removeData("mask")}})},string:function(J,F){this.init();var I={};if(typeof J!="string"){J=String(J)}switch(typeof F){case"string":if(this.masks[F]){I=D.extend(I,this.masks[F])}else{I.mask=F}break;case"object":I=F}if(!I.fixedChars){I.fixedChars=this.options.fixedChars}var E=new RegExp(I.fixedChars),G=new RegExp(I.fixedChars,"g");if((I.type==="reverse")&&I.defaultValue){if(typeof this.signals[I.defaultValue.charAt(0)]!="undefined"){var H=J.charAt(0);I.signal=(typeof this.signals[H]!="undefined")?this.signals[H]:this.signals[I.defaultValue.charAt(0)];I.defaultValue=I.defaultValue.substring(1)}}return this.__maskArray(J.split(""),I.mask.replace(G,"").split(""),I.mask.split(""),I.type,I.maxLength,I.defaultValue,E,I.signal)},_onFocus:function(G){var F=D(this),E=F.data("mask");E.inputFocusValue=F.val();E.changed=false;if(E.selectCharsOnFocus){F.select()}},_onBlur:function(G){var F=D(this),E=F.data("mask");if(E.inputFocusValue!=F.val()&&!E.changed){F.trigger("change")}},_onChange:function(E){D(this).data("mask").changed=true},_onMask:function(E){var G=E.data.thisObj,F={};F._this=E.target;F.$this=D(F._this);F.data=F.$this.data("mask");if(F.$this.attr("readonly")||!F.data){return true}F[F.data.type]=true;F.value=F.$this.val();F.nKey=G.__getKeyNumber(E);F.range=G.__getRange(F._this);F.valueArray=F.value.split("");return E.data.func.call(G,E,F)},_onKeyDown:function(F,G){this.ignore=D.inArray(G.nKey,this.ignoreKeys)>-1||F.ctrlKey||F.metaKey||F.altKey;if(this.ignore){var E=this.keyRep[G.nKey];G.data.onValid.call(G._this,E||"",G.nKey)}return C?this._onKeyPress(F,G):true},_onKeyUp:function(E,F){if(F.nKey===9||F.nKey===16){return true}if(F.repeat){this.__autoTab(F);return true}return this._onPaste(E,F)},_onPaste:function(F,G){if(G.reverse){this.__changeSignal(F.type,G)}var E=this.__maskArray(G.valueArray,G.data.maskNonFixedCharsArray,G.data.maskArray,G.data.type,G.data.maxLength,G.data.defaultValue,G.data.fixedCharsReg,G.data.signal);G.$this.val(E);if(!G.reverse&&G.data.defaultValue.length&&(G.range.start===G.range.end)){this.__setRange(G._this,G.range.start,G.range.end)}if((D.browser.msie||D.browser.safari)&&!G.reverse){this.__setRange(G._this,G.range.start,G.range.end)}if(this.ignore){return true}this.__autoTab(G);return true},_onKeyPress:function(L,E){if(this.ignore){return true}if(E.reverse){this.__changeSignal(L.type,E)}var M=String.fromCharCode(E.nKey),O=E.range.start,I=E.value,G=E.data.maskArray;if(E.reverse){var H=I.substr(0,O),K=I.substr(E.range.end,I.length);I=H+M+K;if(E.data.signal&&(O-E.data.signal.length>0)){O-=E.data.signal.length}}var N=I.replace(E.data.fixedCharsRegG,"").split(""),F=this.__extraPositionsTill(O,G,E.data.fixedCharsReg);E.rsEp=O+F;if(E.repeat){E.rsEp=0}if(!this.rules[G[E.rsEp]]||(E.data.maxLength!=-1&&N.length>=E.data.maxLength&&E.repeat)){E.data.onOverflow.call(E._this,M,E.nKey);return false}else{if(!this.rules[G[E.rsEp]].test(M)){E.data.onInvalid.call(E._this,M,E.nKey);return false}else{E.data.onValid.call(E._this,M,E.nKey)}}var J=this.__maskArray(N,E.data.maskNonFixedCharsArray,G,E.data.type,E.data.maxLength,E.data.defaultValue,E.data.fixedCharsReg,E.data.signal,F);if(!E.repeat){E.$this.val(J)}return(E.reverse)?this._keyPressReverse(L,E):(E.fixed)?this._keyPressFixed(L,E):true},_keyPressFixed:function(E,F){if(F.range.start==F.range.end){if((F.rsEp===0&&F.value.length===0)||F.rsEp<F.value.length){this.__setRange(F._this,F.rsEp,F.rsEp+1)}}else{this.__setRange(F._this,F.range.start,F.range.end)}return true},_keyPressReverse:function(E,F){if(D.browser.msie&&((F.range.start===0&&F.range.end===0)||F.range.start!=F.range.end)){this.__setRange(F._this,F.value.length)}return false},__autoTab:function(F){if(F.data.autoTab&&((F.$this.val().length>=F.data.maskArray.length&&!F.repeat)||(F.data.maxLength!=-1&&F.valueArray.length>=F.data.maxLength&&F.repeat))){var E=this.__getNextInput(F._this,F.data.autoTab);if(E){F.$this.trigger("blur");E.focus().select()}}},__changeSignal:function(F,G){if(G.data.signal!==false){var E=(F==="paste")?G.value.charAt(0):String.fromCharCode(G.nKey);if(this.signals&&(typeof this.signals[E]!=="undefined")){G.data.signal=this.signals[E]}}},__getKeyNumber:function(E){return(E.charCode||E.keyCode||E.which)},__maskArray:function(M,H,G,J,E,K,N,L,F){if(J==="reverse"){M.reverse()}M=this.__removeInvalidChars(M,H,J==="repeat"||J==="infinite");if(K){M=this.__applyDefaultValue.call(M,K)}M=this.__applyMask(M,G,F,N);switch(J){case"reverse":M.reverse();return(L||"")+M.join("").substring(M.length-G.length);case"infinite":case"repeat":var I=M.join("");return(E!==-1&&M.length>=E)?I.substring(0,E):I;default:return M.join("").substring(0,G.length)}return""},__applyDefaultValue:function(G){var E=G.length,F=this.length,H;for(H=F-1;H>=0;H--){if(this[H]==G.charAt(0)){this.pop()}else{break}}for(H=0;H<E;H++){if(!this[H]){this[H]=G.charAt(H)}}return this},__removeInvalidChars:function(H,G,E){for(var F=0,I=0;F<H.length;F++){if(G[I]&&this.rules[G[I]]&&!this.rules[G[I]].test(H[F])){H.splice(F,1);if(!E){I--}F--}if(!E){I++}}return H},__applyMask:function(H,F,I,E){if(typeof I=="undefined"){I=0}for(var G=0;G<H.length+I;G++){if(F[G]&&E.test(F[G])){H.splice(G,0,F[G])}}return H},__extraPositionsTill:function(H,F,E){var G=0;while(E.test(F[H++])){G++}return G},__getNextInput:function(Q,G){var F=Q.form;if(F==null){return null}var J=F.elements,I=D.inArray(Q,J)+1,L=J.length,O=null,K;for(K=I;K<L;K++){O=D(J[K]);if(this.__isNextInput(O,G)){return O}}var E=document.forms,H=D.inArray(Q.form,E)+1,N,M,P=E.length;for(N=H;N<P;N++){M=E[N].elements;L=M.length;for(K=0;K<L;K++){O=D(M[K]);if(this.__isNextInput(O,G)){return O}}}return null},__isNextInput:function(G,E){var F=G.get(0);return F&&(F.offsetWidth>0||F.offsetHeight>0)&&F.nodeName!="FIELDSET"&&(E===true||(typeof E=="string"&&G.is(E)))},__setRange:function(G,H,E){if(typeof E=="undefined"){E=H}if(G.setSelectionRange){G.setSelectionRange(H,E)}else{var F=G.createTextRange();F.collapse();F.moveStart("character",H);F.moveEnd("character",E-H);F.select()}},__getRange:function(F){if(!D.browser.msie){return{start:F.selectionStart,end:F.selectionEnd}}var G={start:0,end:0},E=document.selection.createRange();G.start=0-E.duplicate().moveStart("character",-100000);G.end=G.start+E.text.length;return G},unmaskedVal:function(E){return D(E).val().replace(D.mask.fixedCharsRegG,"")}}});D.fn.extend({setMask:function(E){return D.mask.set(this,E)},unsetMask:function(){return D.mask.unset(this)},unmaskedVal:function(){return D.mask.unmaskedVal(this[0])}})})(jQuery)


jQuery(function(){
	
	//console.log('Start script.funcao.ack.js')
	
	////////////////////////////////////////////////////////////////// /////// //////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////// FUNÇÕES //////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////// /////// //////////////////////////////////////////////////////////////////
	/* ••••••••••••••••••••••••••••••••••••••••
	   | FUNÇÃO publica
	   | Geral
	   | Cria um objeto com informações basicas sobre a pagina visualizada.
	   */
	infoPrime = function(parent){
		var infoPage = {};
			infoPage['modulo'] = {};
			infoPage['pagina'] = {};
			infoPage['segundoNivel'] = {};
			infoPage['url'] = window.location.pathname;
		
		pageURL = window.location.pathname.split('/');
		posArr  = $.inArray("ack", pageURL) +1;
		infoPage['pagina'] = pageURL[posArr];
		
		pos2Arr  = $.inArray("ack", pageURL) +2;
		infoPage['segundoNivel'] = pageURL[pos2Arr];
		
		if( parent.find('input[type="hidden"]').length != 0 ){
			infoPage['input'] = {};
		}
		
		if( $('.menuIdioma').length != 0 ){
			infoPage['idiomas'] = {};
			idiomasPagina = {};
			
			$('.menuIdioma').find('button').each(function(but_idx, but_val){
				legendaBTN = $(but_val).children('span').html()
				idiomasBTN = $(but_val).val();
				idiomasPagina[idiomasBTN] = legendaBTN;
			})
			infoPage['idiomas'] = idiomasPagina;
		}
		
		parent.find('.modulo, input[type="hidden"]').each(function(idx, elm) {
			tagID    = $(elm).attr('id');
			tagClass = ( elm.className != null ) ? elm.className.split(' ')[1] : elm.className;
			
			if( tagClass == null && tagID == null ){
				nomeTag = $(elm).parents('div').attr('id') || $(elm).parents('div').className;
				
			} else if( tagID != null ){
				nomeTag = tagID;
				
			} else if( tagID == null ){
				nomeTag = tagClass;
			}
			
			if( elm.tagName == 'INPUT' ){
				infoPage['input'][nomeTag] = $(elm).val();
				
			} else {
				infoPage['modulo'][nomeTag] = {};
				infoPage['modulo'][nomeTag]['tag'] = $(elm);
				
				if( $(elm).attr('id') != null ){
					infoPage['modulo'][nomeTag]['segundaClass'] = elm.className.split(' ')[1];
				}
			}
        });
		
		return infoPage;
	};// ••••• _getCampos
	
	
	/* ••••••••••••••••••••••••••••••••••••••••
	   | FUNÇÃO publica
	   | Animação
	   | Joga a aba de loader com informações sobre a ação que esta sendo executada, retornado um erro quando ocorrer.
	   */
	_abaLOAD = function(setting){
		var info = $.extend({
				mensagem: 'Atualizando...',
				status: '1',
				remover: '1'
			}, setting),
			
			overlay = $('<div id="overlayLOAD" />').css({
				display: 'inline-block',
				width: '100%',
				height: '100%',
				position: 'fixed',
				left: 0,
				top: 0,
				zIndex: 99999,
				background: 'rgba(0,0,0,0.03)',
				'box-shadow': 'inset 0 0 20px rgba(0,0,0,0.2)'
			});
		
		if( info.status != '1' ){
			var icone = 'ERRO';
		} else {
			var icone = 'OK';
		}
		
		var aba = '<div id="abaLoad" class="'+ icone +'"><span></span><div><span></span><em>'+ info.mensagem +'</em></div><span></span></div>';
		
		if( info.status != '0' ){
			if( $('#overlayLOAD').is(':visible') ){
				$('#abaLoad').find('em').html(info.mensagem);
				$('#abaLoad').removeAttr('class').addClass(icone)
			} else {
				$('body').append( overlay.html(aba) );
			}
			setTimeout(function(){
				$('#overlayLOAD').remove();
			}, 250);
		} else {
			$('#abaLoad').find('em').html(info.mensagem);
			$('#abaLoad').removeAttr('class').addClass(icone);
			
			setTimeout(function(){
				$('#overlayLOAD').remove();
			}, 2000);
		}
	};
	
	
	
	/* ••••••••••••••••••••••••••••••••••••••••
	   | FUNÇÃO publica
	   | Animação
	   | Foca o campo indicado com um alerta.
	   */
	_focusField = function(setting){
		var info = $.extend({
				campo: '',
				mensagem: 'Campo obrigatório!'
			}, setting),
			markup = $('<div id="alertaCampo" />').html('<em>'+ info.mensagem +'</em>');
		
		$('#alertaCampo').remove();
		$(info.campo).focus();
		
		if( $(info.campo).parents('.fieldset').is(':visible') ){
			var parent = $(info.campo).parents('.fieldset'),
				posParent = parent.position();
			
			parent.css({ position:'relative' }).append( markup.css({ top:(parent.height() -20), left:($(info.campo).width() +35)*2 }) )
			
		} else if( $(info.campo).parents('fieldset').is(':visible') ){
			var parent = $(info.campo).parents('fieldset'),
				posParent = parent.position();
			
			parent.css({ position:'relative' }).append( markup.css({ top:(parent.height() -20), left:($(info.campo).width() +35) }) )
		}
		
		$(info.campo).bind('keyup', function(){
			$('#alertaCampo').remove();
		})
	};
	
	
	
	
	/* ••••••••••••••••••••••••••••••••••••••••
	   | FUNÇÃO publica
	   | Geral
	   | Atravez da "class ou id" passada em "parent", tags input contidas em ".radioGrup, .checkGrup, fieldset" 
	     diretos serão passados a um array associativo, onde a key="será preenchida com o name do 
		 input" e val="com o valor digitadono no campo" */
	_getCampos = function(info){
		var setting = $.extend({
				modulo: '',     // ID/CLASS que tenha como filhos diretos "fieldset ou .fieldset" - obrigatorio
				importante: {}, // "name ou class" que devem ser preenchidos junto com a mensagem que sera exibida
				ignorar: '',    // ID do modulo parent dos campos, ou o name do campo que sera ignorada
				idioma: '',     // idiomas para associar aos campos
				output: false,
				tipoAcao: 'incluir'
			}, info),
			gC_retorno = {},
			gC_arrIgn  = setting.ignorar.split(', '),
			gC_arrImp  = [],
			gC_check   = true,
			arrImpot   = setting.importante;
		
		for (var gC_key in setting.importante) {
			gC_arrImp.push(gC_key);
		};// separa key de value da array
		
		$('fieldset, .fieldset').find('.alerta').fadeOut('fast', function(){
			$(this).remove();
		}); // Remove mensagens de alerta que estiverem visiveis
		
		
		$.each($(setting.modulo), function(idx_parent, elt_parent){
			if( $(elt_parent).parents('.modulo').attr('id') ){
				arrName = $(elt_parent).parents('.modulo').attr('id');
				
			} else if( $(elt_parent).parents('.modulo').attr('class').split(' ').length > 1 ){
				arrName = $(elt_parent).parents('.modulo').attr('class').split(' ')[1];
				
			} else if( $(elt_parent).attr('id') ){
				arrName = ( $(elt_parent).attr('id') ) ? $(elt_parent).attr('id') : $(elt_parent).attr('class') ;
			}
			
			if( $.inArray(arrName, gC_arrIgn) != -1 ){
				return;
				
			} else {
				gC_retorno[arrName] = {};
				// se achar algum input=hidden em algum fieldset, ele sera incluido no array
				if( $(elt_parent).find('input[type="hidden"]').length > 0 ){
					oculto = $(elt_parent).find('input[type="hidden"]');
					gC_retorno[arrName][oculto.attr('name')] = oculto.val();
				}
				
				$(elt_parent).find('.radioGrup, .checkGrup, fieldset, .editorTexto').each(function(idx_chil, elt_chil){
					if( $(elt_chil).children().hasClass('select') ){
						var chil_value = $(elt_chil).children('.select').children('select').val(),
							chil_name  = $(elt_chil).children('.select').children('select').attr('name');
					} else {
						var chil_value = $(elt_chil).children('input, textarea, select').val(),
							chil_name  = $(elt_chil).children('input, textarea, select').attr('name');
					}
					
					if( $(elt_chil).hasClass('editorTexto') ){
						chil_name  = $(elt_chil).find('textarea').attr('name');
						chil_value = $(elt_chil).find('iframe').contents().find("body").html()
						
						gC_retorno[arrName][chil_name] = chil_value;
						
					} else if( $(elt_chil).hasClass('checkGrup') ){
						if( $.inArray(chil_name, gC_arrImp) != -1 && chil_value == null ) {
							gC_check = false;
						}
						chil_grupo = new Array();
						$.each($(elt_chil).find('input[type="checkbox"]:checked'), function(idx_check, elt_check) {
							key_checkbox = $(elt_check).val()
							chil_grupo.push(key_checkbox);
						});
						gC_retorno[arrName] = chil_grupo;
							
					} else if( setting.tipoAcao == 'incluir' && $('*[name="'+chil_name+'"]').is(':hidden') ){
						return;
						
					} else if( $('.parentFull').hasClass('usuarios') && $('*[name="'+chil_name+'"]').is(':hidden') ){
						return;
						
					} else if( $.inArray(chil_name, gC_arrIgn) != -1 || chil_name == null || $('*[name="'+chil_name+'"]').is(':disabled') /*|| $('*[name="'+chil_name+'"]').is(':hidden')*/ ){
						return;
						
					} else {
						if( $(elt_chil).find('input').attr('type') == 'radio' || $(elt_chil).find('input').attr('type') == 'checkbox' ){
							var chil_value = $(elt_chil).find('input:checked').val(),
								chil_grupo = {};
						}
						
						if( $(elt_chil).hasClass('checkGrup') ){
							if( $.inArray(chil_name, gC_arrImp) != -1 && chil_value == null ) {
								gC_check = false;
							}
							chil_grupo = new Array();
							$.each($(elt_chil).find('input[type="checkbox"]:checked'), function(idx_check, elt_check) {
								key_checkbox = $(elt_check).val()
								chil_grupo.push(key_checkbox);
							});
							gC_retorno[arrName] = chil_grupo;
							
						} else if( $(elt_chil).hasClass('radioGrup') ){
							if( $.inArray(chil_name, gC_arrImp) != -1 && chil_value == null ) {
								gC_check = false;
							}
							gC_retorno[arrName][chil_name] = chil_value;
							
						} else {
							if( $.inArray(chil_name, gC_arrImp) != -1 && chil_value == '' ){  // ----- Verifica se o campo esta na lista de obrigatorios e vazio
								_focusField({ campo:$('*[name="'+chil_name+'"]') })
								gC_check = false;
								
							} else if( $('*[name="'+chil_name+'"]').attr('type') == 'email' && !/[A-Za-z0-9_.-]+@([A-Za-z0-9_]+\.)+[A-Za-z]{2,4}/.test(chil_value) ){ // ----- Verifica se o campo é do tipo e-mail, para valida-lo
								_focusField({ campo:$('*[name="'+chil_name+'"]'), mensagem:'E-mail inválido' })
								gC_check = false;
								
							//} else if( $('*[name="'+chil_name+'"]').attr('type') == 'password' && chil_value.length < 6 ){ // ----- Verifica se o campo senha possui no minimo 6 caracteres
							} else if( $('*[name="'+chil_name+'"]').attr('type') == 'password' ){ // ----- Verifica se o campo senha possui no minimo 6 caracteres
								//_focusField({ campo:$('*[name="'+chil_name+'"]'), mensagem:'Sua senha deve pelo menos 6 caracteres' })
								//gC_check = false;
								
								if( chil_value.length < 6 ){
									_focusField({ campo:$('*[name="'+chil_name+'"]'), mensagem:'Sua senha deve pelo menos 6 caracteres' })
									gC_check = false;
								} else if( $('input[name="senhaNovaConf"]').val() != $('input[name="senhaNova"]').val() ){
									_focusField({ campo:$('input[name="senhaNovaConf"]'), mensagem:'Senha incorreta' })
									gC_check = false;
								}
							}
							gC_retorno[arrName][chil_name] = chil_value;
						}
					}
					if( gC_check === false ){
						gC_retorno = false;
						return false;
					}
				}); // end each
			}
			if( gC_check === false ){
				gC_retorno = false;
				return false;
			}
		}); // end each
		
		return gC_retorno;
	};// ••••• _getCampos
	
	
	/* ••••••••••••••••••••••••••••••••••••••••
	   | FUNÇÃO publica
	   | Local
	   | Usada para ordenar a lista de itens recebida pelo json
	   */
	function sort_by(field, reverse, primer){
		var key = function (x) {return primer ? primer(x[field]) : x[field]};
		return function (a,b) {
			var A = key(a), B = key(b);
			return ((A < B) ? -1 : (A > B) ? +1 : 0) * [-1,1][+!!reverse];                  
		}
	}
	
	
	
	/* ••••••••••••••••••••••••••••••••••••••••
	   | FUNÇÃO publica
	   | Geralmente para o modulo de infoSistema
	   | Recebe um array associativo e atravez das informações passadas preenche os campos indicados no array
	   */
	_setCampos = function(setting){
		var info = $.extend({
				modulo: $('.dadosPagina').attr('id'),
				botao: '',
				id: $('.dadosPagina').val()
			}, setting),
			
			modulo    = ( info.modulo != '' ) ? info.modulo : info.botao.parents('.modulo').attr('class').split(' ')[1],
			idomaView = $('.menuIdiomas button.onView').attr('name'),
			pedido    = JSON.stringify({ 'acao':'loadDados', 'modulo':modulo, 'id':info.id, 'idioma':info.botao.attr('name') });
			
		$.ajax({
			url: siteURL+'/ack/ajax',
			type: 'POST',
			data: {'ajaxACK':pedido},
			dataType: 'json',
			
			beforeSend: function(){
				_abaLOAD({ mensagem: 'Trocando idioma' });
				$('.botao.salvar').click();
			},
			success: function(data){
				if( data.status == '1' ){
					$(info.botao).parents('.modulo').find('.collumA').find('fieldset').each(function(i_campo, val_campo){
						$(val_campo).find('input, textarea, select').each(function(i_input, val_input){
							var nomeInput = $(val_input).attr('name'),
								novoNome  = nomeInput.replace('_'+idomaView, '_'+info.botao.attr('name'));
							
							$('legend strong').html('['+ info.botao.find('em').html() +']');
							$(val_input).attr('name', novoNome);
						});
					});
					
					info.botao.addClass('onView').siblings('button').removeClass('onView');
					
					$(info.botao).parents('.modulo').find('.collumA').animate({ opacity:0.5 }, 'fast', function(){
						$.each(data, function(ld_chave, ld_valor){
							$(info.botao).parents('.modulo').find('*[name='+ld_chave+']').val( ld_valor );
						})
					}).promise().done(function(){
						$(this).animate({ opacity:1 })
					});
				}
			}
		})
	};// ••••• _setCampos
	
	
	/* ••••••••••••••••••••••••••••••••••••••••
	   | FUNÇÃO privada
	   | Atualiza a cor da linha
	   */
	function linhaParImpar(){
		$('.lista').find('ol li').children('div').each(function(idx_linha, val_linha){
			$(val_linha).removeAttr('style'); /* limpa as linhas para depois passar a cor */
			( idx_linha%2 ) ? $(val_linha).css({ 'background-color':'#F6F6F6' }) : '';
		});
	};// ••••• linhaParImpar
	
	



	/* •••••••••••••••••••••••••••••••••••••••• REVER
	   | FUNÇÃO publica
	   | Paginas com qualquer tipo de listagem
	   | carrega mais itens de acordo com a pagina
	   */
	CarregarSubLinhas = function(info){
		var settings = $.extend({
			botao: '', // botao clicado
			modulo: '', // modulo parent do botao
			emLista: 0, // numero de itens que estao visiveis na lista
			apendice: '', // dados extra que serao enviados para o php
			tragndrop: false // ativa o plugin de drag'n drop quando solicitado
		}, info);
		
		var markup      = $('<li />'),
			moduloPai   = $('input[type="hidden"].dadosPagina').attr('id'),
			urlModulo   = infoPrime( $('.parentFull') ),
			pacote      = JSON.stringify({ acao:'carregar_mais', modulo:settings.modulo, qtd_itens:settings.emLista }),
			grupAnchor  = Array(),
			grupTexto   = Array(),
			grupOrdem   = Array(),
			colW        = Array();
		
		/* ----------------------------------------------------------------------------------------------------------------
			Adiciona a classe do cabeçalho da lista no array certo
			• quando a classe tem uma segunda classe 'tx' ou 'normal' o texto da lista nao tem link
			• quando a classe tem uma segunda classe 'ordem' alem da ancora as setas de ordenaçao serao incluidas
			• se nao tiver segunda classe o texto sera uma ancora normal
		  ---------------------------------------------------------------------------------------------------------------- */
		$('.lista .header > div').children().each(function(idx, tag){
			if( $(tag).attr('class').split(' ')[1] != null ){
				if( $(tag).attr('class').split(' ')[1] == 'normal' || $(tag).attr('class').split(' ')[1] == 'tx' ){
					grupTexto.push( $(tag).attr('class').split(' ')[0] );
				}
				if( $(tag).attr('class').split(' ')[1] == 'ordem' ){
					grupOrdem.push( $(tag).attr('class').split(' ')[0] );
				}
			} else if( $(tag).attr('class') != 'checkGrupo' ){
				grupAnchor.push( $(tag).attr('class').split(' ')[0] );
			}
		})

		$.ajax({
			url:  siteURL+'/ack/ajax',
			data: {'ajaxACK':pacote},
			type: 'POST',
			dataType: 'json',
			
			beforeSend: function(){
				//LoaderBar({ mensagem:'Carregando lista...' });
			},
			success:    function(data){
				if( data.exibir_botao === 0 ){
					$(settings.botao).attr('disabled', 'disabled');
				} else {
					$(settings.botao).removeAttr('disabled');
				}
				
				var dadosLI  = data.grupo,
					contador = 1;
				
				$.each(dadosLI, function(CS_idx, CS_elm){
					var html_li    = markup,
						elm_parent = CS_elm.relacao,
						sublinha   = '';
					
					$.each(CS_elm, function(sub_key, sub_val){
						// Se essas chaves nao tiverem conteudo 'digitado pelo usuario durante o cadastro' o texto alternativo será usado
						var cont_linha = ( sub_val != '' ) ? sub_val : '<i style="font-style:italic; color:#ccc;">Conteudo não informado</i>',
							baseURL    = siteURL +'/ack/'+ urlModulo.pagina +'/'+ ((data.parent_lista=='grupos')?'':'categorias/') +'editar/';
						
						if(sub_key == 'visivel'){
							if( !CS_elm.tx ){
								var check_ok = ( sub_val == 0 ) ? '' : ' ok',
									checked  = ( sub_val == 0 ) ? '' : 'checked="checked"';
								sublinha    += '<label class="'+ sub_key + check_ok +'"><input type="checkbox" '+ checked +' name="'+data.parent_lista+'-'+moduloPai+'" /></label>';
								//linha += '<div class="checkboxACK"><label class="'+s_key + checkOK+'"><input type="checkbox" '+checkedACK+' name="'+moduloPage+'-'+data.parent_lista+'" /></label></div>';
							} else {
								sublinha += '';
							}
							
						} else if($.inArray(sub_key, grupOrdem) != -1){
							if( elm_parent!='0' ){
								sublinha += '<div class="'+ sub_key +'">\
												<img class="setaSub" src="'+siteURL+'/ack-core/images/icon_setaSubnivelCinza.gif" width="13" height="12" /><a href="'+ baseURL + CS_elm.id +'">'+ cont_linha +'</a>\
												<button title="Mover para cima" class="btn_goTopo" accesskey="'+ (Number(CS_elm.ordem)-1) +'"><img width="13" height="7" alt="▲" src="'+ siteURL +'/ack-core/images/icon_setaToTopo.png"></button>\
												<button title="Mover para baixo" class="btn_goFundo" accesskey="'+ (Number(CS_elm.ordem)+1) +'"><img width="13" height="7" alt="▼" src="'+ siteURL +'/ack-core/images/icon_setaToFundo.png"></button>\
											</div>';
							} else {
								if( !CS_elm.tx ){
									var txtLinha = '<a href="'+ baseURL + CS_elm.id +'">'+ cont_linha +'</a>';
								} else {
									var txtLinha = '<span>'+ cont_linha +'</span>';
								}
								sublinha += '<div class="'+ sub_key +'">'+ txtLinha +'</div>';
							}
							
						} else if($.inArray(sub_key, grupAnchor) != -1){
							// Quando receber a key tx=true a linha nao tera link nem checkbox nem botao de visivel
							if( !CS_elm.tx ){
								var txtLinha = '<a href="'+ baseURL + CS_elm.id +'">'+ cont_linha +'</a>';
							} else {
								//var txtLinha = '<span>'+ cont_linha +'</span>';
							}
							
							if( elm_parent!='0' ){
								//sublinha += '<img class="setaSub" src="'+siteURL+'/ack-core/images/icon_setaSubnivelCinza.gif" width="13" height="12" /><span class='+ sub_key +'>'+ txtLinha +'</span>';
								sublinha += '<span class='+ sub_key +'>'+ txtLinha +'</span>';
							} else {
								//sublinha += '<span class='+ sub_key +'>'+ txtLinha +'</span>';
							}
							
						} else if(sub_key === 'anexo') {
							(sub_val != 0) ? linha += '<span class="'+ sub_key +'"><img src="imagens/ack/icon_anexo.png" width="12" height="9" alt="■" /></span>' : sublinha += '<span class="'+ sub_key +'"></span>';
							
						} else if($.inArray(sub_key, grupTexto) != -1 ) {
							sublinha += '<span class='+ sub_key +'><span>'+ sub_val +'</span></span>';
							
						} else if(sub_key === 'id'){
							if( !CS_elm.tx ){
								sublinha += '<label class="checkLinha"><input type="checkbox" value="'+ sub_val +'" name="checkLinha" /></label>';
							} else {
								sublinha += '<div class="checkBox-fake visivel"></div>';
							}
							
						} else {
							return;
						}
					});// END each
					
					if(CS_elm.relacao != '0'){
						if( $('#'+elm_parent).find('ol').length == 0 ){
							contador++;
							$('#'+elm_parent).append( $('<ol />') );
						}
						html_li = $('<li />').attr('id', CS_elm.id).append( $('<div />').html(sublinha) );
						$('#'+elm_parent+' > ol').append(html_li);
						
					} else {
						contador = 1;
						
						html_li = $('<li />').attr('id', CS_elm.id).append( $('<div />').html(sublinha) );
						$('div#'+settings.modulo).find('.principal').append(html_li);
					}
				});// END each
			},
			complete:   function(){
				$('#overlay').remove();
				
				disableArrow();
				linhaParImpar()
			}
		})
	};// ••••• CarregarSubLinhas


	
	
	/* ••••••••••••••••••••••••••••••••••••••••
	   | FUNÇÃO privada
	   | Paginas com qualquer tipo de listagem
	   | atualiza o status dos botoes de navegação entre linhas da lista, desabilitando o primeiro e o ultimo
	   */
	function disableArrow(){
		$('ol li').find('.btn_goFundo, .btn_goTopo').removeAttr('disabled');
		
		$('ol').children('li').each(function(li_idx, li_emt) {
			if( $(li_emt).is(':last-child') && $(li_emt).children('ol:visible') ){
				$(li_emt).find('button.btn_goFundo').attr('disabled', 'disabled');
				$(li_emt).children('ol').find('button.btn_goFundo').removeAttr('disabled');
			}
			if( $(li_emt).is(':first-child') && $(li_emt).children('ol:visible') ){
				$(li_emt).find('button.btn_goTopo').attr('disabled', 'disabled')
				$(li_emt).children('ol').find('button.btn_goTopo').removeAttr('disabled');
			}
		});
	};// ••••• disableArrow
	
	
	/* ••••••••••••••••••••••••••••••••••••••••
	   | FUNÇÃO privada
	   | Geral
	   | recebe informações para montar um modal
	   */
	montaMODAL = function(info){
		setting = $.extend({
			largura: 500,
			altura: 150,
			titulo: 'titulo teste',
			texto: 'texto teste',
			input: 'dados ocultos',
			id_parent: '',
			padrao: true,
			modal: true,
			new_markup: false,
			markup_xcluir: '<button class="botao confirma" title="Excluir selecionados"><span><var></var><em>Excluir</em></span><var class="borda"></var></button><input type="hidden" value="{array}" />'
		}, info);
		
		markupModal = '<div id="ack_modal">\
							<div id="helper">\
							\
								<div class="content" style="width:{width}px; display:none;">\
									<div class="modalTop"><span class="borda modal_left"></span> <span class="modal_middle" style="width:'+ (setting.largura-28 ) +'px;"></span> <span class="borda modal_right"></span></div>\
									<div class="modalMiddle">\
										<div class="left">\
											<div class="right">\
											\
												<div class="modalContent" style="width:'+ (setting.largura-28 ) +'px;">\
													<div class="dadosModal" style="height:{height}px">\
														<h3>{titulo}</h3>\
														<p>{texto}</p>\
														<input type="hidden" id="extra" value="{array}" />\
													</div><!-- END dadosModal -->\
													<div class="boxBotoes">\
														<button class="botao ignora" title="Cancelar operação" name="{parent}"><span><em>Cancelar</em></span><var class="borda"></var></button>\
														{botao}\
													</div>\
												</div>\
											\
											</div>\
										</div>\
									</div>\
									<div class="modalBottom"><span class="borda modal_left"></span> <span class="modal_middle" style="width:'+ (setting.largura-28 ) +'px;"></span> <span class="borda modal_right"></span></div>\
								</div>\
							\
							</div>\
						</div>';
		newModal    = markupModal;
		
		if( setting.padrao ){
			newModal = newModal.replace(/{botao}/, setting.markup_xcluir)
		}
		newModal = newModal.replace(/{titulo}/, setting.titulo).replace(/{texto}/, setting.texto).replace(/{array}/, setting.input).replace(/{height}/, setting.altura).replace(/{width}/g, setting.largura)
		
		$('body').append( newModal );
		
		if( setting.new_markup ){ $('.dadosModal').html( setting.new_markup ) }
		
		$('#ack_modal').fadeIn('fast', function(){
			$(this).css({ display:'table' }).find('.content').fadeIn('slow');
		})
	};// ••••• disableArrow
	
	
	/* •••••••••••••••••••••••••••••••••••••••• REVER
	   | FUNÇÃO privada
	   | Geral
	   | passando o campo e a mensagem a função anima a pagina até o campo e exibe um alerta
	   */
	function _onFocus(campo, mensagem){
		var field  = campo,
			parent = campo.parents('fieldset, .fieldset'),
			markup = '<span class="alerta ok"><em>'+ mensagem +'</em></span>';
		
		$(parent_func).append(markup_alert);
		//$('html, body').animate({ scrollTop: $(parent_func).offset().top }, 'slow', function(){ campo.focus() });
		$('.alerta').fadeIn().fadeOut().fadeIn();
	};// ••••• _onFocus
	
	
	/* ••••••••••••••••••••••••••••••••••••••••
	   | FUNÇÃO
	   | Geral
	   | retorna uma string de acordo com a url passada
	   */
	_getFileType = function(itemSrc){
		if (itemSrc.match(/youtube\.com\/watch/i) || itemSrc.match(/youtu\.be/i)) {
			return 'youtube';
		} else if (itemSrc.match(/vimeo\.com/i)) {
			return 'vimeo';
		} else if( itemSrc.match(/\b.swf\b/i) || itemSrc.match(/\b.png\b/i) || itemSrc.match(/\b.jpg\b/i) ){
			return 'outro';
		};
	};// ••••• _getFileType
	
	
	/* ••••••••••••••••••••••••••••••••••••••••
	   | FUNÇÃO
	   | Geral
	   | 
	   */
	getParam = function(name, url){
		var name    = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]"),
			regexS  = "[\\?&]"+name+"=([^&#]*)",
			regex   = new RegExp( regexS ),
			results = regex.exec( url );
		return ( results == null ) ? "" : results[1];
	};// ••••• getParam
	
	
	/* ••••••••••••••••••••••••••••••••••••••••
	   | FUNÇÃO
	   | Especifica para a pagina de edição/inclusao de usuario
	   | Carrega array associativa para gerar lista HTML com as permissoes de usuario
	   */
	echoPermissoes = function(usuario){
		markup_perm = '<li>\
						<div>\
							<span class="secao">{Mnome}</span>\
							<div class="radioGrup">\
								<label><input type="radio" name="{Mname}" value="0" {valor_0} {status} /><em>Não disponível</em></label>\
								<label><input type="radio" name="{Mname}" value="1" {valor_1} {status} /><em>Somente leitura</em></label>\
								<label><input type="radio" name="{Mname}" value="2" {valor_2} {status} /><em>Controle completo</em></label>\
							</div>\
						</div>\
					</li>';
		pedido      = JSON.stringify({ acao:'permissoes', usuario:usuario });
		
		$.ajax({
			url:  siteURL+'/ack/ajax',
			type: 'POST',
			data: 'ajaxACK='+pedido,
			dataType: 'json',
			
			success: function(data){
				$.each(data, function(key, value){
					
					temp = markup_perm.replace(/{Mnome}/g, value[0]).replace(/{Mname}/g, key).replace(/{status}/g, value[2]);
					
					switch( value[1] ){
						case "0": $('.listaPermissoes').append( temp.replace(/{valor_0}/g, "checked=\"checked\"").replace(/{valor_1}/g, '').replace(/{valor_2}/g, '') );
						break;
						
						case "1": $('.listaPermissoes').append( temp.replace(/{valor_1}/g, "checked=\"checked\"").replace(/{valor_0}/g, '').replace(/{valor_2}/g, '') );
						break;
						
						case "2": $('.listaPermissoes').append( temp.replace(/{valor_2}/g, "checked=\"checked\"").replace(/{valor_1}/g, '').replace(/{valor_0}/g, '') );
						break;
					}
					
				});
				
				$('html, body').animate({ scrollTop: $('.slide').offset().top }, 'slow');
				$('#loadAba').slideUp('slow', function(){ $(this).remove() });
			}
		});
	};// ••••• echoPermissoes
	
	
	/* ••••••••••••••••••••••••••••••••••••••••
	   | FUNÇÃO
	   | Especidica para listagem de produtos
	   | passando o o botao clicado e destino da lista que sera carregada esta função carregar por cateforia"filtro" todos os produtos
	   */
	filtroProdutos = function(info){
		var setting = $.extend({
				botao: '',
				parent_lista: $('.list_produtos'),
				modulo: '',
				callback: ''
			}, info),
			botao   = $(setting.botao),
			produto = botao.val(),
			markup  = '<div id="{idProduto}" class="lista lista_daCategoria" style="display:none;">\
							<h5 class="tituloCat">{nomeProduto} [<var>{qtdProduto}</var>]</h5>\
							<ol style="display:none;"></ol>\
							<button class="maisProdutos_categoria" title="Carregar mais resultados" name="{idProduto}"><span></span><em>Exibir mais resultados.</em><span></span></button>\
						</div>';
		
		if( botao.hasClass('checked') ){
			if( botao.siblings('button').hasClass('checked') ){
				$('.checked').removeAttr('disabled');
			} else {
				$('.filtroCategorias button').removeAttr('disabled');
			}
			
			botao.removeAttr('class');
			setting.parent_lista.find('div#'+produto).find('ol').slideUp('slow', function(){
				$(this).parent('div#'+produto).slideUp('fast', function(){
					$(this).remove()
				});
			});
			
		} else if( !botao.hasClass('checked') ){
			botao.addClass('checked');
			
			pacote = JSON.stringify({ 'acao':'carregar_grupo', 'id':produto, 'modulo':setting.modulo });
			$.ajax({
				url:  siteURL+'/ack/ajax',
				type: 'POST',
				data: {'ajaxACK':pacote},
				dataType: 'json',
				
				success: function(data){
					if( produto === 'todosProdutos' ){
						botao.siblings('button').attr('disabled', 'disabled');
					} else {
						$('.filtroCategorias button[value="todosProdutos"]').attr('disabled', 'disabled');
					}
					newHTML = markup.replace(/{idProduto}/g, produto).replace(/{nomeProduto}/g, data.nome).replace(/{qtdProduto}/g, data.quantidade);
					
					setting.parent_lista.append( newHTML );
					
					CarregarMais({
						botao: $('button[name="'+data.categoria+'"]'),
						modulo: $('input[type="hidden"].dadosPagina').attr('id'),
						categoria: $('div#'+data.categoria).children('button').attr('name')
					});
					
					setting.parent_lista.find('div#'+data.categoria).fadeIn('fast', function(){
						$(this).children('ol').delay(400).slideDown('fast');
					})
				},
				complete: function(){
					wrapperList = $( '#'+$(setting.botao).val() );
					/*if( wrapperList.offset().top >= 250 ){
						$('html,body').animate({scrollTop: wrapperList.offset().top -150}, 888);
					}*/
				}
			})
		}
		
		if( typeof(setting.callback) == 'function' ){
			setting.callback.call(this);
		}
	};// ••••• filtroProdutos
	
	
	
	/* ••••••••••••••••••••••••••••••••••••••••
	   | FUNÇÃO
	   | Especidica para listagem de produtos
	   | passando o o botao clicado e destino da lista que sera carregada esta função carregar por cateforia"filtro" todos os produtos
	   */
	_checkData = function(obj){
		v = obj.value;
		v = v.replace(/[^0-9\.]/g, '');
		v = v.replace(/\D/g, "");
		v = v.replace(/(\d{2})(\d)/, "$1-$2");
		v = v.replace(/(\d{2})(\d)/, "$1-$2");
		return obj.value = v;
	};
	
	
	/* •••••••••••••••••••••••••••••••••••••••• REVER
	   | FUNÇÃO
	   | Limita os caracteres
	   */
	$.fn.limitador = function(setting){
		var info = $.extend({
				limite: 255
			}, setting),
			contador = $(this).parent('fieldset, .fieldset').find('legend, .legend').find('input[readonly="readonly"]');
			contador = $(this).parent('fieldset').find('legend small b');
		
		//contador.val( info.limite - $(this).val().length );
		
		this.bind('keyup', function(){
			if( $(this).val().length > info.limite ){
				$(this).val( $(this).val().substring(0, info.limite) )
			}
			contador.val( info.limite - $(this).val().length );
		})
	}
	
	
	
	/* •••••••••••••••••••••••••••••••••••••••• REVER
	   | FUNÇÃO
	   | Retorna o numero de elementos de um objeto
	   */
	objectSize = function(obj) {
		var size = 0, key;
		for (key in obj) {
			if (obj.hasOwnProperty(key)) size++;
		}
		return size;
	}

	
	
	
	
	////////////////////////////////////////////////////////////////// //////// //////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////// EVENTOS ///////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////// //////// //////////////////////////////////////////////////////////////////
	
	/* ••••••••••••••••••••••••••••••••••••••••
	   | EVENTO
	   | modal
	   | Fecha a janela modal
	••••• */
	$('#ack_modal .ignora').bind('click', function(){
		$('#ack_modal .content').fadeOut('normal', function(){
			$(this).parents('#ack_modal').fadeOut('fast', function(){
				$(this).remove()
			})
		});
	})
	
	
	
	/* ••••••••••••••••••••••••••••••••••••••••
	   | EVENTO
	   | Paginas com qualquer tipo de listagem
	   | Navegalçao por setas
	••••• */
	$('.lista ol li').find('.btn_goTopo, .btn_goFundo').bind('click', function(){
		var thisLI    = $(this),
			parentLI  = thisLI.closest('li').parent('ol'),
			indexAt   = thisLI.closest('li').index(),
			categoria = '',
			modulo    = $('input[type="hidden"].dadosPagina').attr('id'),
			idItem    = thisLI.parents('li').attr('id'),
			novaPos   = '',
			
			prevLI = parentLI.children('li').eq(indexAt + 1),
			proxLI = parentLI.children('li').eq(indexAt - 1);
		
		if( thisLI.hasClass('btn_goFundo') ){
			novaPos = indexAt + 1;
		} else if(thisLI.hasClass('btn_goTopo')){
			novaPos = indexAt - 1;
		}
		
		if( $('.filtroCategorias').length > 0 ){
			categoria = $(this).parents('.lista.lista_daCategoria').children('.maisProdutos_categoria').attr('name');
		} else {
			categoria = '0';
		}
		
		var pacote = JSON.stringify({ 'acao':'dragdrop', 'modulo':modulo, 'id':idItem, posicao_antiga:indexAt+1, posicao_nova:novaPos+1, 'categoria':categoria });
		$.ajax({
			url: siteURL+'/ack/ajax',
			type: 'POST',
			data: {'ajaxACK':pacote},
			dataType: 'json',
			
			success: function(data){
				if( thisLI.hasClass('btn_goFundo') ){
					parentLI.children('li').eq(indexAt).before(prevLI);
					novaPos = indexAt + 1;
					
				} else if(thisLI.hasClass('btn_goTopo')){
					parentLI.children('li').eq(indexAt).after(proxLI);
					novaPos = indexAt - 1;
				}
			},
			complete: function(){
				linhaParImpar()
				disableArrow();
			}
		})
		/////
		///disableArrow();
	});
	
	
	
	/* ••••••••••••••••••••••••••••••••••••••••
	   | EVENTO
	   | Paginas com qualquer tipo de listagem
	   | seleciona e deseleciona os itens de uma lista
	••••• */
	$('input[name="checkAll"]').bind('click', function(){
		if( $(this).is(':checked') ){
			$(this).closest('.lista').find('ol').find('li').each(function(){
				$(this).find('input[name="checkLinha"]').attr('checked', 'checked')
				$('.head').find('button.botao.excluir').removeAttr('disabled')
			});
			
		} else {
			$(this).closest('.lista').find('ol').find('li').each(function(){
				$(this).find('input[name="checkLinha"]').removeAttr('checked')
				$('.head').find('button.botao.excluir').attr('disabled', 'disabled')
			});
		}
	});
	
	
	/* ••••••••••••••••••••••••••••••••••••••••
	   | EVENTO
	   | Paginas com qualquer tipo de listagem
	   | evento para checar se todas as linhas foram selecionadas uma a uma
	••••• */
	$('input[name="checkLinha"]').bind('click', function(){
		marcados = $(this).closest('.lista').find('li').find('input[name="checkLinha"]:checked').length;
		total    = $(this).closest('.lista').find('li').find('input[name="checkLinha"]').length
		
		if( marcados === total ){
			$('input[name="checkAll"]').attr('checked', 'checked')
		} else if( marcados != total ){
			$('input[name="checkAll"]').removeAttr('checked')
		}
		
		if( marcados != 0 ){
			$('.head').find('button.botao.excluir').removeAttr('disabled')
		} else {
			$('.head').find('button.botao.excluir').attr('disabled', 'disabled')
		}
		
		
		if( $(this).closest('li').children('ol').length > 0 ){
			childOL    = $(this).closest('li').children('ol');
			checkdGrup = $(this).is(':checked');
			
			childOL.find('li').each(function(){
				$(this).find('input[name="checkLinha"]').attr('checked', checkdGrup)
			});
		}
	});
	
	
	/* ••••••••••••••••••••••••••••••••••••••••
	   | EVENTO
	   | Geral
	   | input radio para visibilidade da pagina
	••••• */
	$('.visivel > input').bind('click', function(){
		var pagina = $('input[type="hidden"].dadosPagina').val(),
			modulo = $(this).attr('name'),
			valor  = ($(this).is(':checked')) ?  1 : 0,
			LIid   = $(this).closest('li').attr('id');
		
		/* ----------------------------------------------------------------------------------------------------------------
			Verfica se o input.categorias esta na pagina para mudar os dados do pacote enviado por AJAX
		   ---------------------------------------------------------------------------------------------------------------- */
		if( $('.parentFull').find('input.categorias').length == 0 ){
			var pacote = JSON.stringify({ 'acao':'visivel', 'id':LIid, 'modulo':modulo, 'valor':valor, 'id_pagina':pagina })
		} else {
			pagina = $(this).attr('name')+'_'+$('input[type="hidden"].categorias').attr('id');
			modulo = $('.parentFull').find('input.dadosPagina').attr('id');
			var pacote = JSON.stringify({ 'acao':'visivel', 'id':LIid, 'modulo':modulo, 'valor':valor, 'id_pagina':pagina })
		}
		
		if( $('.dadosPagina').attr('id') == 'dadosGerais' ){
			var pacote = JSON.stringify({ 'acao':'visivel', 'id':LIid, 'modulo':modulo, 'valor':valor, 'id_pagina':'geral_ack' })
		};

		if ( modulo != 'idiomas' ) {
			$.ajax({
				url: siteURL+'/ack/ajax',
				type: 'POST',
				data: {'ajaxACK':pacote},
				dataType: 'json',
				
				beforeSend: function(){
					_abaLOAD({ mensagem: 'Atualizando status' });
				},
				success: function(data){
					if( valor === 1 ){
						$('#'+data.parent).children('div').find('.visivel').addClass('ok');
					} else if( valor === 0 ){
						$('#'+data.parent).children('div').find('.visivel').removeClass('ok');
					}
					dados = data;
				},
				complete: function(){
					_abaLOAD({ mensagem: dados.mensagem, status: dados.status, remover: dados.status });
				},
				error: function(){
					_abaLOAD({ mensagem: dados.mensagem, status: dados.status, remover: dados.status });
				}
			})
		};
	});
	
	
	/* ••••••••••••••••••••••••••••••••••••••••
	   | EVENTO
	   | Geral
	   | botao de ajuda ao clicar envia um ID ao PHP que retorna o titulo e texto referenta ao campo duvidoso
	••••• 
	var ajudaTimer;
	$('.ajuda').bind('click', function(){
		botao  = $(this).closest('legend, .legend');
		pos    = ( botao.width() > 0 ) ? 'right' : 'left';
		markup = '<div class="janelaAjuda '+pos+'">\
					  <span></span>\
					  <div>\
						  <div class="header">\
							  <span><span>O que é isso?</span></span>\
							  <button class="icone excluir" title="Fechar">(X)</button>\
						  </div>\
						  <div class="texto"> <h5>{titulo}</h5> <p>{texto}</p> </div><!-- END texto -->\
					  </div>\
					  <span></span>\
				  </div>';
		
		pacote = JSON.stringify({ 'campo':$(this).attr('id'), 'acao':'ajuda' });
		$.ajax({
			url: siteURL+'/ack/ajax',
			type: 'POST',
			data: {ajaxACK:pacote},
			dataType: 'json',
			
			success: function(data){
				markup = markup.replace(/{titulo}/g, data.titulo).replace(/{texto}/g, data.texto);
				botao.append(markup).find('.janelaAjuda').fadeIn('slow');
			}
		});
	});
	// ---------- // fecha janela de ajuda depois de 15seg sem o mouse em cima // -----
	$('.janelaAjuda').bind('mouseleave', function(){
		janela = $(this);
		ajudaTimer = setTimeout(function() {
			janela.fadeOut('fast', function(){
				$(this).remove()
			})
		}, 700);
	}).bind('mouseenter', function(){ clearTimeout(ajudaTimer) });
	// ---------- // fecha janela de ajuda com click // -------------------------------
	$('.janelaAjuda').find('button').bind('click', function(){
		$(this).parents('.janelaAjuda').fadeOut('fast', function(){
			$(this).remove()
		})
	});*/
	$('.wrapper-ajuda').on('click', '.ajuda-head', function(){
		var clicado = $(this);

		if ( !clicado.next('.ajuda-body').is(':visible') ) {
			clicado.next('.ajuda-body').fadeIn(150);
		} else {
			clicado.next('.ajuda-body').fadeOut('fast');
		};
	});
	$('.wrapper-ajuda').on('click', '.icon.fechar', function(){
		$(this).parents('.ajuda-body').fadeOut('fast');
	});

	$('body').on('click', function(e){
		if ( $(e.target).parents('.wrapper-ajuda').length == 0 ) {
			$('.ajuda-body:visible').fadeOut('fast');
		};
	})
	
	
	/* ••••••••••••••••••••••••••••••••••••••••
	   | EVENTO
	   | Geral
	   | focus~blur personalizado para os campos de entrada de texto
	••••• */
	$('input[type="text"], input[type="tel"], input[type="email"], input[type="date"], textarea').bind({
		'focus': function(){
			$(this).parent('fieldset, .fieldset').addClass('fieldFocus');
		},
		'blur': function(){
			$(this).parent('fieldset, .fieldset').removeClass('fieldFocus');
		}
	});
	
	
	
	/* ••••••••••••••••••••••••••••••••••••••••
	   | EVENTO
	   | Geral
	   | Abre e fecha o blocos de formulario do ack
	••••• */
	$('body').on('click', '.btnAB', function() {
		var clicado = $(this),
			slide = clicado.next('.slide');

		if ( slide.is(':visible') ) {
			slide.slideDown('fast');
		} else {
			slide.slideUp('fast');
		};
	});

});
































































