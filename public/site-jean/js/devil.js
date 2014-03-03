//========================= variáveis globais =========================
var LAST_RELATED_FIELD_NAME = false;
var RELOAD_PAGE = false;
var DELETE_CONFIRMED = false;
//======================= END variáveis globais =======================


window.onmessage = function(e){
    var dataReceived = e.data;
    if(LAST_RELATED_FIELD_NAME) {

        select =  $('select[name="'+LAST_RELATED_FIELD_NAME+'"]');
        if($(select).val()) {

            var option = document.createElement("option");
            option.text = 'Nova relação';
            option.value = dataReceived;
            $(select).append(option);
            $(select).val(dataReceived);

            $(".actionButton").trigger('click');
        }
    }
    RELOAD_PAGE = true;
};

$(window).load(function()
{
    AckBootstrap();
});

function AckBootstrap()
{
    cache = new Object;
    serviceLocator = new AckServiceLocator;

    serviceLocator.get('AckTableRowForm');
    serviceLocator.get('AckTableRowList');

    $(".modalTrigger").colorbox({iframe:true,
                                innerWidth: 1100,
                                innerHeight: 500,
                                opacity: 0.5,
                                onOpen: function() {
                                    if($(this).attr('data-related-field-name')) {
                                        LAST_RELATED_FIELD_NAME = $(this).attr('data-related-field-name');
                                    }
                                },
                                onClosed: function() {
                                    if(RELOAD_PAGE) {
                                        RELOAD_PAGE = false;
                                        location.reload();
                                    }

                                }});
}

function Utils ()
{
    this.foreach = function (array, func)
    {
        for(var i = 0; i < array.length; i++) {
            func(array[i]);
        }
    }

    this.foreachObj = function (array, func)
    {
        for(var i = 0; i < array.length; i++) {
            func(array.next());
        }
    }
    /**
     * notifica um evento
     * @param  {[type]} evt [description]
     * @return {[type]}     [description]
     */
    this.notify = function (evt)
    {
        if(DEBUG) console.log(evt);
    }

    this.escapeRegExp = function (str) {
      return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
    }

    this.getInstanceFromStr = function (str)
    {
        return eval("new "+str);
    }


    this.isEmpty = function (obj) {

    // null and undefined are "empty"
    if (obj == null) return true;

    // Assume if it has a length property with a non-zero value
    // that that property is correct.
    if (obj.length > 0)    return false;
    if (obj.length === 0)  return true;

    // Otherwise, does it have any properties of its own?
    // Note that this doesn't handle
    // toString and valueOf enumeration bugs in IE < 9
    for (var key in obj) {
        if (hasOwnProperty.call(obj, key)) return false;
    }

    return true;
    }
}

function AckServiceLocator ()
{
    var cache = new Object;

    this.get = function (name) {

        if(this.getCache(name)) return this.getCache(name);

        utils = new Utils;
        instance = utils.getInstanceFromStr(name);

        factory = this.getFactoryConfig(name);
        if(factory && !instance.Factory) instance.Factory = factory;

        if(instance.Factory) instance.Factory();

        this.setCache(name,instance);

        if(!instance) alert('instância de'+name+' está vazia!');

        return instance;
    }

    this.getCache = function (key) {
        if(window.cache[key]) return window.cache[key];
        return false;
    }

    this.setCache = function (key,value) {
        window.cache[key] = value;
        return this;
    }

    this.getFactoryConfig = function (name) {

        config = {
                factories: {
                                AckTableRowList: function ()
                                {
                                    filters = new this.Filters();
                                    //filters.Factory();
                                    checks = new this.CheckItens();
                                    checks.Factory();
                                    loadMore = this.LoadItensInstance();
                                    loadMore.Factory(filters);
                                    loadMore.getElement().trigger('click');
                                }
                            }
            };

        if(eval('config.factories.'+name)) return eval('config.factories.'+name);
        return null;
    }

    /**
     * retorna uma nova instância do objeto chamado
     * @param  {[type]} name [description]
     * @return {[type]}      [description]
     */
    this.getInstance  = function (name) {

        utils = new Utils;
        instance = utils.getInstanceFromStr(name);
        return instance;
    }

    this.getServiceConfig = function ()
    {

    }
}

function AckDataMinner ()
{
    var elementTypes = 'input,select,textarea';

    this.findFromParent  = function (Parent) {

        var data = {};

        elements = Parent.find(elementTypes);

        elements.each(function() {
            
            //pula os radio buttons desmarcados 
            if ($(this).attr('type') == 'radio' && !$(this).is(':checked')) {
            
            } else {
                 data[$(this).attr("name")] = $(this).attr("value");

            }
        });

        return data;
    }



    this.findGroupsFromParent  = function (Parent) {

        var data = {};

        parentsCanditates = Parent.find('div');
        hasInnerParents = false;
        parentsCanditates.each(function(key,check) {
            if($(this).hasClass('rowContainer') && $(this).attr("name")) {

                dataKey = $(this).attr("name");

                data[dataKey] = {};

                elements = $(this).find(elementTypes);

                elements.each(function() {
                    if($(this).attr("name"))
                     data[dataKey][$(this).attr("name")] = $(this).attr("value");
                });
            }
        });

        return data;
    }

    this.findPageInfo = function () {
        return JSON.parse($('.pageInfo').first().attr('data-container'));
    }

    this.Factory = function () {}
}

/**
 * gerengia as telas que implementam
 * a estrutura padrão do ack
 */
function AckTableRowForm ()
{
    this.Factory = function () {

        //da setup dos botões de enviar
        $(".actionButton").click(function(){
           
            if (typeof tinyMCE != "undefined") {
                tinyMCE.triggerSave();
            }
            if($(this).attr('data-container')) {

                buttonParameters = JSON.parse($(this).attr('data-container'));
                pageInfo = serviceLocator.get('AckDataMinner').findPageInfo();

                ajax = serviceLocator.get('AckAjax');
                data = {};
                data.data = {};


                if(buttonParameters['dataMinnerMethod'] == 'sendParent') {


                    data.data = serviceLocator.get('AckDataMinner').findFromParent($('#rowContainer'));

                } else if (buttonParameters['dataMinnerMethod'] == 'sendGroupsFromParent') {

                    data.data = serviceLocator.get('AckDataMinner').findGroupsFromParent($('#rowContainer'));

                } else {
                    alert('sem método de mineração de dados!');
                    return;
                }



                data.parameters = pageInfo.parameters;



                    ajax.data = data;

                    //sobreescreve a função de sucesso default
                    //adicionando a gerência a modals que envia a
                    //mensagem para o pai caso o parameto noLayout
                    //for passado
                    ajax.success = function( response ) {
                            //desabilita a mensagem de sucesso pois aparecerá a do

                                    //se não tiver layout dispacha para o parent uma mensagem
                            if(response.parameters == 'noLayout') {
                                var curDomain = location.protocol + '//' + location.host; //This will be received as e.origin (see above)
                                var relatedId = response.id; //This will be received as e.data
                                parent.postMessage(relatedId,curDomain); //Sends message to parent frame
                            } else {
                                if(!response.disableSuccessNotifiction) alert(response.mensagem);
                            }

                            if(response.url) window.location = response.url;

                    };

                    //adiciona o id caso este já esteja setado
                    if(pageInfo.rowId) ajax.data.id = pageInfo.rowId;

                    //seta parêmetros adicionais
                    ajax.action = (buttonParameters.actionName) ? buttonParameters.actionName: pageInfo.actionName;
                    ajax.url = pageInfo.urlGateway;

                    result = ajax.send();
            }
        });
    }
}

/**
 * gerencia a tela de listagem de elementos
 * que implementam a estrutura padrão do ack
 */
function AckTableRowList ()
{
    var filters = null;
    var checks = null;
    var loadMore = null;

    this.Filters = function () {

        var action = 'loadItens';

        // this.Factory = function ()
        // {
        //     this.bindFilterButton();
        // }

        this.getData = function ()
        {
            data = serviceLocator.get('AckDataMinner').findFromParent(this.getFiltersContainer());
            return data;
        }

        this.bindFilterButton = function()
        {
            FilterButton = this.getFilterButton();
            Filters = this;

            $(FilterButton).click(function(){
                Filters.dispatch();
            });
        }

        this.getFilterButton = function ()
        {
            return $('#filterButoon');
        }

        this.getFiltersContainer = function ()
        {
            return $('.filtersContainer');
        }

        // this.dispatch = function ()
        // {
        //     data = new Object();
        //     data.filters = this.getData();
        //     data.action = action;

        //     pageInfo = serviceLocator.get('AckDataMinner').findPageInfo();
        //     ajax = serviceLocator.getInstance('AckAjax');
        //     ajax.data = data;
        //     ajax.url = pageInfo.urlGateway;
        //     ajax.send();
        // }
    }

    this.getCheckItensInstance = function()
    {
        return new this.CheckItens();
    }

    this.CheckItens = function ()
    {
        this.Factory = function ()
        {
           //this.bindLocalChecks();
        }

        this.getCurrentlySelectedItens = function ()
        {
            localElements = this.getLocalElements();

            result = {};
            $(localElements).each(function(key,check) {
                i = 0;
                if(!$(check).is(':checked')) {
                    localElements[key] = null;
                }
            });

            if(!$(localElements)) alert("Não há itens selecionados");
            return $(localElements);
        }

        this.bindLocalChecks = function ()
        {
            localChecks = this.getLocalElements();
            globalCheck =  this.getGlobalElement();

            globalCheck.click(function(){

                if(globalCheck.is(':checked')) {

                    localChecks.each(function(indx,check) {
                        $(check).attr('checked', 'checked');
                    });

                } else {
                    localChecks.each(function(indx,check) {
                        $(check).attr('checked', null);
                    });
                }
            });
        }

        this.getGlobalElement = function ()
        {
            return $('.globalCheck');
        }

        this.getLocalElements = function ()
        {
            return $('.localCheck');
        }
    }

    this.getRemoveItensInstance = function ()
    {
        return new this.RemoveItens();
    }

    this.RemoveItens = function ()
    {
        var checkItens;

        this.getAction = function ()
        {
            return 'delete';
        }

        this.Factory = function (checkItens)
        {
            this.checkItens = checkItens;
            return this;
        }

        this.bindMainButton = function ()
        {
            checkItens = this.checkItens;
            RemoveItens = this;

            this.getRmButton().click(function(){
                selectedItens = checkItens.getCurrentlySelectedItens();

                ids = new Array();
                if($(selectedItens))
                $(selectedItens).each(function(key,check) {
                    $(check).parent().parent().hide();
                    ids.push($(check).attr('id'));
                });

                RemoveItens.dispatch(ids);
            });
        }

        this.bindPersonalButtons = function ()
        {
            personalButtons = this.getPersonalButtons();
            RemoveItens = this;

            $(personalButtons).each(function(key,button){
                $(button).click(function(){


                    id = $(button).attr('name').split('_');
                    id = id[1];

                    result = RemoveItens.dispatch(new Array(id));


                    if (result)
                        $(button).parent().parent().hide();


                    return result;
                });
            });

        }

        this.dispatch = function (ids)
        {
            pageInfo = serviceLocator.get('AckDataMinner').findPageInfo();

            data = new Object();
            data.ids = ids;
            data.action = this.getAction();

            ajax = serviceLocator.getInstance('AckAjax');
            ajax.data = data;
            ajax.url = pageInfo.urlGateway;

            ajax.success = function( response ) {
                $("#cover").css("display", "block");
                DELETE_CONFIRMED = false;
                return true;
            }
            ajax.error = function(error) {
                return true;
            }

            if(DELETE_CONFIRMED || confirm("Deseja realmente excluir este item?")) {
                ajax.send();
                DELETE_CONFIRMED = true;
            } else {
                return false;
            }
            return true;
        }

        this.getPersonalButtons =  function ()
        {
            return $('.removeRow')
        }

        this.getRmButton = function()
        {
            return $('#removeRows');
        }
    }

    this.LoadItensInstance = function () {
        return new this.LoadItens;
    }

    this.LoadItens = function () {

        var action = "loadItens";
        var itensCount = 0;
        var filters;

        this.getItensCount = function()
        {
            itensCount = this.getItensContainer().children().length;

            return itensCount;
        }

        this.getTableHeaderContainer = function()
        {
            return $('.tableHeaderContainer');
        }

        this.getItensContainer = function ()
        {
           return $('.elementsContainer');
        }

        this.columnInTableHeader = function ( columnName )
        {
            result = false;
            headerContainer = this.getTableHeaderContainer();
            $(headerContainer).find('th').each(function(key,element){
               if($(element).attr('name') == columnName) {
                 result = true;
                 return result;
             }
            });
            return result;
        }

        this.columnPositionInTableHeader = function ( columnName )
        {
            headerContainer = this.getTableHeaderContainer();
            var iterator = 0;

            //console.log('procurando '+columnName);
            $(headerContainer).find('th').each( function(key, element) {

                //console.log('iteração: '+iterator+' valor: '+$(element).attr('name'));
                if($(element).attr('name') == columnName) {
                    //console.log('retornando: '+columnName+' posicao:'+iterator);
                    return false;
                }
                //se é diferente de null incrementa
                if($(element).attr('name')) {
                    iterator++;
                }
            });
            //console.log('resultado: '+iterator);
            return iterator;
        }

        this.getColumnWidth = function (columnName)
        {
            result = '100px';
            headerContainer = this.getTableHeaderContainer();
            $(headerContainer).find('td').each(function(key,element){
               if($(element).attr('name') == columnName) {
                 result =  $(element).css('width');
                 return result;
             }
            });
            return result;
        }

        this.getSpecialColumns = function ()
        {
            return new Array('url_linha','id');
        }

        this.isSpecialColumn = function (columnName) {

            specialColumns = this.getSpecialColumns();

            return ($.inArray(columnName,specialColumns) != -1);
        }

        this.getItemMarkup = function()
        {
            return  '<tr><td><input type="checkbox" class="localCheck" name="row" id="{id}"  /></td>{columns}</tr>';
        }

        this.getColumnMarkup = function ()
        {
            return '<td class="{class}" name="{columnName}">{value}</td>';
        }

        this.Factory = function (filters)
        {
            if(!(filters)) serviceLocator.get('AckNotifier').report('os filtros nao foram passados ao construtor do carregar mais');

            this.filters = filters;
            result = null;
            this.bindElement();
        }

        //da bind do elmeento de carregar lista
        //com seu evento e respectivo retorno
        this.bindElement = function ()
        {
            filters = this.filters;
            LoadItens = this;

            onClickFunction = function(event) {

                pageInfo = serviceLocator.get('AckDataMinner').findPageInfo();
                ajax = serviceLocator.get('AckAjax');
                ajax.data = new Object();
                ajax.data.action = action;
                ajax.data.itensCount = (!event.data.disableRemovePrevItens) ? 0 : LoadItens.getItensCount();
                ajax.data.filters = filters.getData();
                ajax.url = pageInfo.urlGateway;

                ackTableRowList =  new AckTableRowList;

                ajax.beforeSend = function(){
                    loadItens = ackTableRowList.LoadItensInstance();
                    if(!event.data.disableRemovePrevItens)
                    loadItens.getItensContainer().children().remove();
                },

                ajax.success = function (ajaxData) {

                    loadItens = ackTableRowList.LoadItensInstance();

                    serviceLocator.get('Utils').foreach(ajaxData.grupo,function(row) {

                        aColumns = new Array();
                        //prepara as colunas da linha
                        $.each(row,function(key,value) {
                            if(loadItens.columnInTableHeader(key)) {
                                width = loadItens.getColumnWidth(key);

                                position = loadItens.columnPositionInTableHeader(key);

                                //console.log(position);
                                if(position != -1) {
                                    aColumns[position] = (loadItens.getColumnMarkup().replace('{columnName}',key).replace('{value}',value).replace('{class}','').replace('{width}',width));
                                    //console.log( aColumns[position] );
                                }
                            }
                        });

                        //console.log(aColumns);

                        sColumns = '';
                        for (i = 0; i < aColumns.length; i++) {
                            sColumns+= aColumns[i];
                        }

                        //========================= colunas especiais =========================
                            sColumns+= (loadItens.getColumnMarkup().replace('{columnName}','view_row_link').replace('{value}','<a title="Ver" href="'+row.url_linha+'"><span class="glyphicon glyphicon-edit"><span></a> &#124; <a title="Remover" href="javascript:void(0);" class="removeRow" name="removeRow_'+row.id+'"><span class="glyphicon glyphicon-remove-circle"></span></a>').replace('{class}',''));
                        //======================= END colunas especiais =======================

                        //insere uma linha
                        loadItens.getItensContainer().append(loadItens.getItemMarkup().replace('{width}','10px').replace('{id}',row.id).replace('{columns}',sColumns));

                        CheckItens = ackTableRowList.getCheckItensInstance();
                        CheckItens.bindLocalChecks();
                        RemoveItens = ackTableRowList.getRemoveItensInstance().Factory(CheckItens);
                        RemoveItens.bindMainButton();
                        RemoveItens.bindPersonalButtons();

                    });
                };
                 ajax.send();
            };

            this.getElement().click({disableRemovePrevItens: true},onClickFunction);
            this.getFilterButton().click({disableRemovePrevItens: false},onClickFunction);
        }

        this.getElement = function ()
        {
            return $('.loadMoreItens');
        }

         this.getFilterButton = function ()
        {
            return $('#filterButoon');
        }


    }
}


function AckAjax ()
{
    var data;
    var url;
    var response;
    var action;
    var jsonParsing = true;
    /**
     * função de sucesso
     * @type {[type]}
     */
    var success = null;

    this.disableJsonParsing = function ()
    {
        this.jsonParsing = false;
        return this;
    }

    this.send = function () {

        JsonData = new Object();

        JsonData = this.data;

        if(!JsonData.action) JsonData.action = this.action;

        if(this.jsonParsing) JsonData =  JSON.stringify(JsonData);
        else JsonData =  JSON.stringify(JsonData);

        successFunction = (this.success) ? this.success : function( response ) {
                if(response.url) window.location = response.url;
                if(!response.disableSuccessNotifiction) alert(response.mensagem);
        };

        errorFunction = (this.error) ? this.error : function( response ) {
              alert('Algum erro ocorreu.');
        };

        beforeSendFunction = (this.beforeSend) ? this.beforeSend : function( response ) {};

        var settings = {
            type: 'POST',
            url: this.url,
            data: { ajaxACK : JsonData },
            dataType: 'json',
            success: successFunction,
            beforeSend: beforeSendFunction,
            error: errorFunction
        };
        $.ajax(settings);
    }

    this.Factory = function () {}
}

function AckApplication ()
{
    var debug = 1;

    this.getDebug = function ()
    {
        return this.debug;
    }

    this.Factory = function () {}
}

function AckNotifier ()
{
    this.report = function (something)
    {
        alert(something);
    }

    this.Factory = function () {}
}

function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}

